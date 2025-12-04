<!-- Create Permission Modal -->
<div x-show="showCreatePermissionModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">

    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-dark/50 transition-opacity" @click="closeCreatePermissionModal()"></div>

        <!-- Modal panel -->
        <div x-show="showCreatePermissionModal" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="inline-block align-bottom bg-light rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">

            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium text-font flex items-center space-x-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Nova Permissão</span>
                </h3>
                <button @click="closeCreatePermissionModal()" class="text-font/40 hover:text-font/60">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.permissions.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <!-- Nome -->
                    <div>
                        <label for="create_permission_name" class="block text-sm font-medium text-font">Nome da
                            Permissão</label>
                        <input type="text" id="create_permission_name" name="name"
                            x-ref="createPermissionNameInput"
                            class="mt-1 block w-full px-3 py-2 border border-font/20 rounded-lg shadow-sm focus:outline-none focus:ring-primary focus:border-primary bg-light text-font"
                            placeholder="Ex: Visualizar relatórios" required>
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="create_permission_slug" class="block text-sm font-medium text-font">Slug</label>
                        <input type="text" id="create_permission_slug" name="slug"
                            class="mt-1 block w-full px-3 py-2 border border-font/20 rounded-lg shadow-sm focus:outline-none focus:ring-primary focus:border-primary bg-light text-font"
                            placeholder="Ex: reports.view" pattern="[a-z0-9._-]+" required>
                        <p class="mt-1 text-xs text-font/50">Use apenas letras minúsculas, números, pontos, hífens e
                            underscores</p>
                    </div>

                    <!-- Descrição -->
                    <div>
                        <label for="create_permission_description" class="block text-sm font-medium text-font">Descrição
                            (opcional)</label>
                        <textarea id="create_permission_description" name="description" rows="3"
                            class="mt-1 block w-full px-3 py-2 border border-font/20 rounded-lg shadow-sm focus:outline-none focus:ring-primary focus:border-primary bg-light text-font"
                            placeholder="Descreva o que esta permissão permite fazer..."></textarea>
                    </div>

                    <!-- Grupo -->
                    <div>
                        <label for="create_permission_group"
                            class="block text-sm font-medium text-font">Grupo/Módulo</label>
                        <input type="text" id="create_permission_group" name="group"
                            class="mt-1 block w-full px-3 py-2 border border-font/20 rounded-lg shadow-sm focus:outline-none focus:ring-primary focus:border-primary bg-light text-font"
                            placeholder="Ex: relatórios" required>
                    </div>

                    <!-- Ordem -->
                    <div>
                        <label for="create_permission_sort_order" class="block text-sm font-medium text-font">Ordem de
                            Exibição</label>
                        <input type="number" id="create_permission_sort_order" name="sort_order" min="0"
                            class="mt-1 block w-full px-3 py-2 border border-font/20 rounded-lg shadow-sm focus:outline-none focus:ring-primary focus:border-primary bg-light text-font"
                            placeholder="0">
                    </div>

                    <!-- Status -->
                    <div class="flex items-center">
                        <input type="checkbox" id="create_permission_is_active" name="is_active" value="1" checked
                            class="h-4 w-4 text-primary focus:ring-primary border-font/30 rounded">
                        <label for="create_permission_is_active" class="ml-2 block text-sm text-font">
                            Permissão ativa
                        </label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-font/10 mt-6">
                    <button type="button" @click="closeCreatePermissionModal()"
                        class="px-4 py-2 text-sm font-medium text-font bg-light border border-font/20 rounded-lg hover:bg-bg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-light bg-primary border border-transparent rounded-lg hover:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Criar Permissão
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Permission Modal -->
<div x-show="showEditPermissionModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">

    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-dark/50 transition-opacity" @click="closeEditPermissionModal()"></div>

        <!-- Modal panel -->
        <div x-show="showEditPermissionModal" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="inline-block align-bottom bg-light rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">

            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium text-font flex items-center space-x-2">
                    <svg class="w-5 h-5 text-link" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    <span>Editar Permissão</span>
                </h3>
                <button @click="closeEditPermissionModal()" class="text-font/40 hover:text-font/60">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <form :action="`/admin/permissions/${editPermissionId}`" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <!-- Nome -->
                    <div>
                        <label for="edit_permission_name" class="block text-sm font-medium text-font">Nome da
                            Permissão</label>
                        <input type="text" id="edit_permission_name" name="name" x-model="editPermissionName"
                            x-ref="editPermissionNameInput"
                            class="mt-1 block w-full px-3 py-2 border border-font/20 rounded-lg shadow-sm focus:outline-none focus:ring-primary focus:border-primary bg-light text-font"
                            required>
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="edit_permission_slug" class="block text-sm font-medium text-font">Slug</label>
                        <input type="text" id="edit_permission_slug" name="slug" x-model="editPermissionSlug"
                            class="mt-1 block w-full px-3 py-2 border border-font/20 rounded-lg shadow-sm focus:outline-none focus:ring-primary focus:border-primary bg-light text-font"
                            pattern="[a-z0-9._-]+" required>
                        <p class="mt-1 text-xs text-font/50">Use apenas letras minúsculas, números, pontos, hífens e
                            underscores</p>
                    </div>

                    <!-- Descrição -->
                    <div>
                        <label for="edit_permission_description" class="block text-sm font-medium text-font">Descrição
                            (opcional)</label>
                        <textarea id="edit_permission_description" name="description" rows="3" x-model="editPermissionDescription"
                            class="mt-1 block w-full px-3 py-2 border border-font/20 rounded-lg shadow-sm focus:outline-none focus:ring-primary focus:border-primary bg-light text-font"></textarea>
                    </div>

                    <!-- Grupo -->
                    <div>
                        <label for="edit_permission_group"
                            class="block text-sm font-medium text-font">Grupo/Módulo</label>
                        <input type="text" id="edit_permission_group" name="group"
                            x-model="editPermissionGroup"
                            class="mt-1 block w-full px-3 py-2 border border-font/20 rounded-lg shadow-sm focus:outline-none focus:ring-primary focus:border-primary bg-light text-font"
                            required>
                    </div>

                    <!-- Ordem -->
                    <div>
                        <label for="edit_permission_sort_order" class="block text-sm font-medium text-font">Ordem de
                            Exibição</label>
                        <input type="number" id="edit_permission_sort_order" name="sort_order" min="0"
                            x-model="editPermissionSortOrder"
                            class="mt-1 block w-full px-3 py-2 border border-font/20 rounded-lg shadow-sm focus:outline-none focus:ring-primary focus:border-primary bg-light text-font">
                    </div>

                    <!-- Status -->
                    <div class="flex items-center">
                        <input type="checkbox" id="edit_permission_is_active" name="is_active" value="1"
                            x-model="editPermissionIsActive"
                            class="h-4 w-4 text-primary focus:ring-primary border-font/30 rounded">
                        <label for="edit_permission_is_active" class="ml-2 block text-sm text-font">
                            Permissão ativa
                        </label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-font/10 mt-6">
                    <button type="button" @click="closeEditPermissionModal()"
                        class="px-4 py-2 text-sm font-medium text-font bg-light border border-font/20 rounded-lg hover:bg-bg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-light bg-link border border-transparent rounded-lg hover:bg-link-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-link">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Permission Modal -->
<div x-show="showDeletePermissionModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">

    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-dark/50 transition-opacity" @click="closeDeletePermissionModal()"></div>

        <!-- Modal panel -->
        <div x-show="showDeletePermissionModal" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="inline-block align-bottom bg-light rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">

            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium text-font flex items-center space-x-2">
                    <svg class="w-5 h-5 text-danger" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                    <span>Excluir Permissão</span>
                </h3>
                <button @click="closeDeletePermissionModal()" class="text-font/40 hover:text-font/60">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="mb-6">
                <div class="bg-danger/5 border border-danger/20 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-danger" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-danger">Atenção!</h3>
                            <div class="mt-2 text-sm text-danger/80">
                                <p>Você está prestes a excluir a permissão <strong x-text="deletePermissionName"></strong>.</p>
                                <p class="mt-1">Esta ação não pode ser desfeita e removerá a permissão de todas as funções que a possuem.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-3">
                <button @click="closeDeletePermissionModal()"
                    class="px-4 py-2 text-sm font-medium text-font bg-light border border-font/20 rounded-lg hover:bg-bg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Cancelar
                </button>
                <button @click="confirmDeletePermission()"
                    class="px-4 py-2 text-sm font-medium text-light bg-danger border border-transparent rounded-lg hover:bg-danger-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-danger">
                    Excluir Permissão
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Modal (reutilizar do role-modals) -->
<div x-show="showNotificationModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">

    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-dark/50 transition-opacity" @click="closeNotificationModal()"></div>

        <!-- Modal panel -->
        <div x-show="showNotificationModal" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="inline-block align-bottom bg-light rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">

            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium flex items-center space-x-2"
                    :class="notificationType === 'success' ? 'text-success' : 'text-danger'">
                    <!-- Success Icon -->
                    <svg x-show="notificationType === 'success'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <!-- Error Icon -->
                    <svg x-show="notificationType === 'error'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span x-text="notificationType === 'success' ? 'Sucesso' : 'Erro'"></span>
                </h3>
                <button @click="closeNotificationModal()" class="text-font/40 hover:text-font/60">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="mb-4">
                <p class="text-sm text-font/60" x-text="notificationMessage"></p>
            </div>

            <!-- Button -->
            <div class="flex items-center justify-end pt-4 border-t border-font/10">
                <button @click="closeNotificationModal()"
                    class="px-4 py-2 text-sm font-medium text-light rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2"
                    :class="notificationType === 'success' ? 'bg-success hover:bg-success-hover focus:ring-success' : 'bg-danger hover:bg-danger-hover focus:ring-danger'">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>
