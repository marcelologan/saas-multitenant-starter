<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight flex items-center space-x-2">
    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
        </path>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
    </svg>
    <span>Configurações da Empresa</span>
</h2>
                <p class="mt-1 text-sm text-gray-600">
                    Gerencie usuários, funções e permissões da sua empresa
                </p>
            </div>
            <div class="text-right">
                <div class="text-sm font-medium text-gray-900">{{ auth()->user()->tenant->trade_name }}</div>
                <div class="text-xs text-gray-500">Última atualização: {{ now()->format('d/m/Y H:i') }}</div>
            </div>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                    class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center space-x-2">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                    class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center space-x-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Tabs Container -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div x-data="{ activeTab: 'users' }" class="min-h-screen">
                    <!-- Tab Navigation -->
                    <div class="border-b border-gray-200 bg-gray-50">
                        <nav class="flex space-x-8 px-6" aria-label="Tabs">
                            <!-- Tab: Usuários -->
                            <button @click="activeTab = 'users'"
                                :class="activeTab === 'users' ? 'border-primary text-primary' :
                                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center space-x-2 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z">
                                    </path>
                                </svg>
                                <span>Usuários</span>
                                <span
                                    :class="activeTab === 'users' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600'"
                                    class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none rounded-full">
                                    {{ $users->count() }}
                                </span>
                            </button>

                            <!-- Tab: Funções -->
                            <button @click="activeTab = 'roles'"
                                :class="activeTab === 'roles' ? 'border-primary text-primary' :
                                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center space-x-2 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                                <span>Funções</span>
                                <span
                                    :class="activeTab === 'roles' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600'"
                                    class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none rounded-full">
                                    3
                                </span>
                            </button>

                            <!-- Tab: Permissões -->
                            <button @click="activeTab = 'permissions'"
                                :class="activeTab === 'permissions' ? 'border-primary text-primary' :
                                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center space-x-2 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                <span>Permissões</span>
                                <span
                                    :class="activeTab === 'permissions' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600'"
                                    class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none rounded-full">
                                    Em breve
                                </span>
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div class="p-6">
                        <!-- Usuários Tab -->
                        <div x-show="activeTab === 'users'" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform translate-y-1"
                            x-transition:enter-end="opacity-100 transform translate-y-0">
                            @include('admin.partials.users-tab', ['users' => $users])
                        </div>

                        <!-- Funções Tab -->
                        <div x-show="activeTab === 'roles'" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform translate-y-1"
                            x-transition:enter-end="opacity-100 transform translate-y-0">
                            @include('admin.partials.roles-tab')
                        </div>

                        <!-- Permissões Tab -->
                        <div x-show="activeTab === 'permissions'" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform translate-y-1"
                            x-transition:enter-end="opacity-100 transform translate-y-0">
                            @include('admin.partials.permissions-tab')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
