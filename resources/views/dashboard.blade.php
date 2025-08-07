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
            {{-- Welcome Section --}}
            <div class="mb-8 text-content">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Selamat Datang di BijakSampah! 🌱</h1>
                <p class="text-gray-600 text-lg">Platform inovatif untuk mendukung UMKM dan mengurangi sampah</p>
            </div>

            {{-- Main Hero Section --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start w-full mb-12">
                
                {{-- Left Content Section --}}
                <div class="space-y-8 w-full text-content">
                    {{-- Main Heading --}}
                    <div>
                        <h2 class="text-6xl lg:text-8xl font-black text-[#181F2A] leading-tight">
                            Dukung <span class="text-highlight text-6xl lg:text-8xl font-black">UMKM</span>,<br>
                            Kurangi Sampah,<br>
                            Rawat <span class="text-highlight text-6xl lg:text-8xl font-black">Bumi</span>
                        </h2>
                        <p class="text-gray-600 text-lg mt-6 leading-relaxed max-w-lg font-medium">
                            Inovasi ramah lingkungan kini hadir lewat produk UMKM kreatif yang mendukung ekonomi sirkular dan keberlanjutan lingkungan.
                        </p>
                    </div>

                    {{-- Call-to-Action Buttons --}}
                    <div class="flex items-center gap-4 mt-8">
                        <button class="btn-primary font-bold px-8 py-4 rounded-2xl">
                            <i class="fas fa-rocket mr-2"></i>
                            Mulai Sekarang
                        </button>
                        <button class="btn-secondary font-bold px-8 py-4 rounded-2xl">
                            <i class="fas fa-recycle mr-2"></i>
                            Bank Sampah
                        </button>
                    </div>

                    {{-- Statistics Section --}}
                    <div class="flex gap-12 pt-8">
                        <div class="text-left">
                            <div class="text-4xl font-black text-gray-900">37k+</div>
                            <div class="text-gray-600 text-sm font-medium">User Aktif</div>
                        </div>
                        <div class="text-left">
                            <div class="text-4xl font-black text-gray-900">20kg+</div>
                            <div class="text-gray-600 text-sm font-medium">Sampah Terdaur</div>
                        </div>
                        <div class="text-left">
                            <div class="text-4xl font-black text-gray-900">99k+</div>
                            <div class="text-gray-600 text-sm font-medium">Produk BS</div>
                        </div>
                    </div>
                </div>

                {{-- Right Image Gallery Section --}}
                <div class="grid grid-cols-3 gap-3 h-[500px] overflow-hidden w-full">
                    <div class="col-span-2 grid grid-cols-2 gap-3">
                        <img src="{{ asset('asset/img/bijak1.jpg') }}" class="rounded-xl w-full h-[160px] object-cover shadow-lg" alt="Decorative Mirror">
                        <img src="{{ asset('asset/img/bijak2.jpg') }}" class="rounded-xl w-full h-[160px] object-cover shadow-lg" alt="Woven Baskets">
                        <img src="{{ asset('asset/img/bijak3.jpg') }}" class="rounded-xl w-full h-[160px] object-cover shadow-lg" alt="Hand with Sunflower">
                        <img src="{{ asset('asset/img/bijak4.jpg') }}" class="rounded-xl w-full h-[160px] object-cover shadow-lg" alt="Circular Art Pieces">
                        <img src="{{ asset('asset/img/bijak1.jpg') }}" class="rounded-xl w-full h-[160px] object-cover shadow-lg" alt="Shop Display">
                        <img src="{{ asset('asset/img/bijak4.jpg') }}" class="rounded-xl w-full h-[160px] object-cover shadow-lg" alt="More Crafts">
                    </div>
                    <img src="{{ asset('asset/img/hero.png') }}" class="rounded-xl w-full h-full object-cover shadow-lg" alt="Fashion Model">
                </div>
            </div>

            {{-- Statistics Cards Section --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <div class="stat-card p-6 text-content">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Pendapatan</p>
                            <p class="text-3xl font-bold text-gray-900">Rp 2.5M</p>
                            <p class="text-green-600 text-sm font-medium">+12.5% dari bulan lalu</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card p-6 text-content">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Sampah Terdaur</p>
                            <p class="text-3xl font-bold text-gray-900">1,247 kg</p>
                            <p class="text-blue-600 text-sm font-medium">+8.3% dari minggu lalu</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-recycle text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card p-6 text-content">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">UMKM Terdaftar</p>
                            <p class="text-3xl font-bold text-gray-900">1,234</p>
                            <p class="text-purple-600 text-sm font-medium">+15.2% dari bulan lalu</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-store text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card p-6 text-content">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Produk Terjual</p>
                            <p class="text-3xl font-bold text-gray-900">5,678</p>
                            <p class="text-orange-600 text-sm font-medium">+22.1% dari bulan lalu</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-shopping-bag text-orange-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions & Recent Activities --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                {{-- Quick Actions --}}
                <div class="lg:col-span-1 text-content">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Aksi Cepat</h3>
                    <div class="space-y-4">
                        <button class="quick-action-btn w-full flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-plus-circle text-2xl"></i>
                                <span class="font-semibold">Tambah Sampah</span>
                            </div>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                        
                        <button class="quick-action-btn w-full flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-shopping-cart text-2xl"></i>
                                <span class="font-semibold">Beli Produk</span>
                            </div>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                        
                        <button class="quick-action-btn w-full flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-users text-2xl"></i>
                                <span class="font-semibold">Gabung Komunitas</span>
                            </div>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                        
                        <button class="quick-action-btn w-full flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-chart-line text-2xl"></i>
                                <span class="font-semibold">Lihat Laporan</span>
                            </div>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                {{-- Recent Activities --}}
                <div class="lg:col-span-2 text-content">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Aktivitas Terbaru</h3>
                    <div class="space-y-4">
                        <div class="activity-card p-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-recycle text-green-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">Sampah berhasil didaur ulang</p>
                                    <p class="text-sm text-gray-600">2.5 kg sampah plastik telah diproses</p>
                                    <p class="text-xs text-gray-500">2 jam yang lalu</p>
                                </div>
                                <span class="text-green-600 font-semibold">+Rp 25.000</span>
                            </div>
                        </div>

                        <div class="activity-card p-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-shopping-bag text-blue-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">Produk berhasil dibeli</p>
                                    <p class="text-sm text-gray-600">Tas daur ulang dari @Wugis</p>
                                    <p class="text-xs text-gray-500">4 jam yang lalu</p>
                                </div>
                                <span class="text-blue-600 font-semibold">-Rp 45.000</span>
                            </div>
                        </div>

                        <div class="activity-card p-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-users text-purple-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">Bergabung dengan komunitas</p>
                                    <p class="text-sm text-gray-600">Komunitas Daur Ulang Jakarta</p>
                                    <p class="text-xs text-gray-500">1 hari yang lalu</p>
                                </div>
                                <span class="text-purple-600 font-semibold">Bergabung</span>
                            </div>
                        </div>

                        <div class="activity-card p-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-star text-orange-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">Mencapai milestone</p>
                                    <p class="text-sm text-gray-600">100 kg sampah terdaur ulang</p>
                                    <p class="text-xs text-gray-500">2 hari yang lalu</p>
                                </div>
                                <span class="text-orange-600 font-semibold">🏆</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Progress & Goals Section --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                {{-- Monthly Goals --}}
                <div class="chart-container p-6 text-content">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Target Bulanan</h3>
                    <div class="space-y-6">
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-semibold text-gray-700">Sampah Terdaur</span>
                                <span class="text-sm text-gray-600">75%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="progress-bar rounded-full" style="width: 75%"></div>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">15 kg dari 20 kg target</p>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-semibold text-gray-700">Produk Terjual</span>
                                <span class="text-sm text-gray-600">60%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="progress-bar rounded-full" style="width: 60%"></div>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">12 dari 20 produk target</p>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-semibold text-gray-700">Pendapatan</span>
                                <span class="text-sm text-gray-600">85%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="progress-bar rounded-full" style="width: 85%"></div>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">Rp 850.000 dari Rp 1.000.000 target</p>
                        </div>
                    </div>
                </div>

                {{-- Environmental Impact --}}
                <div class="chart-container p-6 text-content">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Dampak Lingkungan</h3>
                    <div class="space-y-6">
                        <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-tree text-green-600 text-2xl"></i>
                                <div>
                                    <p class="font-semibold text-gray-900">Pohon Terselamatkan</p>
                                    <p class="text-sm text-gray-600">Setara dengan 15 pohon</p>
                                </div>
                            </div>
                            <span class="text-2xl font-bold text-green-600">15</span>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-water text-blue-600 text-2xl"></i>
                                <div>
                                    <p class="font-semibold text-gray-900">Air Tersimpan</p>
                                    <p class="text-sm text-gray-600">Setara dengan 2.500 liter</p>
                                </div>
                            </div>
                            <span class="text-2xl font-bold text-blue-600">2.5k</span>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-orange-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-fire text-orange-600 text-2xl"></i>
                                <div>
                                    <p class="font-semibold text-gray-900">Energi Tersimpan</p>
                                    <p class="text-sm text-gray-600">Setara dengan 1.200 kWh</p>
                                </div>
                            </div>
                            <span class="text-2xl font-bold text-orange-600">1.2k</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Featured Products --}}
            <div class="mb-12 text-content">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Produk Unggulan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="stat-card p-4">
                        <img src="{{ asset('asset/img/bijak1.jpg') }}" alt="Product 1" class="w-full h-32 object-cover rounded-lg mb-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Tas Daur Ulang</h4>
                        <p class="text-sm text-gray-600 mb-2">@Wugis</p>
                        <p class="text-lg font-bold text-green-600">Rp 45.000</p>
                    </div>

                    <div class="stat-card p-4">
                        <img src="{{ asset('asset/img/bijak2.jpg') }}" alt="Product 2" class="w-full h-32 object-cover rounded-lg mb-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Keranjang Anyaman</h4>
                        <p class="text-sm text-gray-600 mb-2">@Wugis</p>
                        <p class="text-lg font-bold text-green-600">Rp 35.000</p>
                    </div>

                    <div class="stat-card p-4">
                        <img src="{{ asset('asset/img/bijak3.jpg') }}" alt="Product 3" class="w-full h-32 object-cover rounded-lg mb-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Hiasan Dinding</h4>
                        <p class="text-sm text-gray-600 mb-2">@Wugis</p>
                        <p class="text-lg font-bold text-green-600">Rp 25.000</p>
                    </div>

                    <div class="stat-card p-4">
                        <img src="{{ asset('asset/img/bijak4.jpg') }}" alt="Product 4" class="w-full h-32 object-cover rounded-lg mb-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Aksesoris Unik</h4>
                        <p class="text-sm text-gray-600 mb-2">@Wugis</p>
                        <p class="text-lg font-bold text-green-600">Rp 15.000</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection