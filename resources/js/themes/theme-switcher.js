// resources/js/themes/theme-switcher.js
class ThemeSwitcher {
    constructor() {
        // ✅ LIMPAR CACHE INVÁLIDO
        const stored = localStorage.getItem('selected-theme');
        if (stored && !['textil'].includes(stored)) {
            localStorage.removeItem('selected-theme');
        }
        
        this.currentTheme = this.getStoredTheme() || 'textil';
        // resources/js/themes/theme-switcher.js - ATUALIZAR:
        this.themes = {
            'textil': {
                '--primary': '#6c5ce7',
                '--primary-hover': '#5a4fcf',
                '--secondary': '#a29bfe',
                '--secondary-hover': '#8b7efe',
                '--font': '#2d3436',
                '--bg': '#dfe6e9',
                '--light': '#ffffff',
                '--dark': '#2d3436',
                '--link': '#0984e3',
                '--link-hover': '#0770c4',
                '--danger': '#d63031',
                '--danger-hover': '#c0281f',
                '--success': '#00b894',
                '--success-hover': '#009a7e',
                '--warning': '#fdcb6e',
                '--warning-hover': '#fcbf49',
                '--gradient-primary': 'linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%)',
                '--gradient-secondary': 'linear-gradient(135deg, #a29bfe 0%, #6c5ce7 100%)'
            }
        };
        this.init();
    }

    init() {
        this.applyTheme(this.currentTheme);
        this.setupEventListeners();
    }

    getStoredTheme() {
        return localStorage.getItem('selected-theme');
    }

    storeTheme(theme) {
        localStorage.setItem('selected-theme', theme);
    }

    applyTheme(theme) {
        const body = document.body;

        // Remove temas anteriores
        body.removeAttribute('data-theme');

        // Aplica novo tema
        if (theme !== 'textil') {
            body.setAttribute('data-theme', theme);
        }

        // ✅ VERIFICAÇÃO ANTES DE INJETAR
        if (this.themes[theme]) {
            this.injectCssVariables(theme);
        } else {
            console.error(`Tema '${theme}' não encontrado. Usando tema padrão.`);
            this.injectCssVariables('textil');
        }

        this.currentTheme = theme;
        this.storeTheme(theme);

        // Dispara evento customizado
        window.dispatchEvent(new CustomEvent('themeChanged', {
            detail: { theme: theme }
        }));
    }

    injectCssVariables(theme) {
        const variables = this.themes[theme];
        const root = document.documentElement;

        // ✅ VERIFICAÇÃO ADICIONAL
        if (!variables) {
            console.error(`Variáveis do tema '${theme}' não encontradas`);
            return;
        }

        // Aplica cada variável CSS
        Object.entries(variables).forEach(([property, value]) => {
            root.style.setProperty(property, value);
        });

        console.log(`Tema '${theme}' aplicado com sucesso!`);
    }

    switchTheme(theme) {
        this.applyTheme(theme);
    }

    setupEventListeners() {
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-theme-switch]')) {
                const theme = e.target.getAttribute('data-theme-switch');
                this.switchTheme(theme);
            }
        });
    }

    getCurrentTheme() {
        return this.currentTheme;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    window.themeSwitcher = new ThemeSwitcher();
});

export default ThemeSwitcher;