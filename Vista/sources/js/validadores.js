/* Archivo validadores */
function marcarValido(input, spanError) {
    input.classList.remove("border-red-500");
    input.classList.add("border-green-500");
    spanError.classList.remove("text-red-500");
    spanError.classList.add("text-green-500");
    spanError.textContent = "Campo válido";
}
function marcarError(input, spanError, mensaje) {
    input.classList.remove("border-green-500");
    input.classList.add("border-red-500");
    spanError.classList.remove("text-green-500");
    spanError.classList.add("text-red-500");
    spanError.textContent = mensaje;
}
/* Archivo donde se van a encontrar todas las funciones para validar*/
function validarCampoVacio (input) {
    let esValido = "";
    if (input == ""){
        esValido = "Este campo no puede estar vacio.";
    }
    return esValido;
}
function validarCampoTexto (input) {
    let esValido = "";
    const regexTexto = /^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s\.\:\!\?\,\-\(\)]+$/;
    if (!regexTexto.test(input)){
        esValido = "Este campo solo admite letras, números y signos básicos como . , : ! ? - ( ).";
    }
    return esValido;
}
function validarCampoNumerico (input) {
    let esValido = "";
    // Validar campo numero (3 de longitud)
    const regexNumerico = /^\d{1,3}$/;
    if (!regexNumerico.test(input)){
        esValido = "Este campo admite unicamente numeros de 3 digitos.";
    }
    return esValido;
}
function validarCampoNumericoDecimal (input) {
    let esValido = "";
    // Validar campo numero (3 de longitud)
    const regexNumericoDecimal = /^\d+([.,]\d{1,2})?$/;
    if (!regexNumericoDecimal.test(input)){
        esValido = "Este campo admite unicamente precios con el formato ('150.99').";
    }
    return esValido;
}
function validarCampoImagen (input) {
    let esValido = "";
    // Validar campo imagen .jpg,.jpeg,.png
    const regexImagen = /\.(jpg|jpeg|png)$/i;
    if (!regexImagen.test(input)) {
        esValido = "Formato inválido. Solo se permiten imágenes JPG, JPEG o PNG.";
    }
    return esValido;
}
function validarCampoNombre(input) {
    let esValido = "";
    // Solo letras (con acentos), ñ y espacios
    const regexNombre = /^[A-Za-zÁÉÍÓÚáéíóúÑñ]+(\s+[A-Za-zÁÉÍÓÚáéíóúÑñ]+)*$/;
    if (!regexNombre.test(input.trim())) {
        esValido = "Ingresá un nombre válido (solo letras y espacios).";
    }
    return esValido;
}
function validarCampoEmail(input) {
    let esValido = "";
    // Regex simple y seguro para email
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!regexEmail.test(input.trim())) {
        esValido = "Ingresá un email válido (ejemplo: usuario@correo.com).";
    }

    return esValido;
}
function validarPassword(input) {
    let esValido = "";
    // Mínimo 8 caracteres
    const regexPassword = /^.{8,}$/;

    if (!regexPassword.test(input.trim())) {
        esValido = "La contraseña debe tener al menos 8 caracteres.";
    }

    return esValido;
}
function validarConfirmacionPassword(pass, confirmPass) {
    let esValido = "";

    if (pass.trim() !== confirmPass.trim()) {
        esValido = "Las contraseñas no coinciden.";
    }

    return esValido;
}


