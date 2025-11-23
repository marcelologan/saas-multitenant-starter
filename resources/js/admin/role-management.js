/**
 * Role Management - Admin Panel
 * Gerenciamento de roles e permissões
 */

export function roleManagement() {
    return {
        // Create Role Modal
        showCreateRoleModal: false,

        // Edit Role Modal
        showEditRoleModal: false,
        editRoleId: null,
        editRoleName: '',
        editRoleDescription: '',
        editRoleSortOrder: '',
        editRoleIsActive: true,

        // Delete Role Modal
        showDeleteRoleModal: false,
        deleteRoleId: null,
        deleteRoleName: '',

        // ✅ PERMISSIONS MODAL - NOMES CONSISTENTES:
        showRolePermissionsModal: false,
        rolePermissionsName: '',
        permissionsRoleId: null,

        // Permissions Modal (as outras que já existem)
        loadingPermissions: false,
        savingPermissions: false,
        permissionsData: null,
        selectedPermissions: [],

        // Notification Modal
        showNotificationModal: false,
        notificationType: 'success',
        notificationMessage: '',

        // Loading states
        isSubmitting: false,

        /**
         * ========== CREATE ROLE MODAL ==========
         */
        openCreateRoleModal() {
            this.showCreateRoleModal = true;
            this.$nextTick(() => {
                this.$refs.createRoleNameInput?.focus();
            });
        },

        closeCreateRoleModal() {
            this.showCreateRoleModal = false;
            this.resetCreateRoleForm();
        },

        resetCreateRoleForm() {
            // Form será resetado automaticamente pelo HTML
        },

        /**
         * ========== EDIT ROLE MODAL ==========
         */
        openEditRoleModal(id, name, description, sortOrder, isActive) {
            this.editRoleId = id;
            this.editRoleName = name;
            this.editRoleDescription = description || '';
            this.editRoleSortOrder = sortOrder || '';
            this.editRoleIsActive = isActive;
            this.showEditRoleModal = true;

            this.$nextTick(() => {
                this.$refs.editRoleNameInput?.focus();
            });
        },

        closeEditRoleModal() {
            this.showEditRoleModal = false;
            this.resetEditRoleForm();
        },

        resetEditRoleForm() {
            this.editRoleId = null;
            this.editRoleName = '';
            this.editRoleDescription = '';
            this.editRoleSortOrder = '';
            this.editRoleIsActive = true;
        },

        /**
         * ========== DELETE ROLE MODAL ==========
         */
        openDeleteRoleModal(id, name) {
            this.deleteRoleId = id;
            this.deleteRoleName = name;
            this.showDeleteRoleModal = true;
        },

        closeDeleteRoleModal() {
            this.showDeleteRoleModal = false;
            this.deleteRoleId = null;
            this.deleteRoleName = '';
        },

        confirmDeleteRole() {
            if (this.deleteRoleId) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/roles/${this.deleteRoleId}`;

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
         * ========== PERMISSIONS MODAL ==========
         */
        async openPermissionsModal(roleId, roleName) {
            this.permissionsRoleId = roleId;
            this.rolePermissionsName = roleName;  // ✅ CORRIGIDO
            this.showRolePermissionsModal = true; // ✅ CORRIGIDO
            this.loadingPermissions = true;

            // Aguardar o modal aparecer e então carregar as permissões
            await this.$nextTick();
            this.loadRolePermissions(roleId);
        },

        closePermissionsModal() {
            this.showRolePermissionsModal = false; // ✅ CORRIGIDO
            this.permissionsRoleId = null;
            this.rolePermissionsName = '';         // ✅ CORRIGIDO
            this.permissionsData = null;
            this.selectedPermissions = [];
            this.loadingPermissions = false;
            this.savingPermissions = false;
        },

        /**
         * Carregar permissões atuais da role
         */
        async loadRolePermissions(roleId) {
            this.loadingPermissions = true;

            try {
                const response = await fetch(`/admin/roles/${roleId}/permissions`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.success) {
                        this.permissionsData = data.permissions;
                        this.selectedPermissions = data.rolePermissions || [];
                    }
                }
            } catch (error) {
                console.error('Erro ao carregar permissões:', error);
                alert('Erro ao carregar permissões');
            } finally {
                this.loadingPermissions = false;
            }
        },

        /**
         * Marcar checkboxes das permissões
         */
        setPermissionCheckboxes(permissionIds) {
            const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = permissionIds.includes(parseInt(checkbox.value));
            });
        },

        /**
         * Limpar todos os checkboxes
         */
        clearPermissionCheckboxes() {
            const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        },

        /**
         * Toggle todas as permissões de um módulo
         */
        toggleModulePermissions(module) {
            const moduleCheckboxes = document.querySelectorAll(`input[data-module="${module}"]`);
            const allChecked = Array.from(moduleCheckboxes).every(cb => cb.checked);

            moduleCheckboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
            });
        },

        /**
         * Toggle todas as permissões de um grupo
         */
        toggleGroupPermissions(group) {
            if (!this.permissionsData || !this.permissionsData[group]) {
                return;
            }

            const groupPermissions = this.permissionsData[group];
            const groupPermissionIds = groupPermissions.map(p => p.id);

            // Verificar se todos estão selecionados
            const allSelected = groupPermissionIds.every(id =>
                this.selectedPermissions.includes(id)
            );

            if (allSelected) {
                // Desmarcar todos do grupo
                this.selectedPermissions = this.selectedPermissions.filter(id =>
                    !groupPermissionIds.includes(id)
                );
            } else {
                // Marcar todos do grupo
                groupPermissionIds.forEach(id => {
                    if (!this.selectedPermissions.includes(id)) {
                        this.selectedPermissions.push(id);
                    }
                });
            }
        },

        // Métodos de notificação
        showNotification(type, message) {
            this.notificationType = type;
            this.notificationMessage = message;
            this.showNotificationModal = true;
        },

        closeNotificationModal() {
            this.showNotificationModal = false;
            this.notificationType = 'success';
            this.notificationMessage = '';
        },

        // Salvar permissões
        async savePermissions() {
            this.savingPermissions = true;

            try {
                const response = await fetch(`/admin/roles/${this.permissionsRoleId}/permissions`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        permissions: this.selectedPermissions
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.closePermissionsModal();
                    this.showNotification('success', 'Permissões atualizadas com sucesso!');

                    // Manter aba ativa e recarregar
                    window.maintainActiveTab('roles');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Erro ao salvar permissões');
                }
            } catch (error) {
                console.error('Erro ao salvar permissões:', error);
                this.showNotification('error', 'Erro ao salvar permissões: ' + error.message);
            } finally {
                this.savingPermissions = false;
            }
        },

        // Método para recarregar apenas a seção de roles
        async reloadRolesSection() {
            try {
                const response = await fetch(window.location.href, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.ok) {
                    // Por enquanto, recarregar a página mas manter a aba
                    const url = new URL(window.location);
                    url.hash = '#roles';
                    window.location.href = url.toString();
                    window.location.reload();
                }
            } catch (error) {
                console.error('Erro ao recarregar seção:', error);
                window.location.reload();
            }
        },

        /**
         * ========== INICIALIZAÇÃO ==========
         */
        init() {
            // Listener para ESC key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    if (this.showCreateRoleModal) this.closeCreateRoleModal();
                    if (this.showEditRoleModal) this.closeEditRoleModal();
                    if (this.showDeleteRoleModal) this.closeDeleteRoleModal();
                    if (this.showRolePermissionsModal) this.closePermissionsModal(); // ✅ CORRIGIDO
                }
            });
        }
    }
}

// Disponibilizar globalmente para Alpine.js
window.roleManagement = roleManagement;