document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formProducto"); // 👈 tu formulario

    form.addEventListener("submit", (event) => {

        let valido = true;

        const nombre = document.getElementById("nombre");
        const valorNombre = nombre.value.trim();
        const errorNombre = document.getElementById("errorNombre");
        // Validación campo "Nombre del producto"
        campoVacioNombre = validarCampoVacio(valorNombre);
        campoTextoValido = validarCampoTexto(valorNombre);
        if (campoVacioNombre != "") {
            marcarError(nombre, errorNombre, campoVacioNombre);
            valido = false;
        } else if (campoTextoValido != "") {
            marcarError(nombre, errorNombre, campoTextoValido);
            valido = false;
        } else {
            marcarValido(nombre, errorNombre);
        }
        // Validación campo "Stock del producto"
        const stock = document.getElementById("stock");
        const valorStock = stock.value.trim();
        const errorStock = document.getElementById("errorStock");
        campoVacioStock = validarCampoVacio(valorStock);
        campoStockValido = validarCampoNumerico(valorStock);
        if (campoVacioStock != "") {
            marcarError(stock,errorStock,campoVacioStock);
            valido = false;
        } else if (campoStockValido != "") {
            marcarError(stock,errorStock,campoStockValido);
            valido = false;
        } else {
            marcarValido(stock,errorStock);
        }
        // Validación campo "Precio del producto"
        const precio = document.getElementById("precio");
        const valorPrecio = precio.value.trim();
        const errorPrecio = document.getElementById("errorPrecio");
        campoVacioPrecio = validarCampoVacio(valorPrecio);
        campoPrecioValido = validarCampoNumericoDecimal(valorPrecio);
        if (campoVacioPrecio != "") {
            marcarError(precio,errorPrecio,campoVacioPrecio);
            valido = false;
        } else if (campoPrecioValido != "") {
            marcarError(precio,errorPrecio,campoPrecioValido);
            valido = false;
        } else {
            marcarValido(precio,errorPrecio);
        }
        // Validacion campo "Detalle del producto"
        const detalle = document.getElementById("detalle");
        const valorDetalle = detalle.value.trim();
        const errorDetalle = document.getElementById("errorDetalle");
        campoVacioDetalle = validarCampoVacio(valorDetalle);
        campoDetalleValido = validarCampoTexto(valorDetalle);
        if (campoVacioDetalle != "") {
            marcarError(detalle,errorDetalle,campoVacioDetalle);
            valido = false;
        } else if (campoDetalleValido != "") {
            marcarError(detalle,errorDetalle,campoDetalleValido);
            valido = false;
        } else {
            marcarValido(detalle,errorDetalle);
        }
        // Validación campo "Imagen del producto"
        const imagen = document.getElementById("imagen");
        const archivo = imagen.value.trim();
        const errorImagen = document.getElementById("errorImagen");
        campoVacioImagen = validarCampoVacio(archivo);
        campoImagenValido = validarCampoImagen(archivo);
        if (campoVacioImagen != "") {
            marcarError(imagen,errorImagen,campoVacioImagen);
            valido = false;
        } else if (campoImagenValido != "") {
            marcarError(imagen,errorImagen,campoImagenValido);
            valido = false;
        } else {
            marcarValido(imagen,errorImagen);
        }

        // Si hay error → detener el envío
        if (!valido) {
            event.preventDefault();  // ❌ cancela el submit
        }
    });
});