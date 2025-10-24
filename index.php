<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="/TrabajoFinalPWD/Vista/sources/logo.png" type="image/x-icon">
    <title>Inicio</title>
</head>
<body class="d-flex flex-col min-vh-screen">
    <?php
        include_once ('Vista/structure/header.php');
    ?>
    <main>
        <div class="flex-grow">
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
                            <p class="text-gray-600">Tirador de goma</p>
                        </div>
                        <div class="mb-8 md:mb-0">
                            <img class="w-24 h-24 md:w-32 md:h-32 rounded-full mx-auto" src="https://avatars.githubusercontent.com/u/206235917?v=4" alt="Miembro del equipo">
                            <h3 class="text-lg md:text-xl font-semibold mt-4">Benjamín de la Fuente</h3>
                            <p class="text-gray-600">Desarrollador Web</p>
                        </div>
                        <div class="mb-8 md:mb-0">
                            <img class="w-24 h-24 md:w-32 md:h-32 rounded-full mx-auto" src="https://avatars.githubusercontent.com/u/149085169?v=4" alt="Miembro del equipo">
                            <h3 class="text-lg md:text-xl font-semibold mt-4">Matias Bacsay</h3>
                            <p class="text-gray-600">"Lucas v2"</p>
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
        </div>
    </main>
    <?php
        include_once ('Vista/structure/footer.php');
    ?>
</body>
</html>