<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Penjualan Sampah - Bijak Sampah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-firestore.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>
    <script>
        window.addEventListener('load', function() {
            console.log('Window loaded, Chart.js available:', typeof Chart !== 'undefined');
        });
    </script>
    <style>
        :root {
            --primary-color: #05445E;
            --secondary-color: #75E6DA;
            --accent-color: #f16728;
            --success-color: #2b8a3e;
            --danger-color: #c0392b;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        /* Custom CSS untuk efek gradasi sidebar */
    .sidebar-banksampah-gradient {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 30%, #05445E 100%);
    }
        
        /* Ensure seamless connection between topbar and sidebar */
        .topbar-sidebar-seamless {
            background: linear-gradient(135deg, #75E6DA 0%, #05445E 30%, #05445E 100%);
            border: none;
            box-shadow: none;
        }

    /* Style untuk area main content */
    .main-content {
        padding-top: 64px; /* Menyesuaikan dengan tinggi top bar */
        min-height: 100vh;
    }

        /* Chart Container */
        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
            min-height: 300px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px;
            background: white;
        }
        
        #trendChart, #compositionChart {
            width: 100% !important;
            height: 100% !important;
            min-height: 300px;
            display: block !important;
        }

        /* Custom Card Styles */
        .custom-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .custom-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px rgba(0,0,0,0.1);
        }

        /* Badge Styles */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-primary {
            background-color: #e1f0fa;
            color: var(--primary-color);
        }

        .badge-success {
            background-color: #e6f7ed;
            color: var(--success-color);
        }

        .badge-warning {
            background-color: #fff4e6;
            color: #f97316;
        }

        /* Table Styles */
        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .data-table thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            padding: 12px 16px;
            border-bottom: 1px solid #e2e8f0;
        }

        .data-table tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        .data-table tbody tr:hover td {
            background-color: #f8fafc;
        }

        /* Animation */
        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(10px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        /* Product card animation */
        .product-card {
            opacity: 0;
            animation: fadeIn 0.3s ease-out forwards;
            transition: all 0.3s ease;
        }

        /* New listing highlight */
        .product-card.new-listing {
            border: 2px solid #10b981 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
        }

        /* Updated listing highlight */
        .product-card.updated-listing {
            border: 2px solid #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
            animation: pulse 1s ease-in-out;
        }

        /* Pulse animation for updated listings */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }

        /* Smooth transitions for all interactive elements */
        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        /* Tooltip */
        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltip-text {
            visibility: hidden;
            width: 120px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 12px;
        }

        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }
    
    /* Styling tambahan dari file asli penjualansampah-banksampah */
    .product-card {
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .status-badge {
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 12px;
    }
    .status-pending { background-color: #fef3c7; color: #d97706; }
    .status-processing { background-color: #dbeafe; color: #1d4ed8; }
    .status-shipped { background-color: #e0f2fe; color: #0369a1; }
    .status-completed { background-color: #dcfce7; color: #166534; }
    .status-cancelled { background-color: #fee2e2; color: #b91c1c; }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            width: 90%;
            max-width: 600px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            animation: modalFadeIn 0.3s;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-header {
            padding: 15px 20px;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            font-size: 18px;
            font-weight: 600;
        }

        .modal-close {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }

        .modal-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #555;
        }

        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background-color: #f9f9f9;
        }

        .modal-footer {
            padding: 15px 20px;
            background-color: #f5f5f5;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-secondary {
            background-color: #e5e7eb;
            color: #333;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #d1d5db;
        }

        .btn-success {
            background-color: var(--success-color);
            color: white;
            border: none;
        }

        .btn-success:hover {
            background-color: #247532;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #04384e;
        }

        /* Tab Styles */
        .tab-button {
            padding: 8px 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            border-bottom: 2px solid transparent;
        }

        .tab-button.active {
            color: #3b82f6;
            border-bottom-color: #3b82f6;
        }

        .tab-button:hover {
            color: #3b82f6;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Ensure marketplace content is always visible by default */
        #marketplaceContent {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* Smooth scrolling for the entire page */
        html {
            scroll-behavior: smooth;
        }

        /* Tab content transition */
        .tab-content {
            transition: opacity 0.3s ease-in-out;
        }

        /* Visual feedback for active tab content */
        .tab-content.active {
            opacity: 1;
        }

        /* Ensure seamless connection between topbar and sidebar */
        .topbar-sidebar-seamless {
            background: linear-gradient(135deg, #75E6DA 0%, #05445E 30%, #05445E 100%);
            border: none;
            box-shadow: none;
        }
</style>
</head>
<body class="bg-gray-50">

<div class="flex min-h-screen bg-gray-50" x-data="{ sidebarOpen: false, activeMenu: 'penjualansampah' }" x-init="activeMenu = 'penjualansampah'">

    {{-- Sidebar --}}
    <aside 
        class="fixed top-0 left-0 z-40 flex flex-col py-6 overflow-hidden shadow-2xl group sidebar-banksampah-gradient text-white"
        :class="sidebarOpen ? 'w-[250px]' : 'w-16'"
        style="transition: width 0.3s ease; height: 100vh; background: linear-gradient(135deg, #75E6DA 0%, #05445E 30%, #05445E 100%);"
    >
        <div class="relative flex flex-col h-full w-full px-4">
            
            {{-- Logo Section with Toggle Button --}}
            {{-- PASTIKAN FILE logo-icon.png ADA DI public/asset/img --}}
            <div class="flex items-center justify-center mb-8 mt-14" :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                <div class="flex items-center justify-center gap-2" :class="sidebarOpen ? 'flex-1' : ''">
                    <img x-show="sidebarOpen" class="w-32 h-auto" src="{{ asset('asset/img/logo1.png') }}" alt="Logo Penuh">
                    <img x-show="!sidebarOpen" class="w-6 h-6" src="{{ asset('asset/img/logo.png') }}" alt="Logo Kecil">
                    {{-- Toggle Button --}}
                    <button 
                        @click="sidebarOpen = !sidebarOpen"
                        class="p-1 rounded-full bg-white/20 hover:bg-white/30 transition-colors duration-200 text-white"
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
                    href="{{ route('dashboard-banksampah') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center; padding-left: 0; padding-right: 0;'"
                    @click="activeMenu = 'dashboard'"
                >
                    <i class="fas fa-home text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Dashboard</span>
                </a>

                <div 
                    class="group"
                    x-data="{ expanded: false }"
                    x-init="$watch('sidebarOpen', value => { if (!value) expanded = false })"
                >
                    <button 
                        @click="expanded = !expanded" 
                        class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                        :style="sidebarOpen ? 'justify-between; gap: 12px;' : 'justify-content: center;'"
                    >
                        <div class="flex items-center" :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'">
                            <i class="fas fa-users text-lg"></i>
                            <span x-show="sidebarOpen" class="text-sm font-medium">Nasabah</span>
                        </div>
                        <i x-show="sidebarOpen" class="fas fa-chevron-down text-xs opacity-70 transition-transform duration-200" :class="expanded ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="expanded && sidebarOpen" x-collapse.duration.300ms class="pl-6 pt-2 space-y-1">
                        <a 
                            href="{{ route('verifikasi-nasabah-banksampah') }}" 
                            class="flex items-center gap-3 p-2 rounded-lg whitespace-nowrap w-full text-sm hover:bg-white/10 hover:shadow-sm transition-colors duration-200"
                            @click="activeMenu = 'verifikasi-nasabah'"
                        >
                            <i class="fas fa-user-check"></i>
                            <span x-show="sidebarOpen">Verifikasi Nasabah</span>
                        </a>
                        <a 
                            href="{{ route('data-nasabah-banksampah') }}" 
                            class="flex items-center gap-3 p-2 rounded-lg whitespace-nowrap w-full text-sm hover:bg-white/10 hover:shadow-sm transition-colors duration-200"
                            @click="activeMenu = 'data-nasabah'"
                        >
                            <i class="fas fa-database"></i>
                            <span x-show="sidebarOpen">Data Nasabah</span>
                        </a>
                    </div>
                </div>

                <a 
                    href="{{ route('penjemputan-sampah-banksampah') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'penjemputan-sampah'"
                >
                    <i class="fas fa-truck text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Penjemputan Sampah</span>
                </a>
                
                <div 
                    class="group"
                    x-data="{ expanded: false }"
                    x-init="$watch('sidebarOpen', value => { if (!value) expanded = false })"
                >
                    <button 
                        @click="expanded = !expanded" 
                        class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                        :style="sidebarOpen ? 'justify-between; gap: 12px;' : 'justify-content: center;'"
                    >
                        <div class="flex items-center" :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'">
                            <i class="fas fa-weight-hanging text-lg"></i>
                            <span x-show="sidebarOpen" class="text-sm font-medium">Penimbangan</span>
                        </div>
                        <i x-show="sidebarOpen" class="fas fa-chevron-down text-xs opacity-70 transition-transform duration-200" :class="expanded ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="expanded && sidebarOpen" x-collapse.duration.300ms class="pl-6 pt-2 space-y-1">
                        <a 
                            href="{{ route('input-setoran') }}" 
                            class="flex items-center gap-3 p-2 rounded-lg whitespace-nowrap w-full text-sm hover:bg-white/10 hover:shadow-sm transition-colors duration-200"
                            @click="activeMenu = 'input-setoran'"
                        >
                            <i class="fas fa-plus-circle"></i>
                            <span x-show="sidebarOpen">Input Setoran</span>
                        </a>
                    </div>
                </div>

                <a 
                    href="{{ route('datasampah-banksampah') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'data-sampah'"
                >
                    <i class="fas fa-trash-alt text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Data Sampah</span>
                </a>
                
                <a 
                    href="{{ route('penjualansampah-banksampah') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 bg-white/20 shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'penjualansampah'"
                >
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Penjualan Sampah</span>
                </a>
                
                <a 
                    href="{{ route('settingsbank') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'pengaturan'"
                >
                    <i class="fas fa-cog text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Pengaturan</span>
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

    {{-- Main Content --}}
    <div class="main-content" :class="sidebarOpen ? 'pl-24' : 'pl-24'" style="transition: padding-left 0.3s ease;">
        {{-- Top Header Bar --}}
        <div class="fixed top-0 left-0 right-0 h-12 z-40 flex items-center justify-between px-6 text-white" :style="'padding-left:' + (sidebarOpen ? '16rem' : '4rem') + '; background: linear-gradient(135deg, #75E6DA 0%, #05445E 30%, #05445E 100%);'">
            <h1 class="text-white font-semibold text-lg" style="position: absolute; left: 1.5rem;">BijakSampah</h1>
            <div class="flex items-center gap-4" style="position: absolute; right: 1.5rem;">
                <a href="{{ route('notifikasibank') }}" class="relative">
                    <i class="far fa-bell text-white text-sm"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-medium">3</span>
                </a>
                <button class="focus:outline-none">
                    <i class="fas fa-search text-white text-sm"></i>
                </button>
                <div class="flex items-center gap-2">
                    <a href="{{ route('profilebank') }}" class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center border-2 border-gray-300">
                        <img src="{{ asset('asset/img/user_profile.jpg') }}" alt="Profile" class="w-full h-full object-cover">
                    </a>
                    <i class="fas fa-chevron-down text-white text-xs"></i>
                </div>
            </div>
            </div>

        <div class="p-6" style="padding-top: 20px;">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Marketplace Sampah</h1>
                    <p class="text-sm text-gray-500">Jual sampah Anda ke UMKM daur ulang dan pengepul terdekat</p>
                </div>
            </div>

            <div class="flex border-b border-gray-200 mb-6">
                <button class="tab-button active px-4 py-2 font-medium text-blue-600 border-b-2 border-blue-600" onclick="switchTab('marketplace')">
                    <i class="fas fa-store mr-2"></i>Marketplace
                </button>
                <button class="tab-button px-4 py-2 font-medium text-gray-500 hover:text-blue-600" onclick="switchTab('mySales')">
                    <i class="fas fa-clipboard-list mr-2"></i>Penjualan Saya
                </button>
                <button class="tab-button px-4 py-2 font-medium text-gray-500 hover:text-blue-600" onclick="switchTab('transactions')">
                    <i class="fas fa-exchange-alt mr-2"></i>Transaksi
                </button>
            </div>

            <div id="marketplaceContent" class="space-y-6" style="display: block !important;">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Buat Penawaran Baru</h3>
                            <p class="text-sm text-gray-500">Jual sampah Anda ke UMKM daur ulang dan pengepul</p>
                        </div>
                        <button class="w-full md:w-auto px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg font-medium hover:from-blue-700 hover:to-blue-900 transition-all" onclick="showCreateListingModal()">
                            <i class="fas fa-plus mr-2"></i>Buat Penawaran
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">List Penawaran Saya</h3>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm hover:bg-blue-100 transition-colors" onclick="exportMarketplaceData()">
                                <i class="fas fa-download mr-1"></i> Export
                            </button>
                            <button class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm hover:bg-blue-100 transition-colors" onclick="showFilterModal()">
                                <i class="fas fa-filter mr-1"></i> Filter
                                <span id="filterIndicator" class="ml-1 hidden">●</span>
                            </button>
                            <button class="px-3 py-1 bg-gray-50 text-gray-600 rounded-full text-sm hover:bg-gray-100 transition-colors" onclick="showSortModal()">
                                <i class="fas fa-sort mr-1"></i> Urutkan
                                <span id="sortIndicator" class="ml-1 hidden">●</span>
                            </button>
                        </div>
                    </div>
                    <div id="myListingsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Penawaran akan ditampilkan di sini -->
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-box-open text-4xl mb-4"></i>
                            <p>Belum ada penawaran yang dibuat</p>
                            <p class="text-sm">Klik "Buat Penawaran" untuk mulai menjual sampah Anda</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Content untuk Penjualan Saya -->
            <div id="mySalesContent" class="space-y-6" style="display: none;">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Ringkasan Penjualan</h3>
                            <p class="text-sm text-gray-500">Statistik penjualan sampah Anda</p>
                        </div>
                        <div class="flex space-x-2">
                            <select id="salesPeriod" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <option value="7">7 Hari Terakhir</option>
                                <option value="30">30 Hari Terakhir</option>
                                <option value="90">90 Hari Terakhir</option>
                                <option value="365">1 Tahun</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-blue-600 font-medium">Total Penjualan</p>
                                    <p class="text-2xl font-bold text-blue-800">Rp 2.450.000</p>
                                </div>
                                <i class="fas fa-chart-line text-blue-500 text-xl"></i>
                            </div>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-green-600 font-medium">Berat Terjual</p>
                                    <p class="text-2xl font-bold text-green-800">1.250 kg</p>
                                </div>
                                <i class="fas fa-weight-hanging text-green-500 text-xl"></i>
                            </div>
                        </div>
                        <div class="bg-yellow-50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-yellow-600 font-medium">Transaksi</p>
                                    <p class="text-2xl font-bold text-yellow-800">45</p>
                                </div>
                                <i class="fas fa-receipt text-yellow-500 text-xl"></i>
                            </div>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-purple-600 font-medium">Rating</p>
                                    <p class="text-2xl font-bold text-purple-800">4.8/5</p>
                                </div>
                                <i class="fas fa-star text-purple-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Riwayat Penjualan</h3>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm hover:bg-blue-100 transition-colors" onclick="exportSalesData()">
                                <i class="fas fa-download mr-1"></i> Export
                            </button>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full data-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Produk</th>
                                    <th>Pembeli</th>
                                    <th>Berat</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="salesHistoryTable">
                                <!-- Data riwayat penjualan akan ditampilkan di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tab Content untuk Transaksi -->
            <div id="transactionsContent" class="space-y-6" style="display: none;">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Status Transaksi</h3>
                            <p class="text-sm text-gray-500">Monitor semua transaksi Anda</p>
                        </div>
                        <div class="flex space-x-2">
                            <select id="transactionStatus" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <option value="">Semua Status</option>
                                <option value="pending">Menunggu Pembayaran</option>
                                <option value="paid">Sudah Dibayar</option>
                                <option value="shipped">Dikirim</option>
                                <option value="delivered">Diterima</option>
                                <option value="cancelled">Dibatalkan</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-orange-50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-orange-600 font-medium">Menunggu Pembayaran</p>
                                    <p class="text-2xl font-bold text-orange-800">3</p>
                                </div>
                                <i class="fas fa-clock text-orange-500 text-xl"></i>
                            </div>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-blue-600 font-medium">Dalam Proses</p>
                                    <p class="text-2xl font-bold text-blue-800">7</p>
                                </div>
                                <i class="fas fa-truck text-blue-500 text-xl"></i>
                            </div>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-green-600 font-medium">Selesai</p>
                                    <p class="text-2xl font-bold text-green-800">28</p>
                                </div>
                                <i class="fas fa-check-circle text-green-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Daftar Transaksi</h3>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm hover:bg-blue-100 transition-colors" onclick="exportTransactionData()">
                                <i class="fas fa-download mr-1"></i> Export
                            </button>
                            <button class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm hover:bg-blue-100 transition-colors" onclick="refreshTransactions()">
                                <i class="fas fa-sync-alt mr-1"></i> Refresh
                            </button>
                        </div>
                    </div>
                    
                    <div class="space-y-4" id="transactionsList">
                        <!-- Daftar transaksi akan ditampilkan di sini -->
                    </div>
                </div>

                <!-- Section Data Penjualan Sampah Tersimpan -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Data Penjualan Sampah Tersimpan</h3>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 bg-green-50 text-green-600 rounded-full text-sm hover:bg-green-100 transition-colors" onclick="displayStoredWasteSales()">
                                <i class="fas fa-sync-alt mr-1"></i> Refresh
                            </button>
                            <button class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm hover:bg-blue-100 transition-colors" onclick="exportWasteSalesData()">
                                <i class="fas fa-download mr-1"></i> Export
                            </button>
                            <button class="px-3 py-1 bg-red-50 text-red-600 rounded-full text-sm hover:bg-red-100 transition-colors" onclick="clearWasteSalesData()">
                                <i class="fas fa-trash mr-1"></i> Clear All
                            </button>
                        </div>
                    </div>
                    
                    <div id="storedWasteSalesContainer">
                        <!-- Data penjualan sampah akan ditampilkan di sini -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Listing Modal -->
<div class="modal" id="createListingModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Buat Penawaran Baru</h3>
            <button class="modal-close" onclick="closeModal('createListingModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="createListingForm">
                <div class="form-group">
                    <label>Jenis Sampah</label>
                    <select id="wasteType" required>
                        <option value="">Pilih jenis sampah</option>
                        <option value="plastik">Plastik</option>
                        <option value="kertas">Kertas</option>
                        <option value="logam">Logam</option>
                        <option value="elektronik">Elektronik</option>
                        <option value="organik">Organik</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Judul Penawaran</label>
                    <input type="text" id="listingTitle" placeholder="Contoh: Plastik PET Bersih" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea id="listingDescription" placeholder="Jelaskan detail sampah Anda..." required></textarea>
                </div>
                <div class="form-group">
                    <label>Harga per Kg</label>
                    <input type="number" id="listingPrice" placeholder="5000" required>
                </div>
                <div class="form-group">
                    <label>Stok (Kg)</label>
                    <input type="number" id="listingStock" placeholder="100" required>
                </div>
                <div class="form-group">
                    <label>Lokasi</label>
                    <input type="text" id="listingLocation" placeholder="Jakarta Selatan" required>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('createListingModal')">Batal</button>
            <button class="btn btn-success" onclick="submitCreateListing()">Buat Penawaran</button>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal" id="filterModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Filter Sampah</h3>
            <button class="modal-close" onclick="closeModal('filterModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Jenis Sampah</label>
                <select id="filterWasteType">
                    <option value="">Semua Jenis</option>
                    <option value="plastik">Plastik</option>
                    <option value="kertas">Kertas</option>
                    <option value="logam">Logam</option>
                    <option value="elektronik">Elektronik</option>
                    <option value="organik">Organik</option>
                </select>
            </div>
            <div class="form-group">
                <label>Rentang Harga</label>
                <div class="flex gap-2">
                    <input type="number" id="minPrice" placeholder="Min" class="flex-1">
                    <span class="self-center">-</span>
                    <input type="number" id="maxPrice" placeholder="Max" class="flex-1">
                </div>
            </div>
            <div class="form-group">
                <label>Lokasi</label>
                <input type="text" id="filterLocation" placeholder="Masukkan lokasi">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="resetFilter()">Reset Filter</button>
            <button class="btn btn-secondary" onclick="closeModal('filterModal')">Batal</button>
            <button class="btn btn-primary" onclick="applyFilter()">Terapkan Filter</button>
        </div>
    </div>
</div>

<!-- Sort Modal -->
<div class="modal" id="sortModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Urutkan Sampah</h3>
            <button class="modal-close" onclick="closeModal('sortModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Urutkan Berdasarkan</label>
                <select id="sortBy">
                    <option value="price-low">Harga: Rendah ke Tinggi</option>
                    <option value="price-high">Harga: Tinggi ke Rendah</option>
                    <option value="date-new">Tanggal: Terbaru</option>
                    <option value="date-old">Tanggal: Terlama</option>
                    <option value="stock-high">Stok: Terbanyak</option>
                    <option value="stock-low">Stok: Tersedikit</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="resetSort()">Reset Urutan</button>
            <button class="btn btn-secondary" onclick="closeModal('sortModal')">Batal</button>
            <button class="btn btn-primary" onclick="applySort()">Terapkan Urutan</button>
        </div>
    </div>
</div>

<!-- Buy Modal -->
<div class="modal" id="buyModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Beli Sampah</h3>
            <button class="modal-close" onclick="closeModal('buyModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Produk</label>
                <input type="text" id="buyProductName" readonly>
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="text" id="buyPrice" readonly>
            </div>
            <div class="form-group">
                <label>Stok Tersedia</label>
                <input type="text" id="buyStock" readonly>
            </div>
            <div class="form-group">
                <label>Jumlah yang Dibeli (Kg)</label>
                <input type="number" id="buyQuantity" placeholder="Masukkan jumlah" min="1" required>
            </div>
            <div class="form-group">
                <label>Alamat Pengiriman</label>
                <textarea id="buyAddress" placeholder="Masukkan alamat lengkap" required></textarea>
            </div>
            <div class="form-group">
                <label>Catatan</label>
                <textarea id="buyNotes" placeholder="Catatan tambahan (opsional)"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('buyModal')">Batal</button>
            <button class="btn btn-success" onclick="submitBuy()">Beli Sekarang</button>
        </div>
    </div>
</div>

<!-- Product Detail Modal -->
<div class="modal" id="productDetailModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Detail Produk</h3>
            <button class="modal-close" onclick="closeModal('productDetailModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" id="detailProductName" readonly>
            </div>
            <div class="form-group">
                <label>Penjual</label>
                <input type="text" id="detailSeller" readonly>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea id="detailDescription" readonly></textarea>
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="text" id="detailPrice" readonly>
            </div>
            <div class="form-group">
                <label>Stok</label>
                <input type="text" id="detailStock" readonly>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('productDetailModal')">Tutup</button>
            <button class="btn btn-primary" onclick="showBuyModalFromDetail()">Beli Sekarang</button>
        </div>
    </div>
</div>

<script>
    // Global variables untuk menyimpan data penawaran
    let allListings = [];
    let filteredListings = [];
    let currentFilters = {
        wasteType: '',
        minPrice: '',
        maxPrice: '',
        location: ''
    };
    let currentSort = '';

    // Data contoh untuk penjualan dan transaksi
    let salesData = [
        {
            id: 1,
            date: '2024-01-15',
            product: 'Plastik PET Bersih',
            buyer: 'PT Daur Ulang Hijau',
            weight: 50,
            price: 7500,
            total: 375000,
            status: 'delivered'
        },
        {
            id: 2,
            date: '2024-01-14',
            product: 'Kertas Koran Bekas',
            buyer: 'CV Kertas Mandiri',
            weight: 100,
            price: 3000,
            total: 300000,
            status: 'shipped'
        },
        {
            id: 3,
            date: '2024-01-13',
            product: 'Logam Aluminium',
            buyer: 'PT Logam Bersih',
            weight: 25,
            price: 12000,
            total: 300000,
            status: 'paid'
        },
        {
            id: 4,
            date: '2024-01-12',
            product: 'Elektronik Bekas',
            buyer: 'CV Elektronik Daur Ulang',
            weight: 15,
            price: 25000,
            total: 375000,
            status: 'pending'
        }
    ];

    let transactionsData = [
        {
            id: 'TRX-001',
            date: '2024-01-15',
            product: 'Plastik PET Bersih',
            buyer: 'PT Daur Ulang Hijau',
            amount: 375000,
            status: 'delivered',
            paymentMethod: 'Transfer Bank'
        },
        {
            id: 'TRX-002',
            date: '2024-01-14',
            product: 'Kertas Koran Bekas',
            buyer: 'CV Kertas Mandiri',
            amount: 300000,
            status: 'shipped',
            paymentMethod: 'E-Wallet'
        },
        {
            id: 'TRX-003',
            date: '2024-01-13',
            product: 'Logam Aluminium',
            buyer: 'PT Logam Bersih',
            amount: 300000,
            status: 'paid',
            paymentMethod: 'Transfer Bank'
        },
        {
            id: 'TRX-004',
            date: '2024-01-12',
            product: 'Elektronik Bekas',
            buyer: 'CV Elektronik Daur Ulang',
            amount: 375000,
            status: 'pending',
            paymentMethod: 'COD'
        }
    ];

    // Tab switching functionality
    function switchTab(tabName) {
        // Remove active class from all tabs
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active', 'text-blue-600', 'border-blue-600');
            btn.classList.add('text-gray-500');
        });
        
        // Add active class to clicked tab
        event.target.classList.add('active', 'text-blue-600', 'border-blue-600');
        event.target.classList.remove('text-gray-500');
        
        // Add visual feedback
        highlightActiveTab(tabName);
        
        // Hide all content
        document.getElementById('marketplaceContent').style.display = 'none';
        document.getElementById('mySalesContent').style.display = 'none';
        document.getElementById('transactionsContent').style.display = 'none';
        
        // Show selected content and scroll to it
        if (tabName === 'marketplace') {
            showMarketplaceContent();
            scrollToMarketplace();
        } else if (tabName === 'mySales') {
            document.getElementById('marketplaceContent').style.display = 'none';
            document.getElementById('mySalesContent').style.display = 'block';
            document.getElementById('transactionsContent').style.display = 'none';
            loadSalesData(); // Reload sales data when tab is opened
            scrollToMySales();
        } else if (tabName === 'transactions') {
            document.getElementById('marketplaceContent').style.display = 'none';
            document.getElementById('mySalesContent').style.display = 'none';
            document.getElementById('transactionsContent').style.display = 'block';
            loadTransactionsData(); // Reload transactions data when tab is opened
            scrollToTransactions();
        }
    }

    // Function untuk scroll ke konten yang dipilih
    function scrollToContent(contentId) {
        const contentElement = document.getElementById(contentId);
        if (contentElement) {
            // Delay kecil untuk memastikan konten sudah ter-render
            setTimeout(() => {
                // Scroll dengan offset untuk memberikan ruang di atas
                const offset = 120; // Offset dalam pixel
                const elementPosition = contentElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - offset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
                
                console.log(`Scrolled to ${contentId} at position ${offsetPosition}`);
            }, 150); // Delay 150ms untuk memastikan konten sudah ter-render
        }
    }

    // Function untuk scroll ke marketplace dengan animasi khusus
    function scrollToMarketplace() {
        const marketplaceContent = document.getElementById('marketplaceContent');
        if (marketplaceContent) {
            setTimeout(() => {
                marketplaceContent.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start' 
                });
            }, 100);
        }
    }

    // Function untuk scroll ke penjualan saya dengan animasi khusus
    function scrollToMySales() {
        const mySalesContent = document.getElementById('mySalesContent');
        if (mySalesContent) {
            setTimeout(() => {
                mySalesContent.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start' 
                });
            }, 200); // Delay lebih lama untuk memastikan data sudah ter-load
        }
    }

    // Function untuk scroll ke transaksi dengan animasi khusus
    function scrollToTransactions() {
        const transactionsContent = document.getElementById('transactionsContent');
        if (transactionsContent) {
            setTimeout(() => {
                transactionsContent.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start' 
                });
            }, 200); // Delay lebih lama untuk memastikan data sudah ter-load
        }
    }

    // Function untuk memberikan feedback visual saat tab dipilih
    function highlightActiveTab(tabName) {
        // Remove highlight from all tabs
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.style.transform = 'scale(1)';
            btn.style.transition = 'transform 0.2s ease';
        });
        
        // Add highlight to active tab
        const activeTab = event.target;
        if (activeTab) {
            activeTab.style.transform = 'scale(1.05)';
            setTimeout(() => {
                activeTab.style.transform = 'scale(1)';
            }, 200);
        }
    }

    // Show Create Listing Modal
    function showCreateListingModal() {
        document.getElementById('createListingModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    // Show Filter Modal
    function showFilterModal() {
        document.getElementById('filterModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    // Show Sort Modal
    function showSortModal() {
        document.getElementById('sortModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    // Show Buy Modal
    function showBuyModal(productName, price, stock) {
        document.getElementById('buyProductName').value = productName;
        document.getElementById('buyPrice').value = price;
        document.getElementById('buyStock').value = stock;
        document.getElementById('buyModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    // Show Product Detail Modal
    function showProductDetail() {
        document.getElementById('detailProductName').value = 'Plastik PET Bersih';
        document.getElementById('detailSeller').value = 'Bank Sampah Hijau';
        document.getElementById('detailDescription').value = 'Plastik PET bersih, sudah dicuci dan dikeringkan, siap untuk didaur ulang.';
        document.getElementById('detailPrice').value = 'Rp 7.500/kg';
        document.getElementById('detailStock').value = '150 kg';
        document.getElementById('productDetailModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    // Close Modal
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Toggle Favorite
    function toggleFavorite(element) {
        if (element.classList.contains('text-red-500')) {
            element.classList.remove('text-red-500');
            element.classList.add('text-gray-400');
            alert('Dihapus dari favorit!');
        } else {
            element.classList.remove('text-gray-400');
            element.classList.add('text-red-500');
            alert('Ditambahkan ke favorit!');
        }
    }

    // Submit Create Listing
    function submitCreateListing() {
        const wasteType = document.getElementById('wasteType').value;
        const title = document.getElementById('listingTitle').value;
        const description = document.getElementById('listingDescription').value;
        const price = document.getElementById('listingPrice').value;
        const stock = document.getElementById('listingStock').value;
        const location = document.getElementById('listingLocation').value;

        if (!wasteType || !title || !description || !price || !stock || !location) {
            alert('Harap isi semua field yang wajib!');
            return;
        }

        // Tutup modal terlebih dahulu
        closeModal('createListingModal');
        
        // Reset form
        document.getElementById('createListingForm').reset();
        
        // Tambah penawaran ke list
        addListingToContainer(title, description, price, stock, location, wasteType);
        
        // SIMPAN DATA PENJUALAN SAMPAH KE STORAGE
        saveWasteSaleData(wasteType, title, description, price, stock, location);
        
        // Tampilkan pesan sukses setelah data ditambahkan
        setTimeout(() => {
            alert('Penawaran berhasil dibuat dan data tersimpan!');
            // Scroll ke list penawaran untuk feedback visual
            scrollToListings();
        }, 100);
    }

    // Function untuk menyimpan data penjualan sampah
    function saveWasteSaleData(wasteType, title, description, price, stock, location) {
        // Generate Invoice ID unik
        const invoiceId = 'TEK' + Date.now();
        
        // Buat objek data penjualan
        const saleData = {
            id: invoiceId,
            nasabah: 'Nasabah Bijak Sampah', // Bisa diambil dari session/login
            jenisSampah: wasteType,
            judulPenawaran: title,
            deskripsi: description,
            hargaPerKg: parseInt(price),
            berat: parseInt(stock),
            totalHarga: parseInt(price) * parseInt(stock),
            lokasi: location,
            tanggal: new Date().toISOString(),
            status: 'Baru',
            isNew: true
        };
        
        // Ambil data existing dari localStorage
        let existingSales = JSON.parse(localStorage.getItem('wasteSalesData') || '[]');
        
        // Tambah data baru
        existingSales.push(saleData);
        
        // Simpan kembali ke localStorage
        localStorage.setItem('wasteSalesData', JSON.stringify(existingSales));
        
        // Trigger event untuk sync dengan halaman lain
        window.dispatchEvent(new CustomEvent('wasteSaleAdded', { detail: saleData }));
        
        // Tambahan: Trigger storage event untuk sinkronisasi antar tab
        window.dispatchEvent(new StorageEvent('storage', {
            key: 'wasteSalesData',
            newValue: JSON.stringify(existingSales),
            oldValue: JSON.stringify(existingSales.slice(0, -1))
        }));
        
        console.log('Data penjualan sampah tersimpan:', saleData);
        console.log('Total data tersimpan:', existingSales.length);
        console.log('Event wasteSaleAdded dan storage event telah dikirim');
    }

    // Function untuk scroll ke list penawaran
    function scrollToListings() {
        const listingsContainer = document.getElementById('myListingsContainer');
        if (listingsContainer) {
            listingsContainer.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }
    }

    // Function untuk menambah penawaran ke container
    function addListingToContainer(title, description, price, stock, location, wasteType) {
        // Buat objek penawaran baru
        const newListing = {
            id: Date.now(), // ID unik berdasarkan timestamp
            title: title,
            description: description,
            price: parseInt(price),
            stock: parseInt(stock),
            location: location,
            wasteType: wasteType,
            status: 'Aktif',
            createdAt: new Date(),
            isNew: true // Flag untuk menandai penawaran baru
        };
        
        // Tambahkan ke array global
        allListings.push(newListing);
        
        // Clear filtered listings to show all data including new one
        filteredListings = [];
        
        // Render ulang dengan filter dan sort yang aktif
        renderListings();
        
        // Highlight penawaran baru
        setTimeout(() => {
            highlightNewListing(newListing.id);
        }, 300);
        
        console.log('New listing added:', newListing);
        console.log('Total listings now:', allListings.length);
    }

    // Function untuk highlight penawaran baru
    function highlightNewListing(listingId) {
        const listingCard = document.querySelector(`[data-listing-id="${listingId}"]`);
        if (listingCard) {
            listingCard.classList.add('new-listing');
            
            // Remove highlight after 3 seconds
            setTimeout(() => {
                listingCard.classList.remove('new-listing');
            }, 3000);
        }
    }

    // Function untuk highlight penawaran yang baru diupdate
    function highlightUpdatedListing(listingId) {
        const listingCard = document.querySelector(`[data-listing-id="${listingId}"]`);
        if (listingCard) {
            listingCard.classList.add('updated-listing');
            
            // Remove highlight after 3 seconds
            setTimeout(() => {
                listingCard.classList.remove('updated-listing');
            }, 3000);
        }
    }

    // Function untuk render semua penawaran
    function renderListings() {
        const container = document.getElementById('myListingsContainer');
        console.log('renderListings called, container:', container);
        
        // Hapus semua konten yang ada
        container.innerHTML = '';
        
        // Tentukan data yang akan ditampilkan
        let listingsToShow = filteredListings.length > 0 ? filteredListings : allListings;
        console.log('Listings to show:', listingsToShow.length);
        
        if (listingsToShow.length === 0) {
            container.innerHTML = `
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-box-open text-4xl mb-4"></i>
                    <p>Belum ada penawaran yang dibuat</p>
                    <p class="text-sm">Klik "Buat Penawaran" untuk mulai menjual sampah Anda</p>
                </div>
            `;
            return;
        }
        
        // Render setiap penawaran
        listingsToShow.forEach((listing, index) => {
            const listingCard = document.createElement('div');
            listingCard.className = 'product-card bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow';
            listingCard.setAttribute('data-listing-id', listing.id);
            listingCard.style.animation = `fadeIn 0.3s ease-out ${index * 0.1}s forwards`;
            listingCard.innerHTML = `
                <div class="p-4">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex-1">
                            <h4 class="font-semibold text-lg mb-1">${listing.title}</h4>
                            <p class="text-sm text-gray-500 mb-2">Lokasi: ${listing.location}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="status-badge status-pending">${listing.status}</span>
                            <div class="bg-white rounded-full p-2 shadow">
                                <i class="fas fa-edit text-blue-500 hover:text-blue-700 cursor-pointer" onclick="editListing(this)" title="Edit Penawaran"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">${listing.description}</p>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-bold text-blue-600">Rp ${listing.price}/kg</p>
                            <p class="text-xs text-gray-500">Stok: ${listing.stock} kg</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="px-3 py-1 bg-green-50 text-green-600 rounded-full text-sm hover:bg-green-100 transition-colors" onclick="viewOrders('${listing.title}')">
                                <i class="fas fa-eye mr-1"></i> Lihat Pesanan
                            </button>
                            <button class="px-3 py-1 bg-red-50 text-red-600 rounded-full text-sm hover:bg-red-100 transition-colors" onclick="deleteListing(this)">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            container.appendChild(listingCard);
        });
        
        // Update indicators
        updateFilterIndicator();
        updateSortIndicator();
        
        console.log('Render completed. Total cards rendered:', listingsToShow.length);
    }

    // Function untuk update filter indicator
    function updateFilterIndicator() {
        const filterBtn = document.getElementById('filterBtn');
        if (filterBtn) {
            const hasActiveFilters = Object.values(currentFilters).some(value => value !== '' && value !== 'all');
            if (hasActiveFilters) {
                filterBtn.classList.add('bg-blue-500', 'text-white');
                filterBtn.classList.remove('bg-gray-200', 'text-gray-700');
            } else {
                filterBtn.classList.remove('bg-blue-500', 'text-white');
                filterBtn.classList.add('bg-gray-200', 'text-gray-700');
            }
        }
    }

    // Function untuk update sort indicator
    function updateSortIndicator() {
        const sortBtn = document.getElementById('sortBtn');
        if (sortBtn) {
            if (currentSort && currentSort !== 'default') {
                sortBtn.classList.add('bg-green-500', 'text-white');
                sortBtn.classList.remove('bg-gray-200', 'text-gray-700');
            } else {
                sortBtn.classList.remove('bg-green-500', 'text-white');
                sortBtn.classList.add('bg-gray-200', 'text-gray-700');
            }
        }
    }

    // Apply Filter
    function applyFilter() {
        const wasteType = document.getElementById('filterWasteType').value;
        const minPrice = document.getElementById('minPrice').value;
        const maxPrice = document.getElementById('maxPrice').value;
        const location = document.getElementById('filterLocation').value;

        // Update current filters
        currentFilters = {
            wasteType: wasteType,
            minPrice: minPrice ? parseInt(minPrice) : '',
            maxPrice: maxPrice ? parseInt(maxPrice) : '',
            location: location
        };

        // Apply filters
        applyFiltersToData();
        
        // Render filtered results
        renderListings();
        
        // Show success message
        const filterCount = filteredListings.length;
        const totalCount = allListings.length;
        alert(`Filter diterapkan! Menampilkan ${filterCount} dari ${totalCount} penawaran.`);
        
        // Update indicators
        updateFilterIndicator();
        
        closeModal('filterModal');
    }

    // Function untuk menerapkan filter ke data
    function applyFiltersToData() {
        filteredListings = allListings.filter(listing => {
            // Filter berdasarkan jenis sampah
            if (currentFilters.wasteType && listing.wasteType !== currentFilters.wasteType) {
                return false;
            }
            
            // Filter berdasarkan rentang harga
            if (currentFilters.minPrice && listing.price < currentFilters.minPrice) {
                return false;
            }
            if (currentFilters.maxPrice && listing.price > currentFilters.maxPrice) {
                return false;
            }
            
            // Filter berdasarkan lokasi
            if (currentFilters.location && !listing.location.toLowerCase().includes(currentFilters.location.toLowerCase())) {
                return false;
            }
            
            return true;
        });

        // Apply current sort if exists
        if (currentSort) {
            applySortToData();
        }
    }

    // Function untuk menerapkan sort ke data yang sudah difilter
    function applySortToData() {
        const dataToSort = filteredListings.length > 0 ? filteredListings : allListings;
        
        dataToSort.sort((a, b) => {
            switch (currentSort) {
                case 'price-low':
                    return a.price - b.price;
                case 'price-high':
                    return b.price - a.price;
                case 'date-new':
                    return new Date(b.createdAt) - new Date(a.createdAt);
                case 'date-old':
                    return new Date(a.createdAt) - new Date(b.createdAt);
                case 'stock-high':
                    return b.stock - a.stock;
                case 'stock-low':
                    return a.stock - b.stock;
                default:
                    return 0;
            }
        });
    }

    // Apply Sort
    function applySort() {
        const sortBy = document.getElementById('sortBy').value;
        
        // Update current sort
        currentSort = sortBy;
        
        // Apply sort to data
        applySortToData();
        
        // Render sorted results
        renderListings();
        
        // Show success message
        const sortText = document.getElementById('sortBy').options[document.getElementById('sortBy').selectedIndex].text;
        alert(`Urutan diterapkan: ${sortText}`);
        
        // Update indicators
        updateSortIndicator();
        
        closeModal('sortModal');
    }

    // Submit Buy
    function submitBuy() {
        const quantity = document.getElementById('buyQuantity').value;
        const address = document.getElementById('buyAddress').value;

        if (!quantity || !address) {
            alert('Harap isi jumlah dan alamat pengiriman!');
            return;
        }

        alert('Pembelian berhasil! Pesanan Anda akan diproses.');
        closeModal('buyModal');
        document.getElementById('buyQuantity').value = '';
        document.getElementById('buyAddress').value = '';
        document.getElementById('buyNotes').value = '';
    }

    // Show Buy Modal from Detail
    function showBuyModalFromDetail() {
        closeModal('productDetailModal');
        showBuyModal('Plastik PET Bersih', 'Rp 7.500/kg', '150 kg');
    }

    // Edit Listing
    function editListing(element) {
        const card = element.closest('.product-card');
        const listingId = parseInt(card.getAttribute('data-listing-id'));
        
        // Cari data penawaran berdasarkan ID
        const listing = allListings.find(l => l.id === listingId);
        if (!listing) {
            alert('Data penawaran tidak ditemukan!');
            return;
        }
        
        // Populate edit modal
        document.getElementById('wasteType').value = listing.wasteType;
        document.getElementById('listingTitle').value = listing.title;
        document.getElementById('listingDescription').value = listing.description;
        document.getElementById('listingPrice').value = listing.price;
        document.getElementById('listingStock').value = listing.stock;
        document.getElementById('listingLocation').value = listing.location;
        
        // Show modal
        showCreateListingModal();
        
        // Change modal title and button
        document.querySelector('#createListingModal .modal-header h3').textContent = 'Edit Penawaran';
        document.querySelector('#createListingModal .btn-success').textContent = 'Update Penawaran';
        document.querySelector('#createListingModal .btn-success').onclick = function() {
            updateListing(listingId);
        };
    }

    // Update Listing
    function updateListing(listingId) {
        const title = document.getElementById('listingTitle').value;
        const description = document.getElementById('listingDescription').value;
        const price = document.getElementById('listingPrice').value;
        const stock = document.getElementById('listingStock').value;
        const location = document.getElementById('listingLocation').value;
        const wasteType = document.getElementById('wasteType').value;

        if (!title || !description || !price || !stock || !location || !wasteType) {
            alert('Harap isi semua field yang wajib!');
            return;
        }

        // Cari dan update data penawaran
        const listingIndex = allListings.findIndex(l => l.id === listingId);
        if (listingIndex === -1) {
            alert('Data penawaran tidak ditemukan!');
            return;
        }

        // Update data
        allListings[listingIndex] = {
            ...allListings[listingIndex],
            title: title,
            description: description,
            price: parseInt(price),
            stock: parseInt(stock),
            location: location,
            wasteType: wasteType
        };

        console.log('Listing updated:', allListings[listingIndex]);
        console.log('Total listings:', allListings.length);

        // Tutup modal terlebih dahulu
        closeModal('createListingModal');
        
        // Reset form
        document.getElementById('createListingForm').reset();
        
        // Reset modal title and button
        document.querySelector('#createListingModal .modal-header h3').textContent = 'Buat Penawaran Baru';
        document.querySelector('#createListingModal .btn-success').textContent = 'Buat Penawaran';
        document.querySelector('#createListingModal .btn-success').onclick = submitCreateListing;

        // Re-apply filters and sort
        applyFiltersToData();
        renderListings();

        // Tampilkan pesan sukses setelah data diupdate
        setTimeout(() => {
            alert('Penawaran berhasil diupdate!');
            // Highlight penawaran yang baru diupdate
            highlightUpdatedListing(listingId);
            // Scroll ke penawaran yang baru diupdate
            scrollToUpdatedListing(listingId);
        }, 100);
    }

    // Function untuk scroll ke penawaran yang baru diupdate
    function scrollToUpdatedListing(listingId) {
        const listingCard = document.querySelector(`[data-listing-id="${listingId}"]`);
        if (listingCard) {
            listingCard.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
        }
    }

    // Delete Listing
    function deleteListing(element) {
        if (confirm('Apakah Anda yakin ingin menghapus penawaran ini?')) {
            const card = element.closest('.product-card');
            const listingId = parseInt(card.getAttribute('data-listing-id'));
            
            // Hapus dari array global
            const listingIndex = allListings.findIndex(l => l.id === listingId);
            if (listingIndex !== -1) {
                allListings.splice(listingIndex, 1);
            }
            
            // Re-apply filters and sort
            applyFiltersToData();
            renderListings();
            
            alert('Penawaran berhasil dihapus!');
        }
    }

    // View Orders
    function viewOrders(title) {
        alert(`Melihat pesanan untuk: ${title}\n\nBelum ada pesanan yang masuk.`);
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const modals = ['createListingModal', 'filterModal', 'sortModal', 'buyModal', 'productDetailModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (event.target === modal) {
                closeModal(modalId);
            }
        });
    });

    // Product card click to show detail
    document.addEventListener('DOMContentLoaded', function() {
        const productCard = document.querySelector('.product-card');
        if (productCard) {
            productCard.addEventListener('click', function(e) {
                // Don't trigger if clicking on heart icon or buy button
                if (!e.target.closest('.fa-heart') && !e.target.closest('button')) {
                    showProductDetail();
                }
            });
        }
        
        // Add sample data for testing
        addSampleData();
        
        // Load sales and transactions data
        loadSalesData();
        loadTransactionsData();
        
        // Add event listener for transaction status filter
        document.getElementById('transactionStatus').addEventListener('change', function() {
            filterTransactionsByStatus(this.value);
        });
        
        // Ensure marketplace is shown by default
        document.getElementById('marketplaceContent').style.display = 'block';
        document.getElementById('mySalesContent').style.display = 'none';
        document.getElementById('transactionsContent').style.display = 'none';
        
        // Debug: Log to ensure marketplace is visible
        console.log('Marketplace content display:', document.getElementById('marketplaceContent').style.display);
        console.log('Marketplace content visibility:', document.getElementById('marketplaceContent').offsetHeight);
        
        // Force show marketplace content
        showMarketplaceContent();
        
        // Force render listings after a short delay to ensure DOM is ready
        setTimeout(() => {
            console.log('Forcing render listings after delay...');
            renderListings();
        }, 500);
    });

    // Additional event listener to ensure marketplace is shown on page load
    window.addEventListener('load', function() {
        setTimeout(() => {
            showMarketplaceContent();
        }, 100);
    });

    // Function untuk memastikan konten marketplace ditampilkan
    function showMarketplaceContent() {
        const marketplaceContent = document.getElementById('marketplaceContent');
        const mySalesContent = document.getElementById('mySalesContent');
        const transactionsContent = document.getElementById('transactionsContent');
        
        if (marketplaceContent) {
            marketplaceContent.style.display = 'block';
            marketplaceContent.style.visibility = 'visible';
            marketplaceContent.style.opacity = '1';
            marketplaceContent.style.position = 'relative';
            marketplaceContent.style.zIndex = '1';
        }
        
        if (mySalesContent) {
            mySalesContent.style.display = 'none';
        }
        
        if (transactionsContent) {
            transactionsContent.style.display = 'none';
        }
        
        console.log('Marketplace content forced to show');
        console.log('Marketplace element:', marketplaceContent);
        console.log('Marketplace display style:', marketplaceContent ? marketplaceContent.style.display : 'element not found');
    }

    // Function untuk memuat data penjualan
    function loadSalesData() {
        const tableBody = document.getElementById('salesHistoryTable');
        if (!tableBody) return;
        
        tableBody.innerHTML = '';
        
        salesData.forEach(sale => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${formatDate(sale.date)}</td>
                <td>${sale.product}</td>
                <td>${sale.buyer}</td>
                <td>${sale.weight} kg</td>
                <td>Rp ${sale.price.toLocaleString()}/kg</td>
                <td>Rp ${sale.total.toLocaleString()}</td>
                <td><span class="status-badge status-${sale.status}">${getStatusText(sale.status)}</span></td>
                <td>
                    <button class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-xs hover:bg-blue-100" onclick="viewSaleDetail(${sale.id})">
                        <i class="fas fa-eye mr-1"></i> Detail
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    // Function untuk memuat data transaksi
    function loadTransactionsData() {
        const container = document.getElementById('transactionsList');
        if (!container) return;
        
        container.innerHTML = '';
        
        transactionsData.forEach(transaction => {
            const card = document.createElement('div');
            card.className = 'bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow';
            card.innerHTML = `
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h4 class="font-semibold text-gray-800">${transaction.product}</h4>
                        <p class="text-sm text-gray-500">ID: ${transaction.id}</p>
                        <p class="text-sm text-gray-500">Pembeli: ${transaction.buyer}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-lg text-gray-800">Rp ${transaction.amount.toLocaleString()}</p>
                        <span class="status-badge status-${transaction.status}">${getStatusText(transaction.status)}</span>
                    </div>
                </div>
                <div class="flex justify-between items-center text-sm text-gray-600">
                    <div>
                        <p>Tanggal: ${formatDate(transaction.date)}</p>
                        <p>Metode: ${transaction.paymentMethod}</p>
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs hover:bg-blue-100" onclick="viewTransactionDetail('${transaction.id}')">
                            <i class="fas fa-eye mr-1"></i> Detail
                        </button>
                        <button class="px-3 py-1 bg-green-50 text-green-600 rounded-full text-xs hover:bg-green-100" onclick="trackTransaction('${transaction.id}')">
                            <i class="fas fa-truck mr-1"></i> Track
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(card);
        });
    }

    // Function untuk format tanggal
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    }

    // Function untuk mendapatkan teks status
    function getStatusText(status) {
        const statusMap = {
            'pending': 'Menunggu Pembayaran',
            'paid': 'Sudah Dibayar',
            'shipped': 'Dikirim',
            'delivered': 'Diterima',
            'cancelled': 'Dibatalkan'
        };
        return statusMap[status] || status;
    }

    // Function untuk melihat detail penjualan
    function viewSaleDetail(saleId) {
        const sale = salesData.find(s => s.id === saleId);
        if (sale) {
            alert(`Detail Penjualan:\n\nProduk: ${sale.product}\nPembeli: ${sale.buyer}\nBerat: ${sale.weight} kg\nHarga: Rp ${sale.price.toLocaleString()}/kg\nTotal: Rp ${sale.total.toLocaleString()}\nStatus: ${getStatusText(sale.status)}`);
        }
    }

    // Function untuk melihat detail transaksi
    function viewTransactionDetail(transactionId) {
        const transaction = transactionsData.find(t => t.id === transactionId);
        if (transaction) {
            alert(`Detail Transaksi:\n\nID: ${transaction.id}\nProduk: ${transaction.product}\nPembeli: ${transaction.buyer}\nJumlah: Rp ${transaction.amount.toLocaleString()}\nStatus: ${getStatusText(transaction.status)}\nMetode Pembayaran: ${transaction.paymentMethod}`);
        }
    }

    // Function untuk tracking transaksi
    function trackTransaction(transactionId) {
        alert(`Tracking Transaksi ${transactionId}:\n\nStatus: Dalam pengiriman\nEstimasi: 2-3 hari kerja\nKurir: JNE Express\nResi: JNE${transactionId.replace('TRX-', '')}123456`);
    }

    // Function untuk export data penjualan
    function exportSalesData() {
        // Buat data untuk export
        const exportData = salesData.map(sale => ({
            'Tanggal': formatDate(sale.date),
            'Produk': sale.product,
            'Pembeli': sale.buyer,
            'Berat (kg)': sale.weight,
            'Harga per kg': `Rp ${sale.price.toLocaleString()}`,
            'Total': `Rp ${sale.total.toLocaleString()}`,
            'Status': getStatusText(sale.status)
        }));

        // Buat header untuk Excel
        const headers = ['Tanggal', 'Produk', 'Pembeli', 'Berat (kg)', 'Harga per kg', 'Total', 'Status'];
        
        // Gunakan fungsi universal
        exportDataToExcel(exportData, 'Data_Penjualan', headers);
    }

    // Function untuk refresh transaksi
    function refreshTransactions() {
        loadTransactionsData();
        alert('Data transaksi berhasil diperbarui!');
    }

    // Function untuk filter transaksi berdasarkan status
    function filterTransactionsByStatus(status) {
        const container = document.getElementById('transactionsList');
        if (!container) return;
        
        container.innerHTML = '';
        
        let filteredTransactions = transactionsData;
        if (status) {
            filteredTransactions = transactionsData.filter(t => t.status === status);
        }
        
        if (filteredTransactions.length === 0) {
            container.innerHTML = `
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-search text-4xl mb-4"></i>
                    <p>Tidak ada transaksi dengan status tersebut</p>
                </div>
            `;
            return;
        }
        
        filteredTransactions.forEach(transaction => {
            const card = document.createElement('div');
            card.className = 'bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow';
            card.innerHTML = `
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h4 class="font-semibold text-gray-800">${transaction.product}</h4>
                        <p class="text-sm text-gray-500">ID: ${transaction.id}</p>
                        <p class="text-sm text-gray-500">Pembeli: ${transaction.buyer}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-lg text-gray-800">Rp ${transaction.amount.toLocaleString()}</p>
                        <span class="status-badge status-${transaction.status}">${getStatusText(transaction.status)}</span>
                    </div>
                </div>
                <div class="flex justify-between items-center text-sm text-gray-600">
                    <div>
                        <p>Tanggal: ${formatDate(transaction.date)}</p>
                        <p>Metode: ${transaction.paymentMethod}</p>
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs hover:bg-blue-100" onclick="viewTransactionDetail('${transaction.id}')">
                            <i class="fas fa-eye mr-1"></i> Detail
                        </button>
                        <button class="px-3 py-1 bg-green-50 text-green-600 rounded-full text-xs hover:bg-green-100" onclick="trackTransaction('${transaction.id}')">
                            <i class="fas fa-truck mr-1"></i> Track
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(card);
        });
    }

    // Function untuk menambah data contoh
    function addSampleData() {
        console.log('addSampleData called, current listings:', allListings.length);
        
        if (allListings.length === 0) {
            const sampleData = [
                {
                    id: Date.now() - 3000,
                    title: 'Plastik PET Bersih',
                    description: 'Plastik PET bersih, sudah dicuci dan dikeringkan, siap untuk didaur ulang.',
                    price: 7500,
                    stock: 150,
                    location: 'Jakarta Selatan',
                    wasteType: 'plastik',
                    status: 'Aktif',
                    createdAt: new Date(Date.now() - 3000)
                },
                {
                    id: Date.now() - 2000,
                    title: 'Kertas Koran Bekas',
                    description: 'Kertas koran bekas dalam kondisi baik, cocok untuk daur ulang.',
                    price: 3000,
                    stock: 200,
                    location: 'Jakarta Barat',
                    wasteType: 'kertas',
                    status: 'Aktif',
                    createdAt: new Date(Date.now() - 2000)
                },
                {
                    id: Date.now() - 1000,
                    title: 'Logam Aluminium',
                    description: 'Logam aluminium bekas kemasan, sudah dibersihkan.',
                    price: 12000,
                    stock: 50,
                    location: 'Jakarta Utara',
                    wasteType: 'logam',
                    status: 'Aktif',
                    createdAt: new Date(Date.now() - 1000)
                },
                {
                    id: Date.now() - 500,
                    title: 'Elektronik Bekas',
                    description: 'Komponen elektronik bekas yang masih bisa didaur ulang.',
                    price: 25000,
                    stock: 30,
                    location: 'Jakarta Timur',
                    wasteType: 'elektronik',
                    status: 'Aktif',
                    createdAt: new Date(Date.now() - 500)
                },
                {
                    id: Date.now(),
                    title: 'Sampah Organik',
                    description: 'Sampah organik dari dapur, cocok untuk kompos.',
                    price: 2000,
                    stock: 100,
                    location: 'Jakarta Pusat',
                    wasteType: 'organik',
                    status: 'Aktif',
                    createdAt: new Date()
                }
            ];
            
            allListings.push(...sampleData);
            console.log('Sample data added, total listings:', allListings.length);
            renderListings();
        } else {
            console.log('Sample data already exists, skipping...');
        }
    }

    // Function untuk export data transaksi
    function exportTransactionData() {
        // Buat data untuk export
        const exportData = transactionsData.map(transaction => ({
            'ID Transaksi': transaction.id,
            'Tanggal': formatDate(transaction.date),
            'Produk': transaction.product,
            'Pembeli': transaction.buyer,
            'Jumlah': `Rp ${transaction.amount.toLocaleString()}`,
            'Status': getStatusText(transaction.status),
            'Metode Pembayaran': transaction.paymentMethod
        }));

        // Buat header untuk Excel
        const headers = ['ID Transaksi', 'Tanggal', 'Produk', 'Pembeli', 'Jumlah', 'Status', 'Metode Pembayaran'];
        
        // Gunakan fungsi universal
        exportDataToExcel(exportData, 'Data_Transaksi', headers);
    }

    // Function untuk export data penawaran marketplace
    function exportMarketplaceData() {
        // Tentukan data yang akan diexport (semua atau yang difilter)
        const dataToExport = filteredListings.length > 0 ? filteredListings : allListings;
        
        if (dataToExport.length === 0) {
            alert('Tidak ada data penawaran untuk diexport!');
            return;
        }

        // Buat data untuk export
        const exportData = dataToExport.map(listing => ({
            'Judul Penawaran': listing.title,
            'Deskripsi': listing.description,
            'Jenis Sampah': listing.wasteType,
            'Harga per kg': `Rp ${listing.price.toLocaleString()}`,
            'Stok (kg)': listing.stock,
            'Lokasi': listing.location,
            'Status': listing.status,
            'Tanggal Dibuat': formatDate(listing.createdAt)
        }));

        // Buat header untuk Excel
        const headers = ['Judul Penawaran', 'Deskripsi', 'Jenis Sampah', 'Harga per kg', 'Stok (kg)', 'Lokasi', 'Status', 'Tanggal Dibuat'];
        
        // Gunakan fungsi universal
        exportDataToExcel(exportData, 'Data_Penawaran_Marketplace', headers);
    }

    // Function untuk export data yang universal
    function exportDataToExcel(data, filename, headers) {
        if (data.length === 0) {
            alert('Tidak ada data untuk diexport!');
            return;
        }

        // Buat CSV content
        let csvContent = '\uFEFF'; // BOM untuk UTF-8
        csvContent += headers.join(',') + '\n';
        
        data.forEach(row => {
            const values = headers.map(header => {
                const value = row[header] || '';
                // Escape quotes dan wrap dalam quotes jika ada koma
                return `"${value.toString().replace(/"/g, '""')}"`;
            });
            csvContent += values.join(',') + '\n';
        });

        // Buat dan download file
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        
        link.setAttribute('href', url);
        link.setAttribute('download', `${filename}_${new Date().toISOString().split('T')[0]}.csv`);
        link.style.visibility = 'hidden';
        
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Tampilkan pesan sukses
        setTimeout(() => {
            alert(`${filename} berhasil diexport!\n\nFile: ${filename}_${new Date().toISOString().split('T')[0]}.csv\nTotal data: ${data.length} baris`);
        }, 100);
    }

    // Function untuk menampilkan data penjualan sampah yang tersimpan
    function displayStoredWasteSales() {
        const storedData = JSON.parse(localStorage.getItem('wasteSalesData') || '[]');
        const container = document.getElementById('storedWasteSalesContainer');
        
        if (!container) return;
        
        if (storedData.length === 0) {
            container.innerHTML = '<p class="text-gray-500 text-center py-8">Belum ada data penjualan sampah tersimpan</p>';
            return;
        }
        
        let html = '<div class="space-y-4">';
        storedData.forEach((sale, index) => {
            const date = new Date(sale.tanggal).toLocaleDateString('id-ID');
            const isNew = sale.isNew ? 'border-l-4 border-l-green-500' : '';
            
            html += `
                <div class="bg-white rounded-lg shadow-md p-4 ${isNew}">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h4 class="font-semibold text-gray-800">${sale.judulPenawaran}</h4>
                            <p class="text-sm text-gray-600">Invoice: ${sale.id}</p>
                        </div>
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">${sale.status}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <span class="text-gray-600">Jenis:</span>
                            <span class="font-medium">${sale.jenisSampah}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Berat:</span>
                            <span class="font-medium">${sale.berat} kg</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Harga/kg:</span>
                            <span class="font-medium">Rp ${sale.hargaPerKg.toLocaleString()}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Total:</span>
                            <span class="font-medium text-green-600">Rp ${sale.totalHarga.toLocaleString()}</span>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-2">${sale.deskripsi}</p>
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span>${sale.lokasi}</span>
                            <span>${date}</span>
                        </div>
                    </div>
                    ${sale.isNew ? '<div class="mt-2 text-xs text-green-600 font-medium">✨ Data Baru</div>' : ''}
                </div>
            `;
        });
        html += '</div>';
        
        container.innerHTML = html;
    }

    // Function untuk export data penjualan sampah
    function exportWasteSalesData() {
        const storedData = JSON.parse(localStorage.getItem('wasteSalesData') || '[]');
        
        if (storedData.length === 0) {
            alert('Tidak ada data untuk diexport!');
            return;
        }
        
        // Convert to CSV
        let csvContent = 'Invoice ID,Nasabah,Jenis Sampah,Judul Penawaran,Berat (kg),Harga per kg,Total Harga,Lokasi,Tanggal,Status\n';
        
        storedData.forEach(sale => {
            const date = new Date(sale.tanggal).toLocaleDateString('id-ID');
            csvContent += `${sale.id},${sale.nasabah},${sale.jenisSampah},${sale.judulPenawaran},${sale.berat},${sale.hargaPerKg},${sale.totalHarga},${sale.lokasi},${date},${sale.status}\n`;
        });
        
        // Download CSV
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', `data_penjualan_sampah_${new Date().toISOString().split('T')[0]}.csv`);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // Function untuk clear data penjualan sampah
    function clearWasteSalesData() {
        if (confirm('Yakin ingin menghapus semua data penjualan sampah? Data tidak dapat dikembalikan!')) {
            localStorage.removeItem('wasteSalesData');
            displayStoredWasteSales();
            alert('Data penjualan sampah berhasil dihapus!');
        }
    }

    // Event listener untuk sync data dengan halaman lain
    window.addEventListener('wasteSaleAdded', function(event) {
        console.log('Event wasteSaleAdded diterima:', event.detail);
        // Update tampilan data
        displayStoredWasteSales();
    });

    // Event listener saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Tampilkan data yang tersimpan
        displayStoredWasteSales();
        
        // Log jumlah data tersimpan
        const storedData = JSON.parse(localStorage.getItem('wasteSalesData') || '[]');
        console.log('Data penjualan sampah tersimpan:', storedData.length);
    });
</script>
</body>
</html>