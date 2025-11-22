document.addEventListener('DOMContentLoaded', () => {
    // 1. Verificar si hay que mostrar el modal de éxito
    // Buscamos un elemento oculto que PHP pondrá si la compra fue exitosa
    const flagExito = document.getElementById('flag-compra-exitosa');
    if (flagExito) {
        const modal = document.getElementById('modalExito');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }
});

// 2. Función para cerrar el modal
function cerrarModal() {
    const modal = document.getElementById('modalExito');
    if (!modal) return;
    
    modal.classList.add('opacity-0'); // Animación salida
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex', 'opacity-0');
    }, 300);
}

// 3. Agregar al Carrito con AJAX
function agregarConAjax(idProducto) {
    // Ajusta la ruta relativa según desde dónde se carga el script
    // Como este JS se carga en 'Vista/tienda.php', la ruta relativa a 'accion' es correcta
    const url = 'accion/Carrito/accionAgregarAlCarrito.php?idProducto=' + idProducto + '&ajax=true';

    fetch(url)
        .then(response => {
            if (response.redirected) {
                window.location.href = response.url;
                return;
            }
            return response.json();
        }) 
        .then(data => {
            if (!data) return;

            if (data.status === 'success') {
                mostrarToast("¡Producto agregado al carrito!", "success");
            } else {
                mostrarToast(data.msg || "Error al agregar", "error");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarToast("Error de conexión. Intenta loguearte.", "error");
        });
}

// 4. Mostrar Toast (Notificación)
function mostrarToast(mensaje, tipo) {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    
    let colorClase = tipo === 'success' ? 'bg-green-600' : 'bg-red-600';
    let icono = tipo === 'success' 
        ? '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>'
        : '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';

    toast.className = `${colorClase} px-6 py-3 rounded-lg shadow-lg text-white transform transition-all duration-500 translate-x-full opacity-0 flex items-center font-medium mb-2`;
    toast.innerHTML = icono + mensaje;

    container.appendChild(toast);

    requestAnimationFrame(() => {
        toast.classList.remove("translate-x-full", "opacity-0");
    });

    setTimeout(() => {
        toast.classList.add("opacity-0", "translate-x-full");
        setTimeout(() => toast.remove(), 500);
    }, 3000);
}