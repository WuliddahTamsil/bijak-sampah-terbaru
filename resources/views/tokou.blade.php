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
    .main-content-wrapper::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.03"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        pointer-events: none;
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
    .decorative-element {
        position: absolute; border-radius: 50%; background: linear-gradient(135deg, #75E6DA, #05445E);
        opacity: 0.05; z-index: 0; animation: float 8s ease-in-out infinite;
    }
    .decorative-element.top-right { width: 200px; height: 200px; top: -100px; right: -100px; animation-delay: 0s; }
    .decorative-element.bottom-left { width: 150px; height: 150px; bottom: -75px; left: -75px; animation-delay: 3s; }
    @keyframes float { 0%, 100% { transform: translateY(0px) rotate(0deg); } 50% { transform: translateY(-20px) rotate(180deg); } }
    .page-title {
        background: linear-gradient(135deg, #1e293b, #334155); -webkit-background-clip: text;
        -webkit-text-fill-color: transparent; background-clip: text; font-size: 3.5rem;
        font-weight: 900; text-align: center; margin-bottom: 2rem;
        text-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); position: relative;
        letter-spacing: -0.02em;
    }
    .page-title::after {
        content: ''; position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%);
        width: 100px; height: 4px; background: linear-gradient(90deg, #75E6DA, #05445E);
        border-radius: 2px;
    }
    .search-bar {
        background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);
        border-radius: 25px; padding: 1rem 1.5rem; margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08); border: 1px solid rgba(255, 255, 255, 0.3);
        display: flex; align-items: center; gap: 1rem; max-width: 600px; margin-left: auto; margin-right: auto;
    }
    .search-input {
        flex: 1; border: none; outline: none; background: transparent;
        font-size: 1rem; color: #1f2937; placeholder-color: #9ca3af;
    }
    .search-btn {
        background: linear-gradient(135deg, #75E6DA, #05445E); color: white;
        padding: 0.5rem 1rem; border-radius: 15px; border: none; cursor: pointer;
        transition: all 0.3s ease; font-weight: 600;
    }
    .search-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(117, 230, 218, 0.3); }
    .filter-section {
        display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;
        flex-wrap: wrap; gap: 1rem;
    }
    .category-filter {
        background: linear-gradient(135deg, #ffffff, #f8fafc); color: #475569;
        padding: 0.8rem 1.5rem; border-radius: 25px; font-size: 0.9rem; font-weight: 600;
        cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid #e2e8f0; position: relative; overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    .category-filter::before {
        content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(117, 230, 218, 0.2), transparent);
        transition: left 0.5s ease;
    }
    .category-filter:hover::before { left: 100%; }
    .category-filter:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1); }
    .category-filter.active {
        background: linear-gradient(135deg, #75E6DA, #05445E); color: white;
        border-color: #75E6DA; box-shadow: 0 4px 12px rgba(117, 230, 218, 0.3);
    }
    .sort-dropdown {
        background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);
        border-radius: 15px; padding: 0.8rem 1.2rem; border: 2px solid #e2e8f0;
        color: #475569; font-weight: 600; cursor: pointer; transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    .sort-dropdown:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1); }
    .product-card {
        background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);
        border-radius: 20px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.3); position: relative; overflow: hidden;
    }
    .product-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, #75E6DA, #05445E); opacity: 0;
        transition: opacity 0.3s ease;
    }
    .product-card:hover { transform: translateY(-8px) scale(1.02); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12); }
    .product-card:hover::before { opacity: 1; }
    .product-image-container {
        position: relative; overflow: hidden; border-radius: 16px 16px 0 0;
    }
    .product-image {
        width: 100%; height: 200px; object-fit: cover; transition: all 0.3s ease;
    }
    .product-card:hover .product-image { transform: scale(1.05); }
    .wishlist-btn {
        position: absolute; top: 10px; right: 10px; background: rgba(255, 255, 255, 0.9);
        border: none; border-radius: 50%; width: 35px; height: 35px;
        display: flex; align-items: center; justify-content: center; cursor: pointer;
        transition: all 0.3s ease; color: #ef4444; font-size: 1rem;
    }
    .wishlist-btn:hover { background: #ef4444; color: white; transform: scale(1.1); }
    .product-badge {
        position: absolute; top: 10px; left: 10px; background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: white; padding: 0.3rem 0.8rem; border-radius: 12px; font-size: 0.75rem;
        font-weight: 600; text-transform: uppercase;
    }
    .product-info {
        padding: 1.5rem;
    }
    .seller-name {
        color: #6b7280; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem;
    }
    .product-title {
        font-size: 1.1rem; font-weight: 700; color: #1f2937; margin-bottom: 0.75rem;
        line-height: 1.4;
    }
    .product-rating {
        display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;
    }
    .stars {
        color: #fbbf24; font-size: 0.875rem;
    }
    .rating-text {
        color: #6b7280; font-size: 0.8rem; font-weight: 500;
    }
    .product-price {
        font-size: 1.3rem; font-weight: 800; color: #059669; margin-bottom: 1rem;
    }
    .original-price {
        text-decoration: line-through; color: #9ca3af; font-size: 1rem; margin-left: 0.5rem;
    }
    .product-actions {
        display: flex; gap: 0.5rem;
    }
    .view-details-btn {
        background: linear-gradient(135deg, #10b981, #059669); color: white;
        padding: 0.75rem 1rem; border-radius: 12px; font-weight: 600; text-decoration: none;
        display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); position: relative; overflow: hidden;
        flex: 1;
    }
    .view-details-btn::before {
        content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s ease;
    }
    .view-details-btn:hover::before { left: 100%; }
    .view-details-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4); color: white; }
    .add-to-cart-btn {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white;
        padding: 0.75rem; border-radius: 12px; border: none; cursor: pointer;
        transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    .add-to-cart-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4); }
    .cart-icon {
        position: fixed; bottom: 2.5rem; right: 8rem; width: 4rem; height: 4rem;
        background: linear-gradient(135deg, #fbbf24, #f59e0b); border-radius: 50%;
        display: flex; align-items: center; justify-content: center; color: white;
        font-size: 1.5rem; box-shadow: 0 8px 25px rgba(251, 191, 36, 0.4);
        transition: all 0.3s ease; cursor: pointer; z-index: 30;
    }
    .cart-icon:hover { transform: scale(1.1); box-shadow: 0 12px 35px rgba(251, 191, 36, 0.6); }
    .cart-badge {
        position: absolute; top: -5px; right: -5px; background: #ef4444; color: white;
        border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center;
        justify-content: center; font-size: 0.75rem; font-weight: 700;
    }
    .floating-action {
        position: fixed; bottom: 2.5rem; right: 2.5rem; width: 5rem; height: 5rem;
        background: linear-gradient(135deg, #75E6DA, #05445E); border-radius: 50%;
        display: flex; align-items: center; justify-content: center; color: white;
        font-size: 1.8rem; box-shadow: 0 12px 40px rgba(117, 230, 218, 0.4);
        transition: all 0.3s ease; cursor: pointer; z-index: 30;
    }
    .floating-action:hover { transform: scale(1.1) rotate(90deg); box-shadow: 0 16px 50px rgba(117, 230, 218, 0.6); }
    
    /* Smooth scrolling improvements */
    .content-container {
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
    }
    
    /* Alpine.js x-cloak */
    [x-cloak] { display: none !important; }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }
    ::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #75E6DA, #05445E);
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #05445E, #75E6DA);
    }
    
    /* Sidebar Logo Fixes */
    .sidebar-logo-small {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        width: 32px !important;
        height: 32px !important;
        object-fit: contain;
        position: relative !important;
        z-index: 10 !important;
    }
    
    /* Ensure logo is visible when sidebar is collapsed */
    aside.w-16 .sidebar-logo-small {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }
    
    /* Responsive fixes */
    @media (max-width: 1024px) {
        .main-content-wrapper { padding-left: 1rem; padding-right: 1rem; }
        .content-container { padding: 1.5rem; }
        .page-title { font-size: 3rem; }
    }
    @media (max-width: 768px) {
        .main-content-wrapper { padding-left: 0.5rem; padding-right: 0.5rem; }
        .content-container { padding: 1rem; }
        .page-title { font-size: 2.5rem; }
        .floating-action { width: 4rem; height: 4rem; font-size: 1.5rem; }
        .cart-icon { width: 3.5rem; height: 3.5rem; font-size: 1.3rem; }
    }
</style>

<div class="flex min-h-screen bg-gray-50" x-data="sidebarData">
    {{-- Sidebar Overlay --}}
    <div class="sidebar-overlay" :class="{ 'active': sidebarOpen }" @click="sidebarOpen = false"></div>

    {{-- Sidebar --}}
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
                    <template x-if="sidebarOpen">
                        <img class="w-32 h-auto" src="{{ asset('asset/img/logo1.png') }}" alt="Logo Penuh">
                    </template>
                    <template x-if="!sidebarOpen">
                        <img class="sidebar-logo-small" src="{{ asset('asset/img/logo.png') }}" alt="Logo Kecil">
                    </template>
                    {{-- Toggle Button --}}
                    <button 
                        @click="sidebarOpen = !sidebarOpen"
                        class="p-1 rounded-full bg-white/20 hover:bg-white/30 transition-colors duration-200 text-white z-50"
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
                    href="{{ route('nasabahdashboard') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center; padding-left: 0; padding-right: 0;'"
                    @click="activeMenu = 'dashboard'"
                >
                    <i class="fas fa-home text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Dashboard</span>
                </a>

                <a 
                    href="{{ route('nasabahkomunitas') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'komunitas'"
                >
                    <i class="fas fa-users text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Komunitas</span>
                </a>

                <a 
                    href="{{ route('sampahnasabah') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'penjemputan'"
                >
                    <i class="fas fa-trash-alt text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Penjemputan Sampah</span>
                </a>

                <a 
                    href="{{ route('poin-nasabah') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'poin'"
                >
                    <i class="fas fa-coins text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Poin Mu</span>
                </a>

                <a 
                    href="{{ route('riwayattransaksinasabah') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 bg-white/20 shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'riwayat-transaksi'"
                >
                    <i class="fas fa-history text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Riwayat Transaksi</span>
                </a>

                <a 
                    href="{{ route('tokou') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'marketplace'"
                >
                    <i class="fas fa-store text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Marketplace</span>
                </a>

                <a 
                    href="{{ route('settings') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
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

    {{-- Main Content Area --}}
    <div class="main-content-wrapper">
        {{-- Decorative Elements --}}
        <div class="decorative-element top-right"></div>
        <div class="decorative-element bottom-left"></div>
        
        {{-- Top Header Bar --}}
        <div class="fixed-header">
            <h1 class="text-white font-semibold text-lg">BijakSampah</h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('notifikasi') }}" class="relative">
                    <i class="far fa-bell text-white text-sm"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-medium">2</span>
                </a>
                <button class="focus:outline-none">
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
        
        {{-- Content Container --}}
        <div class="content-container">
            <h1 class="page-title">Toko</h1>
            
            {{-- Search Bar --}}
            <div class="search-bar">
                <i class="fas fa-search text-gray-400"></i>
                <input type="text" placeholder="Cari produk daur ulang..." class="search-input" onkeyup="searchProducts(this.value)">
                <button class="search-btn" onclick="openSearch()">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            
            {{-- Filter Section --}}
            <div class="filter-section">
                <div class="flex gap-4 flex-wrap">
                    <span class="category-filter" onclick="filterByCategory('Hiasan Rumah')">Hiasan Rumah</span>
                    <span class="category-filter active" onclick="filterByCategory('Aksesoris')">Aksesoris</span>
                    <span class="category-filter" onclick="filterByCategory('Hiasan Rumah')">Hiasan Rumah</span>
                    <span class="category-filter" onclick="filterByCategory('Lainnya')">Lainnya</span>
                </div>
                <select class="sort-dropdown" onchange="sortProducts(this.value)">
                    <option>Urutkan: Terbaru</option>
                    <option>Harga: Rendah ke Tinggi</option>
                    <option>Harga: Tinggi ke Rendah</option>
                    <option>Rating Tertinggi</option>
                </select>
            </div>

            {{-- Product Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <!-- Product Card 1 -->
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Woven Crafts" class="product-image">
                        <button class="wishlist-btn" onclick="toggleWishlist('1', this)">
                            <i class="far fa-heart"></i>
                        </button>
                        <div class="product-badge">Terlaris</div>
                    </div>
                    <div class="product-info">
                        <div class="seller-name">@Wugis</div>
                        <div class="product-title">Tas Kreasi</div>
                        <div class="product-rating">
                            <div class="stars">★★★★★</div>
                            <span class="rating-text">(4.8)</span>
                        </div>
                        <div class="product-price">
                            Rp20.000
                            <span class="original-price">Rp25.000</span>
                        </div>
                        <div class="product-actions">
                            <a href="#" class="view-details-btn" onclick="viewProductDetail('1', 'Tas Kreasi')">Lihat Detail</a>
                            <button class="add-to-cart-btn" onclick="addToCart('1', 'Tas Kreasi', 20000, 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80')">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product Card 2 -->
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Dinosaur Model" class="product-image">
                        <button class="wishlist-btn" onclick="toggleWishlist('2', this)">
                            <i class="far fa-heart"></i>
                        </button>
                        <div class="product-badge">Baru</div>
                    </div>
                    <div class="product-info">
                        <div class="seller-name">@Wugis</div>
                        <div class="product-title">Model Dinosaurus</div>
                        <div class="product-rating">
                            <div class="stars">★★★★☆</div>
                            <span class="rating-text">(4.2)</span>
                        </div>
                        <div class="product-price">Rp35.000</div>
                        <div class="product-actions">
                            <a href="#" class="view-details-btn" onclick="viewProductDetail('2', 'Model Dinosaurus')">Lihat Detail</a>
                            <button class="add-to-cart-btn" onclick="addToCart('2', 'Model Dinosaurus', 35000, 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80')">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product Card 3 -->
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Woven Baskets" class="product-image">
                        <button class="wishlist-btn" onclick="toggleWishlist('3', this)">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                    <div class="product-info">
                        <div class="seller-name">@Wugis</div>
                        <div class="product-title">Keranjang Anyaman</div>
                        <div class="product-rating">
                            <div class="stars">★★★★★</div>
                            <span class="rating-text">(4.9)</span>
                        </div>
                        <div class="product-price">Rp25.000</div>
                        <div class="product-actions">
                            <a href="#" class="view-details-btn" onclick="viewProductDetail('3', 'Keranjang Anyaman')">Lihat Detail</a>
                            <button class="add-to-cart-btn" onclick="addToCart('3', 'Keranjang Anyaman', 25000, 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80')">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product Card 4 -->
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Sunflower Basket" class="product-image">
                        <button class="wishlist-btn" onclick="toggleWishlist('4', this)">
                            <i class="far fa-heart"></i>
                        </button>
                        <div class="product-badge">Diskon</div>
                    </div>
                    <div class="product-info">
                        <div class="seller-name">@Wugis</div>
                        <div class="product-title">Keranjang Matahari</div>
                        <div class="product-rating">
                            <div class="stars">★★★★☆</div>
                            <span class="rating-text">(4.5)</span>
                        </div>
                        <div class="product-price">
                            Rp18.000
                            <span class="original-price">Rp22.000</span>
                        </div>
                        <div class="product-actions">
                            <a href="#" class="view-details-btn" onclick="viewProductDetail('4', 'Keranjang Matahari')">Lihat Detail</a>
                            <button class="add-to-cart-btn" onclick="addToCart('4', 'Keranjang Matahari', 18000, 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80')">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product Card 5 -->
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Recycled Bag" class="product-image">
                        <button class="wishlist-btn" onclick="toggleWishlist('5', this)">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                    <div class="product-info">
                        <div class="seller-name">@Wugis</div>
                        <div class="product-title">Tas Daur Ulang</div>
                        <div class="product-rating">
                            <div class="stars">★★★★★</div>
                            <span class="rating-text">(4.7)</span>
                        </div>
                        <div class="product-price">Rp30.000</div>
                        <div class="product-actions">
                            <a href="#" class="view-details-btn" onclick="viewProductDetail('5', 'Tas Daur Ulang')">Lihat Detail</a>
                            <button class="add-to-cart-btn" onclick="addToCart('5', 'Tas Daur Ulang', 30000, 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80')">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product Card 6 -->
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Sunflower Basket" class="product-image">
                        <button class="wishlist-btn" onclick="toggleWishlist('6', this)">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                    <div class="product-info">
                        <div class="seller-name">@Wugis</div>
                        <div class="product-title">Keranjang Matahari</div>
                        <div class="product-rating">
                            <div class="stars">★★★★☆</div>
                            <span class="rating-text">(4.3)</span>
                        </div>
                        <div class="product-price">Rp18.000</div>
                        <div class="product-actions">
                            <a href="#" class="view-details-btn" onclick="viewProductDetail('6', 'Keranjang Matahari')">Lihat Detail</a>
                            <button class="add-to-cart-btn" onclick="addToCart('6', 'Keranjang Matahari', 18000, 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80')">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product Card 7 -->
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Woven Wall Art" class="product-image">
                        <button class="wishlist-btn" onclick="toggleWishlist('7', this)">
                            <i class="far fa-heart"></i>
                        </button>
                        <div class="product-badge">Premium</div>
                    </div>
                    <div class="product-info">
                        <div class="seller-name">@Wugis</div>
                        <div class="product-title">Hiasan Dinding Anyaman</div>
                        <div class="product-rating">
                            <div class="stars">★★★★★</div>
                            <span class="rating-text">(4.9)</span>
                        </div>
                        <div class="product-price">Rp45.000</div>
                        <div class="product-actions">
                            <a href="#" class="view-details-btn" onclick="viewProductDetail('7', 'Hiasan Dinding Anyaman')">Lihat Detail</a>
                            <button class="add-to-cart-btn" onclick="addToCart('7', 'Hiasan Dinding Anyaman', 45000, 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80')">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product Card 8 -->
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Recycled Accessories" class="product-image">
                        <button class="wishlist-btn" onclick="toggleWishlist('8', this)">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                    <div class="product-info">
                        <div class="seller-name">@Wugis</div>
                        <div class="product-title">Aksesoris Daur Ulang</div>
                        <div class="product-rating">
                            <div class="stars">★★★★☆</div>
                            <span class="rating-text">(4.1)</span>
                        </div>
                        <div class="product-price">Rp15.000</div>
                        <div class="product-actions">
                            <a href="#" class="view-details-btn" onclick="viewProductDetail('8', 'Aksesoris Daur Ulang')">Lihat Detail</a>
                            <button class="add-to-cart-btn" onclick="addToCart('8', 'Aksesoris Daur Ulang', 15000, 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80')">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cart Icon -->
        <div class="cart-icon" onclick="openCart()">
            <i class="fas fa-shopping-cart"></i>
            <div class="cart-badge" id="cartCount">3</div>
        </div>

        <!-- Floating Action Button -->
        <div class="floating-action" onclick="openSearch()">
            <i class="fas fa-search"></i>
        </div>
    </div>
</div>

<!-- Cart Modal -->
<div id="cartModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Keranjang Belanja</h3>
                <button onclick="closeCart()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="cartItems" class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                <!-- Cart items will be populated here -->
            </div>
            <div class="border-t pt-4">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-semibold">Total:</span>
                    <span class="font-bold text-lg" id="cartTotal">Rp75.000</span>
                </div>
            </div>
            <div class="flex gap-3">
                <button onclick="closeCart()" class="flex-1 bg-gray-200 text-gray-800 py-2 px-4 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                    Lanjut Belanja
                </button>
                <button onclick="openCheckout()" class="flex-1 bg-green-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                    Checkout
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Checkout Modal -->
<div id="checkoutModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Checkout</h3>
                <button onclick="closeCheckout()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Order Summary -->
            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                <h4 class="font-bold text-lg mb-3">Ringkasan Pesanan</h4>
                <div id="checkoutItems" class="space-y-2">
                    <!-- Items will be populated here -->
                </div>
                <div class="border-t pt-3 mt-3">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold">Total:</span>
                        <span class="font-bold text-xl text-green-600" id="checkoutTotal">Rp75.000</span>
                    </div>
                </div>
            </div>
            
            <!-- Shipping Information -->
            <div class="mb-6">
                <h4 class="font-bold text-lg mb-3">Informasi Pengiriman</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" id="fullName" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Masukkan nama lengkap">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="tel" id="phoneNumber" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Masukkan nomor telepon">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea id="address" rows="3" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Masukkan alamat lengkap"></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Payment Method -->
            <div class="mb-6">
                <h4 class="font-bold text-lg mb-3">Metode Pembayaran</h4>
                <div class="space-y-3">
                    <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="paymentMethod" value="cod" class="mr-3" checked>
                        <div class="flex items-center">
                            <i class="fas fa-money-bill-wave text-green-600 mr-2"></i>
                            <span>Cash on Delivery (COD)</span>
                        </div>
                    </label>
                    <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="paymentMethod" value="transfer" class="mr-3">
                        <div class="flex items-center">
                            <i class="fas fa-university text-blue-600 mr-2"></i>
                            <span>Transfer Bank</span>
                        </div>
                    </label>
                    <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="paymentMethod" value="ewallet" class="mr-3">
                        <div class="flex items-center">
                            <i class="fas fa-wallet text-purple-600 mr-2"></i>
                            <span>E-Wallet</span>
                        </div>
                    </label>
                </div>
            </div>
            
            <!-- Shipping Method -->
            <div class="mb-6">
                <h4 class="font-bold text-lg mb-3">Metode Pengiriman</h4>
                <div class="space-y-3">
                    <label class="flex items-center justify-between p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                        <div class="flex items-center">
                            <input type="radio" name="shippingMethod" value="regular" class="mr-3" checked>
                            <div>
                                <span class="font-medium">Regular (3-5 hari)</span>
                                <p class="text-sm text-gray-600">Gratis ongkir</p>
                            </div>
                        </div>
                        <span class="font-bold text-green-600">Gratis</span>
                    </label>
                    <label class="flex items-center justify-between p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                        <div class="flex items-center">
                            <input type="radio" name="shippingMethod" value="express" class="mr-3">
                            <div>
                                <span class="font-medium">Express (1-2 hari)</span>
                                <p class="text-sm text-gray-600">Pengiriman cepat</p>
                            </div>
                        </div>
                        <span class="font-bold text-blue-600">+Rp15.000</span>
                    </label>
                </div>
            </div>
            
            <!-- Order Total -->
            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                <h4 class="font-bold text-lg mb-3">Total Pembayaran</h4>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span id="subtotal">Rp75.000</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Ongkos Kirim</span>
                        <span id="shippingCost">Gratis</span>
                    </div>
                    <div class="border-t pt-2">
                        <div class="flex justify-between font-bold text-lg">
                            <span>Total</span>
                            <span id="finalTotal" class="text-green-600">Rp75.000</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex gap-3">
                <button onclick="closeCheckout()" class="flex-1 bg-gray-200 text-gray-800 py-3 px-4 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                    Kembali
                </button>
                <button onclick="processCheckout()" class="flex-1 bg-green-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                    <i class="fas fa-credit-card mr-2"></i>
                    Bayar Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Search Modal -->
<div id="searchModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl p-6 w-full max-w-2xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Pencarian Produk</h3>
                <button onclick="closeSearch()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="mb-4">
                <input type="text" id="searchInput" placeholder="Cari produk daur ulang..." 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div id="searchResults" class="space-y-3">
                <!-- Search results will be populated here -->
            </div>
        </div>
    </div>
</div>

<script>
// Shopping Cart Functionality
let cart = [];
let wishlist = [];

// Initialize cart from localStorage
document.addEventListener('DOMContentLoaded', function() {
    loadCart();
    loadWishlist();
    updateCartDisplay();
    
    // Fix sidebar logo visibility
    const sidebarLogoSmall = document.querySelector('.sidebar-logo-small');
    if (sidebarLogoSmall) {
        sidebarLogoSmall.style.display = 'block';
        sidebarLogoSmall.style.visibility = 'visible';
        sidebarLogoSmall.style.opacity = '1';
    }
});

function addToCart(productId, productName, price, image) {
    const existingItem = cart.find(item => item.id === productId);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            id: productId,
            name: productName,
            price: price,
            image: image,
            quantity: 1
        });
    }
    
    saveCart();
    updateCartDisplay();
    showNotification('Produk ditambahkan ke keranjang!', 'success');
}

function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    saveCart();
    updateCartDisplay();
    showNotification('Produk dihapus dari keranjang!', 'info');
}

function updateCartDisplay() {
    const cartCount = document.getElementById('cartCount');
    const cartItems = document.getElementById('cartItems');
    const cartTotal = document.getElementById('cartTotal');
    
    // Update cart count
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartCount.textContent = totalItems;
    
    // Update cart items display
    cartItems.innerHTML = '';
    let total = 0;
    
    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        
        cartItems.innerHTML += `
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                <img src="${item.image}" alt="${item.name}" class="w-12 h-12 object-cover rounded-lg">
                <div class="flex-1">
                    <h4 class="font-semibold">${item.name}</h4>
                    <p class="text-sm text-gray-600">Rp${item.price.toLocaleString()}</p>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="updateQuantity('${item.id}', ${item.quantity - 1})" class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center text-sm">-</button>
                    <span class="w-8 text-center">${item.quantity}</span>
                    <button onclick="updateQuantity('${item.id}', ${item.quantity + 1})" class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center text-sm">+</button>
                    <button onclick="removeFromCart('${item.id}')" class="text-red-500 hover:text-red-700">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
    });
    
    cartTotal.textContent = `Rp${total.toLocaleString()}`;
}

function updateQuantity(productId, newQuantity) {
    if (newQuantity <= 0) {
        removeFromCart(productId);
        return;
    }
    
    const item = cart.find(item => item.id === productId);
    if (item) {
        item.quantity = newQuantity;
        saveCart();
        updateCartDisplay();
    }
}

function openCart() {
    document.getElementById('cartModal').classList.remove('hidden');
}

function closeCart() {
    document.getElementById('cartModal').classList.add('hidden');
}

function openCheckout() {
    if (cart.length === 0) {
        showNotification('Keranjang belanja kosong!', 'error');
        return;
    }
    
    // Populate checkout items
    const checkoutItems = document.getElementById('checkoutItems');
    const checkoutTotal = document.getElementById('checkoutTotal');
    const subtotal = document.getElementById('subtotal');
    const finalTotal = document.getElementById('finalTotal');
    
    checkoutItems.innerHTML = '';
    let total = 0;
    
    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        
        checkoutItems.innerHTML += `
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="${item.image}" alt="${item.name}" class="w-10 h-10 object-cover rounded-lg">
                    <div>
                        <h5 class="font-semibold">${item.name}</h5>
                        <p class="text-sm text-gray-600">Qty: ${item.quantity}</p>
                    </div>
                </div>
                <span class="font-semibold">Rp${itemTotal.toLocaleString()}</span>
            </div>
        `;
    });
    
    checkoutTotal.textContent = `Rp${total.toLocaleString()}`;
    subtotal.textContent = `Rp${total.toLocaleString()}`;
    finalTotal.textContent = `Rp${total.toLocaleString()}`;
    
    // Close cart modal and open checkout modal
    closeCart();
    document.getElementById('checkoutModal').classList.remove('hidden');
}

function closeCheckout() {
    document.getElementById('checkoutModal').classList.add('hidden');
}

function processCheckout() {
    // Get form values
    const fullName = document.getElementById('fullName').value;
    const phoneNumber = document.getElementById('phoneNumber').value;
    const address = document.getElementById('address').value;
    const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
    const shippingMethod = document.querySelector('input[name="shippingMethod"]:checked').value;
    
    // Validate form
    if (!fullName || !phoneNumber || !address) {
        showNotification('Mohon lengkapi semua data pengiriman!', 'error');
        return;
    }
    
    // Calculate shipping cost
    let shippingCost = 0;
    if (shippingMethod === 'express') {
        shippingCost = 15000;
    }
    
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const finalTotal = subtotal + shippingCost;
    
    // Show success notification
    showNotification('Pesanan berhasil dibuat! Terima kasih telah berbelanja.', 'success');
    
    // Clear cart
    cart = [];
    saveCart();
    updateCartDisplay();
    
    // Close checkout modal
    closeCheckout();
    
    // Reset form
    document.getElementById('fullName').value = '';
    document.getElementById('phoneNumber').value = '';
    document.getElementById('address').value = '';
    document.querySelector('input[name="paymentMethod"][value="cod"]').checked = true;
    document.querySelector('input[name="shippingMethod"][value="regular"]').checked = true;
    
    // Show order details (optional)
    setTimeout(() => {
        showOrderConfirmation(fullName, finalTotal);
    }, 1000);
}

function showOrderConfirmation(customerName, total) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center';
    modal.innerHTML = `
        <div class="bg-white rounded-2xl p-8 max-w-md mx-4 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check text-green-600 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Pesanan Berhasil!</h3>
            <p class="text-gray-600 mb-4">Terima kasih ${customerName}, pesanan Anda telah kami terima.</p>
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <p class="text-sm text-gray-600">Total Pembayaran</p>
                <p class="text-2xl font-bold text-green-600">Rp${total.toLocaleString()}</p>
            </div>
            <p class="text-sm text-gray-600 mb-6">Tim kami akan menghubungi Anda segera untuk konfirmasi pesanan.</p>
            <button onclick="this.parentElement.parentElement.remove()" class="bg-green-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                Tutup
            </button>
        </div>
    `;
    document.body.appendChild(modal);
}

// Wishlist Functionality
function toggleWishlist(productId, button) {
    const isInWishlist = wishlist.includes(productId);
    
    if (isInWishlist) {
        wishlist = wishlist.filter(id => id !== productId);
        button.innerHTML = '<i class="far fa-heart"></i>';
        showNotification('Produk dihapus dari wishlist!', 'info');
    } else {
        wishlist.push(productId);
        button.innerHTML = '<i class="fas fa-heart"></i>';
        showNotification('Produk ditambahkan ke wishlist!', 'success');
    }
    
    saveWishlist();
}

// Search Functionality
function openSearch() {
    document.getElementById('searchModal').classList.remove('hidden');
    document.getElementById('searchInput').focus();
}

function closeSearch() {
    document.getElementById('searchModal').classList.add('hidden');
}

// Product Detail Navigation
function viewProductDetail(productId, productName) {
    // Store product info in sessionStorage for the detail page
    sessionStorage.setItem('selectedProduct', JSON.stringify({
        id: productId,
        name: productName
    }));
    
    // Navigate to product detail page using Laravel route
    window.location.href = `/product-detail/${productId}`;
}

// Category Filter
function filterByCategory(category) {
    // Remove active class from all filters
    document.querySelectorAll('.category-filter').forEach(filter => {
        filter.classList.remove('active');
    });
    
    // Add active class to clicked filter
    event.target.classList.add('active');
    
    // Show notification
    showNotification(`Filter: ${category}`, 'info');
    
    // Here you would typically filter the products
    // For now, just show a notification
}

// Sort Products
function sortProducts(sortType) {
    showNotification(`Produk diurutkan: ${sortType}`, 'info');
    // Here you would typically sort the products
}

// Notification System
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
    
    // Set background color based on type
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        info: 'bg-blue-500',
        warning: 'bg-yellow-500'
    };
    
    notification.className += ` ${colors[type] || colors.info} text-white`;
    notification.innerHTML = `
        <div class="flex items-center gap-2">
            <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'info'}-circle"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Local Storage Functions
function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
}

function loadCart() {
    const savedCart = localStorage.getItem('cart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
    }
}

function saveWishlist() {
    localStorage.setItem('wishlist', JSON.stringify(wishlist));
}

function loadWishlist() {
    const savedWishlist = localStorage.getItem('wishlist');
    if (savedWishlist) {
        wishlist = JSON.parse(savedWishlist);
    }
}

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    const cartModal = document.getElementById('cartModal');
    const searchModal = document.getElementById('searchModal');
    const checkoutModal = document.getElementById('checkoutModal');
    
    if (event.target === cartModal) {
        closeCart();
    }
    
    if (event.target === searchModal) {
        closeSearch();
    }
    
    if (event.target === checkoutModal) {
        closeCheckout();
    }
});

// Update shipping cost when shipping method changes
document.addEventListener('change', function(event) {
    if (event.target.name === 'shippingMethod') {
        updateShippingCost();
    }
});

// Fix sidebar logo visibility when sidebar state changes
document.addEventListener('alpine:init', () => {
    Alpine.data('sidebarData', () => ({
        sidebarOpen: false,
        init() {
            this.$watch('sidebarOpen', (value) => {
                const logoSmall = document.querySelector('.sidebar-logo-small');
                if (logoSmall) {
                    if (!value) {
                        // Sidebar collapsed - ensure logo is visible
                        logoSmall.style.display = 'block';
                        logoSmall.style.visibility = 'visible';
                        logoSmall.style.opacity = '1';
                    }
                }
            });
        }
    }));
});

function updateShippingCost() {
    const shippingMethod = document.querySelector('input[name="shippingMethod"]:checked').value;
    const shippingCostElement = document.getElementById('shippingCost');
    const finalTotalElement = document.getElementById('finalTotal');
    const subtotalElement = document.getElementById('subtotal');
    
    let shippingCost = 0;
    if (shippingMethod === 'express') {
        shippingCost = 15000;
        shippingCostElement.textContent = 'Rp15.000';
    } else {
        shippingCostElement.textContent = 'Gratis';
    }
    
    // Get subtotal from cart
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const finalTotal = subtotal + shippingCost;
    
    finalTotalElement.textContent = `Rp${finalTotal.toLocaleString()}`;
}

// Search functionality
function searchProducts(query) {
    if (query.length < 2) {
        return;
    }
    
    showNotification(`Mencari: ${query}`, 'info');
    // Here you would typically search through products
    // For now, just show a notification
}

document.getElementById('searchInput')?.addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase();
    const searchResults = document.getElementById('searchResults');
    
    if (query.length < 2) {
        searchResults.innerHTML = '';
        return;
    }
    
    // Simulate search results
    const products = [
        { id: 1, name: 'Tas Kreasi', price: 20000, image: 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80' },
        { id: 2, name: 'Model Dinosaurus', price: 35000, image: 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80' },
        { id: 3, name: 'Keranjang Anyaman', price: 25000, image: 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80' }
    ];
    
    const filteredProducts = products.filter(product => 
        product.name.toLowerCase().includes(query)
    );
    
    searchResults.innerHTML = filteredProducts.map(product => `
        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100" 
             onclick="viewProductDetail('${product.id}', '${product.name}')">
            <img src="${product.image}" alt="${product.name}" class="w-12 h-12 object-cover rounded-lg">
            <div class="flex-1">
                <h4 class="font-semibold">${product.name}</h4>
                <p class="text-sm text-gray-600">Rp${product.price.toLocaleString()}</p>
            </div>
            <i class="fas fa-chevron-right text-gray-400"></i>
        </div>
    `).join('');
});
</script>
    </div>
</div>
@endsection 