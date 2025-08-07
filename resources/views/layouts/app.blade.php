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
        
        /* Theme-specific font sizes */
        html[data-theme="light"] body {
            font-size: 16px;
        }
        
        html[data-theme="dark"] body {
            font-size: 16px;
        }
        
        /* Font size classes */
        .text-small { font-size: 14px !important; }
        .text-medium { font-size: 16px !important; }
        .text-large { font-size: 18px !important; }
        
        /* Protect specific elements from font size changes */
        .text-highlight,
        .text-highlight * {
            font-size: inherit !important;
        }
        
        /* Apply font size only to specific text elements, not layout */
        html[data-font-size="small"] .text-content,
        html[data-font-size="small"] .text-content h1:not([class*="text-"]),
        html[data-font-size="small"] .text-content h2:not([class*="text-"]),
        html[data-font-size="small"] .text-content h3:not([class*="text-"]),
        html[data-font-size="small"] .text-content h4:not([class*="text-"]),
        html[data-font-size="small"] .text-content h5:not([class*="text-"]),
        html[data-font-size="small"] .text-content h6:not([class*="text-"]),
        html[data-font-size="small"] .text-content p,
        html[data-font-size="small"] .text-content span:not(.text-highlight),
        html[data-font-size="small"] .text-content label,
        html[data-font-size="small"] .text-content button,
        html[data-font-size="small"] .text-content a,
        html[data-font-size="small"] .text-content li {
            font-size: 14px !important;
        }
        
        html[data-font-size="medium"] .text-content,
        html[data-font-size="medium"] .text-content h1:not([class*="text-"]),
        html[data-font-size="medium"] .text-content h2:not([class*="text-"]),
        html[data-font-size="medium"] .text-content h3:not([class*="text-"]),
        html[data-font-size="medium"] .text-content h4:not([class*="text-"]),
        html[data-font-size="medium"] .text-content h5:not([class*="text-"]),
        html[data-font-size="medium"] .text-content h6:not([class*="text-"]),
        html[data-font-size="medium"] .text-content p,
        html[data-font-size="medium"] .text-content span:not(.text-highlight),
        html[data-font-size="medium"] .text-content label,
        html[data-font-size="medium"] .text-content button,
        html[data-font-size="medium"] .text-content a,
        html[data-font-size="medium"] .text-content li {
            font-size: 16px !important;
        }
        
        html[data-font-size="large"] .text-content,
        html[data-font-size="large"] .text-content h1:not([class*="text-"]),
        html[data-font-size="large"] .text-content h2:not([class*="text-"]),
        html[data-font-size="large"] .text-content h3:not([class*="text-"]),
        html[data-font-size="large"] .text-content h4:not([class*="text-"]),
        html[data-font-size="large"] .text-content h5:not([class*="text-"]),
        html[data-font-size="large"] .text-content h6:not([class*="text-"]),
        html[data-font-size="large"] .text-content p,
        html[data-font-size="large"] .text-content span:not(.text-highlight),
        html[data-font-size="large"] .text-content label,
        html[data-font-size="large"] .text-content button,
        html[data-font-size="large"] .text-content a,
        html[data-font-size="large"] .text-content li {
            font-size: 18px !important;
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
    <div class="flex min-h-screen bg-gray-50" x-data="{ sidebarOpen: false }">
        {{-- Sidebar Overlay --}}
        <div class="sidebar-overlay" :class="{ 'active': sidebarOpen }" @click="sidebarOpen = false"></div>

        {{-- Sidebar --}}
        <aside 
            x-data="{ open: false, active: '' }"
            x-ref="sidebar"
            @mouseenter="open = true; $root.sidebarOpen = true"
            @mouseleave="open = false; $root.sidebarOpen = false"
            class="fixed top-0 left-0 z-50 flex flex-col py-6 sidebar-hover overflow-hidden shadow-2xl group sidebar-gradient"
            :class="open ? 'w-64' : 'w-16'"
            style="transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); margin-top: 48px; height: calc(100vh - 48px);"
        >
            <div class="relative flex flex-col h-full w-full px-4">
                {{-- Logo Section --}}
                <div class="flex items-center justify-center mb-8 mt-2 sidebar-logo">
                    <img x-show="open" class="w-32 h-auto" src="{{ asset('asset/img/logo1.png') }}" alt="Logo Penuh">
                    <img x-show="!open" class="w-6 h-6" src="{{ asset('asset/img/logo.png') }}" alt="Logo Ikon">
                </div>
                
                {{-- Navigation Menu --}}
                <nav class="flex flex-col gap-2 w-full flex-1">
                    {{-- Dashboard Link --}}
                    <a href="{{ route('nasabahdashboard') }}" class="flex items-center gap-3 p-3 font-medium sidebar-nav-item whitespace-nowrap w-full" :class="open ? (active === 'dashboard' ? 'active text-white' : 'text-white') : (active === 'dashboard' ? 'active text-white justify-center' : 'text-white justify-center')">
                        <i class="fas fa-home text-lg"></i>
                        <span x-show="open" class="text-sm font-medium">Dashboard</span>
                    </a>
                    
                    {{-- Komunitas Link --}}
                    <a href="{{ route('nasabahkomunitas') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'komunitas' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'komunitas' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                        <i class="fas fa-users text-lg"></i>
                        <span x-show="open" class="text-sm font-medium">Komunitas</span>
                    </a>
                    
                    {{-- Penjemputan Sampah Link --}}
                    <a href="{{ route('sampahnasabah') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'penjemputan' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'penjemputan' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                        <i class="fas fa-trash-alt text-lg"></i>
                        <span x-show="open" class="text-sm font-medium">Penjemputan Sampah</span>
                    </a>
                    
                    {{-- Poin Link --}}
                    <a href="{{ route('poin-nasabah') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'poin' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'poin' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                        <i class="fas fa-coins text-lg"></i>
                        <span x-show="open" class="text-sm font-medium">Poin Mu</span>
                    </a>
                    
                    {{-- Riwayat Transaksi Link --}}
                    <a href="{{ route('riwayattransaksinasabah') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'riwayat-transaksi' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'riwayat-transaksi' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                        <i class="fas fa-history text-lg"></i>
                        <span x-show="open" class="text-sm font-medium">Riwayat Transaksi</span>
                    </a>
                    
                    {{-- Toko Link --}}
                    <a href="{{ route('tokon') }}" class="flex items-center gap-3 p-3 font-medium sidebar-nav-item whitespace-nowrap w-full" :class="open ? (active === 'marketplace' ? 'active text-white' : 'text-white') : (active === 'marketplace' ? 'active text-white justify-center' : 'text-white justify-center')">
                        <i class="fas fa-store text-lg"></i>
                        <span x-show="open" class="text-sm font-medium">Toko</span>
                    </a>
                    
                    {{-- Settings Link --}}
                    <a href="{{ route('settingsnasab') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'settings' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'settings' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                        <i class="fas fa-cog text-lg"></i>
                        <span x-show="open" class="text-sm font-medium">Settings</span>
                    </a>
                </nav>
                
                {{-- Logout Section --}}
                <div class="w-full flex items-center py-3 mt-auto">
                    <a href="{{ route('logout') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover text-white hover:text-red-300 transition-all duration-200 w-full whitespace-nowrap" :class="open ? (active === 'logout' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'logout' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                        <i class="fas fa-sign-out-alt text-lg"></i>
                        <span x-show="open" class="text-sm font-medium">Logout</span>
                    </a>
                </div>
            </div>
        </aside>

        <div class="main-content-wrapper" style="width:100%">@yield('content')</div>
    </div>

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