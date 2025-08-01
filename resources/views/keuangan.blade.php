@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
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
    .chart-bar { 
        transition: all 0.3s ease; 
        position: relative;
    }
    .chart-bar:hover { 
        transform: scaleY(1.05); 
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .chart-bar::after {
        content: attr(data-value);
        position: absolute;
        top: -25px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(255,255,255,0.9);
        color: #333;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: bold;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .chart-bar:hover::after {
        opacity: 1;
    }
    .progress-ring {
        transform: rotate(-90deg);
    }
    .progress-ring-circle {
        transition: stroke-dasharray 0.35s;
        transform-origin: 50% 50%;
    }
    .stat-card {
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .gradient-bg-green {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    .gradient-bg-orange {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }
    .gradient-bg-purple {
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    }
</style>

<div class="flex min-h-screen bg-gradient-to-br from-blue-50 via-white to-teal-50" x-data="{ sidebarOpen: false, activeTab: 'pemasukan' }">
    {{-- Sidebar --}}
    <aside
        x-data="{ open: false, active: 'keuangan' }"
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
                <img x-show="open" class="w-16 h-auto" src="{{ asset('asset/img/logo.png') }}" alt="Logo Penuh">
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
    <div class="flex-1 min-h-screen" :style="'padding-left:' + (sidebarOpen ? '16rem' : '4rem') + '; transition: padding-left 0.3s cubic-bezier(0.4,0,0.2,1);'">
        {{-- Top Header Bar --}}
        <div class="fixed-header" :style="'padding-left:' + (sidebarOpen ? '16rem' : '4rem') + ';'">
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

        {{-- Main Content --}}
        <div class="p-8 w-full" style="padding-top: 60px;">
            <div class="p-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">Keuangan</h1>
                        <p class="text-gray-600 text-lg">Kelola dan pantau keuangan Anda dengan mudah</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="bg-white rounded-xl shadow-lg px-6 py-3 border border-gray-100">
                            <i class="fas fa-calendar text-blue-500 mr-2"></i>
                            <span class="text-sm font-medium text-gray-700">23 Maret 2025</span>
                        </div>
                    </div>
                </div>
                
                {{-- Statistics Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Saldo -->
                    <div class="stat-card bg-white rounded-2xl shadow-2xl p-6 border-2 border-green-200 hover:border-green-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-700 text-sm font-bold uppercase tracking-wide mb-2">Total Saldo</p>
                                <p class="text-3xl font-black text-gray-900 mb-2">Rp202.000</p>
                                <p class="text-green-700 text-sm font-bold flex items-center">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    +12.5% dari bulan lalu
                                </p>
                            </div>
                            <div class="bg-green-600 rounded-full p-4 shadow-xl">
                                <i class="fas fa-wallet text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Pemasukan Bulan Ini -->
                    <div class="stat-card bg-white rounded-2xl shadow-2xl p-6 border-2 border-blue-200 hover:border-blue-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-700 text-sm font-bold uppercase tracking-wide mb-2">Pemasukan</p>
                                <p class="text-3xl font-black text-gray-900 mb-2">Rp156.000</p>
                                <p class="text-blue-700 text-sm font-bold flex items-center">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    +8.2% dari bulan lalu
                                </p>
                            </div>
                            <div class="bg-blue-600 rounded-full p-4 shadow-xl">
                                <i class="fas fa-arrow-up text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Pengeluaran Bulan Ini -->
                    <div class="stat-card bg-white rounded-2xl shadow-2xl p-6 border-2 border-red-200 hover:border-red-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-red-700 text-sm font-bold uppercase tracking-wide mb-2">Pengeluaran</p>
                                <p class="text-3xl font-black text-gray-900 mb-2">Rp45.000</p>
                                <p class="text-red-700 text-sm font-bold flex items-center">
                                    <i class="fas fa-arrow-down mr-1"></i>
                                    -3.1% dari bulan lalu
                                </p>
                            </div>
                            <div class="bg-red-600 rounded-full p-4 shadow-xl">
                                <i class="fas fa-arrow-down text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Transaksi -->
                    <div class="stat-card bg-white rounded-2xl shadow-2xl p-6 border-2 border-purple-200 hover:border-purple-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-700 text-sm font-bold uppercase tracking-wide mb-2">Total Transaksi</p>
                                <p class="text-3xl font-black text-gray-900 mb-2">24</p>
                                <p class="text-purple-700 text-sm font-bold flex items-center">
                                    <i class="fas fa-plus mr-1"></i>
                                    +5 transaksi hari ini
                                </p>
                            </div>
                            <div class="bg-purple-600 rounded-full p-4 shadow-xl">
                                <i class="fas fa-exchange-alt text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Toggle Buttons --}}
                <div class="flex gap-4 mb-8">
                    <button 
                        @click="activeTab = 'pemasukan'" 
                        :class="activeTab === 'pemasukan' ? 'bg-green-600 text-black shadow-2xl scale-105 border-2 border-green-700' : 'bg-gray-100 text-gray-900 hover:bg-gray-200 border-2 border-gray-400'"
                        class="px-8 py-3 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg">
                        <i class="fas fa-arrow-up mr-2"></i>Pemasukan
                    </button>
                    <button 
                        @click="activeTab = 'pengeluaran'" 
                        :class="activeTab === 'pengeluaran' ? 'bg-red-600 text-white shadow-2xl scale-105 border-2 border-red-700' : 'bg-gray-100 text-gray-900 hover:bg-gray-200 border-2 border-gray-400'"
                        class="px-8 py-3 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg">
                        <i class="fas fa-arrow-down mr-2"></i>Pengeluaran
                    </button>
                </div>
                
                {{-- Charts Section --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Bar Chart -->
                    <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 border-gray-200">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-black text-gray-900 mb-2">Tren Pemasukan 7 Hari Terakhir</h3>
                                <p class="text-gray-700 font-medium">Analisis pemasukan harian</p>
                            </div>
                            <div class="flex items-center gap-3 bg-blue-100 px-4 py-2 rounded-full border border-blue-300">
                                <span class="w-4 h-4 bg-blue-600 rounded-full"></span>
                                <span class="text-sm font-bold text-blue-800">Pemasukan</span>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="barChart" width="400" height="200"></canvas>
                        </div>
                    </div>

                    <!-- Doughnut Chart -->
                    <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 border-gray-200">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-black text-gray-900 mb-2">Distribusi Kategori</h3>
                                <p class="text-gray-700 font-medium">Persentase berdasarkan jenis sampah</p>
                            </div>
                            <div class="flex items-center gap-3 bg-green-100 px-4 py-2 rounded-full border border-green-300">
                                <span class="w-4 h-4 bg-green-600 rounded-full"></span>
                                <span class="text-sm font-bold text-green-800">Kategori</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-center mb-4">
                            <div class="relative w-48 h-48">
                                <canvas id="doughnutChart" width="200" height="200"></canvas>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="flex items-center gap-3 p-3 bg-green-100 rounded-xl border border-green-300">
                                <div class="w-4 h-4 bg-green-600 rounded-full"></div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900">Organik</div>
                                    <div class="text-xs text-green-700 font-bold">70%</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-blue-100 rounded-xl border border-blue-300">
                                <div class="w-4 h-4 bg-blue-600 rounded-full"></div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900">Anorganik</div>
                                    <div class="text-xs text-blue-700 font-bold">20%</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-yellow-100 rounded-xl border border-yellow-300">
                                <div class="w-4 h-4 bg-yellow-600 rounded-full"></div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900">B3</div>
                                    <div class="text-xs text-yellow-700 font-bold">10%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Line Chart -->
                <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 border-gray-200 mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-black text-gray-900 mb-2">Tren Keuangan 30 Hari Terakhir</h3>
                            <p class="text-gray-700 font-medium">Analisis tren pemasukan vs pengeluaran</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-3 bg-green-100 px-4 py-2 rounded-full border border-green-300">
                                <span class="w-4 h-4 bg-green-600 rounded-full"></span>
                                <span class="text-sm font-bold text-green-800">Pemasukan</span>
                            </div>
                            <div class="flex items-center gap-3 bg-red-100 px-4 py-2 rounded-full border border-red-300">
                                <span class="w-4 h-4 bg-red-600 rounded-full"></span>
                                <span class="text-sm font-bold text-red-800">Pengeluaran</span>
                            </div>
                        </div>
                    </div>
                    <div class="h-64">
                        <canvas id="lineChart" width="400" height="200"></canvas>
                    </div>
                    <div class="flex justify-between mt-4 text-sm text-gray-700 font-bold">
                        <span>1 Mar</span>
                        <span>15 Mar</span>
                        <span>30 Mar</span>
                    </div>
                </div>
                
                                <!-- Tabel Riwayat -->
                <div class="bg-white rounded-2xl shadow-2xl p-8 border-2 border-gray-200">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <div class="text-gray-900 text-2xl font-black mb-2" x-text="activeTab === 'pemasukan' ? 'Pemasukan' : 'Pengeluaran'"></div>
                            <div class="text-gray-700 text-lg font-bold">Cek riwayat <span x-text="activeTab === 'pemasukan' ? 'pemasukan' : 'pengeluaran'"></span> Anda!</div>
                        </div>
                        <div class="flex items-center gap-3">
                            <button onclick="exportData()" class="bg-blue-600 text-black px-4 py-2 rounded-lg hover:bg-blue-700 transition-all duration-300 font-bold shadow-lg">
                                <i class="fas fa-download mr-2"></i>Export
                            </button>
                            <button onclick="showFilterModal()" class="bg-green-600 text-black px-4 py-2 rounded-lg hover:bg-green-700 transition-all duration-300 font-bold shadow-lg">
                                <i class="fas fa-filter mr-2"></i>Filter
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b-2 border-gray-300 bg-gray-50">
                                    <th class="px-4 py-3 text-left font-black text-lg text-gray-900">No. Invoice</th>
                                    <th class="px-4 py-3 text-left font-black text-lg text-gray-900">Tanggal</th>
                                    <th class="px-4 py-3 text-left font-black text-lg text-gray-900">Nama Pembeli</th>
                                    <th class="px-4 py-3 text-left font-black text-lg text-gray-900">Nama Produk</th>
                                    <th class="px-4 py-3 text-left font-black text-lg text-gray-900">Kategori</th>
                                    <th class="px-4 py-3 text-left font-black text-lg text-gray-900">Harga</th>
                                    <th class="px-4 py-3 text-left font-black text-lg text-gray-900">Status</th>
                                    <th class="px-4 py-3 text-left font-black text-lg text-gray-900">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < 8; $i++)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-all duration-300">
                                    <td class="px-4 py-3 font-bold text-gray-900">1#TEK12{{ $i+3 }}</td>
                                    <td class="px-4 py-3 font-bold text-gray-900">16/06/25</td>
                                    <td class="px-4 py-3 font-bold text-gray-900">{{ $i % 2 == 0 ? 'Wugis' : 'BS' }}</td>
                                    <td class="px-4 py-3 font-bold text-gray-900">{{ $i % 2 == 0 ? 'T#Tas Kreasi' : 'TopUp Coin' }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-2 rounded-full text-sm font-black {{ $i % 3 == 0 ? 'bg-green-100 text-green-800 border-2 border-green-300' : ($i % 3 == 1 ? 'bg-blue-100 text-blue-800 border-2 border-blue-300' : 'bg-yellow-100 text-yellow-800 border-2 border-yellow-300') }}">
                                            {{ $i % 3 == 0 ? 'Organik' : ($i % 3 == 1 ? 'Anorganik' : 'B3') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 font-black text-lg text-gray-900">Rp{{ number_format(20000 + ($i * 5000)) }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-2 rounded-full text-sm font-black bg-green-100 text-green-800 border-2 border-green-300">
                                            Selesai
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <button onclick="viewTransaction('{{ $i+3 }}')" class="text-blue-600 hover:text-blue-800 transition-all duration-300 hover:scale-110" title="Lihat Detail">
                                                <i class="fas fa-eye text-lg"></i>
                                            </button>
                                            <button onclick="downloadInvoice('{{ $i+3 }}')" class="text-green-600 hover:text-green-800 transition-all duration-300 hover:scale-110" title="Download Invoice">
                                                <i class="fas fa-download text-lg"></i>
                                            </button>
                                            <button onclick="showTransactionMenu('{{ $i+3 }}')" class="text-purple-600 hover:text-purple-800 transition-all duration-300 hover:scale-110" title="Menu">
                                                <i class="fas fa-ellipsis-v text-lg"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                    <div class="flex items-center justify-between mt-6">
                        <div class="text-gray-700 text-lg font-bold">
                            Menampilkan 1-8 dari 24 transaksi
                        </div>
                        <div class="flex items-center gap-3">
                            <button onclick="previousPage()" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-all duration-300 font-bold border-2 border-gray-300">
                                <i class="fas fa-chevron-left mr-2"></i>Sebelumnya
                            </button>
                            <span class="text-gray-900 px-4 py-2 font-black text-lg bg-blue-100 rounded-lg border-2 border-blue-300">1</span>
                            <button onclick="nextPage()" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-all duration-300 font-bold border-2 border-gray-300">
                                Selanjutnya<i class="fas fa-chevron-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
             </div>
         </div>
     </div>
 </div>

 <!-- Filter Modal -->
 <div id="filterModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
     <div class="flex items-center justify-center min-h-screen">
         <div class="bg-white rounded-lg p-6 w-96">
             <div class="flex items-center justify-between mb-4">
                 <h3 class="text-lg font-semibold">Filter Transaksi</h3>
                 <button onclick="hideFilterModal()" class="text-gray-500 hover:text-gray-700">
                     <i class="fas fa-times"></i>
                 </button>
             </div>
             <div class="space-y-4">
                 <div>
                     <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                     <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                     <select class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                         <option value="">Semua Kategori</option>
                         <option value="organik">Organik</option>
                         <option value="anorganik">Anorganik</option>
                         <option value="b3">B3</option>
                     </select>
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                     <select class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                         <option value="">Semua Status</option>
                         <option value="selesai">Selesai</option>
                         <option value="pending">Pending</option>
                         <option value="batal">Batal</option>
                     </select>
                 </div>
                 <div class="flex gap-2 pt-4">
                     <button onclick="applyFilter()" class="flex-1 bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">
                         Terapkan
                     </button>
                     <button onclick="resetFilter()" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400">
                         Reset
                     </button>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <!-- Transaction Detail Modal -->
 <div id="transactionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
     <div class="flex items-center justify-center min-h-screen">
         <div class="bg-white rounded-lg p-6 w-96">
             <div class="flex items-center justify-between mb-4">
                 <h3 class="text-lg font-semibold">Detail Transaksi</h3>
                 <button onclick="hideTransactionModal()" class="text-gray-500 hover:text-gray-700">
                     <i class="fas fa-times"></i>
                 </button>
             </div>
             <div id="transactionDetails" class="space-y-3">
                 <!-- Transaction details will be populated here -->
             </div>
         </div>
     </div>
 </div>

 <script>
 // Chart.js Charts
 document.addEventListener('DOMContentLoaded', function() {
     // Bar Chart - Pemasukan 7 Hari
     const barCtx = document.getElementById('barChart').getContext('2d');
     const barChart = new Chart(barCtx, {
         type: 'bar',
         data: {
             labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
             datasets: [{
                 label: 'Pemasukan',
                 data: [15000, 22000, 18000, 25000, 30000, 35000, 40000],
                 backgroundColor: 'rgba(59, 130, 246, 0.8)',
                 borderColor: 'rgba(59, 130, 246, 1)',
                 borderWidth: 1
             }]
         },
         options: {
             responsive: true,
             maintainAspectRatio: false,
             plugins: {
                 legend: {
                     display: false
                 }
             },
             scales: {
                 y: {
                     beginAtZero: true,
                     ticks: {
                         callback: function(value) {
                             return 'Rp' + value.toLocaleString();
                         }
                     }
                 }
             }
         }
     });

     // Doughnut Chart - Distribusi Kategori
     const doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
     const doughnutChart = new Chart(doughnutCtx, {
         type: 'doughnut',
         data: {
             labels: ['Organik', 'Anorganik', 'B3'],
             datasets: [{
                 data: [70, 20, 10],
                 backgroundColor: [
                     'rgba(16, 185, 129, 0.8)',
                     'rgba(59, 130, 246, 0.8)',
                     'rgba(245, 158, 11, 0.8)'
                 ],
                 borderColor: [
                     'rgba(16, 185, 129, 1)',
                     'rgba(59, 130, 246, 1)',
                     'rgba(245, 158, 11, 1)'
                 ],
                 borderWidth: 2
             }]
         },
         options: {
             responsive: true,
             maintainAspectRatio: false,
             plugins: {
                 legend: {
                     display: false
                 }
             }
         }
     });

     // Line Chart - Tren Keuangan 30 Hari
     const lineCtx = document.getElementById('lineChart').getContext('2d');
     const lineChart = new Chart(lineCtx, {
         type: 'line',
         data: {
             labels: Array.from({length: 30}, (_, i) => i + 1),
             datasets: [{
                 label: 'Pemasukan',
                 data: Array.from({length: 30}, () => Math.floor(Math.random() * 50000) + 10000),
                 borderColor: 'rgba(16, 185, 129, 1)',
                 backgroundColor: 'rgba(16, 185, 129, 0.1)',
                 tension: 0.4,
                 fill: true
             }, {
                 label: 'Pengeluaran',
                 data: Array.from({length: 30}, () => Math.floor(Math.random() * 20000) + 5000),
                 borderColor: 'rgba(239, 68, 68, 1)',
                 backgroundColor: 'rgba(239, 68, 68, 0.1)',
                 tension: 0.4,
                 fill: true
             }]
         },
         options: {
             responsive: true,
             maintainAspectRatio: false,
             plugins: {
                 legend: {
                     display: true,
                     position: 'top'
                 }
             },
             scales: {
                 y: {
                     beginAtZero: true,
                     ticks: {
                         callback: function(value) {
                             return 'Rp' + value.toLocaleString();
                         }
                     }
                 }
             }
         }
     });
 });

 // Function implementations
 function exportData() {
     alert('Mengunduh data keuangan...');
     // Implement actual export functionality
 }

 function showFilterModal() {
     document.getElementById('filterModal').classList.remove('hidden');
 }

 function hideFilterModal() {
     document.getElementById('filterModal').classList.add('hidden');
 }

 function applyFilter() {
     alert('Filter diterapkan!');
     hideFilterModal();
 }

 function resetFilter() {
     alert('Filter direset!');
     hideFilterModal();
 }

 function viewTransaction(id) {
     const details = {
         '3': { invoice: '1#TEK123', date: '16/06/25', buyer: 'Wugis', product: 'T#Tas Kreasi', amount: 'Rp20.000', status: 'Selesai' },
         '4': { invoice: '1#TEK124', date: '16/06/25', buyer: 'BS', product: 'TopUp Coin', amount: 'Rp25.000', status: 'Selesai' },
         '5': { invoice: '1#TEK125', date: '16/06/25', buyer: 'Wugis', product: 'T#Tas Kreasi', amount: 'Rp30.000', status: 'Selesai' },
         '6': { invoice: '1#TEK126', date: '16/06/25', buyer: 'BS', product: 'TopUp Coin', amount: 'Rp35.000', status: 'Selesai' },
         '7': { invoice: '1#TEK127', date: '16/06/25', buyer: 'Wugis', product: 'T#Tas Kreasi', amount: 'Rp40.000', status: 'Selesai' },
         '8': { invoice: '1#TEK128', date: '16/06/25', buyer: 'BS', product: 'TopUp Coin', amount: 'Rp45.000', status: 'Selesai' },
         '9': { invoice: '1#TEK129', date: '16/06/25', buyer: 'Wugis', product: 'T#Tas Kreasi', amount: 'Rp50.000', status: 'Selesai' },
         '10': { invoice: '1#TEK1210', date: '16/06/25', buyer: 'BS', product: 'TopUp Coin', amount: 'Rp55.000', status: 'Selesai' }
     };
     
     const transaction = details[id];
     if (transaction) {
         document.getElementById('transactionDetails').innerHTML = `
             <div><strong>No. Invoice:</strong> ${transaction.invoice}</div>
             <div><strong>Tanggal:</strong> ${transaction.date}</div>
             <div><strong>Pembeli:</strong> ${transaction.buyer}</div>
             <div><strong>Produk:</strong> ${transaction.product}</div>
             <div><strong>Jumlah:</strong> ${transaction.amount}</div>
             <div><strong>Status:</strong> <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">${transaction.status}</span></div>
         `;
         document.getElementById('transactionModal').classList.remove('hidden');
     }
 }

 function hideTransactionModal() {
     document.getElementById('transactionModal').classList.add('hidden');
 }

 function downloadInvoice(id) {
     alert(`Mengunduh invoice ${id}...`);
     // Implement actual download functionality
 }

 function showTransactionMenu(id) {
     alert(`Menu untuk transaksi ${id}`);
     // Implement dropdown menu functionality
 }

 function previousPage() {
     alert('Halaman sebelumnya');
     // Implement pagination
 }

 function nextPage() {
     alert('Halaman berikutnya');
     // Implement pagination
 }
 </script>
 @endsection 