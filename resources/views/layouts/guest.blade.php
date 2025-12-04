<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&display=swap" rel="stylesheet" />

    <!-- Theme CSS Variables -->
    <style>
    {!! $themeCss ?? \App\Helpers\ThemeHelper::generateCssVariables() !!}
    </style>

    <!-- Scripts -->
    @vite([
        'resources/css/app.css', 
        'resources/css/themes/themes.css',
        'resources/css/auth/auth.css',
        'resources/js/app.js', 
        'resources/js/themes/theme-switcher.js'
    ])
</head>
<body class="font-sans antialiased">
    <!-- Theme Selector (floating) -->
    <div class="fixed top-4 right-4 z-50">
        <button onclick="openThemeModal()" class="bg-white border border-light rounded-full p-2 shadow-lg hover:shadow-xl transition-all">
            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v6a2 2 0 002 2h4a2 2 0 002-2V5zM21 15a2 2 0 00-2-2h-4a2 2 0 00-2 2v2a2 2 0 002 2h4a2 2 0 002-2v-2z"></path>
            </svg>
        </button>
    </div>

    {{ $slot }}

    <!-- Theme Switcher Modal -->
    <div id="theme-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50" onclick="closeThemeModal()">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg p-6 max-w-md w-full" onclick="event.stopPropagation()">
                <h3 class="text-lg font-semibold text-dark mb-4">Escolher Tema</h3>
                <div class="space-y-3">
                    <button onclick="switchTheme('flat-ui')" class="w-full text-left p-3 rounded-md border border-light hover:bg-light transition-colors">
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 rounded-full" style="background: #9b59b6;"></div>
                            <span class="font-medium">Flat UI</span>
                        </div>
                    </button>
                    <button onclick="switchTheme('russian')" class="w-full text-left p-3 rounded-md border border-light hover:bg-light transition-colors">
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 rounded-full" style="background: #e77f67;"></div>
                            <span class="font-medium">Russian</span>
                        </div>
                    </button>
                    <button onclick="switchTheme('german')" class="w-full text-left p-3 rounded-md border border-light hover:bg-light transition-colors">
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 rounded-full" style="background: #45aaf2;"></div>
                            <span class="font-medium">German</span>
                        </div>
                    </button>
                </div>
                <button onclick="closeThemeModal()" class="mt-4 w-full btn btn-secondary">
                    Fechar
                </button>
            </div>
        </div>
    </div>

    <script>
        function openThemeModal() {
            document.getElementById('theme-modal').classList.remove('hidden');
        }

        function closeThemeModal() {
            document.getElementById('theme-modal').classList.add('hidden');
        }

        function switchTheme(theme) {
            if (window.themeSwitcher) {
                window.themeSwitcher.switchTheme(theme);
            }
            closeThemeModal();
        }
    </script>
</body>
</html>