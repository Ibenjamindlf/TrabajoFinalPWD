<?php
    session_start();
    include_once ('../structure/header.php');
    $token = $_GET['token'] ?? '';
    if(empty($token)) { header('Location: /TrabajoFinalPWD/Vista/login.php'); exit; }
?>
<main class="flex-grow flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h1 class="text-2xl font-semibold text-gray-800 text-center mb-4">Nueva Contraseña</h1>
            
            <?php if (isset($_SESSION['errores_abm'])): ?>
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    <?php echo $_SESSION['errores_abm']; unset($_SESSION['errores_abm']); ?>
                </div>
            <?php endif; ?>

            <form action="../../Vista/accion/Pass/accionGuardarPass.php" method="post" class="space-y-4">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nueva Contraseña</label>
                    <input type="password" name="password" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                    <input type="password" name="confirm_password" required class="w-full px-4 py-2 border rounded-lg">
                </div>

                <button type="submit" class="w-full bg-orange-600 text-white py-2 rounded-lg hover:bg-orange-700">
                    Guardar Contraseña
                </button>
            </form>
        </div>
    </div>
</main>
<?php include_once ('../structure/footer.php'); ?>