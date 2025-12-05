<x-guest-layout>
    <!-- ADICIONAR NO TOPO DA VIEW REGISTER -->
    @if ($errors->any())
        <div class="bg-danger/10 border border-danger/20 text-danger px-4 py-3 rounded mb-4">
            <h4 class="font-bold">Erros encontrados:</h4>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-danger/10 border border-danger/20 text-danger px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="min-h-screen bg-gray-50">
        <!-- Header Corrigido -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo Corrigida -->
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset(config('app_branding.logos.icon')) }}"
                            alt="{{ config('app_branding.logos.alt') }}"
                            class="{{ config('app_branding.logos.sizes.navbar') }}">
                        <div>
                            <span class="text-xl font-bold text-gray-900">{{ config('app_branding.app.name') }}</span>
                            <p class="text-xs text-gray-500 -mt-1">{{ config('app_branding.app.tagline') }}</p>
                        </div>
                    </div>

                    <!-- Link para Login -->
                    <div class="text-sm text-gray-600">
                        {{ config('app_branding.auth.register.already_have_account') }}
                        <a href="{{ route('login') }}"
                            class="text-primary hover:text-primary-hover font-semibold transition-colors">
                            {{ config('app_branding.cta.login_link') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resto do conteúdo permanece igual... -->
        <div class="py-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Progress Steps -->
                <div class="mb-8">
                    <div class="flex items-center justify-center space-x-4">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                1</div>
                            <span class="ml-2 text-sm font-medium text-primary">Dados da Empresa</span>
                        </div>
                        <div class="w-16 h-1 bg-gray-300 rounded"></div>
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 text-sm font-semibold">
                                2</div>
                            <span class="ml-2 text-sm font-medium text-gray-600">Administrador</span>
                        </div>
                        <div class="w-16 h-1 bg-gray-300 rounded"></div>
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 text-sm font-semibold">
                                3</div>
                            <span class="ml-2 text-sm font-medium text-gray-600">Plano</span>
                        </div>
                    </div>
                </div>

                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ config('app_branding.auth.register.title') }}
                    </h1>
                    <p class="text-xl text-gray-600">
                        {{ str_replace('têxtil', config('app_branding.app.industry_adjective'), config('app_branding.auth.register.subtitle')) }}
                    </p>
                </div>

                <!-- Main Form Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                    <form method="POST" action="{{ route('register') }}" class="p-8 space-y-8">
                        @csrf

                        <!-- Dados da Empresa -->
                        <div>
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900">
                                        {{ config('app_branding.auth.register.company_section.title') }}</h2>
                                    <p class="text-gray-600">
                                        {{ str_replace('confecção', config('app_branding.app.business_type'), config('app_branding.auth.register.company_section.subtitle')) }}
                                    </p>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="company_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Razão Social *
                                    </label>
                                    <input id="company_name" name="company_name" type="text" required
                                        value="{{ old('company_name') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                        placeholder="{{ config('app_branding.placeholders.company_name') }}">
                                    <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                                </div>

                                <div>
                                    <label for="trade_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nome Fantasia
                                    </label>
                                    <input id="trade_name" name="trade_name" type="text"
                                        value="{{ old('trade_name') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                        placeholder="{{ config('app_branding.placeholders.trade_name') }}">
                                    <x-input-error :messages="$errors->get('trade_name')" class="mt-2" />
                                </div>

                                <div>
                                    <label for="cnpj" class="block text-sm font-semibold text-gray-700 mb-2">
                                        CNPJ *
                                    </label>
                                    <input id="cnpj" name="cnpj" type="text" required
                                        value="{{ old('cnpj') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                        placeholder="{{ config('app_branding.placeholders.cnpj') }}" maxlength="18">
                                    <x-input-error :messages="$errors->get('cnpj')" class="mt-2" />
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Telefone *
                                    </label>
                                    <input id="phone" name="phone" type="text" required
                                        value="{{ old('phone') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                        placeholder="{{ config('app_branding.placeholders.phone') }}">
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>

                                <div class="md:col-span-2">
                                    <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Endereço Completo
                                    </label>
                                    <input id="address" name="address" type="text" value="{{ old('address') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                        placeholder="{{ config('app_branding.placeholders.address') }}">
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200"></div>

                        <!-- Dados do Administrador -->
                        <div>
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900">
                                        {{ config('app_branding.auth.register.admin_section.title') }}</h2>
                                    <p class="text-gray-600">
                                        {{ config('app_branding.auth.register.admin_section.subtitle') }}</p>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nome Completo *
                                    </label>
                                    <input id="name" name="name" type="text" required
                                        value="{{ old('name') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                        placeholder="{{ config('app_branding.placeholders.admin_name') }}">
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Email *
                                    </label>
                                    <input id="email" name="email" type="email" required
                                        value="{{ old('email') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                        placeholder="{{ config('app_branding.placeholders.admin_email') }}">
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Senha *
                                    </label>
                                    <input id="password" name="password" type="password" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                        placeholder="{{ config('app_branding.placeholders.password') }}">
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div>
                                    <label for="password_confirmation"
                                        class="block text-sm font-semibold text-gray-700 mb-2">
                                        Confirmar Senha *
                                    </label>
                                    <input id="password_confirmation" name="password_confirmation" type="password"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                        placeholder="{{ config('app_branding.placeholders.password_confirm') }}">
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200"></div>

                        <!-- Seleção de Plano -->
                        <div>
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900">
                                        {{ config('app_branding.auth.register.plan_section.title') }}</h2>
                                    <p class="text-gray-600">
                                        {{ config('app_branding.auth.register.plan_section.subtitle') }}</p>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-3 gap-6">
                                @php
                                    $plans = [
                                        [
                                            'id' => 1,
                                            'name' => config('app_branding.plans.starter.name'),
                                            'price' => config('app_branding.plans.starter.price'),
                                            'period' => config('app_branding.plans.starter.period'),
                                            'slug' => 'starter',
                                            'features' => ['Até 50 produtos/mês', 'Controle básico', '1 usuário'],
                                            'popular' => false,
                                        ],
                                        [
                                            'id' => 2,
                                            'name' => config('app_branding.plans.professional.name'),
                                            'price' => config('app_branding.plans.professional.price'),
                                            'period' => config('app_branding.plans.professional.period'),
                                            'slug' => 'professional',
                                            'features' => ['Até 500 produtos/mês', 'Gestão completa', '5 usuários'],
                                            'popular' => true,
                                        ],
                                        [
                                            'id' => 3,
                                            'name' => config('app_branding.plans.business.name'),
                                            'price' => config('app_branding.plans.business.price'),
                                            'period' => config('app_branding.plans.business.period'),
                                            'slug' => 'business',
                                            'features' => ['Até 2000 produtos/mês', 'Múltiplas linhas', '15 usuários'],
                                            'popular' => false,
                                        ],
                                    ];
                                @endphp

                                @foreach ($plans as $plan)
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="plan_id" value="{{ $plan['id'] }}"
                                            class="sr-only peer"
                                            {{ old('plan_id', request('plan') == $plan['slug'] ? $plan['id'] : 1) == $plan['id'] ? 'checked' : '' }}>

                                        <div
                                            class="border-2 border-gray-200 rounded-xl p-6 peer-checked:border-primary peer-checked:bg-primary/5 transition-all group-hover:border-primary/50 {{ $plan['popular'] ? 'ring-2 ring-primary/20' : '' }}">
                                            @if ($plan['popular'])
                                                <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                                                    <span
                                                        class="bg-primary text-white px-3 py-1 rounded-full text-xs font-semibold">
                                                        Mais Popular
                                                    </span>
                                                </div>
                                            @endif

                                            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $plan['name'] }}</h3>
                                            <div class="mb-4">
                                                <span class="text-2xl font-bold text-gray-900">R\$
                                                    {{ $plan['price'] }}</span>
                                                <span class="text-gray-600">/{{ $plan['period'] }}</span>
                                            </div>

                                            <ul class="space-y-2 text-sm text-gray-600">
                                                @foreach ($plan['features'] as $feature)
                                                    <li class="flex items-center">
                                                        <svg class="w-4 h-4 text-primary mr-2" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        {{ $feature }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('plan_id')" class="mt-2" />
                        </div>

                        <!-- Terms -->
                        <div class="flex items-start">
                            <input id="terms" name="terms" type="checkbox" required
                                class="h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary mt-1">
                            <label for="terms" class="ml-3 text-sm text-gray-600">
                                {{ config('app_branding.auth.register.terms_text') }}
                                <a href="#"
                                    class="text-primary hover:text-primary-hover font-semibold">{{ config('app_branding.auth.register.terms_link') }}</a>
                                e
                                <a href="#"
                                    class="text-primary hover:text-primary-hover font-semibold">{{ config('app_branding.auth.register.privacy_link') }}</a>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6">
                            <button type="submit"
                                class="w-full btn-gradient py-4 px-6 rounded-xl text-white font-bold text-lg transition-all transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                {{ config('app_branding.cta.register') }}
                            </button>
                            <p class="mt-4 text-center text-sm text-gray-500">
                                {{ config('app_branding.auth.register.trust_message') }}
                            </p>
                        </div>
                    </form>
                </div>

                <!-- Trust Signals -->
                <div class="mt-12 text-center">
                    <p class="text-gray-600 mb-6">{{ config('app_branding.hero.trust_message') }}</p>
                    <div class="flex justify-center items-center space-x-8 opacity-60">
                        @foreach (config('app_branding.clients') as $client)
                            <div
                                class="w-24 h-12 bg-gray-200 rounded flex items-center justify-center text-xs font-semibold text-gray-500">
                                {{ $client['name'] }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Máscara para CNPJ
        document.getElementById('cnpj').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/^(\d{2})(\d)/, '$1.$2');
            value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
            value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
            value = value.replace(/(\d{4})(\d)/, '$1-$2');
            e.target.value = value;
        });

        // Máscara para telefone
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/^(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{5})(\d)/, '$1-$2');
            e.target.value = value;
        });

        // Progress steps animation
        const form = document.querySelector('form');
        const steps = document.querySelectorAll('.step');

        // Simular progresso baseado no scroll ou preenchimento
        window.addEventListener('scroll', function() {
            const scrollPercent = (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100;

            if (scrollPercent > 20) {
                // Ativar step 2
                document.querySelector('.step-2')?.classList.add('active');
            }

            if (scrollPercent > 60) {
                // Ativar step 3
                document.querySelector('.step-3')?.classList.add('active');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Verificar se há erros de elementos JS
            console.log('=== DEBUG REGISTER PAGE ===');

            // Verificar se todos os elementos críticos existem
            const form = document.querySelector('form');
            const submitBtn = document.querySelector('button[type="submit"]');
            const planInputs = document.querySelectorAll('input[name="plan_id"]');

            console.log('Form encontrado:', !!form);
            console.log('Submit button encontrado:', !!submitBtn);
            console.log('Plan inputs encontrados:', planInputs.length);

            // Prevenir erro de classList
            try {
                // Qualquer código que use classList aqui
            } catch (error) {
                console.error('Erro JS capturado:', error);
            }
        });
    </script>
</x-guest-layout>
