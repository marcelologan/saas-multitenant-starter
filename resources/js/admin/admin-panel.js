import { userManagement } from './user-management.js';
import { roleManagement } from './role-management.js'; // ADICIONAR ESTA LINHA

/**
 * Admin Panel - Configurações
 * Gerenciamento completo do painel administrativo
 */
export function adminPanel() {
    return {
        // Tabs
        activeTab: 'users',

        // Combinar funcionalidades
        ...userManagement(),
        ...roleManagement(), // ADICIONAR ESTA LINHA

        /**
         * Alternar entre tabs
         */
        setActiveTab(tab) {
            this.activeTab = tab;
            
            // Fechar todos os modals ao trocar de aba
            this.closeAllModals();
        },

        /**
         * Fechar todos os modals
         */
        closeAllModals() {
            // User modals
            this.closeCreateModal();
            this.closeEditModal();
            this.closeDeleteModal();
            
            // Role modals
            this.closeCreateRoleModal();
            this.closeEditRoleModal();
            this.closeDeleteRoleModal();
            this.closePermissionsModal();
        },

        /**
         * Inicialização
         */
        init() {
            console.log('Admin Panel inicializado');
            
            // Inicializar sub-módulos
            if (typeof this.userManagement === 'function') {
                this.userManagement().init?.();
            }
            if (typeof this.roleManagement === 'function') {
                this.roleManagement().init?.();
            }
        }
    }
}

// Disponibilizar globalmente
window.adminPanel = adminPanel;