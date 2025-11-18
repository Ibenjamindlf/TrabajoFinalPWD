<?php
include_once("../Control/ABMProducto.php");
$abmProducto = new ABMProducto();
$arrayProductos = $abmProducto->buscar(NULL);
if ($arrayProductos != null) {
    $cantProductos = count($arrayProductos);
} else {
    $cantProductos = 0;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>    
    <link rel="shortcut icon" href="/TrabajoFinalPWD/Vista/sources/Logo.png" type="image/x-icon">
    <title>Inicio | Vinilos Truchos</title>
</head>
<body class="flex min-h-screen flex-col bg-gray-50">
    <?php
        include_once ('../Vista/structure/header.php');
    ?>

    <main>
        <div class="grow">

            <section class="relative h-[60vh] min-h-[400px] flex items-center justify-center text-center text-white px-4 overflow-hidden">
                
                <div class="absolute inset-0 -z-10">
                    <video autoplay muted loop playsinline class="w-full h-full object-cover" src="/TrabajoFinalPWD/Vista/sources/video/viniloIndex.mp4">
                </div>                
                <div class="relative z-10">
                    <h1 class="text-4xl md:text-6xl font-bold tracking-tight mb-4">Vinilos Truchos</h1>
                    <p class="text-lg md:text-xl max-w-2xl mx-auto mb-8">
                        Encontrá las joyas truchas del rock, los clásicos del jazz y las últimas novedades en formato vinilo rayado!
                    </p>
                    <a href="/TrabajoFinalPWD/Vista/tienda.php" class="bg-orange-600 text-white px-8 py-3 rounded-lg text-lg font-semibold shadow-lg hover:bg-orange-700 transition duration-300">
                        Mirá nuestros productos
                    </a>
                </div>
            </section>

            <section class="py-16 bg-white">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Novedades y Destacados</h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        
                        <?php if ($cantProductos > 0): ?>
                            
                            <?php $i = 0; ?>

                            <?php foreach ($arrayProductos as $unProducto) { ?>
                                
                                <div class="bg-white rounded-lg overflow-hidden h-full shadow-sm border-0 flex flex-col transition duration-300 hover:scale-105">
                                    
                                    <img src="/TrabajoFinalPWD/<?php echo $unProducto->getImagen(); ?>" 
                                        alt="<?php echo $unProducto->getNombre(); ?>" 
                                        class="w-full h-[220px] object-cover">
                                    
                                    <div class="p-4 flex flex-col justify-between flex-grow">
                                        <div>
                                            <h5 class="text-xl font-semibold text-gray-900 mb-2 truncate">
                                                <?php echo $unProducto->getNombre(); ?>
                                            </h5>
                                            <p class="text-sm text-gray-500 truncate">
                                                <?php echo $unProducto->getDetalle(); ?>
                                            </p>
                                        </div>
                                        <div class="mt-4 text-sm text-gray-700">
                                            <?php echo number_format($unProducto->getStock(), 0) ?> unidades disponibles
                                        </div>
                                        <div class="mt-4">
                                            <p class="font-bold text-orange-600 mb-2">
                                                $<?php echo number_format($unProducto->getPrecio(), 2, ',', '.'); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                $i++;
                                if ($i >= 4) {
                                    break; 
                                }
                                ?>
                            <?php }?>

                        <?php elseif ($cantProductos <= 0): ?>
                            <div class="flex justify-center items-center text-center col-span-1 sm:col-span-2 md:col-span-3 lg:col-span-4 mt-12 mb-12">
                                <p class="text-lg text-gray-500">No hay productos destacados disponibles en este momento.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="text-center mt-12">
                        <a href="/TrabajoFinalPWD/Vista/tienda.php" class="px-6 py-3 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition">
                            Ver Toda la Tienda
                        </a>
                    </div>

                </div>
            </section>

            <section class="py-16 bg-gray-900 text-white">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-bold text-center mb-12">Explorá por Género</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        
                        <a href="#" class="block relative rounded-lg overflow-hidden h-40 group">
                            <img src="https://images.unsplash.com/photo-1592051148519-4eef666e6418?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Rock" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                <h3 class="font-bold text-2xl">ROCK</h3>
                            </div>
                        </a>

                        <a href="#" class="block relative rounded-lg overflow-hidden h-40 group">
                            <img src="https://images.unsplash.com/photo-1573761449626-1b80629dafc3?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Pop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                <h3 class="font-bold text-2xl">POP</h3>
                            </div>
                        </a>

                        <a href="#" class="block relative rounded-lg overflow-hidden h-40 group">
                            <img src="https://images.unsplash.com/photo-1614573879558-60766894170d?q=80&w=1074&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Hip-Hop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                <h3 class="font-bold text-2xl">HIP-HOP</h3>
                            </div>
                        </a>

                        <a href="#" class="block relative rounded-lg overflow-hidden h-40 group">
                            <img src="https://images.unsplash.com/photo-1670983480059-6dc099a47a9e?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Jazz" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                <h3 class="font-bold text-2xl">JAZZ</h3>
                            </div>
                        </a>

                    </div>
                </div>
            </section>

            <section class="bg-gray-100 py-12">
                <div class="container mx-auto px-4 md:px-6 text-center">
                    <h2 class="text-2xl md:text-3xl font-bold mb-4">Nuestro Equipo</h2>
                    <p class="text-base md:text-lg text-gray-700 max-w-2xl mx-auto mb-12">
                        Apasionados por la música, pero dedicados a traerte los peores vinilos.
                    </p>
                    <div class="flex flex-col md:flex-row justify-center items-center gap-6 mt-8">
                        
                        <div class="mb-8 md:mb-0">
                            <img class="w-24 h-24 md:w-32 md:h-32 rounded-full mx-auto" src="https://avatars.githubusercontent.com/u/68124872?v=4" alt="Mariano Infante">
                            <h3 class="text-lg md:text-xl font-semibold mt-4">Mariano Infante</h3>
                            <p class="text-gray-600">Desarrollador Web</p>
                        </div>
                        
                        <div class="mb-8 md:mb-0">
                            <img class="w-24 h-24 md:w-32 md:h-32 rounded-full mx-auto" src="https://avatars.githubusercontent.com/u/150484970?v=4" alt="Facundo Ledesma">
                            <h3 class="text-lg md:text-xl font-semibold mt-4">Facundo Ledesma</h3>
                            <p class="text-gray-600">Desarrollador Web</p>
                        </div>
                        
                        <div class="mb-8 md:mb-0">
                            <img class="w-24 h-24 md:w-32 md:h-32 rounded-full mx-auto" src="https://avatars.githubusercontent.com/u/206235917?v=4" alt="Benjamín de la Fuente">
                            <h3 class="text-lg md:text-xl font-semibold mt-4">Benjamín de la Fuente</h3>
                            <p class="text-gray-600">Desarrollador Web</p>
                        </div>
                        
                        <div class="mb-8 md:mb-0">
                            <img class="w-24 h-24 md:w-32 md:h-32 rounded-full mx-auto" src="https://avatars.githubusercontent.com/u/149085169?v=4" alt="Matias Bacsay">
                            <h3 class="text-lg md:text-xl font-semibold mt-4">Matias Bacsay</h3>
                            <p class="text-gray-600">Desarrollador Web</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-gray-100 py-12 flex justify-center">
                <div class="relative inline-flex items-center justify-center group">
                    <div class="absolute inset-0 duration-300 bg-gradient-to-r from-indigo-500 via-pink-500 to-yellow-400 rounded-xl blur-lg filter group-hover:scale-110"></div>
                    <a
                        href="https://github.com/Ibenjamindlf/TrabajoFinalPWD"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="relative inline-flex items-center justify-center text-base rounded-xl bg-gray-900 px-8 py-3 font-semibold text-white transition-all duration-300 hover:bg-gray-800 hover:shadow-lg hover:scale-105 hover:shadow-gray-600/30"
                        title="Visita nuestro repositorio"
                    >
                        <span>Visita nuestro repositorio</span>
                        <svg
                            class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                stroke-width="2" 
                                d="M13 7l5 5m0 0l-5 5m5-5H6"
                            />
                        </svg>
                    </a>
                </div>
            </section>
            
        </div>
    </main>

    <?php
        include_once ('../Vista/structure/footer.php');
    ?>
</body>
</html>