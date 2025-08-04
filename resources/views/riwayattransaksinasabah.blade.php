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

    /* Balance Section */
    .balance-section {
      display: flex;
      gap: 25px;
      margin-bottom: 30px;
    }

    .balance-card {
      background: white;
      border-radius: 16px;
      padding: 25px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      flex: 1;
      position: relative;
      overflow: hidden;
    }

    .balance-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: linear-gradient(90deg, #75E6DA, #05445E);
    }

    .balance-date {
      font-size: 14px;
      color: #666;
      margin-bottom: 5px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .balance-title {
      font-size: 18px;
      color: #05445E;
      font-weight: 700;
      margin-bottom: 5px;
    }

    .balance-subtitle {
      font-size: 14px;
      color: #666;
      margin-bottom: 10px;
    }

    .balance-badge {
      background: #4ADE80;
      color: white;
      font-size: 12px;
      font-weight: 600;
      padding: 4px 10px;
      border-radius: 20px;
      display: inline-block;
      margin-bottom: 15px;
    }

    .balance-amount {
      font-size: 32px;
      font-weight: 800;
      color: #05445E;
      margin-bottom: 5px;
    }

    .balance-footer {
      font-size: 14px;
      color: #666;
    }

    .promo-card {
      background: linear-gradient(135deg, #00C9FF 0%, #92FE9D 100%);
      border-radius: 16px;
      padding: 25px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      flex: 2;
      display: flex;
      align-items: center;
      justify-content: space-between;
      color: white;
      position: relative;
      overflow: hidden;
    }

    .promo-content {
      max-width: 60%;
    }

    .promo-title {
      font-size: 20px;
      font-weight: 700;
      margin-bottom: 10px;
    }

    .promo-subtitle {
      font-size: 16px;
      opacity: 0.9;
    }

    .promo-image {
      width: 150px;
      height: auto;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* Sections Container */
    .poinmu-content-wrapper > div {
        display: none; /* Hide all sections by default */
    }
    .poinmu-content-wrapper > div.active-section {
        display: block; /* Show only the active section */
    }

    /* E-Wallet Section */
    .ewallet-section {
      background: white;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      margin-bottom: 30px;
    }

    .section-title {
      color: #0a3a60;
      font-weight: 700;
      font-size: 22px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .section-title i {
      color: #05445E;
      font-size: 24px;
    }
    
    .section-title img {
      height: 30px; /* Consistent height for logos in section titles */
      margin-right: 10px;
      object-fit: contain; /* Ensure logo fits without distortion */
    }

    .ewallet-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
      gap: 20px;
    }

    .ewallet-card {
      background: white;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.3s;
      border: 1px solid #eee;
    }
    
    .ewallet-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
      border-color: #75E6DA;
    }

    .ewallet-logo {
      width: 60px;
      height: 60px;
      object-fit: contain;
      margin-bottom: 15px;
    }

    .ewallet-name {
      font-weight: 600;
      color: #333;
      text-align: center; /* Center text for names */
    }

    /* Nominal Selection Section */
    .nominal-section {
      background: white;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      margin-bottom: 30px;
    }

    .nominal-back {
      display: flex;
      align-items: center;
      gap: 8px;
      color: #05445E;
      font-weight: 600;
      margin-bottom: 20px;
      cursor: pointer;
    }

    .nominal-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 20px;
    }

    .nominal-item {
      background: white;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
      transition: all 0.3s;
      border: 1px solid #eee;
      text-align: center;
      cursor: pointer;
    }

    .nominal-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
      border-color: #75E6DA;
    }

    .nominal-provider {
      font-size: 16px;
      font-weight: 600;
      color: #05445E;
      margin-bottom: 10px;
    }

    .nominal-currency {
      font-size: 14px;
      color: #666;
    }

    .nominal-amount {
      font-size: 24px;
      font-weight: 700;
      color: #05445E;
      margin: 10px 0;
    }

    .nominal-points {
      background: linear-gradient(135deg, #05445E 0%, #0A3A60 100%);
      color: white;
      padding: 8px;
      border-radius: 6px;
      font-weight: 600;
      font-size: 14px;
    }
    
    /* Redemption Confirmation Section */
    .redemption-section {
        background: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    .redemption-summary {
        background: #f8f9fc;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        border: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap; /* Allow wrapping for smaller screens */
        gap: 15px;
    }

    .redemption-summary .summary-info h4 {
        font-size: 18px;
        color: #05445E;
        margin-bottom: 5px;
    }

    .redemption-summary .summary-info p {
        font-size: 14px;
        color: #666;
    }
    
    .redemption-summary .summary-points {
        background: #05445E;
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        font-weight: 600;
        white-space: nowrap; /* Prevent text wrapping */
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }
    
    .form-group input {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 16px;
        transition: border-color 0.3s;
    }
    
    .form-group input:focus {
        outline: none;
        border-color: #75E6DA;
        box-shadow: 0 0 0 2px rgba(117, 230, 218, 0.2);
    }
    
    .redemption-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 25px;
    }
    
    .btn {
        padding: 12px 25px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
    }
    
    .btn-primary {
        background: #05445E;
        color: white;
    }
    
    .btn-primary:hover {
        background: #0A3A60;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .btn-secondary {
        background: #f16728;
        color: white;
    }
    
    .btn-secondary:hover {
        background: #e05e24;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .error-message {
        color: #FF5A5F;
        font-size: 14px;
        margin-top: 5px;
        display: none;
    }

    /* Transaction History Section */
    .transaction-history-section {
      background: white;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      margin-bottom: 30px;
    }

    .transaction-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .transaction-header .section-title {
        margin-bottom: 0; /* Override default margin */
    }

    .transaction-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .transaction-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #eee;
    }

    .transaction-item:last-child {
        border-bottom: none;
    }

    .transaction-info {
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
    }

    .transaction-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #05445E;
        font-size: 18px;
    }
    .transaction-icon.in {
        background-color: #e6ffed; /* Light green */
        color: #28a745; /* Green */
    }
    .transaction-icon.out {
        background-color: #ffe6e6; /* Light red */
        color: #dc3545; /* Red */
    }

    .transaction-details {
        flex: 1;
    }

    .transaction-details h4 {
        font-size: 16px;
        color: #333;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .transaction-details p {
        font-size: 13px;
        color: #888;
    }

    .transaction-amount {
        font-size: 16px;
        font-weight: 700;
        color: #333;
        white-space: nowrap; /* Prevent wrapping */
    }

    .transaction-amount.positive {
        color: #28a745;
    }

    .transaction-amount.negative {
        color: #dc3545;
    }
    
    .view-all-transactions {
        text-align: right;
        margin-top: 20px;
    }

    .view-all-transactions a {
        color: #05445E;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: color 0.3s;
    }

    .view-all-transactions a:hover {
        color: #f16728;
    }

    .print-button {
        background: #05445E;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .print-button:hover {
        background: #0A3A60;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
      .balance-section {
        flex-direction: column;
      }
      
      .promo-content {
        max-width: 100%;
      }
      
      .promo-image {
        display: none;
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

      .ewallet-grid {
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
      }
      .nominal-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      }
      .transaction-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
      }
      .transaction-icon {
        margin-right: 0;
        margin-bottom: 5px;
      }
    }
    @media (max-width: 480px) {
        .redemption-summary {
            flex-direction: column;
            align-items: flex-start;
        }
        .redemption-actions {
            flex-direction: column;
            width: 100%;
        }
        .btn {
            width: 100%;
        }
    }
  </style>

<div class="flex min-h-screen bg-gray-50" x-data="{ sidebarOpen: false }">
    {{-- Sidebar Overlay --}}
    <div class="sidebar-overlay" :class="{ 'active': sidebarOpen }" @click="sidebarOpen = false"></div>

    {{-- Sidebar --}}
    <aside 
        x-data="{ open: false, active: 'riwayat-transaksi' }"
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
                    <h1 class="text-2xl font-bold text-gray-800"><i class="fas fa-history"></i> Riwayat Transaksi</h1>
                    <p class="text-sm text-gray-500">Lihat dan kelola riwayat transaksi poin Anda</p>
                </div>
            </div>

    <div class="balance-section">
      <div class="balance-card">
        <div class="balance-date">
          <i class="fas fa-calendar-alt"></i> <span id="current-date"></span>
        </div>
        <h3 class="balance-title">Poin Anda</h3>
        <p class="balance-subtitle">Saldo Poin terbilang...</p>
        <span class="balance-badge">Aktif</span>
        <div class="balance-amount" id="user-points-display">4.297 Koin</div>
        <p class="balance-footer">Terakhir Diperbarui</p>
      </div>
      
      <div class="promo-card">
        <div class="promo-content">
          <h3 class="promo-title">Tukar Poinmu Jadi Pulsa, Token Listrik dan Saldo E-Wallet!</h3>
          <p class="promo-subtitle">Dapatkan berbagai keuntungan dengan menukarkan poin Anda</p>
        </div>
        <img src="https://i.ibb.co/dMGtFq5/ewallet-mockup.png" alt="E-Wallet" class="promo-image">
      </div>
    </div>
    
    <div class="poinmu-content-wrapper">
      <div class="ewallet-section active-section" id="ewalletSelectionSection">
        <h2 class="section-title">
          <i class="fas fa-wallet"></i> Pilih Tujuan Penukaran
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
          
          <div class="ewallet-card" data-provider-id="shopeepay" onclick="showNominalSelection('shopeepay', 'ShopeePay', 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a6/ShopeePay_logo.svg/1200px-ShopeePay_logo.svg.png')">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a6/ShopeePay_logo.svg/1200px-ShopeePay_logo.svg.png" alt="ShopeePay" class="ewallet-logo">
            <span class="ewallet-name">ShopeePay</span>
          </div>
          
          <div class="ewallet-card" data-provider-id="linkaja" onclick="showNominalSelection('linkaja', 'LinkAja', 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7a/LinkAja.svg/1200px-LinkAja.svg.png')">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7a/LinkAja.svg/1200px-LinkAja.svg.png" alt="LinkAja" class="ewallet-logo">
            <span class="ewallet-name">LinkAja</span>
          </div>
          
          <div class="ewallet-card" data-provider-id="pulsa" onclick="showNominalSelection('pulsa', 'Pulsa', 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Pulsa_logo.svg/1200px-Pulsa_logo.svg.png')">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Pulsa_logo.svg/1200px-Pulsa_logo.svg.png" alt="Pulsa" class="ewallet-logo">
            <span class="ewallet-name">Pulsa</span>
          </div>
          
          <div class="ewallet-card" data-provider-id="pln" onclick="showNominalSelection('pln', 'Token Listrik', 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/36/Logo_PLN_2019.svg/1200px-Logo_PLN_2019.svg.png')">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/36/Logo_PLN_2019.svg/1200px-Logo_PLN_2019.svg.png" alt="PLN" class="ewallet-logo">
            <span class="ewallet-name">Token Listrik</span>
          </div>
        </div>
      </div>

      <div class="nominal-section" id="nominalSelectionSection">
        <div class="nominal-back" onclick="showSection('ewalletSelectionSection')">
          <i class="fas fa-arrow-left"></i> Kembali ke Pilihan Tujuan
        </div>
        
        <h2 class="section-title" id="nominal-section-title">
          </h2>
        <p style="margin-bottom: 20px; font-size: 14px; color: #666;">Pilih nominal yang ingin Anda tukarkan dan isi ulang.</p>
        
        <div class="nominal-grid" id="nominal-grid-container">
          </div>
      </div>
      
      <div class="redemption-section" id="pointExchangeConfirmationSection">
        <div class="nominal-back" onclick="showNominalSelection(selectedProviderId, selectedProviderName, selectedProviderLogo)">
            <i class="fas fa-arrow-left"></i> Kembali ke Nominal
        </div>

        <h2 class="section-title">
            <img id="exchange-confirm-logo" src="" alt="" style="height: 30px; margin-right: 10px;">
            Konfirmasi Penukaran Poin ke Saldo <span id="exchange-confirm-provider-name"></span>
        </h2>
        
        <div class="redemption-summary">
            <div class="summary-info">
                <h4>Anda akan menukarkan:</h4>
                <p id="exchange-points-info"></p>
            </div>
            <div class="summary-points">
                <span id="exchange-rp-info"></span>
            </div>
        </div>
        
        <p style="font-size:14px; color:#666; margin-top: 15px;">
            Poin akan dipotong dari saldo poin Anda, dan saldo Rupiah akan ditambahkan ke "BijakSampah Pay" Anda.
        </p>
            
        <div class="redemption-actions">
            <button type="button" class="btn btn-secondary" onclick="showNominalSelection(selectedProviderId, selectedProviderName, selectedProviderLogo)">Batalkan</button>
            <button type="button" class="btn btn-primary" id="confirm-point-exchange-btn">Tukar Poin Sekarang</button>
        </div>
      </div>

      <div class="redemption-section" id="finalRedemptionFormSection">
        <div class="nominal-back" onclick="showNominalSelection(selectedProviderId, selectedProviderName, selectedProviderLogo)">
            <i class="fas fa-arrow-left"></i> Kembali ke Nominal
        </div>

        <h2 class="section-title">
            <img id="final-redeem-logo" src="" alt="" style="height: 30px; margin-right: 10px;">
            Isi Ulang <span id="final-redeem-provider-name"></span>
        </h2>
        
        <div class="redemption-summary">
            <div class="summary-info">
                <h4>Isi Ulang Saldo:</h4>
                <p id="final-redeem-amount-text">Rp 10.000</p>
            </div>
            <div class="summary-points">
                Saldo BijakSampah Pay: <span id="bijak-sampah-pay-balance-display">Rp 0</span>
            </div>
        </div>
        
        <div class="redemption-form">
            <div class="form-group">
                <label for="phone-number" id="phone-number-label">Nomor HP / Akun</label>
                <input type="text" id="phone-number" name="phone-number" placeholder="Masukkan nomor HP atau ID akun">
                <p id="phone-error" class="error-message">Nomor HP/ID tidak valid.</p>
            </div>
            <div class="form-group">
                <p style="font-size:14px; color:#666;">
                    Pastikan nomor/ID yang Anda masukkan sudah benar. Setelah penukaran berhasil, saldo tidak dapat dikembalikan.
                </p>
            </div>
            
            <div class="redemption-actions">
                <button type="button" class="btn btn-secondary" onclick="showNominalSelection(selectedProviderId, selectedProviderName, selectedProviderLogo)">Batalkan</button>
                <button type="button" class="btn btn-primary" id="confirm-final-redeem-btn">Isi Ulang Sekarang</button>
            </div>
        </div>
      </div>
      
      <div class="transaction-history-section active-section" id="transactionHistorySection">
        <div class="transaction-header">
            <h2 class="section-title">
                <i class="fas fa-history"></i> Riwayat Transaksi
            </h2>
            <button class="print-button" onclick="printTransactionHistory()">
                <i class="fas fa-print"></i> Cetak Riwayat
            </button>
        </div>
        
        <ul class="transaction-list" id="transaction-list">
          </ul>
        
        <div class="view-all-transactions">
            <a href="#" onclick="alert('Halaman semua transaksi belum tersedia!')">Lihat Semua Transaksi <i class="fas fa-chevron-right"></i></a>
        </div>
      </div>

    </div> <div class="footer">
      Created by <strong>TEK(G)</strong> | All Right Reserved!
    </div>
  </div>

  <script>
    // --- Global State Variables ---
    let userPoints = 4297; // Initial points
    let bijakSampahPayBalance = 25000; // Initial internal Rupiah balance

    let transactions = [
        { type: 'in', description: 'Tambahan Poin dari Penjemputan', amountPoints: 500, amountRupiah: 0, balancePoints: 4297, balanceRupiah: 25000, date: new Date(2025, 6, 29, 10, 0) },
        { type: 'out', description: 'Tukar Poin ke Saldo BijakSampah Pay (Gopay Rp 10.000)', amountPoints: -1249, amountRupiah: 10000, balancePoints: 3797, balanceRupiah: 15000, date: new Date(2025, 6, 28, 15, 30) },
        { type: 'out', description: 'Isi Ulang Gopay Rp 10.000 (0812xxxxxx)', amountPoints: 0, amountRupiah: -10000, balancePoints: 3797, balanceRupiah: 5000, date: new Date(2025, 6, 28, 15, 35) },
        { type: 'in', description: 'Tambahan Poin dari Penjemputan', amountPoints: 1000, amountRupiah: 0, balancePoints: 5046, balanceRupiah: 5000, date: new Date(2025, 6, 27, 9, 0) },
        { type: 'out', description: 'Isi Ulang DANA Rp 15.000 (0813xxxxxx)', amountPoints: 0, amountRupiah: -15000, balancePoints: 5046, balanceRupiah: -10000, date: new Date(2025, 6, 26, 11, 0) },
        { type: 'in', description: 'Tambahan Saldo (Transfer Bank)', amountPoints: 0, amountRupiah: 20000, balancePoints: 5046, balanceRupiah: 10000, date: new Date(2025, 6, 26, 10, 0) },
    ];
    // Reverse to show newest first for display
    transactions.sort((a, b) => b.date - a.date);


    let selectedExchange = { // For point exchange to internal balance
        targetAmountRupiah: 0,
        pointsRequired: 0,
        providerId: '',
        providerName: '',
        providerLogo: ''
    };

    let selectedFinalRedemption = { // For internal balance to e-wallet/pulsa
        amountRupiah: 0,
        providerId: '',
        providerName: '',
        providerLogo: ''
    };

    let currentSectionId = 'ewalletSelectionSection'; // To keep track of current view

    // Data for nominals for each provider
    const nominalData = {
        gopay: [
            { amount: 10000, points: 1249 },
            { amount: 15000, points: 1849 },
            { amount: 20000, points: 2349 },
            { amount: 30000, points: 3449 },
            { amount: 35000, points: 3949 },
            { amount: 50000, points: 5549 },
            { amount: 100000, points: 11098 },
            { amount: 150000, points: 16647 }
        ],
        ovo: [
            { amount: 10000, points: 1299 },
            { amount: 25000, points: 3099 },
            { amount: 50000, points: 6199 },
            { amount: 100000, points: 12298 },
            { amount: 200000, points: 24596 }
        ],
        dana: [
            { amount: 10000, points: 1249 },
            { amount: 20000, points: 2499 },
            { amount: 50000, points: 6099 },
            { amount: 100000, points: 12098 }
        ],
        shopeepay: [
            { amount: 10000, points: 1249 },
            { amount: 20000, points: 2499 },
            { amount: 50000, points: 6099 },
            { amount: 100000, points: 12098 }
        ],
        linkaja: [
            { amount: 10000, points: 1249 },
            { amount: 20000, points: 2499 },
            { amount: 50000, points: 6099 },
            { amount: 100000, points: 12098 }
        ],
        pulsa: [
            { amount: 5000, points: 700 },
            { amount: 10000, points: 1300 },
            { amount: 25000, points: 3000 },
            { amount: 50000, points: 5900 },
            { amount: 100000, points: 11500 }
        ],
        pln: [
            { amount: 20000, points: 2500, label: '20.000 (20 kWh)' },
            { amount: 50000, points: 6000, label: '50.000 (50 kWh)' },
            { amount: 100000, points: 11800, label: '100.000 (100 kWh)' },
            { amount: 200000, points: 23000, label: '200.000 (200 kWh)' }
        ]
    };

    // DOM Elements (cached for performance)
    const sidebar = document.getElementById('sidebar');
    const toggleCollapse = document.getElementById('toggleCollapse');
    const poinmuContentWrapper = document.querySelector('.poinmu-content-wrapper');
    const ewalletSelectionSection = document.getElementById('ewalletSelectionSection');
    const nominalSelectionSection = document.getElementById('nominalSelectionSection');
    const pointExchangeConfirmationSection = document.getElementById('pointExchangeConfirmationSection');
    const finalRedemptionFormSection = document.getElementById('finalRedemptionFormSection');
    const transactionHistorySection = document.getElementById('transactionHistorySection');

    const nominalSectionTitle = document.getElementById('nominal-section-title');
    const nominalGridContainer = document.getElementById('nominal-grid-container');

    const exchangeConfirmLogo = document.getElementById('exchange-confirm-logo');
    const exchangeConfirmProviderName = document.getElementById('exchange-confirm-provider-name');
    const exchangePointsInfo = document.getElementById('exchange-points-info');
    const exchangeRpInfo = document.getElementById('exchange-rp-info');
    const confirmPointExchangeBtn = document.getElementById('confirm-point-exchange-btn');

    const finalRedeemLogo = document.getElementById('final-redeem-logo');
    const finalRedeemProviderName = document.getElementById('final-redeem-provider-name');
    const finalRedeemAmountText = document.getElementById('final-redeem-amount-text');
    const bijakSampahPayBalanceDisplay = document.getElementById('bijak-sampah-pay-balance-display');
    const phoneNumberLabel = document.getElementById('phone-number-label');
    const phoneNumberInput = document.getElementById('phone-number');
    const phoneError = document.getElementById('phone-error');
    const confirmFinalRedeemBtn = document.getElementById('confirm-final-redeem-btn');

    const userPointsDisplay = document.getElementById('user-points-display');
    const currentDateDisplay = document.getElementById('current-date');
    const transactionList = document.getElementById('transaction-list');


    // --- Initialization ---
    document.addEventListener('DOMContentLoaded', () => {
        updatePointAndBalanceDisplays();
        updateCurrentDate();
        showSection('transactionHistorySection'); // Show transaction history by default, as per image
        renderTransactionHistory();
    });

    // --- Helper Functions ---
    function formatNumber(num, isRupiah = false) {
      if (typeof num !== 'number') return num; // Return as is if not a number
      const parts = num.toFixed(0).toString().split('.'); // Ensure no decimals for currency
      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      return (isRupiah ? 'Rp ' : '') + parts.join(',');
    }

    function updatePointAndBalanceDisplays() {
        userPointsDisplay.textContent = `${formatNumber(userPoints)} Koin`;
        bijakSampahPayBalanceDisplay.textContent = formatNumber(bijakSampahPayBalance, true);
    }

    function updateCurrentDate() {
        const today = new Date();
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        currentDateDisplay.textContent = today.toLocaleDateString('id-ID', options);
    }

    function addTransaction(type, description, amountPoints, amountRupiah) {
        transactions.unshift({
            type: type, // 'in' or 'out'
            description: description,
            amountPoints: amountPoints,
            amountRupiah: amountRupiah,
            balancePoints: userPoints, // Current balance after this transaction
            balanceRupiah: bijakSampahPayBalance, // Current balance after this transaction
            date: new Date()
        });
        renderTransactionHistory();
    }

    function renderTransactionHistory() {
        transactionList.innerHTML = ''; // Clear existing list
        const displayLimit = 5; // Display only the latest 5 transactions for summary
        const transactionsToDisplay = transactions.slice(0, displayLimit);

        if (transactionsToDisplay.length === 0) {
            transactionList.innerHTML = '<li style="text-align: center; color: #888; padding: 20px;">Belum ada riwayat transaksi.</li>';
            return;
        }

        transactionsToDisplay.forEach(transaction => {
            const li = document.createElement('li');
            li.classList.add('transaction-item');

            const dateOptions = { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' };
            const formattedDate = transaction.date.toLocaleDateString('id-ID', dateOptions).replace(',', ' '); // Remove comma for formatting

            let iconClass = '';
            let amountText = '';
            let amountClass = '';

            // Prioritize Rupiah display for amounts
            if (transaction.amountRupiah !== 0) {
                amountText = `${transaction.amountRupiah > 0 ? '+' : '-'}Rp ${formatNumber(Math.abs(transaction.amountRupiah))}`;
                amountClass = transaction.amountRupiah > 0 ? 'positive' : 'negative';
                iconClass = transaction.amountRupiah > 0 ? 'in' : 'out';
            } else if (transaction.amountPoints !== 0) {
                amountText = `${transaction.amountPoints > 0 ? '+' : ''}${formatNumber(transaction.amountPoints)} Poin`;
                amountClass = transaction.amountPoints > 0 ? 'positive' : 'negative';
                iconClass = transaction.amountPoints > 0 ? 'in' : 'out';
            }

            const iconHtml = `<div class="transaction-icon ${iconClass}">
                                ${transaction.amountRupiah > 0 ? '<i class="fas fa-plus"></i>' : (transaction.amountRupiah < 0 || transaction.amountPoints < 0 ? '<i class="fas fa-minus"></i>' : '<i class="fas fa-exchange-alt"></i>')}
                              </div>`;

            li.innerHTML = `
                <div class="transaction-info">
                    ${iconHtml}
                    <div class="transaction-details">
                        <h4>${transaction.description}</h4>
                        <p>${formattedDate}</p>
                    </div>
                </div>
                <div class="transaction-amount ${amountClass}">${amountText}</div>
            `;
            transactionList.appendChild(li);
        });
    }

    // --- Section Switching Logic ---
    function showSection(sectionId) {
        // Update current section tracking
        currentSectionId = sectionId;

        // Hide all sections
        const sections = poinmuContentWrapper.children;
        for (let i = 0; i < sections.length; i++) {
            sections[i].classList.remove('active-section');
        }

        // Show the target section
        document.getElementById(sectionId).classList.add('active-section');

        // Reset phone number input and error message
        phoneNumberInput.value = '';
        phoneError.style.display = 'none';

        // Clear any previous nominal items if not going to nominal section
        if (sectionId !== 'nominalSelectionSection') {
            nominalGridContainer.innerHTML = '';
        }
    }

    // --- E-Wallet/Provider Selection ---
    function showNominalSelection(providerId, providerName, providerLogo) {
        selectedExchange.providerId = providerId;
        selectedExchange.providerName = providerName;
        selectedExchange.providerLogo = providerLogo;

        selectedFinalRedemption.providerId = providerId; // Keep track for final redemption
        selectedFinalRedemption.providerName = providerName;
        selectedFinalRedemption.providerLogo = providerLogo;

        // Update section title with provider's logo and name
        nominalSectionTitle.innerHTML = `
            <img src="${providerLogo}" alt="${providerName}" style="height: 30px; margin-right: 10px;">
            Pilih Nominal ${providerName}
        `;

        // Clear previous nominal items
        nominalGridContainer.innerHTML = '';

        // Generate nominal items dynamically based on providerId
        const nominals = nominalData[providerId];
        if (nominals) {
            nominals.forEach(item => {
                const nominalItem = document.createElement('div');
                nominalItem.classList.add('nominal-item');
                nominalItem.setAttribute('data-amount', item.amount);
                nominalItem.setAttribute('data-points', item.points);
                // On click, go to Point Exchange Confirmation
                nominalItem.setAttribute('onclick', `showPointExchangeConfirmation(${item.amount}, ${item.points})`);

                const amountDisplay = item.label || formatNumber(item.amount);

                nominalItem.innerHTML = `
                    <div class="nominal-provider">${providerName}</div>
                    <div class="nominal-currency">${providerId === 'pln' ? '' : 'Rp'}</div>
                    <div class="nominal-amount">${amountDisplay}</div>
                    <div class="nominal-points">${formatNumber(item.points)} Poin</div>
                `;
                nominalGridContainer.appendChild(nominalItem);
            });
        }

        showSection('nominalSelectionSection');
    }

    // --- Point Exchange Confirmation ---
    function showPointExchangeConfirmation(targetAmountRupiah, pointsRequired) {
        if (userPoints < pointsRequired) {
            alert(`Maaf, poin Anda (${formatNumber(userPoints)}) tidak mencukupi. Anda butuh ${formatNumber(pointsRequired)} Poin untuk penukaran ini.`);
            return;
        }

        selectedExchange.targetAmountRupiah = targetAmountRupiah;
        selectedExchange.pointsRequired = pointsRequired;

        exchangeConfirmLogo.src = selectedExchange.providerLogo;
        exchangeConfirmLogo.alt = selectedExchange.providerName;
        exchangeConfirmProviderName.textContent = selectedExchange.providerName;
        exchangePointsInfo.textContent = `${formatNumber(pointsRequired)} Poin`;
        exchangeRpInfo.textContent = `${formatNumber(targetAmountRupiah, true)}`;

        showSection('pointExchangeConfirmationSection');
    }

    // --- Handle Point Exchange ---
    confirmPointExchangeBtn.addEventListener('click', function() {
        if (userPoints < selectedExchange.pointsRequired) {
            alert('Poin tidak mencukupi untuk melakukan penukaran ini.');
            showSection('ewalletSelectionSection'); // Go back to start
            return;
        }

        // Deduct points
        userPoints -= selectedExchange.pointsRequired;
        // Add Rupiah to internal balance
        bijakSampahPayBalance += selectedExchange.targetAmountRupiah;

        // Add transaction for point exchange
        addTransaction(
            'out',
            `Tukar Poin ke Saldo BijakSampah Pay (${selectedExchange.providerName} ${formatNumber(selectedExchange.targetAmountRupiah, true)})`,
            -selectedExchange.pointsRequired,
            selectedExchange.targetAmountRupiah // Positive because it adds to internal Rupiah balance
        );

        updatePointAndBalanceDisplays();
        alert(`Berhasil menukarkan ${formatNumber(selectedExchange.pointsRequired)} Poin menjadi ${formatNumber(selectedExchange.targetAmountRupiah, true)} saldo BijakSampah Pay.`);

        // Now move to the final redemption form using the newly gained balance
        showFinalRedemptionForm(selectedExchange.targetAmountRupiah, selectedExchange.providerId, selectedExchange.providerName, selectedExchange.providerLogo);
    });

    // --- Final Redemption Form (using BijakSampah Pay balance) ---
    function showFinalRedemptionForm(amount, providerId, providerName, providerLogo) {
        selectedFinalRedemption.amountRupiah = amount; // This is the amount for the final top-up

        finalRedeemLogo.src = providerLogo;
        finalRedeemLogo.alt = providerName;
        finalRedeemProviderName.textContent = providerName;
        finalRedeemAmountText.textContent = formatNumber(amount, true);
        bijakSampahPayBalanceDisplay.textContent = formatNumber(bijakSampahPayBalance, true);

        // Adjust label for phone number input based on provider
        if (providerId === 'pln') {
            phoneNumberLabel.textContent = 'Nomor Meter / ID Pelanggan';
            phoneNumberInput.placeholder = 'Contoh: 123456789012';
            phoneError.textContent = 'Nomor Meter / ID Pelanggan tidak valid (11-12 digit).';
        } else if (providerId === 'pulsa') {
            phoneNumberLabel.textContent = 'Nomor Telepon';
            phoneNumberInput.placeholder = 'Contoh: 081234567890';
            phoneError.textContent = 'Nomor Telepon tidak valid (10-13 digit).';
        } else {
            phoneNumberLabel.textContent = `Nomor HP / Akun ${providerName}`;
            phoneNumberInput.placeholder = `Contoh: 081234567890`;
            phoneError.textContent = `Nomor HP / Akun ${providerName} tidak valid (10-13 digit).`;
        }

        showSection('finalRedemptionFormSection');
    }

    // --- Handle Final Redemption (Top-up E-Wallet/Pulsa) ---
    confirmFinalRedeemBtn.addEventListener('click', function() {
        const phoneNumber = phoneNumberInput.value.trim();
        let isValid = false;

        // Basic validation
        if (selectedFinalRedemption.providerId === 'pln') {
            isValid = /^\d{11,12}$/.test(phoneNumber);
        } else if (selectedFinalRedemption.providerId === 'pulsa') {
            isValid = /^\d{10,13}$/.test(phoneNumber);
        } else {
            isValid = /^\d{10,13}$/.test(phoneNumber);
        }

        if (!isValid) {
            phoneError.style.display = 'block';
            phoneNumberInput.focus();
            return;
        }

        if (bijakSampahPayBalance < selectedFinalRedemption.amountRupiah) {
            alert('Saldo BijakSampah Pay Anda tidak mencukupi untuk isi ulang ini. Silakan tukar lebih banyak poin atau top up saldo.');
            showSection('ewalletSelectionSection'); // Go back to start
            return;
        }

        phoneError.style.display = 'none';

        // Deduct Rupiah from internal balance
        bijakSampahPayBalance -= selectedFinalRedemption.amountRupiah;

        // Add transaction for final redemption
        addTransaction(
            'out',
            `Isi Ulang ${selectedFinalRedemption.providerName} ${formatNumber(selectedFinalRedemption.amountRupiah, true)} (${phoneNumber})`,
            0, // No point change for this step
            -selectedFinalRedemption.amountRupiah // Negative because it's an outflow of Rupiah
        );

        updatePointAndBalanceDisplays();
        alert(`Isi ulang ${selectedFinalRedemption.providerName} sebesar ${formatNumber(selectedFinalRedemption.amountRupiah, true)} ke nomor ${phoneNumber} berhasil diproses!`);

        // Go back to transaction history after successful redemption
        showSection('transactionHistorySection');
    });


    // --- Other existing button actions ---
    // Note: These elements are now handled by the new topbar structure

    // --- Print Transaction History (using html2canvas) ---
    function printTransactionHistory() {
        const historySection = document.getElementById('transactionHistorySection');
        
        // Temporarily hide elements not meant for print
        const printButton = historySection.querySelector('.print-button');
        const viewAllLink = historySection.querySelector('.view-all-transactions');
        const header = document.querySelector('.header'); // Hide main header too for cleaner print
        const sidebarElement = document.getElementById('sidebar'); // Hide sidebar

        if (printButton) printButton.style.display = 'none';
        if (viewAllLink) viewAllLink.style.display = 'none';
        if (header) header.style.display = 'none';
        if (sidebarElement) sidebarElement.style.display = 'none';

        html2canvas(historySection, {
            scale: 2, // Increase scale for better resolution
            useCORS: true // Important for images loaded from different origins
        }).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const link = document.createElement('a');
            link.href = imgData;
            link.download = 'Riwayat_Transaksi_BijakSampah.png';
            document.body.appendChild(link); // Append to body to make it clickable in some browsers
            link.click();
            document.body.removeChild(link); // Clean up

            // Restore hidden elements
            if (printButton) printButton.style.display = 'flex'; // Use flex if it was display flex
            if (viewAllLink) viewAllLink.style.display = 'block'; // Use block if it was display block
            if (header) header.style.display = 'flex';
            if (sidebarElement) sidebarElement.style.display = 'block'; // Or whatever its original display was
        });
    }

  </script>
        </div>
@endsection