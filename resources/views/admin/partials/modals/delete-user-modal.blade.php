<!-- Delete User Modal -->
<div x-show="showDeleteModal" 
     x-transition:enter="ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto" 
     style="display: none;">
    
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-dark/50 transition-opacity" @click="closeDeleteModal()"></div>

        <!-- Modal panel -->
        <div x-show="showDeleteModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block align-bottom bg-light rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full sm:p-6">
            
            <!-- Icon -->
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-danger/10 mb-4">
                <svg class="h-6 w-6 text-danger" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>

            <!-- Content -->
            <div class="text-center">
                <h3 class="text-lg font-medium text-font mb-2">
                    Excluir Usuário
                </h3>
                <p class="text-sm text-font/60 mb-6">
                    Tem certeza que deseja excluir o usuário 
                    <span class="font-semibold text-font" x-text="deleteUserName"></span>?
                    Esta ação não pode ser desfeita.
                </p>

                <!-- Warning -->
                <div class="bg-warning/5 border border-warning/20 rounded-lg p-3 mb-6">
                    <div class="flex">
                        <svg class="h-5 w-5 text-warning mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div class="text-left">
                            <p class="text-sm text-warning font-medium">Atenção!</p>
                            <p class="text-xs text-warning/80 mt-1">
                                Todos os dados relacionados a este usuário serão permanentemente removidos.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-center space-x-3">
                    <button type="button" 
                            @click="closeDeleteModal()"
                            class="px-4 py-2 text-sm font-medium text-font bg-light border border-font/20 rounded-lg hover:bg-bg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Cancelar
                    </button>
                    <button type="button"
                            @click="confirmDelete()"
                            class="px-4 py-2 text-sm font-medium text-light bg-danger border border-transparent rounded-lg hover:bg-danger-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-danger">
                        Sim, Excluir
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>