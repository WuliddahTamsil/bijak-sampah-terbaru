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
        padding-top: 30px; 
        padding-left: 2rem; 
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
    
    .text-highlight {
        color: #75E6DA;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #10B981, #059669);
        color: white;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #05445E, #043a4e);
        color: white;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(5, 68, 94, 0.3);
    }
    
    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(5, 68, 94, 0.4);
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .activity-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .activity-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .quick-action-btn {
        background: linear-gradient(135deg, #75E6DA, #05445E);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(117, 230, 218, 0.3);
    }

    .quick-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(117, 230, 218, 0.4);
    }

    .progress-bar {
        background: linear-gradient(90deg, #75E6DA, #05445E);
        height: 8px;
        border-radius: 4px;
        transition: width 0.3s ease;
    }

    .chart-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
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

    /* Toko specific styles */
    .toko-card {
        background: rgba(255, 255, 255, 0.95) !important;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3) !important;
        color: #1f2937 !important;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    .toko-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }
    .stats-card {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(117, 230, 218, 0.3);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        border-radius: 20px;
    }
    .stats-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(117, 230, 218, 0.4);
    }
    .action-button {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(117, 230, 218, 0.3);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .action-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    .action-button:hover::before {
        left: 100%;
    }
    .action-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(117, 230, 218, 0.4);
    }
    .product-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .product-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #75E6DA, #05445E);
    }
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
    }
    .product-image {
        transition: transform 0.3s ease;
    }
    .product-card:hover .product-image {
        transform: scale(1.02);
    }
    .price-tag {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: bold;
        box-shadow: 0 4px 16px rgba(117, 230, 218, 0.3);
    }
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .floating-action {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
        border-radius: 50%;
        box-shadow: 0 8px 32px rgba(117, 230, 218, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 1000;
    }
    .floating-action:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 24px rgba(117, 230, 218, 0.6);
    }
    .floating-action svg {
        color: white;
        width: 24px;
        height: 24px;
    }
    
    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.02);
        }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.4s ease-out;
    }
    .animate-pulse-slow {
        animation: pulse 3s infinite;
    }
</style>

<div class="flex min-h-screen bg-gray-50" x-data="{ sidebarOpen: false }">
    {{-- Sidebar Overlay --}}
    <div class="sidebar-overlay" :class="{ 'active': sidebarOpen }" @click="sidebarOpen = false"></div>

    {{-- Sidebar --}}
    <aside
        x-data="{ open: false, active: 'toko' }"
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
                <a href="/dashboard" class="flex items-center gap-3 p-3 font-medium sidebar-nav-item whitespace-nowrap w-full" :class="open ? (active === 'dashboard' ? 'active text-white' : 'text-white') : (active === 'dashboard' ? 'active text-white justify-center' : 'text-white justify-center')">
                    <i class="fas fa-home text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Dashboard</span>
                </a>
                
                {{-- Bank Sampah Link --}}
                <a href="/bank-sampah" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'bank-sampah' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'bank-sampah' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-tachometer-alt text-lg"></i>
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
            <h1 class="text-white font-semibold text-lg">BijakSampah</h1>
            <div class="flex items-center gap-4">
                <a href="/notifikasi" class="relative">
                    <i class="far fa-bell text-white text-sm"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-medium">3</span>
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
            {{-- Toko Title --}}
            <div class="mb-8 text-content">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Dashboard Toko UMKM 🏪</h1>
                <p class="text-gray-600 text-lg">Kelola produk, pesanan, dan bisnis UMKM Anda dengan mudah</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="stats-card p-6 animate-fade-in-up" style="animation-delay: 0.1s;">
                    <div class="flex items-center relative z-10">
                        <div class="p-3 rounded-full bg-white/20 backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-white/80">Total Produk</p>
                            <p class="text-2xl font-bold text-white">24</p>
                        </div>
                    </div>
                </div>
                <div class="stats-card p-6 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="flex items-center relative z-10">
                        <div class="p-3 rounded-full bg-white/20 backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-white/80">Pesanan Hari Ini</p>
                            <p class="text-2xl font-bold text-white">8</p>
                        </div>
                    </div>
                </div>
                <div class="stats-card p-6 animate-fade-in-up" style="animation-delay: 0.3s;">
                    <div class="flex items-center relative z-10">
                        <div class="p-3 rounded-full bg-white/20 backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-white/80">Pendapatan Bulan</p>
                            <p class="text-2xl font-bold text-white">Rp 2.4M</p>
                        </div>
                    </div>
                </div>
                <div class="stats-card p-6 animate-fade-in-up" style="animation-delay: 0.4s;">
                    <div class="flex items-center relative z-10">
                        <div class="p-3 rounded-full bg-white/20 backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-white/80">Pelanggan Aktif</p>
                            <p class="text-2xl font-bold text-white">156</p>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-4 mb-8">
            <button onclick="openModal('addProductModal')" class="action-button text-white px-6 py-3 font-medium flex items-center space-x-2 animate-fade-in-up" style="animation-delay: 0.5s;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>Tambah Produk</span>
            </button>
            <button onclick="openModal('orderHistoryModal')" class="action-button text-white px-6 py-3 font-medium flex items-center space-x-2 animate-fade-in-up" style="animation-delay: 0.6s;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <span>Riwayat Pesanan</span>
            </button>
            <button onclick="openModal('shippingModal')" class="action-button text-white px-6 py-3 font-medium flex items-center space-x-2 animate-fade-in-up" style="animation-delay: 0.7s;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span>Tracking Pengiriman</span>
            </button>
            <button onclick="openModal('paymentModal')" class="action-button text-white px-6 py-3 font-medium flex items-center space-x-2 animate-fade-in-up" style="animation-delay: 0.8s;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                <span>Konfirmasi Pembayaran</span>
            </button>
        </div>

        <!-- Products Grid -->
        <div class="toko-card">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Katalog Produk</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="productsGrid">
                    <!-- Product Card 1 -->
                    <div class="product-card overflow-hidden animate-fade-in-up" style="animation-delay: 0.9s;">
                        <img class="w-full h-48 object-cover product-image" src="https://via.placeholder.com/300x200/75E6DA/ffffff?text=Kerajinan+Bambu" alt="Produk 1">
                        <div class="p-6">
                            <h3 class="font-bold text-gray-900 mb-2 text-lg">Kerajinan Bambu</h3>
                            <p class="text-gray-600 text-sm mb-4 leading-relaxed">Kerajinan tangan dari bambu berkualitas tinggi dengan desain tradisional yang elegan</p>
                            <div class="flex justify-between items-center mb-3">
                                <span class="price-tag">Rp 150.000</span>
                                <div class="flex space-x-2">
                                    <button onclick="editProduct(1)" class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-full transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button onclick="deleteProduct(1)" class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-full transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    Stok: 25 pcs
                                </span>
                                <span class="status-badge bg-green-100 text-green-800">Tersedia</span>
                            </div>
                        </div>
                    </div>

                    <!-- Product Card 2 -->
                    <div class="product-card overflow-hidden animate-fade-in-up" style="animation-delay: 1.0s;">
                        <img class="w-full h-48 object-cover product-image" src="https://via.placeholder.com/300x200/75E6DA/ffffff?text=Batik+Tulis" alt="Produk 2">
                        <div class="p-6">
                            <h3 class="font-bold text-gray-900 mb-2 text-lg">Batik Tulis</h3>
                            <p class="text-gray-600 text-sm mb-4 leading-relaxed">Batik tulis asli dengan motif tradisional yang indah dan berkualitas tinggi</p>
                            <div class="flex justify-between items-center mb-3">
                                <span class="price-tag">Rp 500.000</span>
                                <div class="flex space-x-2">
                                    <button onclick="editProduct(2)" class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-full transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button onclick="deleteProduct(2)" class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-full transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    Stok: 8 pcs
                                </span>
                                <span class="status-badge bg-yellow-100 text-yellow-800">Terbatas</span>
                            </div>
                        </div>
                    </div>

                    <!-- Product Card 3 -->
                    <div class="product-card overflow-hidden animate-fade-in-up" style="animation-delay: 1.1s;">
                        <img class="w-full h-48 object-cover product-image" src="https://via.placeholder.com/300x200/75E6DA/ffffff?text=Makanan+Tradisional" alt="Produk 3">
                        <div class="p-6">
                            <h3 class="font-bold text-gray-900 mb-2 text-lg">Tas Kreasi</h3>
                            <p class="text-gray-600 text-sm mb-4 leading-relaxed">Tas Kreasi dengan bahan berkualitas</p>
                            <div class="flex justify-between items-center mb-3">
                                <span class="price-tag">Rp 75.000</span>
                                <div class="flex space-x-2">
                                    <button onclick="editProduct(3)" class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-full transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button onclick="deleteProduct(3)" class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-full transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    Stok: 15 pcs
                                </span>
                                <span class="status-badge bg-green-100 text-green-800">Tersedia</span>
                            </div>
                        </div>
                    </div>

                    <!-- Product Card 4 -->
                    <div class="product-card overflow-hidden animate-fade-in-up" style="animation-delay: 1.2s;">
                        <img class="w-full h-48 object-cover product-image" src="https://via.placeholder.com/300x200/75E6DA/ffffff?text=Aksesoris+Handmade" alt="Produk 4">
                        <div class="p-6">
                            <h3 class="font-bold text-gray-900 mb-2 text-lg">Aksesoris Handmade</h3>
                            <p class="text-gray-600 text-sm mb-4 leading-relaxed">Aksesoris handmade dengan desain unik dan kreatif</p>
                            <div class="flex justify-between items-center mb-3">
                                <span class="price-tag">Rp 120.000</span>
                                <div class="flex space-x-2">
                                    <button onclick="editProduct(4)" class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-full transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button onclick="deleteProduct(4)" class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-full transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    Stok: 12 pcs
                                </span>
                                <span class="status-badge bg-green-100 text-green-800">Tersedia</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Floating Action Button -->
    <div class="floating-action animate-pulse-slow" onclick="openModal('addProductModal')">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
    </div>
</div>

<!-- Add Product Modal -->
<div id="addProductModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="flex items-center justify-between p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Tambah Produk Baru</h3>
                <button onclick="closeModal('addProductModal')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form class="p-6 space-y-4" id="addProductForm" onsubmit="addNewProduct(event)">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                    <input type="text" id="productName" name="productName" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea id="productDescription" name="productDescription" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" required></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
                    <input type="number" id="productPrice" name="productPrice" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                    <input type="number" id="productStock" name="productStock" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Produk</label>
                    <input type="file" id="productImage" name="productImage" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" accept="image/*">
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeModal('addProductModal')" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Order History Modal -->
<div id="orderHistoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Riwayat Pesanan</h3>
                <button onclick="closeModal('orderHistoryModal')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <!-- Order Item 1 -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-semibold text-gray-900">#ORD-001</h4>
                                <p class="text-sm text-gray-600">Batik Tulis - 2 pcs</p>
                                <p class="text-sm text-gray-500">Pembeli: Ahmad Suryadi</p>
                                <p class="text-sm text-gray-500">Total: Rp 1.000.000</p>
                            </div>
                            <div class="text-right">
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Selesai</span>
                                <p class="text-sm text-gray-500 mt-1">3 hari yang lalu</p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Item 2 -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-semibold text-gray-900">#ORD-002</h4>
                                <p class="text-sm text-gray-600">Kerajinan Bambu - 1 pcs</p>
                                <p class="text-sm text-gray-500">Pembeli: Sarah Putri</p>
                                <p class="text-sm text-gray-500">Total: Rp 150.000</p>
                            </div>
                            <div class="text-right">
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Dalam Pengiriman</span>
                                <p class="text-sm text-gray-500 mt-1">1 hari yang lalu</p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Item 3 -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-semibold text-gray-900">#ORD-003</h4>
                                <p class="text-sm text-gray-600">Makanan Tradisional - 3 pcs</p>
                                <p class="text-sm text-gray-500">Pembeli: Budi Santoso</p>
                                <p class="text-sm text-gray-500">Total: Rp 225.000</p>
                            </div>
                            <div class="text-right">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Menunggu Pembayaran</span>
                                <p class="text-sm text-gray-500 mt-1">Hari ini</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notification Modal -->
<div id="notificationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="flex items-center justify-between p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Notifikasi</h3>
                <button onclick="closeModal('notificationModal')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="border-l-4 border-blue-500 pl-4">
                    <p class="font-medium text-gray-900">Pesanan Baru #ORD-004</p>
                    <p class="text-sm text-gray-600">Aksesoris Handmade - 1 pcs</p>
                    <p class="text-xs text-gray-500">2 menit yang lalu</p>
                </div>
                <div class="border-l-4 border-green-500 pl-4">
                    <p class="font-medium text-gray-900">Pembayaran Diterima</p>
                    <p class="text-sm text-gray-600">Pesanan #ORD-002 telah dibayar</p>
                    <p class="text-xs text-gray-500">15 menit yang lalu</p>
                </div>
                <div class="border-l-4 border-yellow-500 pl-4">
                    <p class="font-medium text-gray-900">Stok Menipis</p>
                    <p class="text-sm text-gray-600">Produk "Batik Tulis" tersisa 3 pcs</p>
                    <p class="text-xs text-gray-500">1 jam yang lalu</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Shipping Tracking Modal -->
<div id="shippingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Tracking Pengiriman</h3>
                <button onclick="closeModal('shippingModal')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <!-- Filter dan Pencarian -->
                <div class="mb-6 flex flex-wrap gap-4">
                    <select id="orderFilter" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Pesanan</option>
                        <option value="ORD-001">ORD-001 - Batik Tulis</option>
                        <option value="ORD-002">ORD-002 - Kerajinan Bambu</option>
                        <option value="ORD-003">ORD-003 - Makanan Tradisional</option>
                        <option value="ORD-004">ORD-004 - Aksesoris Handmade</option>
                    </select>
                    <button onclick="showTrackingDetails('ORD-002')" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Lihat Detail</button>
                </div>

                <!-- Daftar Pesanan -->
                <div class="space-y-4">
                    <!-- Pesanan 1 -->
                    <div class="border border-gray-200 rounded-lg p-4 cursor-pointer hover:bg-gray-50" onclick="showTrackingDetails('ORD-001')">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">Pesanan #ORD-001</h4>
                                <p class="text-sm text-gray-600">Batik Tulis - 2 pcs</p>
                                <p class="text-sm text-gray-500">Pembeli: Ahmad Suryadi</p>
                                <p class="text-sm text-gray-500">Tujuan: Jl. Sudirman No. 123, Jakarta Pusat</p>
                                <p class="text-sm text-gray-500">Resi: JNE123456789</p>
                            </div>
                            <div class="text-right">
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Diterima</span>
                                <p class="text-sm text-gray-500 mt-1">3 hari yang lalu</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pesanan 2 -->
                    <div class="border border-gray-200 rounded-lg p-4 cursor-pointer hover:bg-gray-50" onclick="showTrackingDetails('ORD-002')">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">Pesanan #ORD-002</h4>
                                <p class="text-sm text-gray-600">Kerajinan Bambu - 1 pcs</p>
                                <p class="text-sm text-gray-500">Pembeli: Sarah Putri</p>
                                <p class="text-sm text-gray-500">Tujuan: Jl. Thamrin No. 45, Jakarta Selatan</p>
                                <p class="text-sm text-gray-500">Resi: JNE987654321</p>
                            </div>
                            <div class="text-right">
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Dalam Pengiriman</span>
                                <p class="text-sm text-gray-500 mt-1">1 hari yang lalu</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pesanan 3 -->
                    <div class="border border-gray-200 rounded-lg p-4 cursor-pointer hover:bg-gray-50" onclick="showTrackingDetails('ORD-003')">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">Pesanan #ORD-003</h4>
                                <p class="text-sm text-gray-600">Makanan Tradisional - 3 pcs</p>
                                <p class="text-sm text-gray-500">Pembeli: Budi Santoso</p>
                                <p class="text-sm text-gray-500">Tujuan: Jl. Gatot Subroto No. 67, Jakarta Barat</p>
                                <p class="text-sm text-gray-500">Resi: JNE456789123</p>
                            </div>
                            <div class="text-right">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Menunggu Pembayaran</span>
                                <p class="text-sm text-gray-500 mt-1">Hari ini</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pesanan 4 -->
                    <div class="border border-gray-200 rounded-lg p-4 cursor-pointer hover:bg-gray-50" onclick="showTrackingDetails('ORD-004')">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">Pesanan #ORD-004</h4>
                                <p class="text-sm text-gray-600">Aksesoris Handmade - 1 pcs</p>
                                <p class="text-sm text-gray-500">Pembeli: Rina Dewi</p>
                                <p class="text-sm text-gray-500">Tujuan: Jl. Asia Afrika No. 89, Bandung</p>
                                <p class="text-sm text-gray-500">Resi: JNE789123456</p>
                            </div>
                            <div class="text-right">
                                <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Diproses</span>
                                <p class="text-sm text-gray-500 mt-1">2 jam yang lalu</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Tracking (akan muncul saat diklik) -->
                <div id="trackingDetails" class="hidden mt-6 border-t pt-6">
                    <h4 class="font-semibold text-gray-900 mb-4" id="detailTitle">Detail Tracking</h4>
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-600">Produk:</p>
                                <p class="font-medium" id="detailProduct">-</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Pembeli:</p>
                                <p class="font-medium" id="detailBuyer">-</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Alamat Pengiriman:</p>
                                <p class="font-medium" id="detailAddress">-</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Resi:</p>
                                <p class="font-medium" id="detailResi">-</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4" id="trackingTimeline">
                        <!-- Timeline akan diisi oleh JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Confirmation Modal -->
<div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Pembayaran</h3>
                <button onclick="closeModal('paymentModal')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <!-- Filter Status -->
                <div class="mb-6 flex flex-wrap gap-4">
                    <select id="paymentFilter" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Status</option>
                        <option value="pending">Menunggu Konfirmasi</option>
                        <option value="confirmed">Dikonfirmasi</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                    <span class="text-sm text-gray-600">Total: <span id="totalPayments">4</span> pembayaran</span>
                </div>

                <!-- Daftar Pembayaran -->
                <div class="space-y-4" id="paymentList">
                    <!-- Pembayaran 1 -->
                    <div class="border border-gray-200 rounded-lg p-4" data-payment-id="PAY-001" data-status="pending">
                        <div class="flex justify-between items-start mb-4">
                            <h4 class="font-semibold text-gray-900">Pesanan #ORD-003</h4>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Menunggu Konfirmasi</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-4">
                            <div>
                                <p class="text-gray-600">Pembeli:</p>
                                <p class="font-medium">Budi Santoso</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Total Pembayaran:</p>
                                <p class="font-medium">Rp 225.000</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Metode Pembayaran:</p>
                                <p class="font-medium">Transfer Bank BCA</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Tanggal Pembayaran:</p>
                                <p class="font-medium">Hari ini, 10:30</p>
                            </div>
                        </div>
                        <div class="mb-4 p-3 bg-gray-50 rounded">
                            <p class="text-sm text-gray-600 mb-2">Bukti Transfer:</p>
                            <img src="https://via.placeholder.com/200x100/4F46E5/FFFFFF?text=Bukti+Transfer+BCA" alt="Bukti Transfer" class="rounded">
                        </div>
                        <div class="flex space-x-3">
                            <button onclick="confirmPayment('PAY-001')" class="flex-1 bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700">Konfirmasi</button>
                            <button onclick="rejectPayment('PAY-001')" class="flex-1 bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700">Tolak</button>
                        </div>
                    </div>

                    <!-- Pembayaran 2 -->
                    <div class="border border-gray-200 rounded-lg p-4" data-payment-id="PAY-002" data-status="pending">
                        <div class="flex justify-between items-start mb-4">
                            <h4 class="font-semibold text-gray-900">Pesanan #ORD-005</h4>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Menunggu Konfirmasi</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-4">
                            <div>
                                <p class="text-gray-600">Pembeli:</p>
                                <p class="font-medium">Dewi Sartika</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Total Pembayaran:</p>
                                <p class="font-medium">Rp 350.000</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Metode Pembayaran:</p>
                                <p class="font-medium">Transfer Bank Mandiri</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Tanggal Pembayaran:</p>
                                <p class="font-medium">Hari ini, 09:15</p>
                            </div>
                        </div>
                        <div class="mb-4 p-3 bg-gray-50 rounded">
                            <p class="text-sm text-gray-600 mb-2">Bukti Transfer:</p>
                            <img src="https://via.placeholder.com/200x100/DC2626/FFFFFF?text=Bukti+Transfer+Mandiri" alt="Bukti Transfer" class="rounded">
                        </div>
                        <div class="flex space-x-3">
                            <button onclick="confirmPayment('PAY-002')" class="flex-1 bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700">Konfirmasi</button>
                            <button onclick="rejectPayment('PAY-002')" class="flex-1 bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700">Tolak</button>
                        </div>
                    </div>

                    <!-- Pembayaran 3 -->
                    <div class="border border-gray-200 rounded-lg p-4" data-payment-id="PAY-003" data-status="pending">
                        <div class="flex justify-between items-start mb-4">
                            <h4 class="font-semibold text-gray-900">Pesanan #ORD-006</h4>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Menunggu Konfirmasi</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-4">
                            <div>
                                <p class="text-gray-600">Pembeli:</p>
                                <p class="font-medium">Ahmad Fauzi</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Total Pembayaran:</p>
                                <p class="font-medium">Rp 180.000</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Metode Pembayaran:</p>
                                <p class="font-medium">E-Wallet OVO</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Tanggal Pembayaran:</p>
                                <p class="font-medium">Hari ini, 08:45</p>
                            </div>
                        </div>
                        <div class="mb-4 p-3 bg-gray-50 rounded">
                            <p class="text-sm text-gray-600 mb-2">Bukti Pembayaran:</p>
                            <img src="https://via.placeholder.com/200x100/059669/FFFFFF?text=Bukti+OVO" alt="Bukti Pembayaran" class="rounded">
                        </div>
                        <div class="flex space-x-3">
                            <button onclick="confirmPayment('PAY-003')" class="flex-1 bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700">Konfirmasi</button>
                            <button onclick="rejectPayment('PAY-003')" class="flex-1 bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700">Tolak</button>
                        </div>
                    </div>

                    <!-- Pembayaran 4 -->
                    <div class="border border-gray-200 rounded-lg p-4" data-payment-id="PAY-004" data-status="pending">
                        <div class="flex justify-between items-start mb-4">
                            <h4 class="font-semibold text-gray-900">Pesanan #ORD-007</h4>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Menunggu Konfirmasi</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-4">
                            <div>
                                <p class="text-gray-600">Pembeli:</p>
                                <p class="font-medium">Siti Nurhaliza</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Total Pembayaran:</p>
                                <p class="font-medium">Rp 420.000</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Metode Pembayaran:</p>
                                <p class="font-medium">Transfer Bank BRI</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Tanggal Pembayaran:</p>
                                <p class="font-medium">Kemarin, 16:20</p>
                            </div>
                        </div>
                        <div class="mb-4 p-3 bg-gray-50 rounded">
                            <p class="text-sm text-gray-600 mb-2">Bukti Transfer:</p>
                            <img src="https://via.placeholder.com/200x100/7C3AED/FFFFFF?text=Bukti+Transfer+BRI" alt="Bukti Transfer" class="rounded">
                        </div>
                        <div class="flex space-x-3">
                            <button onclick="confirmPayment('PAY-004')" class="flex-1 bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700">Konfirmasi</button>
                            <button onclick="rejectPayment('PAY-004')" class="flex-1 bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700">Tolak</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div id="editProductModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="flex items-center justify-between p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Edit Produk</h3>
                <button onclick="closeModal('editProductModal')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form class="p-6 space-y-4" id="editProductForm" onsubmit="updateProduct(event)">
                <input type="hidden" id="editProductId" name="editProductId">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                    <input type="text" id="editProductName" name="editProductName" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea id="editProductDescription" name="editProductDescription" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" required></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
                    <input type="number" id="editProductPrice" name="editProductPrice" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                    <input type="number" id="editProductStock" name="editProductStock" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Produk</label>
                    <input type="file" id="editProductImage" name="editProductImage" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" accept="image/*">
                    <div id="currentImagePreview" class="mt-2">
                        <img id="currentProductImage" src="" alt="Current Image" class="w-20 h-20 object-cover rounded border">
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeModal('editProductModal')" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Sidebar functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize sidebar state
    window.sidebarOpen = false;
    
    // Add click event listeners for existing product cards
    const existingProductCards = document.querySelectorAll('.product-card');
    existingProductCards.forEach(card => {
        const editButton = card.querySelector('button[onclick*="editProduct"]');
        const deleteButton = card.querySelector('button[onclick*="deleteProduct"]');
        
        if (editButton) {
            editButton.addEventListener('click', function(e) {
                e.preventDefault();
                const productId = this.getAttribute('onclick').match(/\d+/)[0];
                editProduct(productId);
            });
        }
        
        if (deleteButton) {
            deleteButton.addEventListener('click', function(e) {
                e.preventDefault();
                const productId = this.getAttribute('onclick').match(/\d+/)[0];
                deleteProduct(productId);
            });
        }
    });
    
    // Initialize product stats on page load
    updateProductStats();
});

function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

function editProduct(productId) {
    console.log('Edit product:', productId); // Debug log
    
    // Ambil data produk dari card
    const productCard = document.getElementById(`product-${productId}`);
    if (!productCard) {
        // Untuk produk yang sudah ada (bukan yang baru ditambahkan)
        const productCards = document.querySelectorAll('.product-card');
        const targetCard = Array.from(productCards).find(card => {
            const editButton = card.querySelector('button[onclick*="editProduct"]');
            return editButton && editButton.getAttribute('onclick').includes(productId);
        });
        
        if (targetCard) {
            populateEditForm(targetCard, productId);
        } else {
            console.log('Product card not found for ID:', productId);
        }
        return;
    }
    
    populateEditForm(productCard, productId);
}

function populateEditForm(productCard, productId) {
    // Ambil data dari card
    const name = productCard.querySelector('h3').textContent;
    const description = productCard.querySelector('p.text-gray-600').textContent;
    const price = productCard.querySelector('span.price-tag').textContent.replace('Rp ', '').replace(/,/g, '');
    const stock = productCard.querySelector('span.text-sm.text-gray-500').textContent.replace('Stok: ', '').replace(' pcs', '');
    const image = productCard.querySelector('img').src;
    
    // Isi form edit
    document.getElementById('editProductId').value = productId;
    document.getElementById('editProductName').value = name;
    document.getElementById('editProductDescription').value = description;
    document.getElementById('editProductPrice').value = price;
    document.getElementById('editProductStock').value = stock;
    document.getElementById('currentProductImage').src = image;
    
    // Tampilkan modal edit
    openModal('editProductModal');
}

function updateProduct(event) {
    event.preventDefault();
    
    // Ambil data dari form
    const productId = document.getElementById('editProductId').value;
    const productName = document.getElementById('editProductName').value;
    const productDescription = document.getElementById('editProductDescription').value;
    const productPrice = document.getElementById('editProductPrice').value;
    const productStock = document.getElementById('editProductStock').value;
    const productImage = document.getElementById('editProductImage').files[0];
    
    // Validasi form
    if (!productName || !productDescription || !productPrice || !productStock) {
        alert('Mohon lengkapi semua field yang diperlukan!');
        return;
    }
    
    // Update product card
    const productCard = document.getElementById(`product-${productId}`);
    if (productCard) {
        // Update card content
        productCard.querySelector('h3').textContent = productName;
        productCard.querySelector('p.text-gray-600').textContent = productDescription;
        productCard.querySelector('span.price-tag').textContent = `Rp ${parseInt(productPrice).toLocaleString()}`;
        productCard.querySelector('span.text-sm.text-gray-500').innerHTML = `
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            Stok: ${productStock} pcs
        `;
        
        // Update image if new one is selected
        if (productImage) {
            const reader = new FileReader();
            reader.onload = function(e) {
                productCard.querySelector('img').src = e.target.result;
            };
            reader.readAsDataURL(productImage);
        }
        
        showNotification('Produk berhasil diupdate!', 'success');
    } else {
        // Handle existing products (not newly added ones)
        const productCards = document.querySelectorAll('.product-card');
        const targetCard = Array.from(productCards).find(card => {
            const editButton = card.querySelector('button[onclick*="editProduct"]');
            return editButton && editButton.getAttribute('onclick').includes(productId);
        });
        
        if (targetCard) {
            targetCard.querySelector('h3').textContent = productName;
            targetCard.querySelector('p.text-gray-600').textContent = productDescription;
            targetCard.querySelector('span.price-tag').textContent = `Rp ${parseInt(productPrice).toLocaleString()}`;
            
            // Update image if new one is selected
            if (productImage) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    targetCard.querySelector('img').src = e.target.result;
                };
                reader.readAsDataURL(productImage);
            }
            
            showNotification('Produk berhasil diupdate!', 'success');
        }
    }
    
    // Reset form dan tutup modal
    document.getElementById('editProductForm').reset();
    closeModal('editProductModal');
}

function addNewProduct(event) {
    event.preventDefault();
    
    // Ambil data dari form
    const productName = document.getElementById('productName').value;
    const productDescription = document.getElementById('productDescription').value;
    const productPrice = document.getElementById('productPrice').value;
    const productStock = document.getElementById('productStock').value;
    const productImage = document.getElementById('productImage').files[0];
    
    // Validasi form
    if (!productName || !productDescription || !productPrice || !productStock) {
        alert('Mohon lengkapi semua field yang diperlukan!');
        return;
    }
    
    // Generate ID unik untuk produk baru
    const newProductId = Date.now();
    
    // Buat elemen produk baru
    const newProductCard = createProductCard(newProductId, productName, productDescription, productPrice, productStock, productImage);
    
    // Tambahkan ke grid produk
    const productsGrid = document.getElementById('productsGrid');
    productsGrid.insertBefore(newProductCard, productsGrid.firstChild);
    
    // Update total produk di stats
    updateProductStats();
    
    // Reset form dan tutup modal
    document.getElementById('addProductForm').reset();
    closeModal('addProductModal');
    
    // Tampilkan notifikasi sukses
    showNotification('Produk berhasil ditambahkan!', 'success');
}

function createProductCard(id, name, description, price, stock, imageFile) {
    const card = document.createElement('div');
    card.className = 'product-card overflow-hidden animate-fade-in-up';
    card.id = `product-${id}`;
    
    // Handle image preview
    let imageSrc = 'https://via.placeholder.com/300x200/75E6DA/ffffff?text=' + encodeURIComponent(name);
    if (imageFile) {
        const reader = new FileReader();
        reader.onload = function(e) {
            card.querySelector('img').src = e.target.result;
        };
        reader.readAsDataURL(imageFile);
    }
    
    card.innerHTML = `
        <img class="w-full h-48 object-cover product-image" src="${imageSrc}" alt="${name}">
        <div class="p-6">
            <h3 class="font-bold text-gray-900 mb-2 text-lg">${name}</h3>
            <p class="text-gray-600 text-sm mb-4 leading-relaxed">${description}</p>
            <div class="flex justify-between items-center mb-3">
                <span class="price-tag">Rp ${parseInt(price).toLocaleString()}</span>
                <div class="flex space-x-2">
                    <button onclick="editProduct(${id})" class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                    <button onclick="deleteProduct(${id})" class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Stok: ${stock} pcs
                </span>
                <span class="status-badge bg-green-100 text-green-800">Tersedia</span>
            </div>
        </div>
    `;
    
    return card;
}

function deleteProduct(productId) {
    console.log('Delete product:', productId); // Debug log
    
    if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
        // Coba hapus produk yang baru ditambahkan
        let productCard = document.getElementById(`product-${productId}`);
        
        if (productCard) {
            productCard.remove();
            updateProductStats();
            showNotification('Produk berhasil dihapus!', 'success');
            return;
        }
        
        // Jika tidak ditemukan, cari produk yang sudah ada (product-card class)
        const productCards = document.querySelectorAll('.product-card');
        const targetCard = Array.from(productCards).find(card => {
            const deleteButton = card.querySelector('button[onclick*="deleteProduct"]');
            return deleteButton && deleteButton.getAttribute('onclick').includes(productId);
        });
        
        if (targetCard) {
            targetCard.remove();
            updateProductStats();
            showNotification('Produk berhasil dihapus!', 'success');
        } else {
            console.log('Product card not found for deletion ID:', productId);
        }
    }
}

function updateProductStats() {
    const productsGrid = document.getElementById('productsGrid');
    const totalProducts = productsGrid.children.length;
    
    // Update total produk di stats card (stats-card class)
    const totalProductElement = document.querySelector('.stats-card p.text-2xl.font-bold.text-white');
    if (totalProductElement) {
        totalProductElement.textContent = totalProducts;
    }
}

function showNotification(message, type = 'info') {
    // Buat elemen notifikasi
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg ${
        type === 'success' ? 'bg-green-500 text-white' : 
        type === 'error' ? 'bg-red-500 text-white' : 
        'bg-blue-500 text-white'
    }`;
    notification.textContent = message;
    
    // Tambahkan ke body
    document.body.appendChild(notification);
    
    // Hapus setelah 3 detik
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

function showTrackingDetails(orderId) {
    // Data tracking untuk setiap pesanan
    const trackingData = {
        'ORD-001': {
            product: 'Batik Tulis - 2 pcs',
            buyer: 'Ahmad Suryadi',
            address: 'Jl. Sudirman No. 123, Jakarta Pusat',
            resi: 'JNE123456789',
            timeline: [
                { status: 'Paket telah diterima pembeli', time: 'Hari ini, 14:30', completed: true },
                { status: 'Paket dalam pengiriman', time: 'Kemarin, 09:15', completed: true },
                { status: 'Paket telah dikirim', time: '2 hari yang lalu, 16:45', completed: true }
            ]
        },
        'ORD-002': {
            product: 'Kerajinan Bambu - 1 pcs',
            buyer: 'Sarah Putri',
            address: 'Jl. Thamrin No. 45, Jakarta Selatan',
            resi: 'JNE987654321',
            timeline: [
                { status: 'Paket dalam pengiriman', time: 'Hari ini, 10:30', completed: true },
                { status: 'Paket telah dikirim', time: 'Kemarin, 16:45', completed: true },
                { status: 'Pesanan diproses', time: '2 hari yang lalu, 14:20', completed: true }
            ]
        },
        'ORD-003': {
            product: 'Makanan Tradisional - 3 pcs',
            buyer: 'Budi Santoso',
            address: 'Jl. Gatot Subroto No. 67, Jakarta Barat',
            resi: 'JNE456789123',
            timeline: [
                { status: 'Menunggu pembayaran', time: 'Hari ini, 09:00', completed: false },
                { status: 'Pesanan diterima', time: 'Hari ini, 08:30', completed: true }
            ]
        },
        'ORD-004': {
            product: 'Aksesoris Handmade - 1 pcs',
            buyer: 'Rina Dewi',
            address: 'Jl. Asia Afrika No. 89, Bandung',
            resi: 'JNE789123456',
            timeline: [
                { status: 'Pesanan diproses', time: '2 jam yang lalu', completed: true },
                { status: 'Pesanan diterima', time: '3 jam yang lalu', completed: true }
            ]
        }
    };

    const data = trackingData[orderId];
    if (!data) return;

    // Update detail informasi
    document.getElementById('detailTitle').textContent = `Detail Tracking - ${orderId}`;
    document.getElementById('detailProduct').textContent = data.product;
    document.getElementById('detailBuyer').textContent = data.buyer;
    document.getElementById('detailAddress').textContent = data.address;
    document.getElementById('detailResi').textContent = data.resi;

    // Update timeline
    const timelineContainer = document.getElementById('trackingTimeline');
    timelineContainer.innerHTML = '';

    data.timeline.forEach((item, index) => {
        const timelineItem = document.createElement('div');
        timelineItem.className = 'flex items-center';
        timelineItem.innerHTML = `
            <div class="w-8 h-8 ${item.completed ? 'bg-green-500' : 'bg-gray-300'} rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="font-medium text-gray-900">${item.status}</p>
                <p class="text-sm text-gray-500">${item.time}</p>
            </div>
        `;
        timelineContainer.appendChild(timelineItem);
    });

    // Tampilkan detail
    document.getElementById('trackingDetails').classList.remove('hidden');
    
    // Scroll ke detail
    document.getElementById('trackingDetails').scrollIntoView({ behavior: 'smooth' });
}

function confirmPayment(paymentId) {
    if (confirm('Apakah Anda yakin ingin mengkonfirmasi pembayaran ini?')) {
        const paymentCard = document.querySelector(`[data-payment-id="${paymentId}"]`);
        if (paymentCard) {
            // Update status
            paymentCard.setAttribute('data-status', 'confirmed');
            const statusBadge = paymentCard.querySelector('span');
            statusBadge.className = 'bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full';
            statusBadge.textContent = 'Dikonfirmasi';
            
            // Disable buttons
            const buttons = paymentCard.querySelectorAll('button');
            buttons.forEach(button => {
                button.disabled = true;
                button.className = 'flex-1 bg-gray-400 text-white py-2 px-4 rounded-md cursor-not-allowed';
                button.textContent = 'Sudah Dikonfirmasi';
            });
            
            // Update total count
            updatePaymentCount();
            showNotification('Pembayaran berhasil dikonfirmasi!', 'success');
        }
    }
}

function rejectPayment(paymentId) {
    const reason = prompt('Alasan penolakan pembayaran:');
    if (reason !== null) {
        const paymentCard = document.querySelector(`[data-payment-id="${paymentId}"]`);
        if (paymentCard) {
            // Update status
            paymentCard.setAttribute('data-status', 'rejected');
            const statusBadge = paymentCard.querySelector('span');
            statusBadge.className = 'bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full';
            statusBadge.textContent = 'Ditolak';
            
            // Disable buttons
            const buttons = paymentCard.querySelectorAll('button');
            buttons.forEach(button => {
                button.disabled = true;
                button.className = 'flex-1 bg-gray-400 text-white py-2 px-4 rounded-md cursor-not-allowed';
                button.textContent = 'Sudah Ditolak';
            });
            
            // Add rejection reason
            const reasonDiv = document.createElement('div');
            reasonDiv.className = 'mt-2 p-2 bg-red-50 border border-red-200 rounded text-sm';
            reasonDiv.innerHTML = `<strong>Alasan penolakan:</strong> ${reason}`;
            paymentCard.appendChild(reasonDiv);
            
            // Update total count
            updatePaymentCount();
            showNotification('Pembayaran ditolak!', 'error');
        }
    }
}

function updatePaymentCount() {
    const totalPayments = document.querySelectorAll('[data-payment-id]').length;
    const pendingPayments = document.querySelectorAll('[data-status="pending"]').length;
    const confirmedPayments = document.querySelectorAll('[data-status="confirmed"]').length;
    const rejectedPayments = document.querySelectorAll('[data-status="rejected"]').length;
    
    document.getElementById('totalPayments').textContent = totalPayments;
    
    // Update filter options
    const filterSelect = document.getElementById('paymentFilter');
    if (filterSelect) {
        const currentValue = filterSelect.value;
        filterSelect.innerHTML = `
            <option value="">Semua Status (${totalPayments})</option>
            <option value="pending">Menunggu Konfirmasi (${pendingPayments})</option>
            <option value="confirmed">Dikonfirmasi (${confirmedPayments})</option>
            <option value="rejected">Ditolak (${rejectedPayments})</option>
        `;
        filterSelect.value = currentValue;
    }
}

// Filter payments by status
document.addEventListener('DOMContentLoaded', function() {
    const paymentFilter = document.getElementById('paymentFilter');
    if (paymentFilter) {
        paymentFilter.addEventListener('change', function() {
            const selectedStatus = this.value;
            const paymentCards = document.querySelectorAll('[data-payment-id]');
            
            paymentCards.forEach(card => {
                const cardStatus = card.getAttribute('data-status');
                if (selectedStatus === '' || cardStatus === selectedStatus) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
});

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('fixed')) {
        event.target.classList.add('hidden');
    }
});

// Initialize product stats on page load
document.addEventListener('DOMContentLoaded', function() {
    updateProductStats();
    
    // Add click event listeners for existing product cards
    const existingProductCards = document.querySelectorAll('.product-card');
    existingProductCards.forEach(card => {
        const editButton = card.querySelector('button[onclick*="editProduct"]');
        const deleteButton = card.querySelector('button[onclick*="deleteProduct"]');
        
        if (editButton) {
            editButton.addEventListener('click', function(e) {
                e.preventDefault();
                const productId = this.getAttribute('onclick').match(/\d+/)[0];
                editProduct(productId);
            });
        }
        
        if (deleteButton) {
            deleteButton.addEventListener('click', function(e) {
                e.preventDefault();
                const productId = this.getAttribute('onclick').match(/\d+/)[0];
                deleteProduct(productId);
            });
        }
    });
});

</script>
@endsection
