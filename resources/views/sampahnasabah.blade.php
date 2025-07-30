<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Sampah - Bijak Sampah</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }

    body {
      background-color: #f8f9fc;
      display: flex;
      min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
      background: linear-gradient(135deg, #75E6DA 0%, #05445E 30%, #05445E 100%);
      color: white;
      padding: 20px 0;
      min-height: 100vh;
      transition: width 0.3s;
      position: fixed;
      left: 0;
      top: 0;
      overflow: hidden;
      box-shadow: 2px 0 10px rgba(0,0,0,0.1);
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
      font-size: 22px;
      font-weight: bold;
      color: white;
      white-space: nowrap;
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
      transition: transform 0.3s ease;
    }

    .sidebar.collapsed .toggle-collapse {
      transform: rotate(180deg);
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
      border-left: 4px solid #f16728;
    }

    .menu-icon {
      width: 24px;
      height: 24px;
      margin-right: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .menu-text {
      font-size: 15px;
      transition: opacity 0.3s;
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

    /* Main Content */
    .main-content {
      margin-left: 250px;
      width: calc(100% - 250px);
      padding: 30px;
      transition: margin-left 0.3s, width 0.3s;
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
    }

    .page-title {
      font-size: 28px;
      color: #0A3A60;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .profile-actions {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .profile-icon {
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: white;
      border-radius: 50%;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      cursor: pointer;
      position: relative;
      transition: all 0.3s;
    }

    .profile-icon:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .profile-icon.notif::after {
      content: '';
      position: absolute;
      top: 5px;
      right: 5px;
      width: 8px;
      height: 8px;
      background: #FF5A5F;
      border-radius: 50%;
      border: 2px solid white;
    }

    .profile-icon i {
      color: #05445E;
      font-size: 18px;
    }

    .avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #05445E;
      cursor: pointer;
      transition: all 0.3s;
    }

    .avatar:hover {
      transform: scale(1.05);
      box-shadow: 0 4px 12px rgba(5, 68, 94, 0.2);
    }

    /* BS Pay Section */
    .bs-pay-section {
      display: flex;
      gap: 20px;
      margin-bottom: 30px;
    }

    .bs-pay-card {
      background: white;
      border-radius: 16px;
      padding: 25px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      display: flex;
      align-items: center;
      gap: 20px;
      transition: all 0.3s ease;
    }

    .bs-pay-card:first-child {
      flex: 1;
      background: linear-gradient(135deg, #f8f9fc 0%, #ffffff 100%);
      border: 1px solid #e0e6ed;
    }

    .bs-pay-card:nth-child(2) {
      flex: 3;
      padding: 0;
      overflow: hidden;
      background: linear-gradient(135deg, #f8f9fc 0%, #ffffff 100%);
      border: 1px solid #e0e6ed;
      justify-content: center;
    }

    .bs-pay-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }

    .bs-pay-logo {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 24px;
      font-weight: bold;
      box-shadow: 0 4px 12px rgba(5, 68, 94, 0.2);
    }

    .bs-pay-info {
      flex: 1;
    }

    .bs-pay-title {
      font-size: 18px;
      color: #666;
      margin-bottom: 5px;
      font-weight: 600;
    }

    .bs-pay-amount {
      font-size: 32px;
      font-weight: 700;
      color: #05445E;
      margin-bottom: 10px;
    }

    .bs-pay-subtitle {
      font-size: 14px;
      color: #666;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .bs-pay-subtitle i {
      color: #4ADE80;
    }

    .pie-chart-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
      padding: 20px;
    }

    .pie-chart-container img {
      max-width: 100%;
      max-height: 100%;
      object-fit: contain;
      transition: all 0.3s ease;
    }

    .pie-chart-container:hover img {
      transform: scale(1.05);
    }

    /* Kategori Section */
    .kategori-section {
      background: white;
      border-radius: 16px;
      padding: 25px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      margin-bottom: 30px;
    }

    .section-title {
      font-size: 22px;
      color: #0a3a60;
      font-weight: 700;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .section-title i {
      color: #05445E;
      font-size: 24px;
    }

    .kategori-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 20px;
    }

    .kategori-card {
      background: #f0f8ff;
      border-radius: 12px;
      padding: 20px;
      transition: all 0.3s;
      border-left: 4px solid #75E6DA;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .kategori-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    .kategori-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(90deg, #75E6DA, #05445E);
    }

    .kategori-icon {
      font-size: 40px;
      color: #05445E;
      margin-bottom: 10px;
      transition: all 0.3s;
    }

    .kategori-card:hover .kategori-icon {
      transform: scale(1.1);
    }

    .kategori-berat {
      font-size: 18px;
      font-weight: 600;
      color: #05445E;
      margin-bottom: 5px;
    }

    .kategori-name {
      font-size: 16px;
      color: #333;
      margin-bottom: 10px;
      font-weight: 600;
    }

    .kategori-total {
      font-size: 14px;
      color: #666;
      background: rgba(117, 230, 218, 0.2);
      padding: 4px 10px;
      border-radius: 20px;
    }

    /* Table Section */
    .table-section {
      background: white;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      margin-bottom: 30px;
    }

    .table-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .filter-group {
      display: flex;
      gap: 15px;
      align-items: center;
    }

    .filter-btn {
      background: white;
      border: 1px solid #ddd;
      padding: 8px 16px;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.3s;
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 14px;
    }

    .filter-btn:hover {
      background: #f5f5f5;
    }

    .filter-btn.active {
      background: linear-gradient(135deg, #05445E 0%, #0A3A60 100%);
      color: white;
      border-color: #05445E;
    }

    .date-filter {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .date-input {
      padding: 8px 12px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 14px;
      width: 150px;
      color: #333;
    }

    /* DataTables Customization */
    #riwayatTable {
      width: 100% !important;
      border-collapse: separate;
      border-spacing: 0 10px;
    }

    #riwayatTable thead th {
      background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
      color: white;
      font-weight: 600;
      padding: 12px 15px;
      border: none;
      text-align: left;
    }

    #riwayatTable thead th:first-child {
      border-top-left-radius: 8px;
      border-bottom-left-radius: 8px;
    }

    #riwayatTable thead th:last-child {
      border-top-right-radius: 8px;
      border-bottom-right-radius: 8px;
    }

    #riwayatTable tbody tr {
      background: white;
      transition: all 0.3s;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      border-radius: 8px;
    }

    #riwayatTable tbody tr:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    #riwayatTable tbody td {
      padding: 12px 15px;
      border: none;
      border-bottom: 1px solid #f0f0f0;
    }
    
    #riwayatTable tbody tr td:first-child {
      border-top-left-radius: 8px;
      border-bottom-left-radius: 8px;
    }
    
    #riwayatTable tbody tr td:last-child {
      border-top-right-radius: 8px;
      border-bottom-right-radius: 8px;
    }

    .action-btn {
      background: none;
      border: none;
      color: #05445E;
      cursor: pointer;
      font-size: 18px;
      padding: 5px;
      transition: all 0.2s;
      border-radius: 50%;
      width: 30px;
      height: 30px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .action-btn:hover {
      background: #f0f8ff;
      transform: scale(1.1);
      color: #0A3A60;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
      padding: 8px 12px;
      border-radius: 8px;
      border: 1px solid #ddd;
      margin: 0 3px;
      transition: all 0.3s;
      color: #333 !important;
      background: white;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
      background: linear-gradient(135deg, #05445E 0%, #0A3A60 100%) !important;
      color: white !important;
      border-color: #05445E !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
      background: linear-gradient(135deg, #05445E 0%, #0A3A60 100%) !important;
      color: white !important;
      border-color: #05445E !important;
    }

    .dataTables_wrapper .dataTables_filter input {
      padding: 8px 12px;
      border: 1px solid #ddd;
      border-radius: 8px;
      margin-left: 10px;
    }

    .dataTables_wrapper .dataTables_length select {
      padding: 8px 12px;
      border: 1px solid #ddd;
      border-radius: 8px;
    }

    /* Footer */
    .footer {
      text-align: center;
      margin-top: 50px;
      font-size: 14px;
      color: #666;
    }

    .footer strong {
      font-weight: 700;
      color: #05445E;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
      .filter-group {
        flex-direction: column;
        align-items: flex-start;
      }
      
      .bs-pay-section {
        flex-direction: column;
      }
      
      .bs-pay-card:first-child {
        flex: 1;
      }

      .bs-pay-card:nth-child(2) {
        flex: 1;
        height: 250px;
      }
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 80px;
      }
      
      .sidebar .menu-text,
      .sidebar .logo-text {
        display: none;
      }
      
      .sidebar .logo-icon {
        font-size: 22px;
      }
      
      .main-content {
        margin-left: 80px;
        width: calc(100% - 80px);
        padding: 20px;
      }

      .header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
      }

      .profile-actions {
        width: 100%;
        justify-content: flex-end;
      }

      .table-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
      }

      .filter-group {
        width: 100%;
      }

      .date-filter {
        width: 100%;
        justify-content: space-between;
      }

      .date-input {
        width: calc(50% - 5px);
      }
    }

    /* Animation for buttons */
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }

    .pulse-animation {
      animation: pulse 1.5s infinite;
    }

    /* Tooltip for action buttons */
    .tooltip {
      position: relative;
      display: inline-block;
    }

    .tooltip .tooltiptext {
      visibility: hidden;
      width: 120px;
      background-color: #05445E;
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

    .tooltip .tooltiptext::after {
      content: "";
      position: absolute;
      top: 100%;
      left: 50%;
      margin-left: -5px;
      border-width: 5px;
      border-style: solid;
      border-color: #05445E transparent transparent transparent;
    }

    .tooltip:hover .tooltiptext {
      visibility: visible;
      opacity: 1;
    }
    /* Popup Modal Styles */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 1000;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }

    .modal-overlay.active {
      opacity: 1;
      visibility: visible;
    }

    .modal-container {
      background: white;
      border-radius: 16px;
      width: 90%;
      max-width: 500px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      transform: translateY(20px);
      transition: all 0.3s ease;
      overflow: hidden;
    }

    .modal-overlay.active .modal-container {
      transform: translateY(0);
    }

    .modal-header {
      background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
      color: white;
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .modal-header h3 {
      margin: 0;
      font-size: 20px;
      font-weight: 600;
    }

    .modal-close {
      background: none;
      border: none;
      color: white;
      font-size: 24px;
      cursor: pointer;
      transition: transform 0.2s;
    }

    .modal-close:hover {
      transform: rotate(90deg);
    }

    .modal-body {
      padding: 25px;
    }

    .detail-row {
      display: flex;
      margin-bottom: 15px;
      padding-bottom: 15px;
      border-bottom: 1px solid #eee;
    }

    .detail-row:last-child {
      border-bottom: none;
      margin-bottom: 0;
      padding-bottom: 0;
    }

    .detail-label {
      width: 120px;
      font-weight: 500;
      color: #666;
    }

    .detail-value {
      flex: 1;
      font-weight: 600;
      color: #05445E;
    }

    .detail-icon {
      width: 40px;
      height: 40px;
      background: #f0f8ff;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
      color: #05445E;
      font-size: 18px;
    }

    .detail-category {
      display: flex;
      align-items: center;
    }

    .detail-points {
      font-size: 24px;
      font-weight: 700;
      color: #05445E;
      text-align: center;
      margin: 20px 0;
      padding: 15px;
      background: #f8f9fc;
      border-radius: 10px;
    }

    .detail-points small {
      font-size: 14px;
      font-weight: 500;
      color: #666;
      display: block;
    }

    .modal-footer {
      padding: 15px 25px;
      background: #f8f9fc;
      display: flex;
      justify-content: flex-end;
      border-top: 1px solid #eee;
    }

    .modal-btn {
      padding: 10px 20px;
      border-radius: 8px;
      border: none;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s;
    }

    .modal-btn-close {
      background: #e0e6ed;
      color: #666;
    }

    .modal-btn-close:hover {
      background: #d1d9e6;
    }

    .modal-btn-primary {
      background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
      color: white;
      margin-left: 10px;
    }

    .modal-btn-primary:hover {
      opacity: 0.9;
      transform: translateY(-2px);
    }

    /* Animation for modal */
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideUp {
      from { transform: translateY(20px); }
      to { transform: translateY(0); }
    }
  </style>
</head>
<body>

    <div class="sidebar" id="sidebar">
    <div class="logo-container">
      <div class="logo">
        <span class="logo-icon"><i class="fas fa-recycle"></i></span>
        <span class="logo-text">Bijak<span>Sampah</span></span>
      </div>
      <button class="toggle-collapse" id="toggleCollapse">
        <i class="fas fa-chevron-left"></i>
      </button>
    </div>
    
    <ul class="menu-items">
      <li class="menu-item">
        <div class="menu-icon"><i class="fas fa-home"></i></div>
        <span class="menu-text">Dashboard</span>
      </li>
      <li class="menu-item">
        <div class="menu-icon"><i class="fas fa-users"></i></div>
        <span class="menu-text">Komunitas</span>
      </li>
      <li class="menu-item active">
        <div class="menu-icon"><i class="fas fa-trash-alt"></i></div>
        <span class="menu-text">Riwayat Sampah</span>
      </li>
      <li class="menu-item">
        <div class="menu-icon"><i class="fas fa-coins"></i></div>
        <span class="menu-text">Poin Mu</span>
      </li>
      <li class="menu-item">
        <div class="menu-icon"><i class="fas fa-history"></i></div>
        <span class="menu-text">Riwayat Transaksi</span>
      </li>
      <li class="menu-item">
        <div class="menu-icon"><i class="fas fa-store"></i></div>
        <span class="menu-text">Marketplace</span>
      </li>
      <li class="menu-item">
        <div class="menu-icon"><i class="fas fa-cog"></i></div>
        <span class="menu-text">Settings</span>
      </li>
      <li class="menu-item">
        <div class="menu-icon"><i class="fas fa-sign-out-alt"></i></div>
        <span class="menu-text">Logout</span>
      </li>
    </ul>
  </div>

    <div class="main-content">
    <div class="header">
      <h1 class="page-title"><i class="fas fa-history"></i> Riwayat Sampah</h1>
      <div class="profile-actions">
        <div class="profile-icon notif" id="notifBtn" title="Notifikasi">
          <i class="fas fa-bell"></i>
        </div>
        <div class="profile-icon" id="searchBtn" title="Cari">
          <i class="fas fa-search"></i>
        </div>
        <img class="avatar" src="https://ui-avatars.com/api/?name=Nasabah&background=75E6DA&color=05445E" alt="Profile" id="profileBtn">
      </div>
    </div>

        <div class="bs-pay-section">
      <div class="bs-pay-card">
        <div class="bs-pay-logo">
          BS
        </div>
        <div class="bs-pay-info">
          <div class="bs-pay-title">BS, PAY!</div>
          <div class="bs-pay-amount">4.297 Koin</div>
          <div class="bs-pay-subtitle"><i class="fas fa-arrow-up"></i> Pemasukan bulan ini</div>
        </div>
      </div>
      
            <div class="bs-pay-card">
        <div class="pie-chart-container">
          <img src="asset/img/pieChart.png" alt="Pie Chart">
        </div>
      </div>
    </div>

        <div class="kategori-section">
      <h2 class="section-title"><i class="fas fa-list"></i> Kategori Sampah di Bijak Sampah</h2>
      
      <div class="kategori-grid">
        <div class="kategori-card">
          <i class="kategori-icon fas fa-bolt"></i>
          <div class="kategori-berat">1 kg</div>
          <div class="kategori-name">Besi</div>
          <div class="kategori-total">Total: 883 poin</div>
        </div>
        
        <div class="kategori-card">
          <i class="kategori-icon fas fa-bottle-water"></i>
          <div class="kategori-berat">1 kg</div>
          <div class="kategori-name">Plastik</div>
          <div class="kategori-total">Total: 116 poin</div>
        </div>
        
        <div class="kategori-card">
          <i class="kategori-icon fas fa-file-alt"></i>
          <div class="kategori-berat">1 kg</div>
          <div class="kategori-name">Kertas</div>
          <div class="kategori-total">Total: 393 poin</div>
        </div>
        
        <div class="kategori-card">
          <i class="kategori-icon fas fa-laptop"></i>
          <div class="kategori-berat">1 kg</div>
          <div class="kategori-name">Elektronik</div>
          <div class="kategori-total">Total: 564 poin</div>
        </div>
        
        <div class="kategori-card">
          <i class="kategori-icon fas fa-wine-glass"></i>
          <div class="kategori-berat">1 kg</div>
          <div class="kategori-name">Kaca</div>
          <div class="kategori-total">Total: 450 poin</div>
        </div>
        
        <div class="kategori-card">
          <i class="kategori-icon fas fa-box-open"></i>
          <div class="kategori-berat">0</div>
          <div class="kategori-name">Lainnya</div>
          <div class="kategori-total">Total: 0 poin</div>
        </div>
      </div>
    </div>

        <div class="table-section">
      <div class="table-header">
        <h2 class="section-title"><i class="fas fa-table"></i> Pemasukan</h2>
        <div class="filter-group">
          <div class="date-filter">
            <input type="text" class="date-input" id="startDate" placeholder="Mulai Tanggal">
            <span>s/d</span>
            <input type="text" class="date-input" id="endDate" placeholder="Sampai Tanggal">
          </div>
          <button class="filter-btn active" id="allFilter">
            <i class="fas fa-list"></i> Semua
          </button>
          <button class="filter-btn" id="monthFilter">
            <i class="fas fa-calendar-alt"></i> Bulan Ini
          </button>
        </div>
      </div>

      <table id="riwayatTable" class="display" style="width:100%">
        <thead>
          <tr>
            <th>No.</th>
            <th>Tanggal</th>
            <th>Kategori</th>
            <th>Berat Sampah</th>
            <th>Koin</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
                  </tbody>
      </table>
    </div>

    <!-- Modal Popup -->
  <div class="modal-overlay" id="detailModal">
    <div class="modal-container">
      <div class="modal-header">
        <h3>Detail Transaksi</h3>
        <button class="modal-close" id="modalClose">&times;</button>
      </div>
      <div class="modal-body" id="modalBody">
        <!-- Content will be inserted here dynamically -->
      </div>
      <div class="modal-footer">
        <button class="modal-btn modal-btn-close" id="modalBtnClose">Tutup</button>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
  <script>
    $(document).ready(function () {
      // [Previous JavaScript code remains the same until the action button click handler...]

      // Aksi tombol di tabel dengan popup detail
      $(document).on('click', '.action-btn', function() {
        const row = $(this).closest('tr');
        const date = row.find('td:nth-child(2)').text();
        const category = row.find('td:nth-child(3)').text().trim();
        const weight = row.find('td:nth-child(4)').text();
        const points = row.find('td:nth-child(5)').text();
        
        // Extract category name (remove icon)
        const categoryName = category.replace(/<[^>]*>/g, '').trim();
        
        // Get category icon
        const categoryIcon = $(row.find('td:nth-child(3) i')).attr('class');
        
        // Calculate points per kg
        const weightValue = parseFloat(weight);
        const pointsValue = parseInt(points.replace(/\./g, ''));
        const pointsPerKg = (pointsValue / weightValue).toFixed(0);
        
        // Format modal content
        const modalContent = `
          <div class="detail-row">
            <div class="detail-icon"><i class="${categoryIcon}"></i></div>
            <div style="flex:1">
              <div class="detail-category">
                <div style="font-weight:600;color:#05445E;font-size:18px">${categoryName}</div>
              </div>
              <div style="font-size:14px;color:#666">${date}</div>
            </div>
          </div>
          
          <div class="detail-points">
            ${points} Koin
            <small>${weight} × ${pointsPerKg} koin/kg</small>
          </div>
          
          <div class="detail-row">
            <div class="detail-label">Status</div>
            <div class="detail-value"><span style="display:inline-block;padding:4px 10px;background:#e3f9e5;color:#1a7a2e;border-radius:20px;font-size:13px;font-weight:500"><i class="fas fa-check-circle"></i> Selesai</span></div>
          </div>
          
          <div class="detail-row">
            <div class="detail-label">Waktu Transaksi</div>
            <div class="detail-value">${getRandomTime()}</div>
          </div>
          
          <div class="detail-row">
            <div class="detail-label">Lokasi</div>
            <div class="detail-value">Bank Sampah ${getRandomLocation()}</div>
          </div>
          
          <div class="detail-row">
            <div class="detail-label">ID Transaksi</div>
            <div class="detail-value">BS-${Math.random().toString(36).substr(2, 8).toUpperCase()}</div>
          </div>
        `;
        
        // Insert content and show modal
        $('#modalBody').html(modalContent);
        $('#detailModal').addClass('active');
        
        // Add animation class
        setTimeout(() => {
          $('.modal-container').addClass('animated');
        }, 10);
      });

      // Function to generate random time
      function getRandomTime() {
        const hours = Math.floor(Math.random() * 12) + 8; // Between 8-19
        const minutes = Math.floor(Math.random() * 60);
        return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')} WIB`;
      }

      // Function to generate random location
      function getRandomLocation() {
        const locations = [
          "Sudirman", 
          "Thamrin", 
          "Kebayoran", 
          "Pondok Indah", 
          "Grogol", 
          "Cipete", 
          "Kemang"
        ];
        return locations[Math.floor(Math.random() * locations.length)];
      }

      // Close modal
      $('#modalClose, #modalBtnClose').click(function() {
        $('#detailModal').removeClass('active');
      });

      // Close modal when clicking outside
      $('#detailModal').click(function(e) {
        if ($(e.target).hasClass('modal-overlay')) {
          $(this).removeClass('active');
        }
      });

      // [Rest of the previous JavaScript code remains the same...]
    });
  </script>


        <div class="footer">
      Created by <strong>TEK(G)</strong> | All Right Reserved!
    </div>
  </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
  <script>
    $(document).ready(function () {
      // Data dummy yang lebih realistis dengan variasi tanggal dan berat pecahan
      const dummyData = [
        { date: '28/07/2025', day: 'Senin', category: 'Plastik', weight: 1.2, pointsPerKg: 116 },
        { date: '27/07/2025', day: 'Minggu', category: 'Besi', weight: 1.5, pointsPerKg: 883 },
        { date: '25/07/2025', day: 'Jumat', category: 'Kertas', weight: 0.8, pointsPerKg: 393 },
        { date: '22/07/2025', day: 'Selasa', category: 'Plastik', weight: 2.3, pointsPerKg: 116 },
        { date: '20/07/2025', day: 'Minggu', category: 'Kaca', weight: 1.7, pointsPerKg: 450 },
        { date: '18/07/2025', day: 'Jumat', category: 'Elektronik', weight: 0.5, pointsPerKg: 564 },
        { date: '15/07/2025', day: 'Selasa', category: 'Kertas', weight: 1.0, pointsPerKg: 393 },
        { date: '12/07/2025', day: 'Sabtu', category: 'Besi', weight: 2.2, pointsPerKg: 883 },
        { date: '10/07/2025', day: 'Kamis', category: 'Plastik', weight: 1.8, pointsPerKg: 116 },
        { date: '05/07/2025', day: 'Sabtu', category: 'Kaca', weight: 0.9, pointsPerKg: 450 },
        { date: '30/06/2025', day: 'Senin', category: 'Elektronik', weight: 1.3, pointsPerKg: 564 },
        { date: '28/06/2025', day: 'Sabtu', category: 'Kertas', weight: 2.5, pointsPerKg: 393 },
        { date: '25/06/2025', day: 'Rabu', category: 'Besi', weight: 1.1, pointsPerKg: 883 },
        { date: '20/06/2025', day: 'Jumat', category: 'Plastik', weight: 0.7, pointsPerKg: 116 },
        { date: '18/06/2025', day: 'Rabu', category: 'Kaca', weight: 1.4, pointsPerKg: 450 }
      ];

      // Fungsi untuk mengisi tabel dengan data
      function populateTable() {
        const tableBody = $('#riwayatTable tbody');
        tableBody.empty();
        dummyData.forEach((item, index) => {
          const points = (item.weight * item.pointsPerKg).toFixed(0);
          const row = `
            <tr>
              <td>${index + 1}</td>
              <td>${item.day}, ${item.date}</td>
              <td>
                <div style="display: flex; align-items: center; gap: 8px;">
                  ${getCategoryIcon(item.category)}
                  ${item.category}
                </div>
              </td>
              <td>${item.weight.toFixed(1)} kg</td>
              <td><strong>${points}</strong></td>
              <td>
                <div class="tooltip">
                  <button class="action-btn" title="Detail"><i class="fas fa-eye"></i></button>
                  <span class="tooltiptext">Lihat Detail</span>
                </div>
              </td>
            </tr>
          `;
          tableBody.append(row);
        });
      }

      // Fungsi untuk mendapatkan ikon berdasarkan kategori
      function getCategoryIcon(category) {
        const icons = {
          'Plastik': 'fas fa-bottle-water',
          'Besi': 'fas fa-bolt',
          'Kertas': 'fas fa-file-alt',
          'Elektronik': 'fas fa-laptop',
          'Kaca': 'fas fa-wine-glass',
          'Lainnya': 'fas fa-box-open'
        };
        return `<i class="${icons[category] || 'fas fa-trash-alt'}" style="color: #05445E;"></i>`;
      }

      populateTable();

      // Inisialisasi DataTables
      const table = $('#riwayatTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 20, 50],
        searching: true,
        info: true,
        language: {
          search: "Cari:",
          lengthMenu: "Tampilkan _MENU_ entri",
          info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
          paginate: {
            next: "Berikutnya",
            previous: "Sebelumnya"
          }
        }
      });

      // Inisialisasi datepicker
      flatpickr("#startDate, #endDate", {
        dateFormat: "d/m/Y",
        locale: "id",
        allowInput: true
      });

      // Filter tanggal
      $('#startDate, #endDate').on('change', function() {
        table.draw();
      });

      // Filter bulan ini
      $('#monthFilter').click(function() {
        const now = new Date();
        const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
        const lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);
        
        $('#startDate').val(flatpickr.formatDate(firstDay, "d/m/Y"));
        $('#endDate').val(flatpickr.formatDate(lastDay, "d/m/Y"));
        table.draw();
        
        // Update button active state
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
      });

      // Filter semua
      $('#allFilter').click(function() {
        $('#startDate').val('');
        $('#endDate').val('');
        table.draw();
        
        // Update button active state
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
      });

      // Custom filter untuk tanggal
      $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
          const startDateStr = $('#startDate').val();
          const endDateStr = $('#endDate').val();
          
          if (!startDateStr && !endDateStr) {
            return true;
          }
          
          const dateStr = data[1].split(',')[1].trim(); // Ambil bagian tanggal dari "Hari, DD/MM/YYYY"
          const dateParts = dateStr.split('/');
          const rowDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
          
          let start = null;
          if (startDateStr) {
            const startParts = startDateStr.split('/');
            start = new Date(startParts[2], startParts[1] - 1, startParts[0]);
          }
          
          let end = null;
          if (endDateStr) {
            const endParts = endDateStr.split('/');
            end = new Date(endParts[2], endParts[1] - 1, endParts[0]);
            end.setHours(23, 59, 59, 999);
          }
          
          return (
            (!start || rowDate >= start) &&
            (!end || rowDate <= end)
          );
        }
      );

      // Toggle sidebar
      $('#toggleCollapse').click(function() {
        $('#sidebar').toggleClass('collapsed');
        setTimeout(() => {
          table.columns.adjust().draw();
        }, 300);
      });

      // Tombol aksi profil dengan animasi
      $('#notifBtn, #searchBtn, #profileBtn').click(function() {
        $(this).addClass('pulse-animation');
        setTimeout(() => {
          $(this).removeClass('pulse-animation');
          // Simulasikan notifikasi
          if ($(this).attr('id') === 'notifBtn') {
            alert('Anda memiliki 3 notifikasi baru!');
          } else if ($(this).attr('id') === 'searchBtn') {
            alert('Fitur pencarian akan segera tersedia!');
          } else {
            alert('Profil pengguna akan ditampilkan!');
          }
        }, 500);
      });
      
      // Aksi tombol di tabel dengan feedback visual
      $(document).on('click', '.action-btn', function() {
        const row = $(this).closest('tr');
        row.css('background-color', '#f0f8ff');
        setTimeout(() => {
          row.css('background-color', '');
          // Tampilkan detail transaksi
          const date = row.find('td:nth-child(2)').text();
          const category = row.find('td:nth-child(3)').text().trim();
          const weight = row.find('td:nth-child(4)').text();
          const points = row.find('td:nth-child(5)').text();
          
  
        }, 200);
      });
    });
  </script>
</body>
</html>