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
        padding-top: 30px; 
        padding-left: 2rem; 
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
    .nominal-item {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .nominal-item:hover {
        border-color: #3b82f6;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
    }

    .nominal-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #3b82f6, #1d4ed8);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .nominal-item:hover::before {
        transform: scaleX(1);
    }

    .nominal-provider {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 8px;
    }

    .nominal-currency {
        font-size: 16px;
        color: #374151;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .nominal-amount {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .nominal-points {
        font-size: 14px;
        color: #3b82f6;
        font-weight: 600;
        background: #eff6ff;
        padding: 4px 12px;
        border-radius: 20px;
        display: inline-block;
    }

    /* E-Wallet Modal Styles */
    .ewallet-card {
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    
    .ewallet-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: left 0.5s;
    }
    
    .ewallet-card:hover::before {
        left: 100%;
    }
    
    .ewallet-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    
    .ewallet-logo-container {
        transition: all 0.3s ease;
        position: relative;
    }
    
    .ewallet-card:hover .ewallet-logo-container {
        transform: scale(1.1);
    }
    
    .ewallet-logo {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: all 0.3s ease;
    }
    
    .ewallet-icon {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .ewallet-name {
        transition: all 0.3s ease;
    }
    
    .ewallet-card:hover .ewallet-name {
        transform: scale(1.05);
    }
    
    /* Special effects for each e-wallet type */
    .ewallet-card[onclick*="gopay"]:hover {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }
    
    .ewallet-card[onclick*="ovo"]:hover {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
    }
    
    .ewallet-card[onclick*="dana"]:hover {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
    }
    
    .ewallet-card[onclick*="shopeepay"]:hover {
        background: linear-gradient(135deg, #f97316, #ea580c);
        color: white;
    }
    
    .ewallet-card[onclick*="linkaja"]:hover {
        background: linear-gradient(135deg, #14b8a6, #0d9488);
        color: white;
    }
    
    .ewallet-card[onclick*="pulsa"]:hover {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: white;
    }
    
    .ewallet-card[onclick*="tokenlistrik"]:hover {
        background: linear-gradient(135deg, #eab308, #ca8a04);
        color: white;
    }
    
    /* Enhanced e-wallet section styling */
    .ewallet-section {
        background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 50%, #e0f2fe 100%);
        border: 1px solid rgba(59, 130, 246, 0.1);
        box-shadow: 
            0 20px 25px -5px rgba(0, 0, 0, 0.1),
            0 10px 10px -5px rgba(0, 0, 0, 0.04),
            inset 0 1px 0 rgba(255, 255, 255, 0.8);
    }
    
    .ewallet-section .section-title {
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .ewallet-grid {
        perspective: 1000px;
    }
    
    .ewallet-card {
        backdrop-filter: blur(10px);
        border: 2px solid transparent;
        background-clip: padding-box;
    }
    
    .ewallet-card:hover {
        border-color: rgba(59, 130, 246, 0.3);
    }
    
    /* Logo container enhancements */
    .ewallet-logo-container {
        box-shadow: 
            0 4px 6px -1px rgba(0, 0, 0, 0.1),
            0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .ewallet-card:hover .ewallet-logo-container {
        box-shadow: 
            0 10px 15px -3px rgba(0, 0, 0, 0.1),
            0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    /* Text enhancements */
    .ewallet-name {
        font-weight: 700;
        letter-spacing: -0.025em;
    }
    
    .ewallet-card:hover .ewallet-name {
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }
    
    /* Info badge styling */
    .ewallet-section .bg-blue-100 {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border: 1px solid rgba(59, 130, 246, 0.2);
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.1);
    }

    /* Transaction History Styles */
    .transaction-item {
        transition: all 0.3s ease;
    }

    .transaction-item:hover {
        transform: translateX(4px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    /* Modal Animation */
    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(-20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    #ewalletModal > div > div {
        animation: modalSlideIn 0.3s ease-out;
    }

    /* Progress Bar Animation */
    #progressBar {
        transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Step Transition */
    .step-transition {
        transition: all 0.3s ease-in-out;
    }

    /* Button Hover Effects */
    .btn-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
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
                <a href="{{ route('tokon') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'marketplace' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'marketplace' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-store text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Marketplace</span>
                </a>
                
                {{-- Settings Link --}}
                <a href="{{ route('settingsnasab') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'settings' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'settings' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
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
                        <img src="https://ui-avatars.com/api/?name=Nasabah&background=75E6DA&color=05445E" alt="Profile" class="w-full h-full object-cover">
                    </button>
                    <button onclick="showDevelopmentModal('Profile Menu')" class="hover:text-white/80 transition-colors">
                        <i class="fas fa-chevron-down text-white text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="content-container">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800"><i class="fas fa-coins"></i> <span id="page-title-text">Poin Mu</span></h1>
                    <p class="text-sm text-gray-500">Kelola dan tukar poin Anda</p>
                </div>
            </div>
            <div class="poinmu-content-wrapper space-y-8">
                <div class="active-section" id="poinmuDashboard">
                    <div class="poinmu-header-card flex flex-col md:flex-row items-center justify-between bg-white rounded-2xl shadow-lg p-6 mb-6">
                        <div class="poinmu-info-section flex-1 flex flex-col md:flex-row items-center gap-6">
                            <div class="flex flex-col items-center md:items-start">
                                <div class="poinmu-user-info flex items-center gap-3 mb-2">
                                    <img class="avatar w-14 h-14 rounded-full border-2 border-blue-200" src="https://ui-avatars.com/api/?name=Nasabah&background=75E6DA&color=05445E" alt="Profile">
                                    <span class="user-name font-semibold text-lg text-gray-700">Hello, Nasabah!</span>
                                </div>
                                <div class="poinmu-balance-info">
                                    <div class="title text-gray-500">Total Poin Anda</div>
                                    <div class="amount text-3xl font-bold text-blue-700 mt-1 mb-1" id="user-points-display">4.297 Poin</div>
                                    <div class="last-updated text-xs text-gray-400">Terakhir Diperbarui: <span id="current-date-1"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="poinmu-image-section flex justify-center items-center">
                            <img src="asset/img/poin.png" alt="Ilustrasi Poin Mu" class="w-28 h-28 object-contain rounded-xl shadow-md" />
                        </div>
                    </div>
                    <div class="poin-flow-cards flex gap-6 mb-6">
                        <div class="poin-flow-card flex-1 bg-gradient-to-r from-green-200 to-green-400 rounded-xl p-5 flex items-center gap-4 shadow">
                            <div class="icon in bg-white rounded-full p-3 shadow"><i class="fas fa-arrow-down text-green-600 text-xl"></i></div>
                            <div class="info">
                                <h4 class="font-semibold text-green-800">Poin Masuk</h4>
                                <p id="poin-in-display" class="text-lg font-bold">0 Poin</p>
                            </div>
                        </div>
                        <div class="poin-flow-card flex-1 bg-gradient-to-r from-red-200 to-red-400 rounded-xl p-5 flex items-center gap-4 shadow">
                            <div class="icon out bg-white rounded-full p-3 shadow"><i class="fas fa-arrow-up text-red-600 text-xl"></i></div>
                            <div class="info">
                                <h4 class="font-semibold text-red-800">Poin Keluar</h4>
                                <p id="poin-out-display" class="text-lg font-bold">0 Poin</p>
                            </div>
                        </div>
                    </div>
                    <div class="ewallet-section bg-gradient-to-br from-white to-blue-50 rounded-3xl shadow-xl p-8 mb-8 border border-blue-100">
                        <div class="text-center mb-8">
                            <h2 class="section-title text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-3 flex items-center justify-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-wallet text-white text-lg"></i>
                                </div>
                                Tukar Poin Mu
                            </h2>
                            <p class="text-gray-600 text-lg">Pilih e-wallet favoritmu dan tukarkan poin dengan mudah!</p>
                        </div>
                        
                        <div class="ewallet-grid grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            <!-- Gopay -->
                            <div class="ewallet-card group bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer border-2 border-green-200 hover:border-green-400 hover:scale-105" onclick="openEwalletModal('gopay', 'Gopay', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/1200px-Gopay_logo.svg.png')">
                                <div class="text-center">
                                    <div class="ewallet-logo-container w-16 h-16 mx-auto mb-4 bg-white rounded-2xl p-3 shadow-lg group-hover:shadow-xl transition-all duration-300 flex items-center justify-center">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/1200px-Gopay_logo.svg.png" alt="Gopay" class="w-full h-full object-contain">
                                    </div>
                                    <h3 class="ewallet-name text-lg font-bold text-green-800 mb-2 group-hover:text-green-900 transition-colors">Gopay</h3>
                                    <p class="text-green-600 text-sm font-medium">GoPay Indonesia</p>
                                </div>
                            </div>
                            
                            <!-- OVO -->
                            <div class="ewallet-card group bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer border-2 border-purple-200 hover:border-purple-400 hover:scale-105" onclick="openEwalletModal('ovo', 'OVO', 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/1200px-Logo_ovo_purple.svg.png')">
                                <div class="text-center">
                                    <div class="ewallet-logo-container w-16 h-16 mx-auto mb-4 bg-white rounded-2xl p-3 shadow-lg group-hover:shadow-xl transition-all duration-300 flex items-center justify-center">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/1200px-Logo_ovo_purple.svg.png" alt="OVO" class="w-full h-full object-contain">
                                    </div>
                                    <h3 class="ewallet-name text-lg font-bold text-purple-800 mb-2 group-hover:text-purple-900 transition-colors">OVO</h3>
                                    <p class="text-purple-600 text-sm font-medium">OVO Digital</p>
                                </div>
                            </div>

                            <!-- DANA -->
                            <div class="ewallet-card group bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer border-2 border-blue-200 hover:border-blue-400 hover:scale-105" onclick="openEwalletModal('dana', 'DANA', 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/1200px-Logo_dana_blue.svg.png')">
                                <div class="text-center">
                                    <div class="ewallet-logo-container w-16 h-16 mx-auto mb-4 bg-white rounded-2xl p-3 shadow-lg group-hover:shadow-xl transition-all duration-300 flex items-center justify-center">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/1200px-Logo_dana_blue.svg.png" alt="DANA" class="w-full h-full object-contain">
                                    </div>
                                    <h3 class="ewallet-name text-lg font-bold text-blue-800 mb-2 group-hover:text-blue-900 transition-colors">DANA</h3>
                                    <p class="text-blue-600 text-sm font-medium">DANA Indonesia</p>
                                </div>
                            </div>

                            <!-- ShopeePay -->
                            <div class="ewallet-card group bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer border-2 border-orange-200 hover:border-orange-400 hover:scale-105" onclick="openEwalletModal('shopeepay', 'ShopeePay', 'https://cdn-icons-png.flaticon.com/512/5969/5969059.png')">
                                <div class="text-center">
                                    <div class="ewallet-logo-container w-16 h-16 mx-auto mb-4 bg-white rounded-2xl p-3 shadow-lg group-hover:shadow-xl transition-all duration-300 flex items-center justify-center">
                                        <img src="https://bloguna.com/wp-content/uploads/2025/06/Logo-ShopeePay-PNG-CDR-SVG-EPS-Kualitas-HD.png" alt="ShopeePay" class="w-full h-full object-contain">
                                    </div>
                                    <h3 class="ewallet-name text-lg font-bold text-orange-800 mb-2 group-hover:text-orange-900 transition-colors">ShopeePay</h3>
                                    <p class="text-orange-600 text-sm font-medium">Shopee Digital</p>
                                </div>
                            </div>

                            <!-- LinkAja -->
                            <div class="ewallet-card group bg-gradient-to-br from-teal-50 to-teal-100 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer border-2 border-teal-200 hover:border-teal-400 hover:scale-105" onclick="openEwalletModal('linkaja', 'LinkAja', 'https://cdn-icons-png.flaticon.com/512/5969/5969059.png')">
                                <div class="text-center">
                                    <div class="ewallet-logo-container w-16 h-16 mx-auto mb-4 bg-white rounded-2xl p-3 shadow-lg group-hover:shadow-xl transition-all duration-300 flex items-center justify-center">
                                        <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjVlPZwKzWUoaxBpt6mJCixaNjGdbraFXJjCQcdVwuLsqz02UAAzAidd6y745xuXLvCtVPfhObIWVLPT6oZbS9U5iICX2XhEmBqbR-AGL-Edx3Iipq-4qGwLBAcqpB8Q5QQ3p0bG3By-7o/s2048/Logo+LinkAja.png" alt="LinkAja" class="w-full h-full object-contain">
                                    </div>
                                    <h3 class="ewallet-name text-lg font-bold text-teal-800 mb-2 group-hover:text-teal-900 transition-colors">LinkAja</h3>
                                    <p class="text-teal-600 text-sm font-medium">LinkAja Digital</p>
                                </div>
                            </div>
                            
                            <!-- Pulsa -->
                            <div class="ewallet-card group bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer border-2 border-indigo-200 hover:border-indigo-400 hover:scale-105" onclick="openEwalletModal('pulsa', 'Pulsa', 'placeholder')">
                                <div class="text-center">
                                    <div class="ewallet-logo-container w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-2xl p-3 shadow-lg group-hover:shadow-xl transition-all duration-300 flex items-center justify-center">
                                        <i class="fas fa-mobile-alt text-white text-2xl"></i>
                                    </div>
                                    <h3 class="ewallet-name text-lg font-bold text-indigo-800 mb-2 group-hover:text-indigo-900 transition-colors">Pulsa</h3>
                                    <p class="text-indigo-600 text-sm font-medium">Mobile Credit</p>
                                </div>
                            </div>

                            <!-- Token Listrik -->
                            <div class="ewallet-card group bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer border-2 border-yellow-200 hover:border-yellow-400 hover:scale-105" onclick="openEwalletModal('tokenlistrik', 'Token Listrik', 'placeholder')">
                                <div class="text-center">
                                    <div class="ewallet-logo-container w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl p-3 shadow-lg group-hover:shadow-xl transition-all duration-300 flex items-center justify-center">
                                        <i class="fas fa-bolt text-white text-2xl"></i>
                                    </div>
                                    <h3 class="ewallet-name text-lg font-bold text-yellow-800 mb-2 group-hover:text-yellow-900 transition-colors">Token Listrik</h3>
                                    <p class="text-yellow-600 text-sm font-medium">Electricity Token</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Additional Info Section -->
                        <div class="mt-8 text-center">
                            <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-medium">
                                <i class="fas fa-info-circle"></i>
                                <span>Semua e-wallet tersedia 24/7 • Proses instan • Tanpa biaya tersembunyi</span>
                            </div>
                        </div>
                    </div>

                    <!-- List Transaksi Section -->
                    <div class="transaction-section bg-white rounded-2xl shadow-lg p-6">
                        <h2 class="section-title text-xl font-bold text-blue-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-history"></i> Riwayat Transaksi
                        </h2>
                        <div class="transaction-list">
                            <div id="transaction-history-list" class="space-y-3">
                                <!-- Transactions will be loaded here -->
                            </div>
                            <div id="no-history-message" class="text-center py-8 text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3"></i>
                                <p>Belum ada transaksi</p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="footer text-center mt-10 text-gray-500">
                Created by <strong>TEK(G)</strong> | All Right Reserved
            </div>
        </div>
    </div>

    <!-- E-Wallet Modal -->
    <div id="ewalletModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4">
                <!-- Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <img id="modalProviderLogo" src="" alt="Provider" class="w-8 h-8 rounded-lg">
                        <h3 class="text-xl font-bold text-gray-800" id="modalProviderName">E-Wallet</h3>
                    </div>
                    <button onclick="closeEwalletModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Step 1: Input Nominal -->
                <div id="step1" class="p-6">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-wallet text-white text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Input Nominal</h4>
                        <p class="text-gray-600 text-sm">Masukkan nominal yang ingin ditukar</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nominal (Rp)</label>
                            <input type="number" id="ewalletAmount" placeholder="0" 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:outline-none transition-colors text-center text-lg font-semibold">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP/Rekening</label>
                            <input type="text" id="ewalletNumber" placeholder="Masukkan nomor HP atau rekening" 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:outline-none transition-colors">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pemilik</label>
                            <input type="text" id="ewalletOwner" placeholder="Masukkan nama pemilik rekening" 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:outline-none transition-colors">
                        </div>
                        
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Poin yang akan ditukar:</span>
                                <span id="pointsToExchange" class="font-semibold text-blue-600">0 poin</span>
                            </div>
                            <div class="flex justify-between items-center text-sm mt-2">
                                <span class="text-gray-600">Sisa poin:</span>
                                <span id="remainingPoints" class="font-semibold text-green-600">0 poin</span>
                            </div>
                        </div>

                        <button onclick="nextToStep2()" id="nextStep1Btn" 
                                class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-blue-600 hover:to-purple-700 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            Lanjutkan
                        </button>
                    </div>
                </div>

                <!-- Step 2: Konfirmasi -->
                <div id="step2" class="p-6 hidden">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-check-circle text-white text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Konfirmasi Penukaran</h4>
                        <p class="text-gray-600 text-sm">Periksa detail penukaran Anda</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 mb-6">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Provider:</span>
                                <span id="confirmProvider" class="font-semibold text-gray-800">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Nomor HP/Rekening:</span>
                                <span id="confirmNumber" class="font-semibold text-gray-800">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Nama Pemilik:</span>
                                <span id="confirmOwner" class="font-semibold text-gray-800">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Nominal E-Wallet:</span>
                                <span id="confirmAmount" class="font-semibold text-gray-800">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Poin yang ditukar:</span>
                                <span id="confirmPoints" class="font-semibold text-blue-600">0 poin</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Biaya admin:</span>
                                <span id="confirmAdminFee" class="font-semibold text-gray-800">Rp 0</span>
                            </div>
                            <hr class="border-gray-300">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-800 font-semibold">Total:</span>
                                <span id="confirmTotal" class="font-bold text-lg text-blue-600">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex space-x-3">
                        <button onclick="backToStep1()" 
                                class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-300 transition-colors">
                            Kembali
                        </button>
                        <button onclick="confirmExchange()" 
                                class="flex-1 bg-gradient-to-r from-green-500 to-blue-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-blue-700 transition-all duration-200">
                            Konfirmasi
                        </button>
                    </div>
                </div>

                <!-- Step 3: Sukses -->
                <div id="step3" class="p-6 hidden">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-check-circle text-white text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Penukaran Berhasil!</h4>
                        <p class="text-gray-600 text-sm">E-wallet telah ditambahkan ke akun Anda</p>
                    </div>

                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                            <div>
                                <h5 class="font-semibold text-green-800">Transaksi Selesai</h5>
                                <p class="text-green-600 text-sm">Poin berhasil ditukar ke e-wallet</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 mb-6">
                        <h6 class="font-semibold text-gray-800 mb-3">Detail Transaksi:</h6>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">ID Transaksi:</span>
                                <span id="transactionId" class="font-mono text-gray-800">TRX-001</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal:</span>
                                <span id="transactionDate" class="text-gray-800">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="text-green-600 font-semibold">Berhasil</span>
                            </div>
                        </div>
                    </div>

                    <button onclick="closeEwalletModal()" 
                            class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-blue-600 hover:to-purple-700 transition-all duration-200">
                        Selesai
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="fixed top-0 left-0 w-full h-1 bg-gray-200 z-50">
        <div id="progressBar" class="h-full bg-gradient-to-r from-blue-500 to-purple-600 transition-all duration-500" style="width: 0%"></div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    
    <script>
        // E-Wallet Modal Functions
        let currentStep = 1;
        let ewalletData = {
            provider: '',
            providerName: '',
            providerLogo: '',
            amount: 0,
            points: 0,
            adminFee: 0
        };

        // User data
        let userPoints = 4297; // Poin user saat ini
        let transactions = []; // Array untuk menyimpan transaksi

        // Add some dummy transactions for testing
        function addDummyTransactions() {
            const dummyTransactions = [
                {
                    id: 'TRX-001',
                    provider: 'Gopay',
                    number: '081234567890',
                    owner: 'John Doe',
                    amount: 50000,
                    points: 500,
                    date: '15 Januari 2025, 14:30',
                    status: 'Berhasil'
                },
                {
                    id: 'TRX-002',
                    provider: 'OVO',
                    number: '081234567891',
                    owner: 'Jane Smith',
                    amount: 25000,
                    points: 250,
                    date: '12 Januari 2025, 09:15',
                    status: 'Berhasil'
                },
                {
                    id: 'TRX-003',
                    provider: 'DANA',
                    number: '081234567892',
                    owner: 'Bob Johnson',
                    amount: 100000,
                    points: 1000,
                    date: '10 Januari 2025, 16:45',
                    status: 'Berhasil'
                }
            ];
            
            transactions = dummyTransactions;
            renderTransactionHistory();
            
            // Also update the user points to be more realistic
            userPoints = 2500; // Set a realistic starting point
            document.getElementById('user-points-display').textContent = userPoints + ' Poin';
        }

        function openEwalletModal(providerId, providerName, providerLogo) {
            ewalletData.provider = providerId;
            ewalletData.providerName = providerName;
            ewalletData.providerLogo = providerLogo;
            
            // Update modal header
            document.getElementById('modalProviderLogo').src = providerLogo;
            document.getElementById('modalProviderName').textContent = providerName;
            
            // Reset modal
            resetEwalletModal();
            
            // Show modal
            document.getElementById('ewalletModal').classList.remove('hidden');
            
            // Update progress bar
            updateProgressBar();
        }

        function closeEwalletModal() {
            document.getElementById('ewalletModal').classList.add('hidden');
            resetEwalletModal();
        }

        function resetEwalletModal() {
            currentStep = 1;
            
            // Hide all steps
            document.getElementById('step1').classList.remove('hidden');
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step3').classList.add('hidden');
            
            // Reset form
            document.getElementById('ewalletAmount').value = '';
            document.getElementById('ewalletNumber').value = '';
            document.getElementById('ewalletOwner').value = '';
            document.getElementById('pointsToExchange').textContent = '0 poin';
            document.getElementById('remainingPoints').textContent = userPoints + ' poin';
            
            // Reset data
            ewalletData.amount = 0;
            ewalletData.points = 0;
            ewalletData.adminFee = 0;
            ewalletData.number = '';
            ewalletData.owner = '';
            
            // Disable next button
            document.getElementById('nextStep1Btn').disabled = true;
            
            // Update progress bar
            updateProgressBar();
        }

        function updateProgressBar() {
            const progress = (currentStep / 3) * 100;
            document.getElementById('progressBar').style.width = progress + '%';
        }

        function nextToStep2() {
            const amount = parseInt(document.getElementById('ewalletAmount').value);
            const number = document.getElementById('ewalletNumber').value.trim();
            const owner = document.getElementById('ewalletOwner').value.trim();
            
            if (amount <= 0) {
                alert('Masukkan nominal yang valid');
                return;
            }
            
            if (!number) {
                alert('Masukkan nomor HP atau rekening');
                return;
            }
            
            if (!owner) {
                alert('Masukkan nama pemilik rekening');
                return;
            }
            
            // Calculate points and admin fee
            ewalletData.amount = amount;
            ewalletData.points = Math.ceil(amount / 100); // 1 poin = Rp 100
            ewalletData.adminFee = Math.ceil(amount * 0.02); // 2% admin fee
            ewalletData.number = number;
            ewalletData.owner = owner;
            
            // Check if user has enough points
            if (ewalletData.points > userPoints) {
                alert('Poin Anda tidak cukup untuk nominal ini');
                return;
            }
            
            // Update confirmation screen
            document.getElementById('confirmProvider').textContent = ewalletData.providerName;
            document.getElementById('confirmNumber').textContent = number;
            document.getElementById('confirmOwner').textContent = owner;
            document.getElementById('confirmAmount').textContent = 'Rp ' + amount.toLocaleString('id-ID');
            document.getElementById('confirmPoints').textContent = ewalletData.points + ' poin';
            document.getElementById('confirmAdminFee').textContent = 'Rp ' + ewalletData.adminFee.toLocaleString('id-ID');
            document.getElementById('confirmTotal').textContent = 'Rp ' + (amount + ewalletData.adminFee).toLocaleString('id-ID');
            
            // Hide step 1, show step 2
            document.getElementById('step1').classList.add('hidden');
            document.getElementById('step2').classList.remove('hidden');
            
            currentStep = 2;
            updateProgressBar();
        }

        function backToStep1() {
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step1').classList.remove('hidden');
            
            currentStep = 1;
            updateProgressBar();
        }

        function confirmExchange() {
            // Deduct points from user
            userPoints -= ewalletData.points;
            
            // Generate transaction ID
            const transactionId = 'TRX-' + Date.now().toString().slice(-6);
            
            // Add to transaction history
            addToTransactionHistory(transactionId, ewalletData.amount, ewalletData.points, new Date());
            
            // Update user points display
            document.getElementById('user-points-display').textContent = userPoints + ' Poin';
            document.getElementById('remainingPoints').textContent = userPoints + ' poin';
            
            // Update transaction details in step 3
            document.getElementById('transactionId').textContent = transactionId;
            document.getElementById('transactionDate').textContent = new Date().toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            // Hide step 2, show step 3
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step3').classList.remove('hidden');
            
            currentStep = 3;
            updateProgressBar();
        }

        function addToTransactionHistory(id, amount, points, date) {
            const transaction = {
                id: id,
                provider: ewalletData.providerName,
                number: ewalletData.number,
                owner: ewalletData.owner,
                amount: amount,
                points: points,
                date: date.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                }),
                status: 'Berhasil'
            };
            
            transactions.unshift(transaction);
            renderTransactionHistory();
            updatePointsDisplay(); // Update points display after adding new transaction
        }

        function renderTransactionHistory() {
            const transactionList = document.getElementById('transaction-history-list');
            const noHistoryMessage = document.getElementById('no-history-message');
            
            if (transactions.length === 0) {
                noHistoryMessage.classList.remove('hidden');
                return;
            }
            
            noHistoryMessage.classList.add('hidden');
            transactionList.innerHTML = '';
            
            transactions.forEach(transaction => {
                const transactionItem = document.createElement('div');
                transactionItem.className = 'bg-gray-50 rounded-xl p-4 border border-gray-200';
                transactionItem.innerHTML = `
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-wallet text-white text-sm"></i>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-gray-800">${transaction.provider}</h5>
                                    <p class="text-sm text-gray-600">ID: ${transaction.id}</p>
                                    <p class="text-sm text-gray-600">${transaction.number} - ${transaction.owner}</p>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500">${transaction.date}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-blue-600">Rp ${transaction.amount.toLocaleString('id-ID')}</div>
                            <div class="text-sm text-gray-600">-${transaction.points} poin</div>
                            <span class="inline-block px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full font-medium">${transaction.status}</span>
                        </div>
                    </div>
                `;
                transactionList.appendChild(transactionItem);
            });
        }

        // Function to update current date/time
        function updateDateTime() {
            const now = new Date();
            const dateString = now.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            const dateElement = document.getElementById('current-date-1');
            if (dateElement) {
                dateElement.textContent = dateString;
            }
        }
        
        // Function to calculate and update points display
        function updatePointsDisplay() {
            let totalPointsIn = 0;
            let totalPointsOut = 0;
            
            // Calculate points from transaction history
            transactions.forEach(transaction => {
                if (transaction.status === 'Berhasil') {
                    // For now, assume all successful transactions are points out (e-wallet exchanges)
                    // In a real system, you'd have different transaction types
                    totalPointsOut += transaction.points;
                }
            });
            
            // For demo purposes, let's add some sample points in (you can modify this logic)
            // In a real system, this would come from actual point earning transactions
            totalPointsIn = userPoints + totalPointsOut; // Total points user has + what they've spent
            
            // Update the display
            document.getElementById('poin-in-display').textContent = totalPointsIn.toLocaleString('id-ID') + ' Poin';
            document.getElementById('poin-out-display').textContent = totalPointsOut.toLocaleString('id-ID') + ' Poin';
        }
        
        // Real-time calculation for step 1
        document.addEventListener('DOMContentLoaded', function() {
            const amountInput = document.getElementById('ewalletAmount');
            if (amountInput) {
                amountInput.addEventListener('input', function() {
                    const amount = parseInt(this.value) || 0;
                    const points = Math.ceil(amount / 100);
                    const remaining = userPoints - points;
                    
                    document.getElementById('pointsToExchange').textContent = points + ' poin';
                    document.getElementById('remainingPoints').textContent = remaining + ' poin';
                    
                    // Enable/disable next button
                    const nextBtn = document.getElementById('nextStep1Btn');
                    if (amount > 0 && points <= userPoints) {
                        nextBtn.disabled = false;
                        nextBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    } else {
                        nextBtn.disabled = true;
                        nextBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                });
            }
            
            // Initialize transaction history with dummy data
            addDummyTransactions();
            updatePointsDisplay(); // Update points display after loading transactions
        });

        // Close modal when clicking outside
        document.getElementById('ewalletModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEwalletModal();
            }
        });

        // Toast notification function
        function showToast(type, title, message) {
            // Simple alert for now, can be enhanced with proper toast
            alert(`${title}: ${message}`);
        }
    </script>
</div>
@endsection