<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Data Nasabah - Bijak Sampah</title>
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

    // Fungsi untuk memeriksa status login
    window.checkAuthState = () => {
      onAuthStateChanged(auth, (user) => {
        if (user) {
          // User is signed in
          console.log('User logged in:', user);
          window.displayUserInfo(user);
          window.loadCustomerData(); // Memanggil fungsi yang benar
        } else {
          // No user is signed in
          console.log('No user logged in');
          window.location.href = '/login'; // Redirect ke halaman login
        }
      });
    };

    // Fungsi untuk menampilkan info user (dummy)
    window.displayUserInfo = (user) => {
      const userAvatar = document.getElementById('userAvatar');
      // Anda bisa mengganti ini dengan foto profil asli jika tersedia
      userAvatar.src = user.photoURL || 'https://ui-avatars.com/api/?name=Admin&background=75E6DA&color=05445E';
    };

    // Fungsi untuk memuat data nasabah dari Firebase
    window.loadCustomerData = () => {
      console.log('Loading customer data...');
      const customersRef = ref(database, 'nasabah'); // Mengambil data dari koleksi 'nasabah'
      
      onValue(customersRef, (snapshot) => {
        const customersTableBody = document.getElementById('customersTableBody');
        customersTableBody.innerHTML = ''; // Hapus spinner atau data lama

        if (snapshot.exists()) {
          const customers = snapshot.val();
          let totalCustomers = 0;
          let activeCustomers = 0;
          let inactiveCustomers = 0;

          // Mengambil semua nasabah, termasuk sub-node jika ada
          Object.keys(customers).forEach(key => {
            const customer = customers[key];
            if (customer) {
              totalCustomers++;
              if (customer.status === 'aktif') {
                activeCustomers++;
              } else {
                inactiveCustomers++;
              }

              const row = document.createElement('tr');
              row.innerHTML = `
                <td><a href="#" class="customer-name-link">${customer.nama}</a></td>
                <td>${customer.alamat || 'N/A'}</td>
                <td>${customer.kota || 'N/A'}</td>
                <td>${customer.email || 'N/A'}</td>
                <td>${customer.telepon || 'N/A'}</td>
                <td><span class="status ${customer.status === 'aktif' ? 'active' : 'inactive'}">${customer.status}</span></td>
              `;
              customersTableBody.appendChild(row);
            }
          });

          // Update stats cards
          document.getElementById('totalCustomers').textContent = totalCustomers;
          document.getElementById('activeCustomers').textContent = activeCustomers;
          document.getElementById('inactiveCustomers').textContent = inactiveCustomers;

        } else {
          customersTableBody.innerHTML = '<tr><td colspan="6" class="text-center">Tidak ada data nasabah.</td></tr>';
        }
      }, (error) => {
        console.error('Error loading customer data:', error);
        customersTableBody.innerHTML = '<tr><td colspan="6" class="text-center text-red-500">Gagal memuat data.</td></tr>';
      });
    };

    // Fungsi untuk toggle dropdown
    window.toggleDropdown = () => {
      document.getElementById("dropdownMenu").classList.toggle("show");
    };

    // Fungsi logout
    window.setupLogout = () => {
      document.getElementById('logoutBtn').addEventListener('click', () => {
        if (confirm('Apakah Anda yakin ingin logout?')) {
          signOut(auth).then(() => {
            window.location.href = '/login';
          }).catch(error => {
            console.error('Logout error:', error);
            alert('Gagal logout');
          });
        }
      });
    };

    // Initialize aplikasi saat DOM siap
    window.addEventListener('DOMContentLoaded', () => {
      window.checkAuthState();
      window.setupLogout();
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
            margin: 0;
            padding: 0;
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
            
            .main-content {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
        }

        @media (max-width: 480px) {
            .stats {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .search-sort {
                width: 100%;
                justify-content: flex-start;
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

        /* Customers Container Full Width */
        .customers-container {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .table-header {
            width: 100%;
            margin-bottom: 20px;
        }

        .search-sort {
            width: 100%;
            justify-content: flex-end;
        }

        /* Table Full Width */
        #customersTable {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        #customersTable th,
        #customersTable td {
            word-wrap: break-word;
            max-width: 200px;
        }
  </style>
</head>
<body class="bg-gray-50" onload="checkAuthState()">

        <div class="flex min-h-screen bg-gray-50 w-full" x-data="{ sidebarOpen: false, activeMenu: 'data-nasabah' }" x-init="activeMenu = 'data-nasabah'">
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
                            class="flex items-center gap-3 p-2 rounded-lg whitespace-nowrap w-full text-sm hover:bg-white/10 hover:shadow-sm transition-colors duration-200 bg-white/20"
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

        <div class="p-6" style="padding-top: 60px; width: 100%; max-width: 100%;">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Data Nasabah</h1>
                    <p class="text-sm text-gray-500">Kelola data nasabah bank sampah</p>
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

            <div class="customers-container" style="width: 100%;">
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
    </div>
  </div>

  <script>
    // Fungsi untuk memuat data nasabah dari Firebase (perbaikan)
    // Sisa fungsi lainnya dari file asli sudah benar, jadi tidak perlu diubah
    const loadCustomerData = () => {
      console.log('Loading customer data...');
      const customersRef = ref(database, 'nasabah'); // Mengambil data dari koleksi 'nasabah'
      
      onValue(customersRef, (snapshot) => {
        const customersTableBody = document.getElementById('customersTableBody');
        customersTableBody.innerHTML = ''; // Hapus spinner atau data lama

        if (snapshot.exists()) {
          const customers = snapshot.val();
          let totalCustomers = 0;
          let activeCustomers = 0;
          let inactiveCustomers = 0;

          // Mengambil semua nasabah, termasuk sub-node jika ada
          Object.keys(customers).forEach(key => {
            const customer = customers[key];
            if (customer) {
              totalCustomers++;
              if (customer.status === 'aktif') {
                activeCustomers++;
              } else {
                inactiveCustomers++;
              }

              const row = document.createElement('tr');
              row.innerHTML = `
                <td><a href="#" class="customer-name-link">${customer.nama}</a></td>
                <td>${customer.alamat || 'N/A'}</td>
                <td>${customer.kota || 'N/A'}</td>
                <td>${customer.email || 'N/A'}</td>
                <td>${customer.telepon || 'N/A'}</td>
                <td><span class="status ${customer.status === 'aktif' ? 'active' : 'inactive'}">${customer.status}</span></td>
              `;
              customersTableBody.appendChild(row);
            }
          });

          // Update stats cards
          document.getElementById('totalCustomers').textContent = totalCustomers;
          document.getElementById('activeCustomers').textContent = activeCustomers;
          document.getElementById('inactiveCustomers').textContent = inactiveCustomers;

        } else {
          customersTableBody.innerHTML = '<tr><td colspan="6" class="text-center">Tidak ada data nasabah.</td></tr>';
        }
      }, (error) => {
        console.error('Error loading customer data:', error);
        customersTableBody.innerHTML = '<tr><td colspan="6" class="text-center text-red-500">Gagal memuat data.</td></tr>';
      });
    };

    // Panggil fungsi ini saat DOM selesai dimuat
    document.addEventListener('DOMContentLoaded', function() {
        checkAuthState();
        setupLogout();
    });
  </script>
</body>
</html>