<section>
    
    <section>
        <!-- resto do código continua igual... -->
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Informações Pessoais
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Atualize suas informações pessoais e dados de contato.
            </p>
        </header>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nome -->
                <div class="md:col-span-2">
                    <x-input-label for="name" value="Nome Completo *" />
                    <input id="name" name="name" type="text"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Email (só admin pode alterar) -->
                <div>
                    <x-input-label for="email" value="E-mail *" />
                    <input id="email" name="email" type="email"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ !$user->isAdmin() ? 'bg-gray-100' : '' }}"
                        value="{{ old('email', $user->email) }}" {{ $user->isAdmin() ? 'required' : 'readonly' }}
                        autocomplete="username" />
                    @if (!$user->isAdmin())
                        <p class="mt-1 text-xs text-gray-500">Apenas administradores podem alterar o e-mail</p>
                    @endif
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                        <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-sm text-yellow-800">
                                Seu e-mail ainda não foi verificado.
                                <button form="send-verification"
                                    class="underline text-sm text-yellow-600 hover:text-yellow-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    Clique aqui para reenviar o e-mail de verificação.
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-green-600">
                                    Um novo link de verificação foi enviado para seu e-mail.
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Telefone -->
                <div>
                    <x-input-label for="phone" value="Telefone" />
                    <input id="phone" name="phone" type="text"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        value="{{ old('phone', $user->phone) }}" placeholder="(11) 99999-9999" autocomplete="tel" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>

                <!-- Role (readonly) -->
                <div>
                    <x-input-label for="role" value="Função" />
                    <input id="role" name="role" type="text"
                        class="mt-1 block w-full border-gray-300 bg-gray-100 rounded-md shadow-sm"
                        value="{{ ucfirst($user->role) }}" readonly />
                    <p class="mt-1 text-xs text-gray-500">Este campo não pode ser alterado</p>
                </div>
                <!-- Status (readonly) -->
                <div>
                    <x-input-label for="status" value="Status" />
                    <div class="mt-1 flex items-center space-x-2">
                        @if (($user->status ?? '') === 'active')
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Ativo
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Inativo
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button type="submit"
                    class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-hover transition-colors flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Salvar Alterações</span>
                </button>

                {{-- @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                        class="text-sm text-green-600 flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        <span>Perfil atualizado com sucesso!</span>
                    </p>
                @endif --}}
            </div>
        </form>
    </section>

    <script>
        // Máscara para telefone
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');

            if (value.length <= 11) {
                if (value.length <= 10) {
                    value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                } else {
                    value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                }
            }

            e.target.value = value;
        });
    </script>
