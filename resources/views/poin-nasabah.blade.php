@extends('layouts.app')

@section('content')
    <style>
    html, body { 
        overflow-x: hidden; 
        margin: 0;
        padding: 0;
        scroll-behavior: smooth;
    }
    .sidebar-gradient { background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%); }
    .sidebar-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .sidebar-item-hover { transition: all 0.2s ease-in-out; }
    .sidebar-item-hover:hover { background-color: rgba(255, 255, 255, 0.2); }
    .sidebar-logo { transition: all 0.3s ease-in-out; }
    .sidebar-nav-item { transition: all 0.2s ease-in-out; border-radius: 8px; }
    .sidebar-nav-item:hover { background-color: rgba(255, 255, 255, 0.1); }
    .sidebar-nav-item.active { background-color: rgba(255, 255, 255, 0.2); box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
    .fixed-header {
        position: fixed; top: 0; left: 0; right: 0; height: 48px; z-index: 40;
        display: flex; align-items: center; justify-content: space-between; 
        padding: 0 1.5rem; background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
        transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    .main-content-wrapper {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #f1f5f9 100%);
        padding-top: 60px; 
        padding-left: 4rem; 
        padding-right: 0;
        transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative; 
        overflow-x: hidden;
        width: 100%;
        scroll-behavior: smooth;
    }
    .content-container { 
        width: 100%; 
        margin: 0; 
        padding: 2rem; 
        position: relative; 
        z-index: 1; 
        box-sizing: border-box;
        scroll-behavior: smooth;
    }
    .sidebar-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.5); z-index: 45; opacity: 0; visibility: hidden;
        transition: all 0.3s ease;
    }
    .sidebar-overlay.active { opacity: 1; visibility: visible; }
    
    .text-highlight {
        color: #75E6DA;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #10B981, #059669);
        color: white;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #05445E, #043a4e);
        color: white;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(5, 68, 94, 0.3);
    }
    
    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(5, 68, 94, 0.4);
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .activity-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .activity-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .quick-action-btn {
        background: linear-gradient(135deg, #75E6DA, #05445E);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(117, 230, 218, 0.3);
    }

    .quick-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(117, 230, 218, 0.4);
    }

    .progress-bar {
        background: linear-gradient(90deg, #75E6DA, #05445E);
        height: 8px;
        border-radius: 4px;
        transition: width 0.3s ease;
    }

    .chart-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
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

    /* Responsive Design */
    @media (max-width: 1024px) {
      .komunitas-container {
            flex-direction: column;
      }
      
      .left-panel {
        width: 100%;
      }
    }

    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-250px);
      }
      
      .sidebar.collapsed {
        transform: translateX(0);
      }
      
      .main-content {
        margin-left: 0;
        width: 100%;
      }
      
      .form-container {
        padding: 30px 20px;
      }
      
      .form-title {
        font-size: 28px;
      }
      
      .form-subtitle {
        font-size: 20px;
      }
    }

    @media (max-width: 480px) {
      .interest-tags {
            gap: 8px;
      }
      
      .interest-tag {
        padding: 6px 12px;
            font-size: 14px;
        }
      
      .form-title {
            font-size: 24px;
      }
      
      .form-subtitle {
            font-size: 18px;
      }
    }

    /* Responsive fixes */
    @media (max-width: 1024px) {
        .main-content-wrapper { padding-left: 1rem; padding-right: 1rem; }
        .content-container { padding: 1.5rem; }
        }
        @media (max-width: 768px) {
        .main-content-wrapper { padding-left: 0.5rem; padding-right: 0.5rem; }
        .content-container { padding: 1rem; }
        }
    </style>

<div class="flex min-h-screen bg-gray-50" x-data="{ sidebarOpen: false }">
    {{-- Sidebar Overlay --}}
    <div class="sidebar-overlay" :class="{ 'active': sidebarOpen }" @click="sidebarOpen = false"></div>

    {{-- Sidebar --}}
    <aside 
        x-data="{ open: false, active: 'poin' }"
        x-ref="sidebar"
        @mouseenter="open = true; $root.sidebarOpen = true"
        @mouseleave="open = false; $root.sidebarOpen = false"
        class="fixed top-0 left-0 z-50 flex flex-col py-6 sidebar-hover overflow-hidden shadow-2xl group sidebar-gradient"
        :class="open ? 'w-64' : 'w-16'"
        style="transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); margin-top: 48px; height: calc(100vh - 48px);"
    >
        <div class="relative flex flex-col h-full w-full px-4">
            {{-- Logo Section --}}
            <div class="flex items-center justify-center mb-8 mt-2 sidebar-logo">
                <img x-show="open" class="w-32 h-auto" src="{{ asset('asset/img/logo1.png') }}" alt="Logo Penuh">
                <img x-show="!open" class="w-6 h-6" src="{{ asset('asset/img/logo.png') }}" alt="Logo Ikon">
            </div>
            
            {{-- Navigation Menu --}}
            <nav class="flex flex-col gap-2 w-full flex-1">
                {{-- Dashboard Link --}}
                <a href="{{ route('nasabahdashboard') }}" class="flex items-center gap-3 p-3 font-medium sidebar-nav-item whitespace-nowrap w-full" :class="open ? (active === 'dashboard' ? 'active text-white' : 'text-white') : (active === 'dashboard' ? 'active text-white justify-center' : 'text-white justify-center')">
                    <i class="fas fa-home text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Dashboard</span>
                </a>
                
                {{-- Komunitas Link --}}
                <a href="{{ route('nasabahkomunitas') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'komunitas' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'komunitas' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-users text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Komunitas</span>
                </a>
                
                {{-- Penjemputan Sampah Link --}}
                <a href="{{ route('sampahnasabah') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'penjemputan' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'penjemputan' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-trash-alt text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Penjemputan Sampah</span>
                </a>
                
                {{-- Poin Link --}}
                <a href="{{ route('poin-nasabah') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'poin' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'poin' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-coins text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Poin Mu</span>
                </a>
                
                {{-- Riwayat Transaksi Link --}}
                <a href="{{ route('riwayattransaksinasabah') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'riwayat-transaksi' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'riwayat-transaksi' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-history text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Riwayat Transaksi</span>
                </a>
                
                {{-- Marketplace Link --}}
                <a href="{{ route('tokou') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'marketplace' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'marketplace' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-store text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Marketplace</span>
                </a>
                
                {{-- Settings Link --}}
                <a href="{{ route('settings') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'settings' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'settings' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-cog text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Settings</span>
                </a>
            </nav>
            
            {{-- Logout Section --}}
            <div class="w-full flex items-center py-3 mt-auto">
                <a href="{{ route('logout') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover text-white hover:text-red-300 transition-all duration-200 w-full whitespace-nowrap" :class="open ? (active === 'logout' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'logout' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Logout</span>
                </a>
            </div>
        </div>
    </aside>

    {{-- Main Content Area --}}
    <div class="main-content-wrapper">
        {{-- Top Header Bar --}}
        <div class="fixed-header">
            <h1 class="text-white font-semibold text-lg">BijakSampah</h1>
            <div class="flex items-center gap-4">
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

        {{-- Content Container --}}
        <div class="content-container">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800"><i class="fas fa-coins"></i> <span id="page-title-text">Poin Mu</span></h1>
                    <p class="text-sm text-gray-500">Kelola dan tukar poin Anda</p>
                </div>
            </div>

        <div class="poinmu-content-wrapper">
            <div class="active-section" id="poinmuDashboard">
                <div class="poinmu-header-card">
                    <div class="poinmu-info-section">
                        <div>
                            <div class="poinmu-user-info">
                                <img class="avatar" src="https://ui-avatars.com/api/?name=Nasabah&background=75E6DA&color=05445E" alt="Profile">
                                <span class="user-name">Hello, Nasabah!</span>
                            </div>
                            <div class="poinmu-balance-info">
                                <div class="title">Total Poin Anda</div>
                                <div class="amount" id="user-points-display">4.297 Poin</div>
                                <div class="last-updated">Terakhir Diperbarui: <span id="current-date-1"></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="poinmu-image-section">
                         <img src="asset/img/poin.png" alt="Ilustrasi Poin Mu" />
                    </div>
                </div>

                <div class="poin-flow-cards">
                    <div class="poin-flow-card">
                        <div class="icon in"><i class="fas fa-arrow-down"></i></div>
                        <div class="info">
                            <h4>Poin Masuk</h4>
                            <p id="poin-in-display">0 Poin</p>
                        </div>
                    </div>
                    <div class="poin-flow-card">
                        <div class="icon out"><i class="fas fa-arrow-up"></i></div>
                        <div class="info">
                            <h4>Poin Keluar</h4>
                            <p id="poin-out-display">0 Poin</p>
                        </div>
                    </div>
                </div>
                
                <div class="ewallet-section" id="ewalletSelectionSection">
                    <h2 class="section-title">
                        <i class="fas fa-wallet"></i> Tukar Poin Mu
                    </h2>
                    
                    <div class="ewallet-grid">
                        <div class="ewallet-card" data-provider-id="gopay" onclick="showNominalSelection('gopay', 'Gopay', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/1200px-Gopay_logo.svg.png')">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/1200px-Gopay_logo.svg.png" alt="Gopay" class="ewallet-logo">
                            <span class="ewallet-name">Gopay</span>
                        </div>
                        
                        <div class="ewallet-card" data-provider-id="ovo" onclick="showNominalSelection('ovo', 'OVO', 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/1200px-Logo_ovo_purple.svg.png')">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/1200px-Logo_ovo_purple.svg.png" alt="OVO" class="ewallet-logo">
                            <span class="ewallet-name">OVO</span>
                        </div>

                        <div class="ewallet-card" data-provider-id="dana" onclick="showNominalSelection('dana', 'DANA', 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/1200px-Logo_dana_blue.svg.png')">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/1200px-Logo_dana_blue.svg.png" alt="DANA" class="ewallet-logo">
                            <span class="ewallet-name">DANA</span>
                        </div>

                        <div class="ewallet-card" data-provider-id="shopeepay" onclick="showNominalSelection('shopeepay', 'ShopeePay', 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f3/ShopeePay_logo.svg/1200px-ShopeePay_logo.svg.png')">
                            <img src="https://bloguna.com/wp-content/uploads/2025/06/Logo-ShopeePay-PNG-CDR-SVG-EPS-Kualitas-HD.png" alt="ShopeePay" class="ewallet-logo">
                            <span class="ewallet-name">ShopeePay</span>
                        </div>

                        <div class="ewallet-card" data-provider-id="linkaja" onclick="showNominalSelection('linkaja', 'LinkAja', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/LinkAja.svg/1200px-LinkAja.svg.png')">
                            <img src="https://assets-a1.kompasiana.com/items/album/2023/04/13/beli-saldo-paypal-via-linkaja-6437c7be4addee244748a212.png" alt="LinkAja" class="ewallet-logo">
                            <span class="ewallet-name">LinkAja</span>
                        </div>
                        
                        <div class="ewallet-card" data-provider-id="pulsa" onclick="showNominalSelection('pulsa', 'Pulsa', 'placeholder')">
                            <i class="fas fa-mobile-alt ewallet-icon"></i>
                            <span class="ewallet-name">Pulsa</span>
                        </div>

                        <div class="ewallet-card" data-provider-id="tokenlistrik" onclick="showNominalSelection('tokenlistrik', 'Token Listrik', 'placeholder')">
                            <i class="fas fa-bolt ewallet-icon"></i>
                            <span class="ewallet-name">Token Listrik</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="nominal-section" id="nominalSelectionSection">
                <a class="nominal-back" onclick="showSection('poinmuDashboard')"><i class="fas fa-arrow-left"></i> Kembali</a>
                <h2 class="section-title">
                    Pilih Nominal <span id="nominal-provider-name"></span>
                </h2>
                <div class="nominal-grid" id="nominal-grid">
                    </div>
            </div>

            <div class="redemption-section" id="redemptionConfirmationSection">
                <a class="nominal-back" onclick="showSection('nominalSelectionSection')"><i class="fas fa-arrow-left"></i> Kembali</a>
                <h2 class="section-title">Konfirmasi Penukaran</h2>
                
                <div class="redemption-summary">
                    <div class="summary-info">
                        <h4>Poin yang Ditukar</h4>
                        <p id="summary-points-text">1.000 Poin</p>
                    </div>
                    <div class="summary-points">
                        <span id="summary-points-amount">1000 Poin</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="recipient-number">Nomor Tujuan</label>
                    <input type="text" id="recipient-number" placeholder="Masukkan nomor tujuan">
                    <span class="error-message" id="number-error">Nomor tujuan tidak valid.</span>
                </div>

                <div class="form-group">
                    <label for="bijaksampah-pin">PIN BijakSampah Pay</label>
                    <input type="password" id="bijaksampah-pin" placeholder="PIN saat kamu register/login" maxlength="6">
                    <span class="error-message" id="pin-error">PIN salah.</span>
                </div>

                <div class="redemption-actions">
                    <button class="btn btn-secondary" onclick="showSection('poinmuDashboard')">Batalkan</button>
                    <button class="btn btn-primary" id="confirm-redemption-btn">Konfirmasi Penukaran</button>
                </div>
            </div>

            <div class="transaction-history-section" id="transactionHistorySection">
                <div class="history-controls">
                    <h2 class="section-title"><i class="fas fa-history"></i> Riwayat Transaksi</h2>
                    <div class="history-actions">
                        <button class="btn print-button" id="print-history-btn">
                            <i class="fas fa-print"></i> Cetak Riwayat
                        </button>
                    </div>
                </div>
                
                <div class="transaction-list-container">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>Deskripsi</th>
                                <th>Tanggal</th>
                                <th style="text-align: right;">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody id="transaction-history-list">
                            </tbody>
                    </table>
                    <div id="no-history-message" style="text-align: center; color: var(--subtle-text); padding: 30px; display: none;">
                        Belum ada riwayat transaksi.
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            Created by <strong>TEK(G)</strong> | All Right Reserved
        </div>
    </div>
</div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    
    <script>
        // Data Dummy
        let userPoints = 4297; // Poin awal pengguna
        let transactions = []; // Riwayat transaksi kosong

        const nominalData = {
            gopay: [
                { amount: 10000, points: 1249 },
                { amount: 15000, points: 1874 },
                { amount: 20000, points: 2498 },
                { amount: 30000, points: 3747 },
                { amount: 35000, points: 4372 },
                { amount: 50000, points: 6245 },
                { amount: 100000, points: 12490 },
                { amount: 150000, points: 18735 },
                { amount: 200000, points: 24980 }
            ],
            ovo: [
                { amount: 10000, points: 1249 },
                { amount: 15000, points: 1874 },
                { amount: 20000, points: 2498 },
                { amount: 30000, points: 3747 },
                { amount: 35000, points: 4372 },
                { amount: 50000, points: 6245 },
                { amount: 100000, points: 12490 },
                { amount: 150000, points: 18735 },
                { amount: 200000, points: 24980 }
            ],
            dana: [
                { amount: 10000, points: 1249 },
                { amount: 15000, points: 1874 },
                { amount: 20000, points: 2498 },
                { amount: 30000, points: 3747 },
                { amount: 35000, points: 4372 },
                { amount: 50000, points: 6245 },
                { amount: 100000, points: 12490 },
                { amount: 150000, points: 18735 },
                { amount: 200000, points: 24980 }
            ],
            shopeepay: [
                { amount: 10000, points: 1249 },
                { amount: 15000, points: 1874 },
                { amount: 20000, points: 2498 },
                { amount: 30000, points: 3747 },
                { amount: 35000, points: 4372 },
                { amount: 50000, points: 6245 },
                { amount: 100000, points: 12490 },
                { amount: 150000, points: 18735 },
                { amount: 200000, points: 24980 }
            ],
            linkaja: [
                { amount: 10000, points: 1249 },
                { amount: 15000, points: 1874 },
                { amount: 20000, points: 2498 },
                { amount: 30000, points: 3747 },
                { amount: 35000, points: 4372 },
                { amount: 50000, points: 6245 },
                { amount: 100000, points: 12490 },
                { amount: 150000, points: 18735 },
                { amount: 200000, points: 24980 }
            ],
            pulsa: [
                { amount: 5000, points: 625 },
                { amount: 10000, points: 1249 },
                { amount: 15000, points: 1874 },
                { amount: 20000, points: 2498 },
                { amount: 30000, points: 3747 },
                { amount: 35000, points: 4372 },
                { amount: 50000, points: 6245 },
                { amount: 100000, points: 12490 }
            ],
            tokenlistrik: [
                { amount: 20000, points: 2498 },
                { amount: 50000, points: 6245 },
                { amount: 100000, points: 12490 },
                { amount: 250000, points: 31225 },
                { amount: 500000, points: 62450 }
            ]
        };

        let selectedProvider = {};
        let selectedNominal = {};

        // Helper function to format points
        function formatPoints(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }

        // Function to render balances and point flow cards
        function renderBalances() {
            document.getElementById('user-points-display').innerText = `${formatPoints(userPoints)} Poin`;
            
            const poinIn = transactions.filter(t => t.amount > 0).reduce((sum, t) => sum + t.amount, 0);
            const poinOut = transactions.filter(t => t.amount < 0).reduce((sum, t) => sum + Math.abs(t.amount), 0);
            
            document.getElementById('poin-in-display').innerText = `${formatPoints(poinIn)} Poin`;
            document.getElementById('poin-out-display').innerText = `${formatPoints(poinOut)} Poin`;
        }

        // Function to show a specific section and hide others
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.poinmu-content-wrapper > div');
            sections.forEach(section => {
                section.classList.remove('active-section');
            });
            document.getElementById(sectionId).classList.add('active-section');
            updateActiveMenu(sectionId);
            updatePageTitle(sectionId);
        }

        // Function to update the active menu item in the sidebar
        function updateActiveMenu(activeSectionId) {
            const menuItems = document.querySelectorAll('.sidebar-nav-item');
            menuItems.forEach(item => {
                item.classList.remove('active');
            });

            if (activeSectionId === 'poinmuDashboard' || activeSectionId === 'ewalletSelectionSection' || activeSectionId === 'nominalSelectionSection' || activeSectionId === 'redemptionConfirmationSection') {
                document.querySelector(`.sidebar-nav-item a[href="${route('poin-nasabah')}"]`).classList.add('active');
            } else if (activeSectionId === 'transactionHistorySection') {
                document.querySelector(`.sidebar-nav-item a[href="${route('riwayattransaksinasabah')}"]`).classList.add('active');
            }
        }

        // Function to update the page title
        function updatePageTitle(activeSectionId) {
            const pageTitleElement = document.getElementById('page-title-text');
            if (activeSectionId === 'poinmuDashboard' || activeSectionId === 'ewalletSelectionSection') {
                pageTitleElement.innerText = 'Poin Mu';
            } else if (activeSectionId === 'transactionHistorySection') {
                pageTitleElement.innerText = 'Riwayat Transaksi';
            } else if (activeSectionId === 'nominalSelectionSection') {
                pageTitleElement.innerText = `Pilih Nominal ${selectedProvider.name || ''}`;
            } else if (activeSectionId === 'redemptionConfirmationSection') {
                pageTitleElement.innerText = 'Konfirmasi Penukaran';
            }
        }

        // Function to render nominal selection
        function showNominalSelection(providerId, providerName, providerLogo) {
            selectedProvider = { id: providerId, name: providerName, logo: providerLogo };
            const nominals = nominalData[providerId];
            const nominalGrid = document.getElementById('nominal-grid');
            nominalGrid.innerHTML = '';

            const nominalTitle = document.getElementById('nominal-provider-name');
            nominalTitle.innerText = providerName;

            if (!nominals) {
                nominalGrid.innerHTML = '<p style="text-align: center; color: var(--subtle-text);">Nominal tidak tersedia.</p>';
                return;
            }

            nominals.forEach(nominal => {
                const item = document.createElement('div');
                item.className = 'nominal-item';
                item.innerHTML = `
                    <div class="nominal-provider">${providerName}</div>
                    <div class="nominal-currency">Rp</div>
                    <div class="nominal-amount">${formatPoints(nominal.amount)}</div>
                    <div class="nominal-points">${formatPoints(nominal.points)} Poin</div>
                `;
                item.onclick = () => showConfirmation(nominal);
                nominalGrid.appendChild(item);
            });

            showSection('nominalSelectionSection');
        }

        // Function to show confirmation screen
        function showConfirmation(nominal) {
            selectedNominal = nominal;
            document.getElementById('summary-points-text').innerText = `${formatPoints(selectedNominal.points)} Poin`;
            document.getElementById('summary-points-amount').innerText = `${formatPoints(selectedNominal.points)} Poin`;
            
            document.getElementById('confirm-redemption-btn').onclick = () => {
                const recipientNumber = document.getElementById('recipient-number').value;
                const pin = document.getElementById('bijaksampah-pin').value;
                
                document.getElementById('number-error').style.display = 'none';
                document.getElementById('pin-error').style.display = 'none';

                if (recipientNumber.trim() === '') {
                    document.getElementById('number-error').innerText = 'Nomor tujuan tidak boleh kosong.';
                    document.getElementById('number-error').style.display = 'block';
                    return;
                }
                if (pin !== '123456') { // PIN dummy
                    document.getElementById('pin-error').innerText = 'PIN yang Anda masukkan salah.';
                    document.getElementById('pin-error').style.display = 'block';
                    return;
                }

                redeemPointsToEwallet(recipientNumber, pin);
            };

            showSection('redemptionConfirmationSection');
        }

        // Function to redeem points to e-wallet
        function redeemPointsToEwallet(recipientNumber, pin) {
            if (userPoints >= selectedNominal.points) {
                userPoints -= selectedNominal.points;
                const transactionDescription = `Penukaran ${new Intl.NumberFormat('id-ID').format(selectedNominal.amount)} ke ${selectedProvider.name} (${recipientNumber})`;
                const transactionAmount = -selectedNominal.points;
                addTransaction(transactionDescription, transactionAmount);
                
                alert('Penukaran berhasil! Silakan cek riwayat transaksi Anda.');
                
                renderBalances();
                showSection('transactionHistorySection');
            } else {
                alert('Poin Anda tidak cukup untuk melakukan penukaran ini.');
            }
        }

        // Function to add a new transaction
        function addTransaction(description, amount) {
            const today = new Date();
            const date = today.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            transactions.unshift({
                date: date,
                description: description,
                amount: amount
            });
            renderTransactionHistory();
        }

        // Function to render the transaction history list
        function renderTransactionHistory() {
            const transactionList = document.getElementById('transaction-history-list');
            const noHistoryMessage = document.getElementById('no-history-message');
            transactionList.innerHTML = '';
            
            if (transactions.length === 0) {
                noHistoryMessage.style.display = 'block';
                return;
            } else {
                noHistoryMessage.style.display = 'none';
            }

            transactions.forEach(transaction => {
                const row = document.createElement('tr');
                row.className = 'transaction-item';
                const amountClass = transaction.amount > 0 ? 'positive' : 'negative';
                const formattedAmount = transaction.amount > 0 ?
                    `+${formatPoints(transaction.amount)} Poin` :
                    `${formatPoints(transaction.amount)} Poin`;

                row.innerHTML = `
                    <td>
                        <div class="transaction-details">
                            <div class="transaction-icon">
                                <i class="fas fa-exchange-alt"></i>
                            </div>
                            <div class="transaction-info">
                                <h4>${transaction.description}</h4>
                                <p>${transaction.amount > 0 ? 'Pemasukan' : 'Pengeluaran'}</p>
                            </div>
                        </div>
                    </td>
                    <td>${transaction.date}</td>
                    <td style="text-align: right;">
                        <span class="transaction-amount ${amountClass}">${formattedAmount}</span>
                    </td>
                `;
                transactionList.appendChild(row);
            });
        }

        // Function to print transaction history
        function printTransactionHistory() {
            const containerToPrint = document.getElementById('transactionHistorySection');
            if (transactions.length === 0) {
                 alert('Tidak ada riwayat transaksi yang dapat dicetak.');
                 return;
            }
            
            html2canvas(containerToPrint, { scale: 2 }).then(canvas => {
                const imageData = canvas.toDataURL('image/png');
                const printWindow = window.open('', '_blank');
                printWindow.document.write(`
                    <html>
                    <head>
                        <title>Cetak Riwayat Transaksi</title>
                        <style>
                            @media print {
                                body { margin: 0; }
                                img { max-width: 100%; height: auto; display: block; }
                            }
                        </style>
                    </head>
                    <body>
                        <img src="${imageData}" onload="window.print(); window.close();" />
                    </body>
                    </html>
                `);
                printWindow.document.close();
            });
        }
        
        // Event listeners
        document.addEventListener('DOMContentLoaded', () => {
            const today = new Date();
            const formattedDate = today.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            document.getElementById('current-date-1').innerText = formattedDate;
            renderBalances();
            renderTransactionHistory();
            showSection('poinmuDashboard');
            
            document.getElementById('print-history-btn').addEventListener('click', printTransactionHistory);
            // Note: Sidebar toggle is now handled by Alpine.js
        });
    </script>
</div>
@endsection