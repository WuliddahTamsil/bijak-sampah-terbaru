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

    /* Custom styles for nasabah dashboard */
    .notif-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #75E6DA, #05445E);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .card:hover::before {
        opacity: 1;
    }

    .card h4 {
        color: #0a3a60;
        font-weight: 600;
        font-size: 17px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card h4 i {
        color: #05445E;
        font-size: 20px;
    }

    .card p {
        font-size: 15px;
        color: #555;
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        color: #777;
    }

    .card-actions {
        display: flex;
        gap: 10px;
    }

    .card-btn {
        background: none;
        border: none;
        color: #05445E;
        cursor: pointer;
        font-size: 14px;
        padding: 4px 8px;
        border-radius: 4px;
        transition: all 0.2s;
    }

    .card-btn:hover {
        background: rgba(5, 68, 94, 0.1);
    }

    .card-btn.delete:hover {
        color: #FF5A5F;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-primary {
        background-color: #e1f0fa;
        color: #05445E;
    }

    .badge-success {
        background-color: #e6f7ed;
        color: #10B981;
    }

    .badge-warning {
        background-color: #fff4e6;
        color: #f97316;
    }

    /* Chart styles */
    .chart-section {
        background: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    .chart-title {
        color: #0a3a60;
        font-weight: 700;
        font-size: 22px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .chart-title i {
        color: #05445E;
        font-size: 24px;
    }

    .chart-sub {
        font-size: 15px;
        color: #777;
        margin-bottom: 30px;
    }
    
    .chart-content {
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        position: relative;
        height: 220px;
        padding-top: 40px;
        padding-bottom: 30px;
    }

    .chart-content::before {
        content: '';
        position: absolute;
        bottom: 30px;
        left: 0;
        width: 100%;
        height: 2px;
        background: #eee;
    }

    .chart-bar-item {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        min-width: 0;
        position: relative;
        height: var(--height);
        transition: height 0.3s ease;
    }

    .bar {
        width: 100%;
        max-width: 50px;
        background: linear-gradient(to top, #05445E, #189AB4);
        border-radius: 8px 8px 0 0;
        position: relative;
        height: 100%;
        transform: scaleY(0);
        transform-origin: bottom;
        animation: grow-scale 1.5s ease-out forwards;
        animation-delay: calc(var(--order) * 0.2s);
    }

    @keyframes grow-scale {
        from { transform: scaleY(0); }
        to { transform: scaleY(1); }
    }

    .bar-label {
        position: absolute;
        top: -40px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 13px;
        font-weight: 600;
        background: white;
        padding: 6px 12px;
        border-radius: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        white-space: nowrap;
        opacity: 0;
        animation: fadeIn 0.5s ease-out forwards;
        animation-delay: calc(var(--order) * 0.2s + 1s);
        color: #05445E;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateX(-50%) translateY(10px); }
        to { opacity: 1; transform: translateX(-50%) translateY(0); }
    }
    
    .day {
        position: absolute;
        bottom: -40px;
        width: 100%;
        text-align: center;
        font-size: 12px;
        color: #555;
    }

    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: white;
        border-radius: 16px;
        width: 90%;
        max-width: 500px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        animation: modalFadeIn 0.3s ease-out;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .modal-title {
        font-size: 22px;
        color: #05445E;
        font-weight: 700;
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #777;
        transition: all 0.2s;
    }

    .close-modal:hover {
        color: #05445E;
        transform: rotate(90deg);
    }

    .modal-body {
        margin-bottom: 25px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #555;
    }

    .form-group input, 
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 15px;
        transition: all 0.3s;
    }

    .form-group input:focus, 
    .form-group textarea:focus {
        border-color: #75E6DA;
        outline: none;
        box-shadow: 0 0 0 3px rgba(117, 230, 218, 0.2);
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #05445E 0%, #0A3A60 100%);
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #0A3A60 0%, #05445E 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(5, 68, 94, 0.3);
    }

    .btn-outline {
        background: white;
        border: 1px solid #ddd;
        color: #555;
    }

    .btn-outline:hover {
        background: #f5f5f5;
    }

    .btn-danger {
        background: #FF5A5F;
        color: white;
    }

    .btn-danger:hover {
        background: #e04a50;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 90, 95, 0.3);
    }

    /* Responsive fixes */
    @media (max-width: 1024px) {
        .main-content-wrapper { padding-left: 1rem; padding-right: 1rem; }
        .content-container { padding: 1.5rem; }
    }
    @media (max-width: 768px) {
        .main-content-wrapper { padding-left: 0.5rem; padding-right: 0.5rem; }
        .content-container { padding: 1rem; }
        .notif-cards {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="flex min-h-screen bg-gray-50" x-data="{ sidebarOpen: false }">
    {{-- Sidebar Overlay --}}
    <div class="sidebar-overlay" :class="{ 'active': sidebarOpen }" @click="sidebarOpen = false"></div>

    {{-- Sidebar --}}
    <aside
        x-data="{ open: false, active: 'dashboard' }"
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
                
                {{-- Marketplace Link --}}
                <a href="{{ route('tokou') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'marketplace' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'marketplace' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-store text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Marketplace</span>
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
    <div class="main-content-wrapper">
        {{-- Top Header Bar --}}
        <div class="fixed-header">
            <h1 class="text-white font-semibold text-lg">BijakSampah</h1>
            <div class="flex items-center gap-4">
                <button onclick="showDevelopmentModal('Notification')" class="relative hover:text-white/80 transition-colors">
                    <i class="far fa-bell text-white text-sm"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-medium">2</span>
                </button>
                <button onclick="showDevelopmentModal('Search')" class="focus:outline-none hover:text-white/80 transition-colors">
                    <i class="fas fa-search text-white text-sm"></i>
                </button>
                <div class="flex items-center gap-2">
                    <button onclick="showDevelopmentModal('Profile')" class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center border-2 border-gray-300 cursor-pointer hover:border-white/50 transition-colors">
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
            {{-- Welcome Section --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Dashboard - Nasabah</h1>
                <p class="text-sm text-gray-500">Selamat datang di marketplace daur ulang</p>
            </div>

            {{-- Notifikasi Section --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Notifikasi</h2>
                <div class="notif-cards" id="notifContainer">
                    <!-- Notifikasi akan dimuat di sini -->
                </div>
            </div>

            {{-- Aktivitas Section --}}
            <div class="chart-section">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Aktivitasmu</h2>
                        <p class="text-sm text-gray-500">Minggu Lalu</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold">
                            Hurraaahhh! Super Productive
                        </div>
                        <div class="text-2xl font-bold text-green-600">97%</div>
                        <button class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Bulan <i class="fas fa-chevron-down ml-1"></i>
                        </button>
                    </div>
                </div>

                <div class="chart-content" id="chart-content">
                    <!-- Grafik akan dimuat di sini -->
                </div>
            </div>

            <div class="text-center mt-8 text-gray-500">
                Created by <strong>TEK(G)</strong> | All Right Reserved!
            </div>
        </div>
    </div>
</div>

{{-- Modal untuk menu dalam pengembangan --}}
<div class="modal" id="developmentModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Fitur Dalam Pengembangan</h3>
            <button class="close-modal" id="closeDevelopmentModal">&times;</button>
        </div>
        <div class="modal-body">
            <div style="text-align: center; padding: 20px;">
                <i class="fas fa-tools" style="font-size: 48px; color: #05445E; margin-bottom: 20px;"></i>
                <h4 style="color: #05445E; font-size: 18px; margin-bottom: 10px;">Fitur Sedang Dikembangkan</h4>
                <p style="color: #666; font-size: 14px; line-height: 1.6;">
                    Fitur ini sedang dalam tahap pengembangan. 
                    Tim kami sedang bekerja keras untuk menghadirkan pengalaman terbaik untuk Anda.
                </p>
                <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                    <p style="color: #05445E; font-size: 12px; margin: 0;">
                        <i class="fas fa-clock"></i> Estimasi rilis: 2-3 minggu ke depan
                    </p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" id="closeDevModal">Mengerti</button>
        </div>
    </div>
</div>

<script>
    // Data Notifikasi sesuai gambar
    let notifications = [
        { 
            id: 1,
            title: "Koleksi Tas Daur Ulang Lucu",
            icon: "fas fa-shopping-bag",
            message: "Ramah lingkungan & stylish. Cek di Marketplace BijakSampah! ❤️",
            date: "22 Juni 2025",
            time: "20:45",
            priority: "Urgent",
            timeTag: "Kemarin"
        },
        { 
            id: 2,
            title: "Dompet daur ulang unik tersedia!",
            icon: "fas fa-wallet",
            message: "Anti air & ramah lingkungan. Cek di Marketplace BijakSampah! ❤️❤️❤️",
            date: "23 Juni 2025",
            time: "14:14",
            priority: "Medium",
            timeTag: "2 jam yang lalu"
        }
    ];

    // Data untuk grafik aktivitas sesuai gambar
    const chartData = [
        { height: 60, value: '60%', label: '16 Jun' }, 
        { height: 45, value: '45%', label: '17 Jun' }, 
        { height: 97, value: '97%', label: '18 Jun' },
        { height: 75, value: '75%', label: '19 Jun' }, 
        { height: 80, value: '80%', label: '20 Jun' }, 
        { height: 65, value: '65%', label: '21 Jun' }, 
        { height: 70, value: '70%', label: '22 Jun' }  
    ];

    // DOM Elements
    const notifContainer = document.getElementById('notifContainer');
    const chartContent = document.getElementById('chart-content');

    // Load Notifications
    function loadNotifications() {
        console.log('Loading notifications, count:', notifications.length);
        notifContainer.innerHTML = '';
        
        if (notifications.length === 0) {
            notifContainer.innerHTML = `
                <div class="col-span-full text-center py-8">
                    <i class="fas fa-bell-slash text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Tidak ada notifikasi</p>
                </div>
            `;
            return;
        }
        
        notifications.forEach(notif => {
            const card = document.createElement('div');
            card.className = 'card';
            
            // Priority badge color
            let priorityClass = '';
            if (notif.priority === 'Urgent') {
                priorityClass = 'bg-red-100 text-red-800';
            } else if (notif.priority === 'Medium') {
                priorityClass = 'bg-green-100 text-green-800';
            }
            
            card.innerHTML = `
                <div class="flex justify-between items-start mb-3">
                    <span class="badge badge-primary">${notif.timeTag}</span>
                    <div class="flex items-center gap-2">
                        <span class="badge ${priorityClass}">${notif.priority}</span>
                        <button class="card-btn delete" data-id="${notif.id}" onclick="deleteNotification(${notif.id})">
                            <i class="fas fa-trash text-red-500 hover:text-red-700"></i>
                        </button>
                    </div>
                </div>
                <h4><i class="${notif.icon}"></i> ${notif.title}</h4>
                <p>${notif.message}</p>
                <div class="card-footer">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar text-gray-400 text-xs"></i>
                        <span class="text-xs text-gray-500">${notif.date}</span>
                        <i class="fas fa-clock text-gray-400 text-xs"></i>
                        <span class="text-xs text-gray-500">${notif.time}</span>
                    </div>
                </div>
            `;
            notifContainer.appendChild(card);
        });

        // Update notification count
        updateNotificationCount();
    }

    // Generate Chart for activity trends
    function generateChart() {
        chartContent.innerHTML = '';
        
        // Generate bars for each day
        chartData.forEach((data, index) => {
            const chartBarItem = document.createElement('div');
            chartBarItem.className = 'chart-bar-item';
            chartBarItem.style.setProperty('--height', `${data.height}%`);
            
            // Add green color for the highest bar (18 Jun - 97%)
            let barClass = 'bar';
            if (data.height === 97) {
                barClass = 'bar green';
            }
            
            chartBarItem.innerHTML = `
                <div class="${barClass}" style="--order: ${index + 1};">
                    <span class="bar-label">${data.value} ${data.label}</span>
                </div>
                <div class="day">${data.label}</div>
            `;
            chartContent.appendChild(chartBarItem);
        });
    }

    // Update Notification Count in Topbar
    function updateNotificationCount() {
        const countElement = document.querySelector('.absolute.-top-1.-right-1');
        if (countElement) {
            countElement.textContent = notifications.length;
            if (notifications.length === 0) {
                countElement.style.display = 'none';
            } else {
                countElement.style.display = 'flex';
            }
        }
    }

    // Delete Notification
    function deleteNotification(id) {
        console.log('Deleting notification with ID:', id);
        
        if (confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) {
            // Remove from notifications array
            const initialLength = notifications.length;
            notifications = notifications.filter(notif => notif.id !== id);
            
            console.log('Notifications before:', initialLength, 'after:', notifications.length);
            
            // Reload notifications display
            loadNotifications();
            
            // Show success message
            showToast('Notifikasi berhasil dihapus!', 'success');
            
            // Update notification count in topbar
            updateNotificationCount();
        }
    }

    // Show Toast Message
    function showToast(message, type = 'success') {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white font-medium transition-all duration-300 transform translate-x-full`;
        
        if (type === 'success') {
            toast.className += ' bg-green-500';
        } else if (type === 'error') {
            toast.className += ' bg-red-500';
        }
        
        toast.textContent = message;
        document.body.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }

    // Show Development Modal
    function showDevelopmentModal(featureName) {
        const modal = document.getElementById('developmentModal');
        const title = modal.querySelector('.modal-title');
        title.textContent = `${featureName} - Fitur Dalam Pengembangan`;
        modal.style.display = 'flex';
    }

    // Close Development Modal
    document.getElementById('closeDevelopmentModal').addEventListener('click', function() {
        document.getElementById('developmentModal').style.display = 'none';
    });

    document.getElementById('closeDevModal').addEventListener('click', function() {
        document.getElementById('developmentModal').style.display = 'none';
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const developmentModal = document.getElementById('developmentModal');
        if (event.target === developmentModal) {
            developmentModal.style.display = 'none';
        }
    });

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing...');
        loadNotifications();
        generateChart();
        updateNotificationCount();
    });
</script>
@endsection