<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    Perfil do Usuário
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Gerencie suas informações pessoais e configurações da conta
                </p>
            </div>
            <div class="mt-4 sm:mt-0 flex items-center space-x-3">
                <div class="text-sm text-gray-500">
                    Última atualização: {{ $user->updated_at->format('d/m/Y H:i') }}
                </div>
                @if($user->isAdmin())
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Administrador
                    </span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Informações do Usuário -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Informações Pessoais</h3>
                    <p class="text-sm text-gray-600 mt-1">Atualize seus dados pessoais e informações de contato</p>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Dados da Empresa (apenas para Admin) -->
            @if($user->isAdmin())
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Dados da Empresa</h3>
                        <p class="text-sm text-gray-600 mt-1">Gerencie as informações da sua empresa</p>
                    </div>
                    <div class="p-6">
                        @include('profile.partials.update-company-information-form')
                    </div>
                </div>
            @endif

            <!-- Alterar Senha -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Segurança da Conta</h3>
                    <p class="text-sm text-gray-600 mt-1">Mantenha sua conta segura com uma senha forte</p>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Excluir Conta -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Zona de Perigo</h3>
                    <p class="text-sm text-gray-600 mt-1">Ações irreversíveis relacionadas à sua conta</p>
                </div>
                <div class="p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>