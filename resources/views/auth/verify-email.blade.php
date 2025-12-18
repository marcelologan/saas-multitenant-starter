<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-bg py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo -->
            <div class="text-center">
                <img src="{{ asset(config('app_branding.logos.full')) }}" 
                     alt="{{ config('app_branding.logos.alt') }}" 
                     class="{{ config('app_branding.logos.sizes.login') }} mx-auto mb-6">
                <h2 class="text-3xl font-bold text-font">Verificar Email</h2>
                <p class="mt-2 text-sm text-font-secondary">
                    Obrigado por se cadastrar! Antes de começar, verifique seu endereço de email clicando no link que enviamos para você.
                </p>
            </div>

            <!-- Success Message -->
            @if (session('status') == 'verification-link-sent')
                <div class="bg-success-light border border-success rounded-xl px-4 py-3">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-success" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium text-success">Um novo link de verificação foi enviado para seu email!</span>
                    </div>
                </div>
            @endif

            <!-- Action Card -->
            <div class="bg-light rounded-2xl shadow-xl p-8 border border-neutral-300">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-primary-light rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-font mb-2">Verifique sua caixa de entrada</h3>
                    <p class="text-sm text-font-secondary">
                        Se você não recebeu o email, podemos enviar outro.
                    </p>
                </div>

                <div class="space-y-4">
                    <!-- Resend Button -->
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit"
                            class="w-full bg-gradient-primary py-3 px-4 rounded-xl text-light font-semibold text-lg transition-all transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 hover:opacity-90">
                            Reenviar Email de Verificação
                        </button>
                    </form>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full py-3 px-4 border border-neutral-300 rounded-xl text-font font-medium hover:bg-bg transition-colors">
                            Sair da Conta
                        </button>
                    </form>
                </div>
            </div>

            <!-- Help Text -->
            <div class="text-center">
                <p class="text-xs text-font-secondary">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Verifique também sua pasta de spam
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>