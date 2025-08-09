@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
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

    /* Keuangan specific styles */
    .chart-bar { 
        transition: all 0.3s ease; 
        position: relative;
    }
    .chart-bar:hover { 
        transform: scaleY(1.05); 
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .chart-bar::after {
        content: attr(data-value);
        position: absolute;
        top: -25px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(255,255,255,0.9);
        color: #333;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: bold;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .chart-bar:hover::after {
        opacity: 1;
    }
    .progress-ring {
        transform: rotate(-90deg);
    }
    .progress-ring-circle {
        transition: stroke-dasharray 0.35s;
        transform-origin: 50% 50%;
    }
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .gradient-bg-green {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    .gradient-bg-orange {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }
    .gradient-bg-purple {
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    }
    .chart-bar { 
        transition: all 0.3s ease; 
        position: relative;
    }
    .chart-bar:hover { 
        transform: scaleY(1.05); 
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .chart-bar::after {
        content: attr(data-value);
        position: absolute;
        top: -25px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(255,255,255,0.9);
        color: #333;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: bold;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .chart-bar:hover::after {
        opacity: 1;
    }
    .progress-ring {
        transform: rotate(-90deg);
    }
    .progress-ring-circle {
        transition: stroke-dasharray 0.35s;
        transform-origin: 50% 50%;
    }
    .stat-card {
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .gradient-bg-green {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    .gradient-bg-orange {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }
    .gradient-bg-purple {
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    }
    
    /* Chart canvas styles */
    canvas {
        display: block !important;
        max-width: 100% !important;
        height: auto !important;
    }
    
    .h-64 canvas {
        width: 100% !important;
        height: 256px !important;
    }
    
         .w-48.h-48 canvas {
         width: 192px !important;
         height: 192px !important;
     }
     
     /* Modal centering styles */
     #filterModal {
         display: none !important;
         align-items: center !important;
         justify-content: center !important;
         opacity: 0 !important;
         visibility: hidden !important;
         transition: opacity 0.3s ease, visibility 0.3s ease;
     }
     
     #filterModal.show {
         display: flex !important;
         opacity: 1 !important;
         visibility: visible !important;
     }
     
     #filterModal > div {
         width: 100% !important;
         max-width: 400px !important;
         margin: 0 auto !important;
     }
     
     #filterModal .bg-white {
         transform: translateY(-50px);
         animation: modalSlideIn 0.3s ease-out;
     }
     
     @keyframes modalSlideIn {
         from {
             opacity: 0;
             transform: translateY(-100px);
         }
         to {
             opacity: 1;
             transform: translateY(-50px);
         }
     }
</style>

<div class="flex min-h-screen bg-gray-50" x-data="{ sidebarOpen: false, activeTab: 'pemasukan' }">
    {{-- Sidebar Overlay --}}
    <div class="sidebar-overlay" :class="{ 'active': sidebarOpen }" @click="sidebarOpen = false"></div>

    {{-- Sidebar --}}
    <aside
        x-data="{ open: false, active: 'keuangan' }"
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
            <div class="flex items-center justify-between mb-8 text-content">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Keuangan 💰</h1>
                    <p class="text-gray-600 text-lg">Kelola dan pantau keuangan Anda dengan mudah</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="bg-white rounded-xl shadow-lg px-6 py-3 border border-gray-100">
                        <i class="fas fa-calendar text-blue-500 mr-2"></i>
                        <span class="text-sm font-medium text-gray-700" id="currentDate"></span>
                    </div>
                </div>
            </div>
                
                {{-- Statistics Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Saldo -->
                    <div class="stat-card bg-white rounded-2xl shadow-2xl p-6 border-2 border-green-200 hover:border-green-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-700 text-sm font-bold uppercase tracking-wide mb-2">Total Saldo</p>
                                <p class="text-3xl font-black text-gray-900 mb-2">Rp202.000</p>
                                <p class="text-green-700 text-sm font-bold flex items-center">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    +12.5% dari bulan lalu
                                </p>
                            </div>
                            <div class="bg-green-600 rounded-full p-4 shadow-xl">
                                <i class="fas fa-wallet text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Pemasukan Bulan Ini -->
                    <div class="stat-card bg-white rounded-2xl shadow-2xl p-6 border-2 border-blue-200 hover:border-blue-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-700 text-sm font-bold uppercase tracking-wide mb-2">Pemasukan</p>
                                <p class="text-3xl font-black text-gray-900 mb-2">Rp156.000</p>
                                <p class="text-blue-700 text-sm font-bold flex items-center">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    +8.2% dari bulan lalu
                                </p>
                            </div>
                            <div class="bg-blue-600 rounded-full p-4 shadow-xl">
                                <i class="fas fa-arrow-up text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Pengeluaran Bulan Ini -->
                    <div class="stat-card bg-white rounded-2xl shadow-2xl p-6 border-2 border-red-200 hover:border-red-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-red-700 text-sm font-bold uppercase tracking-wide mb-2">Pengeluaran</p>
                                <p class="text-3xl font-black text-gray-900 mb-2">Rp45.000</p>
                                <p class="text-red-700 text-sm font-bold flex items-center">
                                    <i class="fas fa-arrow-down mr-1"></i>
                                    -3.1% dari bulan lalu
                                </p>
                            </div>
                            <div class="bg-red-600 rounded-full p-4 shadow-xl">
                                <i class="fas fa-arrow-down text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Transaksi -->
                    <div class="stat-card bg-white rounded-2xl shadow-2xl p-6 border-2 border-purple-200 hover:border-purple-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-700 text-sm font-bold uppercase tracking-wide mb-2">Total Transaksi</p>
                                <p class="text-3xl font-black text-gray-900 mb-2">24</p>
                                <p class="text-purple-700 text-sm font-bold flex items-center">
                                    <i class="fas fa-plus mr-1"></i>
                                    +5 transaksi hari ini
                                </p>
                            </div>
                            <div class="bg-purple-600 rounded-full p-4 shadow-xl">
                                <i class="fas fa-exchange-alt text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Toggle Buttons --}}
                <div class="flex gap-4 mb-8">
                    <button 
                        @click="activeTab = 'pemasukan'" 
                        :class="activeTab === 'pemasukan' ? 'bg-green-600 text-black shadow-2xl scale-105 border-2 border-green-700' : 'bg-gray-100 text-gray-900 hover:bg-gray-200 border-2 border-gray-400'"
                        class="px-8 py-3 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg">
                        <i class="fas fa-arrow-up mr-2"></i>Pemasukan
                    </button>
                    <button 
                        @click="activeTab = 'pengeluaran'" 
                        :class="activeTab === 'pengeluaran' ? 'bg-red-600 text-white shadow-2xl scale-105 border-2 border-red-700' : 'bg-gray-100 text-gray-900 hover:bg-gray-200 border-2 border-gray-400'"
                        class="px-8 py-3 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg">
                        <i class="fas fa-arrow-down mr-2"></i>Pengeluaran
                    </button>
                </div>
                
                {{-- Charts Section --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Bar Chart -->
                    <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 border-gray-200">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-black text-gray-900 mb-2">Tren Pemasukan 7 Hari Terakhir</h3>
                                <p class="text-gray-700 font-medium">Analisis pemasukan harian</p>
                            </div>
                            <div class="flex items-center gap-3 bg-blue-100 px-4 py-2 rounded-full border border-blue-300">
                                <span class="w-4 h-4 bg-blue-600 rounded-full"></span>
                                <span class="text-sm font-bold text-blue-800">Pemasukan</span>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="barChart" width="400" height="200"></canvas>
                        </div>
                    </div>

                    <!-- Doughnut Chart -->
                    <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 border-gray-200">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-black text-gray-900 mb-2">Distribusi Kategori</h3>
                                <p class="text-gray-700 font-medium">Persentase berdasarkan jenis sampah</p>
                            </div>
                            <div class="flex items-center gap-3 bg-green-100 px-4 py-2 rounded-full border border-green-300">
                                <span class="w-4 h-4 bg-green-600 rounded-full"></span>
                                <span class="text-sm font-bold text-green-800">Kategori</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-center mb-4">
                            <div class="relative w-48 h-48">
                                <canvas id="doughnutChart" width="200" height="200"></canvas>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="flex items-center gap-3 p-3 bg-green-100 rounded-xl border border-green-300">
                                <div class="w-4 h-4 bg-green-600 rounded-full"></div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900">Organik</div>
                                    <div class="text-xs text-green-700 font-bold">70%</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-blue-100 rounded-xl border border-blue-300">
                                <div class="w-4 h-4 bg-blue-600 rounded-full"></div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900">Anorganik</div>
                                    <div class="text-xs text-blue-700 font-bold">20%</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-yellow-100 rounded-xl border border-yellow-300">
                                <div class="w-4 h-4 bg-yellow-600 rounded-full"></div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900">B3</div>
                                    <div class="text-xs text-yellow-700 font-bold">10%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Line Chart -->
                <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 border-gray-200 mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-black text-gray-900 mb-2">Tren Keuangan 30 Hari Terakhir</h3>
                            <p class="text-gray-700 font-medium">Analisis tren pemasukan vs pengeluaran</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-3 bg-green-100 px-4 py-2 rounded-full border border-green-300">
                                <span class="w-4 h-4 bg-green-600 rounded-full"></span>
                                <span class="text-sm font-bold text-green-800">Pemasukan</span>
                            </div>
                            <div class="flex items-center gap-3 bg-red-100 px-4 py-2 rounded-full border border-red-300">
                                <span class="w-4 h-4 bg-red-600 rounded-full"></span>
                                <span class="text-sm font-bold text-red-800">Pengeluaran</span>
                            </div>
                        </div>
                    </div>
                    <div class="h-64">
                        <canvas id="lineChart" width="400" height="200"></canvas>
                    </div>
                    <div class="flex justify-between mt-4 text-sm text-gray-700 font-bold">
                        <span>1 Mar</span>
                        <span>15 Mar</span>
                        <span>30 Mar</span>
                    </div>
                </div>
                
                                <!-- Tabel Riwayat -->
                <div class="bg-white rounded-2xl shadow-2xl p-8 border-2 border-gray-200">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <div class="text-gray-900 text-2xl font-black mb-2" x-text="activeTab === 'pemasukan' ? 'Pemasukan' : 'Pengeluaran'"></div>
                            <div class="text-gray-700 text-lg font-bold">Cek riwayat <span x-text="activeTab === 'pemasukan' ? 'pemasukan' : 'pengeluaran'"></span> Anda!</div>
                        </div>
                        <div class="flex items-center gap-3">
                            <button onclick="exportData()" class="bg-blue-600 text-black px-4 py-2 rounded-lg hover:bg-blue-700 transition-all duration-300 font-bold shadow-lg">
                                <i class="fas fa-download mr-2"></i>Export
                            </button>
                            <button onclick="showFilterModal()" class="bg-green-600 text-black px-4 py-2 rounded-lg hover:bg-green-700 transition-all duration-300 font-bold shadow-lg">
                                <i class="fas fa-filter mr-2"></i>Filter
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b-2 border-gray-300 bg-gray-50">
                                    <th class="px-4 py-3 text-left font-black text-lg text-gray-900">No. Invoice</th>
                                    <th class="px-4 py-3 text-left font-black text-lg text-gray-900">Tanggal</th>
                                    <th class="px-4 py-3 text-left font-black text-lg text-gray-900">Nama Pembeli</th>
                                    <th class="px-4 py-3 text-left font-black text-lg text-gray-900">Nama Produk</th>
                                    <th class="px-4 py-3 text-left font-black text-lg text-gray-900">Kategori</th>
                                    <th class="px-4 py-3 text-left font-black text-lg text-gray-900">Harga</th>
                                    <th class="px-4 py-3 text-left font-black text-lg text-gray-900">Status</th>
                                    <th class="px-4 py-3 text-left font-black text-lg text-gray-900">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < 8; $i++)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-all duration-300">
                                    <td class="px-4 py-3 font-bold text-gray-900">1#TEK12{{ $i+3 }}</td>
                                    <td class="px-4 py-3 font-bold text-gray-900">16/06/25</td>
                                    <td class="px-4 py-3 font-bold text-gray-900">{{ $i % 2 == 0 ? 'Wugis' : 'BS' }}</td>
                                    <td class="px-4 py-3 font-bold text-gray-900">{{ $i % 2 == 0 ? 'T#Tas Kreasi' : 'TopUp Coin' }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-2 rounded-full text-sm font-black {{ $i % 3 == 0 ? 'bg-green-100 text-green-800 border-2 border-green-300' : ($i % 3 == 1 ? 'bg-blue-100 text-blue-800 border-2 border-blue-300' : 'bg-yellow-100 text-yellow-800 border-2 border-yellow-300') }}">
                                            {{ $i % 3 == 0 ? 'Organik' : ($i % 3 == 1 ? 'Anorganik' : 'B3') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 font-black text-lg text-gray-900">Rp{{ number_format(20000 + ($i * 5000)) }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-2 rounded-full text-sm font-black bg-green-100 text-green-800 border-2 border-green-300">
                                            Selesai
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <button onclick="viewTransaction('{{ $i+3 }}')" class="text-blue-600 hover:text-blue-800 transition-all duration-300 hover:scale-110" title="Lihat Detail">
                                                <i class="fas fa-eye text-lg"></i>
                                            </button>
                                            <button onclick="downloadInvoice('{{ $i+3 }}')" class="text-green-600 hover:text-green-800 transition-all duration-300 hover:scale-110" title="Download Invoice">
                                                <i class="fas fa-download text-lg"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                    <div class="flex items-center justify-between mt-6">
                        <div class="text-gray-700 text-lg font-bold">
                            Menampilkan 1-8 dari 24 transaksi
                        </div>
                        <div class="flex items-center gap-3">
                            <button onclick="previousPage()" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-all duration-300 font-bold border-2 border-gray-300">
                                <i class="fas fa-chevron-left mr-2"></i>Sebelumnya
                            </button>
                            <span class="text-gray-900 px-4 py-2 font-black text-lg bg-blue-100 rounded-lg border-2 border-blue-300">1</span>
                            <button onclick="nextPage()" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-all duration-300 font-bold border-2 border-gray-300">
                                Selanjutnya<i class="fas fa-chevron-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
             </div>
         </div>
     </div>
 </div>

 <!-- Filter Modal -->
 <div id="filterModal" class="fixed inset-0 bg-black bg-opacity-50 z-50" style="display: none; opacity: 0; visibility: hidden;">
     <div class="flex items-center justify-center min-h-screen p-4">
         <div class="bg-white rounded-lg p-6 w-96 shadow-2xl mx-auto">
             <div class="flex items-center justify-between mb-4">
                 <h3 class="text-lg font-semibold">Filter Transaksi</h3>
                 <button onclick="hideFilterModal()" class="text-gray-500 hover:text-gray-700">
                     <i class="fas fa-times"></i>
                 </button>
             </div>
             <div class="space-y-4">
                                 <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="date" id="filterTanggal" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select id="filterKategori" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="">Semua Kategori</option>
                        <option value="Organik">Organik</option>
                        <option value="Anorganik">Anorganik</option>
                        <option value="B3">B3</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select id="filterStatus" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="">Semua Status</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Pending">Pending</option>
                        <option value="Batal">Batal</option>
                    </select>
                </div>
                 <div class="flex gap-2 pt-4">
                     <button onclick="applyFilter()" class="flex-1 bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">
                         Terapkan
                     </button>
                     <button onclick="resetFilter()" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400">
                         Reset
                     </button>
                </div>
            </div>
        </div>
    </div>
</div>

 <!-- Transaction Detail Modal -->
 <div id="transactionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
     <div class="flex items-center justify-center min-h-screen">
         <div class="bg-white rounded-lg p-6 w-96">
             <div class="flex items-center justify-between mb-4">
                 <h3 class="text-lg font-semibold">Detail Transaksi</h3>
                 <button onclick="hideTransactionModal()" class="text-gray-500 hover:text-gray-700">
                     <i class="fas fa-times"></i>
                 </button>
             </div>
             <div id="transactionDetails" class="space-y-3">
                 <!-- Transaction details will be populated here -->
             </div>
         </div>
     </div>
 </div>

 <script>
 // Sidebar functionality
 document.addEventListener('DOMContentLoaded', function() {
     // Initialize sidebar state
     window.sidebarOpen = false;
     
     // Update current date
     function updateCurrentDate() {
         const now = new Date();
         const options = { 
             day: 'numeric', 
             month: 'long', 
             year: 'numeric' 
         };
         const dateString = now.toLocaleDateString('id-ID', options);
         
         // Update all date elements with various IDs
         const dateSelectors = ['#currentDate', '#currentDate2', '#current-date', '[data-date="current"]'];
         dateSelectors.forEach(selector => {
             const elements = document.querySelectorAll(selector);
             elements.forEach(element => {
                 if (element) {
                     element.textContent = dateString;
                 }
             });
         });
     }
     
     // Set initial date and update every minute
     updateCurrentDate();
     setInterval(updateCurrentDate, 60000); // Update every minute
     
          // Data transaksi untuk Pemasukan dan Pengeluaran - Global variables
     window.pemasukanTransactions = [
         { invoice: '1#TEK123', tanggal: '16/06/25', pembeli: 'Wugis', produk: 'T#Tas Kreasi', kategori: 'Organik', harga: 'Rp20.000', status: 'Selesai', tipe: 'pemasukan' },
         { invoice: '1#TEK124', tanggal: '16/06/25', pembeli: 'BS', produk: 'TopUp Coin', kategori: 'Anorganik', harga: 'Rp25.000', status: 'Selesai', tipe: 'pemasukan' },
         { invoice: '1#TEK125', tanggal: '16/06/25', pembeli: 'Wugis', produk: 'T#Tas Kreasi', kategori: 'B3', harga: 'Rp30.000', status: 'Selesai', tipe: 'pemasukan' },
         { invoice: '1#TEK126', tanggal: '16/06/25', pembeli: 'BS', produk: 'TopUp Coin', kategori: 'Organik', harga: 'Rp35.000', status: 'Selesai', tipe: 'pemasukan' },
         { invoice: '1#TEK127', tanggal: '16/06/25', pembeli: 'Wugis', produk: 'T#Tas Kreasi', kategori: 'Anorganik', harga: 'Rp40.000', status: 'Selesai', tipe: 'pemasukan' },
         { invoice: '1#TEK128', tanggal: '16/06/25', pembeli: 'BS', produk: 'TopUp Coin', kategori: 'B3', harga: 'Rp45.000', status: 'Selesai', tipe: 'pemasukan' },
         { invoice: '1#TEK129', tanggal: '16/06/25', pembeli: 'Wugis', produk: 'T#Tas Kreasi', kategori: 'Organik', harga: 'Rp50.000', status: 'Selesai', tipe: 'pemasukan' },
         { invoice: '1#TEK1210', tanggal: '16/06/25', pembeli: 'BS', produk: 'TopUp Coin', kategori: 'Anorganik', harga: 'Rp55.000', status: 'Selesai', tipe: 'pemasukan' }
     ];
     
     window.pengeluaranTransactions = [
         { invoice: '1#EXP001', tanggal: '16/06/25', pembeli: 'Supplier A', produk: 'Bahan Baku', kategori: 'Operasional', harga: 'Rp15.000', status: 'Selesai', tipe: 'pengeluaran' },
         { invoice: '1#EXP002', tanggal: '16/06/25', pembeli: 'Supplier B', produk: 'Peralatan', kategori: 'Investasi', harga: 'Rp25.000', status: 'Selesai', tipe: 'pengeluaran' },
         { invoice: '1#EXP003', tanggal: '16/06/25', pembeli: 'Supplier C', produk: 'Utilitas', kategori: 'Operasional', harga: 'Rp12.000', status: 'Pending', tipe: 'pengeluaran' },
         { invoice: '1#EXP004', tanggal: '16/06/25', pembeli: 'Supplier D', produk: 'Marketing', kategori: 'Pemasaran', harga: 'Rp18.000', status: 'Selesai', tipe: 'pengeluaran' },
         { invoice: '1#EXP005', tanggal: '16/06/25', pembeli: 'Supplier E', produk: 'Gaji Karyawan', kategori: 'SDM', harga: 'Rp35.000', status: 'Selesai', tipe: 'pengeluaran' },
         { invoice: '1#EXP006', tanggal: '16/06/25', pembeli: 'Supplier F', produk: 'Sewa Tempat', kategori: 'Operasional', harga: 'Rp22.000', status: 'Selesai', tipe: 'pengeluaran' },
         { invoice: '1#EXP007', tanggal: '16/06/25', pembeli: 'Supplier G', produk: 'Asuransi', kategori: 'Keamanan', harga: 'Rp8.000', status: 'Pending', tipe: 'pengeluaran' },
         { invoice: '1#EXP008', tanggal: '16/06/25', pembeli: 'Supplier H', produk: 'Maintenance', kategori: 'Operasional', harga: 'Rp16.000', status: 'Selesai', tipe: 'pengeluaran' }
     ];
     
     // Global variable untuk menyimpan data aktif
     window.currentTransactionData = window.pemasukanTransactions;
     window.currentTransactionType = 'pemasukan';
     
     // Initialize transaction table with pemasukan data
     updateTransactionTable('pemasukan');
     
     // Wait for Chart.js to load and then initialize charts
     function loadCharts() {
         if (typeof Chart !== 'undefined') {
             initializeCharts();
         } else {
             // If Chart.js is not loaded yet, wait for it
             const checkChartJS = setInterval(() => {
                 if (typeof Chart !== 'undefined') {
                     clearInterval(checkChartJS);
                     initializeCharts();
                 }
             }, 100);
             
             // Timeout after 10 seconds
             setTimeout(() => {
                 clearInterval(checkChartJS);
                 console.error('Chart.js failed to load');
             }, 10000);
         }
     }
     
     // Try to load charts immediately
     loadCharts();
     
     // Also try when window is fully loaded
     window.addEventListener('load', loadCharts);
     
     function initializeCharts() {
         console.log('Initializing charts...');
         
         // Chart.js Charts
         // Data untuk pemasukan dan pengeluaran
         const pemasukanData = [15000, 22000, 18000, 25000, 30000, 35000, 40000];
         const pengeluaranData = [8000, 12000, 10000, 15000, 17000, 20000, 22000];
         
         // Wait for Chart.js to be loaded
         if (typeof Chart === 'undefined') {
             console.error('Chart.js not loaded, retrying in 1 second...');
             setTimeout(initializeCharts, 1000);
             return;
         }
         
         console.log('Chart.js loaded successfully');
         // Use global variables instead of local ones
         const pemasukanTransactions = window.pemasukanTransactions;
         const pengeluaranTransactions = window.pengeluaranTransactions;

     // Bar Chart - Pemasukan 7 Hari
     let barCanvas = document.getElementById('barChart');
     if (!barCanvas) {
         console.error('Bar chart canvas not found, creating canvas...');
         // Create canvas if it doesn't exist
         const chartContainer = document.querySelector('.h-64');
         if (chartContainer) {
             barCanvas = document.createElement('canvas');
             barCanvas.id = 'barChart';
             barCanvas.width = 400;
             barCanvas.height = 200;
             chartContainer.appendChild(barCanvas);
         } else {
             setTimeout(initializeCharts, 1000);
             return;
         }
     }
     
     console.log('Bar chart canvas found, creating chart...');
     const barCtx = barCanvas.getContext('2d');
     const barChart = new Chart(barCtx, {
         type: 'bar',
         data: {
             labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
             datasets: [{
                 label: 'Pemasukan',
                 data: pemasukanData,
                 backgroundColor: 'rgba(59, 130, 246, 0.8)',
                 borderColor: 'rgba(59, 130, 246, 1)',
                 borderWidth: 1
             }]
         },
         options: {
             responsive: true,
             maintainAspectRatio: false,
             plugins: {
                 legend: {
                     display: false
                 }
             },
             scales: {
                 y: {
                     beginAtZero: true,
                     ticks: {
                         callback: function(value) {
                             return 'Rp' + value.toLocaleString();
                         }
                     }
                 }
             }
         }
     });

     // Toggle chart data on button click
     const btnPemasukan = document.querySelector('button:has(i.fa-arrow-up)');
     const btnPengeluaran = document.querySelector('button:has(i.fa-arrow-down)');
     // Judul chart
     const chartTitle = document.querySelector('h3.text-xl.font-black');
     // Legend chart
     const chartLegend = document.querySelector('.flex.items-center.gap-3.bg-blue-100, .flex.items-center.gap-3.bg-red-100');
     
     function updateBarChart(type) {
         if (type === 'pemasukan') {
             barChart.data.datasets[0].data = pemasukanData;
             barChart.data.datasets[0].label = 'Pemasukan';
             barChart.data.datasets[0].backgroundColor = 'rgba(59, 130, 246, 0.8)';
             barChart.data.datasets[0].borderColor = 'rgba(59, 130, 246, 1)';
             if (chartTitle) chartTitle.textContent = 'Tren Pemasukan 7 Hari Terakhir';
             if (chartLegend) {
                 chartLegend.classList.remove('bg-red-100', 'border-red-300');
                 chartLegend.classList.add('bg-blue-100', 'border-blue-300');
                 chartLegend.querySelector('span.w-4').className = 'w-4 h-4 bg-blue-600 rounded-full';
                 chartLegend.querySelector('span.text-sm').textContent = 'Pemasukan';
                 chartLegend.querySelector('span.text-sm').className = 'text-sm font-bold text-blue-800';
             }
         } else {
             barChart.data.datasets[0].data = pengeluaranData;
             barChart.data.datasets[0].label = 'Pengeluaran';
             barChart.data.datasets[0].backgroundColor = 'rgba(239, 68, 68, 0.8)';
             barChart.data.datasets[0].borderColor = 'rgba(239, 68, 68, 1)';
             if (chartTitle) chartTitle.textContent = 'Tren Pengeluaran 7 Hari Terakhir';
             if (chartLegend) {
                 chartLegend.classList.remove('bg-blue-100', 'border-blue-300');
                 chartLegend.classList.add('bg-red-100', 'border-red-300');
                 chartLegend.querySelector('span.w-4').className = 'w-4 h-4 bg-red-600 rounded-full';
                 chartLegend.querySelector('span.text-sm').textContent = 'Pengeluaran';
                 chartLegend.querySelector('span.text-sm').className = 'text-sm font-bold text-red-800';
             }
         }
         barChart.update();
     }
     if (btnPemasukan) btnPemasukan.addEventListener('click', function() { 
         updateBarChart('pemasukan'); 
         updateTransactionTable('pemasukan');
     });
     if (btnPengeluaran) btnPengeluaran.addEventListener('click', function() { 
         updateBarChart('pengeluaran'); 
         updateTransactionTable('pengeluaran');
     });

     // Doughnut Chart - Distribusi Kategori
     let doughnutCanvas = document.getElementById('doughnutChart');
     if (!doughnutCanvas) {
         console.error('Doughnut chart canvas not found, creating canvas...');
         // Create canvas if it doesn't exist
         const chartContainer = document.querySelector('.relative.w-48.h-48');
         if (chartContainer) {
             doughnutCanvas = document.createElement('canvas');
             doughnutCanvas.id = 'doughnutChart';
             doughnutCanvas.width = 200;
             doughnutCanvas.height = 200;
             chartContainer.appendChild(doughnutCanvas);
         } else {
             setTimeout(initializeCharts, 1000);
             return;
         }
     }
     
     console.log('Doughnut chart canvas found, creating chart...');
     const doughnutCtx = doughnutCanvas.getContext('2d');
     const doughnutChart = new Chart(doughnutCtx, {
         type: 'doughnut',
         data: {
             labels: ['Organik', 'Anorganik', 'B3'],
             datasets: [{
                 data: [70, 20, 10],
                 backgroundColor: [
                     'rgba(16, 185, 129, 0.8)',
                     'rgba(59, 130, 246, 0.8)',
                     'rgba(245, 158, 11, 0.8)'
                 ],
                 borderColor: [
                     'rgba(16, 185, 129, 1)',
                     'rgba(59, 130, 246, 1)',
                     'rgba(245, 158, 11, 1)'
                 ],
                 borderWidth: 2
             }]
         },
         options: {
             responsive: true,
             maintainAspectRatio: false,
             plugins: {
                 legend: {
                     display: false
                 }
             }
         }
     });

     // Line Chart - Tren Keuangan 30 Hari
     let lineCanvas = document.getElementById('lineChart');
     if (!lineCanvas) {
         console.error('Line chart canvas not found, creating canvas...');
         // Create canvas if it doesn't exist
         const chartContainer = document.querySelector('.h-64:last-of-type');
         if (chartContainer) {
             lineCanvas = document.createElement('canvas');
             lineCanvas.id = 'lineChart';
             lineCanvas.width = 400;
             lineCanvas.height = 200;
             chartContainer.appendChild(lineCanvas);
         } else {
             setTimeout(initializeCharts, 1000);
             return;
         }
     }
     
     console.log('Line chart canvas found, creating chart...');
     const lineCtx = lineCanvas.getContext('2d');
     const lineChart = new Chart(lineCtx, {
         type: 'line',
         data: {
             labels: Array.from({length: 30}, (_, i) => i + 1),
             datasets: [{
                 label: 'Pemasukan',
                 data: Array.from({length: 30}, () => Math.floor(Math.random() * 50000) + 10000),
                 borderColor: 'rgba(16, 185, 129, 1)',
                 backgroundColor: 'rgba(16, 185, 129, 0.1)',
                 tension: 0.4,
                 fill: true
             }, {
                 label: 'Pengeluaran',
                 data: Array.from({length: 30}, () => Math.floor(Math.random() * 20000) + 5000),
                 borderColor: 'rgba(239, 68, 68, 1)',
                 backgroundColor: 'rgba(239, 68, 68, 0.1)',
                 tension: 0.4,
                 fill: true
             }]
         },
         options: {
             responsive: true,
             maintainAspectRatio: false,
             plugins: {
                 legend: {
                     display: true,
                     position: 'top'
                 }
             },
             scales: {
                 y: {
                     beginAtZero: true,
                     ticks: {
                         callback: function(value) {
                             return 'Rp' + value.toLocaleString();
                         }
                     }
                 }
             }
         }
     });
     
     console.log('All charts initialized successfully!');
     
     // Force chart updates
     if (barChart) barChart.update();
     if (doughnutChart) doughnutChart.update();
     if (lineChart) lineChart.update();
     
     // Add some debugging info
     console.log('Bar chart:', barChart);
     console.log('Doughnut chart:', doughnutChart);
     console.log('Line chart:', lineChart);
     }
 });

 // Function implementations
function exportData() {
    // Buat data untuk export Excel
    const currentDate = new Date().toLocaleDateString('id-ID');
    
    // Data summary
    const summaryData = [
        ['LAPORAN KEUANGAN BIJAK SAMPAH'],
        [''],
        ['Tanggal Export:', currentDate],
        [''],
        ['SUMMARY KEUANGAN'],
        ['Total Saldo', 'Rp202.000'],
        ['Total Pemasukan', 'Rp156.000'],
        ['Total Pengeluaran', 'Rp45.000'],
        ['Total Transaksi', '24'],
        [''],
        ['DETAIL TRANSAKSI'],
        ['No. Invoice', 'Tanggal', 'Nama Pembeli', 'Nama Produk', 'Kategori', 'Harga', 'Status']
    ];
    
    // Data transaksi
    const transactionData = [];
    for (let i = 0; i < 8; i++) {
        transactionData.push([
            `1#TEK12${i+3}`,
            '16/06/25',
            i % 2 == 0 ? 'Wugis' : 'BS',
            i % 2 == 0 ? 'T#Tas Kreasi' : 'TopUp Coin',
            i % 3 == 0 ? 'Organik' : (i % 3 == 1 ? 'Anorganik' : 'B3'),
            `Rp${(20000 + (i * 5000)).toLocaleString()}`,
            'Selesai'
        ]);
    }
    
    // Gabungkan semua data
    const allData = [...summaryData, ...transactionData];
    
    // Convert ke CSV format (Excel compatible)
    let csvContent = '';
    allData.forEach(row => {
        const csvRow = row.map(cell => {
            // Escape quotes and wrap in quotes if contains comma
            if (typeof cell === 'string' && (cell.includes(',') || cell.includes('"') || cell.includes('\n'))) {
                return '"' + cell.replace(/"/g, '""') + '"';
            }
            return cell;
        }).join(',');
        csvContent += csvRow + '\n';
    });
    
    // Add BOM for Excel UTF-8 compatibility
    const BOM = '\uFEFF';
    csvContent = BOM + csvContent;
    
    // Create blob and download
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    
    if (link.download !== undefined) {
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', `laporan-keuangan-${currentDate.replace(/\//g, '-')}.csv`);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
    
    // Tampilkan notifikasi
    showNotification('Data berhasil diexport ke Excel!', 'success');
}

function showFilterModal() {
    const modal = document.getElementById('filterModal');
    if (modal) {
        // Show modal using CSS class
        modal.classList.add('show');
        modal.style.zIndex = '9999';
        
        // Reset form
        const tanggalInput = document.getElementById('filterTanggal');
        const kategoriSelect = document.getElementById('filterKategori');
        const statusSelect = document.getElementById('filterStatus');
        
        if (tanggalInput) tanggalInput.value = '';
        if (kategoriSelect) kategoriSelect.selectedIndex = 0;
        if (statusSelect) statusSelect.selectedIndex = 0;
        
        console.log('Filter modal opened');
    } else {
        console.error('Filter modal not found');
    }
}

function hideFilterModal() {
    const modal = document.getElementById('filterModal');
    if (modal) {
        // Hide modal using CSS class
        modal.classList.remove('show');
        modal.style.zIndex = '-1';
        console.log('Filter modal closed');
    }
}

function applyFilter() {
    console.log('Applying filter...');
    
    // Ambil nilai filter
    const tanggalInput = document.getElementById('filterTanggal');
    const kategoriSelect = document.getElementById('filterKategori');
    const statusSelect = document.getElementById('filterStatus');
    
    if (!tanggalInput || !kategoriSelect || !statusSelect) {
        console.error('Filter elements not found');
        showNotification('Error: Filter elements not found', 'error');
        return;
    }
    
    const tanggal = tanggalInput.value;
    const kategori = kategoriSelect.value;
    const status = statusSelect.value;
    
    console.log('Filter values:', { tanggal, kategori, status });
    
    // Gunakan data transaksi yang aktif (pemasukan atau pengeluaran)
    const allData = window.currentTransactionData || window.pemasukanTransactions;
    
    // Filter berdasarkan kriteria
    let filteredData = allData.filter(item => {
        let match = true;
        
        // Filter tanggal (jika dipilih)
        if (tanggal && tanggal !== '') {
            // Convert tanggal input ke format yang sama dengan data
            const inputDate = new Date(tanggal);
            const itemDate = new Date('2025-06-16'); // Tanggal dalam data
            if (inputDate.getDate() !== itemDate.getDate() || 
                inputDate.getMonth() !== itemDate.getMonth() || 
                inputDate.getFullYear() !== itemDate.getFullYear()) {
                match = false;
            }
        }
        
        // Filter kategori (jika dipilih)
        if (kategori && kategori !== '') {
            if (item.kategori !== kategori) {
                match = false;
            }
        }
        
        // Filter status (jika dipilih)
        if (status && status !== '') {
            if (item.status !== status) {
                match = false;
            }
        }
        
        return match;
    });
    
    console.log('Filtered data:', filteredData);
    
    // Update tabel dengan data yang difilter
    updateTableData(filteredData);
    
    // Tampilkan notifikasi
    const filterCount = filteredData.length;
    const message = filteredData.length > 0 
        ? `Filter diterapkan! Menampilkan ${filterCount} transaksi ${window.currentTransactionType}.` 
        : `Tidak ada data ${window.currentTransactionType} yang sesuai dengan filter.`;
    showNotification(message, filteredData.length > 0 ? 'success' : 'info');
    
    hideFilterModal();
}

function resetFilter() {
    console.log('Resetting filter...');
    
    // Reset semua filter
    const tanggalInput = document.getElementById('filterTanggal');
    const kategoriSelect = document.getElementById('filterKategori');
    const statusSelect = document.getElementById('filterStatus');
    
    if (tanggalInput) tanggalInput.value = '';
    if (kategoriSelect) kategoriSelect.selectedIndex = 0;
    if (statusSelect) statusSelect.selectedIndex = 0;
    
    // Tampilkan semua data sesuai tipe transaksi aktif
    updateTableData([]);
    
    const currentType = window.currentTransactionType || 'pemasukan';
    showNotification(`Filter direset! Menampilkan semua transaksi ${currentType}.`, 'info');
    hideFilterModal();
}

function updateTableData(data) {
    console.log('Updating table with data:', data);
    
    // Cari tabel transaksi
    const table = document.querySelector('table');
    if (!table) {
        console.error('Table not found');
        return;
    }
    
    const tbody = table.querySelector('tbody');
    if (!tbody) {
        console.error('Table body not found');
        return;
    }
    
    // Jika tidak ada data filter atau data kosong, tampilkan data aktif
    if (!data || data.length === 0) {
        console.log('No filtered data, showing current transaction data');
        data = window.currentTransactionData || window.pemasukanTransactions;
    }
    
    // Clear existing rows
    tbody.innerHTML = '';
    
    // Add new rows
    data.forEach((item, index) => {
        const row = document.createElement('tr');
        row.className = 'border-b border-gray-200 hover:bg-gray-50 transition-all duration-300';
        
        // Tentukan status class berdasarkan status
        let statusClass = 'bg-green-100 text-green-800 border-2 border-green-300';
        if (item.status === 'Pending') {
            statusClass = 'bg-yellow-100 text-yellow-800 border-2 border-yellow-300';
        } else if (item.status === 'Batal') {
            statusClass = 'bg-red-100 text-red-800 border-2 border-red-300';
        }
        
        row.innerHTML = `
            <td class="px-4 py-3 font-bold text-gray-900">${item.invoice}</td>
            <td class="px-4 py-3 font-bold text-gray-900">${item.tanggal}</td>
            <td class="px-4 py-3 font-bold text-gray-900">${item.pembeli}</td>
            <td class="px-4 py-3 font-bold text-gray-900">${item.produk}</td>
            <td class="px-4 py-3">
                <span class="px-3 py-2 rounded-full text-sm font-black ${getCategoryClass(item.kategori)}">
                    ${item.kategori}
                </span>
            </td>
            <td class="px-4 py-3 font-black text-lg text-gray-900">${item.harga}</td>
            <td class="px-4 py-3">
                <span class="px-3 py-2 rounded-full text-sm font-black ${statusClass}">
                    ${item.status}
                </span>
            </td>
                                <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <button onclick="viewTransaction('${index+3}')" class="text-blue-600 hover:text-blue-800 transition-all duration-300 hover:scale-110" title="Lihat Detail">
                                <i class="fas fa-eye text-lg"></i>
                            </button>
                            <button onclick="downloadInvoice('${index+3}')" class="text-green-600 hover:text-green-800 transition-all duration-300 hover:scale-110" title="Download Invoice">
                                <i class="fas fa-download text-lg"></i>
                            </button>
                        </div>
                    </td>
        `;
        
        tbody.appendChild(row);
    });
    
    console.log(`Table updated with ${data.length} rows`);
}

function updateTransactionTable(type) {
    console.log('Updating transaction table for type:', type);
    
    if (type === 'pemasukan') {
        window.currentTransactionData = window.pemasukanTransactions;
        window.currentTransactionType = 'pemasukan';
    } else if (type === 'pengeluaran') {
        window.currentTransactionData = window.pengeluaranTransactions;
        window.currentTransactionType = 'pengeluaran';
    }
    
    // Update tabel dengan data yang sesuai
    updateTableData(window.currentTransactionData);
    
    // Update kategori filter berdasarkan tipe transaksi
    updateFilterCategories(type);
    
    console.log('Transaction table updated for:', type);
}

function updateFilterCategories(type) {
    const kategoriSelect = document.getElementById('filterKategori');
    if (!kategoriSelect) return;
    
    // Clear existing options
    kategoriSelect.innerHTML = '<option value="">Semua Kategori</option>';
    
    if (type === 'pemasukan') {
        // Kategori untuk pemasukan
        const pemasukanCategories = ['Organik', 'Anorganik', 'B3'];
        pemasukanCategories.forEach(category => {
            const option = document.createElement('option');
            option.value = category;
            option.textContent = category;
            kategoriSelect.appendChild(option);
        });
    } else if (type === 'pengeluaran') {
        // Kategori untuk pengeluaran
        const pengeluaranCategories = ['Operasional', 'Investasi', 'Pemasaran', 'SDM', 'Keamanan'];
        pengeluaranCategories.forEach(category => {
            const option = document.createElement('option');
            option.value = category;
            option.textContent = category;
            kategoriSelect.appendChild(option);
        });
    }
}

function getCategoryClass(kategori) {
    switch(kategori) {
        // Kategori Pemasukan
        case 'Organik':
            return 'bg-green-100 text-green-800 border-2 border-green-300';
        case 'Anorganik':
            return 'bg-blue-100 text-blue-800 border-2 border-blue-300';
        case 'B3':
            return 'bg-yellow-100 text-yellow-800 border-2 border-yellow-300';
        
        // Kategori Pengeluaran
        case 'Operasional':
            return 'bg-purple-100 text-purple-800 border-2 border-purple-300';
        case 'Investasi':
            return 'bg-indigo-100 text-indigo-800 border-2 border-indigo-300';
        case 'Pemasaran':
            return 'bg-pink-100 text-pink-800 border-2 border-pink-300';
        case 'SDM':
            return 'bg-orange-100 text-orange-800 border-2 border-orange-300';
        case 'Keamanan':
            return 'bg-red-100 text-red-800 border-2 border-red-300';
        
        default:
            return 'bg-gray-100 text-gray-800 border-2 border-gray-300';
    }
}

function showNotification(message, type = 'success') {
    // Buat elemen notifikasi
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300 ${
        type === 'success' ? 'bg-green-500 text-white' : 
        type === 'error' ? 'bg-red-500 text-white' : 
        'bg-blue-500 text-white'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(full)';
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

 function viewTransaction(id) {
     const details = {
         '3': { invoice: '1#TEK123', date: '16/06/25', buyer: 'Wugis', product: 'T#Tas Kreasi', amount: 'Rp20.000', status: 'Selesai' },
         '4': { invoice: '1#TEK124', date: '16/06/25', buyer: 'BS', product: 'TopUp Coin', amount: 'Rp25.000', status: 'Selesai' },
         '5': { invoice: '1#TEK125', date: '16/06/25', buyer: 'Wugis', product: 'T#Tas Kreasi', amount: 'Rp30.000', status: 'Selesai' },
         '6': { invoice: '1#TEK126', date: '16/06/25', buyer: 'BS', product: 'TopUp Coin', amount: 'Rp35.000', status: 'Selesai' },
         '7': { invoice: '1#TEK127', date: '16/06/25', buyer: 'Wugis', product: 'T#Tas Kreasi', amount: 'Rp40.000', status: 'Selesai' },
         '8': { invoice: '1#TEK128', date: '16/06/25', buyer: 'BS', product: 'TopUp Coin', amount: 'Rp45.000', status: 'Selesai' },
         '9': { invoice: '1#TEK129', date: '16/06/25', buyer: 'Wugis', product: 'T#Tas Kreasi', amount: 'Rp50.000', status: 'Selesai' },
         '10': { invoice: '1#TEK1210', date: '16/06/25', buyer: 'BS', product: 'TopUp Coin', amount: 'Rp55.000', status: 'Selesai' }
     };
     
     const transaction = details[id];
     if (transaction) {
         document.getElementById('transactionDetails').innerHTML = `
             <div><strong>No. Invoice:</strong> ${transaction.invoice}</div>
             <div><strong>Tanggal:</strong> ${transaction.date}</div>
             <div><strong>Pembeli:</strong> ${transaction.buyer}</div>
             <div><strong>Produk:</strong> ${transaction.product}</div>
             <div><strong>Jumlah:</strong> ${transaction.amount}</div>
             <div><strong>Status:</strong> <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">${transaction.status}</span></div>
         `;
         document.getElementById('transactionModal').classList.remove('hidden');
     }
 }

 function hideTransactionModal() {
     document.getElementById('transactionModal').classList.add('hidden');
 }

 function downloadInvoice(id) {
    console.log(`Generating invoice ${id}...`);
    
    // Cari data transaksi berdasarkan ID
    const allTransactions = [...window.pemasukanTransactions, ...window.pengeluaranTransactions];
    const transaction = allTransactions.find(t => t.invoice.includes(id)) || {
        invoice: `1#TEK${id}`,
        tanggal: '16/06/25',
        pembeli: 'Customer',
        produk: 'Product',
        kategori: 'Category',
        harga: 'Rp25.000',
        status: 'Selesai'
    };
    
    // Tampilkan modal preview invoice
    showInvoicePreview(transaction);
}

function showInvoicePreview(transaction) {
    // Buat modal preview
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
    modal.id = 'invoicePreviewModal';
    
    // Buat invoice HTML
    const invoiceHTML = `
        <div class="bg-white rounded-lg shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b">
                <h3 class="text-xl font-bold text-gray-900">Preview Invoice</h3>
                <div class="flex gap-2">
                    <button onclick="downloadInvoiceAsImage('${transaction.invoice}', 'png')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all duration-300">
                        <i class="fas fa-download mr-2"></i>Download PNG
                    </button>
                    <button onclick="downloadInvoiceAsImage('${transaction.invoice}', 'jpg')" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">
                        <i class="fas fa-download mr-2"></i>Download JPG
                    </button>
                    <button onclick="closeInvoicePreview()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-all duration-300">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="invoice-container" style="max-width: 800px; margin: 0 auto; border: 2px solid #05445E; border-radius: 10px; overflow: hidden;">
                    <div class="header" style="background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%); color: white; padding: 30px; text-align: center;">
                        <div class="logo" style="font-size: 24px; font-weight: bold; margin-bottom: 10px;">BIJAK SAMPAH</div>
                        <div class="company-info" style="font-size: 14px; opacity: 0.9;">
                            Platform Pengelolaan Sampah Pintar<br>
                            Jl. Contoh No. 123, Jakarta<br>
                            Telp: (021) 1234-5678 | Email: info@bijaksampah.com
                        </div>
                    </div>
                    
                    <div class="invoice-title" style="background: #f8f9fa; padding: 20px; border-bottom: 1px solid #dee2e6;">
                        <div class="invoice-number" style="font-size: 18px; font-weight: bold; color: #05445E;">INVOICE: ${transaction.invoice}</div>
                        <div class="invoice-date" style="color: #6c757d; margin-top: 5px;">Tanggal: ${transaction.tanggal}</div>
                    </div>
                    
                    <div class="details" style="padding: 30px;">
                        <div class="row" style="display: flex; justify-content: space-between; margin-bottom: 15px; padding: 10px 0; border-bottom: 1px solid #f1f3f4;">
                            <div class="label" style="font-weight: bold; color: #05445E; min-width: 150px;">No. Invoice:</div>
                            <div class="value" style="text-align: right; color: #333;">${transaction.invoice}</div>
                        </div>
                        <div class="row" style="display: flex; justify-content: space-between; margin-bottom: 15px; padding: 10px 0; border-bottom: 1px solid #f1f3f4;">
                            <div class="label" style="font-weight: bold; color: #05445E; min-width: 150px;">Tanggal:</div>
                            <div class="value" style="text-align: right; color: #333;">${transaction.tanggal}</div>
                        </div>
                        <div class="row" style="display: flex; justify-content: space-between; margin-bottom: 15px; padding: 10px 0; border-bottom: 1px solid #f1f3f4;">
                            <div class="label" style="font-weight: bold; color: #05445E; min-width: 150px;">Nama Pembeli:</div>
                            <div class="value" style="text-align: right; color: #333;">${transaction.pembeli}</div>
                        </div>
                        <div class="row" style="display: flex; justify-content: space-between; margin-bottom: 15px; padding: 10px 0; border-bottom: 1px solid #f1f3f4;">
                            <div class="label" style="font-weight: bold; color: #05445E; min-width: 150px;">Nama Produk:</div>
                            <div class="value" style="text-align: right; color: #333;">${transaction.produk}</div>
                        </div>
                        <div class="row" style="display: flex; justify-content: space-between; margin-bottom: 15px; padding: 10px 0; border-bottom: 1px solid #f1f3f4;">
                            <div class="label" style="font-weight: bold; color: #05445E; min-width: 150px;">Kategori:</div>
                            <div class="value" style="text-align: right; color: #333;">${transaction.kategori}</div>
                        </div>
                        <div class="row" style="display: flex; justify-content: space-between; margin-bottom: 15px; padding: 10px 0; border-bottom: 1px solid #f1f3f4;">
                            <div class="label" style="font-weight: bold; color: #05445E; min-width: 150px;">Status:</div>
                            <div class="value" style="text-align: right; color: #333;">
                                <span class="status-badge" style="background: #28a745; color: white; padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: bold;">${transaction.status}</span>
                            </div>
                        </div>
                        
                        <div class="total" style="background: #e8f5e8; padding: 20px; margin-top: 20px; border-radius: 8px; border-left: 4px solid #28a745;">
                            <div class="total-row" style="display: flex; justify-content: space-between; font-size: 18px; font-weight: bold;">
                                <div>Total Pembayaran:</div>
                                <div>${transaction.harga}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="footer" style="background: #f8f9fa; padding: 20px; text-align: center; color: #6c757d; font-size: 12px;">
                        <strong>Terima kasih telah menggunakan layanan Bijak Sampah!</strong><br>
                        Invoice ini adalah bukti transaksi yang sah.<br>
                        Simpan invoice ini untuk keperluan administrasi.
                    </div>
                </div>
            </div>
        </div>
    `;
    
    modal.innerHTML = invoiceHTML;
    document.body.appendChild(modal);
}

function closeInvoicePreview() {
    const modal = document.getElementById('invoicePreviewModal');
    if (modal) {
        document.body.removeChild(modal);
    }
}

function downloadInvoiceAsImage(invoiceId, format) {
    const allTransactions = [...window.pemasukanTransactions, ...window.pengeluaranTransactions];
    const transaction = allTransactions.find(t => t.invoice.includes(invoiceId)) || {
        invoice: invoiceId,
        tanggal: '16/06/25',
        pembeli: 'Customer',
        produk: 'Product',
        kategori: 'Category',
        harga: 'Rp25.000',
        status: 'Selesai'
    };
    
    // Buat invoice HTML
    const invoiceHTML = `
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Invoice ${transaction.invoice}</title>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    margin: 0;
                    padding: 20px;
                    background: white;
                    color: #333;
                }
                .invoice-container {
                    max-width: 800px;
                    margin: 0 auto;
                    border: 2px solid #05445E;
                    border-radius: 10px;
                    overflow: hidden;
                }
                .header {
                    background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
                    color: white;
                    padding: 30px;
                    text-align: center;
                }
                .logo {
                    font-size: 24px;
                    font-weight: bold;
                    margin-bottom: 10px;
                }
                .company-info {
                    font-size: 14px;
                    opacity: 0.9;
                }
                .invoice-title {
                    background: #f8f9fa;
                    padding: 20px;
                    border-bottom: 1px solid #dee2e6;
                }
                .invoice-number {
                    font-size: 18px;
                    font-weight: bold;
                    color: #05445E;
                }
                .invoice-date {
                    color: #6c757d;
                    margin-top: 5px;
                }
                .details {
                    padding: 30px;
                }
                .row {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 15px;
                    padding: 10px 0;
                    border-bottom: 1px solid #f1f3f4;
                }
                .label {
                    font-weight: bold;
                    color: #05445E;
                    min-width: 150px;
                }
                .value {
                    text-align: right;
                    color: #333;
                }
                .total {
                    background: #e8f5e8;
                    padding: 20px;
                    margin-top: 20px;
                    border-radius: 8px;
                    border-left: 4px solid #28a745;
                }
                .total-row {
                    display: flex;
                    justify-content: space-between;
                    font-size: 18px;
                    font-weight: bold;
                }
                .footer {
                    background: #f8f9fa;
                    padding: 20px;
                    text-align: center;
                    color: #6c757d;
                    font-size: 12px;
                }
                .status-badge {
                    background: #28a745;
                    color: white;
                    padding: 5px 15px;
                    border-radius: 20px;
                    font-size: 12px;
                    font-weight: bold;
                }
            </style>
        </head>
        <body>
            <div class="invoice-container">
                <div class="header">
                    <div class="logo">BIJAK SAMPAH</div>
                    <div class="company-info">
                        Platform Pengelolaan Sampah Pintar<br>
                        Jl. Contoh No. 123, Jakarta<br>
                        Telp: (021) 1234-5678 | Email: info@bijaksampah.com
                    </div>
                </div>
                
                <div class="invoice-title">
                    <div class="invoice-number">INVOICE: ${transaction.invoice}</div>
                    <div class="invoice-date">Tanggal: ${transaction.tanggal}</div>
                </div>
                
                <div class="details">
                    <div class="row">
                        <div class="label">No. Invoice:</div>
                        <div class="value">${transaction.invoice}</div>
                    </div>
                    <div class="row">
                        <div class="label">Tanggal:</div>
                        <div class="value">${transaction.tanggal}</div>
                    </div>
                    <div class="row">
                        <div class="label">Nama Pembeli:</div>
                        <div class="value">${transaction.pembeli}</div>
                    </div>
                    <div class="row">
                        <div class="label">Nama Produk:</div>
                        <div class="value">${transaction.produk}</div>
                    </div>
                    <div class="row">
                        <div class="label">Kategori:</div>
                        <div class="value">${transaction.kategori}</div>
                    </div>
                    <div class="row">
                        <div class="label">Status:</div>
                        <div class="value">
                            <span class="status-badge">${transaction.status}</span>
                        </div>
                    </div>
                    
                    <div class="total">
                        <div class="total-row">
                            <div>Total Pembayaran:</div>
                            <div>${transaction.harga}</div>
                        </div>
                    </div>
                </div>
                
                <div class="footer">
                    <strong>Terima kasih telah menggunakan layanan Bijak Sampah!</strong><br>
                    Invoice ini adalah bukti transaksi yang sah.<br>
                    Simpan invoice ini untuk keperluan administrasi.
                </div>
            </div>
        </body>
        </html>
    `;
    
    // Buat temporary div untuk render HTML
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = invoiceHTML;
    tempDiv.style.position = 'absolute';
    tempDiv.style.left = '-9999px';
    tempDiv.style.width = '800px';
    document.body.appendChild(tempDiv);
    
    // Gunakan html2canvas untuk convert HTML ke canvas
    if (typeof html2canvas !== 'undefined') {
        html2canvas(tempDiv.querySelector('.invoice-container'), {
            width: 800,
            height: 1200,
            scale: 2,
            backgroundColor: '#ffffff',
            useCORS: true,
            allowTaint: true
        }).then(canvas => {
            // Download sesuai format
            const link = document.createElement('a');
            link.download = `invoice-${transaction.invoice}.${format}`;
            
            if (format === 'png') {
                link.href = canvas.toDataURL('image/png');
            } else if (format === 'jpg') {
                link.href = canvas.toDataURL('image/jpeg', 0.9);
            }
            
            link.click();
            
            // Cleanup
            document.body.removeChild(tempDiv);
            
            showNotification(`Invoice ${transaction.invoice} berhasil diunduh sebagai ${format.toUpperCase()}!`, 'success');
        }).catch(error => {
            console.error('Error generating invoice:', error);
            showNotification('Gagal mengunduh invoice. Silakan coba lagi.', 'error');
            document.body.removeChild(tempDiv);
        });
    } else {
        // Fallback jika html2canvas tidak tersedia
        alert('Fitur download invoice memerlukan library html2canvas. Silakan refresh halaman.');
        document.body.removeChild(tempDiv);
    }
}

 // Function showTransactionMenu removed as requested

 function previousPage() {
     alert('Halaman sebelumnya');
     // Implement pagination
 }

 function nextPage() {
     alert('Halaman berikutnya');
     // Implement pagination
 }
 </script>
 @endsection 