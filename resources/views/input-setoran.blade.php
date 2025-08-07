@extends('layouts.app')

@section('title', 'Input Setoran - Bijak Sampah')

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

    .form-card {
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

    .form-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .form-section {
        margin-bottom: 2rem;
    }

    .form-title {
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

    .text-highlight {
        color: #75E6DA;
    }

    .weight-display {
        background: linear-gradient(135deg, #75E6DA, #05445E);
        color: white;
        padding: 1rem;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 1rem;
    }

    .weight-value {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .weight-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }
</style>

<div class="flex min-h-screen bg-gray-50" x-data="{ sidebarOpen: false }">
    {{-- Sidebar Overlay --}}
    <div class="sidebar-overlay" :class="{ 'active': sidebarOpen }" @click="sidebarOpen = false"></div>

    {{-- Sidebar --}}
    <aside 
        x-data="{ open: false, active: 'input-setoran' }"
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
                <a href="{{ route('dashboard-banksampah') }}" class="flex items-center gap-3 p-3 font-medium sidebar-nav-item whitespace-nowrap w-full" :class="open ? (active === 'dashboard' ? 'active text-white' : 'text-white') : (active === 'dashboard' ? 'active text-white justify-center' : 'text-white justify-center')">
                    <i class="fas fa-home text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Dashboard</span>
                </a>
                
                {{-- Nasabah Link --}}
                <a href="{{ route('data-nasabah-banksampah') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'nasabah' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'nasabah' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-users text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Nasabah</span>
                </a>
                
                {{-- Penjemputan Sampah Link --}}
                <a href="{{ route('penjemputan-sampah-banksampah') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'penjemputan' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'penjemputan' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-truck text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Penjemputan Sampah</span>
                </a>
                
                {{-- Input Setoran Link --}}
                <a href="{{ route('input-setoran') }}" class="flex items-center gap-3 p-3 font-medium sidebar-nav-item whitespace-nowrap w-full" :class="open ? (active === 'input-setoran' ? 'active text-white' : 'text-white') : (active === 'input-setoran' ? 'active text-white justify-center' : 'text-white justify-center')">
                    <i class="fas fa-plus-circle text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Input Setoran</span>
                </a>
                
                {{-- Data Sampah Link --}}
                <a href="{{ route('datasampah-banksampah') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'data-sampah' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'data-sampah' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-trash-alt text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Data Sampah</span>
                </a>
                
                {{-- Penjualan Sampah Link --}}
                <a href="{{ route('penjualansampah-banksampah') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'penjualan' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'penjualan' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Penjualan Sampah</span>
                </a>
                
                {{-- Settings Link --}}
                <a href="{{ route('settingsbank') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'settings' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'settings' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
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
                        <img src="https://ui-avatars.com/api/?name=Bank+Sampah&background=75E6DA&color=05445E" alt="Profile" class="w-full h-full object-cover">
                    </button>
                    <button onclick="showDevelopmentModal('Profile Menu')" class="hover:text-white/80 transition-colors">
                        <i class="fas fa-chevron-down text-white text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
        
        {{-- Content Container --}}
        <div class="content-container">
            <h1 class="text-4xl font-bold text-center mb-8 text-highlight">Input Setoran Sampah</h1>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Form Input Setoran --}}
                <div class="form-card">
                    <h2 class="form-title">Data Setoran</h2>
                    <div class="form-section">
                        <div class="form-group">
                            <label class="form-label">Nama Nasabah</label>
                            <select class="form-select">
                                <option value="">Pilih Nasabah</option>
                                <option value="1">Ahmad Nasabah</option>
                                <option value="2">Siti Nasabah</option>
                                <option value="3">Budi Nasabah</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jenis Sampah</label>
                            <select class="form-select">
                                <option value="">Pilih Jenis Sampah</option>
                                <option value="plastik">Plastik</option>
                                <option value="kertas">Kertas</option>
                                <option value="kardus">Kardus</option>
                                <option value="botol">Botol</option>
                                <option value="kaleng">Kaleng</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Berat (kg)</label>
                            <input type="number" class="form-input" placeholder="Masukkan berat sampah" step="0.1" min="0">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Harga per kg</label>
                            <input type="number" class="form-input" placeholder="Masukkan harga per kg" step="100" min="0">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Setoran</label>
                            <input type="date" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-input" rows="3" placeholder="Tambahkan keterangan jika diperlukan"></textarea>
                        </div>
                        <button class="btn-primary px-6 py-2 rounded-lg w-full">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Setoran
                        </button>
                    </div>
                </div>

                {{-- Informasi Setoran --}}
                <div class="form-card">
                    <h2 class="form-title">Informasi Setoran</h2>
                    <div class="form-section">
                        <div class="weight-display">
                            <div class="weight-value">0.0 kg</div>
                            <div class="weight-label">Total Berat Sampah</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Total Harga</label>
                            <div class="text-2xl font-bold text-green-600">Rp 0</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Status Setoran</label>
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                    Pending
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Riwayat Setoran Hari Ini</label>
                            <div class="space-y-2">
                                <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
                                    <span class="text-sm">Plastik - 2.5 kg</span>
                                    <span class="text-sm font-medium text-green-600">Rp 12,500</span>
                                </div>
                                <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
                                    <span class="text-sm">Kertas - 1.0 kg</span>
                                    <span class="text-sm font-medium text-green-600">Rp 3,000</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Setoran Terbaru --}}
            <div class="form-card">
                <h2 class="form-title">Setoran Terbaru</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-2 text-left">Tanggal</th>
                                <th class="px-4 py-2 text-left">Nasabah</th>
                                <th class="px-4 py-2 text-left">Jenis Sampah</th>
                                <th class="px-4 py-2 text-left">Berat</th>
                                <th class="px-4 py-2 text-left">Harga</th>
                                <th class="px-4 py-2 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b">
                                <td class="px-4 py-2">07/08/2025</td>
                                <td class="px-4 py-2">Ahmad Nasabah</td>
                                <td class="px-4 py-2">Plastik</td>
                                <td class="px-4 py-2">2.5 kg</td>
                                <td class="px-4 py-2">Rp 12,500</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Selesai</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="px-4 py-2">07/08/2025</td>
                                <td class="px-4 py-2">Siti Nasabah</td>
                                <td class="px-4 py-2">Kertas</td>
                                <td class="px-4 py-2">1.0 kg</td>
                                <td class="px-4 py-2">Rp 3,000</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Pending</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
@endsection 