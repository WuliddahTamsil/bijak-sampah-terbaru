// Global Theme Manager
class ThemeManager {
    constructor() {
        this.settings = {
            theme: 'light',
            language: 'id',
            fontSize: 'medium'
        };
        // Don't initialize immediately, wait for DOM
        this.initialized = false;
    }

    init() {
        // Check if DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.initializeTheme());
        } else {
            this.initializeTheme();
        }
    }

    initializeTheme() {
        if (this.initialized) return;
        
        // Load settings from localStorage
        const savedSettings = localStorage.getItem('globalSettings');
        if (savedSettings) {
            this.settings = { ...this.settings, ...JSON.parse(savedSettings) };
        }
        
        this.applyTheme();
        this.applyLanguage();
        this.applyFontSize();
        
        // Listen for settings changes
        window.addEventListener('storage', (e) => {
            if (e.key === 'globalSettings') {
                const newSettings = JSON.parse(e.newValue || '{}');
                this.settings = { ...this.settings, ...newSettings };
                this.applyTheme();
                this.applyLanguage();
                this.applyFontSize();
            }
        });

        this.initialized = true;
        // Debug logging
        console.log('ThemeManager initialized with settings:', this.settings);
    }

    applyTheme() {
        // Check if DOM elements exist
        if (!document.documentElement || !document.body) {
            console.warn('DOM elements not ready, skipping theme application');
            return;
        }

        // Remove existing theme classes
        document.documentElement.classList.remove('dark');
        document.body.classList.remove('dark');
        
        console.log('Applying theme:', this.settings.theme);
        
        if (this.settings.theme === 'dark') {
            document.documentElement.classList.add('dark');
            document.body.classList.add('dark');
            console.log('Dark theme applied to html and body');
        } else if (this.settings.theme === 'auto') {
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark');
                console.log('Auto theme: dark mode detected and applied');
            } else {
                console.log('Auto theme: light mode detected');
            }
        } else {
            console.log('Light theme applied');
        }

        // Force a repaint to ensure CSS variables are applied
        document.body.offsetHeight;
        
        // Update any Alpine.js components that might be listening
        if (window.Alpine) {
            window.Alpine.nextTick(() => {
                // Trigger any Alpine components that need to update
                const event = new CustomEvent('themeChanged', { 
                    detail: { theme: this.settings.theme } 
                });
                window.dispatchEvent(event);
            });
        }
    }

    applyLanguage() {
        if (!document.documentElement) {
            console.warn('document.documentElement not ready, skipping language application');
            return;
        }
        
        // Set HTML lang attribute
        document.documentElement.lang = this.settings.language;
        console.log('Language applied:', this.settings.language);
        
        // Trigger language change event for components that need to update
        const event = new CustomEvent('languageChanged', { 
            detail: { language: this.settings.language } 
        });
        window.dispatchEvent(event);
        
        // Update any Alpine.js components that might be listening
        if (window.Alpine) {
            window.Alpine.nextTick(() => {
                // Trigger Alpine components that need language updates
                const alpineEvent = new CustomEvent('alpineLanguageChanged', { 
                    detail: { language: this.settings.language } 
                });
                window.dispatchEvent(alpineEvent);
            });
        }
    }

    applyFontSize() {
        if (!document.documentElement) {
            console.warn('document.documentElement not ready, skipping font size application');
            return;
        }
        
        const sizes = {
            small: '14px',
            medium: '16px',
            large: '18px'
        };
        
        const fontSize = sizes[this.settings.fontSize] || '16px';
        document.documentElement.style.fontSize = fontSize;
        console.log('Font size applied:', this.settings.fontSize, '(', fontSize, ')');
        
        // Trigger font size change event for components that need to update
        const event = new CustomEvent('fontSizeChanged', { 
            detail: { fontSize: this.settings.fontSize, size: fontSize } 
        });
        window.dispatchEvent(event);
        
        // Update any Alpine.js components that might be listening
        if (window.Alpine) {
            window.Alpine.nextTick(() => {
                // Trigger Alpine components that need font size updates
                const alpineEvent = new CustomEvent('alpineFontSizeChanged', { 
                    detail: { fontSize: this.settings.fontSize, size: fontSize } 
                });
                window.dispatchEvent(alpineEvent);
            });
        }
    }

    updateSettings(newSettings) {
        console.log('Updating settings:', newSettings);
        this.settings = { ...this.settings, ...newSettings };
        
        this.applyTheme();
        this.applyLanguage();
        this.applyFontSize();
        
        // Save to localStorage
        localStorage.setItem('globalSettings', JSON.stringify(this.settings));
        
        // Trigger storage event for other tabs/windows
        window.dispatchEvent(new StorageEvent('storage', {
            key: 'globalSettings',
            newValue: JSON.stringify(this.settings)
        }));

        console.log('Settings updated and saved:', this.settings);
    }

    getSettings() {
        return { ...this.settings };
    }

    // Debug method
    debug() {
        console.log('Current ThemeManager state:');
        console.log('- Settings:', this.settings);
        console.log('- HTML has dark class:', document.documentElement?.classList.contains('dark'));
        console.log('- Body has dark class:', document.body?.classList.contains('dark'));
        console.log('- HTML lang attribute:', document.documentElement?.lang);
        console.log('- HTML font size:', document.documentElement?.style.fontSize);
        console.log('- CSS Variables:');
        console.log('  --bg-primary:', getComputedStyle(document.documentElement).getPropertyValue('--bg-primary'));
        console.log('  --text-primary:', getComputedStyle(document.documentElement).getPropertyValue('--text-primary'));
        console.log('  --sidebar-gradient:', getComputedStyle(document.documentElement).getPropertyValue('--sidebar-gradient'));
    }
}

// Initialize global theme manager when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    window.themeManager = new ThemeManager();
    window.themeManager.init();
    
    // Make it available globally
    window.globalTheme = window.themeManager;
    
    // Add debug method to window for easy access
    window.debugTheme = () => window.themeManager.debug();
});

// Fallback initialization for cases where DOMContentLoaded has already fired
if (document.readyState !== 'loading') {
    window.themeManager = new ThemeManager();
    window.themeManager.init();
    window.globalTheme = window.themeManager;
    window.debugTheme = () => window.themeManager.debug();
} 