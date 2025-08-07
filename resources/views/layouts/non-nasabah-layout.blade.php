<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'Bijak Sampah')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('asset/js/global-settings.js') }}"></script>
    <style>
        :root {
            --primary-color: #05445E;
            --secondary-color: #75E6DA;
            --accent-color: #f16728;
            --success-color: #2b8a3e;
            --danger-color: #c0392b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        /* Custom CSS untuk efek gradasi sidebar */
        .sidebar-banksampah-gradient {
            background: linear-gradient(135deg, #75E6DA 0%, #05445E 30%, #05445E 100%);
        }

        /* Ensure seamless connection between topbar and sidebar */
        .topbar-sidebar-seamless {
            background: linear-gradient(135deg, #75E6DA 0%, #05445E 30%, #05445E 100%);
            border: none;
            box-shadow: none;
        }

        /* Style untuk area main content */
        .main-content {
            padding-top: 64px; /* Menyesuaikan dengan tinggi top bar */
            min-height: 100vh;
            width: 100%;
            margin-left: 0;
            margin-right: 0;
            padding-left: 0;
            padding-right: 0;
            padding-bottom: 0;
        }

        /* Hide scrollbar for sidebar */
        .sidebar-banksampah-gradient nav {
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* Internet Explorer 10+ */
        }

        .sidebar-banksampah-gradient nav::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }

        /* Content Container */
        .content-container {
            padding: 0;
            max-width: none;
            margin: 0;
            width: 100%;
        }

        /* Active menu styling */
        .sidebar-nav-item {
            transition: all 0.3s ease;
            border-radius: 8px;
            margin-bottom: 4px;
        }
        
        .sidebar-nav-item.active {
            background: rgba(255, 255, 255, 0.2) !important;
            box-shadow: 0 2px 8px rgba(255, 255, 255, 0.1);
            transform: translateX(4px);
        }
        
        .sidebar-nav-item.active i,
        .sidebar-nav-item.active span {
            color: white !important;
            font-weight: 600;
        }
        
        .sidebar-nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(2px);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .main-content {
                padding-left: 4rem !important;
            }
        }

        @media (min-width: 1200px) {
            .main-content {
                padding-left: 6rem !important;
            }
        }

        @media (max-width: 1199px) {
            .main-content {
                padding-left: 4rem !important;
            }
        }

        /* Full width adjustments */
        @media (max-width: 768px) {
            .content-container {
                padding: 1rem;
            }
        }
    </style>
    @yield('additional-styles')
</head>
<body class="bg-gray-50">

<div class="flex min-h-screen bg-gray-50" x-data="{ sidebarOpen: false, activeMenu: '{{ $activeMenu ?? 'dashboard' }}' }" x-init="activeMenu = '{{ $activeMenu ?? 'dashboard' }}'">
    {{-- Sidebar --}}
    <aside 
        class="fixed top-0 left-0 z-40 flex flex-col py-6 overflow-hidden shadow-2xl group sidebar-banksampah-gradient text-white"
        :class="sidebarOpen ? 'w-[250px]' : 'w-16'"
        style="transition: width 0.3s ease; height: 100vh; background: linear-gradient(135deg, #75E6DA 0%, #05445E 30%, #05445E 100%);"
    >
        <div class="relative flex flex-col h-full w-full px-4">
            
            {{-- Logo Section with Toggle Button --}}
            <div class="flex items-center justify-center mb-8 mt-14" :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                <div class="flex items-center justify-center gap-2" :class="sidebarOpen ? 'flex-1' : ''">
                    <img x-show="sidebarOpen" class="w-32 h-auto" src="{{ asset('asset/img/logo1.png') }}" alt="Logo Penuh">
                    <img x-show="!sidebarOpen" class="w-6 h-6" src="{{ asset('asset/img/logo.png') }}" alt="Logo Kecil">
                    {{-- Toggle Button --}}
                    <button 
                        @click="sidebarOpen = !sidebarOpen"
                        class="p-1 rounded-full bg-white/20 hover:bg-white/30 transition-colors duration-200 text-white"
                        :class="sidebarOpen ? 'rotate-180' : ''"
                        style="transition: transform 0.3s ease;"
                    >
                        <i class="fas fa-chevron-left text-sm"></i>
                    </button>
                </div>
            </div>
            
            {{-- Navigation Menu --}}
            <nav class="flex flex-col gap-2 w-full flex-1">
                <a 
                    href="{{ route('non-nasabah-dashboard') }}" 
                    class="sidebar-nav-item flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :class="activeMenu === 'dashboard' ? 'active' : ''"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'dashboard'"
                >
                    <i class="fas fa-home text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Dashboard</span>
                </a>

                <a 
                    href="{{ route('poin-non-nasabah') }}" 
                    class="sidebar-nav-item flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :class="activeMenu === 'poin' ? 'active' : ''"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'poin'"
                >
                    <i class="fas fa-coins text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Poin Mu</span>
                </a>

                <a 
                    href="{{ route('tokou') }}" 
                    class="sidebar-nav-item flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :class="activeMenu === 'marketplace' ? 'active' : ''"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'marketplace'"
                >
                    <i class="fas fa-store text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Toko</span>
                </a>

                <a 
                    href="{{ route('wishlist') }}" 
                    class="sidebar-nav-item flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :class="activeMenu === 'wishlist' ? 'active' : ''"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'wishlist'"
                >
                    <i class="fas fa-heart text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Wishlist</span>
                </a>

                <a 
                    href="{{ route('riwayat') }}" 
                    class="sidebar-nav-item flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :class="activeMenu === 'riwayat' ? 'active' : ''"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'riwayat'"
                >
                    <i class="fas fa-history text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Riwayat</span>
                </a>

                <a 
                    href="{{ route('settings-non-nasabah') }}" 
                    class="sidebar-nav-item flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :class="activeMenu === 'settings' ? 'active' : ''"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'settings'"
                >
                    <i class="fas fa-cog text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Settings</span>
                </a>
            </nav>

            {{-- Logout Section --}}
            <div class="w-full flex items-center py-3 mt-auto border-t border-white/20">
                <a 
                    href="{{ route('logout') }}" 
                    class="flex items-center p-3 rounded-lg hover:bg-white/10 hover:shadow-sm text-white transition-all duration-200 w-full whitespace-nowrap"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                >
                    <i class="fas fa-sign-out-alt text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Logout</span>
                </a>
            </div>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="main-content" :class="sidebarOpen ? 'pl-24' : 'pl-24'" style="transition: padding-left 0.3s ease; width: 100%; margin-left: 0; margin-right: 0;">
        {{-- Top Header Bar --}}
        <div class="fixed top-0 left-0 right-0 h-12 z-40 flex items-center justify-between px-6 text-white" :style="'padding-left:' + (sidebarOpen ? '16rem' : '4rem') + '; background: linear-gradient(135deg, #75E6DA 0%, #05445E 30%, #05445E 100%);'">
            <h1 class="text-white font-semibold text-lg" style="position: absolute; left: 1.5rem;">BijakSampah</h1>
            <div class="flex items-center gap-4" style="position: absolute; right: 1.5rem;">
                <button onclick="showNotifModal()" class="relative hover:text-white/80 transition-colors">
                    <i class="far fa-bell text-white text-sm"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-medium">2</span>
                </button>
                <button onclick="showSearchModal()" class="focus:outline-none hover:text-white/80 transition-colors">
                    <i class="fas fa-search text-white text-sm"></i>
                </button>
                <div class="flex items-center gap-2">
                    <button onclick="showProfileModal()" class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center border-2 border-gray-300 cursor-pointer hover:border-white/50 transition-colors">
                        <img src="https://ui-avatars.com/api/?name=Non+Nasabah&background=75E6DA&color=05445E" alt="Profile" class="w-full h-full object-cover">
                    </button>
                    <button onclick="showDevelopmentModal('Profile Menu')" class="hover:text-white/80 transition-colors">
                        <i class="fas fa-chevron-down text-white text-xs"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Content Container --}}
        <div class="content-container">
            @yield('content')
        </div>
    </div>
</div>

<script>
    // Common modal functions
    function showNotifModal() {
        alert('Fitur notifikasi sedang dalam pengembangan.');
    }

    function showSearchModal() {
        alert('Fitur pencarian sedang dalam pengembangan.');
    }

    function showProfileModal() {
        alert('Fitur profil sedang dalam pengembangan.');
    }

    function showDevelopmentModal(feature) {
        alert(`Fitur ${feature} sedang dalam pengembangan.`);
    }
</script>

@yield('additional-scripts')

</body>
</html> 