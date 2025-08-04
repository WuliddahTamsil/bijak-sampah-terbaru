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
    .fixed-header {
        position: fixed; top: 0; left: 0; right: 0; height: 48px; z-index: 40;
        display: flex; align-items: center; justify-content: space-between; 
        padding: 0 1.5rem; background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
        transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    .main-content-wrapper {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #f1f5f9 100%);
        padding-top: 60px; 
        padding-left: 4rem; 
        padding-right: 0;
        transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative; 
        overflow-x: hidden;
        width: 100%;
        scroll-behavior: smooth;
    }
    .content-container { 
        width: 100%; 
        margin: 0; 
        padding: 2rem; 
        position: relative; 
        z-index: 1; 
        box-sizing: border-box;
        scroll-behavior: smooth;
    }
    .sidebar-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.5); z-index: 45; opacity: 0; visibility: hidden;
        transition: all 0.3s ease;
    }
    .sidebar-overlay.active { opacity: 1; visibility: visible; }
    
    .notification-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .notification-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
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

    .stats-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

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
    
    /* Responsive fixes */
    @media (max-width: 1024px) {
        .main-content-wrapper { padding-left: 1rem; padding-right: 1rem; }
        .content-container { padding: 1.5rem; }
    }
    @media (max-width: 768px) {
        .main-content-wrapper { padding-left: 0.5rem; padding-right: 0.5rem; }
        .content-container { padding: 1rem; }
    }
</style>

<div class="flex min-h-screen bg-gray-50" x-data="{ sidebarOpen: false, activeFilter: 'all' }">
    {{-- Sidebar Overlay --}}
    <div class="sidebar-overlay" :class="{ 'active': sidebarOpen }" @click="sidebarOpen = false"></div>

    {{-- Sidebar --}}
    <aside
        x-data="{ open: false, active: 'notifikasi' }"
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
                <img x-show="open" class="w-16 h-auto" src="{{ asset('asset/img/logo.png') }}" alt="Logo Penuh">
                <img x-show="!open" class="w-6 h-6" src="{{ asset('asset/img/logo.png') }}" alt="Logo Ikon">
            </div>
            
            {{-- Navigation Menu --}}
            <nav class="flex flex-col gap-2 w-full flex-1">
                {{-- Dashboard Link --}}
                <a href="/dashboard" class="flex items-center gap-3 p-3 font-medium sidebar-nav-item whitespace-nowrap w-full" :class="open ? (active === 'dashboard' ? 'active text-white' : 'text-white') : (active === 'dashboard' ? 'active text-white justify-center' : 'text-white justify-center')">
                    <i class="fas fa-home text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Dashboard</span>
                </a>
                
                {{-- Bank Sampah Link --}}
                <a href="/bank-sampah" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'bank-sampah' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'bank-sampah' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-balance-scale text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Bank Sampah</span>
                </a>
                
                {{-- Toko Link --}}
                <a href="/toko" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'toko' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'toko' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-store text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Toko</span>
                </a>
                
                {{-- Komunitas Link --}}
                <a href="/komunitas" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'komunitas' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'komunitas' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-users text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Komunitas</span>
                </a>
                
                {{-- Berita Link --}}
                <a href="/berita" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'berita' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'berita' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-newspaper text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Berita</span>
                </a>
                
                {{-- Keuangan Link --}}
                <a href="/keuangan" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'keuangan' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'keuangan' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-file-invoice-dollar text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Keuangan</span>
                </a>
                
                {{-- Pesan Link --}}
                <a href="/chat" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'chat' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'chat' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-comment-dots text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Pesan</span>
                </a>
                
                {{-- Umpan Balik Link --}}
                <a href="/feedback" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'feedback' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'feedback' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-info-circle text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Umpan Balik</span>
                </a>
                
                {{-- Settings Link --}}
                <a href="/settings" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'settings' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'settings' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-cog text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Settings</span>
                </a>
            </nav>
            
            {{-- Logout Section --}}
            <div class="w-full flex items-center py-3 mt-auto">
                <a href="/logout" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover text-white hover:text-red-300 transition-all duration-200 w-full whitespace-nowrap" :class="open ? (active === 'logout' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'logout' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Logout</span>
                </a>
            </div>
        </div>
    </aside>

    {{-- Main Content Area --}}
    <div class="main-content-wrapper">
        {{-- Top Header Bar --}}
        <div class="fixed-header">
            <h1 class="text-white font-semibold text-lg">Notifikasi</h1>
            <div class="flex items-center gap-4">
                <a href="/notifikasi" class="relative">
                    <i class="far fa-bell text-white text-sm"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-medium">2</span>
                </a>
                <button class="focus:outline-none">
                    <i class="fas fa-search text-white text-sm"></i>
                </button>
                <div class="flex items-center gap-2">
                    <a href="/profile" class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center border-2 border-gray-300">
                        <img src="{{ asset('asset/img/user_profile.jpg') }}" alt="Profile" class="w-full h-full object-cover">
                    </a>
                    <i class="fas fa-chevron-down text-white text-xs"></i>
                </div>
            </div>
        </div>
        
        {{-- Content Container --}}
        <div class="content-container">
            {{-- Header Section --}}
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Notifikasi 📢</h1>
                <p class="text-gray-600 text-lg">Kelola semua notifikasi dan aktivitas Anda</p>
            </div>

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="stats-card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Notifikasi</p>
                            <p class="text-3xl font-bold text-gray-900">24</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-bell text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stats-card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Belum Dibaca</p>
                            <p class="text-3xl font-bold text-gray-900">8</p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-envelope text-red-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stats-card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Penting</p>
                            <p class="text-3xl font-bold text-gray-900">3</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stats-card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Hari Ini</p>
                            <p class="text-3xl font-bold text-gray-900">5</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-day text-green-600 text-xl"></i>
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
                    <button @click="activeFilter = 'bank'" :class="activeFilter === 'bank' ? 'filter-btn active' : 'filter-btn'" class="filter-btn">
                        <i class="fas fa-recycle mr-2"></i>
                        Bank Sampah
                    </button>
                    <button @click="activeFilter = 'toko'" :class="activeFilter === 'toko' ? 'filter-btn active' : 'filter-btn'" class="filter-btn">
                        <i class="fas fa-store mr-2"></i>
                        Toko
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
                                <i class="fas fa-recycle"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="font-bold text-gray-900">Bank Sampah, Lodaya II Bogor</h3>
                                    <span class="text-sm text-gray-500">2 jam yang lalu</span>
                                </div>
                                <p class="text-gray-700 mb-4">Sampah dari Lodaya II Bogor telah siap untuk diambil. Total berat: 15.5 kg dengan nilai estimasi Rp 155.000</p>
                                <div class="flex items-center gap-3">
                                    <button class="action-btn">
                                        <i class="fas fa-check mr-2"></i>
                                        Ambil Sekarang
                                    </button>
                                    <button class="action-btn secondary">
                                        <i class="fas fa-clock mr-2"></i>
                                        Ambil Nanti
                                    </button>
                                    <button class="action-btn secondary">
                                        <i class="fas fa-eye mr-2"></i>
                                        Selengkapnya
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
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="font-bold text-gray-900">Pesanan Mendesak - Toko Anda</h3>
                                    <span class="text-sm text-gray-500">4 jam yang lalu</span>
                                </div>
                                <p class="text-gray-700 mb-4">Pesanan Tas Nusantara dari Bambang membutuhkan konfirmasi segera. Total pembayaran: Rp 45.000</p>
                                <div class="flex items-center gap-3">
                                    <button class="action-btn">
                                        <i class="fas fa-check mr-2"></i>
                                        Konfirmasi Pesanan
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
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="font-bold text-gray-900">Komunitas Daur Ulang Jakarta</h3>
                                    <span class="text-sm text-gray-500">1 hari yang lalu</span>
                                </div>
                                <p class="text-gray-700 mb-4">Event "Workshop Daur Ulang Kreatif" akan diselenggarakan minggu depan. Daftar sekarang untuk mendapatkan slot terbatas!</p>
                                <div class="flex items-center gap-3">
                                    <button class="action-btn">
                                        <i class="fas fa-calendar-plus mr-2"></i>
                                        Daftar Sekarang
                                    </button>
                                    <button class="action-btn secondary">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Info Lengkap
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
                                    <i class="fas fa-recycle"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-3 mb-1">
                                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">02/02/2025</span>
                                        <span class="font-bold text-gray-900">Bank Sampah, Lodaya II Bogor</span>
                                    </div>
                                    <p class="text-gray-600">Sampah dari Lodaya II Bogor berhasil diproses</p>
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
                                    <i class="fas fa-store"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-3 mb-1">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">02/02/2025</span>
                                        <span class="font-bold text-gray-900">Toko Anda</span>
                                    </div>
                                    <p class="text-gray-600">Pesanan Tas Nusantara dari Bambang telah selesai</p>
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
                                    <i class="fas fa-trophy"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-3 mb-1">
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full">01/02/2025</span>
                                        <span class="font-bold text-gray-900">Achievement Unlocked</span>
                                    </div>
                                    <p class="text-gray-600">Selamat! Anda telah mencapai milestone 100 kg sampah terdaur ulang</p>
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
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-3 mb-1">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">01/02/2025</span>
                                        <span class="font-bold text-gray-900">Komunitas Update</span>
                                    </div>
                                    <p class="text-gray-600">Anggota baru bergabung dengan Komunitas Daur Ulang Jakarta</p>
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
                                <p class="text-sm text-gray-600">Atur preferensi notifikasi Anda</p>
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
                                <p class="text-sm text-gray-600">Unduh riwayat notifikasi</p>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection