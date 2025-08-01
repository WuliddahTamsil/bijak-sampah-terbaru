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
        {{-- Decorative Elements --}}
        <div class="decorative-element top-right"></div>
        <div class="decorative-element bottom-left"></div>
        
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
            <div id="cartItems" class="space-y-3 mb-4">
                <!-- Cart items will be populated here -->
            </div>
            <div class="border-t pt-4">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-semibold">Total:</span>
                    <span class="font-bold text-lg" id="cartTotal">Rp75.000</span>
                </button>
            </div>
            <div class="flex gap-3">
                <button onclick="closeCart()" class="flex-1 bg-gray-200 text-gray-800 py-2 px-4 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                    Lanjut Belanja
                </button>
                <button onclick="checkout()" class="flex-1 bg-green-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                    Checkout
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

function checkout() {
    if (cart.length === 0) {
        showNotification('Keranjang belanja kosong!', 'error');
        return;
    }
    
    showNotification('Redirecting ke halaman checkout...', 'success');
    setTimeout(() => {
        window.location.href = '/checkout';
    }, 1000);
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
    
    if (event.target === cartModal) {
        closeCart();
    }
    
    if (event.target === searchModal) {
        closeSearch();
    }
});

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