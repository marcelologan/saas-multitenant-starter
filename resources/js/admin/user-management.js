/**
 * User Management - Admin Panel
 * Gerenciamento de usuários com modals
 */

export function userManagement() {
    return {
        // Create Modal
        showCreateModal: false,
        
        // Edit Modal
        showEditModal: false,
        editUserId: null,
        editUserName: '',
        editUserEmail: '',
        editUserPhone: '',
        editUserRole: '',
        editUserStatus: '',
        
        // Delete Modal
        showDeleteModal: false,
        deleteUserId: null,
        deleteUserName: '',

        // Loading states
        isSubmitting: false,

        /**
         * Abrir modal de criação
         */
        openCreateModal() {
            this.showCreateModal = true;
            // Focus no primeiro campo após o modal abrir
            this.$nextTick(() => {
                this.$refs.createNameInput?.focus();
            });
        },

        /**
         * Fechar modal de criação
         */
        closeCreateModal() {
            this.showCreateModal = false;
            // Reset form se necessário
            this.resetCreateForm();
        },

        /**
         * Abrir modal de edição
         */
        openEditModal(id, name, email, phone, role, status) {
            this.editUserId = id;
            this.editUserName = name;
            this.editUserEmail = email;
            this.editUserPhone = phone || '';
            this.editUserRole = role;
            this.editUserStatus = status;
            this.showEditModal = true;
            
            // Focus no primeiro campo após o modal abrir
            this.$nextTick(() => {
                this.$refs.editNameInput?.focus();
            });
        },

        /**
         * Fechar modal de edição
         */
        closeEditModal() {
            this.showEditModal = false;
            this.resetEditForm();
        },

        /**
         * Abrir modal de exclusão
         */
        openDeleteModal(id, name) {
            this.deleteUserId = id;
            this.deleteUserName = name;
            this.showDeleteModal = true;
        },

        /**
         * Fechar modal de exclusão
         */
        closeDeleteModal() {
            this.showDeleteModal = false;
            this.deleteUserId = null;
            this.deleteUserName = '';
        },

        /**
         * Reset formulário de criação
         */
        resetCreateForm() {
            // Se você quiser limpar campos específicos
        },

        /**
         * Reset formulário de edição
         */
        resetEditForm() {
            this.editUserId = null;
            this.editUserName = '';
            this.editUserEmail = '';
            this.editUserPhone = '';
            this.editUserRole = '';
            this.editUserStatus = '';
        },

        /**
         * Confirmar exclusão
         */
        confirmDelete() {
            if (this.deleteUserId) {
                // Criar form dinamicamente e submeter
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/users/${this.deleteUserId}`;
                
                // CSRF Token
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
                form.appendChild(csrfInput);
                
                // Method DELETE
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        },

        /**
         * Validação simples de email
         */
        isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        },

        /**
         * Escape para fechar modals
         */
        init() {
            // Listener para ESC key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    if (this.showCreateModal) this.closeCreateModal();
                    if (this.showEditModal) this.closeEditModal();
                    if (this.showDeleteModal) this.closeDeleteModal();
                }
            });
        }
    }
}

// Disponibilizar globalmente para Alpine.js
window.userManagement = userManagement;