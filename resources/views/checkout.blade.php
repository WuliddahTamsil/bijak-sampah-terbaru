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
    .checkout-card {
        background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(15px);
        border-radius: 24px; box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
        padding: 3rem; border: 1px solid rgba(255, 255, 255, 0.3);
        position: relative; overflow: hidden; margin: 2rem auto; max-width: 800px;
    }
    .checkout-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
        background: linear-gradient(90deg, #75E6DA, #05445E);
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-label {
        display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;
    }
    .form-input {
        width: 100%; padding: 0.75rem 1rem; border: 2px solid #e5e7eb;
        border-radius: 12px; font-size: 1rem; transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.8);
    }
    .form-input:focus {
        outline: none; border-color: #75E6DA; box-shadow: 0 0 0 3px rgba(117, 230, 218, 0.1);
    }
    .order-summary {
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        border-radius: 16px; padding: 1.5rem; margin-bottom: 2rem;
        border: 1px solid #e5e7eb;
    }
    .order-item {
        display: flex; justify-content: space-between; align-items: center;
        padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;
    }
    .order-item:last-child {
        border-bottom: none;
    }
    .total-section {
        border-top: 2px solid #e5e7eb; padding-top: 1rem; margin-top: 1rem;
    }
    .total-row {
        display: flex; justify-content: space-between; align-items: center;
        font-weight: 600; font-size: 1.1rem;
    }
    .pay-btn {
        background: linear-gradient(135deg, #10b981, #059669); color: white;
        padding: 1rem 2rem; border-radius: 12px; font-weight: 600; border: none;
        cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        font-size: 1.1rem; width: 100%;
    }
    .pay-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4); }
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
        .checkout-card { padding: 2rem; }
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
            <h1 class="text-white font-semibold text-lg">Checkout</h1>
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
            
            <div class="checkout-card">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Checkout</h1>
                
                <div class="order-summary">
                    <h2 class="text-xl font-bold mb-4">Ringkasan Pesanan</h2>
                    <div id="orderItems">
                        <!-- Order items will be populated here -->
                    </div>
                    <div class="total-section">
                        <div class="total-row">
                            <span>Total:</span>
                            <span id="orderTotal">Rp0</span>
                        </div>
                    </div>
                </div>
                
                <form id="checkoutForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-xl font-bold mb-4">Informasi Pengiriman</h3>
                            
                            <div class="form-group">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-input" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-input" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-input" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea class="form-input" rows="3" required></textarea>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-xl font-bold mb-4">Metode Pembayaran</h3>
                            
                            <div class="form-group">
                                <label class="form-label">Pilih Metode Pembayaran</label>
                                <select class="form-input" required>
                                    <option value="">Pilih metode pembayaran</option>
                                    <option value="transfer">Transfer Bank</option>
                                    <option value="ewallet">E-Wallet</option>
                                    <option value="cod">Cash on Delivery</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Catatan (Opsional)</label>
                                <textarea class="form-input" rows="3" placeholder="Catatan untuk penjual..."></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="pay-btn mt-6">
                        <i class="fas fa-credit-card mr-2"></i>
                        Bayar Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Load cart items from localStorage
document.addEventListener('DOMContentLoaded', function() {
    loadOrderItems();
});

function loadOrderItems() {
    const cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const orderItems = document.getElementById('orderItems');
    const orderTotal = document.getElementById('orderTotal');
    
    if (cart.length === 0) {
        orderItems.innerHTML = '<p class="text-gray-500">Keranjang belanja kosong</p>';
        orderTotal.textContent = 'Rp0';
        return;
    }
    
    let total = 0;
    orderItems.innerHTML = '';
    
    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        
        orderItems.innerHTML += `
            <div class="order-item">
                <div>
                    <div class="font-semibold">${item.name}</div>
                    <div class="text-sm text-gray-600">Qty: ${item.quantity}</div>
                </div>
                <div class="font-semibold">Rp${itemTotal.toLocaleString()}</div>
            </div>
        `;
    });
    
    orderTotal.textContent = `Rp${total.toLocaleString()}`;
}

// Handle form submission
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Show success notification
    showNotification('Pesanan berhasil dibuat! Redirecting...', 'success');
    
    // Clear cart
    localStorage.removeItem('cart');
    
    // Redirect to success page after 2 seconds
    setTimeout(() => {
        window.location.href = '/toko';
    }, 2000);
});

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