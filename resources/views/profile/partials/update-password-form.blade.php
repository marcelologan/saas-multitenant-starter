<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Alterar Senha
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Mantenha sua conta segura usando uma senha longa e aleatória.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Senha Atual -->
            <div class="md:col-span-2">
                <x-input-label for="update_password_current_password" value="Senha Atual *" />
                <x-text-input 
                    id="update_password_current_password" 
                    name="current_password" 
                    type="password" 
                    class="mt-1 block w-full" 
                    autocomplete="current-password" 
                    required
                />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <!-- Nova Senha -->
            <div>
                <x-input-label for="update_password_password" value="Nova Senha *" />
                <x-text-input 
                    id="update_password_password" 
                    name="password" 
                    type="password" 
                    class="mt-1 block w-full" 
                    autocomplete="new-password" 
                    required
                />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                <p class="mt-1 text-xs text-gray-500">Mínimo 8 caracteres</p>
            </div>

            <!-- Confirmar Nova Senha -->
            <div>
                <x-input-label for="update_password_password_confirmation" value="Confirmar Nova Senha *" />
                <x-text-input 
                    id="update_password_password_confirmation" 
                    name="password_confirmation" 
                    type="password" 
                    class="mt-1 block w-full" 
                    autocomplete="new-password" 
                    required
                />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-hover transition-colors flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <span>Alterar Senha</span>
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-green-600 flex items-center space-x-1"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Senha alterada com sucesso!</span>
                </p>
            @endif
        </div>
    </form>
</section>