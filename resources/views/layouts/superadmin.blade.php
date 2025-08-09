<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="globalTheme()" x-init="init()">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bijak Sampah - Super Admin</title>

    {{-- Font Awesome Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Global Settings (load first) --}}
    <script src="{{ asset('asset/js/global-settings.js') }}"></script>
    
    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
    
    {{-- Theme Manager --}}
    <script src="{{ asset('asset/js/theme-manager.js') }}" defer></script>
    <script src="{{ asset('asset/js/update-themes.js') }}" defer></script>
    
    {{-- Ensure global settings work on all pages --}}
    <script>
        // Ensure global settings are applied to all pages
        document.addEventListener('DOMContentLoaded', function() {
            // Apply global settings when page loads
            if (window.applyGlobalSettings) {
                window.applyGlobalSettings();
            }
            
            // Listen for settings changes
            window.addEventListener('settingsChanged', function(e) {
                console.log('Settings changed on page:', e.detail);
                if (window.applyGlobalSettings) {
                    window.applyGlobalSettings();
                }
            });
            
            // Apply settings again after a short delay to ensure everything is loaded
            setTimeout(function() {
                if (window.applyGlobalSettings) {
                    window.applyGlobalSettings();
                }
            }, 100);
        });
    </script>
    
    {{-- Global Theme Styles --}}
    <style>
        /* Light Theme (Default) */
        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #e2e8f0;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --text-muted: #9ca3af;
            --border-primary: #e5e7eb;
            --border-secondary: #d1d5db;
            --accent-primary: #3b82f6;
            --accent-secondary: #1d4ed8;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
        }

        /* Dark Theme */
        html.dark, body.dark {
            --bg-primary: #1f2937;
            --bg-secondary: #111827;
            --bg-tertiary: #374151;
            --text-primary: #f9fafb;
            --text-secondary: #d1d5db;
            --text-muted: #9ca3af;
            --border-primary: #374151;
            --border-secondary: #4b5563;
            --accent-primary: #60a5fa;
            --accent-secondary: #3b82f6;
            --success: #34d399;
            --warning: #fbbf24;
            --error: #f87171;
        }

        /* Global font size application */
        html, body {
            font-size: 16px; /* Default medium size */
            transition: font-size 0.3s ease;
        }

        /* Apply theme variables with higher specificity */
        body {
            background-color: var(--bg-secondary) !important;
            color: var(--text-primary) !important;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Font size classes */
        .text-xs { font-size: 0.75rem !important; }
        .text-sm { font-size: 0.875rem !important; }
        .text-base { font-size: 1rem !important; }
        .text-lg { font-size: 1.125rem !important; }
        .text-xl { font-size: 1.25rem !important; }
        .text-2xl { font-size: 1.5rem !important; }
        .text-3xl { font-size: 1.875rem !important; }
        .text-4xl { font-size: 2.25rem !important; }
        .text-5xl { font-size: 3rem !important; }
        .text-6xl { font-size: 3.75rem !important; }
        .text-7xl { font-size: 4.5rem !important; }
        .text-8xl { font-size: 6rem !important; }
        .text-9xl { font-size: 8rem !important; }

        /* Ensure proper spacing and layout without sidebar */
        .main-content {
            margin-left: 0 !important;
            padding-left: 0 !important;
            width: 100% !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem !important;
            }
        }
    </style>
</head>
<body class="antialiased">
    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    {{-- Global Theme Toggle Function --}}
    <script>
        function globalTheme() {
            return {
                init() {
                    // Initialize theme based on stored preference or system preference
                    this.applyTheme();
                },
                
                applyTheme() {
                    const theme = localStorage.getItem('theme') || 'light';
                    if (theme === 'dark') {
                        document.documentElement.classList.add('dark');
                        document.body.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        document.body.classList.remove('dark');
                    }
                },
                
                toggleTheme() {
                    const currentTheme = localStorage.getItem('theme') || 'light';
                    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                    
                    localStorage.setItem('theme', newTheme);
                    this.applyTheme();
                    
                    // Dispatch event for other components
                    window.dispatchEvent(new CustomEvent('themeChanged', { 
                        detail: { theme: newTheme } 
                    }));
                }
            }
        }
    </script>
</body>
</html>
