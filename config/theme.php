<?php
// config/theme.php

return [
    /*
    |--------------------------------------------------------------------------
    | Theme Configuration
    |--------------------------------------------------------------------------
    |
    | Define as cores principais do sistema. Altere estas cores para
    | customizar completamente a aparência do template para diferentes
    | setores/projetos.
    |
    */

    // Cores Principais
    'primary' => env('THEME_PRIMARY', '#6366f1'),           // Cor principal (botões, links)
    'primary_hover' => env('THEME_PRIMARY_HOVER', '#4f46e5'), // Hover da cor principal
    'primary_light' => env('THEME_PRIMARY_LIGHT', '#e0e7ff'), // Versão clara
    'primary_dark' => env('THEME_PRIMARY_DARK', '#3730a3'),   // Versão escura

    // Cores Secundárias
    'secondary' => env('THEME_SECONDARY', '#64748b'),        // Cor secundária
    'secondary_hover' => env('THEME_SECONDARY_HOVER', '#475569'),
    'secondary_light' => env('THEME_SECONDARY_LIGHT', '#f1f5f9'),
    'secondary_dark' => env('THEME_SECONDARY_DARK', '#334155'),

    // Cor de Destaque
    'accent' => env('THEME_ACCENT', '#d4af37'),              // Cor de destaque/accent
    'accent_hover' => env('THEME_ACCENT_HOVER', '#b8941f'),
    'accent_light' => env('THEME_ACCENT_LIGHT', '#fef3c7'),
    'accent_dark' => env('THEME_ACCENT_DARK', '#92400e'),

    // Cores de Status (podem ser mantidas padrão ou customizadas)
    'success' => env('THEME_SUCCESS', '#10b981'),
    'success_hover' => env('THEME_SUCCESS_HOVER', '#059669'),
    'success_light' => env('THEME_SUCCESS_LIGHT', '#d1fae5'),
    'success_dark' => env('THEME_SUCCESS_DARK', '#047857'),

    'warning' => env('THEME_WARNING', '#f59e0b'),
    'warning_hover' => env('THEME_WARNING_HOVER', '#d97706'),
    'warning_light' => env('THEME_WARNING_LIGHT', '#fef3c7'),
    'warning_dark' => env('THEME_WARNING_DARK', '#92400e'),

    'danger' => env('THEME_DANGER', '#ef4444'),
    'danger_hover' => env('THEME_DANGER_HOVER', '#dc2626'),
    'danger_light' => env('THEME_DANGER_LIGHT', '#fee2e2'),
    'danger_dark' => env('THEME_DANGER_DARK', '#b91c1c'),

    'info' => env('THEME_INFO', '#3b82f6'),
    'info_hover' => env('THEME_INFO_HOVER', '#2563eb'),
    'info_light' => env('THEME_INFO_LIGHT', '#dbeafe'),
    'info_dark' => env('THEME_INFO_DARK', '#1d4ed8'),

    // Cores Neutras (geralmente mantidas)
    'white' => '#ffffff',
    'black' => '#000000',
    'gray_50' => '#f8fafc',
    'gray_100' => '#f1f5f9',
    'gray_200' => '#e2e8f0',
    'gray_300' => '#cbd5e1',
    'gray_400' => '#94a3b8',
    'gray_500' => '#64748b',
    'gray_600' => '#475569',
    'gray_700' => '#334155',
    'gray_800' => '#1e293b',
    'gray_900' => '#0f172a',

    /*
    |--------------------------------------------------------------------------
    | Gradientes
    |--------------------------------------------------------------------------
    |
    | Gradientes gerados automaticamente baseados nas cores principais
    |
    */
    'gradients' => [
        'primary' => 'linear-gradient(135deg, {primary} 0%, {primary_dark} 100%)',
        'hero' => 'linear-gradient(135deg, {primary} 0%, {accent} 100%)',
        'card' => 'linear-gradient(145deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%)',
    ],

    /*
    |--------------------------------------------------------------------------
    | Sombras
    |--------------------------------------------------------------------------
    |
    | Definições de sombras para consistência visual
    |
    */
    'shadows' => [
        'sm' => '0 1px 2px 0 rgb(0 0 0 / 0.05)',
        'default' => '0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1)',
        'md' => '0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)',
        'lg' => '0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)',
        'xl' => '0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1)',
    ],

    /*
    |--------------------------------------------------------------------------
    | Presets de Temas
    |--------------------------------------------------------------------------
    |
    | Configurações pré-definidas para diferentes setores
    |
    */
    'presets' => [
        'textile' => [
            'primary' => '#6366f1',
            'secondary' => '#64748b',
            'accent' => '#d4af37',
            'name' => 'Indústria Têxtil',
            'description' => 'Cores elegantes para indústria têxtil'
        ],
        
        'school' => [
            'primary' => '#1e40af',
            'secondary' => '#64748b',
            'accent' => '#10b981',
            'name' => 'Educacional',
            'description' => 'Cores profissionais para instituições de ensino'
        ],
        
        'ecommerce' => [
            'primary' => '#ea580c',
            'secondary' => '#64748b',
            'accent' => '#dc2626',
            'name' => 'E-commerce',
            'description' => 'Cores vibrantes para vendas online'
        ],
        
        'healthcare' => [
            'primary' => '#0891b2',
            'secondary' => '#64748b',
            'accent' => '#10b981',
            'name' => 'Saúde',
            'description' => 'Cores confiáveis para área da saúde'
        ],
        
        'corporate' => [
            'primary' => '#1e293b',
            'secondary' => '#64748b',
            'accent' => '#3b82f6',
            'name' => 'Corporativo',
            'description' => 'Cores sérias para ambiente corporativo'
        ],
    ],
];