<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="globalTheme()" x-init="init()">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bijak Sampah</title>

    {{-- Font Awesome Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
    
    {{-- Theme Manager --}}
    <script src="{{ asset('asset/js/theme-manager.js') }}" defer></script>
    <script src="{{ asset('asset/js/update-themes.js') }}" defer></script>

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
            --sidebar-gradient: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
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
            --sidebar-gradient: linear-gradient(135deg, #1e293b 0%, #0f172a 63%);
        }

        /* Font Size Variables */
        .text-small { font-size: 14px; }
        .text-medium { font-size: 16px; }
        .text-large { font-size: 18px; }

        /* Apply theme variables with higher specificity */
        body {
            background-color: var(--bg-secondary) !important;
            color: var(--text-primary) !important;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Override Tailwind classes with CSS variables */
        .bg-white { background-color: var(--bg-primary) !important; }
        .bg-gray-50 { background-color: var(--bg-secondary) !important; }
        .bg-gray-100 { background-color: var(--bg-tertiary) !important; }
        
        .text-gray-900 { color: var(--text-primary) !important; }
        .text-gray-600 { color: var(--text-secondary) !important; }
        .text-gray-500 { color: var(--text-muted) !important; }
        
        .border-gray-100 { border-color: var(--border-primary) !important; }
        .border-gray-300 { border-color: var(--border-secondary) !important; }

        /* Settings card dark mode */
        .settings-card {
            background: var(--bg-primary) !important;
            border-color: var(--border-primary) !important;
            color: var(--text-primary) !important;
        }

        /* Sidebar gradient */
        .sidebar-gradient {
            background: var(--sidebar-gradient) !important;
        }

        /* Fixed header gradient */
        .fixed-header {
            background: var(--sidebar-gradient) !important;
        }

        /* Additional dark mode overrides */
        html.dark .bg-white,
        body.dark .bg-white {
            background-color: var(--bg-primary) !important;
        }

        html.dark .text-gray-900,
        body.dark .text-gray-900 {
            color: var(--text-primary) !important;
        }

        html.dark .text-gray-600,
        body.dark .text-gray-600 {
            color: var(--text-secondary) !important;
        }

        html.dark .border-gray-100,
        body.dark .border-gray-100 {
            border-color: var(--border-primary) !important;
        }

        /* Smooth transitions */
        * {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        /* Ensure dark mode classes are applied correctly */
        .dark {
            color-scheme: dark;
        }

        /* Responsive Sidebar Styles (from nasabahdashboard) */
        .sidebar {
            width: 80px;
            background: linear-gradient(135deg, #75E6DA 0%, #05445E 30%, #05445E 100%);
            color: white;
            padding: 20px 0;
            min-height: 100vh;
            transition: width 0.3s ease;
            position: fixed;
            left: 0;
            top: 0;
            overflow: hidden;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .sidebar:hover {
            width: 250px;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .logo-container {
            padding: 0 20px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            height: 60px;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
        }

        .logo img {
            width: 200px;
            height: 200px;
            object-fit: contain;
        }

        .logo-text {
            font-size: 18px;
            font-weight: bold;
            color: white;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar:hover .logo-text {
            opacity: 1;
        }

        .logo span {
            color: #4ADE80;
        }

        .toggle-collapse {
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            padding: 5px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar:hover .toggle-collapse {
            opacity: 1;
        }

        .menu-items {
            list-style: none;
        }

        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s;
            white-space: nowrap;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .menu-item.active {
            background: rgba(255, 255, 255, 0.2);
            border-left: 4px solid #f16728;
        }

        .menu-icon {
            width: 24px;
            height: 24px;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .menu-text {
            font-size: 15px;
            transition: opacity 0.3s ease;
            opacity: 0;
        }

        .sidebar:hover .menu-text {
            opacity: 1;
        }

        .sidebar.collapsed .menu-text {
            opacity: 0;
            width: 0;
        }

        .sidebar.collapsed .logo-text {
            display: none;
        }

        /* Main Content adjustment for responsive sidebar */
        .main-content {
            margin-left: 80px;
            width: calc(100% - 80px);
            padding: 30px;
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        .sidebar:hover ~ .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
        }

        .main-content.collapsed {
            margin-left: 80px;
            width: calc(100% - 80px);
        }
    </style>

</head>
<body class="antialiased" :class="themeClass">
    @yield('content')

    <script>
        // Alpine.js component untuk tema global
        function globalTheme() {
            return {
                themeClass: '',
                
                init() {
                    // Wait for theme manager to be available
                    this.waitForThemeManager();
                    // Initialize responsive sidebar
                    this.initResponsiveSidebar();
                },
                
                waitForThemeManager() {
                    if (window.themeManager && window.themeManager.initialized) {
                        this.updateThemeClass();
                        this.setupListeners();
                    } else {
                        // Wait a bit and try again
                        setTimeout(() => this.waitForThemeManager(), 100);
                    }
                },
                
                setupListeners() {
                    // Listen for theme changes
                    window.addEventListener('storage', (e) => {
                        if (e.key === 'globalSettings') {
                            this.updateThemeClass();
                        }
                    });
                    
                    // Also listen for direct updates
                    if (window.themeManager) {
                        const originalUpdateSettings = window.themeManager.updateSettings;
                        window.themeManager.updateSettings = function(newSettings) {
                            originalUpdateSettings.call(this, newSettings);
                            // Trigger Alpine update
                            setTimeout(() => {
                                if (window.Alpine && window.Alpine.store) {
                                    window.Alpine.store('theme').updateThemeClass();
                                }
                            }, 50);
                        };
                    }
                },
                
                updateThemeClass() {
                    if (!window.themeManager) return;
                    
                    const settings = window.themeManager.getSettings();
                    if (settings.theme === 'dark') {
                        this.themeClass = 'dark';
                    } else if (settings.theme === 'auto') {
                        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                            this.themeClass = 'dark';
                        } else {
                            this.themeClass = '';
                        }
                    } else {
                        this.themeClass = '';
                    }
                },

                // Responsive Sidebar Functions
                initResponsiveSidebar() {
                    const sidebar = document.getElementById('sidebar');
                    const mainContent = document.querySelector('.main-content');
                    const toggleCollapse = document.getElementById('toggleCollapse');
                    
                    if (!sidebar) return;

                    // Responsive Sidebar Hover Behavior
                    let hoverTimeout;

                    sidebar.addEventListener('mouseenter', function() {
                        clearTimeout(hoverTimeout);
                        sidebar.classList.remove('collapsed');
                        if (mainContent) mainContent.classList.remove('collapsed');
                    });

                    sidebar.addEventListener('mouseleave', function() {
                        hoverTimeout = setTimeout(function() {
                            sidebar.classList.add('collapsed');
                            if (mainContent) mainContent.classList.add('collapsed');
                        }, 300); // Small delay to prevent flickering
                    });

                    // Keep toggle button for manual control
                    if (toggleCollapse) {
                        toggleCollapse.addEventListener('click', function() {
                            sidebar.classList.toggle('collapsed');
                            if (mainContent) mainContent.classList.toggle('collapsed');
                            
                            const icon = toggleCollapse.querySelector('i');
                            if (icon) {
                                if (sidebar.classList.contains('collapsed')) {
                                    icon.classList.remove('fa-chevron-left');
                                    icon.classList.add('fa-chevron-right');
                                } else {
                                    icon.classList.remove('fa-chevron-right');
                                    icon.classList.add('fa-chevron-left');
                                }
                            }
                        });
                    }

                    // Initialize collapsed state
                    sidebar.classList.add('collapsed');
                    if (mainContent) mainContent.classList.add('collapsed');
                }
            };
        }
    </script>
</body>
</html>