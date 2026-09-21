<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Location de Prestige' }} | {{ config('app.name', 'Laravel') }}</title>
    <!-- 1. Importation des polices Google Fonts (Ajouté ici) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">


    <!-- Fonts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js pour les interactions légères (ex: menu mobile) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans text-gray-800 bg-primary-50 antialiased">

    <!-- Header Simplifié -->
    <header class="fixed w-full bg-white/90 backdrop-blur-md shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo / Nom -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="font-serif text-2xl font-bold text-primary-900 tracking-tight">
                        VotreRésidence
                    </a>
                </div>
                
                <!-- Navigation (À enrichir plus tard) -->
                <nav class="hidden md:flex space-x-8">
                    <a href="/" class="text-gray-600 hover:text-primary-700 font-medium transition-colors">Accueil</a>
                    <a href="#about" class="text-gray-600 hover:text-primary-700 font-medium transition-colors">La Propriété</a>
                    <a href="#contact" class="text-gray-600 hover:text-primary-700 font-medium transition-colors">Contact</a>
                </nav>

                <!-- CTA Header -->
                <div class="hidden md:flex">
                    <a href="#booking" class="bg-primary-700 hover:bg-primary-900 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-soft">
                        Réserver
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenu Principal -->
    <main class="pt-20">
        {{ $slot }}
    </main>

    <!-- Footer Minimaliste -->
    <footer class="bg-primary-900 text-primary-100 py-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="font-serif text-lg mb-2">VotreRésidence</p>
            <p class="text-sm opacity-70">&copy; {{ date('Y') }} Tous droits réservés.</p>
        </div>
    </footer>

</body>
</html>