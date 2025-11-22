<div id="modalExito" 
     class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity duration-300">
    
    <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full mx-4 relative animate-bounce-in">
        <button onclick="cerrarModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6">
                <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <h2 class="text-2xl font-bold text-gray-900 mb-2">¡Gracias por su compra!</h2>
            <p class="text-gray-600 mb-6">
                Su compra ha sido finalizada correctamente. Hemos enviado el detalle a su correo electrónico.
            </p>

            <button onclick="cerrarModal()" 
                    class="w-full py-3 px-4 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-lg shadow-md transition transform hover:scale-105">
                Seguir Comprando
            </button>
        </div>
    </div>
</div>