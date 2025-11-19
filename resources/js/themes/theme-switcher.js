// Sistema de Controle de Temas
class ThemeSwitcher {
    constructor() {
        this.currentTheme = this.getStoredTheme() || 'flat-ui';
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
        if (theme !== 'flat-ui') {
            body.setAttribute('data-theme', theme);
        }
        
        this.currentTheme = theme;
        this.storeTheme(theme);
        
        // Dispara evento customizado
        window.dispatchEvent(new CustomEvent('themeChanged', { 
            detail: { theme: theme } 
        }));
    }

    switchTheme(theme) {
        this.applyTheme(theme);
    }

    setupEventListeners() {
        // Escuta por mudanças de tema
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

// Inicializa o sistema de temas
document.addEventListener('DOMContentLoaded', () => {
    window.themeSwitcher = new ThemeSwitcher();
});

export default ThemeSwitcher;