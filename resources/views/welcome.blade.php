<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app_branding.meta.title') }}</title>
    <meta name="description" content="{{ config('app_branding.meta.description') }}">
    <meta name="keywords" content="{{ config('app_branding.meta.keywords') }}">
    <meta name="author" content="{{ config('app_branding.meta.author') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="antialiased bg-bg text-font">
    <!-- Navbar Profissional -->
    <nav class="navbar-glass fixed w-full top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Navbar - Logo -->
                <div class="flex items-center space-x-3">
                    <img src="{{ asset(config('app_branding.logos.icon')) }}"
                        alt="{{ config('app_branding.logos.alt') }}"
                        class="{{ config('app_branding.logos.sizes.navbar_full') }}">
                    <div>
                        <h1 class="text-xl font-bold text-font">{{ config('app_branding.app.name') }}</h1>
                        <p class="text-xs text-font/70">{{ config('app_branding.app.tagline') }}</p>
                    </div>
                </div>

                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features"
                        class="text-font hover:text-primary transition-colors font-medium">Funcionalidades</a>
                    <a href="#pricing" class="text-font hover:text-primary transition-colors font-medium">Planos</a>
                    <a href="#about" class="text-font hover:text-primary transition-colors font-medium">Sobre</a>
                    <a href="#contact" class="text-font hover:text-primary transition-colors font-medium">Contato</a>
                </div>

                <!-- Botões de Ação -->
                @if (Route::has('login'))
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-font hover:text-primary font-medium">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-font hover:text-primary font-medium">
                                {{ config('app_branding.cta.login') }}
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="bg-gradient-primary text-light px-6 py-2.5 rounded-xl font-semibold text-sm hover:opacity-90 transition-all">
                                    {{ config('app_branding.cta.register_free') }}
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-primary pt-24 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-5xl md:text-7xl font-bold text-light mb-6 animate-fade-in-up">
                    {{ str_replace(config('app_branding.hero.title_highlight'), '', config('app_branding.hero.title')) }}
                    <span class="block bg-gradient-secondary bg-clip-text text-transparent">
                        {{ config('app_branding.hero.title_highlight') }}
                    </span>
                </h1>
                <p
                    class="text-xl md:text-2xl text-light/90 mb-8 max-w-3xl mx-auto animate-fade-in-up animate-delay-100">
                    {{ config('app_branding.hero.subtitle') }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up animate-delay-200">
                    <a href="{{ route('register') }}"
                        class="bg-light text-primary px-8 py-4 rounded-xl font-bold text-lg hover:bg-bg transition-all transform hover:scale-105 shadow-xl">
                        {{ config('app_branding.hero.cta_primary') }}
                    </a>
                    <a href="#demo"
                        class="bg-light/20 text-light px-8 py-4 rounded-xl font-bold text-lg hover:bg-light/30 transition-all border border-light/30">
                        {{ config('app_branding.hero.cta_secondary') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-light py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                @foreach (config('app_branding.stats') as $stat)
                    <div class="text-center">
                        <div class="text-4xl font-bold text-primary mb-2">{{ $stat['number'] }}</div>
                        <div class="text-font/70">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-font mb-4">
                    {{ str_replace(config('app_branding.sections.features.title_highlight'), '', config('app_branding.sections.features.title')) }}
                    <span class="text-primary">{{ config('app_branding.sections.features.title_highlight') }}</span>
                </h2>
                <p class="text-xl text-font/70 max-w-3xl mx-auto">
                    {{ str_replace('vestuário', config('app_branding.app.segment'), config('app_branding.sections.features.subtitle')) }}
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-light p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all animate-fade-in-up">
                    <div class="bg-gradient-primary w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-font mb-3">Controle de Produção</h3>
                    <p class="text-font/70">Monitore cada etapa: corte, costura, acabamento e embalagem em tempo real.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="bg-light p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all animate-fade-in-up animate-delay-100">
                    <div class="bg-gradient-primary w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-font mb-3">Gestão de Estoque</h3>
                    <p class="text-font/70">Controle tecidos, aviamentos e produtos acabados com alertas automáticos.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="bg-light p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all animate-fade-in-up animate-delay-200">
                    <div class="bg-gradient-primary w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-font mb-3">Análise de Qualidade</h3>
                    <p class="text-font/70">Sistema de controle de qualidade com métricas e relatórios detalhados.</p>
                </div>

                <!-- Feature 4 -->
                <div
                    class="bg-light p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all animate-fade-in-up animate-delay-300">
                    <div class="bg-gradient-primary w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-font mb-3">Gestão de Prazos</h3>
                    <p class="text-font/70">Timeline visual de produção com alertas de atraso e otimização automática.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div
                    class="bg-light p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all animate-fade-in-up animate-delay-100">
                    <div class="bg-gradient-primary w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-font mb-3">Gestão de Equipe</h3>
                    <p class="text-font/70">Controle de produtividade, escalas e performance individual dos
                        colaboradores.</p>
                </div>

                <!-- Feature 6 -->
                <div
                    class="bg-light p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all animate-fade-in-up animate-delay-200">
                    <div class="bg-gradient-primary w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-font mb-3">Relatórios Inteligentes</h3>
                    <p class="text-font/70">Dashboards personalizados com insights para tomada de decisão estratégica.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 bg-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-font mb-4">
                    {{ str_replace(config('app_branding.sections.pricing.title_highlight'), '', config('app_branding.sections.pricing.title')) }}
                    <span class="text-primary">{{ config('app_branding.sections.pricing.title_highlight') }}</span>
                </h2>
                <p class="text-xl text-font/70 max-w-3xl mx-auto">
                    {{ config('app_branding.sections.pricing.subtitle') }}
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                    $plans = [
                        [
                            'name' => config('app_branding.plans.starter.name'),
                            'slug' => 'starter',
                            'description' => str_replace(
                                'confecções',
                                config('app_branding.app.business_type_plural'),
                                config('app_branding.plans.starter.description'),
                            ),
                            'price' => config('app_branding.plans.starter.price'),
                            'period' => config('app_branding.plans.starter.period'),
                            'features' => [
                                'Até 50 produtos/mês',
                                'Controle básico de estoque',
                                'Relatórios essenciais',
                                'Suporte por email',
                                '1 usuário',
                            ],
                            'popular' => false,
                            'cta' => config('app_branding.plans.starter.cta'),
                        ],
                        [
                            'name' => config('app_branding.plans.professional.name'),
                            'slug' => 'professional',
                            'description' => config('app_branding.plans.professional.description'),
                            'price' => config('app_branding.plans.professional.price'),
                            'period' => config('app_branding.plans.professional.period'),
                            'features' => [
                                'Até 500 produtos/mês',
                                'Gestão completa de produção',
                                'Controle de qualidade',
                                'Relatórios avançados',
                                'Até 5 usuários',
                                'Suporte prioritário',
                            ],
                            'popular' => true,
                            'cta' => config('app_branding.plans.professional.cta'),
                        ],
                        [
                            'name' => config('app_branding.plans.business.name'),
                            'slug' => 'business',
                            'description' => config('app_branding.plans.business.description'),
                            'price' => config('app_branding.plans.business.price'),
                            'period' => config('app_branding.plans.business.period'),
                            'features' => [
                                'Até 2000 produtos/mês',
                                'Múltiplas linhas de produção',
                                'Integração com e-commerce',
                                'API personalizada',
                                'Até 15 usuários',
                                'Suporte telefônico',
                            ],
                            'popular' => false,
                            'cta' => config('app_branding.plans.business.cta'),
                        ],
                        [
                            'name' => config('app_branding.plans.enterprise.name'),
                            'slug' => 'enterprise',
                            'description' => config('app_branding.plans.enterprise.description'),
                            'price' => config('app_branding.plans.enterprise.price'),
                            'period' => config('app_branding.plans.enterprise.period'),
                            'features' => [
                                'Produção ilimitada',
                                'Customizações específicas',
                                'Integração ERP',
                                'Consultoria especializada',
                                'Usuários ilimitados',
                                'Suporte 24/7',
                            ],
                            'popular' => false,
                            'cta' => config('app_branding.plans.enterprise.cta'),
                        ],
                    ];
                @endphp

                @foreach ($plans as $plan)
                    <div
                        class="bg-bg p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all relative {{ $plan['popular'] ? 'border-2 border-primary transform scale-105' : '' }}">
                        @if ($plan['popular'])
                            <div
                                class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-primary text-light px-4 py-1 rounded-full text-sm font-semibold">
                                Mais Popular
                            </div>
                        @endif

                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-font mb-2">{{ $plan['name'] }}</h3>
                            <p class="text-font/70 mb-6">{{ $plan['description'] }}</p>

                            <div class="mb-8">
                                @if ($plan['price'] === 'Personalizado')
                                    <div class="text-3xl font-bold text-font">Personalizado</div>
                                @else
                                    <div class="flex items-baseline justify-center">
                                        <span class="text-5xl font-bold text-font">R\$ {{ $plan['price'] }}</span>
                                        @if ($plan['period'])
                                            <span class="text-font/70 ml-2">/{{ $plan['period'] }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <ul class="space-y-4 mb-8 text-left">
                                @foreach ($plan['features'] as $feature)
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-success mr-3 flex-shrink-0" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-font/80">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            @if ($plan['slug'] === 'enterprise')
                                <a href="#contact"
                                    class="w-full bg-gradient-primary text-light py-3 px-6 rounded-xl font-bold text-center block hover:opacity-90 transition-all">
                                    {{ $plan['cta'] }}
                                </a>
                            @else
                                <a href="{{ route('register', ['plan' => $plan['slug']]) }}"
                                    class="w-full bg-gradient-primary text-light py-3 px-6 rounded-xl font-bold text-center block hover:opacity-90 transition-all">
                                    {{ $plan['cta'] }}
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-primary py-20">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8 relative z-10">
            <h2 class="text-4xl md:text-5xl font-bold mb-6 text-light">
                {{ config('app_branding.sections.cta.title') }}
            </h2>
            <p class="text-xl text-light/90 mb-8">
                {{ config('app_branding.sections.cta.subtitle') }}
            </p>
            <a href="{{ route('register') }}"
                class="bg-light text-primary px-8 py-4 rounded-xl font-bold text-lg hover:bg-bg transition-all transform hover:scale-105 shadow-xl inline-block">
                {{ config('app_branding.sections.cta.button') }}
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-light py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="{{ asset(config('app_branding.logos.icon')) }}"
                            alt="{{ config('app_branding.logos.alt') }}"
                            class="{{ config('app_branding.logos.sizes.footer') }}">
                        <div>
                            <h3 class="text-xl font-bold text-light">{{ config('app_branding.app.name') }}</h3>
                            <p class="text-light/70">{{ config('app_branding.app.description') }}</p>
                        </div>
                    </div>
                    <p class="text-light/70 max-w-md">
                        {{ config('app_branding.footer.description') }}
                    </p>
                </div>

                <div>
                    <h4 class="font-semibold mb-4 text-light">{{ config('app_branding.footer.links.product.title') }}
                    </h4>
                    <ul class="space-y-2 text-light/70">
                        @foreach (config('app_branding.footer.links.product.items') as $label => $url)
                            <li><a href="{{ $url }}"
                                    class="hover:text-light transition-colors">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4 text-light">{{ config('app_branding.footer.links.support.title') }}
                    </h4>
                    <ul class="space-y-2 text-light/70">
                        @foreach (config('app_branding.footer.links.support.items') as $label => $url)
                            <li><a href="{{ $url }}"
                                    class="hover:text-light transition-colors">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="border-t border-light/20 mt-12 pt-8 text-center text-light/70">
                <p>&copy; {{ date('Y') }} {{ config('app_branding.app.name') }}.
                    {{ config('app_branding.footer.copyright') }}</p>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-glass');
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-lg');
            } else {
                navbar.classList.remove('shadow-lg');
            }
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>
