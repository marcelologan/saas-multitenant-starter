<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-font leading-tight">
                    Perfil do Usuário
                </h2>
                <p class="text-sm text-font/60 mt-1">
                    Gerencie suas informações pessoais e configurações da conta
                </p>
            </div>
            <div class="mt-4 sm:mt-0 flex items-center space-x-3">
                <div class="text-sm text-font/50">
                    Última atualização: {{ $user->updated_at->format('d/m/Y H:i') }}
                </div>
                @php
                    $userRole = $user->activeRoles->first();
                @endphp
                @if ($userRole)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                        {{ $userRole->slug === 'admin-empresa'
                            ? 'bg-primary/10 text-primary'
                            : ($userRole->slug === 'gerente'
                                ? 'bg-success/10 text-success'
                                : ($userRole->slug === 'funcionario'
                                    ? 'bg-warning/10 text-warning'
                                    : 'bg-font/10 text-font/60')) }}">
                        {{ $userRole->name }}
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-danger/10 text-danger">
                        Sem função definida
                    </span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Informações do Usuário -->
            <div class="bg-light overflow-hidden shadow-lg rounded-2xl border border-font/10">
                <div class="px-6 py-4 border-b border-font/10">
                    <h3 class="text-lg font-semibold text-font">Informações Pessoais</h3>
                    <p class="text-sm text-font/60 mt-1">Atualize seus dados pessoais e informações de contato</p>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Dados da Empresa (apenas para Admin) -->
            @if ($user->isAdmin())
                <div class="bg-light overflow-hidden shadow-lg rounded-2xl border border-font/10">
                    <div class="px-6 py-4 border-b border-font/10">
                        <h3 class="text-lg font-semibold text-font">Dados da Empresa</h3>
                        <p class="text-sm text-font/60 mt-1">Gerencie as informações da sua empresa</p>
                    </div>
                    <div class="p-6">
                        @include('profile.partials.update-company-information-form')
                    </div>
                </div>
            @endif

            <!-- Alterar Senha -->
            <div class="bg-light overflow-hidden shadow-lg rounded-2xl border border-font/10">
                <div class="px-6 py-4 border-b border-font/10">
                    <h3 class="text-lg font-semibold text-font">Segurança da Conta</h3>
                    <p class="text-sm text-font/60 mt-1">Mantenha sua conta segura com uma senha forte</p>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Excluir Conta -->
            <div class="bg-light overflow-hidden shadow-lg rounded-2xl border border-font/10">
                <div class="px-6 py-4 border-b border-font/10">
                    <h3 class="text-lg font-semibold text-font">Zona de Perigo</h3>
                    <p class="text-sm text-font/60 mt-1">Ações irreversíveis relacionadas à sua conta</p>
                </div>
                <div class="p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>