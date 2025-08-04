<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Penjemputan Sampah - Bijak Sampah</title>
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
            width: 100%;
            margin-left: 0;
            margin-right: 0;
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

    /* Stats Cards */
    .stats-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
            margin-bottom: 60px;
    }

    .stat-card {
      background: white;
      border-radius: 12px;
            padding: 30px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      display: flex;
      align-items: center;
            gap: 25px;
      transition: all 0.3s;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    .stat-icon {
      width: 60px;
      height: 60px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      color: white;
    }

    .stat-card:nth-child(1) .stat-icon {
      background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
    }

    .stat-card:nth-child(2) .stat-icon {
      background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
    }

    .stat-card:nth-child(3) .stat-icon {
      background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    }

    .stat-card:nth-child(4) .stat-icon {
      background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);
    }

    .stat-info h3 {
      font-size: 14px;
      color: #6b7280;
      margin-bottom: 5px;
    }

    .stat-number {
      font-size: 32px;
      font-weight: 700;
      color: var(--primary-color);
      margin: 0;
    }

    /* Data Table */
    .data-table-section {
      background: white;
      border-radius: 12px;
            padding: 30px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-top: 50px;
    }

    .table-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
            margin-bottom: 30px;
    }

    .table-header h2 {
      font-size: 20px;
      font-weight: 600;
      color: var(--primary-color);
    }

    .table-actions {
      display: flex;
            gap: 20px;
    }

    .search-input {
      padding: 8px 16px;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      font-size: 14px;
    }

    .filter-select {
      padding: 8px 16px;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      font-size: 14px;
      background: white;
    }

    .status-badge {
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
    }

    .status-badge.waiting {
      background-color: #fef3c7;
      color: #92400e;
    }

    .status-badge.process {
      background-color: #dbeafe;
      color: #1e40af;
    }

    .status-badge.completed {
      background-color: #d1fae5;
      color: #065f46;
    }

    .btn-action {
      background: none;
      border: none;
      color: #6b7280;
      cursor: pointer;
      padding: 4px 8px;
      border-radius: 4px;
      transition: all 0.3s;
    }

    .btn-action:hover {
      background-color: #f3f4f6;
      color: var(--primary-color);
    }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent-color) 0%, #ff8a4c 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(241, 103, 40, 0.3);
        }

        /* Full Width Styles */
        .stats-cards {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .data-table-section {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .data-table th,
        .data-table td {
            word-wrap: break-word;
            max-width: 200px;
        }

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

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            
            .stats-cards {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .table-actions {
                flex-direction: column;
                gap: 10px;
            }
            
            .search-input, .filter-select {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .table-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .table-actions {
                width: 100%;
                justify-content: flex-start;
            }
        }
    </style>
</head>
<body class="bg-gray-50">

<div class="flex min-h-screen bg-gray-50 w-full" x-data="{ sidebarOpen: false, activeMenu: 'penjemputan-sampah' }" x-init="activeMenu = 'penjemputan-sampah'">
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
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 bg-white/20 shadow-sm"
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
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
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
    <div class="main-content" :class="sidebarOpen ? 'pl-24' : 'pl-24'" style="transition: padding-left 0.3s ease; width: 100%;">
        {{-- Top Header Bar --}}
        <div class="fixed top-0 left-0 right-0 h-12 z-40 flex items-center justify-between px-6 text-white" :style="'padding-left:' + (sidebarOpen ? '16rem' : '4rem') + '; background: linear-gradient(135deg, #75E6DA 0%, #05445E 30%, #05445E 100%); width: 100%;'">
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
        <div class="p-6" style="padding-top: 20px; width: 100%; max-width: 100%;">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Penjemputan Sampah</h1>
                    <p class="text-sm text-gray-500">Kelola permintaan penjemputan sampah dari nasabah</p>
                </div>
                <button class="btn-primary" onclick="showAddPickupModal()">
                    <i class="fas fa-plus"></i> Tambah Penjemputan
                </button>
            </div>

      <div class="stats-cards">
        <div class="stat-card">
          <div class="stat-icon">
            <i class="fas fa-clock"></i>
          </div>
          <div class="stat-info">
            <h3>Menunggu</h3>
            <p class="stat-number">12</p>
          </div>
        </div>
        
        <div class="stat-card">
          <div class="stat-icon">
            <i class="fas fa-truck"></i>
          </div>
          <div class="stat-info">
            <h3>Dalam Proses</h3>
            <p class="stat-number">8</p>
          </div>
        </div>
        
        <div class="stat-card">
          <div class="stat-icon">
            <i class="fas fa-check-circle"></i>
          </div>
          <div class="stat-info">
            <h3>Selesai</h3>
            <p class="stat-number">45</p>
          </div>
        </div>
        
        <div class="stat-card">
          <div class="stat-icon">
            <i class="fas fa-calendar"></i>
          </div>
          <div class="stat-info">
            <h3>Hari Ini</h3>
            <p class="stat-number">15</p>
          </div>
        </div>
      </div>

      <div class="data-table-section">
        <div class="table-header">
          <h2>Daftar Penjemputan Sampah</h2>
          <div class="table-actions">
            <input type="text" placeholder="Cari..." class="search-input">
            <select class="filter-select">
              <option value="">Semua Status</option>
              <option value="menunggu">Menunggu</option>
              <option value="proses">Dalam Proses</option>
              <option value="selesai">Selesai</option>
            </select>
          </div>
        </div>

        <div class="table-container">
          <table class="data-table">
            <thead>
              <tr>
                <th>No</th>
                <th>Nasabah</th>
                <th>Alamat</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
                        <tbody id="pickupTableBody">
              <tr>
                <td>1</td>
                <td>Budi Santoso</td>
                <td>Jl. Sudirman No. 123, Jakarta</td>
                <td>15 Jan 2024</td>
                <td><span class="status-badge waiting">Menunggu</span></td>
                <td>
                                    <button class="btn-action" onclick="showViewPickupModal('Budi Santoso', 'Jl. Sudirman No. 123, Jakarta', '15 Jan 2024', 'Menunggu')"><i class="fas fa-eye"></i></button>
                                    <button class="btn-action" onclick="showEditPickupModal('Budi Santoso', 'Jl. Sudirman No. 123, Jakarta', '15 Jan 2024', 'Menunggu')"><i class="fas fa-edit"></i></button>
                </td>
              </tr>
              <tr>
                <td>2</td>
                <td>Siti Aminah</td>
                <td>Jl. Thamrin No. 45, Jakarta</td>
                <td>15 Jan 2024</td>
                <td><span class="status-badge process">Dalam Proses</span></td>
                <td>
                                    <button class="btn-action" onclick="showViewPickupModal('Siti Aminah', 'Jl. Thamrin No. 45, Jakarta', '15 Jan 2024', 'Dalam Proses')"><i class="fas fa-eye"></i></button>
                                    <button class="btn-action" onclick="showEditPickupModal('Siti Aminah', 'Jl. Thamrin No. 45, Jakarta', '15 Jan 2024', 'Dalam Proses')"><i class="fas fa-edit"></i></button>
                </td>
              </tr>
              <tr>
                <td>3</td>
                <td>Ahmad Hidayat</td>
                <td>Jl. Gatot Subroto No. 67, Jakarta</td>
                <td>14 Jan 2024</td>
                <td><span class="status-badge completed">Selesai</span></td>
                <td>
                                    <button class="btn-action" onclick="showViewPickupModal('Ahmad Hidayat', 'Jl. Gatot Subroto No. 67, Jakarta', '14 Jan 2024', 'Selesai')"><i class="fas fa-eye"></i></button>
                                    <button class="btn-action" onclick="showEditPickupModal('Ahmad Hidayat', 'Jl. Gatot Subroto No. 67, Jakarta', '14 Jan 2024', 'Selesai')"><i class="fas fa-edit"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
                </div>
        </div>
      </div>
    </div>
  </div>

<!-- Add Pickup Modal -->
<div class="modal" id="addPickupModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tambah Penjemputan Sampah</h3>
            <button class="modal-close" onclick="closeModal('addPickupModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="addPickupForm">
                <div class="form-group">
                    <label>Nama Nasabah</label>
                    <input type="text" id="customerName" placeholder="Masukkan nama nasabah" required>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea id="customerAddress" placeholder="Masukkan alamat lengkap" required></textarea>
                </div>
                <div class="form-group">
                    <label>Tanggal Penjemputan</label>
                    <input type="date" id="pickupDate" required>
                </div>
                <div class="form-group">
                    <label>Waktu Penjemputan</label>
                    <input type="time" id="pickupTime" required>
                </div>
                <div class="form-group">
                    <label>Jenis Sampah</label>
                    <select id="wasteType" required>
                        <option value="">Pilih jenis sampah</option>
                        <option value="organik">Sampah Organik</option>
                        <option value="anorganik">Sampah Anorganik</option>
                        <option value="campuran">Sampah Campuran</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Catatan</label>
                    <textarea id="notes" placeholder="Catatan tambahan (opsional)"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('addPickupModal')">Batal</button>
            <button class="btn btn-success" onclick="submitAddPickup()">Simpan</button>
        </div>
    </div>
</div>

<!-- View Pickup Modal -->
<div class="modal" id="viewPickupModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Detail Penjemputan Sampah</h3>
            <button class="modal-close" onclick="closeModal('viewPickupModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Nama Nasabah</label>
                <input type="text" id="viewCustomerName" readonly>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea id="viewCustomerAddress" readonly></textarea>
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="text" id="viewPickupDate" readonly>
            </div>
            <div class="form-group">
                <label>Status</label>
                <input type="text" id="viewPickupStatus" readonly>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('viewPickupModal')">Tutup</button>
        </div>
    </div>
</div>

<!-- Edit Pickup Modal -->
<div class="modal" id="editPickupModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Penjemputan Sampah</h3>
            <button class="modal-close" onclick="closeModal('editPickupModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="editPickupForm">
                <div class="form-group">
                    <label>Nama Nasabah</label>
                    <input type="text" id="editCustomerName" required>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea id="editCustomerAddress" required></textarea>
                </div>
                <div class="form-group">
                    <label>Tanggal Penjemputan</label>
                    <input type="date" id="editPickupDate" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select id="editPickupStatus" required>
                        <option value="Menunggu">Menunggu</option>
                        <option value="Dalam Proses">Dalam Proses</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Catatan</label>
                    <textarea id="editNotes" placeholder="Catatan tambahan"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('editPickupModal')">Batal</button>
            <button class="btn btn-success" onclick="submitEditPickup()">Update</button>
        </div>
    </div>
</div>
  
  <script>
    // Variable untuk tracking data yang sedang diedit
    let currentEditRow = null;
    
    // Show Add Pickup Modal
    function showAddPickupModal() {
        document.getElementById('addPickupModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    // Show View Pickup Modal
    function showViewPickupModal(customerName, address, date, status) {
        document.getElementById('viewCustomerName').value = customerName;
        document.getElementById('viewCustomerAddress').value = address;
        document.getElementById('viewPickupDate').value = date;
        document.getElementById('viewPickupStatus').value = status;
        document.getElementById('viewPickupModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    // Show Edit Pickup Modal
    function showEditPickupModal(customerName, address, date, status) {
        document.getElementById('editCustomerName').value = customerName;
        document.getElementById('editCustomerAddress').value = address;
        document.getElementById('editPickupDate').value = date;
        document.getElementById('editPickupStatus').value = status;
        document.getElementById('editPickupModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Simpan referensi ke row yang sedang diedit
        currentEditRow = customerName;
    }

    // Close Modal
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Submit Add Pickup
    function submitAddPickup() {
        const customerName = document.getElementById('customerName').value;
        const customerAddress = document.getElementById('customerAddress').value;
        const pickupDate = document.getElementById('pickupDate').value;
        const pickupTime = document.getElementById('pickupTime').value;
        const wasteType = document.getElementById('wasteType').value;
        const notes = document.getElementById('notes').value;

        if (!customerName || !customerAddress || !pickupDate || !pickupTime || !wasteType) {
            alert('Harap isi semua field yang wajib!');
            return;
        }

        // Tambah data ke table
        addPickupToTable(customerName, customerAddress, pickupDate, 'Menunggu');
        
        // Simulasi penyimpanan data
        alert('Penjemputan sampah berhasil ditambahkan!');
        closeModal('addPickupModal');
        
        // Reset form
        document.getElementById('addPickupForm').reset();
    }

    // Function untuk menambah data ke table
    function addPickupToTable(customerName, address, date, status) {
        const tableBody = document.getElementById('pickupTableBody');
        const rowCount = tableBody.rows.length;
        const newRow = tableBody.insertRow();
        
        // Format tanggal
        const dateObj = new Date(date);
        const formattedDate = dateObj.toLocaleDateString('id-ID', { 
            day: '2-digit', 
            month: 'short', 
            year: 'numeric' 
        });
        
        // Status badge class
        let statusClass = 'waiting';
        if (status === 'Dalam Proses') statusClass = 'process';
        if (status === 'Selesai') statusClass = 'completed';
        
        newRow.innerHTML = `
            <td>${rowCount + 1}</td>
            <td>${customerName}</td>
            <td>${address}</td>
            <td>${formattedDate}</td>
            <td><span class="status-badge ${statusClass}">${status}</span></td>
            <td>
                <button class="btn-action" onclick="showViewPickupModal('${customerName}', '${address}', '${formattedDate}', '${status}')"><i class="fas fa-eye"></i></button>
                <button class="btn-action" onclick="showEditPickupModal('${customerName}', '${address}', '${formattedDate}', '${status}')"><i class="fas fa-edit"></i></button>
            </td>
        `;
    }

    // Submit Edit Pickup
    function submitEditPickup() {
        const customerName = document.getElementById('editCustomerName').value;
        const customerAddress = document.getElementById('editCustomerAddress').value;
        const pickupDate = document.getElementById('editPickupDate').value;
        const status = document.getElementById('editPickupStatus').value;
        const notes = document.getElementById('editNotes').value;

        if (!customerName || !customerAddress || !pickupDate || !status) {
            alert('Harap isi semua field yang wajib!');
            return;
        }

        // Update data di table
        updatePickupInTable(customerName, customerAddress, pickupDate, status);
        
        // Simulasi update data
        alert('Data penjemputan sampah berhasil diupdate!');
        closeModal('editPickupModal');
    }

    // Function untuk update data di table
    function updatePickupInTable(customerName, address, date, status) {
        const tableBody = document.getElementById('pickupTableBody');
        const rows = tableBody.getElementsByTagName('tr');
        
        // Cari row yang sesuai dengan nama customer (gunakan currentEditRow jika ada)
        const targetCustomer = currentEditRow || customerName;
        
        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            if (cells.length > 0 && cells[1].textContent === targetCustomer) {
                // Format tanggal
                const dateObj = new Date(date);
                const formattedDate = dateObj.toLocaleDateString('id-ID', { 
                    day: '2-digit', 
                    month: 'short', 
                    year: 'numeric' 
                });
                
                // Status badge class
                let statusClass = 'waiting';
                if (status === 'Dalam Proses') statusClass = 'process';
                if (status === 'Selesai') statusClass = 'completed';
                
                // Update cells
                cells[1].textContent = customerName; // Update nama jika berubah
                cells[2].textContent = address;
                cells[3].textContent = formattedDate;
                cells[4].innerHTML = `<span class="status-badge ${statusClass}">${status}</span>`;
                
                // Update onclick functions
                const viewBtn = cells[5].querySelector('button:first-child');
                const editBtn = cells[5].querySelector('button:last-child');
                viewBtn.onclick = () => showViewPickupModal(customerName, address, formattedDate, status);
                editBtn.onclick = () => showEditPickupModal(customerName, address, formattedDate, status);
                
                // Reset currentEditRow
                currentEditRow = null;
                break;
            }
        }
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const modals = ['addPickupModal', 'viewPickupModal', 'editPickupModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (event.target === modal) {
                closeModal(modalId);
            }
        });
    });

    // Search functionality
    document.querySelector('.search-input').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('.data-table tbody tr');
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
      } else {
                row.style.display = 'none';
            }
        });
    });

    // Filter functionality
    document.querySelector('.filter-select').addEventListener('change', function() {
        const filterValue = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('.data-table tbody tr');
        
        tableRows.forEach(row => {
            const statusCell = row.querySelector('.status-badge');
            if (statusCell) {
                const status = statusCell.textContent.toLowerCase();
                if (filterValue === '' || status.includes(filterValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });
  </script>
</body>
</html>
