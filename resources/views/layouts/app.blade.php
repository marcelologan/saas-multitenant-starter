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
    @vite(['resources/css/app.css', 'resources/css/themes/themes.css', 'resources/js/app.js', 'resources/js/themes/theme-switcher.js'])
</head>

<body class="font-sans antialiased bg-bg">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-light shadow border-b border-font/10">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="bg-bg min-h-screen">
            {{ $slot }}
        </main>
    </div>

    <!-- Theme Switcher Modal -->
    <div id="theme-modal" class="fixed inset-0 bg-dark/50 hidden z-50" onclick="closeThemeModal()">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-light rounded-lg p-6 max-w-md w-full" onclick="event.stopPropagation()">
                <h3 class="text-lg font-semibold text-font mb-4">Escolher Tema</h3>
                <div class="space-y-3">
                    <button onclick="switchTheme('textil')"
                        class="w-full text-left p-3 rounded-md border border-font/20 hover:bg-bg transition-colors">
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 rounded-full bg-primary"></div>
                            <span class="font-medium text-font">Têxtil (Padrão)</span>
                        </div>
                    </button>
                    <!-- Adicione outros temas aqui quando necessário -->
                </div>
                <button onclick="closeThemeModal()"
                    class="mt-4 w-full bg-secondary text-light py-2 px-4 rounded-lg hover:bg-secondary-hover transition-colors">
                    Fechar
                </button>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
            class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 bg-success text-light px-8 py-4 rounded-lg shadow-xl border-l-4 border-success-hover min-w-96">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
            class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 bg-danger text-light px-8 py-4 rounded-lg shadow-xl border-l-4 border-danger-hover min-w-96">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    @if (session('warning'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
            class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 bg-warning text-light px-8 py-4 rounded-lg shadow-xl border-l-4 border-warning-hover min-w-96">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z">
                    </path>
                </svg>
                <span class="font-medium">{{ session('warning') }}</span>
            </div>
        </div>
    @endif

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
