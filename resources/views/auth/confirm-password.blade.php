<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-bg py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo -->
            <div class="text-center">
                <img src="{{ asset(config('app_branding.logos.full')) }}" 
                     alt="{{ config('app_branding.logos.alt') }}" 
                     class="{{ config('app_branding.logos.sizes.login') }} mx-auto mb-6">
                <h2 class="text-3xl font-bold text-font">Confirmar Senha</h2>
                <p class="mt-2 text-sm text-font-secondary">
                    Esta é uma área segura da aplicação. Confirme sua senha antes de continuar.
                </p>
            </div>

            <!-- Form Card -->
            <div class="bg-light rounded-2xl shadow-xl p-8 border border-neutral-300">
                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                    @csrf

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-font mb-2">
                            Senha Atual
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-font-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password" required autofocus
                                class="w-full pl-10 pr-4 py-3 border border-neutral-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors text-font placeholder-font-secondary bg-light"
                                placeholder="Digite sua senha atual">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="w-full bg-gradient-primary py-3 px-4 rounded-xl text-light font-semibold text-lg transition-all transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 hover:opacity-90">
                            Confirmar
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Notice -->
            <div class="text-center">
                <p class="text-xs text-font-secondary">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Confirmação necessária para acessar área segura
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>