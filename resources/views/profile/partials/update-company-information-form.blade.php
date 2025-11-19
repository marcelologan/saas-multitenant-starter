<section>
    <!-- DEBUG TENANT - REMOVER DEPOIS -->
    <div style="background: #f0f0f0; padding: 10px; margin: 10px 0; border: 1px solid #ccc;">
        <strong>DEBUG TENANT:</strong><br>
        Tenant ID: {{ $tenant->id ?? 'NULL' }}<br>
        Company Name: {{ $tenant->company_name ?? 'NULL' }}<br>
        Trade Name: {{ $tenant->trade_name ?? 'NULL' }}<br>
        Address: {{ $tenant->address ?? 'NULL' }}<br>
        City: {{ $tenant->city ?? 'NULL' }}<br>
        State: {{ $tenant->state ?? 'NULL' }}<br>
        Status: {{ $tenant->status ?? 'NULL' }}<br>
    </div>
    <!-- FIM DEBUG -->
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Informações da Empresa
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Atualize os dados da sua empresa. CNPJ e Razão Social não podem ser alterados.
        </p>
    </header>

    <form method="post" action="{{ route('tenant.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Razão Social (Readonly) -->
            <div class="md:col-span-2">
                <x-input-label for="company_name" value="Razão Social" />
                <input id="company_name" name="company_name" type="text"
                    class="mt-1 block w-full border-gray-300 bg-gray-100 rounded-md shadow-sm"
                    value="{{ $tenant->company_name }}" readonly />
                <p class="mt-1 text-xs text-gray-500">Este campo não pode ser alterado</p>
            </div>

            <!-- CNPJ (Readonly) -->
            <div>
                <x-input-label for="cnpj" value="CNPJ" />
                <input id="cnpj" name="cnpj" type="text"
                    class="mt-1 block w-full border-gray-300 bg-gray-100 rounded-md shadow-sm"
                    value="{{ $tenant->formatted_cnpj }}" readonly />
                <p class="mt-1 text-xs text-gray-500">Este campo não pode ser alterado</p>
            </div>

            <!-- Nome Fantasia -->
            <div>
                <x-input-label for="trade_name" value="Nome Fantasia *" />
                <input id="trade_name" name="trade_name" type="text"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    value="{{ old('trade_name', $tenant->trade_name) }}" required />
                <x-input-error class="mt-2" :messages="$errors->get('trade_name')" />
            </div>

            <!-- Endereço -->
            <div class="md:col-span-2">
                <x-input-label for="address" value="Endereço *" />
                <input id="address" name="address" type="text"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    value="{{ old('address', $tenant->address) }}" required />
                <x-input-error class="mt-2" :messages="$errors->get('address')" />
            </div>

            <!-- Complemento -->
            <div>
                <x-input-label for="complement" value="Complemento" />
                <input id="complement" name="complement" type="text"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    value="{{ old('complement', $tenant->complement) }}" />
                <x-input-error class="mt-2" :messages="$errors->get('complement')" />
            </div>

            <!-- Bairro -->
            <div>
                <x-input-label for="neighborhood" value="Bairro *" />
                <input id="neighborhood" name="neighborhood" type="text"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    value="{{ old('neighborhood', $tenant->neighborhood) }}" required />
                <x-input-error class="mt-2" :messages="$errors->get('neighborhood')" />
            </div>

            <!-- Cidade -->
            <div>
                <x-input-label for="city" value="Cidade *" />
                <input id="city" name="city" type="text"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    value="{{ old('city', $tenant->city) }}" required />
                <x-input-error class="mt-2" :messages="$errors->get('city')" />
            </div>

            <!-- Estado -->
            <div>
                <x-input-label for="state" value="Estado *" />
                <select id="state" name="state"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    required>
                    <option value="">Selecione o estado</option>
                    <option value="AC" {{ old('state', $tenant->state) == 'AC' ? 'selected' : '' }}>Acre</option>
                    <option value="AL" {{ old('state', $tenant->state) == 'AL' ? 'selected' : '' }}>Alagoas
                    </option>
                    <option value="AP" {{ old('state', $tenant->state) == 'AP' ? 'selected' : '' }}>Amapá</option>
                    <option value="AM" {{ old('state', $tenant->state) == 'AM' ? 'selected' : '' }}>Amazonas
                    </option>
                    <option value="BA" {{ old('state', $tenant->state) == 'BA' ? 'selected' : '' }}>Bahia</option>
                    <option value="CE" {{ old('state', $tenant->state) == 'CE' ? 'selected' : '' }}>Ceará</option>
                    <option value="DF" {{ old('state', $tenant->state) == 'DF' ? 'selected' : '' }}>Distrito
                        Federal</option>
                    <option value="ES" {{ old('state', $tenant->state) == 'ES' ? 'selected' : '' }}>Espírito Santo
                    </option>
                    <option value="GO" {{ old('state', $tenant->state) == 'GO' ? 'selected' : '' }}>Goiás</option>
                    <option value="MA" {{ old('state', $tenant->state) == 'MA' ? 'selected' : '' }}>Maranhão
                    </option>
                    <option value="MT" {{ old('state', $tenant->state) == 'MT' ? 'selected' : '' }}>Mato Grosso
                    </option>
                    <option value="MS" {{ old('state', $tenant->state) == 'MS' ? 'selected' : '' }}>Mato Grosso do
                        Sul</option>
                    <option value="MG" {{ old('state', $tenant->state) == 'MG' ? 'selected' : '' }}>Minas Gerais
                    </option>
                    <option value="PA" {{ old('state', $tenant->state) == 'PA' ? 'selected' : '' }}>Pará</option>
                    <option value="PB" {{ old('state', $tenant->state) == 'PB' ? 'selected' : '' }}>Paraíba
                    </option>
                    <option value="PR" {{ old('state', $tenant->state) == 'PR' ? 'selected' : '' }}>Paraná</option>
                    <option value="PE" {{ old('state', $tenant->state) == 'PE' ? 'selected' : '' }}>Pernambuco
                    </option>
                    <option value="PI" {{ old('state', $tenant->state) == 'PI' ? 'selected' : '' }}>Piauí</option>
                    <option value="RJ" {{ old('state', $tenant->state) == 'RJ' ? 'selected' : '' }}>Rio de Janeiro
                    </option>
                    <option value="RN" {{ old('state', $tenant->state) == 'RN' ? 'selected' : '' }}>Rio Grande do
                        Norte</option>
                    <option value="RS" {{ old('state', $tenant->state) == 'RS' ? 'selected' : '' }}>Rio Grande do
                        Sul</option>
                    <option value="RO" {{ old('state', $tenant->state) == 'RO' ? 'selected' : '' }}>Rondônia
                    </option>
                    <option value="RR" {{ old('state', $tenant->state) == 'RR' ? 'selected' : '' }}>Roraima
                    </option>
                    <option value="SC" {{ old('state', $tenant->state) == 'SC' ? 'selected' : '' }}>Santa Catarina
                    </option>
                    <option value="SP" {{ old('state', $tenant->state) == 'SP' ? 'selected' : '' }}>São Paulo
                    </option>
                    <option value="SE" {{ old('state', $tenant->state) == 'SE' ? 'selected' : '' }}>Sergipe
                    </option>
                    <option value="TO" {{ old('state', $tenant->state) == 'TO' ? 'selected' : '' }}>Tocantins
                    </option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('state')" />
            </div>
        </div>

        <!-- Status (apenas admin pode alterar) -->
        <!-- Status -->
        <div>
            <x-input-label for="status" value="Status" />
            <div class="mt-1 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    @if (($tenant->status ?? '') === 'active')
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

                <!-- Toggle Switch para Admin -->
                @if ($user->isAdmin())
                    <div class="flex items-center">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="status" value="active" class="sr-only peer"
                                {{ ($tenant->status ?? '') === 'active' ? 'checked' : '' }}
                                onchange="this.value = this.checked ? 'active' : 'inactive'">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                            </div>
                            <span
                                class="ml-3 text-sm font-medium text-gray-700">{{ ($tenant->status ?? '') === 'active' ? 'Ativar' : 'Desativar' }}</span>
                        </label>
                    </div>
                @else
                    <input type="hidden" name="status" value="{{ $tenant->status }}">
                    <p class="text-xs text-gray-500">Apenas administradores podem alterar o status</p>
                @endif
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
        </div>
    </form>
</section>
