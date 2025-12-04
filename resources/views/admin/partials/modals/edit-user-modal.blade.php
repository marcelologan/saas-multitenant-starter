<!-- Edit User Modal -->
<div x-show="showEditModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">

    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-dark/50 transition-opacity" @click="closeEditModal()"></div>

        <!-- Modal panel -->
        <div x-show="showEditModal" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="inline-block align-bottom bg-light rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">

            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-font flex items-center space-x-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    <span>Editar Usuário</span>
                </h3>
                <button @click="closeEditModal()" class="text-font/40 hover:text-font/60">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <form :action="`/admin/users/${editUserId}`" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Nome -->
                <div>
                    <label for="edit_name" class="block text-sm font-medium text-font mb-1">
                        Nome Completo *
                    </label>
                    <input type="text" id="edit_name" name="name" x-model="editUserName" x-ref="editNameInput"
                        required
                        class="w-full px-3 py-2 border border-font/20 rounded-lg focus:ring-primary focus:border-primary bg-light text-font"
                        placeholder="Digite o nome completo">
                </div>

                <!-- Email -->
                <div>
                    <label for="edit_email" class="block text-sm font-medium text-font mb-1">
                        Email *
                    </label>
                    <input type="email" id="edit_email" name="email" x-model="editUserEmail" required
                        class="w-full px-3 py-2 border border-font/20 rounded-lg focus:ring-primary focus:border-primary bg-light text-font"
                        placeholder="usuario@empresa.com">
                </div>

                <!-- Telefone -->
                <div>
                    <label for="edit_phone" class="block text-sm font-medium text-font mb-1">
                        Telefone
                    </label>
                    <input type="text" id="edit_phone" name="phone" x-model="editUserPhone"
                        class="w-full px-3 py-2 border border-font/20 rounded-lg focus:ring-primary focus:border-primary bg-light text-font"
                        placeholder="(11) 99999-9999">
                </div>

                <!-- Senha (opcional para edição) -->
                <div class="bg-bg p-4 rounded-lg">
                    <h4 class="text-sm font-medium text-font mb-3">Alterar Senha (opcional)</h4>

                    <div class="space-y-3">
                        <div>
                            <label for="edit_password" class="block text-sm font-medium text-font mb-1">
                                Nova Senha
                            </label>
                            <input type="password" id="edit_password" name="password"
                                class="w-full px-3 py-2 border border-font/20 rounded-lg focus:ring-primary focus:border-primary bg-light text-font"
                                placeholder="Deixe em branco para manter a atual">
                        </div>

                        <div>
                            <label for="edit_password_confirmation"
                                class="block text-sm font-medium text-font mb-1">
                                Confirmar Nova Senha
                            </label>
                            <input type="password" id="edit_password_confirmation" name="password_confirmation"
                                class="w-full px-3 py-2 border border-font/20 rounded-lg focus:ring-primary focus:border-primary bg-light text-font"
                                placeholder="Digite a nova senha novamente">
                        </div>
                    </div>
                </div>

                <!-- Função -->
                <div>
                    <label for="edit_role" class="block text-sm font-medium text-font mb-1">
                        Função *
                    </label>
                    <select id="edit_role" name="role_slug" x-model="editUserRole" required
                        class="w-full px-3 py-2 border border-font/20 rounded-lg focus:ring-primary focus:border-primary bg-light text-font">
                        <option value="">Selecione uma função</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->slug }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label for="edit_status" class="block text-sm font-medium text-font mb-1">
                        Status *
                    </label>
                    <select id="edit_status" name="status" x-model="editUserStatus" required
                        class="w-full px-3 py-2 border border-font/20 rounded-lg focus:ring-primary focus:border-primary bg-light text-font">
                        <option value="active">Ativo</option>
                        <option value="inactive">Inativo</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-font/10">
                    <button type="button" @click="closeEditModal()"
                        class="px-4 py-2 text-sm font-medium text-font bg-light border border-font/20 rounded-lg hover:bg-bg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-light bg-primary border border-transparent rounded-lg hover:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>