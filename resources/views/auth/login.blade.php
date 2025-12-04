<x-guest-layout>
    <div class="min-h-screen flex">
        <!-- Lado Esquerdo - Branding -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-primary relative overflow-hidden">
            <div class="absolute inset-0 bg-dark/20"></div>
            <div class="relative z-10 flex flex-col justify-center px-12 text-light">
                <!-- Logo no lado esquerdo -->
                <div class="mb-8">
                    <img src="{{ asset('assets/img/fm_logo.png') }}" alt="Fashion Manager" class="h-16 mb-6">
                    <h1 class="text-4xl font-bold mb-4">Bem-vindo de volta!</h1>
                    <p class="text-xl text-light/90">
                        Acesse sua conta e continue gerenciando sua produção têxtil com eficiência.
                    </p>
                </div>

                <!-- Testimonial -->
                <div class="bg-light/10 backdrop-blur-sm rounded-2xl p-6 max-w-md border border-light/20">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-light/20 rounded-full flex items-center justify-center mr-4">
                            <span class="text-light font-bold">MR</span>
                        </div>
                        <div>
                            <h4 class="font-semibold">Maria Rodrigues</h4>
                            <p class="text-light/80 text-sm">CEO, Confecções Bella</p>
                        </div>
                    </div>
                    <p class="text-light/90 italic">
                        "O Fashion Manager revolucionou nossa produção. Aumentamos 40% nossa eficiência em apenas 3 meses."
                    </p>
                </div>
            </div>

            <!-- Pattern Background -->
            <div class="absolute inset-0 opacity-10">
                <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="textile-pattern" x="0" y="0" width="60" height="60" patternUnits="userSpaceOnUse">
                            <path d="M30 0L60 30L30 60L0 30Z" fill="none" stroke="white" stroke-width="1" />
                            <circle cx="30" cy="30" r="3" fill="white" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#textile-pattern)" />
                </svg>
            </div>
        </div>

        <!-- Lado Direito - Formulário -->
        <div class="flex-1 flex flex-col justify-center px-6 sm:px-12 lg:px-16 bg-bg">
            <div class="w-full max-w-md mx-auto">
                <!-- Logo Mobile -->
                <div class="lg:hidden text-center mb-8">
                    <img src="{{ asset('assets/img/fm_logo.png') }}" alt="Fashion Manager" class="h-12 mx-auto mb-4">
                </div>

                <!-- Header -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-font mb-2">Entrar na sua conta</h2>
                    <p class="text-font/70">
                        Não tem uma conta?
                        <a href="{{ route('register') }}" class="text-primary hover:text-primary-hover font-semibold transition-colors">
                            Cadastre-se gratuitamente
                        </a>
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Formulário -->
                <div class="bg-light rounded-2xl shadow-xl p-8 border border-font/10">
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-font mb-2">
                                Email
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-font/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                </div>
                                <input id="email" name="email" type="email" autocomplete="email" required
                                    value="{{ old('email') }}"
                                    class="w-full pl-10 pr-4 py-3 border border-font/20 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors text-font placeholder-font/50 bg-light"
                                    placeholder="seu@email.com">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-font mb-2">
                                Senha
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-font/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input id="password" name="password" type="password" autocomplete="current-password" required
                                    class="w-full pl-10 pr-4 py-3 border border-font/20 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors text-font placeholder-font/50 bg-light"
                                    placeholder="Sua senha">
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember_me" name="remember" type="checkbox"
                                    class="h-4 w-4 text-primary border-font/30 rounded focus:ring-primary">
                                <label for="remember_me" class="ml-2 block text-sm text-font">
                                    Lembrar-me
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <div class="text-sm">
                                    <a href="{{ route('password.request') }}" class="text-primary hover:text-primary-hover font-semibold transition-colors">
                                        Esqueceu a senha?
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                class="w-full bg-gradient-primary py-3 px-4 rounded-xl text-light font-semibold text-lg transition-all transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 hover:opacity-90">
                                Entrar
                            </button>
                        </div>
                    </form>

                    <!-- Divider -->
                    <div class="mt-8">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-font/20"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-light text-font/50">Ou continue com</span>
                            </div>
                        </div>

                        <!-- Social Login -->
                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <button class="w-full inline-flex justify-center py-3 px-4 border border-font/20 rounded-xl shadow-sm bg-light text-sm font-medium text-font/50 hover:bg-bg transition-colors">
                                <svg class="w-5 h-5" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                    <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                    <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                    <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                                </svg>
                                <span class="ml-2">Google</span>
                            </button>

                            <button class="w-full inline-flex justify-center py-3 px-4 border border-font/20 rounded-xl shadow-sm bg-light text-sm font-medium text-font/50 hover:bg-bg transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                                <span class="ml-2">Facebook</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="mt-6 text-center">
                    <p class="text-xs text-font/50">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Seus dados estão protegidos com criptografia SSL
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>