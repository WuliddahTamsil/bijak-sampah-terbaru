<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Bijak Sampah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
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
    }
    
    .page-title {
        color: #05445E;
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 2rem;
    }

    .settings-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        border: 1px solid #e9ecef;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .settings-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .settings-section {
        margin-bottom: 2rem;
    }

    .settings-title {
        color: #05445E;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        border-bottom: 2px solid #75E6DA;
        padding-bottom: 0.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        color: #05445E;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-input:focus {
        outline: none;
        border-color: #75E6DA;
        box-shadow: 0 0 0 3px rgba(117, 230, 218, 0.2);
    }

    .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
        cursor: pointer;
    }

    .form-select:focus {
        outline: none;
        border-color: #75E6DA;
        box-shadow: 0 0 0 3px rgba(117, 230, 218, 0.2);
    }

    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #75E6DA;
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    .notification-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .notification-item:hover {
        background-color: #f8fafc;
    }

    .notification-item:last-child {
        border-bottom: none;
    }

    .notification-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .notification-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    .notification-text {
        flex: 1;
    }

    .notification-title {
        font-weight: 600;
        color: #05445E;
        margin-bottom: 0.25rem;
    }

    .notification-description {
        color: #666;
        font-size: 0.9rem;
    }

    .privacy-option {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .privacy-option:hover {
        background-color: #f8fafc;
    }

    .privacy-option:last-child {
        border-bottom: none;
    }

    .privacy-info {
        flex: 1;
    }

    .privacy-title {
        font-weight: 600;
        color: #05445E;
        margin-bottom: 0.25rem;
    }

    .privacy-description {
        color: #666;
        font-size: 0.9rem;
    }

    .btn-primary {
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
</style>

<div class="flex min-h-screen bg-gray-50" x-data="{ sidebarOpen: false }">
    {{-- Sidebar Overlay --}}
    <div class="sidebar-overlay" :class="{ 'active': sidebarOpen }" @click="sidebarOpen = false"></div>

    {{-- Sidebar --}}
    <aside 
        x-data="{ open: false, active: 'settings' }"
        x-ref="sidebar"
        @mouseenter="open = true; $root.sidebarOpen = true"
        @mouseleave="open = false; $root.sidebarOpen = false"
        class="fixed top-0 left-0 z-50 flex flex-col py-6 sidebar-hover overflow-hidden shadow-2xl group sidebar-gradient"
        :class="open ? 'w-64' : 'w-16'"
        style="transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); margin-top: 0; height: 100vh;"
    >
        <div class="relative flex flex-col h-full w-full px-4">
            {{-- Logo Section --}}
            <div class="flex items-center justify-center mb-6 mt-4 sidebar-logo">
                <img x-show="open" class="w-24 h-auto" src="/asset/img/logo1.png" alt="Logo Penuh">
                <img x-show="!open" class="w-5 h-5" src="/asset/img/logo.png" alt="Logo Ikon">
            </div>
            
            {{-- Navigation Menu --}}
            <nav class="flex flex-col gap-1 w-full flex-1">
                {{-- Dashboard Link --}}
                <a href="/nasabahdashboard" class="flex items-center gap-3 p-2 font-medium sidebar-nav-item whitespace-nowrap w-full" :class="open ? (active === 'dashboard' ? 'active text-white' : 'text-white') : (active === 'dashboard' ? 'active text-white justify-center' : 'text-white justify-center')">
                    <i class="fas fa-home text-base"></i>
                    <span x-show="open" class="text-sm font-medium">Dashboard</span>
                </a>
                
                {{-- Komunitas Link --}}
                <a href="/nasabahkomunitas" class="flex items-center gap-3 p-2 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'komunitas' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'komunitas' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-users text-base"></i>
                    <span x-show="open" class="text-sm font-medium">Komunitas</span>
                </a>
                
                {{-- Penjemputan Sampah Link --}}
                <a href="/sampahnasabah" class="flex items-center gap-3 p-2 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'penjemputan' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'penjemputan' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-trash-alt text-base"></i>
                    <span x-show="open" class="text-sm font-medium">Penjemputan Sampah</span>
                </a>
                
                {{-- Poin Link --}}
                <a href="/poin-nasabah" class="flex items-center gap-3 p-2 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'poin' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'poin' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-coins text-base"></i>
                    <span x-show="open" class="text-sm font-medium">Poin Mu</span>
                </a>
                
                {{-- Riwayat Transaksi Link --}}
                <a href="/riwayattransaksinasabah" class="flex items-center gap-3 p-2 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'riwayat-transaksi' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'riwayat-transaksi' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-history text-base"></i>
                    <span x-show="open" class="text-sm font-medium">Riwayat Transaksi</span>
                </a>
                
                {{-- Toko Link --}}
                <a href="/tokon" class="flex items-center gap-3 p-2 font-medium sidebar-nav-item whitespace-nowrap w-full" :class="open ? (active === 'marketplace' ? 'active text-white' : 'text-white') : (active === 'marketplace' ? 'active text-white justify-center' : 'text-white justify-center')">
                    <i class="fas fa-store text-base"></i>
                    <span x-show="open" class="text-sm font-medium">Toko</span>
                </a>
                
                {{-- Settings Link --}}
                <a href="/settingsnasab" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'settings' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'settings' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
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
                <button onclick="showDevelopmentModal('Notification')" class="relative hover:text-white/80 transition-colors">
                    <i class="far fa-bell text-white text-sm"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-medium">2</span>
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
            <h1 class="page-title">Aplikasi</h1>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Notifikasi Settings --}}
                <div class="settings-card">
                    <h2 class="settings-title">Notifikasi</h2>
                    <div class="settings-section">
                        <div class="notification-item">
                            <div class="notification-info">
                                <div class="notification-icon" style="background: linear-gradient(135deg, #10B981, #059669);">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <div class="notification-text">
                                    <div class="notification-title">Email Notifikasi</div>
                                    <div class="notification-description">Terima notifikasi melalui email</div>
                                </div>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="notification-item">
                            <div class="notification-info">
                                <div class="notification-icon" style="background: linear-gradient(135deg, #F59E0B, #D97706);">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <div class="notification-text">
                                    <div class="notification-title">Push Notifikasi</div>
                                    <div class="notification-description">Terima notifikasi push</div>
                                </div>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="notification-item">
                            <div class="notification-info">
                                <div class="notification-icon" style="background: linear-gradient(135deg, #EF4444, #DC2626);">
                                    <i class="fas fa-sms"></i>
                                </div>
                                <div class="notification-text">
                                    <div class="notification-title">SMS Notifikasi</div>
                                    <div class="notification-description">Terima notifikasi melalui SMS</div>
                                </div>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Appearance Settings --}}
                <div class="settings-card">
                    <h2 class="settings-title">Penampilan</h2>
                    <div class="settings-section">
                        <div class="form-group">
                            <label class="form-label">Tema</label>
                            <select class="form-select">
                                <option value="light" selected>Terang</option>
                                <option value="dark">Gelap</option>
                                <option value="auto">Otomatis</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Privacy Settings --}}
                <div class="settings-card">
                    <h2 class="settings-title">Pengaturan privasi akun Anda</h2>
                    <div class="settings-section">
                        <div class="privacy-option">
                            <div class="privacy-info">
                                <div class="privacy-title">Dapat melihat profil Anda</div>
                                <div class="privacy-description">Siapa yang dapat melihat profil Anda</div>
                            </div>
                            <button class="btn-secondary px-4 py-2 rounded-lg">
                                Ubah
                            </button>
                        </div>
                        <div class="privacy-option">
                            <div class="privacy-info">
                                <div class="privacy-title">Status Verifikasi</div>
                                <div class="privacy-description">Status verifikasi akun Anda</div>
                            </div>
                            <span class="text-green-600 font-semibold">Terverifikasi</span>
                        </div>
                        <div class="privacy-option">
                            <div class="privacy-info">
                                <div class="privacy-title">Pengaturan Publik</div>
                                <div class="privacy-description">Pengaturan visibilitas profil</div>
                            </div>
                            <select class="form-select w-auto">
                                <option value="public" selected>Publik</option>
                                <option value="private">Privat</option>
                                <option value="friends">Teman Saja</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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
</script>
</body>
</html> 