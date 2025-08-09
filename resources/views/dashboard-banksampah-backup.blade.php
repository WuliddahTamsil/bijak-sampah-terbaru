<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dashboard - Bijak Sampah</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@2.0.1/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
            <script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-app-compat.js"></script>
        <script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-database-compat.js"></script>
    <script>
        // Initialize Alpine.js with Collapse plugin
        document.addEventListener('alpine:init', () => {
            console.log('Alpine.js initialized with Collapse plugin');
        });

        window.addEventListener('load', function() {
            console.log('Window loaded, Chart.js available:', typeof Chart !== 'undefined');
        });

        // Firebase Configuration
        let database = null; // Global database reference
        
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
        console.log('Firebase Config:', firebaseConfig);
        
        try {
            firebase.initializeApp(firebaseConfig);
            database = firebase.database(); // Set global database reference
            console.log('Firebase initialized successfully');
                            updateFirebaseStatus('connected');
        } catch (error) {
            console.error('Error initializing Firebase:', error);
                            updateFirebaseStatus('disconnected');
        }
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

        /* Firebase Notifications & Charts Styling */
        .notification-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 350px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            border-left: 4px solid #ddd;
            transform: translateX(400px);
            transition: transform 0.3s ease;
            z-index: 9999;
            overflow: hidden;
        }

        /* Charts Container Styling */
        .charts-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }

        .chart-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .chart-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }

        .chart-card h3 {
            color: #0a3a60;
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 20px;
            text-align: center;
        }

        .chart-wrapper {
            position: relative;
            height: 300px;
            width: 100%;
        }

        .export-btn {
            background: linear-gradient(135deg, #05445E 0%, #0A3A60 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .export-btn:hover {
            background: linear-gradient(135deg, #0A3A60 0%, #05445E 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(5, 68, 94, 0.3);
        }

        .notification-toast.show {
            transform: translateX(0);
        }

        .notification-toast.notification-high {
            border-left-color: #FF6B6B;
        }

        .notification-toast.notification-medium {
            border-left-color: #FFA726;
        }

        .notification-toast.notification-low {
            border-left-color: #66BB6A;
        }

        .toast-header {
            padding: 15px 20px 10px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .toast-header strong {
            color: #333;
            font-size: 14px;
        }

        .toast-time {
            color: #666;
            font-size: 12px;
        }

        .toast-body {
            padding: 15px 20px;
            color: #555;
            font-size: 13px;
        }

        .notification-card {
            border-left: 4px solid #ddd;
            transition: all 0.3s ease;
        }

        .notification-card.high {
            border-left-color: #FF6B6B;
            background: linear-gradient(135deg, #fff 0%, #fff5f5 100%);
        }

        .notification-card.medium {
            border-left-color: #FFA726;
            background: linear-gradient(135deg, #fff 0%, #fff8f0 100%);
        }

        .notification-card.low {
            border-left-color: #66BB6A;
            background: linear-gradient(135deg, #fff 0%, #f0fff0 100%);
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge.high {
            background: #FF6B6B;
            color: white;
        }

        .status-badge.medium {
            background: #FFA726;
            color: white;
        }

        .status-badge.low {
            background: #66BB6A;
            color: white;
        }

        .firebase-status {
            position: fixed;
            top: 10px;
            left: 10px;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            z-index: 10000;
            transition: all 0.3s ease;
        }

        .firebase-status.connected {
            background: #4CAF50;
            color: white;
        }

        .firebase-status.disconnected {
            background: #F44336;
            color: white;
        }

        .firebase-status.connecting {
            background: #FF9800;
            color: white;
        }

        /* Notifikasi Cards - Diperbagus */
        .notif-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
            margin-top: 20px;
            width: 100%;
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

        .card.deleting {
            transform: scale(0.8);
            opacity: 0;
            transition: all 0.3s ease;
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
            position: relative;
            z-index: 5;
        }

        .card-btn {
            background: none;
            border: none;
            color: #05445E;
            cursor: pointer;
            font-size: 14px;
            padding: 8px 12px;
            border-radius: 4px;
            transition: all 0.2s;
            z-index: 10;
            position: relative;
        }

        .card-btn:hover {
            background: rgba(5, 68, 94, 0.1);
        }

        .card-btn.delete:hover {
            color: #FF5A5F;
            background: rgba(239, 68, 68, 0.1);
            transform: scale(1.1);
        }

        .card-btn.delete:active {
            transform: scale(0.95);
            background: rgba(239, 68, 68, 0.2);
        }

        /* Grafik dengan Animasi */
        .chart-section {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            margin-top: 30px;
            width: 100%;
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
            height: 300px;
            padding-top: 40px;
            padding-bottom: 30px;
            gap: 10px;
            width: 100%;
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
            height: 220px; /* Fixed height for chart container */
            transition: height 0.3s ease;
            max-width: 80px;
        }

        .chart-bar-item .bar {
            width: 100%;
            max-width: 50px;
            background: linear-gradient(to top, #05445E, #189AB4);
            border-radius: 8px 8px 0 0;
            position: relative;
            height: var(--height);
            transform: scaleY(1);
            transform-origin: bottom;
            animation: grow-scale 1.5s ease-out forwards;
            animation-delay: calc(var(--order) * 0.2s);
            min-height: 20px;
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

        .bar.green {
            background: linear-gradient(to top, #22c55e, #16a34a); /* Warna hijau untuk bar yang aktif */
        }

        @keyframes grow-scale {
            from { transform: scaleY(0); }
            to { transform: scaleY(1); }
        }

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
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .notif-cards {
                grid-template-columns: 1fr;
            }
            
            .main-content {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            
            .chart-content {
                height: 250px;
            }
        }

        @media (max-width: 480px) {
            .notif-cards {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .card {
                padding: 20px;
            }
        }

        /* Toast Notification Styles */
        .toast-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-width: 300px;
            max-width: 400px;
            z-index: 9999;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            border-left: 4px solid #05445E;
        }

        .toast-notification.show {
            transform: translateX(0);
        }

        .toast-notification.success {
            border-left-color: #22c55e;
        }

        .toast-notification.error {
            border-left-color: #ef4444;
        }

        .toast-notification.info {
            border-left-color: #3b82f6;
        }

        .toast-content {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
        }

        .toast-content i {
            font-size: 18px;
        }

        .toast-notification.success .toast-content i {
            color: #22c55e;
        }

        .toast-notification.error .toast-content i {
            color: #ef4444;
        }

        .toast-notification.info .toast-content i {
            color: #3b82f6;
        }

        .toast-content span {
            color: #374151;
            font-weight: 500;
        }

        .toast-close {
            background: none;
            border: none;
            color: #9ca3af;
            font-size: 18px;
            cursor: pointer;
            padding: 0;
            margin-left: 12px;
            transition: color 0.2s;
        }

        .toast-close:hover {
            color: #374151;
        }

        /* Alpine.js Collapse Animation */
        [x-cloak] {
            display: none !important;
        }

        .collapse-transition {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50">

<!-- Firebase Status Indicator -->
<div id="firebase-status" class="firebase-status connecting">
    <i class="fas fa-circle-notch fa-spin"></i> Menghubungkan Firebase...
</div>



<!-- Firebase Notifications Container -->
<div id="firebase-notifications" class="notif-cards"></div>

<div class="flex min-h-screen bg-gray-50 w-full" x-data="{ sidebarOpen: false, activeMenu: 'dashboard' }" x-init="activeMenu = 'dashboard'">
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
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 bg-white/20 shadow-sm"
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
                    <div x-show="expanded && sidebarOpen" x-cloak x-collapse.duration.300ms class="pl-6 pt-2 space-y-1">
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
                            class="flex items-center gap-3 p-2 rounded-lg whitespace-nowrap w-full text-sm hover:bg-white/10 hover:shadow-sm transition-colors duration-200"
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
                    <div x-show="expanded && sidebarOpen" x-cloak x-collapse.duration.300ms class="pl-6 pt-2 space-y-1">
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

        <div class="p-6" style="padding-top: 20px; width: 100%; max-width: 100%;">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
                    <p class="text-sm text-gray-500">Selamat datang di dashboard bank sampah</p>
                </div>
            </div>

            <div class="notif-cards" id="notifContainer">
                <!-- Notifikasi akan dimuat di sini oleh JavaScript -->





        </div>



        <!-- Firebase Charts Section -->
        <div class="chart-section">
            <div class="chart-title">
                <i class="fas fa-chart-pie"></i> Firebase Real-time Analytics
            </div>
            <div class="chart-sub">Data real-time dari Firebase Realtime Database</div>
            
            <div class="charts-container">
                <div class="chart-card">
                    <h3>Status Tempat Sampah</h3>
                    <div class="chart-wrapper">
                        <canvas id="status-chart"></canvas>
                    </div>
                </div>
                
                <div class="chart-card">
                    <h3>Aktivitas Update Status</h3>
                    <div class="chart-wrapper">
                        <canvas id="nasabah-chart"></canvas>
                    </div>
                </div>
                
                <div class="chart-card" style="grid-column: 1 / -1;">
                    <h3>Perubahan Status Over Time</h3>
                    <div class="chart-wrapper">
                        <canvas id="timeseries-chart"></canvas>
                    </div>
                </div>
            </div>
            
            <button class="export-btn" onclick="exportFirebaseData()">
                <i class="fas fa-download"></i> Export Data
            </button>
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
                <h3 class="modal-title">Cari</h3>
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
                    <img id="profileImage" src="https://ui-avatars.com/api/?name=Nasabah&background=75E6DA&color=05445E" alt="Profile" style="width: 120px; height: 120px; border-radius: 50%; border: 4px solid #05445E; margin-bottom: 15px; cursor: pointer;">
                    <input type="file" id="profileUpload" accept="image/*" style="display: none;">
                    <button class="btn btn-outline" id="changeProfileBtn" style="margin-top: 10px;">Ganti Foto Profil</button>
                </div>
                <div class="form-group">
                    <label for="profileName">Nama Lengkap</label>
                    <input type="text" id="profileName" value="Nasabah Bijak Sampah">
                </div>
                <div class="form-group">
                    <label for="profileEmail">Email</label>
                    <input type="email" id="profileEmail" value="nasabah@bijaksampah.com">
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

    <div class="modal" id="detailModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Detail Notifikasi</h3>
                <button class="close-modal" id="closeDetailModal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="detailContent">
                    <!-- Detail notifikasi akan dimuat di sini -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="closeDetail">Tutup</button>
                <button class="btn btn-primary" id="markAsRead">Tandai Sudah Dibaca</button>
            </div>
        </div>
    </div>


    <script>
        // Data Notifikasi akan dimuat dari Firebase Realtime Database
        let notifications = [];

        // Data untuk grafik akan dimuat dari Firebase Realtime Database
        let chartData = [];

        // DOM Elements - Check if elements exist
        const sidebar = document.getElementById('sidebar');
        const toggleCollapse = document.getElementById('toggleCollapse');
        const mainContent = document.querySelector('.main-content');
        const notifBtn = document.getElementById('notifBtn');
        const searchBtn = document.getElementById('searchBtn');
        const profileBtn = document.getElementById('profileBtn');
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

        // Toggle Sidebar - Check if element exists first
        if (toggleCollapse) {
        toggleCollapse.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');
            const icon = toggleCollapse.querySelector('i');
            if (sidebar.classList.contains('collapsed')) {
                icon.classList.remove('fa-chevron-left');
                icon.classList.add('fa-chevron-right');
            } else {
                icon.classList.remove('fa-chevron-right');
                icon.classList.add('fa-chevron-left');
            }
        });
        }





                btn.addEventListener('click', function(e) {
                    console.log('Delete button clicked!'); // Debug log
                    e.stopPropagation();
                    e.preventDefault();
                    
                    const id = parseInt(this.getAttribute('data-id'));
                    const card = this.closest('.card');
                    
                    console.log('Card to delete:', card); // Debug log
                    console.log('ID to delete:', id); // Debug log
                    
                    // Konfirmasi sebelum menghapus
                    if (confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) {
                        console.log('User confirmed deletion'); // Debug log
                        
                        // Hapus dari array notifications
                    notifications = notifications.filter(n => n.id !== id);
                        
                        // Hapus card dari DOM dengan animasi
                        card.classList.add('deleting');
                        
                        setTimeout(() => {
                            card.remove();
                            console.log('Card removed from DOM'); // Debug log
                            // Show success message
                            showToast('Notifikasi berhasil dihapus!', 'success');
                        }, 300);
                    } else {
                        console.log('User cancelled deletion'); // Debug log
                    }
                });
            });
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
        }

        // Generate Chart
        function generateChart() {
            chartContent.innerHTML = '';
            
            // Tanggal sesuai gambar (16-22 Juni)
            const dates = [
                { day: '16 Jun', fullDate: '16 Juni 2025' },
                { day: '17 Jun', fullDate: '17 Juni 2025' },
                { day: '18 Jun', fullDate: '18 Juni 2025' },
                { day: '19 Jun', fullDate: '19 Juni 2025' },
                { day: '20 Jun', fullDate: '20 Juni 2025' },
                { day: '21 Jun', fullDate: '21 Juni 2025' },
                { day: '22 Jun', fullDate: '22 Juni 2025' }
            ];

            // Generate chart bars
            for (let i = 0; i < 7; i++) {
                const data = chartData[i];
                const dateInfo = dates[i];
                
                const chartBarItem = document.createElement('div');
                chartBarItem.className = 'chart-bar-item';
                chartBarItem.style.setProperty('--height', `${data.height}%`);
                
                const barClass = data.isGreen ? 'bar green' : 'bar';
                chartBarItem.innerHTML = `
                    <div class="${barClass}" style="--order: ${i + 1};">
                        <span class="bar-label">${data.value}</span>
                    </div>
                    <div class="day">${dateInfo.day}</div>
                `;
                chartContent.appendChild(chartBarItem);
            }
        }

        // Modal Toggles - Check if elements exist
        if (notifBtn && notifModal) {
        notifBtn.addEventListener('click', function() {
            loadNotifModal();
            notifModal.style.display = 'flex';
        });
        }

        if (searchBtn && searchModal) {
        searchBtn.addEventListener('click', function() {
            searchModal.style.display = 'flex';
        });
        }

        if (profileBtn && profileModal) {
        profileBtn.addEventListener('click', function() {
            profileModal.style.display = 'flex';
        });
        }

        // Close Modals - Check if elements exist
        const closeNotifModal = document.getElementById('closeNotifModal');
        const closeSearchModal = document.getElementById('closeSearchModal');
        const closeProfileModal = document.getElementById('closeProfileModal');
        const cancelNotif = document.getElementById('cancelNotif');
        const cancelProfile = document.getElementById('cancelProfile');

        if (closeNotifModal && notifModal) {
            closeNotifModal.addEventListener('click', function() {
            notifModal.style.display = 'none';
        });
        }

        if (closeSearchModal && searchModal) {
            closeSearchModal.addEventListener('click', function() {
            searchModal.style.display = 'none';
        });
        }

        if (closeProfileModal && profileModal) {
            closeProfileModal.addEventListener('click', function() {
            profileModal.style.display = 'none';
        });
        }

        if (cancelNotif && notifModal) {
            cancelNotif.addEventListener('click', function() {
            notifModal.style.display = 'none';
        });
        }

        if (cancelProfile && profileModal) {
            cancelProfile.addEventListener('click', function() {
            profileModal.style.display = 'none';
        });
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (notifModal && event.target === notifModal) {
                notifModal.style.display = 'none';
            }
            if (searchModal && event.target === searchModal) {
                searchModal.style.display = 'none';
            }
            if (profileModal && event.target === profileModal) {
                profileModal.style.display = 'none';
            }
        });

        // Add New Notification - Check if elements exist
        if (saveNotif && notifInput) {
        saveNotif.addEventListener('click', function() {
            if (notifInput.value.trim()) {
                const newId = notifications.length > 0 ? Math.max(...notifications.map(n => n.id)) + 1 : 1;
                const now = new Date();
                const options = { day: 'numeric', month: 'long', year: 'numeric' };
                const date = now.toLocaleDateString('id-ID', options);
                const time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                
                notifications.unshift({
                    id: newId,
                    title: "Notifikasi Baru",
                    icon: "fas fa-info-circle",
                    message: notifInput.value.trim(),
                    date: date,
                    time: time
                });
                
                notifInput.value = '';
                loadNotifications();
                loadNotifModal();
            }
        });
        }

        // Change Profile Image - Check if elements exist
        if (changeProfileBtn && profileUpload) {
        changeProfileBtn.addEventListener('click', function() {
            profileUpload.click();
        });
        }

        if (profileUpload && profileImage) {
        profileUpload.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                const reader = new FileReader();
                reader.onload = function(event) {
                    profileImage.src = event.target.result;
                        if (profileBtn) {
                    profileBtn.src = event.target.result;
                        }
                };
                reader.readAsDataURL(file);
            }
        });
        }

        // Save Profile Changes - Check if elements exist
        if (saveProfile && profileModal) {
        saveProfile.addEventListener('click', function() {
            // In a real app, you would save to database here
            alert('Perubahan profil berhasil disimpan!');
            profileModal.style.display = 'none';
        });
        }

                // Show Notification Detail
        function showNotificationDetail(id) {
            const notif = notifications.find(n => n.id === id);
            if (!notif) return;

            const detailContent = document.getElementById('detailContent');
            detailContent.innerHTML = `
                <div class="mb-4">
                    <div class="flex justify-between items-start mb-3">
                        <h4 class="text-lg font-semibold"><i class="${notif.icon}"></i> ${notif.title}</h4>
                        <span class="px-3 py-1 text-sm text-white rounded-full ${notif.priorityColor}">${notif.priority}</span>
                    </div>
                    <p class="text-gray-700 mb-4">${notif.message}</p>
                    <div class="flex items-center gap-4 text-sm text-gray-500">
                        <span class="flex items-center gap-1"><i class="fas fa-calendar"></i> ${notif.date}</span>
                        <span class="flex items-center gap-1"><i class="fas fa-clock"></i> ${notif.time}</span>
                    </div>
                </div>
            `;

            document.getElementById('detailModal').style.display = 'flex';
        }

        // Detail Modal Event Listeners - Check if elements exist
        const closeDetailModal = document.getElementById('closeDetailModal');
        const closeDetail = document.getElementById('closeDetail');
        const markAsRead = document.getElementById('markAsRead');
        const detailModal = document.getElementById('detailModal');

        if (closeDetailModal && detailModal) {
            closeDetailModal.addEventListener('click', function() {
                detailModal.style.display = 'none';
            });
        }

        if (closeDetail && detailModal) {
            closeDetail.addEventListener('click', function() {
                detailModal.style.display = 'none';
            });
        }

        if (markAsRead && detailModal) {
            markAsRead.addEventListener('click', function() {
                alert('Notifikasi telah ditandai sebagai sudah dibaca!');
                detailModal.style.display = 'none';
            });
        }

        // Close detail modal when clicking outside
        window.addEventListener('click', function(event) {
            if (detailModal && event.target === detailModal) {
                detailModal.style.display = 'none';
            }
        });

        // Show Notification Detail
        function showNotificationDetail(id) {
            const notif = notifications.find(n => n.id === id);
            if (!notif) return;

            const detailContent = document.getElementById('detailContent');
            detailContent.innerHTML = `
                <div class="mb-4">
                    <div class="flex justify-between items-start mb-3">
                        <h4 class="text-lg font-semibold"><i class="${notif.icon}"></i> ${notif.title}</h4>
                        <span class="px-3 py-1 text-sm text-white rounded-full ${notif.priorityColor}">${notif.priority}</span>
                    </div>
                    <p class="text-gray-700 mb-4">${notif.message}</p>
                    <div class="flex items-center gap-4 text-sm text-gray-500">
                        <span class="flex items-center gap-1"><i class="fas fa-calendar"></i> ${notif.date}</span>
                        <span class="flex items-center gap-1"><i class="fas fa-clock"></i> ${notif.time}</span>
                    </div>
                </div>
            `;

            document.getElementById('detailModal').style.display = 'flex';
        }

        // Detail Modal Event Listeners
        document.getElementById('closeDetailModal').addEventListener('click', function() {
            document.getElementById('detailModal').style.display = 'none';
        });

        document.getElementById('closeDetail').addEventListener('click', function() {
            document.getElementById('detailModal').style.display = 'none';
        });

        document.getElementById('markAsRead').addEventListener('click', function() {
            alert('Notifikasi telah ditandai sebagai sudah dibaca!');
            document.getElementById('detailModal').style.display = 'none';
        });

        // Close detail modal when clicking outside
        window.addEventListener('click', function(event) {
            const detailModal = document.getElementById('detailModal');
            if (event.target === detailModal) {
                detailModal.style.display = 'none';
            }
        });

        // Period Dropdown Functionality - Check if element exists
        const periodDropdown = document.getElementById('periodDropdown');
        let currentPeriod = 'Bulan';

        if (periodDropdown) {
            periodDropdown.addEventListener('click', function() {
                const periods = ['Minggu', 'Bulan', 'Tahun'];
                const currentIndex = periods.indexOf(currentPeriod);
                const nextIndex = (currentIndex + 1) % periods.length;
                currentPeriod = periods[nextIndex];
                
                const icon = this.querySelector('i');
                this.innerHTML = `${currentPeriod} <i class="fas fa-chevron-down ml-1"></i>`;
                
                // Update chart based on period
                updateChartByPeriod(currentPeriod);
            });
        }

        function updateChartByPeriod(period) {
            // Simulasi data berbeda untuk setiap periode
            const periodData = {
                'Minggu': [
                    { height: 25, value: '25 kg', isGreen: false },
                    { height: 80, value: '80 kg', isGreen: false },
                    { height: 97, value: '97 kg', isGreen: true },
                    { height: 70, value: '70 kg', isGreen: false },
                    { height: 45, value: '45 kg', isGreen: false },
                    { height: 60, value: '60 kg', isGreen: false },
                    { height: 50, value: '50 kg', isGreen: false }
                ],
                'Bulan': [
                    { height: 30, value: '30 kg', isGreen: false },
                    { height: 75, value: '75 kg', isGreen: false },
                    { height: 85, value: '85 kg', isGreen: true },
                    { height: 60, value: '60 kg', isGreen: false },
                    { height: 40, value: '40 kg', isGreen: false },
                    { height: 55, value: '55 kg', isGreen: false },
                    { height: 45, value: '45 kg', isGreen: false }
                ],
                'Tahun': [
                    { height: 20, value: '20 kg', isGreen: false },
                    { height: 65, value: '65 kg', isGreen: false },
                    { height: 90, value: '90 kg', isGreen: true },
                    { height: 50, value: '50 kg', isGreen: false },
                    { height: 35, value: '35 kg', isGreen: false },
                    { height: 70, value: '70 kg', isGreen: false },
                    { height: 55, value: '55 kg', isGreen: false }
                ]
            };
            
            // Update chart content directly
            const chartContent = document.getElementById('chart-content');
            if (chartContent && periodData[period]) {
                chartContent.innerHTML = '';
                
                const dates = [
                    { day: '16 Jun', fullDate: '16 Juni 2025' },
                    { day: '17 Jun', fullDate: '17 Juni 2025' },
                    { day: '18 Jun', fullDate: '18 Juni 2025' },
                    { day: '19 Jun', fullDate: '19 Juni 2025' },
                    { day: '20 Jun', fullDate: '20 Juni 2025' },
                    { day: '21 Jun', fullDate: '21 Juni 2025' },
                    { day: '22 Jun', fullDate: '22 Juni 2025' }
                ];
                
                periodData[period].forEach((data, i) => {
                    const dateInfo = dates[i];
                    const chartBarItem = document.createElement('div');
                    chartBarItem.className = 'chart-bar-item';
                    chartBarItem.style.setProperty('--height', `${data.height}%`);
                    
                    const barClass = data.isGreen ? 'bar green' : 'bar';
                    chartBarItem.innerHTML = `
                        <div class="${barClass}" style="--order: ${i + 1};">
                            <span class="bar-label">${data.value}</span>
                        </div>
                        <div class="day">${dateInfo.day}</div>
                    `;
                    chartContent.appendChild(chartBarItem);
                });
                
                // Show success message
                showToast(`Data chart berhasil diubah ke periode: ${period}`, 'success');
            }
        }

        // Toast notification function
        function showToast(message, type = 'info') {
            // Remove existing toast
            const existingToast = document.querySelector('.toast-notification');
            if (existingToast) {
                existingToast.remove();
            }
            
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `toast-notification ${type}`;
            toast.innerHTML = `
                <div class="toast-content">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
                    <span>${message}</span>
                </div>
                <button class="toast-close">&times;</button>
            `;
            
            // Add to body
            document.body.appendChild(toast);
            
            // Show toast
            setTimeout(() => {
                toast.classList.add('show');
            }, 100);
            
            // Auto hide after 3 seconds
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);
            
            // Close button
            toast.querySelector('.toast-close').addEventListener('click', () => {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            });
        }

        // Initialize
        loadNotifications();
        generateChart();

        // Test Firebase connection manually
        setTimeout(() => {
            if (database) {
                console.log('Testing Firebase connection...');
                const testRef = database.ref('AlatData');
                testRef.once('value')
                    .then((snapshot) => {
                        const data = snapshot.val();
                        console.log('Manual test - AlatData:', data);
                        if (data) {
                            console.log('Data found! Processing...');
                            if (firebaseNotifications) {
                                firebaseNotifications.processAlatData(data);
                            }
                            if (firebaseCharts) {
                                firebaseCharts.processChartData(data);
                                firebaseCharts.updateCharts();
                            }
                        } else {
                            console.log('No data found in AlatData');
                        }
                    })
                    .catch((error) => {
                        console.error('Manual test error:', error);
                    });
            } else {
                console.error('Database not available for manual test');
            }
        }, 3000);

        // Ensure delete buttons work after page load
        setTimeout(() => {
            console.log('Re-attaching delete event listeners...'); // Debug log
            document.querySelectorAll('.card-btn.delete').forEach(btn => {
                // Remove existing listeners to prevent duplication
                btn.replaceWith(btn.cloneNode(true));
            });
            
            // Re-attach event listeners
            document.querySelectorAll('.card-btn.delete').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    console.log('Delete button clicked (re-attached)!'); // Debug log
                    e.stopPropagation();
                    e.preventDefault();
                    
                    const id = parseInt(this.getAttribute('data-id'));
                    const card = this.closest('.card');
                    
                    console.log('Card to delete (re-attached):', card); // Debug log
                    console.log('ID to delete (re-attached):', id); // Debug log
                    
                    // Konfirmasi sebelum menghapus
                    if (confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) {
                        console.log('User confirmed deletion (re-attached)'); // Debug log
                        
                        // Hapus dari array notifications
                        notifications = notifications.filter(n => n.id !== id);
                        
                        // Hapus card dari DOM dengan animasi
                        card.classList.add('deleting');
                        
                        setTimeout(() => {
                            card.remove();
                            console.log('Card removed from DOM (re-attached)'); // Debug log
                            // Show success message
                            showToast('Notifikasi berhasil dihapus!', 'success');
                        }, 300);
                    } else {
                        console.log('User cancelled deletion (re-attached)'); // Debug log
                    }
                });
            });
        }, 1000);

        // Add event listeners for existing cards
        document.addEventListener('DOMContentLoaded', function() {
            // Add click event listeners for card details (but not for delete button)
            document.querySelectorAll('.card').forEach(card => {
                card.addEventListener('click', function(e) {
                    // Jangan trigger jika yang diklik adalah tombol delete
                    if (e.target.closest('.card-btn.delete')) {
                        return;
                    }
                    
                    const deleteBtn = this.querySelector('.card-btn.delete');
                    if (deleteBtn) {
                        const id = parseInt(deleteBtn.getAttribute('data-id'));
                        showNotificationDetail(id);
                    }
                });
            });

            // Add delete event listeners for existing cards
            document.querySelectorAll('.card-btn.delete').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    console.log('Delete button clicked (DOMContentLoaded)!'); // Debug log
                    e.stopPropagation();
                    e.preventDefault();
                    
                    const id = parseInt(this.getAttribute('data-id'));
                    const card = this.closest('.card');
                    
                    console.log('Card to delete (DOMContentLoaded):', card); // Debug log
                    console.log('ID to delete (DOMContentLoaded):', id); // Debug log
                    
                    // Konfirmasi sebelum menghapus
                    if (confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) {
                        console.log('User confirmed deletion (DOMContentLoaded)'); // Debug log
                        
                        // Hapus dari array notifications
                        notifications = notifications.filter(n => n.id !== id);
                        
                        // Hapus card dari DOM dengan animasi
                        card.classList.add('deleting');
                        
                        setTimeout(() => {
                            card.remove();
                            console.log('Card removed from DOM (DOMContentLoaded)'); // Debug log
                            // Show success message
                            showToast('Notifikasi berhasil dihapus!', 'success');
                        }, 300);
                    } else {
                        console.log('User cancelled deletion (DOMContentLoaded)'); // Debug log
                    }
                });
            });

            // Add period dropdown functionality
            const periodDropdown = document.getElementById('periodDropdown');
            if (periodDropdown) {
                periodDropdown.addEventListener('click', function() {
                    const periods = ['Minggu', 'Bulan', 'Tahun'];
                    const currentText = this.textContent.trim().split(' ')[0];
                    const currentIndex = periods.indexOf(currentText);
                    const nextIndex = (currentIndex + 1) % periods.length;
                    const newPeriod = periods[nextIndex];
                    
                    this.innerHTML = `${newPeriod} <i class="fas fa-chevron-down ml-1"></i>`;
                    
                    // Update chart based on period
                    updateChartByPeriod(newPeriod);
                });
            }

            // Initialize Firebase Notifications and Charts
            initializeFirebase();
        });

        // Firebase Notifications and Charts System
        let firebaseNotifications = null;
        let firebaseCharts = null;

        function initializeFirebase() {
            try {
                // Initialize Firebase Notifications
                firebaseNotifications = new FirebaseNotifications();
                
                // Initialize Firebase Charts
                firebaseCharts = new FirebaseCharts();
                
                // Update Firebase status
                updateFirebaseStatus('connected');
                
                console.log('Firebase initialized successfully');
            } catch (error) {
                console.error('Error initializing Firebase:', error);
                updateFirebaseStatus('disconnected');
            }
        }

        // Firebase Notifications Class
        class FirebaseNotifications {
            constructor() {
                this.notifications = [];
                this.listeners = new Map();
                this.init();
            }

            init() {
                this.listenToUsersData();
                this.setupNotificationSound();
            }

            listenToUsersData() {
                if (!database) {
                    console.error('Database not initialized');
                    return;
                }
                
                const alatDataRef = database.ref('AlatData');
                console.log('Listening to AlatData path:', alatDataRef.toString());
                
                alatDataRef.on('value', (snapshot) => {
                    const data = snapshot.val();
                    console.log('Firebase AlatData received:', data);
                    console.log('Data structure:', JSON.stringify(data, null, 2));
                    
                    if (data) {
                        this.processAlatData(data);
                    } else {
                        console.log('No data found in AlatData');
                    }
                }, (error) => {
                    console.error('Error listening to Firebase:', error);
                    updateFirebaseStatus('disconnected');
                });
            }



            processAlatData(data) {
                const newNotifications = [];
                let dataCount = 0;
                
                Object.keys(data).forEach(alatId => {
                    const alatData = data[alatId];
                    if (alatData.readings && alatData.readings.status && alatData.readings.timestamp) {
                        dataCount++;
                        const notification = {
                            id: `${alatId}_${Date.now()}`,
                            nasabah: alatId,
                            status: alatData.readings.status,
                            timestamp: alatData.readings.timestamp,
                            isNew: true,
                            priority: this.getPriority(alatData.readings.status)
                        };
                        
                        newNotifications.push(notification);
                        
                        if (this.isNewNotification(notification)) {
                            this.showNotification(notification);
                            this.playNotificationSound();
                        }
                    }
                });
                
                this.notifications = newNotifications;
                this.updateNotificationDisplay();
                

            }

            getPriority(status) {
                if (status.includes('PENUH')) return 'high';
                if (status.includes('HAMPIR PENUH')) return 'medium';
                return 'low';
            }

            isNewNotification(notification) {
                const existing = this.notifications.find(n => 
                    n.nasabah === notification.nasabah && 
                    n.status === notification.status
                );
                return !existing;
            }

            showNotification(notification) {
                const toast = document.createElement('div');
                toast.className = `notification-toast notification-${notification.priority}`;
                toast.innerHTML = `
                    <div class="toast-header">
                        <strong>${notification.nasabah}</strong>
                        <span class="toast-time">${notification.timestamp}</span>
                    </div>
                    <div class="toast-body">
                        Status: ${notification.status}
                    </div>
                `;
                
                document.body.appendChild(toast);
                
                setTimeout(() => toast.classList.add('show'), 100);
                
                setTimeout(() => {
                    toast.classList.remove('show');
                    setTimeout(() => toast.remove(), 300);
                }, 5000);
            }

            updateNotificationDisplay() {
                const container = document.getElementById('firebase-notifications');
                if (!container) return;
                
                container.innerHTML = '';
                
                this.notifications.forEach(notification => {
                    const card = this.createNotificationCard(notification);
                    container.appendChild(card);
                });
            }

            createNotificationCard(notification) {
                const card = document.createElement('div');
                card.className = `card notification-card ${notification.priority}`;
                card.innerHTML = `
                    <div class="card-header">
                        <h4>${notification.nasabah}</h4>
                        <span class="status-badge ${notification.priority}">${notification.status}</span>
                    </div>
                    <div class="card-body">
                        <p class="timestamp">${notification.timestamp}</p>
                        <div class="actions">
                            <button class="btn btn-primary btn-sm" onclick="handleNotification('${notification.id}')">
                                Tindak Lanjut
                            </button>
                            <button class="btn btn-secondary btn-sm" onclick="dismissNotification('${notification.id}')">
                                Tutup
                            </button>
                        </div>
                    </div>
                `;
                
                return card;
            }

            setupNotificationSound() {
                this.notificationSound = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTYIG2m98OScTgwOUarm7blmGgU7k9n1unEiBC13yO/eizEIHWq+8+OWT');
            }

            playNotificationSound() {
                if (this.notificationSound) {
                    this.notificationSound.play().catch(e => console.log('Audio play failed:', e));
                }
            }

            dismissNotification(id) {
                this.notifications = this.notifications.filter(n => n.id !== id);
                this.updateNotificationDisplay();
            }
        }

        // Firebase Charts Class
        class FirebaseCharts {
            constructor() {
                this.chartData = {
                    statusHistory: [],
                    nasabahStats: {},
                    timeSeriesData: []
                };
                this.charts = {};
                this.init();
            }

            init() {
                this.listenToData();
                this.setupCharts();
            }

            listenToData() {
                if (!database) {
                    console.error('Database not initialized for charts');
                    return;
                }
                
                const alatDataRef = database.ref('AlatData');
                console.log('Charts listening to AlatData path:', alatDataRef.toString());
                
                alatDataRef.on('value', (snapshot) => {
                    const data = snapshot.val();
                    console.log('Charts AlatData received:', data);
                    console.log('Charts data structure:', JSON.stringify(data, null, 2));
                    
                    if (data) {
                        this.processChartData(data);
                        this.updateCharts();
                    } else {
                        console.log('No data found in AlatData for charts');
                    }
                }, (error) => {
                    console.error('Error listening to Firebase for charts:', error);
                });
            }

            processChartData(data) {
                const statusHistory = [];
                const nasabahStats = {};
                const timeSeriesData = [];
                let dataCount = 0;

                Object.keys(data).forEach(alatId => {
                    const alatData = data[alatId];
                    if (alatData.readings && alatData.readings.status && alatData.readings.timestamp) {
                        dataCount++;
                        statusHistory.push({
                            nasabah: alatId,
                            status: alatData.readings.status,
                            timestamp: alatData.readings.timestamp,
                            date: this.parseTimestamp(alatData.readings.timestamp)
                        });

                        if (!nasabahStats[alatId]) {
                            nasabahStats[alatId] = {
                                totalUpdates: 0,
                                statusCounts: {},
                                lastUpdate: alatData.readings.timestamp
                            };
                        }
                        nasabahStats[alatId].totalUpdates++;
                        nasabahStats[alatId].statusCounts[alatData.readings.status] = 
                            (nasabahStats[alatId].statusCounts[alatData.readings.status] || 0) + 1;
                        nasabahStats[alatId].lastUpdate = alatData.readings.timestamp;

                        timeSeriesData.push({
                            date: this.parseTimestamp(alatData.readings.timestamp),
                            nasabah: alatId,
                            status: alatData.readings.status
                        });
                    }
                });

                this.chartData = {
                    statusHistory: statusHistory.sort((a, b) => new Date(b.date) - new Date(a.date)),
                    nasabahStats,
                    timeSeriesData: timeSeriesData.sort((a, b) => new Date(a.date) - new Date(b.date))
                };
                

            }

            parseTimestamp(timestamp) {
                // Format: "09-08-2025 15:54"
                const [datePart, timePart] = timestamp.split(' ');
                const [day, month, year] = datePart.split('-');
                const [hour, minute] = timePart.split(':');
                
                return new Date(year, month - 1, day, hour, minute);
            }

            setupCharts() {
                this.setupStatusChart();
                this.setupNasabahChart();
                this.setupTimeSeriesChart();
            }

            setupStatusChart() {
                const ctx = document.getElementById('status-chart');
                if (!ctx) return;

                this.charts.statusChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: [],
                        datasets: [{
                            data: [],
                            backgroundColor: [
                                '#FF6B6B', '#FFA726', '#66BB6A', '#42A5F5'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom' },
                            title: {
                                display: true,
                                text: 'Status Tempat Sampah'
                            }
                        }
                    }
                });
            }

            setupNasabahChart() {
                const ctx = document.getElementById('nasabah-chart');
                if (!ctx) return;

                this.charts.nasabahChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [],
                        datasets: [{
                            label: 'Total Update Status',
                            data: [],
                            backgroundColor: '#4CAF50',
                            borderColor: '#388E3C',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Aktivitas Update Status per Nasabah'
                            }
                        }
                    }
                });
            }

            setupTimeSeriesChart() {
                const ctx = document.getElementById('timeseries-chart');
                if (!ctx) return;

                this.charts.timeSeriesChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [],
                        datasets: []
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: 'hour',
                                    displayFormats: { hour: 'HH:mm' }
                                }
                            },
                            y: { beginAtZero: true }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Perubahan Status Over Time'
                            }
                        }
                    }
                });
            }

            updateCharts() {
                this.updateStatusChart();
                this.updateNasabahChart();
                this.updateTimeSeriesChart();
            }

            updateStatusChart() {
                if (!this.charts.statusChart) return;

                const statusCounts = {};
                this.chartData.statusHistory.forEach(item => {
                    statusCounts[item.status] = (statusCounts[item.status] || 0) + 1;
                });

                this.charts.statusChart.data.labels = Object.keys(statusCounts);
                this.charts.statusChart.data.datasets[0].data = Object.values(statusCounts);
                this.charts.statusChart.update();
            }

            updateNasabahChart() {
                if (!this.charts.nasabahChart) return;

                const nasabahNames = Object.keys(this.chartData.nasabahStats);
                const updateCounts = nasabahNames.map(name => this.chartData.nasabahStats[name].totalUpdates);

                this.charts.nasabahChart.data.labels = nasabahNames;
                this.charts.nasabahChart.data.labels = nasabahNames;
                this.charts.nasabahChart.data.datasets[0].data = updateCounts;
                this.charts.nasabahChart.update();
            }

            updateTimeSeriesChart() {
                if (!this.charts.timeSeriesChart) return;

                const nasabahGroups = {};
                this.chartData.timeSeriesData.forEach(item => {
                    if (!nasabahGroups[item.nasabah]) {
                        nasabahGroups[item.nasabah] = [];
                    }
                    nasabahGroups[item.nasabah].push({
                        x: item.date,
                        y: this.getStatusValue(item.status)
                    });
                });

                const datasets = Object.keys(nasabahGroups).map((nasabah, index) => ({
                    label: nasabah,
                    data: nasabahGroups[nasabah],
                    borderColor: this.getColor(index),
                    backgroundColor: this.getColor(index, 0.1),
                    tension: 0.1
                }));

                this.charts.timeSeriesChart.data.datasets = datasets;
                this.charts.timeSeriesChart.update();
            }

            getStatusValue(status) {
                if (status.includes('PENUH')) return 3;
                if (status.includes('HAMPIR PENUH')) return 2;
                return 1;
            }

            getColor(index, alpha = 1) {
                const colors = [
                    `rgba(255, 107, 107, ${alpha})`,
                    `rgba(255, 167, 38, ${alpha})`,
                    `rgba(102, 187, 106, ${alpha})`,
                    `rgba(66, 165, 245, ${alpha})`,
                    `rgba(156, 39, 176, ${alpha})`,
                    `rgba(255, 193, 7, ${alpha})`
                ];
                return colors[index % colors.length];
            }
        }

        // Global functions
        function handleNotification(id) {
            console.log('Handle notification:', id);
            // Implementasi tindak lanjut notifikasi
        }

        function dismissNotification(id) {
            if (firebaseNotifications) {
                firebaseNotifications.dismissNotification(id);
            }
        }

        function exportFirebaseData() {
            if (firebaseCharts) {
                const dataStr = JSON.stringify(firebaseCharts.chartData, null, 2);
                const dataBlob = new Blob([dataStr], {type: 'application/json'});
                const url = URL.createObjectURL(dataBlob);
                
                const link = document.createElement('a');
                link.href = url;
                link.download = 'bank-sampah-data.json';
                link.click();
                
                URL.revokeObjectURL(url);
            }
        }

        function updateFirebaseStatus(status) {
            const statusElement = document.getElementById('firebase-status');
            if (statusElement) {
                statusElement.className = `firebase-status ${status}`;
                
                switch(status) {
                    case 'connected':
                        statusElement.innerHTML = '<i class="fas fa-check-circle"></i> Firebase Connected';
                        break;
                    case 'disconnected':
                        statusElement.innerHTML = '<i class="fas fa-times-circle"></i> Firebase Disconnected';
                        break;
                    case 'connecting':
                        statusElement.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Menghubungkan Firebase...';
                        break;
                }
            }
        }


    </script>
</body>
</html>