<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Data Setoran Sampah - Bijak Sampah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
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

        /* Search Results Info */
        .search-info {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .search-info .info-text {
            color: #0369a1;
            font-size: 14px;
        }

        .search-info .clear-btn {
            background: #0369a1;
            color: white;
            border: none;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .search-info .clear-btn:hover {
            background: #075985;
        }
    </style>
</head>
<body class="bg-gray-50">

<div class="flex min-h-screen bg-gray-50" x-data="{ 
    sidebarOpen: false, 
    activeMenu: 'data-sampah',
    searchQuery: '',
    filteredWastes: [],
    allWastes: [],
    searchResults: 0,
    showSearchInfo: false,
    
    performSearch() {
      const query = this.searchQuery.toLowerCase().trim();
      console.log('Searching for:', query);
      console.log('Current allWastes length:', this.allWastes ? this.allWastes.length : 'undefined');
      
      if (query === '') {
        this.clearSearch();
        return;
      }
      
      // Check if allWastes is available
      if (!this.allWastes || this.allWastes.length === 0) {
        console.log('No waste data available for search');
        console.log('Trying to reload data...');
        
        // Try to reload data from current month
        const selectedMonth = parseInt(document.getElementById('monthFilter').value);
        const monthData = monthlyData[selectedMonth];
        if (monthData && monthData.wastes) {
          this.allWastes = monthData.wastes;
          console.log('Reloaded data with', monthData.wastes.length, 'items');
        } else {
          console.log('No month data available');
          return;
        }
      }
      
      console.log('Available wastes:', this.allWastes.length);
      console.log('Sample wastes:', this.allWastes.slice(0, 3));
      
      // Filter wastes based on search query
      this.filteredWastes = this.allWastes.filter(waste => {
        const matches = waste.name.toLowerCase().includes(query) ||
               waste.category.toLowerCase().includes(query) ||
               waste.unit.toLowerCase().includes(query) ||
               waste.amount.toString().includes(query);
        return matches;
      });
      
      this.searchResults = this.filteredWastes.length;
      this.showSearchInfo = true;
      
      console.log('Search results:', this.filteredWastes.length);
      console.log('Sample results:', this.filteredWastes.slice(0, 3));
      
      // Update table with filtered data
      if (window.updateTableWithData) {
        window.updateTableWithData(this.filteredWastes);
      } else {
        console.error('updateTableWithData function not available');
      }
    },
    
    clearSearch() {
      console.log('Clearing search');
      this.searchQuery = '';
      this.filteredWastes = [];
      this.searchResults = 0;
      this.showSearchInfo = false;
      
      // Reload original data
      const selectedMonth = parseInt(document.getElementById('monthFilter').value);
      if (window.loadMonthData) {
        window.loadMonthData(selectedMonth);
      } else {
        console.error('loadMonthData function not available');
      }
    }
}" x-init="activeMenu = 'data-sampah'">
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
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200"
                    :class="activeMenu === 'penjemputan-sampah' ? 'bg-white/20 shadow-sm' : 'hover:bg-white/10 hover:shadow-sm'"
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
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 bg-white/20 shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'data-sampah'"
                >
                    <i class="fas fa-trash-alt text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Data Sampah</span>
                </a>
                
                <a 
                    href="{{ route('penjualansampah-banksampah') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200"
                    :class="activeMenu === 'penjualansampah' ? 'bg-white/20 shadow-sm' : 'hover:bg-white/10 hover:shadow-sm'"
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

  <!-- Main Content -->
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
    
    <!-- Content Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4" style="padding-top: 60px;">
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Data Setoran Sampah</h2>
        <p class="text-sm text-gray-500">Pantau dan kelola data setoran sampah dari nasabah</p>
      </div>
      <div class="flex items-center space-x-4 w-full md:w-auto">
        <div class="relative flex-grow md:flex-grow-0">
          <input 
            type="text" 
            placeholder="Cari data setoran..." 
            class="pl-10 pr-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm w-full"
            x-model="searchQuery"
            @input="performSearch()"
            @keyup="performSearch()"
          >
          <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        </div>
        <div class="relative">
          <select id="monthFilter" class="pl-4 pr-10 py-2 border rounded-full appearance-none bg-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="1">Januari 2025</option>
            <option value="2">Februari 2025</option>
            <option value="3">Maret 2025</option>
            <option value="4" selected>April 2025</option>
            <option value="5">Mei 2025</option>
            <option value="6">Juni 2025</option>
            <option value="7">Juli 2025</option>
            <option value="8">Agustus 2025</option>
            <option value="9">September 2025</option>
            <option value="10">Oktober 2025</option>
            <option value="11">November 2025</option>
            <option value="12">Desember 2025</option>
          </select>
          <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs"></i>
        </div>
      </div>
    </div>

    <!-- Search Results Info -->
    <div x-show="showSearchInfo" x-transition class="search-info">
      <div class="info-text">
        <i class="fas fa-search mr-2"></i>
        Menampilkan <span x-text="searchResults"></span> hasil pencarian untuk "<span x-text="searchQuery"></span>"
      </div>
      <button @click="clearSearch()" class="clear-btn">
        <i class="fas fa-times mr-1"></i>Bersihkan
      </button>
    </div>
    
    <!-- Debug Info (temporary) -->
    <div x-show="searchQuery !== ''" class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-2 rounded mb-4">
      <strong>Debug:</strong> Query: "<span x-text="searchQuery"></span>", Available: <span x-text="allWastes.length"></span>, Results: <span x-text="filteredWastes.length"></span>
      <br>
      <small>Sample data: <span x-text="allWastes.length > 0 ? allWastes[0].name : 'No data'"></span></small>
    </div>
    
    <!-- Always show debug info for troubleshooting -->
    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-2 rounded mb-4">
      <strong>Status:</strong> Available: <span x-text="allWastes.length"></span> items, 
      Current Month: <span x-text="document.getElementById('monthFilter') ? document.getElementById('monthFilter').value : 'N/A'"></span>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
      <div class="custom-card p-6 animate-fade-in" style="animation-delay: 0.1s;">
        <div class="flex justify-between items-start">
          <div>
            <p class="text-sm text-gray-500">Total Setoran Bulan Ini</p>
            <h3 class="text-2xl font-bold mt-1" id="totalDepositMonth">43.2 <span class="text-lg">Kg</span></h3>
          </div>
          <div class="bg-blue-100 p-3 rounded-full text-blue-600">
            <i class="fas fa-trash-alt"></i>
          </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
          <span class="text-green-500 flex items-center">
            <i class="fas fa-arrow-up mr-1"></i> 12.5%
          </span>
          <span class="text-gray-500 ml-2">vs bulan lalu</span>
        </div>
      </div>

      <div class="custom-card p-6 animate-fade-in" style="animation-delay: 0.2s;">
        <div class="flex justify-between items-start">
          <div>
            <p class="text-sm text-gray-500">Total Nasabah Aktif</p>
            <h3 class="text-2xl font-bold mt-1" id="totalActiveUsers">128 <span class="text-lg">Orang</span></h3>
          </div>
          <div class="bg-green-100 p-3 rounded-full text-green-600">
            <i class="fas fa-users"></i>
          </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
          <span class="text-green-500 flex items-center">
            <i class="fas fa-arrow-up mr-1"></i> 8.2%
          </span>
          <span class="text-gray-500 ml-2">vs bulan lalu</span>
        </div>
      </div>

      <div class="custom-card p-6 animate-fade-in" style="animation-delay: 0.3s;">
        <div class="flex justify-between items-start">
          <div>
            <p class="text-sm text-gray-500">Rata-rata Setoran/Nasabah</p>
            <h3 class="text-2xl font-bold mt-1" id="avgDepositPerUser">0.34 <span class="text-lg">Kg</span></h3>
          </div>
          <div class="bg-orange-100 p-3 rounded-full text-orange-600">
            <i class="fas fa-weight-hanging"></i>
          </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
          <span class="text-green-500 flex items-center">
            <i class="fas fa-arrow-up mr-1"></i> 4.3%
          </span>
          <span class="text-gray-500 ml-2">vs bulan lalu</span>
        </div>
      </div>

      <div class="custom-card p-6 animate-fade-in" style="animation-delay: 0.4s;">
        <div class="flex justify-between items-start">
          <div>
            <p class="text-sm text-gray-500">Sampah Terbanyak</p>
            <h3 class="text-2xl font-bold mt-1" id="topWasteType">Plastik Botol</h3>
          </div>
          <div class="bg-purple-100 p-3 rounded-full text-purple-600">
            <i class="fas fa-trophy"></i>
          </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
          <span class="text-gray-500">20 Kg (46.3%)</span>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Main Table -->
      <div class="lg:col-span-2 custom-card p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
          <h2 class="text-xl font-semibold text-gray-800">Setoran Sampah Bulan <span id="currentMonth">April 2025</span></h2>
          <div class="flex space-x-3">
            <button id="exportBtn" class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm hover:bg-blue-100 transition-colors">
              <i class="fas fa-file-export mr-1"></i> Export
            </button>
            <button id="printBtn" class="px-3 py-1 bg-green-50 text-green-600 rounded-full text-sm hover:bg-green-100 transition-colors">
              <i class="fas fa-print mr-1"></i> Print
            </button>
          </div>
        </div>
        
        <div class="overflow-x-auto">
          <table class="data-table">
            <thead>
              <tr>
                <th class="text-left">No</th>
                <th class="text-left">Jenis Sampah</th>
                <th class="text-left">Kategori</th>
                <th class="text-left">Satuan</th>
                <th class="text-right">Jumlah</th>
                <th class="text-right">Aksi</th>
              </tr>
            </thead>
            <tbody id="wasteTableBody" class="text-sm">
              <tr>
                <td colspan="6" class="text-center py-8 text-gray-500">
                  <i class="fas fa-spinner fa-spin mr-2"></i>
                  Memuat data...
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        
        <div class="flex flex-col sm:flex-row justify-between items-center mt-6 pt-6 border-t border-gray-200 gap-4">
          <div class="text-sm text-gray-500">
            Menampilkan <span id="startItem">1</span>-<span id="endItem">6</span> dari <span id="totalItems">6</span> data
          </div>
          <div class="flex space-x-2">
            <button class="px-3 py-1 border rounded-md text-sm disabled:opacity-50" id="prevPage" disabled>
              <i class="fas fa-chevron-left"></i>
            </button>
            <button class="px-3 py-1 border rounded-md text-sm bg-blue-500 text-white">1</button>
            <button class="px-3 py-1 border rounded-md text-sm hover:bg-gray-100">2</button>
            <button class="px-3 py-1 border rounded-md text-sm hover:bg-gray-100">3</button>
            <button class="px-3 py-1 border rounded-md text-sm" id="nextPage">
              <i class="fas fa-chevron-right"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Charts Section -->
      <div class="space-y-6">
        <!-- Bar/Line Chart -->
        <div class="custom-card p-6">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Trend Setoran 6 Bulan Terakhir</h3>
            <div class="flex space-x-2">
              <button class="px-2 py-1 text-xs rounded-md bg-blue-100 text-blue-600" id="toggleChartType">
                <i class="fas fa-chart-line mr-1"></i>Garis
              </button>
              <button class="px-2 py-1 text-xs rounded-md hover:bg-gray-100" id="toggleTimeRange">
                <i class="fas fa-calendar-alt mr-1"></i>1 Tahun
              </button>
            </div>
          </div>
          <div class="chart-container">
            <canvas id="trendChart" width="400" height="200"></canvas>
          </div>
        </div>

        <!-- Waste Composition -->
        <div class="custom-card p-6">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Komposisi Jenis Sampah</h3>
            <div class="flex space-x-2">
              <button class="px-2 py-1 text-xs rounded-md bg-blue-100 text-blue-600" id="toggleChartView">
                <i class="fas fa-chart-pie mr-1"></i>Pie
              </button>
              <button class="px-2 py-1 text-xs rounded-md hover:bg-gray-100" id="exportChart">
                <i class="fas fa-download mr-1"></i>Unduh
              </button>
            </div>
          </div>
          <div class="chart-container">
            <canvas id="compositionChart" width="400" height="200"></canvas>
          </div>
        </div>

        <!-- Top Waste Contributors -->
        <div class="custom-card p-6">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Top 5 Nasabah</h3>
            <button class="text-blue-500 text-sm hover:underline" id="refreshTopContributors">
              <i class="fas fa-sync-alt mr-1"></i>Refresh
            </button>
          </div>
          <div class="space-y-4">
            <div class="flex items-center">
              <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                <span class="text-xs font-bold">1</span>
              </div>
              <div class="flex-grow">
                <p class="text-sm font-medium">Ahmad Santoso</p>
                <p class="text-xs text-gray-500">12.5 Kg Plastik</p>
              </div>
              <div class="text-sm font-medium text-blue-600">Rp 87,500</div>
            </div>
            <div class="flex items-center">
              <div class="w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mr-3">
                <span class="text-xs font-bold">2</span>
              </div>
              <div class="flex-grow">
                <p class="text-sm font-medium">Budi Setiawan</p>
                <p class="text-xs text-gray-500">9.2 Kg Kertas</p>
              </div>
              <div class="text-sm font-medium text-blue-600">Rp 64,400</div>
            </div>
            <div class="flex items-center">
              <div class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center mr-3">
                <span class="text-xs font-bold">3</span>
              </div>
              <div class="flex-grow">
                <p class="text-sm font-medium">Citra Dewi</p>
                <p class="text-xs text-gray-500">8.7 Kg Plastik</p>
              </div>
              <div class="text-sm font-medium text-blue-600">Rp 60,900</div>
            </div>
            <div class="flex items-center">
              <div class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center mr-3">
                <span class="text-xs font-bold">4</span>
              </div>
              <div class="flex-grow">
                <p class="text-sm font-medium">Dian Pratama</p>
                <p class="text-xs text-gray-500">7.5 Kg Logam</p>
              </div>
              <div class="text-sm font-medium text-blue-600">Rp 112,500</div>
            </div>
            <div class="flex items-center">
              <div class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center mr-3">
                <span class="text-xs font-bold">5</span>
              </div>
              <div class="flex-grow">
                <p class="text-sm font-medium">Eka Wulandari</p>
                <p class="text-xs text-gray-500">6.8 Kg Kaca</p>
              </div>
              <div class="text-sm font-medium text-blue-600">Rp 47,600</div>
            </div>
          </div>
          <button class="w-full mt-4 py-2 text-sm text-blue-500 hover:bg-blue-50 rounded-md transition-colors">
            Lihat Semua <i class="fas fa-chevron-down ml-1"></i>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for Waste Detail -->
  <div id="wasteDetailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg w-full max-w-md mx-4">
      <div class="p-6">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold">Detail Setoran Sampah</h3>
          <button id="closeModal" class="text-gray-500 hover:text-gray-700">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="space-y-4">
          <div>
            <p class="text-sm text-gray-500">Jenis Sampah</p>
            <p class="font-medium" id="modalWasteType">-</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">Kategori</p>
            <p class="font-medium" id="modalWasteCategory">-</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">Jumlah</p>
            <p class="font-medium" id="modalWasteAmount">-</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">Harga per Satuan</p>
            <p class="font-medium" id="modalWastePrice">-</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">Total Nilai</p>
            <p class="font-medium text-blue-600" id="modalWasteTotal">-</p>
          </div>
        </div>
        <div class="mt-6 pt-4 border-t border-gray-200 flex justify-end space-x-3">
          <button class="px-4 py-2 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600" onclick="printReceipt()">
            <i class="fas fa-print mr-2"></i>Cetak Struk PNG
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Enhanced data structure with more waste types and categories
    const wasteCategories = {
      'plastik': ['Plastik Botol Bening', 'Plastik Botol Warna', 'Plastik Gelas Kecil', 'Plastik Kerasan', 'Plastik Kantong', 'Plastik Mika', 'Plastik PVC'],
      'kertas': ['Kertas Duplex', 'Kertas Koran', 'Kertas HVS', 'Kertas Karton', 'Kertas Warna', 'Kertas Bekas Paku'],
      'logam': ['Kaleng Aluminium', 'Kaleng Besi', 'Tembaga', 'Kuningan', 'Besi Tua', 'Aluminium Foil'],
      'kaca': ['Botol Kaca Bening', 'Botol Kaca Warna', 'Gelas Kaca', 'Pecahan Kaca'],
      'organik': ['Sisa Makanan', 'Dedaunan', 'Ranting', 'Kulit Buah'],
      'lainnya': ['Minyak Jelantah', 'Elektronik', 'Baterai', 'Tekstil', 'Karet']
    };

    // Price per kg/liter for each waste type
    const wastePrices = {
      'Plastik Botol Bening': 7000,
      'Plastik Botol Warna': 5000,
      'Plastik Gelas Kecil': 3000,
      'Plastik Kerasan': 4500,
      'Plastik Kantong': 1000,
      'Plastik Mika': 2500,
      'Plastik PVC': 3500,
      'Kertas Duplex': 2000,
      'Kertas Koran': 1500,
      'Kertas HVS': 2500,
      'Kertas Karton': 1800,
      'Kertas Warna': 2200,
      'Kertas Bekas Paku': 1200,
      'Kaleng Aluminium': 10000,
      'Kaleng Besi': 8000,
      'Tembaga': 50000,
      'Kuningan': 40000,
      'Besi Tua': 6000,
      'Aluminium Foil': 7500,
      'Botol Kaca Bening': 3000,
      'Botol Kaca Warna': 2000,
      'Gelas Kaca': 2500,
      'Pecahan Kaca': 500,
      'Minyak Jelantah': 10000,
      'Elektronik': 12000,
      'Baterai': 8000,
      'Tekstil': 1500,
      'Karet': 2000
    };

    // Units for each waste type
    const wasteUnits = {
      'Minyak Jelantah': 'Liter',
      'Elektronik': 'Unit',
      'Baterai': 'Unit',
      'default': 'Kg'
    };

    // Sample data for each month with more waste types
    const monthlyData = {};
    const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", 
                       "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    
    // Generate realistic data for each month
    for (let month = 1; month <= 12; month++) {
      const wastes = [];
      let totalKg = 0;
      
      // Add random amounts for each waste type
      Object.keys(wasteCategories).forEach(category => {
        wasteCategories[category].forEach(wasteType => {
          // Generate random amount with seasonal variation
          let amount;
          if (month >= 3 && month <= 5) { // High season (March-May)
            amount = (Math.random() * 15 + 5).toFixed(1);
          } else if (month >= 9 && month <= 11) { // Medium season (Sept-Nov)
            amount = (Math.random() * 10 + 3).toFixed(1);
          } else { // Low season
            amount = (Math.random() * 8 + 2).toFixed(1);
          }
          
          // Convert to number and add to total
          amount = parseFloat(amount);
          totalKg += amount;
          
          // Determine unit
          const unit = wasteUnits[wasteType] || wasteUnits['default'];
          
          wastes.push({
            name: wasteType,
            category: category,
            unit: unit,
            amount: amount,
            price: wastePrices[wasteType] || 0
          });
        });
      });
      
      // Add some special waste types
      if (month % 2 === 0) {
        wastes.push({
          name: 'Minyak Jelantah',
          category: 'lainnya',
          unit: 'Liter',
          amount: (Math.random() * 5 + 1).toFixed(1),
          price: wastePrices['Minyak Jelantah']
        });
      }
      
      // Find top waste
      const sortedWastes = [...wastes].sort((a, b) => b.amount - a.amount);
      const topWaste = sortedWastes[0];
      
      monthlyData[month] = {
        wastes: wastes,
        topWaste: {
          name: topWaste.name,
          amount: topWaste.amount,
          unit: topWaste.unit,
          percentage: ((topWaste.amount / totalKg) * 100).toFixed(1),
          desc: `${topWaste.name} menjadi setoran paling banyak di bulan ini, yaitu sebanyak ${topWaste.amount}${topWaste.unit}, mengisi ${((topWaste.amount / totalKg) * 100).toFixed(1)}% dari total setoran.`
        },
        totalKg: totalKg,
        activeUsers: Math.floor(Math.random() * 50) + 100 // Random between 100-150
      };
      
      // Debug log for April data
      if (month === 4) {
        console.log(`April data created with ${wastes.length} waste items`);
        console.log('Sample waste items:', wastes.slice(0, 3));
      }
    }

    // Chart instances
    let trendChart, compositionChart;
    let currentChartType = 'line'; // 'line' or 'bar'
    let currentTimeRange = '6months'; // '6months' or '12months'
    let currentCompositionView = 'pie'; // 'pie' or 'doughnut'

    // Initialize the page
    document.addEventListener('DOMContentLoaded', function() {
      console.log('DOM Content Loaded');
      console.log('Monthly data available:', Object.keys(monthlyData));
      console.log('April data:', monthlyData[4]);
      console.log('April wastes count:', monthlyData[4] ? monthlyData[4].wastes.length : 0);
      
      // Load initial data (April)
      loadMonthData(4);
      
      // Initialize charts with Chart.js - wait for Chart to be available
      function initChartsWhenReady() {
        if (typeof Chart !== 'undefined') {
          initCharts();
        } else {
          setTimeout(initChartsWhenReady, 100);
        }
      }
      
      initChartsWhenReady();
      
      // Set up event listeners
      setupEventListeners();
      
      // Function to ensure Alpine.js data is loaded
      function ensureAlpineData() {
        if (window.Alpine) {
          try {
            const alpineComponent = document.querySelector('[x-data]').__x.$data;
            const monthData = monthlyData[4]; // April data
            if (monthData && monthData.wastes) {
              alpineComponent.allWastes = monthData.wastes;
              console.log('Alpine.js data loaded successfully with', monthData.wastes.length, 'items');
              console.log('Sample Alpine.js data:', alpineComponent.allWastes.slice(0, 3));
              return true;
            } else {
              console.log('Month data not available for Alpine.js');
              return false;
            }
          } catch (error) {
            console.log('Alpine.js data loading delayed:', error);
            return false;
          }
        } else {
          console.log('Alpine.js not available yet');
          return false;
        }
      }
      
      // Try to load Alpine.js data multiple times
      let attempts = 0;
      const maxAttempts = 10;
      
      function tryLoadAlpineData() {
        attempts++;
        console.log(`Attempt ${attempts} to load Alpine.js data`);
        
        if (ensureAlpineData()) {
          console.log('Alpine.js data loaded successfully');
        } else if (attempts < maxAttempts) {
          setTimeout(tryLoadAlpineData, 500);
        } else {
          console.log('Failed to load Alpine.js data after', maxAttempts, 'attempts');
        }
      }
      
      // Start trying to load Alpine.js data
      setTimeout(tryLoadAlpineData, 500);
    });



    // Make loadMonthData globally accessible
    window.loadMonthData = function(month) {
      const monthData = monthlyData[month];
      if (!monthData) {
        console.error('Month data not found for month:', month);
        return;
      }
      
      const monthName = monthNames[month-1];
      
      // Update month title
      const currentMonthElement = document.getElementById('currentMonth');
      if (currentMonthElement) {
        currentMonthElement.textContent = `${monthName} 2025`;
      }
      
      // Update stats cards
      const totalDepositElement = document.getElementById('totalDepositMonth');
      const totalUsersElement = document.getElementById('totalActiveUsers');
      const avgDepositElement = document.getElementById('avgDepositPerUser');
      const topWasteElement = document.getElementById('topWasteType');
      
      if (totalDepositElement) totalDepositElement.textContent = `${monthData.totalKg.toFixed(1)} Kg`;
      if (totalUsersElement) totalUsersElement.textContent = `${monthData.activeUsers} Orang`;
      if (avgDepositElement) avgDepositElement.textContent = `${(monthData.totalKg / monthData.activeUsers).toFixed(2)} Kg`;
      if (topWasteElement) topWasteElement.textContent = monthData.topWaste.name;
      
      // Store data in Alpine.js for search functionality
      if (window.Alpine) {
        try {
          const alpineComponent = document.querySelector('[x-data]').__x.$data;
          alpineComponent.allWastes = monthData.wastes;
          alpineComponent.filteredWastes = [];
          alpineComponent.searchQuery = '';
          alpineComponent.showSearchInfo = false;
          console.log('Alpine.js data updated for month:', month, 'with', monthData.wastes.length, 'items');
        } catch (error) {
          console.log('Alpine.js not ready yet, data will be loaded later');
        }
      }
      
      // Fill the table
      updateTableWithData(monthData.wastes);
      
      // Update charts
      updateCharts(month);
      
      console.log(`Month data loaded successfully for month ${month} with ${monthData.wastes.length} waste items`);
      
      // Force Alpine.js data update after a short delay
      setTimeout(() => {
        if (window.Alpine) {
          try {
            const alpineComponent = document.querySelector('[x-data]').__x.$data;
            if (!alpineComponent.allWastes || alpineComponent.allWastes.length === 0) {
              alpineComponent.allWastes = monthData.wastes;
              console.log('Forced Alpine.js data update with', monthData.wastes.length, 'items');
            }
          } catch (error) {
            console.log('Failed to force Alpine.js data update:', error);
          }
        }
      }, 100);
    }

    // Make updateTableWithData globally accessible
    window.updateTableWithData = function(wastes) {
      const tableBody = document.getElementById('wasteTableBody');
      if (!tableBody) {
        console.error('Table body not found');
        return;
      }
      
      console.log('Updating table with', wastes ? wastes.length : 0, 'items');
      
      tableBody.innerHTML = '';
      
      if (!wastes || wastes.length === 0) {
        tableBody.innerHTML = `
          <tr>
            <td colspan="6" class="text-center py-8 text-gray-500">
              <i class="fas fa-search mr-2"></i>
              Tidak ada data yang ditemukan
            </td>
          </tr>
        `;
        console.log('No data to display');
        return;
      }
      
      let totalKg = 0;
      let totalLiter = 0;
      let totalOther = 0;
      
      wastes.forEach((waste, index) => {
        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-50';
        row.innerHTML = `
          <td class="font-medium">${index+1}</td>
          <td>${waste.name}</td>
          <td><span class="badge ${getCategoryBadgeClass(waste.category)}">${waste.category}</span></td>
          <td>${waste.unit}</td>
          <td class="text-right">${waste.amount} ${waste.unit}</td>
          <td class="text-right">
            <button class="text-blue-500 hover:text-blue-700 view-detail" data-waste='${JSON.stringify(waste)}'>
              <i class="fas fa-eye"></i>
            </button>
          </td>
        `;
        tableBody.appendChild(row);
        
        // Calculate totals
        if (waste.unit === 'Kg') {
          totalKg += waste.amount;
        } else if (waste.unit === 'Liter') {
          totalLiter += waste.amount;
        } else {
          totalOther += waste.amount;
        }
      });
      
      // Update pagination info
      const startItem = document.getElementById('startItem');
      const endItem = document.getElementById('endItem');
      const totalItems = document.getElementById('totalItems');
      
      if (startItem) startItem.textContent = '1';
      if (endItem) endItem.textContent = wastes.length;
      if (totalItems) totalItems.textContent = wastes.length;
      
      console.log(`Table updated with ${wastes.length} items`);
    }

    function getCategoryBadgeClass(category) {
      switch(category) {
        case 'plastik': return 'badge-primary';
        case 'kertas': return 'badge-success';
        case 'logam': return 'badge-warning';
        default: return 'badge-primary';
      }
    }

    function initCharts() {
      console.log('=== CHART INITIALIZATION START ===');
      
      // Check if Chart.js is available
      if (typeof Chart === 'undefined') {
        console.error('Chart.js is not loaded!');
        // Show fallback message
        console.log('Chart.js not available, continuing without charts');
        return;
      }
      
      // Get canvas elements
      const trendCanvas = document.getElementById('trendChart');
      const compositionCanvas = document.getElementById('compositionChart');
      
      if (!trendCanvas || !compositionCanvas) {
        console.error('Canvas elements not found!');
        console.log('Canvas elements not found, continuing without charts');
        return;
      }
      
      console.log('Creating simple trend chart...');
      
      // Create simple trend chart
      const trendCtx = trendCanvas.getContext('2d');
      trendChart = new Chart(trendCtx, {
        type: 'line',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
          datasets: [{
            label: 'Total Sampah (Kg)',
            data: [32, 45, 52, 43.2, 38, 41],
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            borderWidth: 2,
            fill: false,
            tension: 0.1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          animation: false, // Disable animations for better performance
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
                  return value + ' Kg';
                }
              }
            }
          }
        }
      });
      
      console.log('Creating simple composition chart...');
      
      // Create simple composition chart
      const compositionCtx = compositionCanvas.getContext('2d');
      compositionChart = new Chart(compositionCtx, {
        type: 'pie',
        data: {
          labels: ['Plastik', 'Kertas', 'Logam', 'Lainnya'],
          datasets: [{
            data: [27.5, 13, 2, 6],
            backgroundColor: [
              '#3b82f6',
              '#f59e0b',
              '#10b981',
              '#8b5cf6'
            ],
            borderWidth: 1,
            borderColor: '#ffffff'
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          animation: false, // Disable animations for better performance
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                padding: 10,
                usePointStyle: false
              }
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  return context.label + ': ' + context.parsed + ' Kg';
                }
              }
            }
          }
        }
      });
      
      console.log('=== CHART INITIALIZATION COMPLETE ===');
    }

    function updateCharts(month) {
      // Check if charts are initialized
      if (!trendChart || !compositionChart) {
        console.log('Charts not yet initialized, skipping update');
        return;
      }
      
      // Update trend chart data
      const monthsToShow = currentTimeRange === '6months' ? 6 : 12;
      const labels = [];
      const data = [];
      
      for (let i = 0; i < monthsToShow; i++) {
        const m = month - monthsToShow + i + 1;
        if (m > 0) {
          labels.push(monthNames[m-1].substring(0, 3));
          data.push(monthlyData[m] ? monthlyData[m].totalKg.toFixed(1) : 0);
        } else {
          // Handle previous year if needed
          labels.push(monthNames[12 + m - 1].substring(0, 3));
          data.push(0); // No data for previous year in our example
        }
      }
      
      // Update trend chart - simplified
      trendChart.data.labels = labels;
      trendChart.data.datasets[0].data = data;
      trendChart.update('none'); // Disable animation
      
      // Update composition chart - simplified with static data
      const simpleData = [27.5, 13, 2, 6];
      const simpleLabels = ['Plastik', 'Kertas', 'Logam', 'Lainnya'];
      const simpleColors = ['#3b82f6', '#f59e0b', '#10b981', '#8b5cf6'];
      
      compositionChart.data.labels = simpleLabels;
      compositionChart.data.datasets[0].data = simpleData;
      compositionChart.data.datasets[0].backgroundColor = simpleColors;
      compositionChart.update('none'); // Disable animation
    }

    function setupEventListeners() {
      // Month filter change
      document.getElementById('monthFilter').addEventListener('change', function() {
        const selectedMonth = parseInt(this.value);
        loadMonthData(selectedMonth);
        
        // Ensure Alpine.js data is updated for the new month
        setTimeout(() => {
          if (window.Alpine) {
            try {
              const alpineComponent = document.querySelector('[x-data]').__x.$data;
              const monthData = monthlyData[selectedMonth];
              if (monthData && monthData.wastes) {
                alpineComponent.allWastes = monthData.wastes;
                alpineComponent.searchQuery = '';
                alpineComponent.showSearchInfo = false;
                console.log('Alpine.js data updated for month', selectedMonth, 'with', monthData.wastes.length, 'items');
              }
            } catch (error) {
              console.log('Failed to update Alpine.js data for month change:', error);
            }
          }
        }, 200);
      });
      
      // Toggle chart type (line/bar) - simplified
      document.getElementById('toggleChartType').addEventListener('click', function() {
        if (!trendChart) return;
        
        if (currentChartType === 'line') {
          currentChartType = 'bar';
          this.innerHTML = '<i class="fas fa-chart-bar mr-1"></i>Batang';
          trendChart.config.type = 'bar';
          trendChart.update('none'); // Disable animation
        } else {
          currentChartType = 'line';
          this.innerHTML = '<i class="fas fa-chart-line mr-1"></i>Garis';
          trendChart.config.type = 'line';
          trendChart.update('none'); // Disable animation
        }
      });
      
      // Toggle time range (6 months/12 months) - simplified
      document.getElementById('toggleTimeRange').addEventListener('click', function() {
        if (currentTimeRange === '6months') {
          currentTimeRange = '12months';
          this.innerHTML = '<i class="fas fa-calendar-alt mr-1"></i>6 Bulan';
        } else {
          currentTimeRange = '6months';
          this.innerHTML = '<i class="fas fa-calendar-alt mr-1"></i>1 Tahun';
        }
        
        // Get current selected month
        const selectedMonth = parseInt(document.getElementById('monthFilter').value);
        updateCharts(selectedMonth);
      });
      
      // Toggle composition chart view (pie/doughnut) - simplified
      document.getElementById('toggleChartView').addEventListener('click', function() {
        if (!compositionChart) return;
        
        if (currentCompositionView === 'pie') {
          currentCompositionView = 'doughnut';
          this.innerHTML = '<i class="fas fa-chart-pie mr-1"></i>Pie';
          compositionChart.config.type = 'doughnut';
          compositionChart.update('none'); // Disable animation
        } else {
          currentCompositionView = 'pie';
          this.innerHTML = '<i class="fas fa-chart-donut mr-1"></i>Donat';
          compositionChart.config.type = 'pie';
          compositionChart.update('none'); // Disable animation
        }
      });
      
      // Export chart
      document.getElementById('exportChart').addEventListener('click', function() {
        const link = document.createElement('a');
        link.download = 'komposisi-sampah-' + document.getElementById('currentMonth').textContent.toLowerCase().replace(' ', '-') + '.png';
        link.href = compositionChart.toBase64Image();
        link.click();
      });
      
      // Export data to CSV
      document.getElementById('exportBtn').addEventListener('click', function() {
        exportToCSV();
      });
      
      // Print data
      document.getElementById('printBtn').addEventListener('click', function() {
        printData();
      });
      
      // Refresh top contributors
      document.getElementById('refreshTopContributors').addEventListener('click', function() {
        const spinner = '<div class="loading-spinner"></div>';
        this.innerHTML = spinner + ' Memuat...';
        
        // Simulate loading
        setTimeout(() => {
          this.innerHTML = '<i class="fas fa-sync-alt mr-1"></i>Refresh';
          // In a real app, you would fetch new data here
          alert('Data top nasabah telah diperbarui!');
        }, 1500);
      });
      
      // View waste detail
      document.addEventListener('click', function(e) {
        if (e.target.closest('.view-detail')) {
          const button = e.target.closest('.view-detail');
          const wasteData = JSON.parse(button.getAttribute('data-waste'));
          
          // Fill modal with waste data
          document.getElementById('modalWasteType').textContent = wasteData.name;
          document.getElementById('modalWasteCategory').textContent = wasteData.category;
          document.getElementById('modalWasteAmount').textContent = `${wasteData.amount} ${wasteData.unit}`;
          document.getElementById('modalWastePrice').textContent = `Rp ${wasteData.price.toLocaleString('id-ID')} / ${wasteData.unit}`;
          document.getElementById('modalWasteTotal').textContent = `Rp ${(wasteData.amount * wasteData.price).toLocaleString('id-ID')}`;
          
          // Show modal
          document.getElementById('wasteDetailModal').classList.remove('hidden');
        }
      });
      
      // Close modal
      document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('wasteDetailModal').classList.add('hidden');
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


    }
    
    // Function to export data to CSV
    function exportToCSV() {
      const currentMonth = document.getElementById('currentMonth').textContent;
      const tableBody = document.getElementById('wasteTableBody');
      const rows = tableBody.querySelectorAll('tr');
      
      let csvContent = "data:text/csv;charset=utf-8,";
      csvContent += "No,Jenis Sampah,Kategori,Satuan,Jumlah\n";
      
      rows.forEach((row, index) => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 5) {
          const no = cells[0].textContent.trim();
          const jenis = cells[1].textContent.trim();
          const kategori = cells[2].textContent.trim();
          const satuan = cells[3].textContent.trim();
          const jumlah = cells[4].textContent.trim();
          
          csvContent += `"${no}","${jenis}","${kategori}","${satuan}","${jumlah}"\n`;
        }
      });
      
      const encodedUri = encodeURI(csvContent);
      const link = document.createElement('a');
      link.setAttribute('href', encodedUri);
      link.setAttribute('download', `data-setoran-sampah-${currentMonth.toLowerCase().replace(' ', '-')}.csv`);
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
      
      // Show success message
      showNotification('Data berhasil diexport ke CSV!', 'success');
    }
    
    // Function to print data
    function printData() {
      const currentMonth = document.getElementById('currentMonth').textContent;
      const tableBody = document.getElementById('wasteTableBody');
      
      // Create print window content
      let printContent = `
        <!DOCTYPE html>
        <html>
        <head>
          <title>Data Setoran Sampah - ${currentMonth}</title>
          <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; }
            h1 { color: #333; }
            .header { text-align: center; margin-bottom: 30px; }
            .stats { margin-bottom: 20px; }
            @media print {
              .no-print { display: none; }
            }
          </style>
        </head>
        <body>
          <div class="header">
            <h1>Data Setoran Sampah</h1>
            <h2>Bulan: ${currentMonth}</h2>
            <p>Tanggal Cetak: ${new Date().toLocaleDateString('id-ID')}</p>
          </div>
          
          <div class="stats">
            <p><strong>Total Setoran:</strong> ${document.getElementById('totalDepositMonth').textContent}</p>
            <p><strong>Total Nasabah Aktif:</strong> ${document.getElementById('totalActiveUsers').textContent}</p>
          </div>
          
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Jenis Sampah</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>Jumlah</th>
              </tr>
            </thead>
            <tbody>
      `;
      
      // Add table rows
      const rows = tableBody.querySelectorAll('tr');
      rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 5) {
          printContent += `
            <tr>
              <td>${cells[0].textContent.trim()}</td>
              <td>${cells[1].textContent.trim()}</td>
              <td>${cells[2].textContent.trim()}</td>
              <td>${cells[3].textContent.trim()}</td>
              <td>${cells[4].textContent.trim()}</td>
            </tr>
          `;
        }
      });
      
      printContent += `
            </tbody>
          </table>
        </body>
        </html>
      `;
      
      // Open print window
      const printWindow = window.open('', '_blank');
      printWindow.document.write(printContent);
      printWindow.document.close();
      
      // Wait for content to load then print
      printWindow.onload = function() {
        printWindow.print();
        printWindow.close();
      };
      
      // Show success message
      showNotification('Data berhasil dicetak!', 'success');
    }
    
    // Function to print receipt as PNG
    function printReceipt() {
      // Get modal data
      const wasteType = document.getElementById('modalWasteType').textContent;
      const wasteCategory = document.getElementById('modalWasteCategory').textContent;
      const wasteAmount = document.getElementById('modalWasteAmount').textContent;
      const wastePrice = document.getElementById('modalWastePrice').textContent;
      const wasteTotal = document.getElementById('modalWasteTotal').textContent;
      
      // Create receipt content
      const receiptContent = `
        <!DOCTYPE html>
        <html>
        <head>
          <title>Struk Setoran Sampah</title>
          <style>
            body {
              font-family: 'Courier New', monospace;
              margin: 0;
              padding: 20px;
              background: white;
              width: 300px;
            }
            .receipt {
              border: 2px solid #000;
              padding: 15px;
              background: white;
            }
            .header {
              text-align: center;
              border-bottom: 1px solid #000;
              padding-bottom: 10px;
              margin-bottom: 15px;
            }
            .title {
              font-size: 18px;
              font-weight: bold;
              margin-bottom: 5px;
            }
            .subtitle {
              font-size: 12px;
              color: #666;
            }
            .info-row {
              display: flex;
              justify-content: space-between;
              margin-bottom: 8px;
              font-size: 12px;
            }
            .label {
              font-weight: bold;
            }
            .value {
              text-align: right;
            }
            .total {
              border-top: 1px solid #000;
              padding-top: 10px;
              margin-top: 10px;
              font-weight: bold;
              font-size: 14px;
            }
            .footer {
              text-align: center;
              margin-top: 15px;
              font-size: 10px;
              color: #666;
            }
            .timestamp {
              font-size: 10px;
              color: #999;
              text-align: center;
              margin-top: 10px;
            }
          </style>
        </head>
        <body>
          <div class="receipt">
            <div class="header">
              <div class="title">BIJAK SAMPAH</div>
              <div class="subtitle">Bank Sampah Digital</div>
            </div>
            
            <div class="info-row">
              <span class="label">Jenis Sampah:</span>
              <span class="value">${wasteType}</span>
            </div>
            
            <div class="info-row">
              <span class="label">Kategori:</span>
              <span class="value">${wasteCategory}</span>
            </div>
            
            <div class="info-row">
              <span class="label">Jumlah:</span>
              <span class="value">${wasteAmount}</span>
            </div>
            
            <div class="info-row">
              <span class="label">Harga per Satuan:</span>
              <span class="value">${wastePrice}</span>
            </div>
            
            <div class="total info-row">
              <span class="label">TOTAL NILAI:</span>
              <span class="value">${wasteTotal}</span>
            </div>
            
            <div class="footer">
              Terima kasih telah berkontribusi<br>
              untuk lingkungan yang lebih baik
            </div>
            
            <div class="timestamp">
              ${new Date().toLocaleString('id-ID')}
            </div>
          </div>
        </body>
        </html>
      `;
      
      // Create a new window for the receipt
      const receiptWindow = window.open('', '_blank', 'width=350,height=600');
      receiptWindow.document.write(receiptContent);
      receiptWindow.document.close();
      
      // Wait for content to load then convert to PNG
      receiptWindow.onload = function() {
        setTimeout(() => {
          // Use html2canvas to convert to PNG
          if (typeof html2canvas !== 'undefined') {
            html2canvas(receiptWindow.document.querySelector('.receipt'), {
              backgroundColor: '#ffffff',
              width: 300,
              height: 500,
              scale: 2,
              useCORS: true,
              allowTaint: true
            }).then(canvas => {
              // Convert canvas to PNG and download
              const link = document.createElement('a');
              link.download = `struk-setoran-${wasteType.toLowerCase().replace(/\s+/g, '-')}-${new Date().getTime()}.png`;
              link.href = canvas.toDataURL('image/png');
              link.click();
              
              // Close the receipt window
              receiptWindow.close();
              
              // Show success notification
              showNotification('Struk berhasil diunduh dalam format PNG!', 'success');
            }).catch(error => {
              console.error('Error generating PNG:', error);
              // Fallback: just print the receipt
              receiptWindow.print();
              receiptWindow.close();
              showNotification('Struk berhasil dicetak!', 'success');
            });
          } else {
            // Fallback: just print the receipt
            receiptWindow.print();
            receiptWindow.close();
            showNotification('Struk berhasil dicetak!', 'success');
          }
        }, 500); // Wait 500ms for content to fully load
      };
    }
    
    // Function to show notification
    function showNotification(message, type = 'info') {
      // Create notification element
      const notification = document.createElement('div');
      notification.className = `fixed top-4 right-4 px-4 py-2 rounded-md text-white z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-blue-500'
      }`;
      notification.textContent = message;
      
      // Add to page
      document.body.appendChild(notification);
      
      // Remove after 3 seconds
      setTimeout(() => {
        if (notification.parentNode) {
          notification.parentNode.removeChild(notification);
        }
      }, 3000);
    }
  </script>
</body>
</html>