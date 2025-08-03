<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace Sampah - Bijak Sampah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        
        /* Sidebar dari kode pertama (disesuaikan) */
        .sidebar {
            width: 80px;
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 30%, var(--primary-color) 100%);
            color: white;
            padding: 20px 0;
            min-height: 100vh;
            transition: width 0.3s ease;
            position: fixed;
            left: 0;
            top: 0;
            overflow: hidden;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .sidebar:hover {
            width: 250px;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .logo-container {
            padding: 0 20px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            height: 60px;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
        }

        .logo img {
            width: 200px;
            height: 200px;
            object-fit: contain;
        }

        .logo-text {
            font-size: 18px;
            font-weight: bold;
            color: white;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar:hover .logo-text {
            opacity: 1;
        }

        .logo span {
            color: #4ADE80;
        }

        .toggle-collapse {
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            padding: 5px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar:hover .toggle-collapse {
            opacity: 1;
        }

        .menu-items {
            list-style: none;
        }

        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s;
            white-space: nowrap;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .menu-item.active {
            background: rgba(255, 255, 255, 0.2);
            border-left: 4px solid var(--accent-color);
        }

        .menu-item.active .menu-icon {
            color: var(--accent-color);
        }

        .sub-menu-item {
            padding: 10px 20px 10px 50px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
            font-size: 14px;
            position: relative;
        }

        .sub-menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .sub-menu-item.active {
            background: rgba(255, 255, 255, 0.15);
            font-weight: 500;
        }

        .menu-icon {
            width: 24px;
            height: 24px;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: color 0.3s ease;
        }

        .menu-text {
            font-size: 15px;
            transition: opacity 0.3s ease;
            opacity: 0;
        }

        .sidebar:hover .menu-text {
            opacity: 1;
        }

        .sidebar.collapsed .menu-text {
            opacity: 0;
            width: 0;
        }

        .sidebar.collapsed .logo-text {
            display: none;
        }

        .sidebar.collapsed .logo-icon {
            font-size: 22px;
        }

        .sidebar-footer {
            padding: 0;
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: auto;
            flex-shrink: 0;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 80px;
            width: calc(100% - 80px);
            padding: 30px;
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        .sidebar:hover ~ .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: 80px;
            width: calc(100% - 80px);
        }

        /* Marketplace Styles */
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

        .status-pending {
            background-color: #fef3c7;
            color: #d97706;
        }

        .status-processing {
            background-color: #dbeafe;
            color: #1d4ed8;
        }

        .status-shipped {
            background-color: #e0f2fe;
            color: #0369a1;
        }

        .status-completed {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-cancelled {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        /* Chat Bubble */
        .chat-bubble {
            max-width: 70%;
            padding: 10px 15px;
            border-radius: 18px;
            margin-bottom: 10px;
        }

        .chat-bubble.sent {
            background-color: #2563eb;
            color: white;
            margin-left: auto;
            border-bottom-right-radius: 4px;
        }

        .chat-bubble.received {
            background-color: #e2e8f0;
            color: #1e293b;
            margin-right: auto;
            border-bottom-left-radius: 4px;
        }

        /* Stepper */
        .stepper {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 2rem 0;
        }

        .stepper::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 2px;
            background: #e2e8f0;
            z-index: 1;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #64748b;
        }

        .step.active .step-number {
            background: #2563eb;
            color: white;
        }

        .step.completed .step-number {
            background: #16a34a;
            color: white;
        }

        .step-title {
            font-size: 0.875rem;
            color: #64748b;
            text-align: center;
        }

        .step.active .step-title {
            color: #1e293b;
            font-weight: 500;
        }

        .step.completed .step-title {
            color: #16a34a;
        }

        /* Responsive Styles */
        @media (max-width: 1024px) {
            .sidebar {
                width: 240px;
            }
            .main-content {
                margin-left: 240px;
                width: calc(100% - 240px);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
            }
            .sidebar.collapsed {
                width: 80px;
            }
            .main-content {
                margin-left: 80px;
                width: calc(100% - 80px);
                padding: 20px 15px;
            }
            .menu-text, .logo-text {
                display: none;
            }
            .logo-container {
                justify-content: center;
            }
            .sub-menu-item {
                padding-left: 20px;
            }
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo-container">
            <div class="logo">
                <img src="{{ asset('asset/img/Logo Alternative_Dark (1).png') }}" alt="Bijak Sampah Logo">
            </div>
            <button class="toggle-collapse">
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>
        
        <div class="menu-container">
            <ul class="menu-items">
                <li class="menu-item">
                    <a href="{{ route('dashboard-banksampah') }}" style="text-decoration: none; color: inherit;">
                        <div class="menu-icon"><i class="fas fa-home"></i></div>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                <li class="menu-item">
                    <div class="menu-icon"><i class="fas fa-users"></i></div>
                    <span class="menu-text">Nasabah</span>
                    <i class="fas fa-chevron-down ml-auto text-xs opacity-70"></i>
                </li>
                <li class="sub-menu-item">
                    <a href="{{ route('verifikasi-nasabah-banksampah') }}" style="text-decoration: none; color: inherit;">
                        <div class="menu-icon"><i class="fas fa-user-check"></i></div>
                        <span class="menu-text">Verifikasi Nasabah</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="{{ route('data-nasabah-banksampah') }}" style="text-decoration: none; color: inherit;">
                        <div class="menu-icon"><i class="fas fa-database"></i></div>
                        <span class="menu-text">Data Nasabah</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('penjemputan-sampah-banksampah') }}" style="text-decoration: none; color: inherit;">
                        <div class="menu-icon"><i class="fas fa-truck"></i></div>
                        <span class="menu-text">Penjemputan Sampah</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('penimbangansampah-banksampah') }}" style="text-decoration: none; color: inherit;">
                        <div class="menu-icon"><i class="fas fa-weight-hanging"></i></div>
                        <span class="menu-text">Penimbangan</span>
                        <i class="fas fa-chevron-down ml-auto text-xs opacity-70"></i>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <div class="menu-icon"><i class="fas fa-plus-circle"></i></div>
                    <span class="menu-text">Input Setoran</span>
                </li>
                <li class="menu-item">
                    <a href="{{ route('datasampah-banksampah') }}" style="text-decoration: none; color: inherit;">
                        <div class="menu-icon"><i class="fas fa-trash-alt"></i></div>
                        <span class="menu-text">Data Sampah</span>
                    </a>
                </li>
                <li class="menu-item active">
                    <a href="{{ route('penjualansampah-banksampah') }}" style="text-decoration: none; color: inherit;">
                        <div class="menu-icon"><i class="fas fa-shopping-cart"></i></div>
                        <span class="menu-text">Penjualan Sampah</span>
                    </a>
                </li>
                <li class="menu-item">
                    <div class="menu-icon"><i class="fas fa-cog"></i></div>
                    <span class="menu-text">Pengaturan</span>
                </li>
            </ul>
        </div>

        <div class="sidebar-footer">
            <div class="menu-item" id="logoutBtn">
                <div class="menu-icon"><i class="fas fa-sign-out-alt"></i></div>
                <span class="menu-text">Logout</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Marketplace Sampah</h1>
                <p class="text-sm text-gray-500">Jual sampah Anda ke UMKM daur ulang dan pengepul terdekat</p>
            </div>
            <div class="flex items-center space-x-4 w-full md:w-auto">
                <div class="relative flex-grow md:flex-grow-0">
                    <input type="text" placeholder="Cari jenis sampah..." class="pl-10 pr-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm w-full">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <div class="relative">
                    <select id="locationFilter" class="pl-4 pr-10 py-2 border rounded-full appearance-none bg-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">Semua Lokasi</option>
                        <option value="jakarta">Jakarta</option>
                        <option value="bandung">Bandung</option>
                        <option value="surabaya">Surabaya</option>
                        <option value="bali">Bali</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs"></i>
                </div>
                <div class="relative tooltip">
                    <i class="fas fa-bell text-xl text-gray-600 cursor-pointer hover:text-blue-500"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">3</span>
                    <span class="tooltip-text">Notifikasi</span>
                </div>
                <div class="relative tooltip">
                    <div class="flex items-center space-x-2 cursor-pointer">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User" class="w-8 h-8 rounded-full object-cover">
                        <span class="hidden md:inline text-sm font-medium">Admin</span>
                    </div>
                    <span class="tooltip-text">Profil Pengguna</span>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex border-b border-gray-200 mb-6">
            <button class="px-4 py-2 font-medium text-blue-600 border-b-2 border-blue-600" id="marketplaceTab">
                <i class="fas fa-store mr-2"></i>Marketplace
            </button>
            <button class="px-4 py-2 font-medium text-gray-500 hover:text-blue-600" id="mySalesTab">
                <i class="fas fa-clipboard-list mr-2"></i>Penjualan Saya
            </button>
            <button class="px-4 py-2 font-medium text-gray-500 hover:text-blue-600" id="transactionsTab">
                <i class="fas fa-exchange-alt mr-2"></i>Transaksi
            </button>
        </div>

        <!-- Marketplace Content -->
        <div id="marketplaceContent" class="space-y-6">
            <!-- Create New Listing -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Buat Penawaran Baru</h3>
                        <p class="text-sm text-gray-500">Jual sampah Anda ke UMKM daur ulang dan pengepul</p>
                    </div>
                    <button class="w-full md:w-auto px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg font-medium hover:from-blue-700 hover:to-blue-900 transition-all" id="createListingBtn">
                        <i class="fas fa-plus mr-2"></i>Buat Penawaran
                    </button>
                </div>
            </div>

            <!-- Available Waste Listings -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Sampah Tersedia di Marketplace</h3>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm hover:bg-blue-100 transition-colors">
                            <i class="fas fa-filter mr-1"></i> Filter
                        </button>
                        <button class="px-3 py-1 bg-gray-50 text-gray-600 rounded-full text-sm hover:bg-gray-100 transition-colors">
                            <i class="fas fa-sort mr-1"></i> Urutkan
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Product Card 1 -->
                    <div class="product-card bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <div class="relative">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTkhzQG6s2X-haW0c3C_jdFh3OZInLXz5F_UA&s" alt="Plastik PET" class="w-full h-48 object-cover">
                            <div class="absolute top-2 right-2 bg-white rounded-full p-2 shadow">
                                <i class="fas fa-heart text-gray-400 hover:text-red-500 cursor-pointer"></i>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-semibold text-lg mb-1">Plastik PET Bersih</h4>
                                    <p class="text-sm text-gray-500 mb-2">Dari: Bank Sampah Hijau</p>
                                </div>
                                <span class="status-badge status-pending">Tersedia</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-3">Plastik PET bersih, sudah dicuci dan dikeringkan, siap untuk didaur ulang.</p>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-bold text-blue-600">Rp 7.500/kg</p>
                                    <p class="text-xs text-gray-500">Stok: 150 kg</p>
                                </div>
                                <button class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm hover:bg-blue-100 transition-colors">
                                    <i class="fas fa-shopping-cart mr-1"></i> Beli
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product Card 2 -->
                    <div class="product-card bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1604176354204-9268737828e4?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Kertas Campur" class="w-full h-48 object-cover">
                            <div class="absolute top-2 right-2 bg-white rounded-full p-2 shadow">
                                <i class="fas fa-heart text-red-500 cursor-pointer"></i>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-semibold text-lg mb-1">Kertas Campur Kualitas Baik</h4>
                                    <p class="text-sm text-gray-500 mb-2">Dari: UMKM Daur Ulang Jaya</p>
                                </div>
                                <span class="status-badge status-pending">Tersedia</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-3">Kertas campur berbagai jenis (HVS, koran, karton) dalam kondisi baik.</p>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-bold text-blue-600">Rp 3.200/kg</p>
                                    <p class="text-xs text-gray-500">Stok: 250 kg</p>
                                </div>
                                <button class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm hover:bg-blue-100 transition-colors">
                                    <i class="fas fa-shopping-cart mr-1"></i> Beli
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product Card 3 -->
                    <div class="product-card bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <div class="relative">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTs0pB8_kV-FK2QYIu8XHO27KJwUiNppU1ouA&s" alt="Kaleng Aluminium" class="w-full h-48 object-cover">
                            <div class="absolute top-2 right-2 bg-white rounded-full p-2 shadow">
                                <i class="fas fa-heart text-gray-400 hover:text-red-500 cursor-pointer"></i>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-semibold text-lg mb-1">Kaleng Aluminium Bekas</h4>
                                    <p class="text-sm text-gray-500 mb-2">Dari: Pengepul Logam Sejahtera</p>
                                </div>
                                <span class="status-badge status-pending">Tersedia</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-3">Kaleng aluminium berbagai ukuran, sudah dipress dan siap dilebur.</p>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-bold text-blue-600">Rp 12.000/kg</p>
                                    <p class="text-xs text-gray-500">Stok: 80 kg</p>
                                </div>
                                <button class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm hover:bg-blue-100 transition-colors">
                                    <i class="fas fa-shopping-cart mr-1"></i> Beli
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-center">
                    <button class="px-4 py-2 border border-blue-500 text-blue-500 rounded-md hover:bg-blue-50 transition-colors">
                        Lihat Lebih Banyak
                    </button>
                </div>
            </div>
        </div>

        <!-- My Sales Content (Hidden by default) -->
        <div id="mySalesContent" class="space-y-6 hidden">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Penjualan Saya</h3>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm hover:bg-blue-100 transition-colors">
                            <i class="fas fa-filter mr-1"></i> Filter
                        </button>
                        <button class="px-3 py-1 bg-gray-50 text-gray-600 rounded-full text-sm hover:bg-gray-100 transition-colors">
                            <i class="fas fa-sort mr-1"></i> Urutkan
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Transaksi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembeli</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#TRX-20250515-001</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Plastik PET</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">UMKM Daur Ulang Jaya</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">25 kg</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp 187.500</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="status-badge status-processing">Diproses</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <button class="text-blue-500 hover:text-blue-700 mr-3">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-green-500 hover:text-green-700">
                                        <i class="fas fa-truck"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#TRX-20250510-002</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Kertas Campur</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Pabrik Kertas Maju</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">50 kg</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp 160.000</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="status-badge status-shipped">Dikirim</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <button class="text-blue-500 hover:text-blue-700 mr-3">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-green-500 hover:text-green-700">
                                        <i class="fas fa-map-marked-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#TRX-20250505-003</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Kaleng Aluminium</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Pengepul Logam Sejahtera</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15 kg</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp 180.000</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="status-badge status-completed">Selesai</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <button class="text-blue-500 hover:text-blue-700 mr-3">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-purple-500 hover:text-purple-700">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Transactions Content (Hidden by default) -->
        <div id="transactionsContent" class="space-y-6 hidden">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Riwayat Transaksi</h3>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm hover:bg-blue-100 transition-colors">
                            <i class="fas fa-filter mr-1"></i> Filter
                        </button>
                        <button class="px-3 py-1 bg-gray-50 text-gray-600 rounded-full text-sm hover:bg-gray-100 transition-colors">
                            <i class="fas fa-sort mr-1"></i> Urutkan
                        </button>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Transaction Item 1 -->
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h4 class="font-semibold text-lg">#TRX-20250515-001</h4>
                                <p class="text-sm text-gray-500">15 Mei 2025, 14:30 WIB</p>
                            </div>
                            <span class="status-badge status-completed">Selesai</span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-500">Produk</p>
                                <p class="font-medium">Plastik PET - 25 kg</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Pembeli</p>
                                <p class="font-medium">UMKM Daur Ulang Jaya</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total</p>
                                <p class="font-medium text-blue-600">Rp 187.500</p>
                            </div>
                        </div>
                        
                        <div class="stepper">
                            <div class="step completed">
                                <div class="step-number">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="step-title">Pesanan Dibuat</div>
                            </div>
                            <div class="step completed">
                                <div class="step-number">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="step-title">Pembayaran</div>
                            </div>
                            <div class="step completed">
                                <div class="step-number">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="step-title">Pengiriman</div>
                            </div>
                            <div class="step completed">
                                <div class="step-number">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="step-title">Selesai</div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3">
                            <button class="px-4 py-2 border rounded-md text-sm hover:bg-gray-100">Detail</button>
                            <button class="px-4 py-2 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600">Cetak Invoice</button>
                        </div>
                    </div>

                    <!-- Transaction Item 2 -->
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h4 class="font-semibold text-lg">#TRX-20250510-002</h4>
                                <p class="text-sm text-gray-500">10 Mei 2025, 09:15 WIB</p>
                            </div>
                            <span class="status-badge status-shipped">Dikirim</span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-500">Produk</p>
                                <p class="font-medium">Kertas Campur - 50 kg</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Pembeli</p>
                                <p class="font-medium">Pabrik Kertas Maju</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total</p>
                                <p class="font-medium text-blue-600">Rp 160.000</p>
                            </div>
                        </div>
                        
                        <div class="stepper">
                            <div class="step completed">
                                <div class="step-number">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="step-title">Pesanan Dibuat</div>
                            </div>
                            <div class="step completed">
                                <div class="step-number">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="step-title">Pembayaran</div>
                            </div>
                            <div class="step active">
                                <div class="step-number">3</div>
                                <div class="step-title">Pengiriman</div>
                            </div>
                            <div class="step">
                                <div class="step-number">4</div>
                                <div class="step-title">Selesai</div>
                            </div>
                        </div>
                        
                        <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-truck text-blue-500 mr-3"></i>
                                <div>
                                    <p class="font-medium text-sm">Paket sedang dalam perjalanan</p>
                                    <p class="text-xs text-gray-500">Estimasi tiba: 18 Mei 2025</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3 mt-4">
                            <button class="px-4 py-2 border rounded-md text-sm hover:bg-gray-100">Detail</button>
                            <button class="px-4 py-2 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600">Lacak</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Listing Modal -->
    <div id="createListingModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Buat Penawaran Baru</h3>
                    <button id="closeCreateModal" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="listingForm">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Sampah</label>
                            <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Jenis Sampah</option>
                                <optgroup label="Plastik">
                                    <option value="pet">Plastik PET</option>
                                    <option value="hdpe">Plastik HDPE</option>
                                    <option value="ldpe">Plastik LDPE</option>
                                    <option value="pp">Plastik PP</option>
                                </optgroup>
                                <optgroup label="Kertas">
                                    <option value="hvs">Kertas HVS</option>
                                    <option value="koran">Kertas Koran</option>
                                    <option value="duplex">Kertas Duplex</option>
                                </optgroup>
                                <optgroup label="Logam">
                                    <option value="aluminium">Aluminium</option>
                                    <option value="besi">Besi</option>
                                    <option value="tembaga">Tembaga</option>
                                </optgroup>
                                <optgroup label="Lainnya">
                                    <option value="kaca">Kaca</option>
                                    <option value="elektronik">Elektronik</option>
                                    <option value="minyak">Minyak Jelantah</option>
                                </optgroup>
                            </select>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                                <div class="flex">
                                    <input type="number" class="flex-1 border border-gray-300 rounded-l-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="0">
                                    <select class="border border-gray-300 border-l-0 rounded-r-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="kg">Kg</option>
                                        <option value="liter">Liter</option>
                                        <option value="unit">Unit</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Harga per Satuan (Rp)</label>
                                <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="0">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Deskripsikan kondisi sampah (bersih, kering, dll)"></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Foto Sampah</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload foto</span>
                                            <input id="file-upload" name="file-upload" type="file" class="sr-only">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Penjemputan</label>
                                <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Alamat lengkap">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Tersedia</label>
                                <input type="date" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        
                        <div class="pt-4 border-t border-gray-200 flex justify-end space-x-3">
                            <button type="button" class="px-4 py-2 border rounded-md text-sm hover:bg-gray-100">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600">Posting Penawaran</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Order Detail Modal -->
    <div id="orderDetailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Detail Pesanan #TRX-20250515-001</h3>
                    <button id="closeOrderModal" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-medium text-gray-900 mb-3">Informasi Produk</h4>
                            <div class="flex items-start space-x-4">
                                <img src="https://images.unsplash.com/photo-1583994009785-37ec30bf934b?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Plastik PET" class="w-16 h-16 object-cover rounded">
                                <div>
                                    <p class="font-medium">Plastik PET Bersih</p>
                                    <p class="text-sm text-gray-500">25 kg @ Rp 7.500</p>
                                    <p class="text-sm text-gray-500 mt-1">Kondisi: Bersih, sudah dicuci dan dikeringkan</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="font-medium text-gray-900 mb-3">Informasi Pembeli</h4>
                            <div class="space-y-2">
                                <p class="font-medium">UMKM Daur Ulang Jaya</p>
                                <p class="text-sm text-gray-500">
                                    <i class="fas fa-map-marker-alt mr-2"></i>Jl. Industri No. 123, Jakarta
                                </p>
                                <p class="text-sm text-gray-500">
                                    <i class="fas fa-phone-alt mr-2"></i>0812-3456-7890
                                </p>
                                <p class="text-sm text-gray-500">
                                    <i class="fas fa-envelope mr-2"></i>daurulangjaya@example.com
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4">
                        <h4 class="font-medium text-gray-900 mb-3">Ringkasan Pembayaran</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <p class="text-sm text-gray-500">Subtotal</p>
                                <p class="text-sm">Rp 187.500</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-sm text-gray-500">Biaya Pengiriman</p>
                                <p class="text-sm">Rp 15.000</p>
                            </div>
                            <div class="flex justify-between border-t border-gray-200 pt-2">
                                <p class="font-medium">Total</p>
                                <p class="font-medium text-blue-600">Rp 202.500</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4">
                        <h4 class="font-medium text-gray-900 mb-3">Status Pengiriman</h4>
                        <div class="stepper">
                            <div class="step completed">
                                <div class="step-number">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="step-title">Pesanan Dibuat</div>
                            </div>
                            <div class="step completed">
                                <div class="step-number">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="step-title">Pembayaran</div>
                            </div>
                            <div class="step active">
                                <div class="step-number">3</div>
                                <div class="step-title">Pengiriman</div>
                            </div>
                            <div class="step">
                                <div class="step-number">4</div>
                                <div class="step-title">Selesai</div>
                            </div>
                        </div>
                        
                        <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-truck text-blue-500 mr-3"></i>
                                <div>
                                    <p class="font-medium text-sm">Paket sedang dalam perjalanan</p>
                                    <p class="text-xs text-gray-500">No. Resi: JNE-1234567890</p>
                                    <p class="text-xs text-gray-500 mt-1">Estimasi tiba: 18 Mei 2025</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4">
                        <h4 class="font-medium text-gray-900 mb-3">Chat dengan Pembeli</h4>
                        <div class="space-y-3 max-h-40 overflow-y-auto p-2">
                            <div class="chat-bubble received">
                                <p class="text-sm">Halo, apakah sampah plastiknya sudah dipacking dengan baik?</p>
                                <p class="text-xs text-gray-400 mt-1 text-right">10:30 AM</p>
                            </div>
                            <div class="chat-bubble sent">
                                <p class="text-sm">Sudah pak, sudah dipacking dalam karung dan siap dikirim</p>
                                <p class="text-xs text-gray-300 mt-1 text-right">10:32 AM</p>
                            </div>
                            <div class="chat-bubble received">
                                <p class="text-sm">Baik, kami akan proses pembayaran hari ini juga</p>
                                <p class="text-xs text-gray-400 mt-1 text-right">10:35 AM</p>
                            </div>
                        </div>
                        <div class="mt-3 flex">
                            <input type="text" class="flex-1 border border-gray-300 rounded-l-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ketik pesan...">
                            <button class="px-3 py-2 bg-blue-500 text-white rounded-r-md hover:bg-blue-600">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 flex justify-end space-x-3">
                        <button class="px-4 py-2 border rounded-md text-sm hover:bg-gray-100">Cetak Invoice</button>
                        <button class="px-4 py-2 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600">Lacak Pengiriman</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching functionality
            document.getElementById('marketplaceTab').addEventListener('click', function() {
                document.getElementById('marketplaceContent').classList.remove('hidden');
                document.getElementById('mySalesContent').classList.add('hidden');
                document.getElementById('transactionsContent').classList.add('hidden');
                
                // Update active tab
                this.classList.add('text-blue-600', 'border-blue-600');
                this.classList.remove('text-gray-500');
                
                document.getElementById('mySalesTab').classList.add('text-gray-500');
                document.getElementById('mySalesTab').classList.remove('text-blue-600', 'border-blue-600');
                
                document.getElementById('transactionsTab').classList.add('text-gray-500');
                document.getElementById('transactionsTab').classList.remove('text-blue-600', 'border-blue-600');
            });
            
            document.getElementById('mySalesTab').addEventListener('click', function() {
                document.getElementById('marketplaceContent').classList.add('hidden');
                document.getElementById('mySalesContent').classList.remove('hidden');
                document.getElementById('transactionsContent').classList.add('hidden');
                
                // Update active tab
                this.classList.add('text-blue-600', 'border-blue-600');
                this.classList.remove('text-gray-500');
                
                document.getElementById('marketplaceTab').classList.add('text-gray-500');
                document.getElementById('marketplaceTab').classList.remove('text-blue-600', 'border-blue-600');
                
                document.getElementById('transactionsTab').classList.add('text-gray-500');
                document.getElementById('transactionsTab').classList.remove('text-blue-600', 'border-blue-600');
            });
            
            document.getElementById('transactionsTab').addEventListener('click', function() {
                document.getElementById('marketplaceContent').classList.add('hidden');
                document.getElementById('mySalesContent').classList.add('hidden');
                document.getElementById('transactionsContent').classList.remove('hidden');
                
                // Update active tab
                this.classList.add('text-blue-600', 'border-blue-600');
                this.classList.remove('text-gray-500');
                
                document.getElementById('marketplaceTab').classList.add('text-gray-500');
                document.getElementById('marketplaceTab').classList.remove('text-blue-600', 'border-blue-600');
                
                document.getElementById('mySalesTab').classList.add('text-gray-500');
                document.getElementById('mySalesTab').classList.remove('text-blue-600', 'border-blue-600');
            });
            
            // Create listing modal
            document.getElementById('createListingBtn').addEventListener('click', function() {
                document.getElementById('createListingModal').classList.remove('hidden');
            });
            
            document.getElementById('closeCreateModal').addEventListener('click', function() {
                document.getElementById('createListingModal').classList.add('hidden');
            });
            
            // Order detail modal
            const viewDetailButtons = document.querySelectorAll('[data-order-detail]');
            viewDetailButtons.forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('orderDetailModal').classList.remove('hidden');
                });
            });
            
            document.getElementById('closeOrderModal').addEventListener('click', function() {
                document.getElementById('orderDetailModal').classList.add('hidden');
            });
            
            // Form submission
            document.getElementById('listingForm').addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Penawaran berhasil diposting!');
                document.getElementById('createListingModal').classList.add('hidden');
                // In a real app, you would submit the form data to the server here
            });
            
            // Sidebar toggle functionality
            document.querySelector('.toggle-collapse').addEventListener('click', function() {
                const sidebar = document.querySelector('.sidebar');
                sidebar.classList.toggle('collapsed');
                const icon = this.querySelector('i');
                
                if (sidebar.classList.contains('collapsed')) {
                    icon.classList.remove('fa-chevron-left');
                    icon.classList.add('fa-chevron-right');
                    document.querySelector('.main-content').style.marginLeft = '80px';
                    document.querySelector('.main-content').style.width = 'calc(100% - 80px)';
                } else {
                    icon.classList.remove('fa-chevron-right');
                    icon.classList.add('fa-chevron-left');
                    document.querySelector('.main-content').style.marginLeft = '280px';
                    document.querySelector('.main-content').style.width = 'calc(100% - 280px)';
                }
            });
            
            // Logout functionality
            document.getElementById('logoutBtn').addEventListener('click', function() {
                if (confirm('Apakah Anda yakin ingin logout?')) {
                    // Show loading
                    this.innerHTML = '<div class="loading-spinner mr-2"></div> Logging out...';
                    
                    // Simulate logout process
                    setTimeout(() => {
                        // Redirect to login page
                        window.location.href = '/login';
                    }, 1000);
                }
            });
        });
    </script>
</body>
</html>