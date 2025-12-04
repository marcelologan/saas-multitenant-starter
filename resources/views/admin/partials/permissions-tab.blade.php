<div x-data="permissionManagement()" class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-medium text-font">Permissões do Sistema</h3>
            <p class="text-sm text-font/60 mt-1">Visualize e gerencie todas as permissões disponíveis organizadas por módulo</p>
        </div>
        <button @click="openCreatePermissionModal()"
            class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-lg font-semibold text-xs text-light uppercase tracking-widest hover:bg-primary-hover focus:bg-primary-hover active:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            Nova Permissão
        </button>
    </div>

    <!-- Permissões por Módulo -->
    <div class="space-y-4">
        @foreach ($permissions as $module => $modulePermissions)
            <div class="bg-light shadow-sm rounded-lg border border-font/10">
                <div class="px-6 py-4 border-b border-font/10 bg-bg">
                    <h4 class="text-base font-semibold text-font capitalize flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                            <span>{{ ucfirst($module) }}</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary text-light">
                                {{ $modulePermissions->count() }} permissões
                            </span>
                        </div>
                    </h4>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 gap-3">
                        @foreach ($modulePermissions as $permission)
                            <div class="flex items-center justify-between p-4 bg-bg rounded-lg hover:bg-font/5 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-font/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-sm font-medium text-font">{{ $permission->name }}</span>
                                            @if ($permission->is_system)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-primary/10 text-primary">
                                                    Sistema
                                                </span>
                                            @endif
                                            @if (!$permission->is_active)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-font/10 text-font/60">
                                                    Inativa
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex items-center space-x-4 mt-1">
                                            <span class="text-xs text-font/50 font-mono bg-light px-2 py-1 rounded border border-font/10">{{ $permission->slug }}</span>
                                            @if ($permission->description)
                                                <span class="text-xs text-font/40">{{ $permission->description }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                @if (!$permission->is_system)
                                    <div class="flex items-center space-x-2">
                                        <button
                                            @click="openEditPermissionModal('{{ $permission->id }}', {{ json_encode($permission->name) }}, '{{ $permission->slug }}', {{ json_encode($permission->description ?? '') }}, '{{ $permission->group }}', {{ $permission->sort_order }}, {{ $permission->is_active ? 'true' : 'false' }})"
                                            class="text-link hover:text-link-hover text-sm font-medium">
                                            Editar
                                        </button>
                                        <button
                                            @click="openDeletePermissionModal('{{ $permission->id }}', {{ json_encode($permission->name) }})"
                                            class="text-danger hover:text-danger-hover text-sm font-medium">
                                            Excluir
                                        </button>
                                    </div>
                                @else
                                    <span class="text-font/40 text-sm">Protegida</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if ($permissions->isEmpty())
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-font/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                </path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-font">Nenhuma permissão encontrada</h3>
            <p class="mt-1 text-sm text-font/50">Execute o seeder para criar as permissões padrão ou crie uma nova.</p>
            <div class="mt-6">
                <button @click="openCreatePermissionModal()"
                    class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-lg font-semibold text-xs text-light uppercase tracking-widest hover:bg-primary-hover focus:bg-primary-hover active:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Nova Permissão
                </button>
            </div>
        </div>
    @endif

    <!-- Include Modals -->
    @include('admin.partials.modals.permission-modals')
</div>