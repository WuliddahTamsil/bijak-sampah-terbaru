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
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
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

            <div id="marketplaceContent" class="space-y-6">
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
                            <button class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm hover:bg-blue-100 transition-colors" onclick="showFilterModal()">
                                <i class="fas fa-filter mr-1"></i> Filter
                            </button>
                            <button class="px-3 py-1 bg-gray-50 text-gray-600 rounded-full text-sm hover:bg-gray-100 transition-colors" onclick="showSortModal()">
                                <i class="fas fa-sort mr-1"></i> Urutkan
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
            <div class="text-center mb-4">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTkhzQG6s2X-haW0c3C_jdFh3OZInLXz5F_UA&s" alt="Plastik PET" class="w-full max-w-md mx-auto rounded-lg">
            </div>
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
        
        // Hide all content
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('active');
        });
        
        // Show selected content
        document.getElementById(tabName + 'Content').classList.add('active');
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

        // Tambah penawaran ke list
        addListingToContainer(title, description, price, stock, location, wasteType);
        
        alert('Penawaran berhasil dibuat!');
        closeModal('createListingModal');
        document.getElementById('createListingForm').reset();
    }

    // Function untuk menambah penawaran ke container
    function addListingToContainer(title, description, price, stock, location, wasteType) {
        const container = document.getElementById('myListingsContainer');
        
        // Hapus pesan "Belum ada penawaran" jika ada
        const emptyMessage = container.querySelector('.text-center');
        if (emptyMessage) {
            emptyMessage.remove();
        }
        
        // Buat card penawaran baru
        const listingCard = document.createElement('div');
        listingCard.className = 'product-card bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow';
        listingCard.innerHTML = `
            <div class="relative">
                <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop" alt="${title}" class="w-full h-48 object-cover">
                <div class="absolute top-2 right-2 bg-white rounded-full p-2 shadow">
                    <i class="fas fa-edit text-blue-500 hover:text-blue-700 cursor-pointer" onclick="editListing(this)" title="Edit Penawaran"></i>
                </div>
            </div>
            <div class="p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="font-semibold text-lg mb-1">${title}</h4>
                        <p class="text-sm text-gray-500 mb-2">Lokasi: ${location}</p>
                    </div>
                    <span class="status-badge status-pending">Aktif</span>
                </div>
                <p class="text-sm text-gray-600 mb-3">${description}</p>
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-bold text-blue-600">Rp ${price}/kg</p>
                        <p class="text-xs text-gray-500">Stok: ${stock} kg</p>
                    </div>
                    <div class="flex gap-2">
                        <button class="px-3 py-1 bg-green-50 text-green-600 rounded-full text-sm hover:bg-green-100 transition-colors" onclick="viewOrders('${title}')">
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
    }

    // Apply Filter
    function applyFilter() {
        const wasteType = document.getElementById('filterWasteType').value;
        const minPrice = document.getElementById('minPrice').value;
        const maxPrice = document.getElementById('maxPrice').value;
        const location = document.getElementById('filterLocation').value;

        alert('Filter diterapkan!');
        closeModal('filterModal');
    }

    // Apply Sort
    function applySort() {
        const sortBy = document.getElementById('sortBy').value;
        alert('Urutan diterapkan!');
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
        const title = card.querySelector('h4').textContent;
        const description = card.querySelector('p.text-gray-600').textContent;
        const price = card.querySelector('.text-blue-600').textContent.replace('Rp ', '').replace('/kg', '');
        const stock = card.querySelector('.text-xs.text-gray-500').textContent.replace('Stok: ', '').replace(' kg', '');
        const location = card.querySelector('p.text-gray-500').textContent.replace('Lokasi: ', '');
        
        // Populate edit modal
        document.getElementById('wasteType').value = 'plastik'; // Default
        document.getElementById('listingTitle').value = title;
        document.getElementById('listingDescription').value = description;
        document.getElementById('listingPrice').value = price;
        document.getElementById('listingStock').value = stock;
        document.getElementById('listingLocation').value = location;
        
        // Show modal
        showCreateListingModal();
        
        // Change modal title and button
        document.querySelector('#createListingModal .modal-header h3').textContent = 'Edit Penawaran';
        document.querySelector('#createListingModal .btn-success').textContent = 'Update Penawaran';
        document.querySelector('#createListingModal .btn-success').onclick = function() {
            updateListing(card);
        };
    }

    // Update Listing
    function updateListing(card) {
        const title = document.getElementById('listingTitle').value;
        const description = document.getElementById('listingDescription').value;
        const price = document.getElementById('listingPrice').value;
        const stock = document.getElementById('listingStock').value;
        const location = document.getElementById('listingLocation').value;

        if (!title || !description || !price || !stock || !location) {
            alert('Harap isi semua field yang wajib!');
            return;
        }

        // Update card content
        card.querySelector('h4').textContent = title;
        card.querySelector('p.text-gray-600').textContent = description;
        card.querySelector('.text-blue-600').textContent = `Rp ${price}/kg`;
        card.querySelector('.text-xs.text-gray-500').textContent = `Stok: ${stock} kg`;
        card.querySelector('p.text-gray-500').textContent = `Lokasi: ${location}`;
        card.querySelector('img').alt = title;

        alert('Penawaran berhasil diupdate!');
        closeModal('createListingModal');
        document.getElementById('createListingForm').reset();
        
        // Reset modal title and button
        document.querySelector('#createListingModal .modal-header h3').textContent = 'Buat Penawaran Baru';
        document.querySelector('#createListingModal .btn-success').textContent = 'Buat Penawaran';
        document.querySelector('#createListingModal .btn-success').onclick = submitCreateListing;
    }

    // Delete Listing
    function deleteListing(element) {
        if (confirm('Apakah Anda yakin ingin menghapus penawaran ini?')) {
            const card = element.closest('.product-card');
            card.remove();
            
            // Check if no more listings
            const container = document.getElementById('myListingsContainer');
            if (container.children.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-box-open text-4xl mb-4"></i>
                        <p>Belum ada penawaran yang dibuat</p>
                        <p class="text-sm">Klik "Buat Penawaran" untuk mulai menjual sampah Anda</p>
                    </div>
                `;
            }
            
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
    });
</script>
</body>
</html>