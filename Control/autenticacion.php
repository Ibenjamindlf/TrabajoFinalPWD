<?php
// Control/auth.php
require_once __DIR__ . '/Session.php';

// Constantes de roles (evitan magic numbers)
require_once __DIR__ . '/roles.php';

/**
 * Devuelve true si hay sesión activa.
 * Soporta Session::validar() o Session::activa()
 */
function isLogged($session): bool {
    if (method_exists($session, 'validar')) {
        return (bool) $session->validar();
    }
    if (method_exists($session, 'activa')) {
        return (bool) $session->activa();
    }
    return false;
}

/**
 * Normaliza lo que devuelve getRoles() a un array de ints.
 * Si no hay roles devuelve ROLE_PUBLICO.
 */
function normalizeRoles($session): array {
    if (!method_exists($session, 'getRoles')) {
        return [ROLE_PUBLICO];
    }
    $raw = $session->getRoles();
    if ($raw === null || $raw === '' || $raw === []) {
        return [ROLE_PUBLICO];
    }
    if (!is_array($raw)) {
        return [(int)$raw];
    }
    return array_map('intval', $raw);
}

/**
 * Obliga a que haya login. Si no, redirige a login.
 */
function requireLogin($session, $redirect = '/TrabajoFinalPWD/Vista/login.php') {
    if (!isLogged($session)) {
        header("Location: $redirect");
        exit;
    }
}

/**
 * Obliga a que el usuario tenga un rol "al menos" (jerarquía).
 * Recordá: un rol numérico menor = mayor privilegio (1 = superAdmin).
 * Ej: requireAtLeastRole($s, ROLE_ADMIN) permite roles 1 y 2.
 *
 * $onFailRedirect: si se setea, redirige ahí; si es null, responde 403.
 */
function requireAtLeastRole($session, int $maxRole, $onFailRedirect = null) {
    // primero exige login
    requireLogin($session);

    $roles = normalizeRoles($session);
    $minRole = count($roles) ? min($roles) : ROLE_PUBLICO;

    // si el "mejor" rol (min) es mayor que $maxRole => no permitido
    if ($minRole > $maxRole) {
        if ($onFailRedirect) {
            header("Location: $onFailRedirect");
            exit;
        }
        http_response_code(403);
        // Podés cambiar por include('403.php') o una vista bonita
        echo '<h1>403 - Acceso denegado</h1><p>No tienes permisos para ver esta página.</p>';
        exit;
    }
}
