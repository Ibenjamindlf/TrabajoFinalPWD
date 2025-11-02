<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>    
    <link rel="shortcut icon" href="/TrabajoFinalPWD/Vista/sources/logo.png" type="image/x-icon">
    <title>Nosotros</title>
</head>
<body class="flex flex-col min-h-screen bg-gray-50">
<?php
    include_once ('../Vista/structure/header.php');
?>
<main class="flex-grow">
    <!-- Hero Section -->
    <section class="bg-gray-900 text-white py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Nuestra Historia</h1>
            <p class="max-w-2xl mx-auto text-gray-300">
                Nos dedicamos a estudiar y completar nuestra formación profesional, desarrollando páginas web de alta calidad. Nuestro equipo está compuesto por apasionados desarrolladores y el Mati.
            </p>
        </div>
    </section>

    <!-- Valores Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-semibold text-center mb-12">Nuestros Valores</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Calidad</h3>
                    <p class="text-gray-600">Trabajamos cuidadosamente para garantizar la mejor calidad.</p>
                </div>
                <div class="text-center p-6">
                    <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Rapidez</h3>
                    <p class="text-gray-600">Completamos todo en tiempo y eficiencia.</p>
                </div>
                <div class="text-center p-6">
                    <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Atención</h3>
                    <p class="text-gray-600">Soporte técnico no garantizado y atención al cliente personalizada.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-semibold text-center mb-12">Nuestro Equipo</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://avatars.githubusercontent.com/u/68124872?v=4" alt="Team Member" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-semibold text-lg">Mariano Infante</h3>
                        <p class="text-gray-600">Frontend Developer</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://avatars.githubusercontent.com/u/150484970?v=4" alt="Team Member" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-semibold text-lg">Facundo Ledesma</h3>
                        <p class="text-gray-600">Backend Developer</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://avatars.githubusercontent.com/u/206235917?v=4" alt="Team Member" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-semibold text-lg">Benjamin de la Fuente</h3>
                        <p class="text-gray-600">Backend Developer</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://avatars.githubusercontent.com/u/149085169?v=4" alt="Team Member" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-semibold text-lg">Matias Bacsay</h3>
                        <p class="text-gray-600">Database Management</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
    include_once ('../Vista/structure/footer.php');
?>
</body>
</html>