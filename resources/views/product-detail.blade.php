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
    .product-detail-card {
        background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(15px);
        border-radius: 24px; box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
        padding: 3rem; border: 1px solid rgba(255, 255, 255, 0.3);
        position: relative; overflow: hidden; margin: 2rem auto; max-width: 1000px;
    }
    .product-detail-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
        background: linear-gradient(90deg, #75E6DA, #05445E);
    }
    .product-image-large {
        width: 100%; height: 400px; object-fit: cover; border-radius: 16px;
        transition: all 0.3s ease; margin-bottom: 2rem;
    }
    .product-title-large {
        font-size: 2.5rem; font-weight: 800; color: #1f2937; margin-bottom: 1rem;
    }
    .product-price-large {
        font-size: 2rem; font-weight: 800; color: #059669; margin-bottom: 1.5rem;
    }
    .product-description {
        font-size: 1.1rem; line-height: 1.8; color: #6b7280; margin-bottom: 2rem;
    }
    .product-actions-large {
        display: flex; gap: 1rem; margin-bottom: 2rem;
    }
    .buy-now-btn {
        background: linear-gradient(135deg, #10b981, #059669); color: white;
        padding: 1rem 2rem; border-radius: 12px; font-weight: 600; text-decoration: none;
        display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); border: none; cursor: pointer;
        font-size: 1.1rem;
    }
    .buy-now-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4); }
    .add-to-cart-btn-large {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white;
        padding: 1rem 2rem; border-radius: 12px; font-weight: 600; border: none;
        cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        font-size: 1.1rem;
    }
    .add-to-cart-btn-large:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4); }
    .wishlist-btn-large {
        background: linear-gradient(135deg, #ef4444, #dc2626); color: white;
        padding: 1rem; border-radius: 12px; border: none; cursor: pointer;
        transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        font-size: 1.1rem;
    }
    .wishlist-btn-large:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4); }
    .back-btn {
        background: linear-gradient(135deg, #6b7280, #4b5563); color: white;
        padding: 0.75rem 1.5rem; border-radius: 12px; font-weight: 600; text-decoration: none;
        display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
    }
    .back-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(107, 114, 128, 0.4); }
    
    /* Responsive fixes */
    @media (max-width: 1024px) {
        .main-content-wrapper { padding-left: 1rem; padding-right: 1rem; }
        .content-container { padding: 1.5rem; }
    }
    @media (max-width: 768px) {
        .main-content-wrapper { padding-left: 0.5rem; padding-right: 0.5rem; }
        .content-container { padding: 1rem; }
        .product-detail-card { padding: 2rem; }
        .product-title-large { font-size: 2rem; }
        .product-actions-large { flex-direction: column; }
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
            <a href="/toko" class="back-btn mb-6">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Toko
            </a>
            
            <div class="product-detail-card">
                <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Product Detail" class="product-image-large">
                
                <h1 class="product-title-large" id="productTitle">Tas Kreasi</h1>
                <div class="product-price-large" id="productPrice">Rp20.000</div>
                
                <div class="product-description">
                    <p>Produk daur ulang berkualitas tinggi yang dibuat dengan tangan oleh pengrajin lokal. 
                    Tas ini terbuat dari bahan-bahan ramah lingkungan yang dipilih dengan teliti untuk 
                    memberikan hasil akhir yang indah dan tahan lama.</p>
                    
                    <h3 class="text-xl font-bold mt-4 mb-2">Spesifikasi:</h3>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Bahan: Daur ulang dari plastik dan kain</li>
                        <li>Ukuran: 30cm x 25cm x 10cm</li>
                        <li>Berat: 500 gram</li>
                        <li>Warna: Natural dengan aksen hijau</li>
                        <li>Garansi: 1 tahun</li>
                    </ul>
                    
                    <h3 class="text-xl font-bold mt-4 mb-2">Keunggulan:</h3>
                    <ul class="list-disc list-inside space-y-1">
                        <li>100% ramah lingkungan</li>
                        <li>Dibuat dengan tangan oleh pengrajin lokal</li>
                        <li>Desain unik dan eksklusif</li>
                        <li>Tahan lama dan mudah dibersihkan</li>
                        <li>Mendukung ekonomi lokal</li>
                    </ul>
                </div>
                
                <div class="product-actions-large">
                    <button class="buy-now-btn" onclick="buyNow()">
                        <i class="fas fa-shopping-bag mr-2"></i>
                        Beli Sekarang
                    </button>
                    <button class="add-to-cart-btn-large" onclick="addToCartDetail()">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Tambah ke Keranjang
                    </button>
                    <button class="wishlist-btn-large" onclick="toggleWishlistDetail()">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                
                <div class="border-t pt-4">
                    <h3 class="text-lg font-bold mb-2">Informasi Penjual:</h3>
                    <div class="flex items-center gap-3">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Seller" class="w-12 h-12 rounded-full">
                        <div>
                            <div class="font-semibold">@Wugis</div>
                            <div class="text-sm text-gray-600">Pengrajin Lokal</div>
                            <div class="text-sm text-gray-600">⭐ 4.8 (150 ulasan)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Get product info from sessionStorage and route parameter
document.addEventListener('DOMContentLoaded', function() {
    const selectedProduct = sessionStorage.getItem('selectedProduct');
    const productId = '{{ $id }}'; // Get ID from Laravel route
    
    if (selectedProduct) {
        const product = JSON.parse(selectedProduct);
        document.getElementById('productTitle').textContent = product.name;
        
        // Set price based on product ID
        const prices = {
            '1': 'Rp20.000',
            '2': 'Rp35.000',
            '3': 'Rp25.000',
            '4': 'Rp18.000',
            '5': 'Rp30.000',
            '6': 'Rp18.000',
            '7': 'Rp45.000',
            '8': 'Rp15.000'
        };
        
        document.getElementById('productPrice').textContent = prices[productId] || 'Rp20.000';
    } else {
        // Fallback if no sessionStorage data
        const productNames = {
            '1': 'Tas Kreasi',
            '2': 'Model Dinosaurus',
            '3': 'Keranjang Anyaman',
            '4': 'Keranjang Matahari',
            '5': 'Tas Daur Ulang',
            '6': 'Keranjang Matahari',
            '7': 'Hiasan Dinding Anyaman',
            '8': 'Aksesoris Daur Ulang'
        };
        
        const prices = {
            '1': 'Rp20.000',
            '2': 'Rp35.000',
            '3': 'Rp25.000',
            '4': 'Rp18.000',
            '5': 'Rp30.000',
            '6': 'Rp18.000',
            '7': 'Rp45.000',
            '8': 'Rp15.000'
        };
        
        document.getElementById('productTitle').textContent = productNames[productId] || 'Produk Daur Ulang';
        document.getElementById('productPrice').textContent = prices[productId] || 'Rp20.000';
    }
});

function buyNow() {
    showNotification('Redirecting ke halaman pembayaran...', 'success');
    setTimeout(() => {
        window.location.href = '/checkout';
    }, 1000);
}

function addToCartDetail() {
    const selectedProduct = sessionStorage.getItem('selectedProduct');
    const productId = '{{ $id }}'; // Get ID from Laravel route
    
    if (selectedProduct) {
        const product = JSON.parse(selectedProduct);
        const prices = {
            '1': 20000,
            '2': 35000,
            '3': 25000,
            '4': 18000,
            '5': 30000,
            '6': 18000,
            '7': 45000,
            '8': 15000
        };
        
        addToCart(product.id, product.name, prices[product.id] || 20000, 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80');
    } else {
        // Fallback if no sessionStorage data
        const productNames = {
            '1': 'Tas Kreasi',
            '2': 'Model Dinosaurus',
            '3': 'Keranjang Anyaman',
            '4': 'Keranjang Matahari',
            '5': 'Tas Daur Ulang',
            '6': 'Keranjang Matahari',
            '7': 'Hiasan Dinding Anyaman',
            '8': 'Aksesoris Daur Ulang'
        };
        
        const prices = {
            '1': 20000,
            '2': 35000,
            '3': 25000,
            '4': 18000,
            '5': 30000,
            '6': 18000,
            '7': 45000,
            '8': 15000
        };
        
        addToCart(productId, productNames[productId] || 'Produk Daur Ulang', prices[productId] || 20000, 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80');
    }
}

function toggleWishlistDetail() {
    const selectedProduct = sessionStorage.getItem('selectedProduct');
    const productId = '{{ $id }}'; // Get ID from Laravel route
    
    if (selectedProduct) {
        const product = JSON.parse(selectedProduct);
        toggleWishlist(product.id, event.target);
    } else {
        toggleWishlist(productId, event.target);
    }
}

// Import functions from toko page
function addToCart(productId, productName, price, image) {
    // This function will be available if loaded from toko page
    if (typeof window.addToCart === 'function') {
        window.addToCart(productId, productName, price, image);
    } else {
        showNotification('Produk ditambahkan ke keranjang!', 'success');
    }
}

function toggleWishlist(productId, button) {
    // This function will be available if loaded from toko page
    if (typeof window.toggleWishlist === 'function') {
        window.toggleWishlist(productId, button);
    } else {
        showNotification('Produk ditambahkan ke wishlist!', 'success');
    }
}

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
</script>
@endsection 