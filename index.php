<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>    
    <link rel="shortcut icon" href="/TrabajoFinalPWD/Vista/sources/Logo.png" type="image/x-icon">
    <title>Inicio | Vinilos truchos</title>
</head>
<body class="flex min-h-screen flex-col">
    <?php
        include_once ('Vista/structure/header.php');
    ?>
    <main>
        <div class="grow">
            <section class="bg-white py-20">
                <div class="container mx-auto px-6 text-center">
                    <h1 class="text-4xl font-bold mb-4">Bienvenido a Nuestra Tienda</h1>
                    <p class="text-lg text-gray-700 mb-8">Explora nuestra amplia gama de productos y encuentra lo que necesitas.</p>
                    <a href="/TrabajoFinalPWD/Vista/tienda.php" class="bg-blue-500 text-white px-6 py-3 rounded-full hover:bg-blue-600 transition duration-300">Ir a la Tienda</a>
                </div>
            </section>
            <section class="bg-gray-100 py-12">
                <div class="container mx-auto px-6 text-center">
                    <h2 class="text-3xl font-bold mb-4">Nuestros Servicios</h2>
                    <p class="text-lg text-gray-700">Ofrecemos una amplia gama de servicios para satisfacer tus necesidades.</p>
                </div>
            </section>
            <section class="bg-white py-20">
                <div class="container mx-auto px-6 text-center">
                    <h2 class="text-3xl font-bold mb-4">Nuestra Misión</h2>
                    <p class="text-lg text-gray-700">Nuestra misión es proporcionar productos de alta calidad y servicios excepcionales para satisfacer las necesidades de nuestros clientes.</p>
                </div>
            </section>
            <section class="bg-gray-100 py-12">
                <div class="container mx-auto px-4 md:px-6 text-center">
                    <h2 class="text-2xl md:text-3xl font-bold mb-4">Nuestro Equipo</h2>
                    <p class="text-base md:text-lg text-gray-700">Conoce a nuestro equipo de trabajo y sus habilidades.</p>
                    <div class="flex flex-col md:flex-row justify-center items-center gap-6 mt-8">
                        <div class="mb-8 md:mb-0">
                            <img class="w-24 h-24 md:w-32 md:h-32 rounded-full mx-auto" src="https://avatars.githubusercontent.com/u/68124872?v=4" alt="Miembro del equipo">
                            <h3 class="text-lg md:text-xl font-semibold mt-4">Mariano Infante</h3>
                            <p class="text-gray-600">Desarrollador Web</p>
                        </div>
                        <div class="mb-8 md:mb-0">
                            <img class="w-24 h-24 md:w-32 md:h-32 rounded-full mx-auto" src="https://avatars.githubusercontent.com/u/150484970?v=4" alt="Miembro del equipo">
                            <h3 class="text-lg md:text-xl font-semibold mt-4">Facundo Ledesma</h3>
                            <p class="text-gray-600">Desarrollador Web</p>
                        </div>
                        <div class="mb-8 md:mb-0">
                            <img class="w-24 h-24 md:w-32 md:h-32 rounded-full mx-auto" src="https://avatars.githubusercontent.com/u/206235917?v=4" alt="Miembro del equipo">
                            <h3 class="text-lg md:text-xl font-semibold mt-4">Benjamín de la Fuente</h3>
                            <p class="text-gray-600">Desarrollador Web</p>
                        </div>
                        <div class="mb-8 md:mb-0">
                            <img class="w-24 h-24 md:w-32 md:h-32 rounded-full mx-auto" src="https://avatars.githubusercontent.com/u/149085169?v=4" alt="Miembro del equipo">
                            <h3 class="text-lg md:text-xl font-semibold mt-4">Matias Bacsay</h3>
                            <p class="text-gray-600">Desarrollador Web</p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="bg-white py-20">
                <div class="container mx-auto px-6 text-center">
                    <h2 class="text-3xl font-bold mb-4">Contacto</h2>
                    <p class="text-lg text-gray-700">Si tenés alguna pregunta o necesitás ayuda, no nos contactes.</p>
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
        include_once ('Vista/structure/footer.php');
    ?>
</body>
</html>