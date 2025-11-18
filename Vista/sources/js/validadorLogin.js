document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("loginForm"); // 👈 tu formulario

    form.addEventListener("submit", (event) => {

        let valido = true;
        
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

        // Si hay error → detener el envío
        if (!valido) {
            event.preventDefault();  // ❌ cancela el submit
        }
    });
});