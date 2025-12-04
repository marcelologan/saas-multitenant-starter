// resources/js/admin/permission-manafement.js

function permissionManagement() {
    return {
        // Modal States
        showCreatePermissionModal: false,
        showEditPermissionModal: false,
        showDeletePermissionModal: false,
        showNotificationModal: false,

        // Create Permission Data (NOVAS PROPRIEDADES)
        createPermissionName: '',
        createPermissionSlug: '',
        isCreateSlugEditable: false, // Controla se o slug é editável

        // Edit Permission Data
        editPermissionId: null,
        editPermissionName: '',
        editPermissionSlug: '',
        editPermissionDescription: '',
        editPermissionGroup: '',
        editPermissionSortOrder: 0,
        editPermissionIsActive: true,

        // Delete Permission Data
        deletePermissionId: null,
        deletePermissionName: '',

        // Notification Data
        notificationType: 'success',
        notificationMessage: '',

        // Create Permission Modal
        openCreatePermissionModal() {
            this.showCreatePermissionModal = true;
            // Resetar valores
            this.createPermissionName = '';
            this.createPermissionSlug = '';
            this.isCreateSlugEditable = false;
            
            this.$nextTick(() => {
                this.$refs.createPermissionNameInput?.focus();
            });
        },

        closeCreatePermissionModal() {
            this.showCreatePermissionModal = false;
            // Limpar valores
            this.createPermissionName = '';
            this.createPermissionSlug = '';
            this.isCreateSlugEditable = false;
        },

        // Edit Permission Modal
        openEditPermissionModal(id, name, slug, description, group, sortOrder, isActive) {
            this.editPermissionId = id;
            this.editPermissionName = name;
            this.editPermissionSlug = slug;
            this.editPermissionDescription = description;
            this.editPermissionGroup = group;
            this.editPermissionSortOrder = sortOrder;
            this.editPermissionIsActive = isActive;
            this.showEditPermissionModal = true;

            this.$nextTick(() => {
                this.$refs.editPermissionNameInput?.focus();
            });
        },

        closeEditPermissionModal() {
            this.showEditPermissionModal = false;
            this.resetEditPermissionData();
        },

        resetEditPermissionData() {
            this.editPermissionId = null;
            this.editPermissionName = '';
            this.editPermissionSlug = '';
            this.editPermissionDescription = '';
            this.editPermissionGroup = '';
            this.editPermissionSortOrder = 0;
            this.editPermissionIsActive = true;
        },

        // Delete Permission Modal
        openDeletePermissionModal(id, name) {
            this.deletePermissionId = id;
            this.deletePermissionName = name;
            this.showDeletePermissionModal = true;
        },

        closeDeletePermissionModal() {
            this.showDeletePermissionModal = false;
            this.deletePermissionId = null;
            this.deletePermissionName = '';
        },

        async confirmDeletePermission() {
            console.log('🔴 INICIANDO confirmDeletePermission');

            if (!this.deletePermissionId) {
                console.log('❌ Sem ID para deletar');
                return;
            }

            console.log('🎯 ID para deletar:', this.deletePermissionId);

            try {
                console.log('📡 FAZENDO FETCH...');

                const response = await fetch(`/admin/permissions/${this.deletePermissionId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                console.log('📨 RESPONSE RECEBIDO:');
                console.log('   Status:', response.status);
                console.log('   OK:', response.ok);
                console.log('   URL:', response.url);

                // ⚠️ AQUI PODE ESTAR O PROBLEMA - VAMOS VER O QUE VEM
                let data;
                try {
                    data = await response.json();
                    console.log('📄 DATA RECEBIDO:', data);
                } catch (jsonError) {
                    console.log('❌ ERRO AO PARSEAR JSON:', jsonError);
                    console.log('📄 RESPONSE TEXT:', await response.text());
                    throw new Error('Resposta inválida do servidor');
                }

                if (response.ok && data.success !== false) {
                    console.log('✅ SUCESSO - Fechando modal e mostrando notificação');
                    this.closeDeletePermissionModal();
                    this.showNotification('success', 'Permissão excluída com sucesso!');

                    window.maintainActiveTab('permissions');
                    setTimeout(() => {
                        console.log('🔄 RECARREGANDO PÁGINA...');
                        window.location.reload();
                    }, 1500);
                } else {
                    console.log('❌ RESPONSE NÃO OK - Lançando erro');
                    throw new Error(data.message || 'Erro ao excluir permissão');
                }
            } catch (error) {
                console.log('🚨 ERRO CAPTURADO NO CATCH:');
                console.log('   Error:', error);
                console.log('   Message:', error.message);

                this.closeDeletePermissionModal();
                this.showNotification('error', 'Erro ao excluir permissão: ' + error.message);
            }
        },

        // Notification Modal
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

        // Auto-generate slug from name
        generateSlug(name) {
            return name
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s\-_.]/g, '') // Remove caracteres especiais
                .replace(/\s+/g, '.') // Substitui espaços por pontos
                .replace(/\.+/g, '.') // Remove pontos duplicados
                .replace(/^\.+|\.+$/g, ''); // Remove pontos do início e fim
        },

        // Initialize auto-slug generation
        init() {
            // ✅ MANTENDO A LÓGICA ORIGINAL + NOVA FUNCIONALIDADE
            
            // Observar mudanças no nome para gerar slug automaticamente (NOVO)
            this.$watch('createPermissionName', (value) => {
                if (!this.isCreateSlugEditable && value) {
                    this.createPermissionSlug = this.generateSlug(value);
                }
            });

            // Observar mudanças no checkbox de edição (NOVO)
            this.$watch('isCreateSlugEditable', (isEditable) => {
                if (!isEditable && this.createPermissionName) {
                    // Se desabilitou a edição, regenera o slug
                    this.createPermissionSlug = this.generateSlug(this.createPermissionName);
                }
            });

            // ✅ MANTENDO A LÓGICA ORIGINAL DO DOM
            // Auto-generate slug for create modal (ORIGINAL)
            this.$watch('$refs.createPermissionNameInput?.value', (value) => {
                if (value && this.showCreatePermissionModal) {
                    const slugInput = document.getElementById('create_permission_slug');
                    if (slugInput && !slugInput.value) {
                        slugInput.value = this.generateSlug(value);
                    }
                }
            });

            // Listen for input changes on create name field (ORIGINAL)
            document.addEventListener('input', (e) => {
                if (e.target.id === 'create_permission_name') {
                    const slugInput = document.getElementById('create_permission_slug');
                    if (slugInput && (!slugInput.value || slugInput.dataset.autoGenerated !== 'false')) {
                        slugInput.value = this.generateSlug(e.target.value);
                        slugInput.dataset.autoGenerated = 'true';
                    }
                }

                // Stop auto-generation if user manually edits slug (ORIGINAL)
                if (e.target.id === 'create_permission_slug') {
                    e.target.dataset.autoGenerated = 'false';
                }
            });
        }
    }
}

// Make it globally available
window.permissionManagement = permissionManagement;