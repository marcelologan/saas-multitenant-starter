<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Gestão Inteligente para Indústria Têxtil</title>

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

<body class="antialiased">
    <!-- Navbar Profissional -->
    <nav class="navbar-glass fixed w-full top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Navbar - Logo Corrigido -->
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('assets/img/fm_ico.png') }}" alt="Fashion Manager" class="w-10 h-10">
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Fashion Manager</h1>
                        <p class="text-xs text-gray-500">Gestão Têxtil</p>
                    </div>
                </div>

                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features"
                        class="text-gray-700 hover:text-primary transition-colors font-medium">Funcionalidades</a>
                    <a href="#pricing" class="text-gray-700 hover:text-primary transition-colors font-medium">Planos</a>
                    <a href="#about" class="text-gray-700 hover:text-primary transition-colors font-medium">Sobre</a>
                    <a href="#contact"
                        class="text-gray-700 hover:text-primary transition-colors font-medium">Contato</a>
                </div>

                <!-- Botões de Ação -->
                @if (Route::has('login'))
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-primary font-medium">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary font-medium">
                                Entrar
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="btn-gradient px-6 py-2.5 rounded-xl font-semibold text-sm">
                                    Começar Grátis
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section pt-24 pb-20">
        <div class="hero-content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 animate-fade-in-up">
                    Revolucione sua
                    <span class="block bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">
                        Produção Têxtil
                    </span>
                </h1>
                <p
                    class="text-xl md:text-2xl text-white/90 mb-8 max-w-3xl mx-auto animate-fade-in-up animate-delay-100">
                    Sistema completo para gestão de produção, controle de qualidade e otimização de processos na
                    indústria do vestuário
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up animate-delay-200">
                    <a href="{{ route('register') }}"
                        class="bg-white text-primary px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-50 transition-all transform hover:scale-105 shadow-xl">
                        Teste Grátis por 30 Dias
                    </a>
                    <a href="#demo"
                        class="glass-effect text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/20 transition-all">
                        Ver Demonstração
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Empresas Atendidas</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">2M+</div>
                    <div class="stat-label">Peças Produzidas</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">35%</div>
                    <div class="stat-label">Aumento Eficiência</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">99.9%</div>
                    <div class="stat-label">Uptime Sistema</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Funcionalidades Específicas para
                    <span class="text-primary">Indústria Têxtil</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Desenvolvido especificamente para as necessidades da produção de vestuário
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card animate-fade-in-up">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Controle de Produção</h3>
                    <p class="text-gray-600">Monitore cada etapa: corte, costura, acabamento e embalagem em tempo real.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card animate-fade-in-up animate-delay-100">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Gestão de Estoque</h3>
                    <p class="text-gray-600">Controle tecidos, aviamentos e produtos acabados com alertas automáticos.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card animate-fade-in-up animate-delay-200">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Análise de Qualidade</h3>
                    <p class="text-gray-600">Sistema de controle de qualidade com métricas e relatórios detalhados.</p>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card animate-fade-in-up animate-delay-300">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Gestão de Prazos</h3>
                    <p class="text-gray-600">Timeline visual de produção com alertas de atraso e otimização automática.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card animate-fade-in-up animate-delay-100">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Gestão de Equipe</h3>
                    <p class="text-gray-600">Controle de produtividade, escalas e performance individual dos
                        colaboradores.</p>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card animate-fade-in-up animate-delay-200">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Relatórios Inteligentes</h3>
                    <p class="text-gray-600">Dashboards personalizados com insights para tomada de decisão estratégica.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Planos que Crescem com seu
                    <span class="text-primary">Negócio</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Escolha o plano ideal para o tamanho da sua operação
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                    $plans = [
                        [
                            'name' => 'Starter',
                            'slug' => 'starter',
                            'description' => 'Ideal para pequenas confecções',
                            'price' => '0.00',
                            'period' => '30 dias grátis',
                            'features' => [
                                'Até 50 produtos/mês',
                                'Controle básico de estoque',
                                'Relatórios essenciais',
                                'Suporte por email',
                                '1 usuário',
                            ],
                            'popular' => false,
                            'cta' => 'Começar Grátis',
                        ],
                        [
                            'name' => 'Professional',
                            'slug' => 'professional',
                            'description' => 'Para empresas em crescimento',
                            'price' => '149.90',
                            'period' => 'mês',
                            'features' => [
                                'Até 500 produtos/mês',
                                'Gestão completa de produção',
                                'Controle de qualidade',
                                'Relatórios avançados',
                                'Até 5 usuários',
                                'Suporte prioritário',
                            ],
                            'popular' => true,
                            'cta' => 'Mais Popular',
                        ],
                        [
                            'name' => 'Business',
                            'slug' => 'business',
                            'description' => 'Para médias empresas',
                            'price' => '299.90',
                            'period' => 'mês',
                            'features' => [
                                'Até 2000 produtos/mês',
                                'Múltiplas linhas de produção',
                                'Integração com e-commerce',
                                'API personalizada',
                                'Até 15 usuários',
                                'Suporte telefônico',
                            ],
                            'popular' => false,
                            'cta' => 'Escolher Plano',
                        ],
                        [
                            'name' => 'Enterprise',
                            'slug' => 'enterprise',
                            'description' => 'Solução completa',
                            'price' => 'Personalizado',
                            'period' => '',
                            'features' => [
                                'Produção ilimitada',
                                'Customizações específicas',
                                'Integração ERP',
                                'Consultoria especializada',
                                'Usuários ilimitados',
                                'Suporte 24/7',
                            ],
                            'popular' => false,
                            'cta' => 'Falar com Vendas',
                        ],
                    ];
                @endphp

                @foreach ($plans as $plan)
                    <div class="pricing-card {{ $plan['popular'] ? 'popular' : '' }}">
                        @if ($plan['popular'])
                            <div class="popular-badge">Mais Popular</div>
                        @endif

                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $plan['name'] }}</h3>
                            <p class="text-gray-600 mb-6">{{ $plan['description'] }}</p>

                            <div class="mb-8">
                                @if ($plan['price'] === 'Personalizado')
                                    <div class="text-3xl font-bold text-gray-900">Personalizado</div>
                                @else
                                    <div class="flex items-baseline justify-center">
                                        <span class="text-5xl font-bold text-gray-900">R\$ {{ $plan['price'] }}</span>
                                        @if ($plan['period'])
                                            <span class="text-gray-600 ml-2">/{{ $plan['period'] }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <ul class="space-y-4 mb-8 text-left">
                                @foreach ($plan['features'] as $feature)
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-primary mr-3 flex-shrink-0" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-gray-700">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            @if ($plan['slug'] === 'enterprise')
                                <a href="#contact"
                                    class="w-full btn-gradient py-3 px-6 rounded-xl font-bold text-center block">
                                    {{ $plan['cta'] }}
                                </a>
                            @else
                                <a href="{{ route('register', ['plan' => $plan['slug']]) }}"
                                    class="w-full btn-gradient py-3 px-6 rounded-xl font-bold text-center block">
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
    <section class="cta-section py-20">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8 relative z-10">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">
                Pronto para Revolucionar sua Produção?
            </h2>
            <p class="text-xl text-white/90 mb-8">
                Junte-se a centenas de empresas que já otimizaram seus processos
            </p>
            <a href="{{ route('register') }}"
                class="bg-white text-gray-900 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all transform hover:scale-105 shadow-xl inline-block">
                Começar Teste Grátis Agora
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <!-- Footer - Logo Corrigido -->
                        <div class="flex items-center space-x-3 mb-4">
                            <img src="{{ asset('assets/img/fm_ico.png') }}" alt="Fashion Manager" class="w-10 h-10">
                            <div>
                                <h3 class="text-xl font-bold">Fashion Manager</h3>
                                <p class="text-gray-400">Gestão Têxtil Inteligente</p>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-400 max-w-md">
                        Transformamos a gestão de produção têxtil com tecnologia de ponta e foco na eficiência
                        operacional.
                    </p>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Produto</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#features" class="hover:text-white transition-colors">Funcionalidades</a></li>
                        <li><a href="#pricing" class="hover:text-white transition-colors">Preços</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Integrações</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">API</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Suporte</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Central de Ajuda</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Documentação</a></li>
                        <li><a href="#contact" class="hover:text-white transition-colors">Contato</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Status</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.</p>
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
