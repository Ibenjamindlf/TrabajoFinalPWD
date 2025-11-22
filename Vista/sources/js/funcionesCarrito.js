// Envía la petición a la API para sumar, restar o quitar
function actualizarCarrito(idItem, accion) {
    fetch('API/carrito.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: idItem, accion: accion })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.eliminado) {
                const fila = document.getElementById('fila-' + idItem);
                if (fila) fila.remove();
                
                if (document.getElementById('lista-productos').children.length === 0) {
                    location.reload();
                }
            } else {
                const cantEl = document.getElementById('cantidad-' + idItem);
                const subEl = document.getElementById('subtotal-' + idItem);
                
                if(cantEl) cantEl.innerText = data.cantidad;
                if(subEl) subEl.innerText = data.subtotal;
            }
            recalcularTotal();
        } else {
            alert(data.msg || "Error al actualizar");
        }
    })
    .catch(err => console.error('Error:', err));
}

// Recalcula el total visualmente sumando los subtotales de la pantalla
// (Esto es solo visual, el total real lo calcula el backend al pagar)

function recalcularTotal() {
    let total = 0;

    document.querySelectorAll('[id^="cantidad-"]').forEach(el => {
        const id = el.id.split('-')[1];
        
        const cantidad = parseInt(el.innerText);
        const precioInput = document.getElementById('precio-unitario-' + id);
        
        if (precioInput) {
            const precio = parseFloat(precioInput.value);
            total += cantidad * precio;
        }
    });
    

    const totalFormateado = total.toLocaleString('es-AR', {
        minimumFractionDigits: 2, 
        maximumFractionDigits: 2
    });

    const totalEl = document.getElementById('total-compra');
    if(totalEl) totalEl.innerText = totalFormateado;
}