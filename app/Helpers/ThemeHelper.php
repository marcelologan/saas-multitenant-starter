<?php
// app/Helpers/ThemeHelper.php

namespace App\Helpers;

class ThemeHelper
{
    /**
     * Gerar CSS com variáveis baseadas na configuração
     */
    public static function generateCssVariables(): string
    {
        $config = config('theme');
        
        $css = ":root {\n";
        
        // Cores principais
        $css .= "  /* Cores Principais */\n";
        $css .= "  --primary: {$config['primary']};\n";
        $css .= "  --primary-hover: {$config['primary_hover']};\n";
        $css .= "  --primary-light: {$config['primary_light']};\n";
        $css .= "  --primary-dark: {$config['primary_dark']};\n\n";
        
        // Cores secundárias
        $css .= "  /* Cores Secundárias */\n";
        $css .= "  --secondary: {$config['secondary']};\n";
        $css .= "  --secondary-hover: {$config['secondary_hover']};\n";
        $css .= "  --secondary-light: {$config['secondary_light']};\n";
        $css .= "  --secondary-dark: {$config['secondary_dark']};\n\n";
        
        // Cor de destaque
        $css .= "  /* Cor de Destaque */\n";
        $css .= "  --accent: {$config['accent']};\n";
        $css .= "  --accent-hover: {$config['accent_hover']};\n";
        $css .= "  --accent-light: {$config['accent_light']};\n";
        $css .= "  --accent-dark: {$config['accent_dark']};\n\n";
        
        // Cores de status
        $css .= "  /* Cores de Status */\n";
        $css .= "  --success: {$config['success']};\n";
        $css .= "  --success-hover: {$config['success_hover']};\n";
        $css .= "  --success-light: {$config['success_light']};\n";
        $css .= "  --success-dark: {$config['success_dark']};\n";
        
        $css .= "  --warning: {$config['warning']};\n";
        $css .= "  --warning-hover: {$config['warning_hover']};\n";
        $css .= "  --warning-light: {$config['warning_light']};\n";
        $css .= "  --warning-dark: {$config['warning_dark']};\n";
        
        $css .= "  --danger: {$config['danger']};\n";
        $css .= "  --danger-hover: {$config['danger_hover']};\n";
        $css .= "  --danger-light: {$config['danger_light']};\n";
        $css .= "  --danger-dark: {$config['danger_dark']};\n";
        
        $css .= "  --info: {$config['info']};\n";
        $css .= "  --info-hover: {$config['info_hover']};\n";
        $css .= "  --info-light: {$config['info_light']};\n";
        $css .= "  --info-dark: {$config['info_dark']};\n\n";
        
        // Cores neutras
        $css .= "  /* Cores Neutras */\n";
        $css .= "  --white: {$config['white']};\n";
        $css .= "  --black: {$config['black']};\n";
        $css .= "  --gray-50: {$config['gray_50']};\n";
        $css .= "  --gray-100: {$config['gray_100']};\n";
        $css .= "  --gray-200: {$config['gray_200']};\n";
        $css .= "  --gray-300: {$config['gray_300']};\n";
        $css .= "  --gray-400: {$config['gray_400']};\n";
        $css .= "  --gray-500: {$config['gray_500']};\n";
        $css .= "  --gray-600: {$config['gray_600']};\n";
        $css .= "  --gray-700: {$config['gray_700']};\n";
        $css .= "  --gray-800: {$config['gray_800']};\n";
        $css .= "  --gray-900: {$config['gray_900']};\n\n";
        
        // Gradientes
        $css .= "  /* Gradientes */\n";
        foreach ($config['gradients'] as $name => $gradient) {
            $processedGradient = str_replace(
                ['{primary}', '{primary_dark}', '{accent}'],
                [$config['primary'], $config['primary_dark'], $config['accent']],
                $gradient
            );
            $css .= "  --gradient-{$name}: {$processedGradient};\n";
        }
        
        // Sombras
        $css .= "\n  /* Sombras */\n";
        foreach ($config['shadows'] as $name => $shadow) {
            $shadowName = $name === 'default' ? 'shadow' : "shadow-{$name}";
            $css .= "  --{$shadowName}: {$shadow};\n";
        }
        
        $css .= "}\n";
        
        return $css;
    }
    
    /**
     * Aplicar preset de tema
     */
    public static function applyPreset(string $presetName): bool
    {
        $presets = config('theme.presets');
        
        if (!isset($presets[$presetName])) {
            return false;
        }
        
        $preset = $presets[$presetName];
        
        // Atualizar .env com as novas cores
        self::updateEnvFile([
            'THEME_PRIMARY' => $preset['primary'],
            'THEME_SECONDARY' => $preset['secondary'],
            'THEME_ACCENT' => $preset['accent'],
        ]);
        
        return true;
    }
    
    /**
     * Atualizar arquivo .env
     */
    private static function updateEnvFile(array $values): void
    {
        $envPath = base_path('.env');
        
        if (!file_exists($envPath)) {
            return;
        }
        
        $envContent = file_get_contents($envPath);
        
        foreach ($values as $key => $value) {
            $pattern = "/^{$key}=.*/m";
            $replacement = "{$key}={$value}";
            
            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, $replacement, $envContent);
            } else {
                $envContent .= "\n{$replacement}";
            }
        }
        
        file_put_contents($envPath, $envContent);
    }
}