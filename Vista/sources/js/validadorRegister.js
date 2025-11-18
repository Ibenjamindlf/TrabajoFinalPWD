document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("registerForm"); // 👈 tu formulario

    form.addEventListener("submit", (event) => {

        let valido = true;

        const nombre = document.getElementById("name");
        const valorNombre = nombre.value.trim();
        const errorNombre = document.getElementById("nameError");
        // Validación campo "Nombre del usuario"
        campoVacioNombre = validarCampoVacio(valorNombre);
        campoTextoValido = validarCampoNombre(valorNombre);
        if (campoVacioNombre != "") {
            marcarError(nombre, errorNombre, campoVacioNombre);
            valido = false;
        } else if (campoTextoValido != "") {
            marcarError(nombre, errorNombre, campoTextoValido);
            valido = false;
        } else {
            marcarValido(nombre, errorNombre);
        }
        // Validación campo "Email"
        const email = document.getElementById("email");
        const valorEmail = email.value.trim();
        const errorEmail = document.getElementById("emailError");
        campoVacioEmail = validarCampoVacio(valorEmail);
        campoEmailValido = validarCampoEmail(valorEmail);
        if (campoVacioEmail != "") {
            marcarError(email,errorEmail,campoVacioEmail);
            valido = false;
        } else if (campoEmailValido != "") {
            marcarError(email,errorEmail,campoEmailValido);
            valido = false;
        } else {
            marcarValido(email,errorEmail);
        }
        // Validación campo "Contrasenia"
        const contrasenia = document.getElementById("password");
        const valorContrasenia = contrasenia.value.trim();
        const errorContrasenia = document.getElementById("pwdError");
        campoVacioContrasenia = validarCampoVacio(valorContrasenia);
        campoContraseniaValido = validarPassword(valorContrasenia);
        if (campoVacioContrasenia != "") {
            marcarError(contrasenia,errorContrasenia,campoVacioContrasenia);
            valido = false;
        } else if (campoContraseniaValido != "") {
            marcarError(contrasenia,errorContrasenia,campoContraseniaValido);
            valido = false;
        } else {
            marcarValido(contrasenia,errorContrasenia);
        }
        // Validacion campo "Confirmar contrasenia"
        const confirContrasenia = document.getElementById("confirmPassword");
        const valorConfirmContrasenia = confirContrasenia.value.trim();
        const errorConfirContrasenia = document.getElementById("confirmError");
        campoVacioConfirmContrasenia = validarCampoVacio(valorConfirmContrasenia);
        campoConfirContraseniaValido = validarConfirmacionPassword(valorContrasenia,valorConfirmContrasenia);
        if (campoVacioConfirmContrasenia != "") {
            marcarError(confirContrasenia,errorConfirContrasenia,campoVacioConfirmContrasenia);
            valido = false;
        } else if (campoConfirContraseniaValido != "") {
            marcarError(confirContrasenia,errorConfirContrasenia,campoConfirContraseniaValido);
            valido = false;
        } else {
            marcarValido(confirContrasenia,errorConfirContrasenia);
        }

        // Si hay error → detener el envío
        if (!valido) {
            event.preventDefault();  // ❌ cancela el submit
        }
    });
});