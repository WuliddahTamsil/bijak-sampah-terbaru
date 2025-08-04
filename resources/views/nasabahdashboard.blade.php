<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dashboard Nasabah - Bijak Sampah</title>
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

        /* Header Styles */


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

        /* Notifikasi Cards - Diperbagus */
        .notif-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #75E6DA, #05445E);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .card:hover::before {
            opacity: 1;
        }

        .card h4 {
            color: #0a3a60;
            font-weight: 600;
            font-size: 17px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card h4 i {
            color: #05445E;
            font-size: 20px;
        }

        .card p {
            font-size: 15px;
            color: #555;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            color: #777;
        }

        .card-actions {
            display: flex;
            gap: 10px;
        }

        .card-btn {
            background: none;
            border: none;
            color: #05445E;
            cursor: pointer;
            font-size: 14px;
            padding: 4px 8px;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .card-btn:hover {
            background: rgba(5, 68, 94, 0.1);
        }

        .card-btn.delete:hover {
            color: #FF5A5F;
        }

        /* Grafik dengan Animasi */
        .chart-section {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .chart-title {
            color: #0a3a60;
            font-weight: 700;
            font-size: 22px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .chart-title i {
            color: #05445E;
            font-size: 24px;
        }

        .chart-sub {
            font-size: 15px;
            color: #777;
            margin-bottom: 30px;
        }
        
        .chart-content {
            display: flex;
            align-items: flex-end;
            justify-content: space-around;
            position: relative;
            height: 220px;
            padding-top: 40px;
            padding-bottom: 30px;
        }

        .chart-content::before {
            content: '';
            position: absolute;
            bottom: 30px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #eee;
        }

        .chart-bar-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            min-width: 0;
            position: relative;
            height: var(--height); /* Tinggi item akan disesuaikan dengan data */
            transition: height 0.3s ease;
        }

        .bar {
            width: 100%;
            max-width: 50px;
            background: linear-gradient(to top, #05445E, #189AB4); /* Warna default untuk semua bar */
            border-radius: 8px 8px 0 0;
            position: relative;
            height: 100%; /* Batang akan mengisi penuh tingginya */
            transform: scaleY(0); /* Mulai dari nol */
            transform-origin: bottom;
            animation: grow-scale 1.5s ease-out forwards;
            animation-delay: calc(var(--order) * 0.2s);
        }

        @keyframes grow-scale {
            from { transform: scaleY(0); }
            to { transform: scaleY(1); }
        }

        /* .bar.green tidak diperlukan lagi jika semua bar berwarna sama,
           tapi tetap bisa dipertahankan untuk fleksibilitas jika suatu saat
           ada bar dengan warna berbeda. */
        /* .bar.green {
            background: linear-gradient(to top, #05445E, #189AB4);
        } */

        .bar-label {
            position: absolute;
            top: -40px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 13px;
            font-weight: 600;
            background: white;
            padding: 6px 12px;
            border-radius: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            white-space: nowrap;
            opacity: 0;
            animation: fadeIn 0.5s ease-out forwards;
            animation-delay: calc(var(--order) * 0.2s + 1s);
            color: #05445E; /* Warna label agar terlihat di atas bar */
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(-50%) translateY(10px); }
            to { opacity: 1; transform: translateX(-50%) translateY(0); }
        }
        
        .day {
            position: absolute;
            bottom: -40px; /* Nilai negatif untuk memposisikan lebih ke bawah dari batas parent */
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #555; /* Warna teks yang sedikit lebih gelap untuk kontras */
        }

        /* Modal untuk CRUD */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            width: 90%;
            max-width: 500px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-title {
            font-size: 22px;
            color: #05445E;
            font-weight: 700;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #777;
            transition: all 0.2s;
        }

        .close-modal:hover {
            color: #05445E;
            transform: rotate(90deg);
        }

        .modal-body {
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }

        .form-group input, 
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
        }

        .form-group input:focus, 
        .form-group textarea:focus {
            border-color: #75E6DA;
            outline: none;
            box-shadow: 0 0 0 3px rgba(117, 230, 218, 0.2);
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #05445E 0%, #0A3A60 100%);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0A3A60 0%, #05445E 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(5, 68, 94, 0.3);
        }

        .btn-outline {
            background: white;
            border: 1px solid #ddd;
            color: #555;
        }

        .btn-outline:hover {
            background: #f5f5f5;
        }

        .btn-danger {
            background: #FF5A5F;
            color: white;
        }

        .btn-danger:hover {
            background: #e04a50;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 90, 95, 0.3);
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
            .notif-cards {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
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

            .notif-cards {
                grid-template-columns: 1fr;
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
        }
    </style>
</head>
<body class="bg-gray-50">

<div class="flex min-h-screen bg-gray-50" x-data="{ sidebarOpen: false, activeMenu: 'dashboard' }" x-init="activeMenu = 'dashboard'">
    {{-- Sidebar --}}
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
                    href="{{ route('nasabahdashboard') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 bg-white/20 shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center; padding-left: 0; padding-right: 0;'"
                    @click="activeMenu = 'dashboard'"
                >
                    <i class="fas fa-home text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Dashboard</span>
                </a>

                <a 
                    href="{{ route('nasabahkomunitas') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'komunitas'"
                >
                    <i class="fas fa-users text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Komunitas</span>
                </a>

                <a 
                    href="{{ route('sampahnasabah') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'penjemputan'"
                >
                    <i class="fas fa-trash-alt text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Penjemputan Sampah</span>
                </a>

                <a 
                    href="{{ route('poin-nasabah') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'poin'"
                >
                    <i class="fas fa-coins text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Poin Mu</span>
                </a>

                <a 
                    href="{{ route('riwayattransaksinasabah') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'riwayat-transaksi'"
                >
                    <i class="fas fa-history text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Riwayat Transaksi</span>
                </a>

                <a 
                    href="{{ route('tokou') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'marketplace'"
                >
                    <i class="fas fa-store text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Marketplace</span>
                </a>

                <a 
                    href="{{ route('settings') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'settings'"
                >
                    <i class="fas fa-cog text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Settings</span>
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
   <div class="main-content" :class="sidebarOpen ? 'pl-24' : 'pl-24'" style="transition: padding-left 0.3s ease; width: 100%; margin-left: 0; margin-right: 0;">
        {{-- Top Header Bar --}}
        <div class="fixed top-0 left-0 right-0 h-12 z-40 flex items-center justify-between px-6 text-white" :style="'padding-left:' + (sidebarOpen ? '16rem' : '4rem') + '; background: linear-gradient(135deg, #75E6DA 0%, #05445E 30%, #05445E 100%);'">
            <h1 class="text-white font-semibold text-lg" style="position: absolute; left: 1.5rem;">BijakSampah</h1>
            <div class="flex items-center gap-4" style="position: absolute; right: 1.5rem;">
                <button onclick="showDevelopmentModal('Sign In')" class="bg-white/20 hover:bg-white/30 text-white px-4 py-1 rounded-full text-sm font-medium transition-colors duration-200">Sign in</button>
                <button onclick="showDevelopmentModal('Notification')" class="relative hover:text-white/80 transition-colors">
                    <i class="far fa-bell text-white text-sm"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-medium">2</span>
                </button>
                <button onclick="showDevelopmentModal('Search')" class="focus:outline-none hover:text-white/80 transition-colors">
                    <i class="fas fa-search text-white text-sm"></i>
                </button>
                <div class="flex items-center gap-2">
                    <button onclick="showDevelopmentModal('Profile')" class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center border-2 border-gray-300 cursor-pointer hover:border-white/50 transition-colors">
                        <img src="https://ui-avatars.com/api/?name=Non+Nasabah&background=75E6DA&color=05445E" alt="Profile" class="w-full h-full object-cover">
                    </button>
                    <button onclick="showDevelopmentModal('Profile Menu')" class="hover:text-white/80 transition-colors">
                        <i class="fas fa-chevron-down text-white text-xs"></i>
                    </button>
            </div>
                </div>
                </div>

        <div class="p-6" style="padding-top: 20px; width: 100%; max-width: 100%;">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4" style="width: 100%;">
                <div style="width: 100%;">
                    <h1 class="text-2xl font-bold text-gray-800">Dashboard - User Biasa</h1>
                    <p class="text-sm text-gray-500">Selamat datang di marketplace daur ulang</p>
            </div>
        </div>

            {{-- Notifikasi Section --}}
            <div class="mb-8" style="width: 100%;">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Notifikasi</h2>
                <div class="notif-cards" id="notifContainer" style="width: 100%;">
            <!-- Notifikasi akan dimuat di sini -->
                </div>
        </div>

            {{-- Aktivitas Section --}}
        <div class="chart-section">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Aktivitasmu</h2>
                        <p class="text-sm text-gray-500">Minggu Lalu</p>
            </div>
                    <div class="flex items-center gap-4">
                        <div class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold">
                            Hurraaahhh! Super Productive
                        </div>
                        <div class="text-2xl font-bold text-green-600">97%</div>
                        <button class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Bulan <i class="fas fa-chevron-down ml-1"></i>
                        </button>
                    </div>
                </div>

            <div class="chart-content" id="chart-content">
                <!-- Grafik akan dimuat di sini -->
            </div>
        </div>

        <div class="footer">
            Created by <strong>TEK(G)</strong> | All Right Reserved!
            </div>
        </div>
        </div>
    </div>

    <div class="modal" id="notifModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Kelola Notifikasi</h3>
                <button class="close-modal" id="closeNotifModal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="notifInput">Tambah Notifikasi Baru</label>
                    <input type="text" id="notifInput" placeholder="Masukkan pesan notifikasi">
                </div>
                <div id="notifList">
                    <!-- Daftar notifikasi akan dimuat di sini -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="cancelNotif">Batal</button>
                <button class="btn btn-primary" id="saveNotif">Simpan</button>
            </div>
        </div>
    </div>

    <div class="modal" id="searchModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Cari Produk</h3>
                <button class="close-modal" id="closeSearchModal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" id="searchInput" placeholder="Masukkan kata kunci...">
                </div>
                <div id="searchResults">
                    <!-- Hasil pencarian akan dimuat di sini -->
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="profileModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Profil Saya</h3>
                <button class="close-modal" id="closeProfileModal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group" style="text-align: center;">
                    <img id="profileImage" src="https://ui-avatars.com/api/?name=Non+Nasabah&background=75E6DA&color=05445E" alt="Profile" style="width: 120px; height: 120px; border-radius: 50%; border: 4px solid #05445E; margin-bottom: 15px; cursor: pointer;">
                    <input type="file" id="profileUpload" accept="image/*" style="display: none;">
                    <button class="btn btn-outline" id="changeProfileBtn" style="margin-top: 10px;">Ganti Foto Profil</button>
                </div>
                <div class="form-group">
                    <label for="profileName">Nama Lengkap</label>
                    <input type="text" id="profileName" value="Non Nasabah Bijak Sampah">
                </div>
                <div class="form-group">
                    <label for="profileEmail">Email</label>
                    <input type="email" id="profileEmail" value="nonnasabah@bijaksampah.com">
                </div>
                <div class="form-group">
                    <label for="profilePhone">No. Telepon</label>
                    <input type="tel" id="profilePhone" value="+6281234567890">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="cancelProfile">Batal</button>
                <button class="btn btn-primary" id="saveProfile">Simpan Perubahan</button>
            </div>
        </div>
    </div>

    {{-- Modal untuk menu dalam pengembangan --}}
    <div class="modal" id="developmentModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Fitur Dalam Pengembangan</h3>
                <button class="close-modal" id="closeDevelopmentModal">&times;</button>
            </div>
            <div class="modal-body">
                <div style="text-align: center; padding: 20px;">
                    <i class="fas fa-tools" style="font-size: 48px; color: #05445E; margin-bottom: 20px;"></i>
                    <h4 style="color: #05445E; font-size: 18px; margin-bottom: 10px;">Fitur Sedang Dikembangkan</h4>
                    <p style="color: #666; font-size: 14px; line-height: 1.6;">
                        Fitur ini sedang dalam tahap pengembangan. 
                        Tim kami sedang bekerja keras untuk menghadirkan pengalaman terbaik untuk Anda.
                    </p>
                    <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                        <p style="color: #05445E; font-size: 12px; margin: 0;">
                            <i class="fas fa-clock"></i> Estimasi rilis: 2-3 minggu ke depan
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="closeDevModal">Mengerti</button>
            </div>
        </div>
    </div>

    <script>
        // Data Notifikasi sesuai gambar
        let notifications = [
            { 
                id: 1,
                title: "Koleksi Tas Daur Ulang Lucu",
                icon: "fas fa-shopping-bag",
                message: "Ramah lingkungan & stylish. Cek di Marketplace BijakSampah! ❤️",
                date: "22 Juni 2025",
                time: "20:45",
                priority: "Urgent",
                timeTag: "Kemarin"
            },
            { 
                id: 2,
                title: "Dompet daur ulang unik tersedia!",
                icon: "fas fa-wallet",
                message: "Anti air & ramah lingkungan. Cek di Marketplace BijakSampah! ❤️❤️❤️",
                date: "23 Juni 2025",
                time: "14:14",
                priority: "Medium",
                timeTag: "2 jam yang lalu"
            
            }
        ];

        // Data untuk grafik aktivitas sesuai gambar
        const chartData = [
            { height: 60, value: '60%', label: '16 Jun' }, 
            { height: 45, value: '45%', label: '17 Jun' }, 
            { height: 97, value: '97%', label: '18 Jun' },
            { height: 75, value: '75%', label: '19 Jun' }, 
            { height: 80, value: '80%', label: '20 Jun' }, 
            { height: 65, value: '65%', label: '21 Jun' }, 
            { height: 70, value: '70%', label: '22 Jun' }  
        ];

        // DOM Elements
        const notifModal = document.getElementById('notifModal');
        const searchModal = document.getElementById('searchModal');
        const profileModal = document.getElementById('profileModal');
        const notifContainer = document.getElementById('notifContainer');
        const notifList = document.getElementById('notifList');
        const notifInput = document.getElementById('notifInput');
        const saveNotif = document.getElementById('saveNotif');
        const profileImage = document.getElementById('profileImage');
        const profileUpload = document.getElementById('profileUpload');
        const changeProfileBtn = document.getElementById('changeProfileBtn');
        const saveProfile = document.getElementById('saveProfile');
        const chartContent = document.getElementById('chart-content');

        // Load Notifications
        function loadNotifications() {
            console.log('Loading notifications, count:', notifications.length);
            notifContainer.innerHTML = '';
            
            if (notifications.length === 0) {
                notifContainer.innerHTML = `
                    <div class="col-span-full text-center py-8">
                        <i class="fas fa-bell-slash text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Tidak ada notifikasi</p>
                    </div>
                `;
                return;
            }
            
            notifications.forEach(notif => {
                const card = document.createElement('div');
                card.className = 'card';
                
                // Priority badge color
                let priorityClass = '';
                if (notif.priority === 'Urgent') {
                    priorityClass = 'bg-red-100 text-red-800';
                } else if (notif.priority === 'Medium') {
                    priorityClass = 'bg-green-100 text-green-800';
                }
                
                card.innerHTML = `
                    <div class="flex justify-between items-start mb-3">
                        <span class="badge badge-primary">${notif.timeTag}</span>
                        <div class="flex items-center gap-2">
                            <span class="badge ${priorityClass}">${notif.priority}</span>
                            <button class="card-btn delete" data-id="${notif.id}" onclick="deleteNotification(${notif.id})">
                                <i class="fas fa-trash text-red-500 hover:text-red-700"></i>
                            </button>
                        </div>
                    </div>
                    <h4><i class="${notif.icon}"></i> ${notif.title}</h4>
                    <p>${notif.message}</p>
                    <div class="card-footer">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar text-gray-400 text-xs"></i>
                            <span class="text-xs text-gray-500">${notif.date}</span>
                            <i class="fas fa-clock text-gray-400 text-xs"></i>
                            <span class="text-xs text-gray-500">${notif.time}</span>
                        </div>
                    </div>
                `;
                notifContainer.appendChild(card);
            });

            // Update notification count
            updateNotificationCount();
        }

        // Load Notifications in Modal
        function loadNotifModal() {
            notifList.innerHTML = '';
            notifications.forEach(notif => {
                const item = document.createElement('div');
                item.className = 'card';
                item.style.marginBottom = '10px';
                item.innerHTML = `
                    <h4 style="font-size: 16px;">${notif.title}</h4>
                    <p style="font-size: 14px;">${notif.message}</p>
                    <div class="card-footer" style="font-size: 12px;">
                        <span>${notif.date} • ${notif.time}</span>
                        <button class="card-btn delete" data-id="${notif.id}"><i class="fas fa-trash"></i></button>
                    </div>
                `;
                notifList.appendChild(item);
            });

            // Add delete event listeners
            document.querySelectorAll('.card-btn.delete').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = parseInt(this.getAttribute('data-id'));
                    notifications = notifications.filter(n => n.id !== id);
                    loadNotifications();
                    loadNotifModal();
                });
            });
        }

        // Generate Chart for activity trends
        function generateChart() {
            chartContent.innerHTML = '';
            
            // Generate bars for each day
            chartData.forEach((data, index) => {
                const chartBarItem = document.createElement('div');
                chartBarItem.className = 'chart-bar-item';
                chartBarItem.style.setProperty('--height', `${data.height}%`);
                
                // Add green color for the highest bar (18 Jun - 97%)
                let barClass = 'bar';
                if (data.height === 97) {
                    barClass = 'bar green';
                }
                
                chartBarItem.innerHTML = `
                    <div class="${barClass}" style="--order: ${index + 1};">
                        <span class="bar-label">${data.value} ${data.label}</span>
                    </div>
                    <div class="day">${data.label}</div>
                `;
                chartContent.appendChild(chartBarItem);
            });
        }

        // Update Notification Count in Topbar
        function updateNotificationCount() {
            const countElement = document.querySelector('.absolute.-top-1.-right-1');
            if (countElement) {
                countElement.textContent = notifications.length;
                if (notifications.length === 0) {
                    countElement.style.display = 'none';
                } else {
                    countElement.style.display = 'flex';
                }
            }
        }

        // Show Notification Modal
        function showNotifModal() {
            loadNotifModal();
            notifModal.style.display = 'flex';
        }

        // Modal Toggles - Removed unused event listeners

        // Close Modals
        document.getElementById('closeNotifModal').addEventListener('click', function() {
            notifModal.style.display = 'none';
        });

        document.getElementById('closeSearchModal').addEventListener('click', function() {
            searchModal.style.display = 'none';
        });

        document.getElementById('closeProfileModal').addEventListener('click', function() {
            profileModal.style.display = 'none';
        });

        document.getElementById('cancelNotif').addEventListener('click', function() {
            notifModal.style.display = 'none';
        });

        document.getElementById('cancelProfile').addEventListener('click', function() {
            profileModal.style.display = 'none';
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === notifModal) {
                notifModal.style.display = 'none';
            }
            if (event.target === searchModal) {
                searchModal.style.display = 'none';
            }
            if (event.target === profileModal) {
                profileModal.style.display = 'none';
            }
        });

        // Add New Notification
        saveNotif.addEventListener('click', function() {
            if (notifInput.value.trim()) {
                const newId = notifications.length > 0 ? Math.max(...notifications.map(n => n.id)) + 1 : 1;
                const now = new Date();
                const options = { day: 'numeric', month: 'long', year: 'numeric' };
                const date = now.toLocaleDateString('id-ID', options);
                const time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                
                // Determine time tag
                let timeTag = 'Baru saja';
                const minutesAgo = Math.floor((Date.now() - now.getTime()) / (1000 * 60));
                if (minutesAgo > 60) {
                    timeTag = `${Math.floor(minutesAgo / 60)} jam yang lalu`;
                } else if (minutesAgo > 0) {
                    timeTag = `${minutesAgo}m yang lalu`;
                }
                
                notifications.unshift({
                    id: newId,
                    title: "Notifikasi Baru",
                    icon: "fas fa-bell",
                    message: notifInput.value.trim(),
                    date: date,
                    time: time,
                    priority: "Medium",
                    timeTag: timeTag
                });
                
                notifInput.value = '';
                loadNotifications();
                loadNotifModal();
                showToast('Notifikasi berhasil ditambahkan!', 'success');
                updateNotificationCount();
            }
        });

        // Change Profile Image
        changeProfileBtn.addEventListener('click', function() {
            profileUpload.click();
        });

        profileUpload.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                const reader = new FileReader();
                reader.onload = function(event) {
                    profileImage.src = event.target.result;
                    profileBtn.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Save Profile Changes
        saveProfile.addEventListener('click', function() {
            // In a real app, you would save to database here
            alert('Perubahan profil berhasil disimpan!');
            profileModal.style.display = 'none';
        });

        // Delete Notification
        function deleteNotification(id) {
            console.log('Deleting notification with ID:', id);
            
            if (confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) {
                // Remove from notifications array
                const initialLength = notifications.length;
                notifications = notifications.filter(notif => notif.id !== id);
                
                console.log('Notifications before:', initialLength, 'after:', notifications.length);
                
                // Reload notifications display
                loadNotifications();
                
                // Show success message
                showToast('Notifikasi berhasil dihapus!', 'success');
                
                // Update notification count in topbar
                updateNotificationCount();
            }
        }

        // Show Toast Message
        function showToast(message, type = 'success') {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white font-medium transition-all duration-300 transform translate-x-full`;
            
            if (type === 'success') {
                toast.className += ' bg-green-500';
            } else if (type === 'error') {
                toast.className += ' bg-red-500';
            }
            
            toast.textContent = message;
            document.body.appendChild(toast);
            
            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);
            
            // Remove after 3 seconds
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }

        // Show Development Modal
        function showDevelopmentModal(featureName) {
            const modal = document.getElementById('developmentModal');
            const title = modal.querySelector('.modal-title');
            title.textContent = `${featureName} - Fitur Dalam Pengembangan`;
            modal.style.display = 'flex';
        }

        // Close Development Modal
        document.getElementById('closeDevelopmentModal').addEventListener('click', function() {
            document.getElementById('developmentModal').style.display = 'none';
        });

        document.getElementById('closeDevModal').addEventListener('click', function() {
            document.getElementById('developmentModal').style.display = 'none';
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            const developmentModal = document.getElementById('developmentModal');
            if (event.target === developmentModal) {
                developmentModal.style.display = 'none';
            }
        });

        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing...');
        loadNotifications();
        generateChart();
            updateNotificationCount();
        });
    </script>
</body>
</html>