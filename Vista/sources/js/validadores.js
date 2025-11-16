/* Archivo validadores */
function marcarValido(input, spanError) {
    input.classList.remove("border-red-500");
    input.classList.add("border-green-500");
    spanError.classList.remove("text-red-600");
    spanError.classList.add("text-green-600");
    spanError.textContent = "Campo válido";
}
function marcarError(input, spanError, mensaje) {
    input.classList.remove("border-green-500");
    input.classList.add("border-red-500");
    spanError.classList.remove("text-green-600");
    spanError.classList.add("text-red-600");
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
    const regexTexto = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
    if (!regexTexto.test(input)){
        esValido = "Este campo admite unicamente letras y espacios.";
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