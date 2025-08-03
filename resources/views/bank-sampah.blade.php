@extends('layouts.app')

@section('content')
<style>
    html, body { 
        overflow-x: hidden; 
        margin: 0;
        padding: 0;
        scroll-behavior: smooth;
    }
    .sidebar-gradient { background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%); }
    .sidebar-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .sidebar-item-hover { transition: all 0.2s ease-in-out; }
    .sidebar-item-hover:hover { background-color: rgba(255, 255, 255, 0.2); }
    .sidebar-logo { transition: all 0.3s ease-in-out; }
    .sidebar-nav-item { transition: all 0.2s ease-in-out; border-radius: 8px; }
    .sidebar-nav-item:hover { background-color: rgba(255, 255, 255, 0.1); }
    .sidebar-nav-item.active { background-color: rgba(255, 255, 255, 0.2); box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
    .sidebar-fixed { z-index: 1000 !important; }
    .main-content-area { position: relative; z-index: 1; }
    .fixed-header {
        position: fixed; top: 0; left: 0; right: 0; height: 48px; z-index: 40;
        display: flex; align-items: center; justify-content: space-between; 
        padding: 0 1.5rem; background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
        transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    .alert-banner {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
        border-radius: 20px;
        box-shadow: 0 12px 40px rgba(117, 230, 218, 0.4);
        border: 2px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
    }
    .invoice-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent;
        background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    }
    .invoice-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(117, 230, 218, 0.3);
        border-color: #75E6DA;
    }
    .waste-image {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
        border-radius: 16px;
        overflow: hidden;
        position: relative;
    }
    .waste-image::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        pointer-events: none;
    }
    .status-badge {
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    .status-badge:hover {
        transform: scale(1.1) rotate(5deg);
    }
    .pickup-button {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    .pickup-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    .pickup-button:hover::before {
        left: 100%;
    }
    .pickup-button:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    }
    .rating-stars {
        color: #fbbf24;
        text-shadow: 0 2px 4px rgba(251, 191, 36, 0.3);
    }
    .chat-bubble {
        animation: pulse 2s infinite;
        filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
    }
    .history-item {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    .history-item:hover {
        transform: translateX(8px);
        border-color: #75E6DA;
        box-shadow: 0 8px 25px rgba(117, 230, 218, 0.2);
    }
    .progress-ring {
        transform: rotate(-90deg);
    }
    .progress-ring-circle {
        transition: stroke-dasharray 0.35s;
        transform-origin: 50% 50%;
    }
    .floating-action {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 1000;
        animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
    .glow-effect {
        box-shadow: 0 0 20px rgba(117, 230, 218, 0.5);
    }
    .glass-effect {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
</style>

<div class="flex min-h-screen bg-gradient-to-br from-blue-50 via-white to-teal-50" x-data="bankSampahApp()" x-init="init()">
    {{-- Sidebar --}}
    <aside
        x-data="{ open: false, active: 'bank-sampah' }"
        x-ref="sidebar"
        @mouseenter="open = true; $root.sidebarOpen = true"
        @mouseleave="open = false; $root.sidebarOpen = false"
        class="fixed top-0 left-0 z-50 flex flex-col py-6 sidebar-hover overflow-hidden shadow-2xl group sidebar-gradient sidebar-fixed"
        :class="open ? 'w-64' : 'w-16'"
        style="transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); margin-top: 48px; height: calc(100vh - 48px);"
    >
        <div class="relative flex flex-col h-full w-full px-4">
            {{-- Logo Section --}}
            <div class="flex items-center justify-center mb-8 mt-2 sidebar-logo">
                <img x-show="open" class="w-16 h-auto" src="{{ asset('asset/img/logo.png') }}" alt="Logo Penuh">
                <img x-show="!open" class="w-6 h-6" src="{{ asset('asset/img/logo.png') }}" alt="Logo Ikon">
            </div>
            
            {{-- Navigation Menu --}}
            <nav class="flex flex-col gap-2 w-full flex-1">
                {{-- Dashboard Link --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-3 font-medium sidebar-nav-item whitespace-nowrap w-full" :class="open ? (active === 'dashboard' ? 'active text-white' : 'text-white') : (active === 'dashboard' ? 'active text-white justify-center' : 'text-white justify-center')">
                    <i class="fas fa-home text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Dashboard</span>
                </a>
                
                {{-- Bank Sampah Link --}}
                <a href="{{ route('bank-sampah') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'bank-sampah' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'bank-sampah' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                <i class="fas fa-tachometer-alt text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Bank Sampah</span>
                </a>
                
                {{-- Toko Link --}}
                <a href="{{ route('toko') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'toko' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'toko' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-store text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Toko</span>
                </a>
                
                {{-- Komunitas Link --}}
                <a href="{{ route('komunitas') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'komunitas' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'komunitas' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-users text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Komunitas</span>
                </a>
                
                {{-- Berita Link --}}
                <a href="{{ route('berita') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'berita' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'berita' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-newspaper text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Berita</span>
                </a>
                
                {{-- Keuangan Link --}}
                <a href="{{ route('keuangan') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'keuangan' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'keuangan' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-file-invoice-dollar text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Keuangan</span>
                </a>
                
                {{-- Pesan Link --}}
                <a href="{{ route('chat') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'chat' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'chat' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-comment-dots text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Pesan</span>
                </a>
                
                {{-- Umpan Balik Link --}}
                <a href="{{ route('feedback') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'feedback' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'feedback' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-info-circle text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Umpan Balik</span>
                </a>
                
                {{-- Settings Link --}}
                <a href="{{ route('settings') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'settings' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'settings' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
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

    {{-- Main Content Area --}}
    <div class="flex-1 min-h-screen main-content-area" :style="'padding-left:' + (sidebarOpen ? '16rem' : '4rem') + '; transition: padding-left 0.3s cubic-bezier(0.4,0,0.2,1);'">
        {{-- Top Header Bar --}}
        <div class="fixed-header" :style="'padding-left:' + (sidebarOpen ? '16rem' : '4rem') + ';'">
            <h1 class="text-white font-semibold text-lg">Bank Sampah</h1>
            <div class="flex items-center gap-4">
                <button @click="openNotifications()" class="relative focus:outline-none">
                    <i class="far fa-bell text-white text-sm"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-medium notification-badge" x-text="getUnreadNotificationCount()"></span>
                </button>
                <button @click="openSearch()" class="focus:outline-none">
                    <i class="fas fa-search text-white text-sm"></i>
                </button>
                <div class="relative">
                    <button @click="toggleProfileDropdown()" class="flex items-center gap-2 focus:outline-none">
                        <div class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center border-2 border-gray-300">
                            <img src="{{ asset('asset/img/user_profile.jpg') }}" alt="Profile" class="w-full h-full object-cover">
                        </div>
                        <i class="fas fa-chevron-down text-white text-xs"></i>
                    </button>
                    
                    <!-- Profile Dropdown -->
                    <div x-show="showProfileDropdown" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-2xl border-2 border-gray-200 z-50">
                        <div class="py-2">
                            <button @click="viewProfile()" class="w-full px-4 py-2 text-left text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                <i class="fas fa-user text-teal-600"></i>
                                <span>Profil</span>
                            </button>
                            <button @click="logout()" class="w-full px-4 py-2 text-left text-red-600 hover:bg-red-50 flex items-center gap-2">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Main Content --}}
        <div class="p-8" style="padding-top: 60px;">
            {{-- Header Section --}}
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Bank Sampah</h1>
                <p class="text-gray-600 text-lg">Terkini</p>
            </div>

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Pengambilan -->
                <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 border-teal-200 hover:border-teal-300 transition-all duration-300 hover:transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-teal-700 text-sm font-bold uppercase tracking-wide mb-2">Total Pengambilan</p>
                            <p class="text-3xl font-black text-gray-900 mb-2">156</p>
                            <p class="text-teal-700 text-sm font-bold flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i>
                                +12 minggu ini
                            </p>
                        </div>
                        <div class="bg-gradient-to-r from-teal-500 to-teal-600 rounded-full p-4 shadow-xl">
                            <i class="fas fa-truck text-2xl text-white"></i>
                        </div>
                    </div>
                </div>

                <!-- Sampah Terkumpul -->
                <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 border-blue-200 hover:border-blue-300 transition-all duration-300 hover:transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-700 text-sm font-bold uppercase tracking-wide mb-2">Sampah Terkumpul</p>
                            <p class="text-3xl font-black text-gray-900 mb-2">2.4 Ton</p>
                            <p class="text-blue-700 text-sm font-bold flex items-center">
                                <i class="fas fa-percentage mr-1"></i>
                                +18% bulan ini
                            </p>
                        </div>
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-full p-4 shadow-xl">
                            <i class="fas fa-recycle text-2xl text-white"></i>
                        </div>
                    </div>
                </div>

                <!-- Daerah Aktif -->
                <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 border-purple-200 hover:border-purple-300 transition-all duration-300 hover:transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-700 text-sm font-bold uppercase tracking-wide mb-2">Daerah Aktif</p>
                            <p class="text-3xl font-black text-gray-900 mb-2">24</p>
                            <p class="text-purple-700 text-sm font-bold flex items-center">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                +3 daerah baru
                            </p>
                        </div>
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-full p-4 shadow-xl">
                            <i class="fas fa-map text-2xl text-white"></i>
                        </div>
                    </div>
                </div>

                <!-- Pendapatan -->
                <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 border-orange-200 hover:border-orange-300 transition-all duration-300 hover:transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-700 text-sm font-bold uppercase tracking-wide mb-2">Pendapatan</p>
                            <p class="text-3xl font-black text-gray-900 mb-2">Rp4.2M</p>
                            <p class="text-orange-700 text-sm font-bold flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i>
                                +15.3% bulan ini
                            </p>
                        </div>
                        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-full p-4 shadow-xl">
                            <i class="fas fa-coins text-2xl text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Alert Banner --}}
            <div class="alert-banner p-8 mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-white text-2xl font-bold mb-1">Bank Sampah, Lodaya II Bogor</h3>
                                <p class="text-white/90 text-lg">Sampah dari Lodaya II Bogor siap diambil</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 mt-4">
                            <span class="px-4 py-2 bg-white/20 rounded-full text-white text-sm font-bold">
                                <i class="fas fa-clock mr-2"></i>Prioritas Tinggi
                            </span>
                            <span class="px-4 py-2 bg-white/20 rounded-full text-white text-sm font-bold">
                                <i class="fas fa-weight-hanging mr-2"></i>150 Kg
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <button @click="pickupNow()" class="bg-white text-teal-700 px-8 py-4 rounded-xl hover:bg-gray-100 transition-all duration-300 font-bold shadow-lg border-2 border-white glow-effect">
                            <i class="fas fa-truck mr-2"></i>Ambil Sekarang
                        </button>
                        <button @click="pickupLater()" class="bg-white/20 text-white px-8 py-4 rounded-xl hover:bg-white/30 transition-all duration-300 font-bold shadow-lg border-2 border-white/30">
                            <i class="fas fa-clock mr-2"></i>Ambil Nanti
                        </button>
                        <button @click="showFilterModal = true" class="bg-white/20 text-white px-6 py-4 rounded-xl hover:bg-white/30 transition-all duration-300 font-bold shadow-lg border-2 border-white/30">
                            <i class="fas fa-filter mr-2"></i>Filter
                        </button>
                    </div>
                    <div class="flex flex-col items-end gap-3">
                        <button @click="closeAlert()" class="text-white/80 hover:text-white transition-colors">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                        <a href="#" class="text-white/80 hover:text-white text-sm underline">Selengkapnya</a>
                    </div>
                </div>
            </div>

            {{-- Invoice Cards Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                @for ($i = 0; $i < 6; $i++)
                <div class="invoice-card rounded-2xl shadow-2xl overflow-hidden">
                    {{-- Top Section --}}
                    <div class="p-6 bg-gradient-to-r from-teal-500 to-teal-600 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
                        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>
                        
                        <div class="flex items-center justify-between mb-4 relative z-10">
                            <div>
                                <h3 class="text-white font-bold text-xl">Invoice #TEK{{ 12345 + $i }}</h3>
                                <p class="text-white/90 text-sm">{{ date('d/m/Y', strtotime('+' . $i . ' days')) }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                @if($i % 3 == 0)
                                <div class="relative">
                                    <i class="fas fa-comment-dots text-white text-xl chat-bubble"></i>
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">3</span>
                                </div>
                                @else
                                <div class="flex items-center gap-1">
                                    <i class="fas fa-thumbs-up text-yellow-300 text-xl"></i>
                                    <span class="text-white font-bold text-sm">{{ 4 + ($i % 2) }}/5</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        {{-- Waste Image --}}
                        <div class="waste-image h-40 flex items-center justify-center mb-4 relative">
                            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-2xl">
                                <i class="fas fa-wine-bottle text-4xl text-teal-600"></i>
                            </div>
                            <div class="absolute top-2 right-2">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-white/20 text-white border border-white/30">
                                    {{ $i % 4 == 0 ? 'Plastik' : ($i % 4 == 1 ? 'Kertas' : ($i % 4 == 2 ? 'Logam' : 'Kaca')) }}
                                </span>
                            </div>
                        </div>
                        
                        <a href="#" class="text-white/90 hover:text-white text-sm underline relative z-10">Selengkapnya</a>
                    </div>
                    
                    {{-- Details Section --}}
                    <div class="p-6">
                        <div class="space-y-4 mb-6">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600 text-sm font-medium">Jenis Sampah:</span>
                                <span class="text-gray-900 font-bold">Botol Plastik</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600 text-sm font-medium">Name:</span>
                                <span class="text-gray-900 font-bold">BS - Lodaya II</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600 text-sm font-medium">Phone:</span>
                                <span class="text-gray-900 font-bold">087876529</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600 text-sm font-medium">Address:</span>
                                <span class="text-gray-900 font-bold">Lodaya II, Bogor</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600 text-sm font-medium">Quantity:</span>
                                <span class="text-gray-900 font-bold text-lg">{{ 50 + ($i * 10) }} Kg</span>
                            </div>
                        </div>
                        
                        {{-- Action Button --}}
                        @if($i % 3 == 0)
                        <button @click="pickupLater({{ $i + 1 }})" class="w-full pickup-button bg-gradient-to-r from-yellow-500 to-yellow-600 text-white py-4 rounded-xl hover:from-yellow-600 hover:to-yellow-700 transition-all duration-300 font-bold shadow-lg border-2 border-yellow-600">
                            <i class="fas fa-clock mr-2"></i>Diambil Nanti
                        </button>
                        @else
                        <button @click="pickupCompleted({{ $i + 1 }})" class="w-full pickup-button bg-gradient-to-r from-green-500 to-green-600 text-white py-4 rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 font-bold shadow-lg border-2 border-green-600">
                            <i class="fas fa-check mr-2"></i>Sudah Diambil
                        </button>
                        @endif
                        
                        {{-- Additional Action Buttons --}}
                        <div class="flex gap-2 mt-3">
                            <button @click="viewWasteDetail({{ $i + 1 }})" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors font-bold border-2 border-blue-700 text-sm">
                                <i class="fas fa-eye mr-1"></i>Detail
                            </button>
                            <button @click="downloadReport({{ $i + 1 }})" class="flex-1 bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 transition-colors font-bold border-2 border-purple-700 text-sm">
                                <i class="fas fa-download mr-1"></i>Laporan
                            </button>
                            <button @click="openChat({{ $i + 1 }})" class="flex-1 bg-teal-600 text-white py-2 rounded-lg hover:bg-teal-700 transition-colors font-bold border-2 border-teal-700 text-sm">
                                <i class="fas fa-comment mr-1"></i>Chat
                            </button>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            {{-- History Section --}}
            <div class="bg-white rounded-2xl shadow-2xl p-8 border-2 border-gray-200">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-teal-500 to-teal-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-history text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Riwayat Pengambilan</h3>
                            <p class="text-gray-600">Aktivitas pengambilan sampah terbaru</p>
                        </div>
                    </div>
                    <button @click="viewAllHistory()" class="text-teal-600 hover:text-teal-700 font-bold px-6 py-3 rounded-xl hover:bg-teal-50 transition-all duration-300 border-2 border-teal-200 hover:border-teal-300">
                        <i class="fas fa-eye mr-2"></i>Lihat Semua
                    </button>
                </div>
                <div class="space-y-4">
                    @for ($i = 0; $i < 5; $i++)
                    <div class="history-item flex items-center gap-6 p-6 bg-gradient-to-r from-gray-50 to-white rounded-2xl hover:bg-gradient-to-r hover:from-teal-50 hover:to-white transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-check text-white text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900 text-lg mb-2">{{ $i % 3 == 0 ? 'Pengambilan sampah plastik selesai' : ($i % 3 == 1 ? 'Pengambilan sampah kertas selesai' : 'Pengambilan sampah logam selesai') }}</h4>
                            <div class="flex items-center gap-4 text-sm text-gray-600">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-map-marker-alt text-teal-600"></i>
                                    {{ $i % 2 == 0 ? 'Lodaya II, Bogor' : 'Malabar, Bandung' }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock text-teal-600"></i>
                                    {{ $i + 1 }} jam yang lalu
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-user text-teal-600"></i>
                                    Petugas #{{ 1001 + $i }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-green-600">{{ 25 + ($i * 5) }} Kg</p>
                            <p class="text-xs text-gray-500">Berat</p>
                            <div class="flex items-center gap-1 mt-2 justify-end">
                                <i class="fas fa-star text-yellow-400 text-sm"></i>
                                <span class="text-sm font-bold text-gray-700">{{ 4 + ($i % 2) }}.5</span>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    {{-- Floating Action Button --}}
    <div class="floating-action">
        <button @click="showPickupDetail = true" class="w-16 h-16 bg-gradient-to-r from-teal-500 to-teal-600 text-white rounded-full shadow-2xl hover:shadow-3xl transition-all duration-300 border-2 border-white glow-effect">
            <i class="fas fa-plus text-xl"></i>
        </button>
    </div>

    {{-- Pickup Detail Modal --}}
    <div x-show="showPickupDetail" x-transition class="fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl p-8 w-full max-w-2xl shadow-3xl">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-teal-500 to-teal-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-truck text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Detail Pengambilan Sampah</h3>
                            <p class="text-gray-600">Atur jadwal dan detail pengambilan</p>
                        </div>
                    </div>
                    <button @click="showPickupDetail = false" class="text-gray-500 hover:text-gray-700 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Invoice Number</label>
                            <input type="text" x-model="pickupData.invoiceNumber" readonly class="w-full px-4 py-4 border-2 border-gray-300 rounded-xl bg-gray-50 focus:border-teal-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Tanggal Pengambilan</label>
                            <input type="date" x-model="pickupData.pickupDate" class="w-full px-4 py-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-teal-500 transition-colors">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Waktu Pengambilan</label>
                        <select x-model="pickupData.pickupTime" class="w-full px-4 py-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-teal-500 transition-colors">
                            <option value="">Pilih waktu</option>
                            <option value="08:00">08:00 - 10:00</option>
                            <option value="10:00">10:00 - 12:00</option>
                            <option value="13:00">13:00 - 15:00</option>
                            <option value="15:00">15:00 - 17:00</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Petugas</label>
                        <select x-model="pickupData.officer" class="w-full px-4 py-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-teal-500 transition-colors">
                            <option value="">Pilih petugas</option>
                            <option value="petugas1">Petugas #1001 - Ahmad</option>
                            <option value="petugas2">Petugas #1002 - Budi</option>
                            <option value="petugas3">Petugas #1003 - Candra</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Catatan Pengambilan</label>
                        <textarea x-model="pickupData.notes" placeholder="Tambahkan catatan pengambilan" class="w-full h-32 px-4 py-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-teal-500 transition-colors resize-none"></textarea>
                    </div>
                    <div class="flex gap-4 pt-6">
                        <button @click="showPickupDetail = false" class="flex-1 bg-gray-300 text-gray-700 py-4 rounded-xl hover:bg-gray-400 transition-all duration-300 font-bold border-2 border-gray-400">
                            <i class="fas fa-times mr-2"></i>Batal
                        </button>
                        <button @click="confirmPickup()" class="flex-1 bg-gradient-to-r from-teal-500 to-teal-600 text-white py-4 rounded-xl hover:from-teal-600 hover:to-teal-700 transition-all duration-300 font-bold border-2 border-teal-600 shadow-lg">
                            <i class="fas fa-check mr-2"></i>Konfirmasi Pengambilan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Notification Modal --}}
    <div x-show="showNotificationModal" x-transition class="fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-3xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Notifikasi</h3>
                    <button @click="showNotificationModal = false" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    <template x-for="notification in notifications" :key="notification.id">
                        <div class="p-4 bg-gray-50 rounded-xl border-l-4" :class="notification.type === 'success' ? 'border-green-500' : notification.type === 'error' ? 'border-red-500' : 'border-blue-500'">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900" x-text="notification.title"></h4>
                                    <p class="text-sm text-gray-600 mt-1" x-text="notification.message"></p>
                                    <p class="text-xs text-gray-500 mt-2" x-text="notification.time"></p>
                                </div>
                                <div class="flex items-center gap-2 ml-4">
                                    <button @click="markNotificationAsRead(notification.id)" class="text-blue-600 hover:text-blue-700" x-show="!notification.read">
                                        <i class="fas fa-check text-sm"></i>
                                    </button>
                                    <button @click="deleteNotification(notification.id)" class="text-red-600 hover:text-red-700">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    {{-- Search Modal --}}
    <div x-show="showSearchModal" x-transition class="fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl p-6 w-full max-w-2xl shadow-3xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Cari Sampah</h3>
                    <button @click="showSearchModal = false" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <input type="text" x-model="searchQuery" placeholder="Cari berdasarkan invoice, lokasi, atau jenis sampah..." class="w-full px-4 py-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-teal-500 transition-colors">
                    </div>
                    <div class="flex gap-4 pt-4">
                        <button @click="showSearchModal = false" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-xl hover:bg-gray-400 transition-all duration-300 font-bold border-2 border-gray-400">
                            Batal
                        </button>
                        <button @click="performSearch()" class="flex-1 bg-gradient-to-r from-teal-500 to-teal-600 text-white py-3 rounded-xl hover:from-teal-600 hover:to-teal-700 transition-all duration-300 font-bold border-2 border-teal-600 shadow-lg">
                            <i class="fas fa-search mr-2"></i>Cari
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Modal --}}
    <div x-show="showFilterModal" x-transition class="fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-3xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Filter Sampah</h3>
                    <button @click="showFilterModal = false" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select x-model="filterData.category" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-teal-500 transition-colors">
                            <option value="">Semua Kategori</option>
                            <option value="plastic">Plastik</option>
                            <option value="paper">Kertas</option>
                            <option value="metal">Logam</option>
                            <option value="glass">Kaca</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Daerah</label>
                        <select x-model="filterData.region" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-teal-500 transition-colors">
                            <option value="">Semua Daerah</option>
                            <option value="jakarta">Jakarta</option>
                            <option value="bandung">Bandung</option>
                            <option value="surabaya">Surabaya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rentang Berat</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" x-model="filterData.minWeight" placeholder="Min (KG)" class="px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-teal-500 transition-colors">
                            <input type="number" x-model="filterData.maxWeight" placeholder="Max (KG)" class="px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-teal-500 transition-colors">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                        <input type="date" x-model="filterData.date" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-teal-500 transition-colors">
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button @click="resetFilter()" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-xl hover:bg-gray-400 transition-all duration-300 font-bold border-2 border-gray-400">
                            Reset
                        </button>
                        <button @click="applyFilter()" class="flex-1 bg-gradient-to-r from-teal-500 to-teal-600 text-white py-3 rounded-xl hover:from-teal-600 hover:to-teal-700 transition-all duration-300 font-bold border-2 border-teal-600 shadow-lg">
                            Terapkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function bankSampahApp() {
        return {
            sidebarOpen: false,
            showPickupDetail: false,
            showFilterModal: false,
            showNotificationModal: false,
            showProfileDropdown: false,
            showSearchModal: false,
            activeFilter: 'all',
            searchQuery: '',
            notifications: [
                { id: 1, title: 'Pengambilan selesai', message: 'Sampah dari Lodaya II berhasil diambil', time: '2 menit lalu', type: 'success', read: false },
                { id: 2, title: 'Invoice baru', message: 'Invoice #TEK12346 telah dibuat', time: '5 menit lalu', type: 'info', read: false }
            ],
            pickupData: {
                invoiceNumber: '',
                pickupDate: '',
                pickupTime: '',
                officer: '',
                notes: ''
            },
            filterData: {
                category: '',
                region: '',
                minWeight: '',
                maxWeight: '',
                date: ''
            },
            
            // Pickup Functions
            pickupNow() {
                this.showNotification('Pengambilan sampah dijadwalkan sekarang!', 'success');
                this.schedulePickup('now');
            },
            
            pickupLater() {
                this.showPickupDetail = true;
                this.pickupData.invoiceNumber = 'TEK' + Math.floor(Math.random() * 90000) + 10000;
            },
            
            schedulePickup(type) {
                const pickupInfo = {
                    type: type,
                    timestamp: new Date().toISOString(),
                    status: type === 'now' ? 'scheduled' : 'pending'
                };
                localStorage.setItem('pickupSchedule', JSON.stringify(pickupInfo));
            },
            
            closeAlert() {
                this.showNotification('Alert ditutup', 'info');
                // Hide alert banner
                const alertBanner = document.querySelector('.alert-banner');
                if (alertBanner) {
                    alertBanner.style.display = 'none';
                }
            },
            
            pickupCompleted(id) {
                this.showNotification(`Pengambilan sampah #${id} telah selesai!`, 'success');
                this.updatePickupStatus(id, 'completed');
            },
            
            updatePickupStatus(id, status) {
                const pickupStatus = JSON.parse(localStorage.getItem('pickupStatus') || '{}');
                pickupStatus[id] = { status, timestamp: new Date().toISOString() };
                localStorage.setItem('pickupStatus', JSON.stringify(pickupStatus));
            },
            
            confirmPickup() {
                if (!this.pickupData.pickupDate || !this.pickupData.pickupTime || !this.pickupData.officer) {
                    this.showNotification('Mohon lengkapi semua data pengambilan!', 'error');
                    return;
                }
                
                this.showNotification('Pengambilan sampah berhasil dikonfirmasi!', 'success');
                this.showPickupDetail = false;
                this.savePickupData();
            },
            
            savePickupData() {
                const pickupHistory = JSON.parse(localStorage.getItem('pickupHistory') || '[]');
                pickupHistory.push({
                    ...this.pickupData,
                    id: Date.now(),
                    createdAt: new Date().toISOString()
                });
                localStorage.setItem('pickupHistory', JSON.stringify(pickupHistory));
                
                // Reset form
                this.pickupData = {
                    invoiceNumber: '',
                    pickupDate: '',
                    pickupTime: '',
                    officer: '',
                    notes: ''
                };
            },
            
            // History Functions
            viewAllHistory() {
                this.showNotification('Melihat semua riwayat pengambilan', 'info');
                this.showHistoryModal();
            },
            
            showHistoryModal() {
                const historyData = JSON.parse(localStorage.getItem('pickupHistory') || '[]');
                console.log('History Data:', historyData);
            },
            
            // Filter Functions
            applyFilter() {
                this.showNotification('Filter diterapkan!', 'success');
                this.showFilterModal = false;
                this.filterWasteData();
            },
            
            resetFilter() {
                this.filterData = {
                    category: '',
                    region: '',
                    minWeight: '',
                    maxWeight: '',
                    date: ''
                };
                this.activeFilter = 'all';
                this.showNotification('Filter direset!', 'info');
                this.showFilterModal = false;
            },
            
            filterWasteData() {
                console.log('Filtering with:', this.filterData);
            },
            
            // Search Functions
            openSearch() {
                this.showSearchModal = true;
            },
            
            performSearch() {
                if (this.searchQuery.trim()) {
                    this.showNotification(`Mencari: ${this.searchQuery}`, 'info');
                    this.showSearchModal = false;
                }
            },
            
            // Notification Functions
            openNotifications() {
                this.showNotificationModal = true;
            },
            
            markNotificationAsRead(id) {
                this.notifications = this.notifications.map(notif => 
                    notif.id === id ? { ...notif, read: true } : notif
                );
                this.showNotification('Notifikasi ditandai sebagai dibaca', 'info');
            },
            
            deleteNotification(id) {
                this.notifications = this.notifications.filter(notif => notif.id !== id);
                this.showNotification('Notifikasi dihapus', 'info');
            },
            
            // Profile Functions
            toggleProfileDropdown() {
                this.showProfileDropdown = !this.showProfileDropdown;
            },
            
            viewProfile() {
                this.showNotification('Melihat profil', 'info');
                this.showProfileDropdown = false;
                window.location.href = '{{ route("profile") }}';
            },
            
            logout() {
                this.showNotification('Logout berhasil', 'success');
                setTimeout(() => {
                    window.location.href = '{{ route("logout") }}';
                }, 1000);
            },
            
            // Detail Functions
            viewWasteDetail(id) {
                this.showNotification(`Melihat detail sampah #${id}`, 'info');
            },
            
            downloadReport(id) {
                this.showNotification(`Mengunduh laporan sampah #${id}`, 'info');
            },
            
            // Chat Functions
            openChat(id) {
                this.showNotification(`Membuka chat untuk invoice #${id}`, 'info');
            },
            
            // Rating Functions
            submitRating(id, rating) {
                this.showNotification(`Rating ${rating}/5 berhasil disubmit untuk #${id}`, 'success');
            },
            
            // Utility Functions
            formatDate(date) {
                return new Date(date).toLocaleDateString('id-ID');
            },
            
            formatTime(date) {
                return new Date(date).toLocaleTimeString('id-ID');
            },
            
            getUnreadNotificationCount() {
                return this.notifications.filter(n => !n.read).length;
            },
            
            // Enhanced Notification System
            showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-2xl text-white font-medium transition-all duration-300 transform translate-x-full`;
                
                if (type === 'success') {
                    notification.classList.add('bg-gradient-to-r', 'from-green-500', 'to-green-600');
                } else if (type === 'error') {
                    notification.classList.add('bg-gradient-to-r', 'from-red-500', 'to-red-600');
                } else {
                    notification.classList.add('bg-gradient-to-r', 'from-teal-500', 'to-teal-600');
                }
                
                notification.innerHTML = `
                    <div class="flex items-center gap-3">
                        <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'} text-xl"></i>
                        <span>${message}</span>
                        <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white/80 hover:text-white">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);
                
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (document.body.contains(notification)) {
                            document.body.removeChild(notification);
                        }
                    }, 300);
                }, 4000);
            },
            
            // Initialize
            init() {
                this.loadSavedData();
                this.setupEventListeners();
                this.startRealTimeUpdates();
            },
            
            loadSavedData() {
                const pickupHistory = JSON.parse(localStorage.getItem('pickupHistory') || '[]');
                console.log('Loaded pickup history:', pickupHistory);
                
                const savedFilters = JSON.parse(localStorage.getItem('filterPreferences') || '{}');
                this.filterData = { ...this.filterData, ...savedFilters };
            },
            
            setupEventListeners() {
                document.addEventListener('keydown', (e) => {
                    if (e.ctrlKey && e.key === 'k') {
                        e.preventDefault();
                        this.openSearch();
                    }
                });
                
                document.addEventListener('click', (e) => {
                    if (!e.target.closest('.modal-content') && !e.target.closest('[x-data]')) {
                        this.showPickupDetail = false;
                        this.showFilterModal = false;
                        this.showNotificationModal = false;
                        this.showSearchModal = false;
                        this.showProfileDropdown = false;
                    }
                });
            },
            
            startRealTimeUpdates() {
                setInterval(() => {
                    const unreadCount = this.getUnreadNotificationCount();
                    const notificationBadge = document.querySelector('.notification-badge');
                    if (notificationBadge) {
                        notificationBadge.textContent = unreadCount;
                    }
                }, 30000);
            }
        }
    }
    </script>
@endsection