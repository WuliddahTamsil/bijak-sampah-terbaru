<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Penjemputan Sampah - Bijak Sampah</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #05445E;
      --secondary-color: #75E6DA;
      --accent-color: #f16728;
    }
    
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Inter', sans-serif;
    }
    
    body {
      background-color: #f8f9fc;
      display: flex;
      min-height: 100vh;
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

    .sidebar-footer {
      padding: 0;
      border-top: 1px solid rgba(255,255,255,0.1);
      margin-top: auto;
      flex-shrink: 0;
    }

    /* Main Content */
    .main-content {
      margin-left: 80px;
      width: calc(100% - 80px);
      padding: 30px;
      background-color: #f8f9fc;
      min-height: 100vh;
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

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      padding-bottom: 20px;
      border-bottom: 2px solid #e9ecef;
    }

    .page-title {
      font-size: 28px;
      font-weight: 700;
      color: var(--primary-color);
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .page-title i {
      color: var(--accent-color);
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

    /* Stats Cards */
    .stats-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .stat-card {
      background: white;
      border-radius: 12px;
      padding: 24px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      display: flex;
      align-items: center;
      gap: 20px;
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
      padding: 24px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .table-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .table-header h2 {
      font-size: 20px;
      font-weight: 600;
      color: var(--primary-color);
    }

    .table-actions {
      display: flex;
      gap: 15px;
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

    .data-table {
      width: 100%;
      border-collapse: collapse;
    }

    .data-table th,
    .data-table td {
      padding: 12px 16px;
      text-align: left;
      border-bottom: 1px solid #e5e7eb;
    }

    .data-table th {
      background-color: #f9fafb;
      font-weight: 600;
      color: var(--primary-color);
    }

    .data-table tbody tr:hover {
      background-color: #f9fafb;
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
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="logo-container">
      <div class="logo">
        <img src="{{ asset('asset/img/Logo Alternative_Dark (1).png') }}" alt="Bijak Sampah Logo">
      </div>
      <button class="toggle-collapse" id="toggleCollapse">
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
        <li class="menu-item active">
          <a href="{{ route('penjemputan-sampah-banksampah') }}" style="text-decoration: none; color: inherit;">
            <div class="menu-icon"><i class="fas fa-truck"></i></div>
            <span class="menu-text">Penjemputan Sampah</span>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{ route('penimbangansampah-banksampah') }}" style="text-decoration: none; color: inherit;">
            <div class="menu-icon"><i class="fas fa-weight-hanging"></i></div>
            <span class="menu-text">Penimbangan</span>
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
        <li class="menu-item">
          <a href="{{ route('penjualansampah-banksampah') }}" style="text-decoration: none; color: inherit;">
            <div class="menu-icon"><i class="fas fa-shopping-cart"></i></div>
            <span class="menu-text">Penjualan Sampah</span>
          </a>
        </li>
        <li class="menu-item">
          <div class="menu-icon"><i class="fas fa-cog"></i></div>
          <span class="menu-text">Settings</span>
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
    <div class="header">
      <h1 class="page-title">
        <i class="fas fa-truck"></i> Penjemputan Sampah
      </h1>
      <div class="header-actions">
        <button class="btn-primary">
          <i class="fas fa-plus"></i> Tambah Penjemputan
        </button>
      </div>
    </div>

    <div class="content-section">
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
            <tbody>
              <tr>
                <td>1</td>
                <td>Budi Santoso</td>
                <td>Jl. Sudirman No. 123, Jakarta</td>
                <td>15 Jan 2024</td>
                <td><span class="status-badge waiting">Menunggu</span></td>
                <td>
                  <button class="btn-action"><i class="fas fa-eye"></i></button>
                  <button class="btn-action"><i class="fas fa-edit"></i></button>
                </td>
              </tr>
              <tr>
                <td>2</td>
                <td>Siti Aminah</td>
                <td>Jl. Thamrin No. 45, Jakarta</td>
                <td>15 Jan 2024</td>
                <td><span class="status-badge process">Dalam Proses</span></td>
                <td>
                  <button class="btn-action"><i class="fas fa-eye"></i></button>
                  <button class="btn-action"><i class="fas fa-edit"></i></button>
                </td>
              </tr>
              <tr>
                <td>3</td>
                <td>Ahmad Hidayat</td>
                <td>Jl. Gatot Subroto No. 67, Jakarta</td>
                <td>14 Jan 2024</td>
                <td><span class="status-badge completed">Selesai</span></td>
                <td>
                  <button class="btn-action"><i class="fas fa-eye"></i></button>
                  <button class="btn-action"><i class="fas fa-edit"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  
  <script>
    // Sidebar toggle functionality
    const sidebar = document.getElementById('sidebar');
    const toggleCollapse = document.getElementById('toggleCollapse');

    toggleCollapse.addEventListener('click', function() {
      sidebar.classList.toggle('collapsed');
      const icon = toggleCollapse.querySelector('i');
      if (sidebar.classList.contains('collapsed')) {
        icon.classList.remove('fa-chevron-left');
        icon.classList.add('fa-chevron-right');
      } else {
        icon.classList.remove('fa-chevron-right');
        icon.classList.add('fa-chevron-left');
      }
    });

    // Logout functionality
    document.getElementById('logoutBtn').addEventListener('click', function() {
      // Add your logout logic here
      alert('Anda akan logout');
      // window.location.href = 'login.html';
    });
  </script>
</body>
</html>
