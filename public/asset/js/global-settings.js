// Global Settings Management for Bijak Sampah Application
// This file should be included in all pages to ensure consistent settings across the app

(function() {
    'use strict';

    // Global settings object with default values
    window.globalSettings = {
        theme: localStorage.getItem('theme') || 'light',
        language: localStorage.getItem('language') || 'id',
        fontSize: localStorage.getItem('fontSize') || 'medium'
    };

    // Apply global settings function
    function applyGlobalSettings() {
        try {
            const settings = window.globalSettings;
            
            // Apply theme
            if (settings.theme === 'dark') {
                document.body.classList.add('dark');
                document.documentElement.classList.add('dark');
                document.documentElement.setAttribute('data-theme', 'dark');
                console.log('Dark theme applied');
            } else if (settings.theme === 'auto') {
                // Auto theme based on system preference
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (prefersDark) {
                    document.body.classList.add('dark');
                    document.documentElement.classList.add('dark');
                    document.documentElement.setAttribute('data-theme', 'dark');
                } else {
                    document.body.classList.remove('dark');
                    document.documentElement.classList.remove('dark');
                    document.documentElement.setAttribute('data-theme', 'light');
                }
                console.log('Auto theme applied:', prefersDark ? 'dark' : 'light');
            } else {
                // Light theme
                document.body.classList.remove('dark');
                document.documentElement.classList.remove('dark');
                document.documentElement.setAttribute('data-theme', 'light');
                console.log('Light theme applied');
            }
            
            // Apply font size using data attribute
            const fontSizeMap = {
                'small': '14px',
                'medium': '16px',
                'large': '18px'
            };
            const fontSize = fontSizeMap[settings.fontSize] || '16px';
            document.documentElement.setAttribute('data-font-size', settings.fontSize);
            // Don't apply font-size directly to body/html to avoid layout issues
            console.log('Font size applied using data-font-size:', settings.fontSize);
            
            // Apply language
            if (settings.language) {
                document.documentElement.lang = settings.language;
                // Store language preference for server-side processing
                localStorage.setItem('app_language', settings.language);
                console.log('Language applied:', settings.language);
            }
            
            console.log('Global settings applied successfully:', settings);
        } catch (error) {
            console.error('Error applying global settings:', error);
        }
    }

    // Save settings to localStorage and apply globally
    function saveSettings(key, value) {
        try {
            window.globalSettings[key] = value;
            localStorage.setItem(key, value);
            
            // Apply settings immediately
            applyGlobalSettings();
            
            // Dispatch custom event for other pages to listen to
            window.dispatchEvent(new CustomEvent('settingsChanged', {
                detail: { key, value }
            }));
            
            console.log('Setting saved successfully:', key, value);
        } catch (error) {
            console.error('Error saving setting:', error);
        }
    }

    // Initialize settings when DOM is loaded
    function initializeSettings() {
        try {
            // Apply initial settings
            applyGlobalSettings();
            
            // Listen for settings changes from other pages
            window.addEventListener('settingsChanged', function(e) {
                console.log('Settings changed event received:', e.detail);
                applyGlobalSettings();
            });

            // Listen for system theme changes (for auto theme)
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
                if (window.globalSettings.theme === 'auto') {
                    console.log('System theme changed, reapplying auto theme');
                    applyGlobalSettings();
                }
            });

            // Expose functions globally
            window.applyGlobalSettings = applyGlobalSettings;
            window.saveSettings = saveSettings;
            
            // Also expose a function to get current settings
            window.getGlobalSettings = function() {
                return window.globalSettings;
            };
            
            console.log('Global settings initialized successfully');
        } catch (error) {
            console.error('Error initializing global settings:', error);
        }
    }

    // Initialize immediately
    initializeSettings();
    
    // Also initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeSettings);
    } else {
        // DOM is already loaded, initialize again to ensure it works
        setTimeout(initializeSettings, 100);
    }

    // Also initialize after a short delay to ensure all other scripts are loaded
    setTimeout(initializeSettings, 500);
    setTimeout(initializeSettings, 1000);

})(); 