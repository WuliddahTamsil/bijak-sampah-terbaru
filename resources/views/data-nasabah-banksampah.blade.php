<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - Bijak Sampah</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script type="module">
    // Import the functions you need from the SDKs you need
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
    import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";
    import { getDatabase, ref, onValue } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-database.js";

    // Your web app's Firebase configuration
    const firebaseConfig = {
      apiKey: "AIzaSyAJhkCyNT0be2x6FSzyUz0Ye9xX-QihIBo",
      authDomain: "bijaksampah-aeb82.firebaseapp.com",
      databaseURL: "https://bijaksampah-aeb82-default-rtdb.asia-southeast1.firebasedatabase.app",
      projectId: "bijaksampah-aeb82",
      storageBucket: "bijaksampah-aeb82.firebasestorage.app",
      messagingSenderId: "140467230562",
      appId: "1:140467230562:web:19a34dfefcb6f65bd7fe3b"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);
    const database = getDatabase(app);
  </script>
  <style>
    :root {
      --primary-color: #05445E;
      --secondary-color: #75E6DA;
      --accent-color: #f16728;
      --success-color: #2b8a3e;
      --danger-color: #c0392b;
    }
    
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Inter', sans-serif;
    }
    
    body {
      background: #f8f9fc;
      color: #333;
      min-height: 100vh;
      display: flex;
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

    /* Header Styles */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .header h1 {
      color: var(--primary-color);
      font-size: 28px;
    }

    /* Stats Cards */
    .stats {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .stat-card {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .stat-card h2 {
      font-size: 28px;
      margin: 10px 0;
    }

    .stat-card p {
      color: #666;
    }

    /* Customers Table */
    .customers-container {
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .table-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .search-sort {
      display: flex;
      gap: 15px;
    }

    .search {
      position: relative;
    }

    .search input {
      padding: 10px 15px 10px 35px;
      border: 1px solid #ddd;
      border-radius: 8px;
      width: 250px;
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
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    th {
      font-weight: 600;
      color: var(--primary-color);
    }

    tr:hover {
      background-color: #f5f5f5;
    }

    .status {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 500;
      display: inline-block;
    }

    /* Link styling untuk nama nasabah */
    .customer-name-link {
      color: var(--primary-color);
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .customer-name-link:hover {
      color: var(--accent-color);
      text-decoration: underline;
    }

    .status.active {
      background-color: #e6f7e6;
      color: var(--success-color);
    }

    .status.inactive {
      background-color: #fdeaea;
      color: var(--danger-color);
    }

    /* Profile Dropdown */
    .profile-dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      right: 0;
      background-color: #fff;
      min-width: 160px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
      z-index: 1;
      border-radius: 8px;
      overflow: hidden;
    }

    .dropdown-content a {
      color: #333;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      transition: background-color 0.3s;
    }

    .dropdown-content a:hover {
      background-color: #f5f5f5;
    }

    .dropdown-content.show {
      display: block;
    }

    .avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--primary-color);
      cursor: pointer;
      transition: all 0.3s;
    }

    .avatar:hover {
      transform: scale(1.05);
      box-shadow: 0 4px 12px rgba(5, 68, 94, 0.2);
    }

    /* Responsive Design */
    @media (max-width: 992px) {
      .sidebar {
        width: 80px;
      }
      
      .sidebar .menu-text,
      .sidebar .sub-menu-item {
        display: none;
      }
      
      .sidebar .logo-text {
        display: none;
      }
      
      .sidebar .logo-icon {
        font-size: 22px;
      }
      
      .main-content {
        margin-left: 80px;
        width: calc(100% - 80px);
      }
      
      .search input {
        width: 200px;
      }
    }

    @media (max-width: 768px) {
      .stats {
        grid-template-columns: 1fr;
      }
      
      .search-sort {
        flex-direction: column;
        gap: 10px;
      }
      
      .search input {
        width: 100%;
      }
      
      table {
        display: block;
        overflow-x: auto;
      }
    }

    /* Loading Spinner */
    .spinner {
      display: inline-block;
      width: 20px;
      height: 20px;
      border: 3px solid rgba(0,0,0,0.1);
      border-radius: 50%;
      border-top-color: var(--primary-color);
      animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    .loading-container {
      display: flex;
      justify-content: center;
      padding: 20px;
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
        <li class="sub-menu-item active">
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
          <span class="menu-text">Setting</span>
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
      <h1>Nasabah</h1>
      <div class="profile-dropdown">
        <img id="userAvatar" class="avatar" src="https://ui-avatars.com/api/?name=Admin&background=75E6DA&color=05445E" alt="User" onclick="toggleDropdown()">
        <div id="dropdownMenu" class="dropdown-content">
          <a href="#" id="profileLink"><i class="fas fa-user-circle"></i> Profil Saya</a>
          <a href="#" id="logoutLink"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
      </div>
    </div>

    <div class="stats">
      <div class="stat-card">
        <p>Total Nasabah</p>
        <h2 id="totalCustomers">0</h2>
        <p style="color: var(--success-color)">⬆ 4% bulan ini</p>
      </div>
      <div class="stat-card">
        <p>Nasabah Aktif</p>
        <h2 id="activeCustomers">0</h2>
        <p style="color: var(--danger-color)">⬇ 1% bulan ini</p>
      </div>
      <div class="stat-card">
        <p>Nasabah Non-Aktif</p>
        <h2 id="inactiveCustomers">0</h2>
      </div>
    </div>

    <div class="customers-container">
      <div class="table-header">
        <h2>Semua Nasabah</h2>
        <div class="search-sort">
          <div class="search">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Cari nasabah..." onkeyup="searchCustomers()">
          </div>
          <div class="sort">
            <select id="sortSelect" onchange="sortCustomers()">
              <option value="newest">Terbaru</option>
              <option value="oldest">Terlama</option>
              <option value="active">Aktif</option>
              <option value="inactive">Non-Aktif</option>
            </select>
          </div>
        </div>
      </div>
      
      <table id="customersTable">
        <thead>
          <tr>
            <th>Nama Nasabah</th>
            <th>Alamat</th>
            <th>Kota</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody id="customersTableBody">
          <tr>
            <td colspan="6" class="loading-container">
              <div class="spinner"></div>
              <span style="margin-left: 10px;">Memuat data nasabah...</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    // Konfigurasi Firebase
    const firebaseConfig = {
      apiKey: "YOUR_API_KEY",
      authDomain: "YOUR_PROJECT_ID.firebaseapp.com",
      databaseURL: "https://YOUR_PROJECT_ID.firebaseio.com",
      projectId: "YOUR_PROJECT_ID",
      storageBucket: "YOUR_PROJECT_ID.appspot.com",
      messagingSenderId: "YOUR_SENDER_ID",
      appId: "YOUR_APP_ID"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    const auth = firebase.auth();
    const db = firebase.firestore();
    const database = firebase.database();

    // Fungsi untuk memeriksa status login
    function checkAuthState() {
      auth.onAuthStateChanged(user => {
        if (user) {
          // User is signed in
          console.log('User logged in:', user);
          displayUserInfo(user);
          loadWasteData();
        } else {
          // No user is signed in
          console.log('No user logged in');
          window.location.href = '/login'; // Redirect ke halaman login
        }
      });
    }

    // Fungsi untuk menampilkan info user
    function displayUserInfo(user) {
      // Update foto profil dan nama di navbar
      const userPhoto = user.photoURL || 'https://randomuser.me/api/portraits/women/44.jpg';
      const userName = user.displayName || 'Admin';
      
      document.querySelector('.user-photo').src = userPhoto;
      document.querySelector('.user-name').textContent = userName;
      
      // Jika ingin menampilkan lebih banyak info user
      db.collection('users').doc(user.uid).get().then(doc => {
        if (doc.exists) {
          const userData = doc.data();
          console.log('User data:', userData);
          // Anda bisa menggunakan data ini untuk menampilkan role, dll
        }
      });
    }

    // Fungsi untuk memuat data sampah dari Firebase
    async function loadWasteData() {
      try {
        // Contoh mengambil data dari Firestore
        const querySnapshot = await db.collection('waste_deposits')
          .orderBy('date', 'desc')
          .limit(10)
          .get();
        
        const wastes = [];
        querySnapshot.forEach(doc => {
          wastes.push({
            id: doc.id,
            ...doc.data()
          });
        });
        
        // Update tabel dengan data dari Firebase
        updateWasteTable(wastes);
        
        // Contoh mengambil data dari Realtime Database
        database.ref('monthly_stats').once('value').then(snapshot => {
          const stats = snapshot.val();
          if (stats) {
            updateStatsCards(stats);
          }
        });
        
      } catch (error) {
        console.error('Error loading waste data:', error);
        alert('Gagal memuat data sampah');
      }
    }

    // Fungsi untuk mengupdate tabel dengan data dari Firebase
    function updateWasteTable(wastes) {
      const tableBody = document.getElementById('wasteTableBody');
      tableBody.innerHTML = '';
      
      wastes.forEach((waste, index) => {
        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-50';
        row.innerHTML = `
          <td class="font-medium">${index+1}</td>
          <td>${waste.type}</td>
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
      });
      
      // Update info pagination
      document.getElementById('startItem').textContent = '1';
      document.getElementById('endItem').textContent = wastes.length;
      document.getElementById('totalItems').textContent = wastes.length;
    }

    // Fungsi untuk mengupdate statistik
    function updateStatsCards(stats) {
      document.getElementById('totalDepositMonth').textContent = `${stats.totalDeposit.toFixed(1)} Kg`;
      document.getElementById('totalActiveUsers').textContent = `${stats.activeUsers} Orang`;
      document.getElementById('avgDepositPerUser').textContent = `${stats.avgDeposit.toFixed(2)} Kg`;
      document.getElementById('topWasteType').textContent = stats.topWasteType;
    }

    // Fungsi logout
    function setupLogout() {
      document.getElementById('logoutBtn').addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin logout?')) {
          this.innerHTML = '<div class="loading-spinner mr-2"></div> Logging out...';
          
          auth.signOut().then(() => {
            window.location.href = '/login';
          }).catch(error => {
            console.error('Logout error:', error);
            alert('Gagal logout');
            this.innerHTML = '<i class="fas fa-sign-out-alt"></i> Logout';
          });
        }
      });
    }

    // Initialize aplikasi saat DOM siap
    document.addEventListener('DOMContentLoaded', function() {
      checkAuthState();
      setupLogout();
      
      // Inisialisasi chart dan event listeners lainnya
      initCharts();
      setupEventListeners();
      
      // Load data bulan saat ini
      const currentMonth = new Date().getMonth() + 1;
      loadMonthData(currentMonth);
    });
  </script>
</body>
</html>