<!-- Roles Tab Content -->
<div x-show="activeTab === 'roles'" class="space-y-6">

    <!-- Header com botão de criar -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-medium text-font">Gerenciar Funções</h3>
            <p class="text-sm text-font/60 mt-1">Crie e gerencie as funções disponíveis no sistema</p>
        </div>
        <button @click="openCreateRoleModal()"
            class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-lg font-semibold text-xs text-light uppercase tracking-widest hover:bg-primary-hover focus:bg-primary-hover active:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            Nova Função
        </button>
    </div>

    <!-- Lista de Roles -->
    <div class="bg-light shadow-sm rounded-lg border border-font/10">
        <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-font/10">
                <thead class="bg-bg">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-font/60 uppercase tracking-wider">
                            Função
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-font/60 uppercase tracking-wider">
                            Permissões
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-font/60 uppercase tracking-wider">
                            Usuários
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-font/60 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-font/60 uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-light divide-y divide-font/10">
                    @forelse($roles as $role)
                        <tr class="hover:bg-bg">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-font">{{ $role->name }}</div>
                                    @if ($role->description)
                                        <div class="text-sm text-font/60">{{ $role->description }}</div>
                                    @endif
                                    <div class="text-xs text-font/40">{{ $role->slug }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-font">
                                    {{ $role->rolePermissions->where('is_granted', true)->count() }} permissões
                                </div>
                                <button
                                    @click="openPermissionsModal('{{ $role->id }}', '{{ addslashes($role->name) }}')"
                                    class="text-xs text-primary hover:text-primary-hover">
                                    Gerenciar permissões
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-font">
                                    {{ $role->users->count() }} usuários
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($role->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success/10 text-success">
                                        Ativa
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-danger/10 text-danger">
                                        Inativa
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <button
                                        @click="openEditRoleModal(
                                        '{{ $role->id }}',
                                        '{{ addslashes($role->name) }}',
                                        '{{ addslashes($role->description) }}',
                                        '{{ $role->sort_order }}',
                                        {{ $role->is_active ? 'true' : 'false' }}
                                    )"
                                        class="text-link hover:text-link-hover p-1 rounded" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    @if ($role->users->count() === 0)
                                        <button
                                            @click="openDeleteRoleModal('{{ $role->id }}', '{{ addslashes($role->name) }}')"
                                            class="text-danger hover:text-danger-hover p-1 rounded" title="Excluir">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-font/50">
                                <svg class="mx-auto h-12 w-12 text-font/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-font">Nenhuma função encontrada</h3>
                                <p class="mt-1 text-sm text-font/50">Comece criando uma nova função.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modals das Roles -->
@include('admin.partials.modals.role-modals')