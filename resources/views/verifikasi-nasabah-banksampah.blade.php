<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Verifikasi Nasabah - Bijak Sampah</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-firestore.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>
    <!-- Tambahkan EmailJS SDK di bagian <head> setelah Firebase SDK -->
    <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
    <script>
        // Firebase Configuration
        const firebaseConfig = {
            apiKey: "AIzaSyAJhkCyNT0be2x6FSzyUz0Ye9xX-QihIBo",
            authDomain: "bijaksampah-aeb82.firebaseapp.com",
            databaseURL: "https://bijaksampah-aeb82-default-rtdb.asia-southeast1.firebasedatabase.app",
            projectId: "bijaksampah-aeb82",
            storageBucket: "bijaksampah-aeb82.firebasestorage.app",
            messagingSenderId: "140467230562",
            appId: "1:140467230562:web:19a34dfefcb6f65bd7fe3b"
        };

        // Initialize Firebase (v8 syntax)
        firebase.initializeApp(firebaseConfig);
        const database = firebase.database();

        // Initialize Alpine.js with Collapse plugin
        document.addEventListener('alpine:init', () => {
            console.log('Alpine.js initialized with Collapse plugin');
        });

        window.addEventListener('load', function() {
            console.log('Window loaded, Chart.js available:', typeof Chart !== 'undefined');
            console.log('Firebase database object:', database);
            console.log('Firebase database ref:', database.ref);
            
            console.log('🚀 Starting Firebase connection test...');
            
            // Skip root access test since rules don't allow it
            // Go directly to load users verification data
            console.log('🎯 Going directly to load users verification data...');
            loadUsersData();
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

        /* Alpine.js Collapse Animation */
        [x-cloak] {
            display: none !important;
        }

        .collapse-transition {
            transition: all 0.3s ease;
    }

    /* Table Styles */
    .customers-container {
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            width: 100%;
    }

    .table-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
            width: 100%;
    }

    .search-sort {
      display: flex;
      gap: 15px;
            width: 100%;
            justify-content: flex-end;
    }

    .search {
      position: relative;
    }

    .search input {
      padding: 10px 15px 10px 35px;
      border: 1px solid #ddd;
      border-radius: 8px;
      width: 250px;
            min-width: 200px;
    }

    .search i {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #999;
    }

    .sort select {
      padding: 10px 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
      background-color: #fff;
            min-width: 150px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
            margin: 0;
            padding: 0;
    }

    th, td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #eee;
            word-wrap: break-word;
            max-width: 200px;
    }

    th {
      font-weight: 600;
      color: var(--primary-color);
    }

    tr:hover {
      background-color: #f5f5f5;
    }

    .btn-review {
      padding: 6px 12px;
      background-color: #fee2e2;
      color: #dc2626;
      border: none;
      border-radius: 6px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s;
    }

    .btn-review:hover {
      background-color: #fecaca;
    }

    /* Pagination */
    .pagination {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 20px;
      font-size: 14px;
      color: #666;
    }

    .pagination-controls {
      display: flex;
      gap: 8px;
    }

    .pagination-btn {
      padding: 6px 12px;
      border: 1px solid #ddd;
      border-radius: 6px;
      cursor: pointer;
      transition: all 0.3s;
    }

    .pagination-btn:hover {
      background-color: #f0f0f0;
    }

    .pagination-btn.active {
      background-color: var(--primary-color);
      color: white;
      border-color: var(--primary-color);
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

    .form-group input, .form-group select {
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

    .btn-primary {
      background-color: var(--primary-color);
      color: white;
      border: none;
    }

    .btn-primary:hover {
      background-color: #04384e;
    }

    .btn-secondary {
      background-color: #e5e7eb;
      color: #333;
      border: none;
    }

    .btn-secondary:hover {
      background-color: #d1d5db;
    }

    .btn-danger {
      background-color: var(--danger-color);
      color: white;
      border: none;
    }

    .btn-danger:hover {
      background-color: #a33226;
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
            
            .search-sort {
                flex-direction: column;
                gap: 10px;
            }
            
            .search input {
                width: 100%;
                min-width: auto;
            }
            
            .sort select {
                width: 100%;
                min-width: auto;
            }
            
            .customers-container {
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            .table-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .search-sort {
                width: 100%;
                justify-content: flex-start;
            }
        }



    /* Step Indicator */
    .step-indicator {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }

    .step {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background-color: #e5e7eb;
      color: #6b7280;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      margin: 0 10px;
      position: relative;
    }

    .step.active {
      background-color: var(--primary-color);
      color: white;
    }

    .step.completed {
      background-color: var(--success-color);
      color: white;
    }

    .step-line {
      flex: 1;
      height: 2px;
      background-color: #e5e7eb;
      margin: 0 -10px;
      position: relative;
      top: 15px;
    }

    .step-line.completed {
      background-color: var(--success-color);
    }

    /* Trash Bin Registration Form */
    .trash-bin-form {
      display: none;
    }

    /* Success Message */
    .success-message {
      display: none;
      text-align: center;
      padding: 40px;
    }

    .success-icon {
      font-size: 60px;
      color: var(--success-color);
      margin-bottom: 20px;
    }

    .success-title {
      font-size: 24px;
      font-weight: 600;
      color: var(--primary-color);
      margin-bottom: 10px;
    }

    .success-details {
      color: #555;
      margin-bottom: 20px;
    }

    .success-account {
      background-color: #f0f7ff;
      padding: 15px;
      border-radius: 8px;
      margin-top: 20px;
      text-align: left;
    }

    .success-account p {
      margin: 5px 0;
    }
  </style>
</head>
<body class="bg-gray-50">

        <div class="flex min-h-screen bg-gray-50 w-full" x-data="{ sidebarOpen: false, activeMenu: 'verifikasi-nasabah' }" x-init="activeMenu = 'verifikasi-nasabah'">
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
                    <div x-show="expanded && sidebarOpen" x-cloak x-collapse.duration.300ms class="pl-6 pt-2 space-y-1">
                        <a 
                            href="{{ route('verifikasi-nasabah-banksampah') }}" 
                            class="flex items-center gap-3 p-2 rounded-lg whitespace-nowrap w-full text-sm hover:bg-white/10 hover:shadow-sm transition-colors duration-200 bg-white/20"
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
                    <div x-show="expanded && sidebarOpen" x-cloak x-collapse.duration.300ms class="pl-6 pt-2 space-y-1">
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
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Verifikasi Nasabah</h1>
                <p class="text-gray-600">Kelola verifikasi data nasabah bank sampah</p>
            </div>

            <!-- Action Bar -->
            <div class="flex justify-between items-center mb-6">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari nasabah..." 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-80">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-gray-600">Sort by:</span>
                    <select id="sortSelect" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                        <option value="email">Email</option>
                        <option value="role">Role</option>
                    </select>
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nasabah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody" class="bg-white divide-y divide-gray-200">
                            <!-- Data will be populated here by JavaScript -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination and Summary -->
                <div class="px-6 py-3 border-t border-gray-200 flex justify-between items-center">
                    <div class="text-sm text-gray-700">
                        Showing data <span id="startEntry">1</span> to <span id="endEntry">5</span> of <span id="totalEntries">0</span> entries
                    </div>
                    <div class="flex items-center space-x-2">
                        <button id="prevPage" class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">&lt;</button>
                        <div id="pageNumbers" class="flex space-x-1">
                            <!-- Page numbers will be generated here -->
                        </div>
                        <button id="nextPage" class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">&gt;</button>
                    </div>
                </div>
            </div>
        </div>

  <!-- Address Verification Modal (LEGACY - REMOVED) -->

  <!-- Personal Data Verification Modal (LEGACY - REMOVED) -->

  <!-- Trash Bin Registration Modal (LEGACY - REMOVED) -->
  
  <!-- Success Message Modal (LEGACY - REMOVED) -->

  <script>
    // Current customer data
    let currentCustomerData = null;
    
    // Global variables for pagination and filtering
    let allVerificationData = [];
    let currentPage = 1;
    const itemsPerPage = 5;
    let filteredData = [];

            // Fallback data for testing when Firebase is not available
        const dummyData = [
            {
                id: 'dummy1',
                name: 'John Doe',
                email: 'john@example.com',
                role: 'Nasabah',
                createdAt: Date.now() - 86400000, // 1 day ago
                status: 'pending'
            },
            {
                id: 'dummy2',
                name: 'Jane Smith',
                email: 'jane@example.com',
                role: 'Nasabah',
                createdAt: Date.now() - 172800000, // 2 days ago
                status: 'pending'
            },
            {
                id: 'dummy3',
                name: 'Bob Johnson',
                email: 'bob@example.com',
                role: 'Nasabah',
                createdAt: Date.now() - 259200000, // 3 days ago
                status: 'pending'
            }
        ];

    // Function to load dummy data as fallback
    function loadDummyData() {
        console.log('Loading dummy data as fallback...');
        allVerificationData = [...dummyData];
        filteredData = [...dummyData];
        renderTableData(filteredData);
        updatePaginationInfo(filteredData.length);
    }

            // Function to load users verification data from Firebase
        async function loadUsersData() {
            try {
                console.log('🔥 Starting Firebase data load...');
                console.log('🎯 Targeting nodes: "users verification" + "users"');
                
                // 1. Load data dari "users verification" node
                const usersVerificationRef = database.ref('users verification');
                console.log('🔍 Accessing users verification node...');
                
                const verificationSnapshot = await usersVerificationRef.once('value');
                console.log('✅ Users verification access successful!');
                
                // 2. Load data lengkap dari "users" node
                const usersRef = database.ref('users');
                console.log('🔍 Accessing users node...');
                
                const usersSnapshot = await usersRef.once('value');
                console.log('✅ Users node access successful!');
                
                if (verificationSnapshot.exists() && usersSnapshot.exists()) {
                    const verificationData = verificationSnapshot.val();
                    const usersData = usersSnapshot.val();
                    const usersArray = [];
                    
                    console.log('📊 Verification data:', verificationData);
                    console.log('📊 Users data:', usersData);
                    
                    Object.keys(verificationData).forEach(userId => {
                        const verificationUser = verificationData[userId];
                        const fullUserData = usersData[userId] || {};
                        
                        // Hanya ambil user dengan role "Nasabah"
                        if (verificationUser.role === 'Nasabah') {
                            // Gabungkan data dari kedua node
                            const completeUser = {
                                id: userId,
                                // Data dari verification
                                email: verificationUser.email || fullUserData.email || 'No email',
                                role: verificationUser.role || 'Unknown',
                                verificationStatus: verificationUser.verificationStatus || 'pending',
                                // Data lengkap dari users node
                                firstName: fullUserData.firstName || verificationUser.firstName || 'N/A',
                                lastName: fullUserData.lastName || verificationUser.lastName || 'N/A',
                                phoneNumber: fullUserData.phone || fullUserData.phoneNumber || 'N/A',
                                dob: fullUserData.dob || 'N/A',
                                address: fullUserData.address || 'N/A',
                                city: fullUserData.city || 'N/A',
                                country: fullUserData.country || 'N/A',
                                accountNumber: fullUserData.accountNumber || 'N/A',
                                deviceId: fullUserData.deviceId || 'N/A',
                                createdAt: verificationUser.createdAt || fullUserData.createdAt || Date.now(),
                                status: verificationUser.status || 'pending'
                            };
                            
                            usersArray.push(completeUser);
                            console.log('👤 Complete user data:', completeUser);
                        }
                    });
                    
                    usersArray.sort((a, b) => b.createdAt - a.createdAt);
                    console.log('🎯 Processed complete NASABAH users data:', usersArray);
                    
                    allVerificationData = usersArray;
                    filteredData = usersArray;
                    renderTableData(filteredData);
                    updatePaginationInfo(filteredData.length);
                    
                    console.log('✅ Complete Firebase NASABAH data loaded and displayed successfully!');
                    console.log(`📊 Total NASABAH users loaded: ${usersArray.length}`);
                } else {
                    console.log('⚠️ One or both nodes are empty, loading dummy data...');
                    loadDummyData();
                }
                
            } catch (error) {
                console.error('💥 Error loading Firebase data:', error);
                console.log('🔄 Falling back to dummy data...');
                loadDummyData();
            }
        }
    
    // Function to display users in table (legacy - replaced by renderTableData)
    function displayUsersInTable(users) {
        // Use the new renderTableData function instead
        renderTableData(users);
    }
    
    // Function to update pagination info
    function updatePaginationInfo(totalUsers) {
        // This function is kept for compatibility but the new pagination system is used
        console.log('Total users:', totalUsers);
    }

    // Function to format timestamp to readable date
    function formatDate(timestamp) {
        const date = new Date(parseInt(timestamp));
        return date.toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    // Function to truncate long text
    function truncateText(text, maxLength = 12) {
        if (!text) return 'N/A';
        if (text.length <= maxLength) return text;
        return text.substring(0, maxLength) + '...';
    }

    // Function to render table data
    function renderTableData(data) {
        const tbody = document.getElementById('usersTableBody');
        tbody.innerHTML = '';

        if (data.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada data verifikasi yang ditemukan
                    </td>
                </tr>
            `;
            return;
        }

        // Filter hanya data dengan role "Nasabah"
        const nasabahData = data.filter(user => user.role === 'Nasabah');
        
        if (nasabahData.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada data verifikasi NASABAH yang ditemukan
                    </td>
                </tr>
            `;
            return;
        }
        
        nasabahData.forEach((user, index) => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50';
            
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-gray-600"></i>
                        </div>
                        <div class="ml-4">
                            <div class="text-xs font-mono text-gray-600 bg-gray-50 px-2 py-1 rounded-md border border-gray-200 cursor-help hover:bg-gray-100 transition-colors" 
                                 title="Full ID: ${user.id}">
                                <span class="text-gray-500">ID:</span> ${truncateText(user.id, 15)}
                            </div>
                            <div class="text-sm text-gray-500 mt-1">${user.role}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ${formatDate(user.createdAt)}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ${user.email}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${
                        user.role === 'Nasabah' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'
                    }">
                        ${user.role}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex space-x-2">
                        <button onclick="approveUser('${user.id}')" class="text-green-600 hover:text-green-900">
                            <i class="fas fa-check-circle"></i> Setujui
                        </button>
                        <button onclick="rejectUser('${user.id}')" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-times-circle"></i> Tolak
                        </button>
                        <button onclick="viewDetails('${user.id}')" class="text-blue-600 hover:text-blue-900">
                            <i class="fas fa-eye"></i> Detail
                        </button>
                    </div>
                </td>
            `;
            
            tbody.appendChild(row);
        });
    }

    // Function to update pagination
    function updatePagination() {
        const totalPages = Math.ceil(filteredData.length / itemsPerPage);
        const startEntry = (currentPage - 1) * itemsPerPage + 1;
        const endEntry = Math.min(currentPage * itemsPerPage, filteredData.length);
        
        document.getElementById('startEntry').textContent = startEntry;
        document.getElementById('endEntry').textContent = endEntry;
        document.getElementById('totalEntries').textContent = filteredData.length;
        
        // Update page numbers
        const pageNumbersContainer = document.getElementById('pageNumbers');
        pageNumbersContainer.innerHTML = '';
        
        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement('button');
            pageButton.className = `px-3 py-1 border rounded ${
                i === currentPage 
                    ? 'bg-blue-600 text-white border-blue-600' 
                    : 'border-gray-300 hover:bg-gray-50'
            }`;
            pageButton.textContent = i;
            pageButton.onclick = () => goToPage(i);
            pageNumbersContainer.appendChild(pageButton);
        }
        
        // Update navigation buttons
        document.getElementById('prevPage').disabled = currentPage === 1;
        document.getElementById('nextPage').disabled = currentPage === totalPages;
    }

    // Function to go to specific page
    function goToPage(page) {
        currentPage = page;
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const pageData = filteredData.slice(startIndex, endIndex);
        renderTableData(pageData);
        updatePagination();
    }

    // Function to go to next page
    function nextPage() {
        if (currentPage < Math.ceil(filteredData.length / itemsPerPage)) {
            goToPage(currentPage + 1);
        }
    }

    // Function to go to previous page
    function prevPage() {
        if (currentPage > 1) {
            goToPage(currentPage - 1);
        }
    }

    // Function to search and filter data
    function searchAndFilter() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const sortBy = document.getElementById('sortSelect').value;
        
        filteredData = allVerificationData.filter(user => 
            user.role === 'Nasabah' && (
                user.email.toLowerCase().includes(searchTerm) ||
                user.role.toLowerCase().includes(searchTerm) ||
                user.id.toLowerCase().includes(searchTerm)
            )
        );
        
        // Sort data
        filteredData.sort((a, b) => {
            switch (sortBy) {
                case 'newest':
                    return b.createdAt - a.createdAt;
                case 'oldest':
                    return a.createdAt - b.createdAt;
                case 'email':
                    return a.email.localeCompare(b.email);
                case 'role':
                    return a.role.localeCompare(b.role);
                default:
                    return 0;
            }
        });
        
        currentPage = 1;
        const startIndex = 0;
        const endIndex = itemsPerPage;
        const pageData = filteredData.slice(startIndex, endIndex);
        renderTableData(pageData);
        updatePagination();
    }

    // Action functions
    function approveUser(userId) {
        const user = allVerificationData.find(u => u.id === userId);
        if (!user) {
            alert('User tidak ditemukan!');
            return;
        }
        
        // Show verification modal
        showVerificationModal(user);
    }

    function rejectUser(userId) {
        if (confirm('Apakah Anda yakin ingin menolak user ini?')) {
            // Here you would implement the rejection logic
            // For now, just show an alert
            alert(`User ${userId} telah ditolak`);
            // You can add Firebase update logic here
        }
    }

    function viewDetails(userId) {
        const user = allVerificationData.find(u => u.id === userId);
        if (user) {
            alert(`Detail User:\nID: ${user.id}\nEmail: ${user.email}\nRole: ${user.role}\nTanggal: ${formatDate(user.createdAt)}`);
        }
    }

    // ===== MODAL VERIFIKASI BANK SAMPAH =====
    
    // Show verification modal
    function showVerificationModal(user) {
        console.log("🔍 Data user untuk verifikasi:", user);
        
        // Create modal HTML dengan data lengkap dari Firebase
        const modalHTML = `
            <div id="verificationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                <div class="relative top-10 mx-auto p-5 border w-[600px] shadow-lg rounded-md bg-white">
                    <div class="mt-3">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl leading-6 font-medium text-gray-900 text-center mb-6">Verifikasi Nasabah</h3>
                        
                        <!-- Data Nasabah dari Firebase -->
                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <h4 class="font-semibold text-gray-800 mb-3 text-center">📋 Data Nasabah</h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-gray-600">Nama:</span><br>
                                    <span class="text-gray-800">${user.firstName || 'N/A'} ${user.lastName || 'N/A'}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Email:</span><br>
                                    <span class="text-gray-800">${user.email || 'N/A'}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">No. Telepon:</span><br>
                                    <span class="text-gray-800">${user.phoneNumber || 'N/A'}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Tanggal Lahir:</span><br>
                                    <span class="text-gray-800">${user.dob || 'N/A'}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Alamat:</span><br>
                                    <span class="text-gray-800">${user.address || 'N/A'}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Kota:</span><br>
                                    <span class="text-gray-800">${user.city || 'N/A'}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">No. Rekening:</span><br>
                                    <span class="text-gray-800">${user.accountNumber || 'N/A'}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Role:</span><br>
                                    <span class="text-blue-600 font-medium">${user.role || 'N/A'}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Input Verifikasi -->
                        <div class="mb-6">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">🆔 ID Alat (Random)</label>
                                <input type="text" id="deviceIdInput" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="Masukkan ID Alat" required>
                                <button onclick="generateRandomDeviceId()" 
                                        class="mt-2 px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                    🎲 Generate Random ID
                                </button>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">📝 Catatan (Opsional)</label>
                                <textarea id="notesInput" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                          placeholder="Catatan verifikasi..."></textarea>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex justify-center space-x-3">
                            <button onclick="closeVerificationModal()" 
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                ❌ Batal
                            </button>
                            <button onclick="confirmVerification('${user.id}')" 
                                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                ✅ Setujui & Kirim Email
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Add modal to body
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        
        // Auto-focus on device ID input
        setTimeout(() => {
            const deviceIdInput = document.getElementById('deviceIdInput');
            if (deviceIdInput) deviceIdInput.focus();
        }, 100);
    }
    
    // Close verification modal
    function closeVerificationModal() {
        const modal = document.getElementById('verificationModal');
        if (modal) {
            modal.remove();
        }
    }
    
    // Generate random device ID
    function generateRandomDeviceId() {
        const deviceIdInput = document.getElementById('deviceIdInput');
        const randomId = 'BS-' + Math.random().toString(36).substr(2, 9).toUpperCase();
        deviceIdInput.value = randomId;
    }
    
    // Confirm verification and send email
    async function confirmVerification(userId) {
        const deviceIdInput = document.getElementById('deviceIdInput');
        const notesInput = document.getElementById('notesInput');
        
        if (!deviceIdInput.value.trim()) {
            alert('ID Alat harus diisi!');
            deviceIdInput.focus();
            return;
        }
        
        const user = allVerificationData.find(u => u.id === userId);
        if (!user) {
            alert('User tidak ditemukan!');
            return;
        }
        
        try {
            // Show loading state
            const confirmBtn = document.querySelector('button[onclick="confirmVerification(\'' + userId + '\')"]');
            const originalText = confirmBtn.textContent;
            confirmBtn.textContent = 'Memproses...';
            confirmBtn.disabled = true;
            
            // 1. Update status di users verification
            await database.ref('users verification/' + user.email.replace(/\./g, ',')).update({
                verificationStatus: 'approved',
                approvedAt: Date.now(),
                approvedBy: 'Bank Sampah Admin',
                deviceId: deviceIdInput.value.trim(),
                notes: notesInput.value.trim()
            });
            
            // 2. Update status di users
            await database.ref('users/' + user.email.replace(/\./g, ',')).update({
                verificationStatus: 'approved',
                approvedAt: Date.now(),
                approvedBy: 'Bank Sampah Admin',
                deviceId: deviceIdInput.value.trim(),
                notes: notesInput.value.trim(),
                status: 'active'
            });
            
            // 3. Tampilkan preview email terlebih dahulu
            console.log("📧 Menampilkan preview email...");
            showEmailPreviewModal(user, deviceIdInput.value.trim());
            
            // Note: Email akan dikirim setelah user konfirmasi di preview modal
            
        } catch (error) {
            console.error('❌ Error saat verifikasi:', error);
            alert('Terjadi kesalahan saat verifikasi. Silakan coba lagi.');
        }
    }
    
    // Send verification success email
    async function sendVerificationSuccessEmail(user, deviceId) {
        try {
            console.log(`📧 Mulai mengirim email ke: ${user.email}`);
            console.log(`📧 From: infobijaksampah@gmail.com`);
            console.log(`🔑 Password default: 12345678bs`);
            
            // 1. Simpan log email ke Firebase
            const emailLog = {
                from: 'infobijaksampah@gmail.com',
                to: user.email,
                subject: 'Verifikasi Berhasil - Anda Resmi Jadi Nasabah Bijak Sampah!',
                message: generateVerificationSuccessEmailContent(user, deviceId),
                sentAt: Date.now(),
                status: 'sending',
                type: 'verification_success',
                credentials: {
                    username: user.email,
                    password: '12345678bs'
                }
            };

            console.log("💾 Menyimpan log email ke Firebase...");
            await database.ref('email_logs').child(user.email.replace(/[.#$[\]]/g, '_')).set(emailLog);
            
            // 2. Kirim email beneran dengan EmailJS
            console.log("📤 Mengirim email dengan EmailJS...");
            
            const emailParams = {
                // Variabel yang dibutuhkan template EmailJS
                recipient_email: user.email,
                recipient_name: `${user.firstName} ${user.lastName}`,
                device_id: deviceId,
                // Variabel tambahan untuk template
                username: user.email,
                password: '12345678bs',
                website_url: 'https://bijaksampah.com/login',
                // Variabel standar EmailJS (opsional)
                to_email: user.email,
                to_name: `${user.firstName} ${user.lastName}`,
                from_email: 'infobijaksampah@gmail.com',
                from_name: 'Bijak Sampah',
                subject: 'Verifikasi Berhasil - Anda Resmi Jadi Nasabah Bijak Sampah!',
                message: generateVerificationSuccessEmailContent(user, deviceId)
            };
            
            console.log("📧 EmailJS Params:", emailParams);
            console.log("🔑 Service ID:", 'service_mf897ra');
            console.log("🔑 Template ID:", 'template_64bk8sj');
            console.log("🔑 User ID:", 'QV-h6ByGM45FkOzZd');
            console.log("📧 Recipient Email:", emailParams.recipient_email);
            console.log("📧 Recipient Name:", emailParams.recipient_name);
            console.log("📧 Device ID:", emailParams.device_id);
            
            // Kirim email dengan Service ID dan Template ID yang sudah ada
            console.log("🚀 Memulai pengiriman email dengan EmailJS...");
            const result = await emailjs.send(
                'service_mf897ra', // Service ID yang sudah ada!
                'template_64bk8sj', // Template ID yang sudah ada!
                emailParams,
                'QV-h6ByGM45FkOzZd' // Ganti dengan User ID dari EmailJS dashboard
            );
            
            if (result.status === 200) {
                console.log("✅ Email berhasil dikirim dengan EmailJS!");
                
                // Update status di Firebase jadi 'sent'
                await database.ref('email_logs').child(user.email.replace(/[.#$[\]]/g, '_')).update({
                    status: 'sent',
                    emailjs_result: result
                });
                
                // Tampilkan notifikasi sukses
                showEmailSuccessNotification(user.email);
                return true;
            } else {
                throw new Error('EmailJS gagal mengirim email');
            }
            
        } catch (error) {
            console.error('❌ Error detail saat mengirim email:', error);
            console.error('❌ Error name:', error.name);
            console.error('❌ Error message:', error.message);
            console.error('❌ Error stack:', error.stack);
            
            // Update status di Firebase jadi 'failed'
            try {
                await database.ref('email_logs').child(user.email.replace(/[.#$[\]]/g, '_')).update({
                    status: 'failed',
                    error: error.message,
                    error_name: error.name,
                    error_stack: error.stack,
                    timestamp: Date.now()
                });
            } catch (firebaseError) {
                console.error('Error updating Firebase:', firebaseError);
            }
            
            return false;
        }
    }
    
    // Show email preview modal
    function showEmailPreviewModal(user, deviceId) {
        const modal = document.createElement('div');
        modal.id = 'emailPreviewModal';
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        `;

        const emailContent = generateVerificationSuccessEmailContent(user, deviceId);
        
        modal.innerHTML = `
            <div style="background: white; border-radius: 15px; max-width: 90%; max-height: 90%; overflow-y: auto; position: relative;">
                <div style="background: #05445E; color: white; padding: 20px; border-radius: 15px 15px 0 0; display: flex; justify-content: space-between; align-items: center;">
                    <h2 style="margin: 0;">📧 Preview Email Verifikasi</h2>
                    <button onclick="closeEmailPreviewModal()" style="background: none; border: none; color: white; font-size: 24px; cursor: pointer;">&times;</button>
                </div>
                
                <div style="padding: 20px;">
                    <div style="background: #e8f5e8; border-radius: 8px; padding: 15px; margin-bottom: 20px; border-left: 4px solid #28a745;">
                        <h4 style="margin: 0; color: #155724;">📤 Email akan dikirim dari:</h4>
                        <p style="margin: 5px 0; color: #155724;"><strong>infobijaksampah@gmail.com</strong></p>
                    </div>
                    
                    <div style="background: #e3f2fd; border-radius: 8px; padding: 15px; margin-bottom: 20px; border-left: 4px solid #2196f3;">
                        <h4 style="margin: 0; color: #0d47a1;">🔐 Kredensial Login:</h4>
                        <p style="margin: 5px 0; color: #0d47a1;"><strong>Username:</strong> ${user.email}</p>
                        <p style="margin: 5px 0; color: #0d47a1;"><strong>Password:</strong> 12345678bs</p>
                    </div>
                    
                    <div style="background: #fff3cd; border-radius: 8px; padding: 15px; margin-bottom: 20px; border-left: 4px solid #ffc107;">
                        <h4 style="margin: 0; color: #856404;">📧 Isi Email:</h4>
                        <p style="margin: 5px 0; color: #856404;">Email akan berisi informasi lengkap verifikasi dan kredensial login.</p>
                    </div>
                    
                    <div style="text-align: center; margin-top: 20px;">
                        <button onclick="closeEmailPreviewModal()" style="background: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 5px; margin-right: 10px; cursor: pointer;">Tutup Preview</button>
                        <button onclick="confirmSendEmail('${user.id}')" style="background: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Kirim Email Sekarang</button>
                    </div>
                </div>
            </div>
        `;

        document.body.appendChild(modal);
    }

    // Close email preview modal
    function closeEmailPreviewModal() {
        const modal = document.getElementById('emailPreviewModal');
        if (modal) {
            modal.remove();
        }
    }

    // Confirm and send email
    async function confirmSendEmail(userId) {
        const user = allVerificationData.find(u => u.id === userId);
        if (user) {
            closeEmailPreviewModal();
            
            try {
                // Trigger email sending
                const emailSent = await sendVerificationSuccessEmail(user, user.deviceId || 'SR-' + Math.random().toString(36).substr(2, 6).toUpperCase());
                
                if (emailSent) {
                    console.log("✅ Email berhasil dikirim!");
                    
                    // Close verification modal
                    closeVerificationModal();
                    
                    // Show success message
                    showSuccessMessage(`Nasabah ${user.firstName} ${user.lastName} berhasil diverifikasi! Email telah dikirim ke ${user.email}`);
                    
                    // Refresh data
                    await loadUsersData();
                } else {
                    console.log("⚠️ Email gagal dikirim, tapi verifikasi tetap berhasil");
                    
                    // Close verification modal
                    closeVerificationModal();
                    
                    // Show success message (tanpa email)
                    showSuccessMessage(`Nasabah ${user.firstName} ${user.lastName} berhasil diverifikasi! (Email gagal dikirim)`);
                    
                    // Refresh data
                    await loadUsersData();
                }
            } catch (error) {
                console.error('❌ Error saat mengirim email:', error);
                alert('Terjadi kesalahan saat mengirim email. Silakan coba lagi.');
            }
        }
    }

    // Show email success notification
    function showEmailSuccessNotification(email) {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            z-index: 10001;
            font-family: Arial, sans-serif;
            max-width: 350px;
            animation: slideInRight 0.5s ease-out;
        `;

        notification.innerHTML = `
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="font-size: 20px;">📧</div>
                <div>
                    <div style="font-weight: bold; margin-bottom: 3px;">Email Terkirim!</div>
                    <div style="font-size: 13px; opacity: 0.9;">Dari: infobijaksampah@gmail.com</div>
                    <div style="font-size: 13px; opacity: 0.9;">Ke: ${email}</div>
                    
                </div>
            </div>
        `;

        document.body.appendChild(notification);

        // Auto remove setelah 4 detik
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 4000);
    }
    
    // Generate email content untuk verifikasi sukses
    function generateVerificationSuccessEmailContent(user, deviceId) {
        const fullName = `${user.firstName} ${user.lastName}`;
        const today = new Date().toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });

        return `
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                <!-- Email Header -->
                <div style="background: #f8f9fa; padding: 15px; border-bottom: 1px solid #ddd; text-align: center;">
                    <p style="margin: 0; color: #666; font-size: 12px;">
                        <strong>From:</strong> infobijaksampah@gmail.com | 
                        <strong>To:</strong> ${user.email} | 
                        <strong>Date:</strong> ${today}
                    </p>
                </div>
                
                <div style="background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%); padding: 30px; text-align: center; color: white;">
                    <h1 style="margin: 0; font-size: 28px;">🎉 Verifikasi Berhasil!</h1>
                    <p style="margin: 10px 0 0 0; font-size: 16px;">Selamat! Anda resmi jadi Nasabah Bijak Sampah</p>
                </div>

                <div style="padding: 30px; background: #f8f9fa;">
                    <h2 style="color: #05445E; margin-bottom: 20px;">Halo ${fullName}! 👋</h2>

                    <div style="background: #e8f5e8; border-radius: 10px; padding: 20px; margin: 20px 0; border-left: 4px solid #28a745;">
                        <h3 style="color: #155724; margin-top: 0;">✅ Status Verifikasi:</h3>
                        <p style="color: #155724; margin: 0; font-weight: bold;">
                            VERIFIKASI BERHASIL! Akun Anda telah diverifikasi dan diaktifkan.
                        </p>
                    </div>

                    <div style="background: white; border-radius: 10px; padding: 20px; margin: 20px 0; border-left: 4px solid #75E6DA;">
                        <h3 style="color: #05445E; margin-top: 0;">📱 Detail Akun Aktif:</h3>
                        <ul style="color: #555; line-height: 2;">
                            <li><strong>Nama Lengkap:</strong> ${fullName}</li>
                            <li><strong>Email:</strong> ${user.email}</li>
                            <li><strong>ID Alat:</strong> ${deviceId}</li>
                            <li><strong>Status:</strong> <span style="color: #28a745; font-weight: bold;">AKTIF</span></li>
                            <li><strong>Tanggal Verifikasi:</strong> ${today}</li>
                        </ul>
                    </div>

                    <div style="background: #e3f2fd; border-radius: 10px; padding: 20px; margin: 20px 0; border-left: 4px solid #2196f3;">
                        <h3 style="color: #0d47a1; margin-top: 0;">🔐 Kredensial Login:</h3>
                        <div style="background: #f5f5f5; padding: 15px; border-radius: 8px; margin: 10px 0;">
                            <p style="margin: 5px 0; color: #333;"><strong>🌐 Website:</strong> <a href="https://bijaksampah.com/login" style="color: #2196f3; text-decoration: none;">bijaksampah.com/login</a></p>
                            <p style="margin: 5px 0; color: #333;"><strong>📧 Username:</strong> <span style="background: #fff; padding: 3px 8px; border-radius: 4px; font-family: monospace; border: 1px solid #ddd;">${user.email}</span></p>
                            <p style="margin: 5px 0; color: #333;"><strong>🔑 Password:</strong> <span style="background: #fff; padding: 3px 8px; border-radius: 4px; font-family: monospace; border: 1px solid #ddd;">12345678bs</span></p>
                        </div>
                        <p style="color: #0d47a1; font-size: 14px; margin: 10px 0 0 0;">
                            <strong>⚠️ Penting:</strong> Simpan kredensial ini dengan aman. Password bisa diubah setelah login pertama.
                        </p>
                    </div>

                    <div style="background: #fff3cd; border-radius: 10px; padding: 20px; margin: 20px 0; border-left: 4px solid #ffc107;">
                        <h3 style="color: #856404; margin-top: 0;">🚀 Langkah Selanjutnya:</h3>
                        <ol style="color: #856404; line-height: 2;">
                            <li><strong>Login ke web</strong> dengan username: <code style="background: #fff; padding: 2px 6px; border-radius: 3px; font-family: monospace;">${user.email}</code> dan password: <code style="background: #fff; padding: 2px 6px; border-radius: 3px; font-family: monospace;">12345678bs</code></li>
                            <li>Akses semua fitur platform Bijak Sampah</li>
                            <li>Mulai mengumpulkan sampah dan dapatkan poin</li>
                            <li>Jual sampah Anda di marketplace</li>
                            <li>Bergabung dengan komunitas nasabah</li>
                        </ol>
                    </div>

                    <div style="text-align: center; margin: 30px 0;">
                        <a href="https://bijaksampah.com/login" style="background: #75E6DA; color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; display: inline-block;">
                            🌐 Login ke Web Bijak Sampah
                            </a>
                    </div>

                    <hr style="border: none; border-top: 1px solid #ddd; margin: 30px 0;">

                    <p style="color: #666; font-size: 14px; text-align: center;">
                        Jika ada pertanyaan, silakan hubungi tim support kami di <strong>support@bijaksampah.com</strong>
                    </p>

                    <p style="color: #666; font-size: 14px; text-align: center;">
                        © 2025 Bijak Sampah. Semua hak dilindungi.
                    </p>
                </div>
            </div>
        `;
    }
    
    // Show success message
    function showSuccessMessage(message) {
        const toast = document.createElement('div');
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 20px 25px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            z-index: 10000;
            font-family: Arial, sans-serif;
            max-width: 400px;
            animation: slideInRight 0.5s ease-out;
        `;

        toast.innerHTML = `
            <div style="display: flex; align-items: center; gap: 15px;">
                <div style="font-size: 24px;">🎉</div>
                <div>
                    <div style="font-weight: bold; margin-bottom: 5px;">Verifikasi Berhasil!</div>
                    <div style="font-size: 14px; opacity: 0.9;">${message}</div>
                </div>
            </div>
        `;

        // Add CSS animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOutRight {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);

        document.body.appendChild(toast);

        // Auto remove setelah 5 detik
        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.5s ease-out';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 500);
        }, 5000);
    }
    
    // ===== END MODAL VERIFIKASI BANK SAMPAH =====

    // Sidebar toggle functionality - Check if element exists
    const toggleCollapse = document.querySelector('.toggle-collapse');
    if (toggleCollapse) {
      toggleCollapse.addEventListener('click', function() {
      const sidebar = document.querySelector('.sidebar');
        if (sidebar) {
      sidebar.classList.toggle('collapsed');
      const icon = this.querySelector('i');
      
      if (sidebar.classList.contains('collapsed')) {
        icon.classList.remove('fa-chevron-left');
        icon.classList.add('fa-chevron-right');
      } else {
        icon.classList.remove('fa-chevron-right');
        icon.classList.add('fa-chevron-left');
          }
        }
      });
    }

    // Logout functionality - Check if element exists
    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
      logoutBtn.addEventListener('click', function() {
      // Add your logout logic here
      console.log('Logout clicked');
      // window.location.href = 'login.html';
    });
    }

    // Show address verification modal (LEGACY - REMOVED)
    // function showVerificationModal(name, email, phone, address, rtRw, dob, gender, nik, kk, familyPosition) {
    //   // Store customer data
    //   currentCustomerData = {
    //     name,
    //     email,
    //     phone,
    //     address,
    //     rtRw,
    //     dob,
    //     gender,
    //     nik,
    //     kk,
    //     familyPosition
    //   };

    //   // Set address verification form data
    //   document.getElementById('modalName').value = name;
    //   document.getElementById('modalEmail').value = email;
    //   document.getElementById('modalPhone').value = phone;
    //   document.getElementById('modalAddress').value = address;
    //   document.getElementById('modalRtRw').value = rtRw;
      
    //   // Show address verification modal
    //   document.getElementById('addressVerificationModal').style.display = 'flex';
    //   document.body.style.overflow = 'hidden';
    // }

    // Show personal data verification (LEGACY - REMOVED)
    // function showPersonalDataVerification() {
    //   // Set personal data verification form
    //   document.getElementById('modalDob').value = currentCustomerData.dob;
    //   document.getElementById('modalGender').value = currentCustomerData.gender;
    //   document.getElementById('modalNik').value = currentCustomerData.nik;
    //   document.getElementById('modalKk').value = currentCustomerData.kk;
    //   document.getElementById('modalFamilyPosition').value = currentCustomerData.familyPosition;
      
    //   // Switch modals
    //   document.getElementById('addressVerificationModal').style.display = 'none';
    //   document.getElementById('personalDataVerificationModal').style.display = 'flex';
    // }

    // Back to address verification (LEGACY - REMOVED)
    // function backToAddressVerification() {
    //   document.getElementById('personalDataVerificationModal').style.display = 'none';
    //   document.getElementById('addressVerificationModal').style.display = 'flex';
    // }

    // Back to personal data verification (LEGACY - REMOVED)
    // function backToPersonalDataVerification() {
    //   document.getElementById('trashBinRegistrationModal').style.display = 'none';
    //   document.getElementById('personalDataVerificationModal').style.display = 'flex';
    // }

    // Close verification modal (LEGACY - REMOVED)
    // function closeVerificationModal() {
    //   document.getElementById('addressVerificationModal').style.display = 'none';
    //   document.getElementById('personalDataVerificationModal').style.display = 'none';
    //   document.getElementById('trashBinRegistrationModal').style.display = 'none';
    //   document.getElementById('successModal').style.display = 'none';
    //   document.body.style.overflow = 'auto';
    // }

    // Reject verification (LEGACY - REMOVED)
    // function rejectVerification() {
    //   alert('Verifikasi nasabah ' + currentCustomerData.name + ' ditolak');
    //   closeVerificationModal();
    //   // Add your rejection logic here
    // }

    // Accept verification (LEGACY - REMOVED)
    // function acceptVerification() {
    //   // Show trash bin registration form
    //   document.getElementById('personalDataVerificationModal').style.display = 'none';
    //   document.getElementById('trashBinRegistrationModal').style.display = 'flex';
    // }

         // Submit trash bin registration (LEGACY - REMOVED)
     // function submitTrashBinRegistration() {
     //   const jenisBak = document.getElementById('jenisBak').value;
     //   const noBak = document.getElementById('noBak').value;
     //   const idBak = document.getElementById('idBak').value;
       
     //   if (!jenisBak || !noBak || !idBak) {
     //     alert('Harap isi semua field pendaftaran bak sampah');
     //     return;
     //   }
       
     //   // Generate random account number (in a real app, this would come from your backend)
     //   const accountNumber = '4273' + Math.floor(10000000 + Math.random() * 90000000);
       
     //   // Show success message
     //   document.getElementById('trashBinRegistrationModal').style.display = 'none';
     //   document.getElementById('successName').textContent = currentCustomerData.name;
     //   document.getElementById('successAccountNumber').textContent = accountNumber;
     //   document.getElementById('successDeviceId').textContent = idBak;
     //   document.getElementById('successModal').style.display = 'flex';
       
     //   // Tampilkan alert berhasil
     //   alert('BERHASIL MENGIRIM KE EMAIL!');
     // }



    // Event listeners for search, sort, and pagination
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listeners for search and sort
        const searchInput = document.getElementById('searchInput');
        const sortSelect = document.getElementById('sortSelect');
        
        if (searchInput) {
            searchInput.addEventListener('input', searchAndFilter);
        }
        
        if (sortSelect) {
            sortSelect.addEventListener('change', searchAndFilter);
        }
        
        // Add event listeners for pagination
        const prevPageBtn = document.getElementById('prevPage');
        const nextPageBtn = document.getElementById('nextPage');
        
        if (prevPageBtn) {
            prevPageBtn.addEventListener('click', prevPage);
        }
        
        if (nextPageBtn) {
            nextPageBtn.addEventListener('click', nextPage);
        }
    });

    // Close modal when clicking outside (LEGACY - REMOVED)
    // window.addEventListener('click', function(event) {
    //   const addressModal = document.getElementById('addressVerificationModal');
    //   const personalModal = document.getElementById('personalDataVerificationModal');
    //   const trashBinModal = document.getElementById('trashBinRegistrationModal');
    //   const successModal = document.getElementById('successModal');
       
      
    //   if (event.target === addressModal || 
    //       event.target === personalModal || 
    //       event.target === trashBinModal ||
    //       event.target === successModal) {
    //     closeVerificationModal();
    //   }
       
       
    // });
    
    // Update event listener
    document.addEventListener('DOMContentLoaded', function() {
        initializeEmailJS();
        // ... existing code ...
    });
    
    // Inisialisasi EmailJS
    function initializeEmailJS() {
        try {
            // Ganti 'YOUR_USER_ID' dengan User ID dari EmailJS dashboard
            // Contoh: 'user_abc123' atau 'user_xyz789'
            emailjs.init('QV-h6ByGM45FkOzZd');
            console.log('✅ EmailJS berhasil diinisialisasi!');
        } catch (error) {
            console.error('❌ Error inisialisasi EmailJS:', error);
        }
        }
  </script>
</body>
</html>