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

    /* Berita specific styles */
    .news-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .news-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.2);
    }
    .news-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(5, 68, 94, 0.8), rgba(117, 230, 218, 0.8));
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1;
    }
    .news-card:hover::before {
        opacity: 1;
    }
    .news-card-content {
        position: relative;
        z-index: 2;
    }
    .category-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 3;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        color: white;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.2);
    }
    .search-container {
        position: relative;
        max-width: 400px;
        width: 100%;
    }
    .search-input {
        width: 100%;
        padding: 12px 20px;
        padding-left: 50px;
        border: 2px solid #e5e7eb;
        border-radius: 25px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: white;
    }
    .search-input:focus {
        outline: none;
        border-color: #75E6DA;
        box-shadow: 0 0 0 3px rgba(117, 230, 218, 0.1);
    }
    .search-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }
    .filter-btn {
        transition: all 0.3s ease;
    }
    .filter-btn:hover {
        transform: scale(1.05);
    }
    .category-btn {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    .category-btn.active {
        background: linear-gradient(135deg, #75E6DA, #05445E);
        color: white;
        border-color: #75E6DA;
    }
    .category-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .news-image {
        transition: all 0.3s ease;
    }
    .news-card:hover .news-image {
        transform: scale(1.05);
    }
    .read-more-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .read-more-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }
    .read-more-btn:hover::before {
        left: 100%;
    }
    .stats-item {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .stats-item:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .stats-item.clicked {
        animation: pulse 0.6s ease-in-out;
    }
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    .floating-action {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 50;
    }
    .floating-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #75E6DA, #05445E);
        color: white;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .floating-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 25px rgba(0,0,0,0.4);
    }
    .bookmark-btn {
        transition: all 0.3s ease;
    }
    .bookmark-btn:hover {
        transform: scale(1.1);
    }
    .share-btn {
        transition: all 0.3s ease;
    }
    .share-btn:hover {
        transform: scale(1.05);
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .news-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .news-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.2);
    }
    .news-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(5, 68, 94, 0.8), rgba(117, 230, 218, 0.8));
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1;
    }
    .news-card:hover::before {
        opacity: 1;
    }
    .news-card-content {
        position: relative;
        z-index: 2;
    }
    .category-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 3;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        color: white;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.2);
    }
    .search-container {
        position: relative;
        max-width: 400px;
        width: 100%;
    }
    .search-input {
        width: 100%;
        padding: 12px 20px;
        padding-left: 50px;
        border: 2px solid #e5e7eb;
        border-radius: 25px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: white;
    }
    .search-input:focus {
        outline: none;
        border-color: #75E6DA;
        box-shadow: 0 0 0 3px rgba(117, 230, 218, 0.1);
    }
    .search-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }
    .filter-btn {
        transition: all 0.3s ease;
    }
    .filter-btn:hover {
        transform: scale(1.05);
    }
    .category-btn {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    .category-btn.active {
        background: linear-gradient(135deg, #75E6DA, #05445E);
        color: white;
        border-color: #75E6DA;
    }
    .category-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .news-image {
        transition: all 0.3s ease;
    }
    .news-card:hover .news-image {
        transform: scale(1.05);
    }
    .read-more-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .read-more-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }
    .read-more-btn:hover::before {
        left: 100%;
    }
    .stats-item {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .stats-item:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .stats-item.clicked {
        animation: pulse 0.6s ease-in-out;
    }
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    .floating-action {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 50;
    }
    .floating-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #75E6DA, #05445E);
        color: white;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .floating-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 25px rgba(0,0,0,0.4);
    }
    .bookmark-btn {
        transition: all 0.3s ease;
    }
    .bookmark-btn:hover {
        transform: scale(1.1);
    }
    .share-btn {
        transition: all 0.3s ease;
    }
    .share-btn:hover {
        transform: scale(1.05);
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Grid layout improvements */
    .news-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2.5rem;
        justify-items: center;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }
    
    @media (max-width: 767px) {
        .news-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 0 1rem;
        }
    }
    
    @media (min-width: 768px) and (max-width: 1023px) {
        .news-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 2.5rem;
        }
    }
    
    @media (min-width: 1024px) {
        .news-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 3rem;
        }
    }
    
    @media (min-width: 1280px) {
        .news-grid {
            gap: 3.5rem;
        }
    }
    
    .news-card {
        width: 100%;
        max-width: 100%;
        min-width: 280px;
        margin: 0;
        padding: 0.5rem;
    }
    
    /* Ensure grid fills space properly */
    .news-grid {
        justify-content: center;
        align-items: start;
    }
    
    /* Remove any unwanted margins */
    .content-container {
        padding-right: 0;
    }
    
    /* Center the entire news section */
    .news-section {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        margin-bottom: 3rem;
        padding: 0;
    }
</style>

<div class="flex min-h-screen bg-gray-50" x-data="{ sidebarOpen: false, activeCategory: 'all', searchQuery: '', showFilters: false }">
    {{-- Sidebar Overlay --}}
    <div class="sidebar-overlay" :class="{ 'active': sidebarOpen }" @click="sidebarOpen = false"></div>

    {{-- Sidebar --}}
    <aside
        x-data="{ open: false, active: 'berita' }"
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
                <button class="focus:outline-none" onclick="toggleSearch()">
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
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Berita Terkini 📰</h1>
                    <p class="text-gray-600 text-lg">Dapatkan informasi terbaru seputar pengelolaan sampah dan lingkungan</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="bg-white rounded-lg shadow-md px-4 py-2">
                        <i class="fas fa-calendar text-gray-500 mr-2"></i>
                        <span class="text-sm text-gray-600" id="currentDate2"></span>
                    </div>
                </div>
            </div>

                {{-- Search and Filter Section --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                    <div class="flex flex-col lg:flex-row gap-6 items-center">
                        {{-- Search Bar --}}
                        <div class="search-container flex-1">
                            <i class="fas fa-search search-icon"></i>
                            <input 
                                type="text" 
                                x-model="searchQuery"
                                placeholder="Cari berita..." 
                                class="search-input"
                            >
                        </div>
                        
                        {{-- Filter Buttons --}}
                        <div class="flex items-center gap-3">
                            <button 
                                @click="showFilters = !showFilters"
                                class="filter-btn bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-all duration-200"
                            >
                                <i class="fas fa-filter mr-2"></i>Filter
                            </button>
                            <button 
                                onclick="filterByCategory('all')"
                                data-category="all"
                                class="category-btn active px-4 py-2 rounded-lg font-medium"
                            >
                                Semua
                            </button>
                            <button 
                                onclick="filterByCategory('environment')"
                                data-category="environment"
                                class="category-btn bg-white border-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium"
                            >
                                Lingkungan
                            </button>
                            <button 
                                onclick="filterByCategory('technology')"
                                data-category="technology"
                                class="category-btn bg-white border-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium"
                            >
                                Teknologi
                            </button>
                        </div>
                    </div>
                    
                    {{-- Advanced Filters --}}
                    <div x-show="showFilters" x-transition class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Filter Lanjutan</h4>
                            <button onclick="resetAllFilters()" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                <i class="fas fa-undo mr-1"></i>Reset Semua
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                                <select id="sortSelect" onchange="applySort(this.value)" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                    <option value="latest">Terbaru</option>
                                    <option value="popular">Terpopuler</option>
                                    <option value="az">A-Z</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Periode</label>
                                <select id="periodSelect" onchange="applyPeriod(this.value)" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                    <option value="all">Semua Waktu</option>
                                    <option value="today">Hari Ini</option>
                                    <option value="week">Minggu Ini</option>
                                    <option value="month">Bulan Ini</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Penulis</label>
                                <select id="authorSelect" onchange="applyAuthor(this.value)" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                    <option value="all">Semua Penulis</option>
                                    <option value="Wugis">Wugis</option>
                                    <option value="BS Team">BS Team</option>
                                    <option value="Admin">Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Statistics Section - 2x2 Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="stats-item bg-white rounded-xl shadow-lg p-6 text-center cursor-pointer" onclick="showStatsDetail('news')">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-newspaper text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">156</h3>
                        <p class="text-gray-600 text-sm">Total Berita</p>
                        <div class="mt-2 text-xs text-green-600">
                            <i class="fas fa-arrow-up mr-1"></i>+12% dari bulan lalu
                        </div>
                    </div>
                    <div class="stats-item bg-white rounded-xl shadow-lg p-6 text-center cursor-pointer" onclick="showStatsDetail('views')">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-eye text-green-600 text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">2.4K</h3>
                        <p class="text-gray-600 text-sm">Total Views</p>
                        <div class="mt-2 text-xs text-green-600">
                            <i class="fas fa-arrow-up mr-1"></i>+8% dari bulan lalu
                        </div>
                    </div>
                    <div class="stats-item bg-white rounded-xl shadow-lg p-6 text-center cursor-pointer" onclick="showStatsDetail('likes')">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-heart text-purple-600 text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">89</h3>
                        <p class="text-gray-600 text-sm">Likes</p>
                        <div class="mt-2 text-xs text-green-600">
                            <i class="fas fa-arrow-up mr-1"></i>+15% dari bulan lalu
                        </div>
                    </div>
                    <div class="stats-item bg-white rounded-xl shadow-lg p-6 text-center cursor-pointer" onclick="showStatsDetail('shares')">
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-share text-orange-600 text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">45</h3>
                        <p class="text-gray-600 text-sm">Shares</p>
                        <div class="mt-2 text-xs text-green-600">
                            <i class="fas fa-arrow-up mr-1"></i>+22% dari bulan lalu
                        </div>
                    </div>
                </div>
                
                {{-- News Grid --}}
                <div class="news-section">
                    <div class="news-grid">
                    @php
                        $newsData = [
                            [
                                'title' => 'Inovasi Teknologi Daur Ulang Sampah Plastik',
                                'category' => 'technology',
                                'categoryName' => 'Teknologi',
                                'author' => 'Wugis',
                                'date' => '2 jam yang lalu',
                                'image' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80',
                                'avatar' => 'https://randomuser.me/api/portraits/women/44.jpg',
                                'excerpt' => 'Para pelaku UMKM semakin memperhatikan pentingnya pengelolaan sampah melalui pendekatan daur ulang yang berbasis teknologi.'
                            ],
                            [
                                'title' => 'Gerakan Bersih Lingkungan di Jakarta',
                                'category' => 'environment',
                                'categoryName' => 'Lingkungan',
                                'author' => 'BS Team',
                                'date' => '4 jam yang lalu',
                                'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?auto=format&fit=crop&w=400&q=80',
                                'avatar' => 'https://randomuser.me/api/portraits/men/32.jpg',
                                'excerpt' => 'Komunitas peduli lingkungan mengadakan aksi bersih-bersih di berbagai titik di Jakarta.'
                            ],
                            [
                                'title' => 'Pemanfaatan Sampah Organik untuk Kompos',
                                'category' => 'environment',
                                'categoryName' => 'Lingkungan',
                                'author' => 'Admin',
                                'date' => '6 jam yang lalu',
                                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=400&q=80',
                                'avatar' => 'https://randomuser.me/api/portraits/women/28.jpg',
                                'excerpt' => 'Cara mudah mengolah sampah organik menjadi kompos berkualitas tinggi untuk tanaman.'
                            ],
                            [
                                'title' => 'Aplikasi Pintar untuk Monitoring Sampah',
                                'category' => 'technology',
                                'categoryName' => 'Teknologi',
                                'author' => 'Wugis',
                                'date' => '8 jam yang lalu',
                                'image' => 'https://images.unsplash.com/photo-1518709268805-4e9042af2176?auto=format&fit=crop&w=400&q=80',
                                'avatar' => 'https://randomuser.me/api/portraits/women/44.jpg',
                                'excerpt' => 'Teknologi AI membantu mengoptimalkan pengumpulan dan pengolahan sampah di perkotaan.'
                            ],
                            [
                                'title' => 'Kampanye Zero Waste di Sekolah',
                                'category' => 'environment',
                                'categoryName' => 'Lingkungan',
                                'author' => 'BS Team',
                                'date' => '1 hari yang lalu',
                                'image' => 'https://images.unsplash.com/photo-1523050854058-8df81610e9c1?auto=format&fit=crop&w=400&q=80',
                                'avatar' => 'https://randomuser.me/api/portraits/men/45.jpg',
                                'excerpt' => 'Program edukasi lingkungan untuk siswa sekolah dasar dalam mengurangi sampah plastik.'
                            ],
                            [
                                'title' => 'Robot Pengumpul Sampah Otomatis',
                                'category' => 'technology',
                                'categoryName' => 'Teknologi',
                                'author' => 'Admin',
                                'date' => '2 hari yang lalu',
                                'image' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=400&q=80',
                                'avatar' => 'https://randomuser.me/api/portraits/women/67.jpg',
                                'excerpt' => 'Inovasi robot cerdas yang dapat mengumpulkan dan memilah sampah secara otomatis.'
                            ],
                            [
                                'title' => 'Teknologi Biogas dari Sampah Organik',
                                'category' => 'technology',
                                'categoryName' => 'Teknologi',
                                'author' => 'Wugis',
                                'date' => '3 hari yang lalu',
                                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=400&q=80',
                                'avatar' => 'https://randomuser.me/api/portraits/women/55.jpg',
                                'excerpt' => 'Pemanfaatan sampah organik untuk menghasilkan biogas sebagai sumber energi alternatif.'
                            ],
                            [
                                'title' => 'Program Bank Sampah Digital',
                                'category' => 'environment',
                                'categoryName' => 'Lingkungan',
                                'author' => 'BS Team',
                                'date' => '4 hari yang lalu',
                                'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?auto=format&fit=crop&w=400&q=80',
                                'avatar' => 'https://randomuser.me/api/portraits/men/78.jpg',
                                'excerpt' => 'Implementasi sistem digital untuk mengelola bank sampah secara lebih efisien.'
                            ],
                            [
                                'title' => 'Edukasi Lingkungan untuk Anak-anak',
                                'category' => 'environment',
                                'categoryName' => 'Lingkungan',
                                'author' => 'Admin',
                                'date' => '5 hari yang lalu',
                                'image' => 'https://images.unsplash.com/photo-1523050854058-8df81610e9c1?auto=format&fit=crop&w=400&q=80',
                                'avatar' => 'https://randomuser.me/api/portraits/women/33.jpg',
                                'excerpt' => 'Program edukasi lingkungan yang menyenangkan untuk anak-anak usia dini.'
                            ]
                        ];
                    @endphp
                    
                    @foreach($newsData as $index => $news)
                    <div class="news-card rounded-2xl shadow-lg bg-white pb-6 w-full max-w-sm" style="background: linear-gradient(180deg, #05445E 0%, #75E6DA 100%);">
                        <div class="relative">
                            <img src="{{ $news['image'] }}" class="w-full h-40 object-cover rounded-t-2xl news-image" alt="Berita">
                            <div class="category-badge">{{ $news['categoryName'] }}</div>
                            <div class="absolute top-3 right-3">
                                <button data-index="{{ $index }}" class="bookmark-btn w-8 h-8 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/30 transition-colors">
                                    <i class="far fa-bookmark"></i>
                                </button>
                            </div>
                        </div>
                        <div class="pt-10 px-4 text-center news-card-content">
                            <div class="flex items-center justify-center gap-2 mb-3">
                                <img src="{{ $news['avatar'] }}" class="w-6 h-6 rounded-full border-2 border-white" alt="Avatar">
                                <div class="text-left">
                                    <div class="font-bold text-white text-xs">{{ $news['author'] }}</div>
                                    <div class="text-white/80 text-xs">{{ $news['date'] }}</div>
                                </div>
                            </div>
                            <h3 class="font-bold text-white text-sm mb-2 line-clamp-2">{{ $news['title'] }}</h3>
                            <div class="text-white/90 text-xs mb-4 leading-relaxed line-clamp-3">{{ $news['excerpt'] }}</div>
                            <div class="flex items-center justify-between">
                                <button data-index="{{ $index }}" class="share-btn text-white/80 hover:text-white transition-colors text-xs">
                                    <i class="fas fa-share-alt mr-1"></i>Bagikan
                                </button>
                                <a href="/berita/{{ $index+1 }}" class="read-more-btn block bg-lime-400 hover:bg-lime-500 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-200 text-xs">
                                    Baca
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    </div>
                </div>
                
                {{-- Load More Button --}}
                <div class="text-center mt-12">
                    <button onclick="loadMoreNews()" class="bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white font-semibold py-4 px-8 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
                        <i class="fas fa-plus mr-2"></i>Muat Berita Lainnya
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Floating Action Button --}}
    <div class="floating-action">
        <button onclick="scrollToTop()" class="floating-btn">
            <i class="fas fa-arrow-up"></i>
        </button>
    </div>

<script>
// Global variables for news data
let currentNewsData = [];
let filteredNewsData = [];
let currentPage = 1;
let newsPerPage = 6;
let isLoading = false;

// Initialize news data
const newsData = [
    {
        id: 1,
        title: 'Inovasi Teknologi Daur Ulang Sampah Plastik',
        category: 'technology',
        categoryName: 'Teknologi',
        author: 'Wugis',
        date: '2 jam yang lalu',
        image: 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80',
        avatar: 'https://randomuser.me/api/portraits/women/44.jpg',
        excerpt: 'Para pelaku UMKM semakin memperhatikan pentingnya pengelolaan sampah melalui pendekatan daur ulang yang berbasis teknologi.',
        views: 1250,
        likes: 89,
        shares: 23,
        bookmarked: false
    },
    {
        id: 2,
        title: 'Gerakan Bersih Lingkungan di Jakarta',
        category: 'environment',
        categoryName: 'Lingkungan',
        author: 'BS Team',
        date: '4 jam yang lalu',
        image: 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?auto=format&fit=crop&w=400&q=80',
        avatar: 'https://randomuser.me/api/portraits/men/32.jpg',
        excerpt: 'Komunitas peduli lingkungan mengadakan aksi bersih-bersih di berbagai titik di Jakarta.',
        views: 980,
        likes: 67,
        shares: 15,
        bookmarked: false
    },
    {
        id: 3,
        title: 'Pemanfaatan Sampah Organik untuk Kompos',
        category: 'environment',
        categoryName: 'Lingkungan',
        author: 'Admin',
        date: '6 jam yang lalu',
        image: 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=400&q=80',
        avatar: 'https://randomuser.me/api/portraits/women/28.jpg',
        excerpt: 'Cara mudah mengolah sampah organik menjadi kompos berkualitas tinggi untuk tanaman.',
        views: 2100,
        likes: 145,
        shares: 34,
        bookmarked: false
    },
    {
        id: 4,
        title: 'Aplikasi Pintar untuk Monitoring Sampah',
        category: 'technology',
        categoryName: 'Teknologi',
        author: 'Wugis',
        date: '8 jam yang lalu',
        image: 'https://images.unsplash.com/photo-1518709268805-4e9042af2176?auto=format&fit=crop&w=400&q=80',
        avatar: 'https://randomuser.me/api/portraits/women/44.jpg',
        excerpt: 'Teknologi AI membantu mengoptimalkan pengumpulan dan pengolahan sampah di perkotaan.',
        views: 1800,
        likes: 112,
        shares: 28,
        bookmarked: false
    },
    {
        id: 5,
        title: 'Kampanye Zero Waste di Sekolah',
        category: 'environment',
        categoryName: 'Lingkungan',
        author: 'BS Team',
        date: '1 hari yang lalu',
        image: 'https://images.unsplash.com/photo-1523050854058-8df81610e9c1?auto=format&fit=crop&w=400&q=80',
        avatar: 'https://randomuser.me/api/portraits/men/45.jpg',
        excerpt: 'Program edukasi lingkungan untuk siswa sekolah dasar dalam mengurangi sampah plastik.',
        views: 1560,
        likes: 98,
        shares: 19,
        bookmarked: false
    },
    {
        id: 6,
        title: 'Robot Pengumpul Sampah Otomatis',
        category: 'technology',
        categoryName: 'Teknologi',
        author: 'Admin',
        date: '2 hari yang lalu',
        image: 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=400&q=80',
        avatar: 'https://randomuser.me/api/portraits/women/67.jpg',
        excerpt: 'Inovasi robot cerdas yang dapat mengumpulkan dan memilah sampah secara otomatis.',
        views: 3200,
        likes: 234,
        shares: 67,
        bookmarked: false
    },
    {
        id: 7,
        title: 'Teknologi Biogas dari Sampah Organik',
        category: 'technology',
        categoryName: 'Teknologi',
        author: 'Wugis',
        date: '3 hari yang lalu',
        image: 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=400&q=80',
        avatar: 'https://randomuser.me/api/portraits/women/55.jpg',
        excerpt: 'Pemanfaatan sampah organik untuk menghasilkan biogas sebagai sumber energi alternatif.',
        views: 890,
        likes: 56,
        shares: 12,
        bookmarked: false
    },
    {
        id: 8,
        title: 'Program Bank Sampah Digital',
        category: 'environment',
        categoryName: 'Lingkungan',
        author: 'BS Team',
        date: '4 hari yang lalu',
        image: 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?auto=format&fit=crop&w=400&q=80',
        avatar: 'https://randomuser.me/api/portraits/men/78.jpg',
        excerpt: 'Implementasi sistem digital untuk mengelola bank sampah secara lebih efisien.',
        views: 1450,
        likes: 87,
        shares: 21,
        bookmarked: false
    },
    {
        id: 9,
        title: 'Edukasi Lingkungan untuk Anak-anak',
        category: 'environment',
        categoryName: 'Lingkungan',
        author: 'Admin',
        date: '5 hari yang lalu',
        image: 'https://images.unsplash.com/photo-1523050854058-8df81610e9c1?auto=format&fit=crop&w=400&q=80',
        avatar: 'https://randomuser.me/api/portraits/women/33.jpg',
        excerpt: 'Program edukasi lingkungan yang menyenangkan untuk anak-anak usia dini.',
        views: 1100,
        likes: 73,
        shares: 16,
        bookmarked: false
    }
];

// Load more news function
function loadMoreNews() {
    if (isLoading) return;
    
    isLoading = true;
    const loadMoreBtn = document.querySelector('button[onclick="loadMoreNews()"]');
    const originalText = loadMoreBtn.innerHTML;
    
    // Show loading state
    loadMoreBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memuat...';
    loadMoreBtn.disabled = true;
    
    // Simulate loading delay
    setTimeout(() => {
        currentPage++;
        
        // Add more news data (simulate API call)
        const additionalNews = [
            {
                id: 10,
                title: 'Teknologi IoT untuk Smart Waste Management',
                category: 'technology',
                categoryName: 'Teknologi',
                author: 'Wugis',
                date: '1 minggu yang lalu',
                image: 'https://images.unsplash.com/photo-1518709268805-4e9042af2176?auto=format&fit=crop&w=400&q=80',
                avatar: 'https://randomuser.me/api/portraits/women/44.jpg',
                excerpt: 'Implementasi Internet of Things untuk monitoring sampah secara real-time.',
                views: 2100,
                likes: 156,
                shares: 45,
                bookmarked: false
            },
            {
                id: 11,
                title: 'Kampanye Plastik Ramah Lingkungan',
                category: 'environment',
                categoryName: 'Lingkungan',
                author: 'BS Team',
                date: '1 minggu yang lalu',
                image: 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?auto=format&fit=crop&w=400&q=80',
                avatar: 'https://randomuser.me/api/portraits/men/32.jpg',
                excerpt: 'Gerakan mengurangi penggunaan plastik sekali pakai di masyarakat.',
                views: 1800,
                likes: 134,
                shares: 38,
                bookmarked: false
            },
            {
                id: 12,
                title: 'Inovasi Pengolahan Sampah Elektronik',
                category: 'technology',
                categoryName: 'Teknologi',
                author: 'Admin',
                date: '2 minggu yang lalu',
                image: 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=400&q=80',
                avatar: 'https://randomuser.me/api/portraits/women/67.jpg',
                excerpt: 'Cara mengolah sampah elektronik dengan aman dan ramah lingkungan.',
                views: 1650,
                likes: 98,
                shares: 25,
                bookmarked: false
            }
        ];
        
        // Add to current data
        newsData.push(...additionalNews);
        
        // Render new news
        renderNews();
        
        // Reset button
        loadMoreBtn.innerHTML = originalText;
        loadMoreBtn.disabled = false;
        isLoading = false;
        
        showNotification('Berita berhasil dimuat!', 'success');
        
        // Hide load more button if no more news
        if (currentPage >= 3) {
            loadMoreBtn.style.display = 'none';
            showNotification('Semua berita telah dimuat!', 'info');
        }
    }, 1500);
}

// Toggle bookmark function
function toggleBookmark(index) {
    const btn = event.target.closest('button');
    const icon = btn.querySelector('i');
    const newsItem = newsData[index];
    
    if (newsItem) {
        newsItem.bookmarked = !newsItem.bookmarked;
        
        if (newsItem.bookmarked) {
            icon.classList.remove('far');
            icon.classList.add('fas');
            btn.style.color = '#fbbf24';
            showNotification('Berita ditambahkan ke bookmark!', 'success');
        } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
            btn.style.color = 'white';
            showNotification('Berita dihapus dari bookmark!', 'info');
        }
    }
}

// Share news function
function shareNews(index) {
    const newsItem = newsData[index];
    
    if (navigator.share) {
        navigator.share({
            title: newsItem.title,
            text: newsItem.excerpt,
            url: window.location.href + '/' + newsItem.id
        }).then(() => {
            showNotification('Berita berhasil dibagikan!', 'success');
        }).catch(() => {
            showNotification('Gagal membagikan berita', 'error');
        });
    } else {
        // Fallback for browsers that don't support Web Share API
        const shareUrl = window.location.href + '/' + newsItem.id;
        const shareText = `${newsItem.title}\n\n${newsItem.excerpt}\n\nBaca selengkapnya: ${shareUrl}`;
        
        // Copy to clipboard
        navigator.clipboard.writeText(shareText).then(() => {
            showNotification('Link berita berhasil disalin ke clipboard!', 'success');
        }).catch(() => {
            // Fallback: show share modal
            showShareModal(newsItem);
        });
    }
}

// Show share modal
function showShareModal(newsItem) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center';
    modal.innerHTML = `
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Bagikan Berita</h3>
                <button onclick="this.closest('.fixed').remove()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-2">Bagikan melalui:</p>
                <div class="grid grid-cols-3 gap-3">
                    <button onclick="shareToSocial('facebook', '${newsItem.title}')" class="bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </button>
                    <button onclick="shareToSocial('twitter', '${newsItem.title}')" class="bg-blue-400 text-white p-3 rounded-lg hover:bg-blue-500 transition-colors">
                        <i class="fab fa-twitter"></i>
                    </button>
                    <button onclick="shareToSocial('whatsapp', '${newsItem.title}')" class="bg-green-500 text-white p-3 rounded-lg hover:bg-green-600 transition-colors">
                        <i class="fab fa-whatsapp"></i>
                    </button>
                </div>
            </div>
            <div class="flex gap-2">
                <button onclick="copyShareLink('${window.location.href}/${newsItem.id}')" class="flex-1 bg-gray-200 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-300 transition-colors">
                    <i class="fas fa-link mr-2"></i>Salin Link
                </button>
                <button onclick="this.closest('.fixed').remove()" class="flex-1 bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}

// Share to social media
function shareToSocial(platform, title) {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent(title);
    
    let shareUrl = '';
    switch(platform) {
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
            break;
        case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?text=${text}&url=${url}`;
            break;
        case 'whatsapp':
            shareUrl = `https://wa.me/?text=${text}%20${url}`;
            break;
    }
    
    if (shareUrl) {
        window.open(shareUrl, '_blank', 'width=600,height=400');
        showNotification(`Berita dibagikan ke ${platform}!`, 'success');
    }
}

// Copy share link
function copyShareLink(url) {
    navigator.clipboard.writeText(url).then(() => {
        showNotification('Link berhasil disalin!', 'success');
    }).catch(() => {
        showNotification('Gagal menyalin link', 'error');
    });
}

// Scroll to top function
function scrollToTop() {
    const scrollStep = -window.scrollY / (500 / 15);
    const scrollInterval = setInterval(() => {
        if (window.scrollY !== 0) {
            window.scrollBy(0, scrollStep);
        } else {
            clearInterval(scrollInterval);
        }
    }, 15);
}

// Show stats detail function
function showStatsDetail(type) {
    const statsItem = event.target.closest('.stats-item');
    statsItem.classList.add('clicked');
    
    setTimeout(() => {
        statsItem.classList.remove('clicked');
    }, 600);
    
    const details = {
        'news': 'Total berita yang dipublikasikan: 156 artikel dalam 30 hari terakhir',
        'views': 'Total views dari semua berita: 2,400 kali dibaca dengan rata-rata 15 views per artikel',
        'likes': 'Total likes dari pembaca: 89 likes dengan engagement rate 3.7%',
        'shares': 'Total shares dari pembaca: 45 shares dengan viral coefficient 0.5'
    };
    
    showNotification(details[type] || 'Detail statistik', 'info');
}

// Toggle search function
function toggleSearch() {
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.focus();
        searchInput.select();
    }
}

// Search functionality
function performSearch(query) {
    if (!query.trim()) {
        filteredNewsData = newsData;
    } else {
        filteredNewsData = newsData.filter(news => 
            news.title.toLowerCase().includes(query.toLowerCase()) ||
            news.excerpt.toLowerCase().includes(query.toLowerCase()) ||
            news.author.toLowerCase().includes(query.toLowerCase()) ||
            news.categoryName.toLowerCase().includes(query.toLowerCase())
        );
    }
    
    renderNews();
    
    if (filteredNewsData.length === 0) {
        showNotification('Tidak ada berita yang ditemukan', 'info');
    } else {
        showNotification(`Ditemukan ${filteredNewsData.length} berita`, 'success');
    }
}

// Filter by category
function filterByCategory(category) {
    // Update active button state
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.classList.remove('active');
        btn.classList.add('bg-white', 'border-gray-200', 'text-gray-700');
    });
    
    // Set clicked button as active
    const activeBtn = document.querySelector(`[data-category="${category}"]`);
    if (activeBtn) {
        activeBtn.classList.add('active');
        activeBtn.classList.remove('bg-white', 'border-gray-200', 'text-gray-700');
    }
    
    // Filter data
    if (category === 'all') {
        filteredNewsData = newsData;
    } else {
        filteredNewsData = newsData.filter(news => news.category === category);
    }
    
    renderNews();
    showNotification(`Menampilkan berita kategori: ${category === 'all' ? 'Semua' : category}`, 'info');
}

// Apply sorting
function applySort(sortType) {
    let sortedData = [...filteredNewsData];
    
    switch(sortType) {
        case 'latest':
            sortedData.sort((a, b) => new Date(b.date) - new Date(a.date));
            break;
        case 'popular':
            sortedData.sort((a, b) => b.views - a.views);
            break;
        case 'az':
            sortedData.sort((a, b) => a.title.localeCompare(b.title));
            break;
    }
    
    filteredNewsData = sortedData;
    renderNews();
    showNotification(`Berita diurutkan berdasarkan: ${sortType === 'latest' ? 'Terbaru' : sortType === 'popular' ? 'Terpopuler' : 'A-Z'}`, 'info');
}

// Apply period filter
function applyPeriod(period) {
    let periodData = [...newsData];
    const now = new Date();
    
    switch(period) {
        case 'today':
            periodData = periodData.filter(news => {
                const newsDate = new Date(now);
                newsDate.setDate(now.getDate() - 1);
                return new Date(news.date) >= newsDate;
            });
            break;
        case 'week':
            periodData = periodData.filter(news => {
                const weekAgo = new Date(now);
                weekAgo.setDate(now.getDate() - 7);
                return new Date(news.date) >= weekAgo;
            });
            break;
        case 'month':
            periodData = periodData.filter(news => {
                const monthAgo = new Date(now);
                monthAgo.setMonth(now.getMonth() - 1);
                return new Date(news.date) >= monthAgo;
            });
            break;
    }
    
    filteredNewsData = periodData;
    renderNews();
    showNotification(`Menampilkan berita periode: ${period === 'all' ? 'Semua Waktu' : period === 'today' ? 'Hari Ini' : period === 'week' ? 'Minggu Ini' : 'Bulan Ini'}`, 'info');
}

// Apply author filter
function applyAuthor(author) {
    if (author === 'all') {
        filteredNewsData = newsData;
    } else {
        filteredNewsData = newsData.filter(news => news.author === author);
    }
    
    renderNews();
    showNotification(`Menampilkan berita penulis: ${author === 'all' ? 'Semua Penulis' : author}`, 'info');
}

// Reset all filters
function resetAllFilters() {
    // Reset category buttons
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.classList.remove('active');
        btn.classList.add('bg-white', 'border-gray-200', 'text-gray-700');
    });
    
    // Set "Semua" as active
    const allBtn = document.querySelector('[data-category="all"]');
    if (allBtn) {
        allBtn.classList.add('active');
        allBtn.classList.remove('bg-white', 'border-gray-200', 'text-gray-700');
    }
    
    // Reset dropdowns
    document.getElementById('sortSelect').value = 'latest';
    document.getElementById('periodSelect').value = 'all';
    document.getElementById('authorSelect').value = 'all';
    
    // Reset search
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.value = '';
    }
    
    // Reset data
    filteredNewsData = newsData;
    renderNews();
    
    showNotification('Semua filter telah direset!', 'success');
}

// Render news function
function renderNews() {
    const newsContainer = document.querySelector('.news-grid');
    if (!newsContainer) return;
    
    const dataToRender = filteredNewsData.length > 0 ? filteredNewsData : newsData;
    
    newsContainer.innerHTML = dataToRender.map((news, index) => `
        <div class="news-card rounded-2xl shadow-lg bg-white pb-6" style="background: linear-gradient(180deg, #05445E 0%, #75E6DA 100%); min-width:280px; max-width:320px;">
            <div class="relative">
                <img src="${news.image}" class="w-full h-40 object-cover rounded-t-2xl news-image" alt="Berita">
                <div class="category-badge">${news.categoryName}</div>
                <div class="absolute top-3 right-3">
                    <button onclick="toggleBookmark(${index})" class="bookmark-btn w-8 h-8 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/30 transition-colors">
                        <i class="${news.bookmarked ? 'fas' : 'far'} fa-bookmark"></i>
                    </button>
                </div>
            </div>
            <div class="pt-10 px-4 text-center news-card-content">
                <div class="flex items-center justify-center gap-2 mb-3">
                    <img src="${news.avatar}" class="w-6 h-6 rounded-full border-2 border-white" alt="Avatar">
                    <div class="text-left">
                        <div class="font-bold text-white text-xs">${news.author}</div>
                        <div class="text-white/80 text-xs">${news.date}</div>
                    </div>
                </div>
                <h3 class="font-bold text-white text-sm mb-2 line-clamp-2">${news.title}</h3>
                <div class="text-white/90 text-xs mb-4 leading-relaxed line-clamp-3">${news.excerpt}</div>
                <div class="flex items-center justify-between">
                    <button onclick="shareNews(${index})" class="share-btn text-white/80 hover:text-white transition-colors text-xs">
                        <i class="fas fa-share-alt mr-1"></i>Bagikan
                    </button>
                    <a href="/berita/${news.id}" class="read-more-btn block bg-lime-400 hover:bg-lime-500 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-200 text-xs">
                        Baca
                    </a>
                </div>
            </div>
        </div>
    `).join('');
}

// Enhanced notification function
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : 
                   type === 'error' ? 'bg-red-500' : 
                   type === 'info' ? 'bg-blue-500' : 'bg-green-500';
    
    notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300`;
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

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize sidebar state
    window.sidebarOpen = false;
    
    // Initialize news data
    currentNewsData = newsData;
    filteredNewsData = newsData;
    
    // Update current date
    function updateCurrentDate() {
        const now = new Date();
        const options = { 
            day: 'numeric', 
            month: 'long', 
            year: 'numeric' 
        };
        const dateString = now.toLocaleDateString('id-ID', options);
        
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
    setInterval(updateCurrentDate, 60000);
    
    // Search functionality
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch(this.value);
            }, 500);
        });
    }
    
    // Category filter functionality
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const category = this.getAttribute('data-category') || 'all';
            filterByCategory(category);
        });
    });
    
    // Filter functionality
    const filterBtn = document.querySelector('button[onclick*="showFilters"]');
    if (filterBtn) {
        filterBtn.addEventListener('click', function() {
            const filters = document.querySelector('[x-show="showFilters"]');
            if (filters) {
                // Toggle filters visibility
                const isVisible = filters.style.display !== 'none';
                filters.style.display = isVisible ? 'none' : 'block';
            }
        });
    }
    
    // Initialize news rendering
    renderNews();
    
    // Add keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K for search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            toggleSearch();
        }
        
        // Escape to close modals
        if (e.key === 'Escape') {
            const modals = document.querySelectorAll('.fixed');
            modals.forEach(modal => {
                if (modal.style.display !== 'none') {
                    modal.remove();
                }
            });
        }
    });
    
    // Add smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Add click handlers for news cards
    document.addEventListener('click', function(e) {
        // Handle news card clicks
        if (e.target.closest('.news-card')) {
            const card = e.target.closest('.news-card');
            const newsId = card.querySelector('a[href*="/berita/"]')?.href.split('/').pop();
            if (newsId && !e.target.closest('.bookmark-btn') && !e.target.closest('.share-btn')) {
                showNewsDetail(newsId);
            }
        }
        
        // Handle bookmark clicks
        if (e.target.closest('.bookmark-btn')) {
            e.stopPropagation();
            const btn = e.target.closest('.bookmark-btn');
            const index = btn.getAttribute('data-index');
            if (index) {
                toggleBookmark(index);
            }
        }
        
        // Handle share clicks
        if (e.target.closest('.share-btn')) {
            e.stopPropagation();
            const btn = e.target.closest('.share-btn');
            const index = btn.getAttribute('data-index');
            if (index) {
                shareNews(index);
            }
        }
    });
    
    // Add hover effects for news cards
    document.addEventListener('mouseover', function(e) {
        if (e.target.closest('.news-card')) {
            const card = e.target.closest('.news-card');
            card.style.transform = 'translateY(-8px)';
            card.style.boxShadow = '0 12px 30px rgba(0,0,0,0.2)';
        }
    });
    
    document.addEventListener('mouseout', function(e) {
        if (e.target.closest('.news-card')) {
            const card = e.target.closest('.news-card');
            card.style.transform = 'translateY(0)';
            card.style.boxShadow = '';
        }
    });
    
    console.log('Berita page initialized successfully!');
});

// Show news detail modal
function showNewsDetail(newsId) {
    const newsItem = newsData.find(news => news.id == newsId);
    if (!newsItem) return;
    
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
    modal.innerHTML = `
        <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="relative">
                <img src="${newsItem.image}" class="w-full h-64 object-cover" alt="Berita">
                <div class="absolute top-4 left-4">
                    <span class="bg-white/90 text-gray-800 px-3 py-1 rounded-full text-sm font-medium">
                        ${newsItem.categoryName}
                    </span>
                </div>
                <button onclick="this.closest('.fixed').remove()" class="absolute top-4 right-4 bg-white/90 text-gray-800 w-8 h-8 rounded-full flex items-center justify-center hover:bg-white transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-3 mb-4">
                    <img src="${newsItem.avatar}" class="w-10 h-10 rounded-full" alt="Avatar">
                    <div>
                        <div class="font-semibold text-gray-900">${newsItem.author}</div>
                        <div class="text-sm text-gray-600">${newsItem.date}</div>
                    </div>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-4">${newsItem.title}</h1>
                <p class="text-gray-700 leading-relaxed mb-6">${newsItem.excerpt}</p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4 text-sm text-gray-600">
                        <span><i class="fas fa-eye mr-1"></i>${newsItem.views} views</span>
                        <span><i class="fas fa-heart mr-1"></i>${newsItem.likes} likes</span>
                        <span><i class="fas fa-share mr-1"></i>${newsItem.shares} shares</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="toggleBookmark(${newsData.indexOf(newsItem)})" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                            <i class="${newsItem.bookmarked ? 'fas' : 'far'} fa-bookmark mr-2"></i>Bookmark
                        </button>
                        <button onclick="shareNews(${newsData.indexOf(newsItem)})" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-share-alt mr-2"></i>Share
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}

// Show bookmarked news
function showBookmarkedNews() {
    const bookmarkedNews = newsData.filter(news => news.bookmarked);
    if (bookmarkedNews.length === 0) {
        showNotification('Belum ada berita yang di-bookmark', 'info');
        return;
    }
    
    filteredNewsData = bookmarkedNews;
    renderNews();
    showNotification(`Menampilkan ${bookmarkedNews.length} berita yang di-bookmark`, 'success');
}

// Show popular news
function showPopularNews() {
    const popularNews = [...newsData].sort((a, b) => b.views - a.views);
    filteredNewsData = popularNews;
    renderNews();
    showNotification('Menampilkan berita terpopuler', 'info');
}

// Show latest news
function showLatestNews() {
    const latestNews = [...newsData].sort((a, b) => new Date(b.date) - new Date(a.date));
    filteredNewsData = latestNews;
    renderNews();
    showNotification('Menampilkan berita terbaru', 'info');
}

// Add keyboard navigation
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + B for bookmarks
    if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
        e.preventDefault();
        showBookmarkedNews();
    }
    
    // Ctrl/Cmd + P for popular
    if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
        e.preventDefault();
        showPopularNews();
    }
    
    // Ctrl/Cmd + L for latest
    if ((e.ctrlKey || e.metaKey) && e.key === 'l') {
        e.preventDefault();
        showLatestNews();
    }
    
    // Ctrl/Cmd + F for search
    if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
        e.preventDefault();
        toggleSearch();
    }
});

// Add loading states for better UX
function showLoadingState() {
    const loadingOverlay = document.createElement('div');
    loadingOverlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center';
    loadingOverlay.id = 'loadingOverlay';
    loadingOverlay.innerHTML = `
        <div class="bg-white rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <span class="text-gray-700">Memuat...</span>
        </div>
    `;
    document.body.appendChild(loadingOverlay);
}

function hideLoadingState() {
    const loadingOverlay = document.getElementById('loadingOverlay');
    if (loadingOverlay) {
        loadingOverlay.remove();
    }
}

// Add error handling
function handleError(error, context) {
    console.error(`Error in ${context}:`, error);
    showNotification(`Terjadi kesalahan: ${error.message}`, 'error');
}

// Add success handling
function handleSuccess(message) {
    showNotification(message, 'success');
}

// Add info handling
function handleInfo(message) {
    showNotification(message, 'info');
}

// Enhanced stats detail function with modal
function showStatsDetail(type) {
    const statsItem = event.target.closest('.stats-item');
    statsItem.classList.add('clicked');
    
    setTimeout(() => {
        statsItem.classList.remove('clicked');
    }, 600);
    
    const details = {
        'news': {
            title: 'Statistik Berita',
            content: 'Total berita yang dipublikasikan: 156 artikel dalam 30 hari terakhir',
            details: [
                'Berita Teknologi: 45 artikel',
                'Berita Lingkungan: 78 artikel',
                'Berita Lainnya: 33 artikel',
                'Rata-rata: 5.2 artikel per hari'
            ]
        },
        'views': {
            title: 'Statistik Views',
            content: 'Total views dari semua berita: 2,400 kali dibaca dengan rata-rata 15 views per artikel',
            details: [
                'Views tertinggi: 3,200 views',
                'Views terendah: 890 views',
                'Rata-rata views per artikel: 15.4',
                'Pertumbuhan: +8% dari bulan lalu'
            ]
        },
        'likes': {
            title: 'Statistik Likes',
            content: 'Total likes dari pembaca: 89 likes dengan engagement rate 3.7%',
            details: [
                'Likes tertinggi: 234 likes',
                'Likes terendah: 56 likes',
                'Engagement rate: 3.7%',
                'Pertumbuhan: +15% dari bulan lalu'
            ]
        },
        'shares': {
            title: 'Statistik Shares',
            content: 'Total shares dari pembaca: 45 shares dengan viral coefficient 0.5',
            details: [
                'Shares tertinggi: 67 shares',
                'Shares terendah: 12 shares',
                'Viral coefficient: 0.5',
                'Pertumbuhan: +22% dari bulan lalu'
            ]
        }
    };
    
    const statDetail = details[type];
    if (!statDetail) return;
    
    // Create detailed modal
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
    modal.innerHTML = `
        <div class="bg-white rounded-lg max-w-2xl w-full">
            <div class="flex items-center justify-between p-6 border-b">
                <h3 class="text-xl font-semibold text-gray-900">${statDetail.title}</h3>
                <button onclick="this.closest('.fixed').remove()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <p class="text-gray-700 mb-4">${statDetail.content}</p>
                <div class="space-y-2">
                    ${statDetail.details.map(detail => `
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check text-green-500 text-sm"></i>
                            <span class="text-gray-600">${detail}</span>
                        </div>
                    `).join('')}
                </div>
                <div class="mt-6 flex justify-end">
                    <button onclick="this.closest('.fixed').remove()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}

// Add auto-refresh functionality
function autoRefreshNews() {
    // Simulate new news every 5 minutes
    setInterval(() => {
        const newNews = {
            id: Date.now(),
            title: 'Berita Terbaru - Auto Refresh',
            category: 'technology',
            categoryName: 'Teknologi',
            author: 'System',
            date: 'Baru saja',
            image: 'https://images.unsplash.com/photo-1518709268805-4e9042af2176?auto=format&fit=crop&w=400&q=80',
            avatar: 'https://randomuser.me/api/portraits/women/44.jpg',
            excerpt: 'Berita terbaru yang ditambahkan secara otomatis untuk demo.',
            views: Math.floor(Math.random() * 1000) + 500,
            likes: Math.floor(Math.random() * 100) + 20,
            shares: Math.floor(Math.random() * 50) + 10,
            bookmarked: false
        };
        
        newsData.unshift(newNews);
        if (filteredNewsData.length === newsData.length - 1) {
            filteredNewsData.unshift(newNews);
            renderNews();
            showNotification('Berita baru tersedia!', 'info');
        }
    }, 300000); // 5 minutes
}

// Initialize auto-refresh
autoRefreshNews();
</script>
@endsection 