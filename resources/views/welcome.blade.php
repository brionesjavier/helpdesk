<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Requerimientos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Puedes agregar tus estilos personalizados aquí si es necesario */
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white dark:bg-gray-800 shadow-md py-4">
        <div class="container mx-auto flex justify-between items-center px-6">
            <a href="#" class="text-lg font-semibold">Sistema de Requerimientos</a>
            <div class="flex space-x-4">
                @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class="rounded-md px-3 py-2 text-black dark:text-white ring-1 ring-transparent transition hover:text-black/70 dark:hover:text-gray-300 focus:outline-none focus-visible:ring-[#FF2D20] dark:focus-visible:ring-white"
                    >
                        Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="rounded-md px-3 py-2 text-black dark:text-white ring-1 ring-transparent transition hover:text-black/70 dark:hover:text-gray-300 focus:outline-none focus-visible:ring-[#FF2D20] dark:focus-visible:ring-white"
                    >
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="rounded-md px-3 py-2 text-black dark:text-white ring-1 ring-transparent transition hover:text-black/70 dark:hover:text-gray-300 focus:outline-none focus-visible:ring-[#FF2D20] dark:focus-visible:ring-white"
                        >
                            Register
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center">
        <div class="container mx-auto flex flex-col lg:flex-row items-center justify-center space-y-8 lg:space-y-0 lg:space-x-8 px-6 py-12">
            
            <!-- Message Section -->
            <div class="w-full lg:w-1/2 text-center lg:text-left">
                <h1 class="text-3xl font-bold mb-4">Bienvenido al Sistema de Requerimientos</h1>
                <p>Administre y controle los requerimientos de su equipo de manera eficiente y organizada.</p>
            </div>

            <!-- Image Section -->
            <div class="w-full lg:w-1/2 flex items-center justify-center">
                <div class="relative">
                    <img id="displayedImage" src="{{url('/images/personas-trabajando.jpg')}}" alt="Imagen de ejemplo" class="rounded shadow-lg w-72 h-96 object-cover">
                    
                    <!-- Buttons to change image -->
                    <div class="absolute inset-x-0 top-1/2 transform -translate-y-1/2 flex justify-between">
                        <button onclick="prevImage()" class="bg-gray-700 dark:bg-gray-600 text-white px-4 py-2 rounded-l hover:bg-gray-900 dark:hover:bg-gray-500">Anterior</button>
                        <button onclick="nextImage()" class="bg-gray-700 dark:bg-gray-600 text-white px-4 py-2 rounded-r hover:bg-gray-900 dark:hover:bg-gray-500">Siguiente</button>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 shadow-md py-4 text-center">
        <p>&copy; 2024 Sistema de Requerimientos. Todos los derechos reservados.</p>
    </footer>

    <!-- JavaScript to handle image changing -->
    <script>
        const images = [
            "{{url('/images/personas-trabajando.jpg')}}",
            
        ];
        let currentIndex = 0;

        function updateImage() {
            const img = document.getElementById("displayedImage");
            img.src = images[currentIndex];
        }

        function prevImage() {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            updateImage();
        }

        function nextImage() {
            currentIndex = (currentIndex + 1) % images.length;
            updateImage();
        }
    </script>

</body>
</html>
