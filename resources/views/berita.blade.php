@extends('layouts.app')

@section('content')
<style>
    html, body {
        overflow-x: hidden;
    }
    .sidebar-gradient {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
    }
    .sidebar-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .sidebar-item-hover {
        transition: all 0.2s ease-in-out;
    }
    .sidebar-item-hover:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }
    .sidebar-logo {
        transition: all 0.3s ease-in-out;
    }
    .sidebar-nav-item {
        transition: all 0.2s ease-in-out;
        border-radius: 8px;
    }
    .sidebar-nav-item:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
    .sidebar-nav-item.active {
        background-color: rgba(255, 255, 255, 0.2);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .fixed-header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 48px;
        z-index: 40;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-right: 1.5rem;
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
        transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
</style>

<div class="flex min-h-screen bg-gray-50" x-data="{ sidebarOpen: false, activeCategory: 'all', searchQuery: '', showFilters: false }">
    {{-- Sidebar --}}
    <aside
        x-data="{ open: false, active: 'berita' }"
        x-ref="sidebar"
        @mouseenter="open = true; $root.sidebarOpen = true"
        @mouseleave="open = false; $root.sidebarOpen = false"
        class="fixed top-0 left-0 z-20 flex flex-col py-6 sidebar-hover overflow-hidden shadow-2xl group sidebar-gradient"
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
                <a href="{{ route('chat') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'chat' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'pesan' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-comment-dots text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Pesan</span>
                </a>
                
                {{-- Umpan Balik Link --}}
                <a href="{{ route('feedback') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'feedback' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'umpan-balik' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
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
    <div class="flex-1 min-h-screen bg-gray-50" :style="'padding-left:' + (sidebarOpen ? '16rem' : '4rem') + '; transition: padding-left 0.3s cubic-bezier(0.4,0,0.2,1);'">
        {{-- Top Header Bar --}}
        <div class="fixed-header" :style="'padding-left:' + (sidebarOpen ? '16rem' : '4rem') + ';'">
            <h1 class="text-white font-semibold text-lg">BijakSampah</h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('notifikasi') }}" class="relative">
                    <i class="far fa-bell text-white text-sm"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-medium">2</span>
                </a>
                <button class="focus:outline-none" onclick="toggleSearch()">
                    <i class="fas fa-search text-white text-sm"></i>
                </button>
                <div class="flex items-center gap-2">
                    <a href="{{ route('profile') }}" class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center border-2 border-gray-300">
                        <img src="{{ asset('asset/img/user_profile.jpg') }}" alt="Profile" class="w-full h-full object-cover">
                    </a>
                    <i class="fas fa-chevron-down text-white text-xs"></i>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="p-8 w-full" style="padding-top: 60px;">
            <div class="p-8">
                {{-- Header Section --}}
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">Berita Terkini</h1>
                        <p class="text-gray-600">Dapatkan informasi terbaru seputar pengelolaan sampah dan lingkungan</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="bg-white rounded-lg shadow-md px-4 py-2">
                            <i class="fas fa-calendar text-gray-500 mr-2"></i>
                            <span class="text-sm text-gray-600">23 Maret 2025</span>
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
                                @click="activeCategory = 'all'"
                                :class="activeCategory === 'all' ? 'category-btn active' : 'category-btn bg-white border-gray-200 text-gray-700'"
                                class="px-4 py-2 rounded-lg font-medium"
                            >
                                Semua
                            </button>
                            <button 
                                @click="activeCategory = 'environment'"
                                :class="activeCategory === 'environment' ? 'category-btn active' : 'category-btn bg-white border-gray-200 text-gray-700'"
                                class="px-4 py-2 rounded-lg font-medium"
                            >
                                Lingkungan
                            </button>
                            <button 
                                @click="activeCategory = 'technology'"
                                :class="activeCategory === 'technology' ? 'category-btn active' : 'category-btn bg-white border-gray-200 text-gray-700'"
                                class="px-4 py-2 rounded-lg font-medium"
                            >
                                Teknologi
                            </button>
                        </div>
                    </div>
                    
                    {{-- Advanced Filters --}}
                    <div x-show="showFilters" x-transition class="mt-6 pt-6 border-t border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                    <option>Terbaru</option>
                                    <option>Terpopuler</option>
                                    <option>A-Z</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Periode</label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                    <option>Semua Waktu</option>
                                    <option>Hari Ini</option>
                                    <option>Minggu Ini</option>
                                    <option>Bulan Ini</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Penulis</label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                    <option>Semua Penulis</option>
                                    <option>Wugis</option>
                                    <option>BS Team</option>
                                    <option>Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Statistics Section - 2x2 Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="stats-item bg-white rounded-xl shadow-lg p-6 text-center" onclick="showStatsDetail('news')">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-newspaper text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">156</h3>
                        <p class="text-gray-600 text-sm">Total Berita</p>
                        <div class="mt-2 text-xs text-green-600">
                            <i class="fas fa-arrow-up mr-1"></i>+12% dari bulan lalu
                        </div>
                    </div>
                    <div class="stats-item bg-white rounded-xl shadow-lg p-6 text-center" onclick="showStatsDetail('views')">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-eye text-green-600 text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">2.4K</h3>
                        <p class="text-gray-600 text-sm">Total Views</p>
                        <div class="mt-2 text-xs text-green-600">
                            <i class="fas fa-arrow-up mr-1"></i>+8% dari bulan lalu
                        </div>
                    </div>
                    <div class="stats-item bg-white rounded-xl shadow-lg p-6 text-center" onclick="showStatsDetail('likes')">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-heart text-purple-600 text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">89</h3>
                        <p class="text-gray-600 text-sm">Likes</p>
                        <div class="mt-2 text-xs text-green-600">
                            <i class="fas fa-arrow-up mr-1"></i>+15% dari bulan lalu
                        </div>
                    </div>
                    <div class="stats-item bg-white rounded-xl shadow-lg p-6 text-center" onclick="showStatsDetail('shares')">
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
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                    <div class="news-card rounded-2xl shadow-lg bg-white pb-6" style="background: linear-gradient(180deg, #05445E 0%, #75E6DA 100%); min-width:280px; max-width:320px;">
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
function loadMoreNews() {
    alert('Memuat berita lainnya...');
    // Implement actual load more functionality
}

function toggleBookmark(index) {
    const btn = event.target.closest('button');
    const icon = btn.querySelector('i');
    if (icon.classList.contains('far')) {
        icon.classList.remove('far');
        icon.classList.add('fas');
        btn.style.color = '#fbbf24';
        showNotification('Berita ditambahkan ke bookmark!');
    } else {
        icon.classList.remove('fas');
        icon.classList.add('far');
        btn.style.color = 'white';
        showNotification('Berita dihapus dari bookmark!');
    }
}

function shareNews(index) {
    if (navigator.share) {
        navigator.share({
            title: 'Berita BijakSampah',
            text: 'Baca berita menarik tentang pengelolaan sampah',
            url: window.location.href
        });
    } else {
        showNotification('Berita berhasil dibagikan!');
    }
}

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

function showStatsDetail(type) {
    const statsItem = event.target.closest('.stats-item');
    statsItem.classList.add('clicked');
    
    setTimeout(() => {
        statsItem.classList.remove('clicked');
    }, 600);
    
    const details = {
        'news': 'Total berita yang dipublikasikan: 156 artikel',
        'views': 'Total views dari semua berita: 2,400 kali dibaca',
        'likes': 'Total likes dari pembaca: 89 likes',
        'shares': 'Total shares dari pembaca: 45 shares'
    };
    
    showNotification(details[type] || 'Detail statistik');
}

function toggleSearch() {
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.focus();
    }
}

function showNotification(message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
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
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            console.log('Searching for:', this.value);
            // Implement search functionality
        });
    }
    
    // Add event listeners for bookmark buttons
    document.querySelectorAll('.bookmark-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const index = this.getAttribute('data-index');
            toggleBookmark(index);
        });
    });
    
    // Add event listeners for share buttons
    document.querySelectorAll('.share-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const index = this.getAttribute('data-index');
            shareNews(index);
        });
    });
});
</script>
@endsection 