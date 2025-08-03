<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Data Setoran Sampah - Bijak Sampah</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-firestore.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script>
    // Ensure ApexCharts is loaded before any chart operations
    window.addEventListener('load', function() {
      console.log('Window loaded, ApexCharts available:', typeof ApexCharts !== 'undefined');
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

    .sub-menu-item {
      padding: 10px 20px 10px 50px;
      display: flex;
      align-items: center;
      cursor: pointer;
      transition: all 0.3s;
      white-space: nowrap;
      font-size: 14px;
    }

    .sub-menu-item:hover {
      background: rgba(255, 255, 255, 0.1);
    }

    .sub-menu-item.active {
      background: rgba(255, 255, 255, 0.15);
    }

    .menu-icon {
      width: 24px;
      height: 24px;
      margin-right: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
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
      margin: 0;
    }

    .menu-item {
      padding: 12px 20px;
      display: flex;
      align-items: center;
      cursor: pointer;
      transition: all 0.3s ease;
      white-space: nowrap;
      position: relative;
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

    /* Animation */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
      animation: fadeIn 0.5s ease-out forwards;
    }

    /* Loading Spinner */
    .loading-spinner {
      display: inline-block;
      width: 20px;
      height: 20px;
      border: 3px solid rgba(255,255,255,0.3);
      border-radius: 50%;
      border-top-color: #fff;
      animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
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
        <li class="menu-item active">
          <a href="{{ route('datasampah-banksampah') }}" style="text-decoration: none; color: inherit;">
            <div class="menu-icon"><i class="fas fa-trash-alt"></i></div>
            <span class="menu-text">Data Sampah</span>
          </a>
        </li>
        <li class="menu-item">
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
        <h1 class="text-2xl font-bold text-gray-800">Data Setoran Sampah</h1>
        <p class="text-sm text-gray-500">Pantau dan kelola data setoran sampah dari nasabah</p>
      </div>
      <div class="flex items-center space-x-4 w-full md:w-auto">
        <div class="relative flex-grow md:flex-grow-0">
          <input type="text" placeholder="Cari data setoran..." class="pl-10 pr-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm w-full">
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
            <button class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm hover:bg-blue-100 transition-colors">
              <i class="fas fa-file-export mr-1"></i> Export
            </button>
            <button class="px-3 py-1 bg-green-50 text-green-600 rounded-full text-sm hover:bg-green-100 transition-colors">
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
              <!-- Data will be filled by JavaScript -->
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
              <button class="px-2 py-1 text-xs rounded-md bg-red-100 text-red-600" id="debugCharts">
                <i class="fas fa-bug mr-1"></i>Debug Charts
              </button>
            </div>
          </div>
          <div class="chart-container">
            <div id="trendChart"></div>
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
            <div id="compositionChart"></div>
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
          <button class="px-4 py-2 border rounded-md text-sm hover:bg-gray-100">Edit</button>
          <button class="px-4 py-2 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600">Cetak Struk</button>
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
    }

    // Chart instances
    let trendChart, compositionChart;
    let currentChartType = 'line'; // 'line' or 'bar'
    let currentTimeRange = '6months'; // '6months' or '12months'
    let currentCompositionView = 'pie'; // 'pie' or 'donut'

    // Initialize the page
    document.addEventListener('DOMContentLoaded', function() {
      console.log('DOM Content Loaded');
      
      // Load initial data (April)
      loadMonthData(4);
      
      // Initialize charts with multiple attempts
      let chartInitAttempts = 0;
      const maxAttempts = 5;
      
      function attemptChartInit() {
        chartInitAttempts++;
        console.log(`Chart initialization attempt ${chartInitAttempts}/${maxAttempts}`);
        
        if (typeof ApexCharts !== 'undefined') {
          setTimeout(() => {
            initCharts();
          }, 200);
        } else if (chartInitAttempts < maxAttempts) {
          console.log('ApexCharts not ready, retrying...');
          setTimeout(attemptChartInit, 1000);
        } else {
          console.error('Failed to load ApexCharts after multiple attempts');
          // Show fallback message
          const chartContainers = document.querySelectorAll('.chart-container');
          chartContainers.forEach(container => {
            container.innerHTML = '<div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #64748b; font-size: 14px;">Grafik tidak dapat dimuat. Silakan refresh halaman.</div>';
          });
        }
      }
      
      // Start chart initialization
      attemptChartInit();
      
      // Set up event listeners
      setupEventListeners();
    });

    function loadMonthData(month) {
      const monthData = monthlyData[month];
      const monthName = monthNames[month-1];
      
      // Update month title
      document.getElementById('currentMonth').textContent = `${monthName} 2025`;
      
      // Update stats cards
      document.getElementById('totalDepositMonth').textContent = `${monthData.totalKg.toFixed(1)} Kg`;
      document.getElementById('totalActiveUsers').textContent = `${monthData.activeUsers} Orang`;
      document.getElementById('avgDepositPerUser').textContent = `${(monthData.totalKg / monthData.activeUsers).toFixed(2)} Kg`;
      document.getElementById('topWasteType').textContent = monthData.topWaste.name;
      
      // Fill the table
      const tableBody = document.getElementById('wasteTableBody');
      tableBody.innerHTML = '';
      
      let totalKg = 0;
      let totalLiter = 0;
      let totalOther = 0;
      
      monthData.wastes.forEach((waste, index) => {
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
      document.getElementById('startItem').textContent = '1';
      document.getElementById('endItem').textContent = monthData.wastes.length;
      document.getElementById('totalItems').textContent = monthData.wastes.length;
      
      // Update charts
      updateCharts(month);
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
      console.log('DOM ready state:', document.readyState);
      console.log('ApexCharts available:', typeof ApexCharts !== 'undefined');
      
      // Wait for ApexCharts to be available
      if (typeof ApexCharts === 'undefined') {
        console.error('ApexCharts is not loaded! Waiting...');
        setTimeout(initCharts, 500);
        return;
      }
      
      // Check if chart containers exist
      const trendChartContainer = document.querySelector("#trendChart");
      const compositionChartContainer = document.querySelector("#compositionChart");
      
      console.log('Trend chart container:', trendChartContainer);
      console.log('Composition chart container:', compositionChartContainer);
      
      if (!trendChartContainer) {
        console.error('Trend chart container not found!');
        return;
      }
      
      if (!compositionChartContainer) {
        console.error('Composition chart container not found!');
        return;
      }
      
      // Check container dimensions
      console.log('Trend container dimensions:', {
        width: trendChartContainer.offsetWidth,
        height: trendChartContainer.offsetHeight,
        style: trendChartContainer.style.cssText
      });
      
      console.log('Composition container dimensions:', {
        width: compositionChartContainer.offsetWidth,
        height: compositionChartContainer.offsetHeight,
        style: compositionChartContainer.style.cssText
      });
      
      console.log('Creating trend chart...');
      
      // Initialize trend chart with more explicit options
      const trendOptions = {
        series: [{
          name: "Total Sampah",
          data: [32, 45, 52, 43.2, 0, 0]
        }],
        chart: {
          height: 350,
          type: 'line',
          toolbar: {
            show: false
          },
          zoom: {
            enabled: false
          },
          animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 800
          }
        },
        colors: ['#3b82f6'],
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'smooth',
          width: 3
        },
        grid: {
          borderColor: '#e2e8f0',
          strokeDashArray: 4,
          padding: {
            top: 10,
            right: 10,
            bottom: 0,
            left: 10
          }
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
          labels: {
            style: {
              colors: '#64748b',
              fontSize: '12px'
            }
          },
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
          }
        },
        yaxis: {
          labels: {
            style: {
              colors: '#64748b',
              fontSize: '12px'
            },
            formatter: function(value) {
              return value + ' Kg';
            }
          }
        },
        tooltip: {
          y: {
            formatter: function(value) {
              return value + ' Kg';
            }
          }
        }
      };
      
      try {
        trendChart = new ApexCharts(trendChartContainer, trendOptions);
        console.log('Trend chart instance created');
        
        trendChart.render().then(() => {
          console.log('Trend chart rendered successfully');
        }).catch((error) => {
          console.error('Error rendering trend chart:', error);
        });
      } catch (error) {
        console.error('Error creating trend chart:', error);
      }
      
      console.log('Creating composition chart...');
      
      // Initialize composition chart with more explicit options
      const compositionOptions = {
        series: [27.5, 13, 2, 6, 0.7],
        chart: {
          height: 350,
          type: 'pie',
          toolbar: {
            show: false
          },
          animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 800
          }
        },
        labels: ['Plastik Botol', 'Plastik Gelas', 'Kertas', 'Minyak Jelantah', 'Lainnya'],
        colors: ['#3b82f6', '#60a5fa', '#93c5fd', '#f59e0b', '#10b981'],
        legend: {
          position: 'right',
          fontSize: '14px',
          fontFamily: 'Inter, sans-serif',
          labels: {
            colors: '#64748b'
          }
        },
        dataLabels: {
          enabled: true,
          style: {
            fontSize: '12px',
            fontFamily: 'Inter, sans-serif'
          },
          formatter: function(val, opts) {
            return opts.w.config.series[opts.seriesIndex].toFixed(1) + ' Kg';
          }
        },
        plotOptions: {
          pie: {
            donut: {
              labels: {
                show: false
              }
            }
          }
        },
        tooltip: {
          y: {
            formatter: function(value) {
              return value + ' Kg';
            }
          }
        }
      };
      
      try {
        compositionChart = new ApexCharts(compositionChartContainer, compositionOptions);
        console.log('Composition chart instance created');
        
        compositionChart.render().then(() => {
          console.log('Composition chart rendered successfully');
        }).catch((error) => {
          console.error('Error rendering composition chart:', error);
        });
      } catch (error) {
        console.error('Error creating composition chart:', error);
      }
      
      console.log('=== CHART INITIALIZATION COMPLETE ===');
    }

    function updateCharts(month) {
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
      
      trendChart.updateOptions({
        xaxis: {
          categories: labels
        },
        series: [{
          data: data
        }]
      });
      
      // Update composition chart based on current month's data
      const monthData = monthlyData[month];
      let categoryTotals = {
        'plastik': 0,
        'kertas': 0,
        'logam': 0,
        'kaca': 0,
        'organik': 0,
        'lainnya': 0
      };
      
      monthData.wastes.forEach(waste => {
        // Convert all to Kg for comparison
        let amount = waste.amount;
        if (waste.unit === 'Liter') {
          amount = waste.amount * 0.9; // Approximate conversion
        } else if (waste.unit === 'Unit') {
          amount = waste.amount * 0.5; // Approximate conversion
        }
        
        categoryTotals[waste.category] += amount;
      });
      
      // Filter out categories with 0 amount
      const categories = [];
      const amounts = [];
      const colors = ['#3b82f6', '#60a5fa', '#f59e0b', '#10b981', '#8b5cf6', '#ec4899'];
      let colorIndex = 0;
      
      Object.keys(categoryTotals).forEach(category => {
        if (categoryTotals[category] > 0) {
          categories.push(category.charAt(0).toUpperCase() + category.slice(1));
          amounts.push(parseFloat(categoryTotals[category].toFixed(1)));
        }
      });
      
      compositionChart.updateOptions({
        series: amounts,
        labels: categories,
        colors: colors.slice(0, categories.length),
        chart: {
          type: currentCompositionView
        }
      });
    }

    function setupEventListeners() {
      // Month filter change
      document.getElementById('monthFilter').addEventListener('change', function() {
        const selectedMonth = parseInt(this.value);
        loadMonthData(selectedMonth);
      });
      
      // Toggle chart type (line/bar)
      document.getElementById('toggleChartType').addEventListener('click', function() {
        if (currentChartType === 'line') {
          currentChartType = 'bar';
          this.innerHTML = '<i class="fas fa-chart-bar mr-1"></i>Batang';
          trendChart.updateOptions({
            chart: {
              type: 'bar'
            }
          });
        } else {
          currentChartType = 'line';
          this.innerHTML = '<i class="fas fa-chart-line mr-1"></i>Garis';
          trendChart.updateOptions({
            chart: {
              type: 'line'
            }
          });
        }
      });
      
      // Toggle time range (6 months/12 months)
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
      
      // Toggle composition chart view (pie/donut)
      document.getElementById('toggleChartView').addEventListener('click', function() {
        if (currentCompositionView === 'pie') {
          currentCompositionView = 'donut';
          this.innerHTML = '<i class="fas fa-chart-pie mr-1"></i>Pie';
          compositionChart.updateOptions({
            chart: {
              type: 'donut'
            },
            plotOptions: {
              pie: {
                donut: {
                  labels: {
                    show: true,
                    total: {
                      show: true,
                      label: 'Total',
                      formatter: function(w) {
                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0).toFixed(1) + ' Kg';
                      }
                    }
                  }
                }
              }
            }
          });
        } else {
          currentCompositionView = 'pie';
          this.innerHTML = '<i class="fas fa-chart-donut mr-1"></i>Donat';
          compositionChart.updateOptions({
            chart: {
              type: 'pie'
            },
            plotOptions: {
              pie: {
                donut: {
                  labels: {
                    show: false
                  }
                }
              }
            }
          });
        }
      });
      
      // Export chart
      document.getElementById('exportChart').addEventListener('click', function() {
        compositionChart.export({
          type: 'png',
          filename: 'komposisi-sampah-' + document.getElementById('currentMonth').textContent.toLowerCase().replace(' ', '-')
        });
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

      // Debug charts button
      document.getElementById('debugCharts').addEventListener('click', function() {
        console.log('Debugging charts...');
        console.log('Current Chart Type:', currentChartType);
        console.log('Current Time Range:', currentTimeRange);
        console.log('Current Composition View:', currentCompositionView);
        console.log('Trend Chart Instance:', trendChart);
        console.log('Composition Chart Instance:', compositionChart);
        alert('Debugging charts. Check console for details.');
      });
    }
  </script>
</body>
</html>