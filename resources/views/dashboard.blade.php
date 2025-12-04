<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-font leading-tight">
                    Dashboard de Produção
                </h2>
                <p class="text-sm text-font/60 mt-1">
                    Visão geral da sua operação têxtil em tempo real
                </p>
            </div>
            <div class="mt-4 sm:mt-0 flex items-center space-x-3">
                <div class="text-sm text-font/50">
                    Última atualização: {{ now()->format('d/m/Y H:i') }}
                </div>
                <button
                    class="bg-primary text-light px-4 py-2 rounded-lg hover:bg-primary-hover transition-colors flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    <span>Exportar Relatório</span>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- KPIs Principais -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Produção Hoje -->
                <div
                    class="bg-light overflow-hidden shadow-lg rounded-2xl border border-font/10 hover:shadow-xl transition-all duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-primary rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-light" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-font/70">Produção Hoje</p>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-success/10 text-success">
                                        +12%
                                    </span>
                                </div>
                                <p class="text-2xl font-bold text-font">1.247</p>
                                <p class="text-xs text-font/50">peças finalizadas</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Eficiência -->
                <div
                    class="bg-light overflow-hidden shadow-lg rounded-2xl border border-font/10 hover:shadow-xl transition-all duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 bg-gradient-secondary rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-light" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-font/70">Eficiência Geral</p>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-success/10 text-success">
                                        +5%
                                    </span>
                                </div>
                                <p class="text-2xl font-bold text-font">87.3%</p>
                                <p class="text-xs text-font/50">meta: 85%</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pedidos Pendentes -->
                <div
                    class="bg-light overflow-hidden shadow-lg rounded-2xl border border-font/10 hover:shadow-xl transition-all duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-warning rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-light" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-font/70">Pedidos Pendentes</p>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-warning/10 text-warning">
                                        23 urgentes
                                    </span>
                                </div>
                                <p class="text-2xl font-bold text-font">156</p>
                                <p class="text-xs text-font/50">R$ 2.8M em valor</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Qualidade -->
                <div
                    class="bg-light overflow-hidden shadow-lg rounded-2xl border border-font/10 hover:shadow-xl transition-all duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-secondary rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-light" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-font/70">Índice Qualidade</p>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-success/10 text-success">
                                        Excelente
                                    </span>
                                </div>
                                <p class="text-2xl font-bold text-font">96.8%</p>
                                <p class="text-xs text-font/50">2.1% rejeição</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos e Tabelas -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Produção por Linha -->
                <div class="lg:col-span-2 bg-light overflow-hidden shadow-lg rounded-2xl border border-font/10">
                    <div class="px-6 py-4 border-b border-font/10">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-font">Produção por Linha de Produção</h3>
                            <div class="flex items-center space-x-2">
                                <select class="text-sm border border-font/20 rounded-lg px-3 py-1 bg-light text-font">
                                    <option>Últimos 7 dias</option>
                                    <option>Últimos 30 dias</option>
                                    <option>Este mês</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <!-- Simulação de gráfico -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-primary rounded-full"></div>
                                    <span class="text-sm font-medium text-font">Linha 1 - Camisetas</span>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="w-48 bg-font/10 rounded-full h-2">
                                        <div class="bg-primary h-2 rounded-full" style="width: 85%"></div>
                                    </div>
                                    <span class="text-sm font-semibold text-font w-16 text-right">1.247 pcs</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-success rounded-full"></div>
                                    <span class="text-sm font-medium text-font">Linha 2 - Calças</span>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="w-48 bg-font/10 rounded-full h-2">
                                        <div class="bg-success h-2 rounded-full" style="width: 72%"></div>
                                    </div>
                                    <span class="text-sm font-semibold text-font w-16 text-right">856 pcs</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-warning rounded-full"></div>
                                    <span class="text-sm font-medium text-font">Linha 3 - Vestidos</span>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="w-48 bg-font/10 rounded-full h-2">
                                        <div class="bg-warning h-2 rounded-full" style="width: 63%"></div>
                                    </div>
                                    <span class="text-sm font-semibold text-font w-16 text-right">432 pcs</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-secondary rounded-full"></div>
                                    <span class="text-sm font-medium text-font">Linha 4 - Jaquetas</span>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="w-48 bg-font/10 rounded-full h-2">
                                        <div class="bg-secondary h-2 rounded-full" style="width: 45%"></div>
                                    </div>
                                    <span class="text-sm font-semibold text-font w-16 text-right">198 pcs</span>
                                </div>
                            </div>
                        </div>

                        <!-- Legenda -->
                        <div class="mt-6 pt-4 border-t border-font/10">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-font/70">Meta diária total: 3.000 peças</span>
                                <span class="font-semibold text-font">Realizado: 2.733 peças (91.1%)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alertas e Notificações -->
                <div class="bg-light overflow-hidden shadow-lg rounded-2xl border border-font/10">
                    <div class="px-6 py-4 border-b border-font/10">
                        <h3 class="text-lg font-semibold text-font">Alertas e Notificações</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Alerta Crítico -->
                            <div class="flex items-start space-x-3 p-3 bg-danger/5 border border-danger/20 rounded-lg">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-danger mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-danger">Estoque Crítico</p>
                                    <p class="text-xs text-danger/70 mt-1">Tecido algodão branco - apenas 2 dias de
                                        estoque</p>
                                </div>
                            </div>

                            <!-- Alerta Atenção -->
                            <div
                                class="flex items-start space-x-3 p-3 bg-warning/5 border border-warning/20 rounded-lg">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-warning mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-warning">Atraso na Produção</p>
                                    <p class="text-xs text-warning/70 mt-1">Pedido #1234 - 2 horas de atraso</p>
                                </div>
                            </div>

                            <!-- Notificação Positiva -->
                            <div
                                class="flex items-start space-x-3 p-3 bg-success/5 border border-success/20 rounded-lg">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-success mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-success">Meta Atingida</p>
                                    <p class="text-xs text-success/70 mt-1">Linha 1 superou meta diária em 12%</p>
                                </div>
                            </div>

                            <!-- Informação -->
                            <div
                                class="flex items-start space-x-3 p-3 bg-primary/5 border border-primary/20 rounded-lg">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-primary mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-primary">Manutenção Programada</p>
                                    <p class="text-xs text-primary/70 mt-1">Máquina overloque #3 - amanhã 14h</p>
                                </div>
                            </div>
                        </div>

                        <!-- Ver Todos -->
                        <div class="mt-4 pt-4 border-t border-font/10">
                            <button
                                class="w-full text-center text-sm text-primary hover:text-primary-hover font-medium">
                                Ver todos os alertas
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pedidos Recentes e Status da Produção -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Pedidos Recentes -->
                <div class="bg-light overflow-hidden shadow-lg rounded-2xl border border-font/10">
                    <div class="px-6 py-4 border-b border-font/10">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-font">Pedidos Recentes</h3>
                            <a href="#" class="text-sm text-primary hover:text-primary-hover font-medium">Ver
                                todos</a>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-font/10">
                            <thead class="bg-bg">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-font/60 uppercase tracking-wider">
                                        Pedido</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-font/60 uppercase tracking-wider">
                                        Cliente</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-font/60 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-font/60 uppercase tracking-wider">
                                        Prazo</th>
                                </tr>
                            </thead>
                            <tbody class="bg-light divide-y divide-font/10">
                                <tr class="hover:bg-bg">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-font">#1245</div>
                                        <div class="text-sm text-font/60">500 camisetas</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-font">Loja Fashion</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-warning/10 text-warning">
                                            Em Produção
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-font">
                                        15/12/2024
                                    </td>
                                </tr>
                                <tr class="hover:bg-bg">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-font">#1244</div>
                                        <div class="text-sm text-font/60">200 vestidos</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-font">Boutique Elegante</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success/10 text-success">
                                            Finalizado
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-font">
                                        12/12/2024
                                    </td>
                                </tr>
                                <tr class="hover:bg-bg">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-font">#1243</div>
                                        <div class="text-sm text-font/60">300 calças</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-font">Mega Store</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-danger/10 text-danger">
                                            Atrasado
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-font">
                                        10/12/2024
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Status das Máquinas -->
                <div class="bg-light overflow-hidden shadow-lg rounded-2xl border border-font/10">
                    <div class="px-6 py-4 border-b border-font/10">
                        <h3 class="text-lg font-semibold text-font">Status das Máquinas</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Máquina 1 -->
                            <div
                                class="flex items-center justify-between p-4 bg-success/5 border border-success/20 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-success rounded-full animate-pulse"></div>
                                    <div>
                                        <p class="text-sm font-medium text-font">Overloque #1</p>
                                        <p class="text-xs text-font/60">Operando - 98% eficiência</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-success">Online</p>
                                    <p class="text-xs text-font/50">8h 23min</p>
                                </div>
                            </div>

                            <!-- Máquina 2 -->
                            <div
                                class="flex items-center justify-between p-4 bg-success/5 border border-success/20 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-success rounded-full animate-pulse"></div>
                                    <div>
                                        <p class="text-sm font-medium text-font">Reta Industrial #2</p>
                                        <p class="text-xs text-font/60">Operando - 95% eficiência</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-success">Online</p>
                                    <p class="text-xs text-font/50">7h 45min</p>
                                </div>
                            </div>

                            <!-- Máquina 3 -->
                            <div
                                class="flex items-center justify-between p-4 bg-warning/5 border border-warning/20 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-warning rounded-full animate-pulse"></div>
                                    <div>
                                        <p class="text-sm font-medium text-font">Galoneira #3</p>
                                        <p class="text-xs text-font/60">Manutenção preventiva</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-warning">Manutenção</p>
                                    <p class="text-xs text-font/50">30min restantes</p>
                                </div>
                            </div>

                            <!-- Máquina 4 -->
                            <div
                                class="flex items-center justify-between p-4 bg-danger/5 border border-danger/20 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-danger rounded-full"></div>
                                    <div>
                                        <p class="text-sm font-medium text-font">Interlock #4</p>
                                        <p class="text-xs text-font/60">Falha no motor - técnico chamado</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-danger">Offline</p>
                                    <p class="text-xs text-font/50">2h 15min</p>
                                </div>
                            </div>
                        </div>

                        <!-- Resumo -->
                        <div class="mt-6 pt-4 border-t border-font/10">
                            <div class="grid grid-cols-3 gap-4 text-center">
                                <div>
                                    <p class="text-2xl font-bold text-success">12</p>
                                    <p class="text-xs text-font/60">Operando</p>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold text-warning">2</p>
                                    <p class="text-xs text-font/60">Manutenção</p>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold text-danger">1</p>
                                    <p class="text-xs text-font/60">Paradas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ações Rápidas -->
            <div class="bg-light overflow-hidden shadow-lg rounded-2xl border border-font/10">
                <div class="px-6 py-4 border-b border-font/10">
                    <h3 class="text-lg font-semibold text-font">Ações Rápidas</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        <!-- Novo Pedido -->
                        <button
                            class="flex flex-col items-center p-4 bg-primary/5 hover:bg-primary/10 border border-primary/20 rounded-xl transition-colors group">
                            <div
                                class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-light" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-font">Novo Pedido</span>
                        </button>

                        <!-- Controle Estoque -->
                        <button
                            class="flex flex-col items-center p-4 bg-success/5 hover:bg-success/10 border border-success/20 rounded-xl transition-colors group">
                            <div
                                class="w-12 h-12 bg-success rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-light" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-font">Estoque</span>
                        </button>

                        <!-- Relatórios -->
                        <button
                            class="flex flex-col items-center p-4 bg-secondary/5 hover:bg-secondary/10 border border-secondary/20 rounded-xl transition-colors group">
                            <div
                                class="w-12 h-12 bg-secondary rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-light" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-font">Relatórios</span>
                        </button>

                        <!-- Qualidade -->
                        <button
                            class="flex flex-col items-center p-4 bg-warning/5 hover:bg-warning/10 border border-warning/20 rounded-xl transition-colors group">
                            <div
                                class="w-12 h-12 bg-warning rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-light" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-font">Qualidade</span>
                        </button>

                        <!-- Funcionários -->
                        <button
                            class="flex flex-col items-center p-4 bg-link/5 hover:bg-link/10 border border-link/20 rounded-xl transition-colors group">
                            <div
                                class="w-12 h-12 bg-link rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-light" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-font">Funcionários</span>
                        </button>

                        <!-- Configurações -->
                        <button
                            class="flex flex-col items-center p-4 bg-dark/5 hover:bg-dark/10 border border-dark/20 rounded-xl transition-colors group">
                            <div
                                class="w-12 h-12 bg-dark rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-light" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-font">Configurações</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts para interatividade -->
    <script>
        // Atualização automática dos dados (simulação)
        setInterval(function() {
            // Simular atualização de dados em tempo real
            const timestamp = document.querySelector('.text-font\/50');
            if (timestamp) {
                timestamp.textContent = 'Última atualização: ' + new Date().toLocaleString('pt-BR');
            }
        }, 30000); // Atualiza a cada 30 segundos

        // Animação dos indicadores
        document.addEventListener('DOMContentLoaded', function() {
            const progressBars = document.querySelectorAll('[style*="width:"]');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.transition = 'width 1s ease-in-out';
                    bar.style.width = width;
                }, 500);
            });
        });
    </script>
</x-app-layout>
