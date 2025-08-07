@extends('layouts.app')

@section('title', 'Toko - Bijak Sampah')

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
        max-width: none;
    }
    .sidebar-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.5); z-index: 45; opacity: 0; visibility: hidden;
        transition: all 0.3s ease;
    }
    .sidebar-overlay.active { opacity: 1; visibility: visible; }
    

    
    @media (max-width: 768px) {
        .main-content-wrapper {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .content-container {
            padding: 1rem;
        }
        
        .page-title {
            font-size: 2rem;
        }
        
        .products-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .category-filter {
            padding: 0.4rem 1rem;
            font-size: 0.9rem;
        }
    }
    

    .page-title {
        color: #05445E;
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 2rem;
    }

    .search-bar {
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 25px;
        padding: 0.75rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .search-bar:focus-within {
        border-color: #75E6DA;
        box-shadow: 0 0 0 3px rgba(117, 230, 218, 0.2);
    }

    .search-input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 1rem;
        color: #333;
        background: transparent;
    }

    .search-btn {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .search-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(117, 230, 218, 0.3);
    }

    .filter-section {
        margin-bottom: 2rem;
    }

    .category-filter {
        background: #f8f9fa;
        color: #05445E;
        border: 2px solid #e9ecef;
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .category-filter:hover {
        background: #e9ecef;
        transform: translateY(-2px);
    }

    .category-filter.active {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
        color: white;
        border-color: transparent;
        font-weight: 600;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .product-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        border: 1px solid #e9ecef;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .product-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 2;
    }

    .product-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    .product-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
        margin: 1rem;
        margin-bottom: 0.5rem;
    }

    .product-description {
        color: #666;
        margin: 0 1rem 1rem;
        line-height: 1.5;
        font-size: 0.9rem;
    }

    .product-price {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        margin: 0 1rem 1rem;
        font-size: 1.5rem;
        font-weight: 700;
        color: #05445E;
    }

    .currency {
        font-size: 1rem;
        color: #666;
    }

    .product-actions {
        display: flex;
        gap: 0.5rem;
        margin: 1rem;
        margin-top: 0;
    }

    .btn-primary {
        flex: 1;
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
        color: white;
        border: none;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(117, 230, 218, 0.3);
    }

    .btn-secondary {
        background: #f8f9fa;
        color: #666;
        border: 1px solid #e9ecef;
        padding: 0.75rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: #e9ecef;
        transform: translateY(-2px);
    }

    .footer {
        text-align: center;
        color: #666;
        margin-top: 3rem;
        font-size: 0.9rem;
    }

    .footer strong {
        color: #05445E;
        font-weight: 600;
    }
</style>

<div class="flex min-h-screen bg-gray-50" x-data="{ sidebarOpen: false }">
    {{-- Sidebar Overlay --}}
    <div class="sidebar-overlay" :class="{ 'active': sidebarOpen }" @click="sidebarOpen = false"></div>

    {{-- Sidebar --}}
    <aside 
        x-data="{ open: false, active: 'marketplace' }"
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
                <a href="{{ route('tokon') }}" class="flex items-center gap-3 p-3 font-medium sidebar-nav-item whitespace-nowrap w-full" :class="open ? (active === 'marketplace' ? 'active text-white' : 'text-white') : (active === 'marketplace' ? 'active text-white justify-center' : 'text-white justify-center')">
                    <i class="fas fa-store text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Marketplace</span>
                </a>
                
                {{-- Settings Link --}}
                <a href="{{ route('settingsnasab') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'settings' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'settings' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
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
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-medium">3</span>
                </button>
                <button onclick="showDevelopmentModal('Search')" class="focus:outline-none hover:text-white/80 transition-colors">
                    <i class="fas fa-search text-white text-sm"></i>
                </button>
                <div class="flex items-center gap-2">
                    <button onclick="showDevelopmentModal('Profile')" class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center border-2 border-gray-300 cursor-pointer hover:border-white/50 transition-colors">
                        <img src="https://ui-avatars.com/api/?name=Nasabah&background=75E6DA&color=05445E" alt="Profile" class="w-full h-full object-cover">
                    </button>
                    <button onclick="showDevelopmentModal('Profile Menu')" class="hover:text-white/80 transition-colors">
                        <i class="fas fa-chevron-down text-white text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
        
        {{-- Content Container --}}
        <div class="content-container">
            <h1 class="page-title">Toko BijakSampah</h1>
            
            <div class="search-bar">
                <i class="fas fa-search text-gray-400"></i>
                <input type="text" id="searchInput" class="search-input" placeholder="Cari produk ramah lingkungan...">
                <button id="searchBtn" class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            
            <div class="filter-section">
                <div class="flex gap-2 flex-wrap">
                    <button class="category-filter active" data-category="semua">Semua</button>
                    <button class="category-filter" data-category="tas-belanja">Tas Belanja</button>
                    <button class="category-filter" data-category="botol-tumbler">Botol Tumbler</button>
                    <button class="category-filter" data-category="kompos">Kompos</button>
                    <button class="category-filter" data-category="produk-daur-ulang">Produk Daur Ulang</button>
                </div>
            </div>
            
            <div class="products-grid" id="productsGrid">
                <!-- Product Card 1 -->
                <div class="product-card" data-category="tas-belanja" data-name="Tas Belanja Reusable Premium" data-description="Tas belanja ramah lingkungan dengan desain modern dan tahan lama. Mengurangi penggunaan plastik sekali pakai.">
                    <div class="product-badge">Terlaris</div>
                    <img src="https://images.unsplash.com/photo-1597481499750-3e6b22637e12?w=400&h=300&fit=crop" alt="Tas Belanja Reusable" class="product-image">
                    <h3 class="product-title">Tas Belanja Reusable Premium</h3>
                    <p class="product-description">Tas belanja ramah lingkungan dengan desain modern dan tahan lama. Mengurangi penggunaan plastik sekali pakai.</p>
                    <div class="product-price">
                        <span class="currency">Rp</span>
                        89.000
                    </div>
                    <div class="product-actions">
                        <button class="btn-primary" onclick="showCheckoutModal('Tas Belanja Reusable Premium', 89000, 'https://images.unsplash.com/photo-1597481499750-3e6b22637e12?w=400&h=300&fit=crop')">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Beli Sekarang
                        </button>
                        <button class="btn-secondary">
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                </div>

                <!-- Product Card 2 -->
                <div class="product-card" data-category="botol-tumbler" data-name="Botol Tumbler Stainless Steel" data-description="Botol minum ramah lingkungan dengan teknologi vacuum insulation. Tahan panas dan dingin hingga 24 jam.">
                    <div class="product-badge">Baru</div>
                    <img src="https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=400&h=300&fit=crop" alt="Botol Tumbler Stainless" class="product-image">
                    <h3 class="product-title">Botol Tumbler Stainless Steel</h3>
                    <p class="product-description">Botol minum ramah lingkungan dengan teknologi vacuum insulation. Tahan panas dan dingin hingga 24 jam.</p>
                    <div class="product-price">
                        <span class="currency">Rp</span>
                        125.000
                    </div>
                    <div class="product-actions">
                        <button class="btn-primary" onclick="showCheckoutModal('Botol Tumbler Stainless Steel', 125000, 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=400&h=300&fit=crop')">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Beli Sekarang
                        </button>
                        <button class="btn-secondary">
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                </div>

                <!-- Product Card 3 -->
                <div class="product-card" data-category="kompos" data-name="Kompos Organik Premium" data-description="Kompos organik berkualitas tinggi untuk tanaman. Mengandung nutrisi lengkap dan ramah lingkungan.">
                    <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=400&h=300&fit=crop" alt="Kompos Organik" class="product-image">
                    <h3 class="product-title">Kompos Organik Premium</h3>
                    <p class="product-description">Kompos organik berkualitas tinggi untuk tanaman. Mengandung nutrisi lengkap dan ramah lingkungan.</p>
                    <div class="product-price">
                        <span class="currency">Rp</span>
                        45.000
                    </div>
                    <div class="product-actions">
                        <button class="btn-primary" onclick="showCheckoutModal('Kompos Organik Premium', 45000, 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=400&h=300&fit=crop')">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Beli Sekarang
                        </button>
                        <button class="btn-secondary">
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                </div>

                <!-- Product Card 4 -->
                <div class="product-card" data-category="produk-daur-ulang" data-name="Kotak Makan Reusable" data-description="Kotak makan ramah lingkungan dengan kompartemen terpisah. Aman untuk microwave dan tahan lama.">
                    <div class="product-badge">Eco</div>
                    <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop" alt="Kotak Makan Reusable" class="product-image">
                    <h3 class="product-title">Kotak Makan Reusable</h3>
                    <p class="product-description">Kotak makan ramah lingkungan dengan kompartemen terpisah. Aman untuk microwave dan tahan lama.</p>
                    <div class="product-price">
                        <span class="currency">Rp</span>
                        75.000
                    </div>
                    <div class="product-actions">
                        <button class="btn-primary" onclick="showCheckoutModal('Kotak Makan Reusable', 75000, 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop')">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Beli Sekarang
                        </button>
                        <button class="btn-secondary">
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="footer">
                <p>© 2025 <strong>BijakSampah</strong>. Semua produk ramah lingkungan untuk masa depan yang lebih hijau.</p>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize sidebar functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Ensure sidebar is properly initialized
        const sidebar = document.querySelector('aside');
        if (sidebar) {
            // Add any additional initialization if needed
            console.log('Sidebar initialized successfully');
        }
    });

    // Show Development Modal
    function showDevelopmentModal(featureName) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center';
        modal.innerHTML = `
            <div class="bg-white rounded-2xl p-8 max-w-md mx-4 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-tools text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">${featureName} - Fitur Dalam Pengembangan</h3>
                <p class="text-gray-600 mb-4">Fitur ini sedang dalam tahap pengembangan. Tim kami sedang bekerja keras untuk menghadirkan pengalaman terbaik untuk Anda.</p>
                <div class="bg-blue-50 rounded-lg p-4 mb-6">
                    <p class="text-sm text-blue-600">
                        <i class="fas fa-clock"></i> Estimasi rilis: 2-3 minggu ke depan
                    </p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    Mengerti
                </button>
            </div>
        `;
        document.body.appendChild(modal);
    }

    function showCheckoutModal(productName, price, imageUrl) {
        alert(`Checkout untuk ${productName} - Rp ${price.toLocaleString()}`);
    }
</script>
@endsection 