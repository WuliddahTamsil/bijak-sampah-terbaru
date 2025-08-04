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
<div class="flex min-h-screen bg-gray-50" x-data="{ sidebarOpen: false }">
    {{-- Sidebar Overlay --}}
    <div class="sidebar-overlay" :class="{ 'active': sidebarOpen }" @click="sidebarOpen = false"></div>

    {{-- Sidebar --}}
    <aside 
        x-data="{ open: false, active: 'penjemputan' }"
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
                    <i class="fas fa-cog text-lg"></i>
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
                <button onclick="showDevelopmentModal('Notification')" class="relative hover:text-white/80 transition-colors">
                    <i class="far fa-bell text-white text-sm"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-medium">3</span>
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

        <div class="p-6" style="padding-top: 20px; width: 100%; max-width: 100%;">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800"><i class="fas fa-history"></i> Riwayat Sampah</h1>
                    <p class="text-sm text-gray-500">Lihat dan kelola riwayat sampah Anda</p>
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
    // Show Development Modal
    function showDevelopmentModal(featureName) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center';
        modal.innerHTML = `
            <div class="bg-white rounded-2xl p-8 max-w-md mx-4 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-tools text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">${featureName} - Fitur Dalam Pengembangan</h3>
                <p class="text-gray-600 mb-4">Fitur ini sedang dalam tahap pengembangan. Tim kami sedang bekerja keras untuk menghadirkan pengalaman terbaik untuk Anda.</p>
                <div class="bg-blue-50 rounded-lg p-4 mb-6">
                    <p class="text-sm text-blue-600">
                        <i class="fas fa-clock"></i> Estimasi rilis: 2-3 minggu ke depan
                    </p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    Mengerti
                </button>
            </div>
        `;
        document.body.appendChild(modal);
    }

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

      // Note: Sidebar toggle is now handled by Alpine.js
      // Update table when sidebar state changes
      setTimeout(() => {
        table.columns.adjust().draw();
      }, 300);

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
</div>
@endsection