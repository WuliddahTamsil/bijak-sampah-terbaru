<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Notifikasi Bank Sampah - Bijak Sampah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
        }

        /* Notification Card Styles */
        .notification-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .notification-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px rgba(0,0,0,0.1);
        }

        .notification-card.unread {
            border-left: 4px solid #10B981;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(255, 255, 255, 0.95) 100%);
        }

        .notification-card.urgent {
            border-left: 4px solid #EF4444;
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.05) 0%, rgba(255, 255, 255, 0.95) 100%);
        }

        .notification-card.info {
            border-left: 4px solid #3B82F6;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(255, 255, 255, 0.95) 100%);
        }

        /* Stats Card */
        .stats-card {
            background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
            color: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* Filter Button */
        .filter-btn {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .filter-btn.active {
            background: linear-gradient(135deg, #75E6DA, #05445E);
            color: white;
            box-shadow: 0 4px 12px rgba(117, 230, 218, 0.3);
        }

        .filter-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Action Button */
        .action-btn {
            background: linear-gradient(135deg, #10B981, #059669);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }

        .action-btn.secondary {
            background: linear-gradient(135deg, #6B7280, #4B5563);
            box-shadow: 0 2px 8px rgba(107, 114, 128, 0.3);
        }

        .action-btn.secondary:hover {
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.4);
        }

        /* Notification Icon */
        .notification-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .notification-icon.success {
            background: linear-gradient(135deg, #10B981, #059669);
            color: white;
        }

        .notification-icon.warning {
            background: linear-gradient(135deg, #F59E0B, #D97706);
            color: white;
        }

        .notification-icon.info {
            background: linear-gradient(135deg, #3B82F6, #1D4ED8);
            color: white;
        }

        .notification-icon.urgent {
            background: linear-gradient(135deg, #EF4444, #DC2626);
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50">

<div class="flex min-h-screen bg-gray-50 w-full" x-data="{ sidebarOpen: false, activeFilter: 'all' }" x-init="activeFilter = 'all'">
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
            <nav class="flex flex-col gap-2 w-full flex-1 overflow-y-auto">
                <a 
                    href="{{ route('dashboard-banksampah') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center; padding-left: 0; padding-right: 0;'"
                    @click="activeMenu = 'dashboard'"
                >
                    <i class="fas fa-home text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Dashboard</span>
                </a>

                <div 
                    class="group"
                    x-data="{ expanded: false }"
                    x-init="$watch('sidebarOpen', value => { if (!value) expanded = false })"
                >
                    <button 
                        @click="expanded = !expanded" 
                        class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                        :style="sidebarOpen ? 'justify-between; gap: 12px;' : 'justify-content: center;'"
                    >
                        <div class="flex items-center" :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'">
                            <i class="fas fa-users text-lg"></i>
                            <span x-show="sidebarOpen" class="text-sm font-medium">Nasabah</span>
                        </div>
                        <i x-show="sidebarOpen" class="fas fa-chevron-down text-xs opacity-70 transition-transform duration-200" :class="expanded ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="expanded && sidebarOpen" x-collapse.duration.300ms class="pl-6 pt-2 space-y-1">
                        <a 
                            href="{{ route('verifikasi-nasabah-banksampah') }}" 
                            class="flex items-center gap-3 p-2 rounded-lg whitespace-nowrap w-full text-sm hover:bg-white/10 hover:shadow-sm transition-colors duration-200"
                            @click="activeMenu = 'verifikasi-nasabah'"
                        >
                            <i class="fas fa-user-check"></i>
                            <span x-show="sidebarOpen">Verifikasi Nasabah</span>
                        </a>
                        <a 
                            href="{{ route('data-nasabah-banksampah') }}" 
                            class="flex items-center gap-3 p-2 rounded-lg whitespace-nowrap w-full text-sm hover:bg-white/10 hover:shadow-sm transition-colors duration-200"
                            @click="activeMenu = 'data-nasabah'"
                        >
                            <i class="fas fa-database"></i>
                            <span x-show="sidebarOpen">Data Nasabah</span>
                        </a>
                    </div>
                </div>

                <a 
                    href="{{ route('penjemputan-sampah-banksampah') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'penjemputan-sampah'"
                >
                    <i class="fas fa-truck text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Penjemputan Sampah</span>
                </a>
                
                <div 
                    class="group"
                    x-data="{ expanded: false }"
                    x-init="$watch('sidebarOpen', value => { if (!value) expanded = false })"
                >
                    <button 
                        @click="expanded = !expanded" 
                        class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                        :style="sidebarOpen ? 'justify-between; gap: 12px;' : 'justify-content: center;'"
                    >
                        <div class="flex items-center" :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'">
                            <i class="fas fa-weight-hanging text-lg"></i>
                            <span x-show="sidebarOpen" class="text-sm font-medium">Penimbangan</span>
                        </div>
                        <i x-show="sidebarOpen" class="fas fa-chevron-down text-xs opacity-70 transition-transform duration-200" :class="expanded ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="expanded && sidebarOpen" x-collapse.duration.300ms class="pl-6 pt-2 space-y-1">
                        <a 
                            href="{{ route('input-setoran') }}" 
                            class="flex items-center gap-3 p-2 rounded-lg whitespace-nowrap w-full text-sm hover:bg-white/10 hover:shadow-sm transition-colors duration-200"
                            @click="activeMenu = 'input-setoran'"
                        >
                            <i class="fas fa-plus-circle"></i>
                            <span x-show="sidebarOpen">Input Setoran</span>
                        </a>
                    </div>
                </div>

                <a 
                    href="{{ route('datasampah-banksampah') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'data-sampah'"
                >
                    <i class="fas fa-trash-alt text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Data Sampah</span>
                </a>
                
                <a 
                    href="{{ route('penjualansampah-banksampah') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'penjualansampah'"
                >
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Penjualan Sampah</span>
                </a>
                
                <a 
                    href="{{ route('settingsbank') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'settings'"
                >
                    <i class="fas fa-cog text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Pengaturan</span>
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
    <div class="main-content" :class="sidebarOpen ? 'pl-24' : 'pl-24'" style="transition: padding-left 0.3s ease; width: 100%;">
        {{-- Top Header Bar --}}
        <div class="fixed top-0 left-0 right-0 h-12 z-40 flex items-center justify-between px-6 text-white" :style="'padding-left:' + (sidebarOpen ? '16rem' : '4rem') + '; background: linear-gradient(135deg, #75E6DA 0%, #05445E 30%, #05445E 100%); width: 100%;'">
            <h1 class="text-white font-semibold text-lg" style="position: absolute; left: 1.5rem;">BijakSampah</h1>
            <div class="flex items-center gap-4" style="position: absolute; right: 1.5rem;">
                <a href="{{ route('notifikasibank') }}" class="relative">
                    <i class="far fa-bell text-white text-sm"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-medium">3</span>
                </a>
                <button class="focus:outline-none">
                    <i class="fas fa-search text-white text-sm"></i>
                </button>
                <div class="flex items-center gap-2">
                    <a href="{{ route('profilebank') }}" class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center border-2 border-gray-300">
                        <img src="{{ asset('asset/img/user_profile.jpg') }}" alt="Profile" class="w-full h-full object-cover">
                    </a>
                    <i class="fas fa-chevron-down text-white text-xs"></i>
                </div>
            </div>
        </div>

        <div class="p-6" style="padding-top: 20px; width: 100%; max-width: 100%;">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Notifikasi Bank Sampah</h1>
                    <p class="text-sm text-gray-500">Kelola semua notifikasi dan aktivitas bank sampah</p>
                </div>
            </div>

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="stats-card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white/80 text-sm font-medium">Total Notifikasi</p>
                            <p class="text-3xl font-bold text-white">24</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-bell text-white text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stats-card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white/80 text-sm font-medium">Belum Dibaca</p>
                            <p class="text-3xl font-bold text-white">8</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-envelope text-white text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stats-card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white/80 text-sm font-medium">Penting</p>
                            <p class="text-3xl font-bold text-white">3</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stats-card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white/80 text-sm font-medium">Hari Ini</p>
                            <p class="text-3xl font-bold text-white">5</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-day text-white text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filter Section --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Filter Notifikasi</h2>
                <div class="flex gap-4 flex-wrap">
                    <button @click="activeFilter = 'all'" :class="activeFilter === 'all' ? 'filter-btn active' : 'filter-btn'" class="filter-btn">
                        <i class="fas fa-list mr-2"></i>
                        Semua
                    </button>
                    <button @click="activeFilter = 'unread'" :class="activeFilter === 'unread' ? 'filter-btn active' : 'filter-btn'" class="filter-btn">
                        <i class="fas fa-envelope mr-2"></i>
                        Belum Dibaca
                    </button>
                    <button @click="activeFilter = 'urgent'" :class="activeFilter === 'urgent' ? 'filter-btn active' : 'filter-btn'" class="filter-btn">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Penting
                    </button>
                    <button @click="activeFilter = 'nasabah'" :class="activeFilter === 'nasabah' ? 'filter-btn active' : 'filter-btn'" class="filter-btn">
                        <i class="fas fa-users mr-2"></i>
                        Nasabah
                    </button>
                    <button @click="activeFilter = 'penjemputan'" :class="activeFilter === 'penjemputan' ? 'filter-btn active' : 'filter-btn'" class="filter-btn">
                        <i class="fas fa-truck mr-2"></i>
                        Penjemputan
                    </button>
                </div>
            </div>

            {{-- Terkini Section --}}
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Terkini</h2>
                <div class="space-y-4">
                    {{-- Notification 1 --}}
                    <div class="notification-card unread p-6">
                        <div class="flex items-start gap-4">
                            <div class="notification-icon success">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="font-bold text-gray-900">Nasabah Baru Terdaftar</h3>
                                    <span class="text-sm text-gray-500">2 jam yang lalu</span>
                                </div>
                                <p class="text-gray-700 mb-4">Ahmad Suryadi telah mendaftar sebagai nasabah baru. Silakan verifikasi data nasabah.</p>
                                <div class="flex items-center gap-3">
                                    <button class="action-btn">
                                        <i class="fas fa-check mr-2"></i>
                                        Verifikasi Sekarang
                                    </button>
                                    <button class="action-btn secondary">
                                        <i class="fas fa-eye mr-2"></i>
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
                            <button class="text-gray-400 hover:text-red-500 transition-colors">
                                <i class="fas fa-times text-lg"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Notification 2 --}}
                    <div class="notification-card urgent p-6">
                        <div class="flex items-start gap-4">
                            <div class="notification-icon urgent">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="font-bold text-gray-900">Penjemputan Sampah Mendesak</h3>
                                    <span class="text-sm text-gray-500">4 jam yang lalu</span>
                                </div>
                                <p class="text-gray-700 mb-4">Permintaan penjemputan sampah dari Siti Nurhaliza di Bogor membutuhkan konfirmasi segera.</p>
                                <div class="flex items-center gap-3">
                                    <button class="action-btn">
                                        <i class="fas fa-check mr-2"></i>
                                        Konfirmasi Penjemputan
                                    </button>
                                    <button class="action-btn secondary">
                                        <i class="fas fa-eye mr-2"></i>
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
                            <button class="text-gray-400 hover:text-red-500 transition-colors">
                                <i class="fas fa-times text-lg"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Notification 3 --}}
                    <div class="notification-card info p-6">
                        <div class="flex items-start gap-4">
                            <div class="notification-icon info">
                                <i class="fas fa-recycle"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="font-bold text-gray-900">Setoran Sampah Berhasil</h3>
                                    <span class="text-sm text-gray-500">1 hari yang lalu</span>
                                </div>
                                <p class="text-gray-700 mb-4">Setoran sampah dari Bambang telah berhasil diproses. Total berat: 15.5 kg dengan nilai Rp 155.000</p>
                                <div class="flex items-center gap-3">
                                    <button class="action-btn">
                                        <i class="fas fa-download mr-2"></i>
                                        Download Laporan
                                    </button>
                                    <button class="action-btn secondary">
                                        <i class="fas fa-eye mr-2"></i>
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
                            <button class="text-gray-400 hover:text-red-500 transition-colors">
                                <i class="fas fa-times text-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Riwayat Section --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Riwayat Notifikasi</h2>
                <div class="space-y-4">
                    {{-- History Item 1 --}}
                    <div class="notification-card p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="notification-icon success">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-3 mb-1">
                                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">02/02/2025</span>
                                        <span class="font-bold text-gray-900">Verifikasi Nasabah</span>
                                    </div>
                                    <p class="text-gray-600">Ahmad Suryadi berhasil diverifikasi sebagai nasabah baru</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <button class="action-btn secondary">
                                    <i class="fas fa-eye mr-2"></i>
                                    Detail
                                </button>
                                <button class="text-gray-400 hover:text-red-500 transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- History Item 2 --}}
                    <div class="notification-card p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="notification-icon info">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-3 mb-1">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">02/02/2025</span>
                                        <span class="font-bold text-gray-900">Penjemputan Selesai</span>
                                    </div>
                                    <p class="text-gray-600">Penjemputan sampah dari Siti Nurhaliza telah selesai</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <button class="action-btn secondary">
                                    <i class="fas fa-eye mr-2"></i>
                                    Detail
                                </button>
                                <button class="text-gray-400 hover:text-red-500 transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- History Item 3 --}}
                    <div class="notification-card p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="notification-icon warning">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-3 mb-1">
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full">01/02/2025</span>
                                        <span class="font-bold text-gray-900">Laporan Bulanan</span>
                                    </div>
                                    <p class="text-gray-600">Laporan kinerja bank sampah bulan Januari 2025 telah tersedia</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <button class="action-btn secondary">
                                    <i class="fas fa-eye mr-2"></i>
                                    Detail
                                </button>
                                <button class="text-gray-400 hover:text-red-500 transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- History Item 4 --}}
                    <div class="notification-card p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="notification-icon info">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-3 mb-1">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">01/02/2025</span>
                                        <span class="font-bold text-gray-900">Update Sistem</span>
                                    </div>
                                    <p class="text-gray-600">Sistem bank sampah telah diperbarui dengan fitur baru</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <button class="action-btn secondary">
                                    <i class="fas fa-eye mr-2"></i>
                                    Detail
                                </button>
                                <button class="text-gray-400 hover:text-red-500 transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Aksi Cepat</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <button class="notification-card p-6 text-left hover:scale-105 transition-transform">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Tandai Semua Dibaca</h3>
                                <p class="text-sm text-gray-600">Tandai semua notifikasi sebagai dibaca</p>
                            </div>
                        </div>
                    </button>

                    <button class="notification-card p-6 text-left hover:scale-105 transition-transform">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-cog text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Pengaturan Notifikasi</h3>
                                <p class="text-sm text-gray-600">Atur preferensi notifikasi bank sampah</p>
                            </div>
                        </div>
                    </button>

                    <button class="notification-card p-6 text-left hover:scale-105 transition-transform">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-download text-purple-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Ekspor Riwayat</h3>
                                <p class="text-sm text-gray-600">Unduh riwayat notifikasi bank sampah</p>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Mark all as read
    function markAllAsRead() {
        alert('Semua notifikasi telah ditandai sebagai dibaca!');
    }

    // Delete notification
    function deleteNotification(element) {
        if (confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) {
            element.closest('.notification-card').remove();
            alert('Notifikasi berhasil dihapus!');
        }
    }

    // Filter notifications
    function filterNotifications(filter) {
        console.log('Filtering notifications by:', filter);
        // Add your filtering logic here
    }

    // Add event listeners when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Add click event to mark all as read button
        const markAllReadBtn = document.querySelector('button:has(.fa-check)');
        if (markAllReadBtn) {
            markAllReadBtn.addEventListener('click', markAllAsRead);
        }

        // Add click event to delete buttons
        const deleteButtons = document.querySelectorAll('.fa-times');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                deleteNotification(this);
            });
        });
    });
</script>
</body>
</html> 