<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Komunitas - Bijak Sampah</title>
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
  </style>
</head>
<body class="bg-gray-50">

<div class="flex min-h-screen bg-gray-50" x-data="komunitasApp()" x-init="activeMenu = 'komunitas'">
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
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center; padding-left: 0; padding-right: 0;'"
                    @click="activeMenu = 'dashboard'"
                >
                    <i class="fas fa-home text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Dashboard</span>
                </a>

                <a 
                    href="{{ route('nasabahkomunitas') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 bg-white/20 shadow-sm"
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
                    href="#" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="showDevelopmentModal('Settings')"
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

        <div class="p-8" style="padding-top: 20px; width: 100%; max-width: 100%;">
            {{-- Header Section --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Komunitas</h1>
                    <p class="text-gray-600 text-lg">Bergabung dengan komunitas peduli lingkungan</p>
                </div>
                <div class="flex items-center gap-4">
                    <button @click="showCreatePost = true" class="bg-green-600 text-black px-6 py-3 rounded-xl hover:bg-green-700 transition-all duration-300 font-bold shadow-lg border-2 border-green-700">
                        <i class="fas fa-plus mr-2"></i>Buat Post
                    </button>
                    <button @click="showCreateEvent = true" class="bg-blue-600 text-black px-6 py-3 rounded-xl hover:bg-blue-700 transition-all duration-300 font-bold shadow-lg border-2 border-blue-700">
                        <i class="fas fa-calendar-plus mr-2"></i>Buat Event
                    </button>
                </div>
            </div>

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Members -->
                <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 border-green-200 hover:border-green-300 transition-all duration-300 hover:transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-700 text-sm font-bold uppercase tracking-wide mb-2">Total Anggota</p>
                            <p class="text-3xl font-black text-gray-900 mb-2">1,247</p>
                            <p class="text-green-700 text-sm font-bold flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i>
                                +23 minggu ini
                            </p>
                        </div>
                        <div class="bg-green-600 rounded-full p-4 shadow-xl">
                            <i class="fas fa-users text-2xl text-white"></i>
                        </div>
                    </div>
                </div>

                <!-- Active Events -->
                <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 border-blue-200 hover:border-blue-300 transition-all duration-300 hover:transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-700 text-sm font-bold uppercase tracking-wide mb-2">Event Aktif</p>
                            <p class="text-3xl font-black text-gray-900 mb-2">8</p>
                            <p class="text-blue-700 text-sm font-bold flex items-center">
                                <i class="fas fa-calendar-check mr-1"></i>
                                3 event minggu ini
                            </p>
                        </div>
                        <div class="bg-blue-600 rounded-full p-4 shadow-xl">
                            <i class="fas fa-calendar-alt text-2xl text-white"></i>
                        </div>
                    </div>
                </div>

                <!-- Posts Today -->
                <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 border-purple-200 hover:border-purple-300 transition-all duration-300 hover:transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-700 text-sm font-bold uppercase tracking-wide mb-2">Post Hari Ini</p>
                            <p class="text-3xl font-black text-gray-900 mb-2">42</p>
                            <p class="text-purple-700 text-sm font-bold flex items-center">
                                <i class="fas fa-comments mr-1"></i>
                                +12 dari kemarin
                            </p>
                        </div>
                        <div class="bg-purple-600 rounded-full p-4 shadow-xl">
                            <i class="fas fa-comment-dots text-2xl text-white"></i>
                        </div>
                    </div>
                </div>

                <!-- Community Score -->
                <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 border-orange-200 hover:border-orange-300 transition-all duration-300 hover:transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-700 text-sm font-bold uppercase tracking-wide mb-2">Skor Komunitas</p>
                            <p class="text-3xl font-black text-gray-900 mb-2">9.2</p>
                            <p class="text-orange-700 text-sm font-bold flex items-center">
                                <i class="fas fa-star mr-1"></i>
                                Sangat Aktif
                            </p>
                        </div>
                        <div class="bg-orange-600 rounded-full p-4 shadow-xl">
                            <i class="fas fa-trophy text-2xl text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Content Tabs --}}
            <div class="flex gap-4 mb-8">
                <button 
                    @click="activeTab = 'timeline'" 
                    :class="activeTab === 'timeline' ? 'bg-green-600 text-white shadow-2xl scale-105 border-2 border-green-700' : 'bg-gray-100 text-gray-900 hover:bg-gray-200 border-2 border-gray-400'"
                    class="px-8 py-3 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg">
                    <i class="fas fa-stream mr-2"></i>Timeline
                </button>
                <button 
                    @click="activeTab = 'events'" 
                    :class="activeTab === 'events' ? 'bg-blue-600 text-white shadow-2xl scale-105 border-2 border-blue-700' : 'bg-gray-100 text-gray-900 hover:bg-gray-200 border-2 border-gray-400'"
                    class="px-8 py-3 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg">
                    <i class="fas fa-calendar mr-2"></i>Events
                </button>
                <button 
                    @click="activeTab = 'members'" 
                    :class="activeTab === 'members' ? 'bg-purple-600 text-white shadow-2xl scale-105 border-2 border-purple-700' : 'bg-gray-100 text-gray-900 hover:bg-gray-200 border-2 border-gray-400'"
                    class="px-8 py-3 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg">
                    <i class="fas fa-users mr-2"></i>Members
                </button>
                <button 
                    @click="activeTab = 'groups'" 
                    :class="activeTab === 'groups' ? 'bg-orange-600 text-white shadow-2xl scale-105 border-2 border-orange-700' : 'bg-gray-100 text-gray-900 hover:bg-gray-200 border-2 border-gray-400'"
                    class="px-8 py-3 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg">
                    <i class="fas fa-layer-group mr-2"></i>Groups
                </button>
            </div>

            {{-- Timeline Tab --}}
            <div x-show="activeTab === 'timeline'" class="space-y-6">
                {{-- Create Post Card --}}
                <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 border-gray-200">
                    <div class="flex items-center gap-4 mb-4">
                        <img src="{{ asset('asset/img/user_profile.jpg') }}" alt="Profile" class="w-12 h-12 rounded-full">
                        <div class="flex-1">
                            <input type="text" placeholder="Apa yang ingin Anda bagikan?" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <button class="flex items-center gap-2 text-gray-600 hover:text-green-600 transition-colors">
                                <i class="fas fa-image"></i>
                                <span>Foto</span>
                            </button>
                            <button class="flex items-center gap-2 text-gray-600 hover:text-blue-600 transition-colors">
                                <i class="fas fa-video"></i>
                                <span>Video</span>
                            </button>
                            <button class="flex items-center gap-2 text-gray-600 hover:text-purple-600 transition-colors">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Lokasi</span>
                            </button>
                        </div>
                        <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors font-bold border-2 border-green-700">
                            Post
                        </button>
                    </div>
                </div>

                {{-- Posts --}}
                <div class="space-y-6">
                    @for ($i = 0; $i < 3; $i++)
                    <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 border-gray-200 hover:shadow-2xl transition-all duration-300">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="relative">
                                <img src="{{ asset('asset/img/user_profile.jpg') }}" alt="Profile" class="w-12 h-12 rounded-full">
                                <div class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="font-bold text-gray-900">{{ $i % 2 == 0 ? 'Sarah Johnson' : 'Ahmad Rahman' }}</h3>
                                    <span class="text-green-600 text-sm font-bold">• Online</span>
                                </div>
                                <p class="text-gray-600 text-sm">{{ $i % 2 == 0 ? '2 jam yang lalu' : '5 jam yang lalu' }}</p>
                            </div>
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                        </div>
                        <p class="text-gray-800 mb-4 leading-relaxed">
                            {{ $i % 2 == 0 ? 'Baru saja selesai mengumpulkan sampah plastik di taman kota! Bersama-sama kita bisa membuat lingkungan lebih bersih. 🌱♻️' : 'Event bersih-bersih pantai minggu depan! Siapa yang mau ikut? Mari kita jaga kebersihan pantai kita! 🏖️🌊' }}
                        </p>
                        @if($i % 2 == 0)
                        <img src="{{ asset('asset/img/bijak' . ($i + 1) . '.jpg') }}" alt="Post Image" class="w-full h-64 object-cover rounded-xl mb-4">
                        @endif
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-6">
                                <button class="flex items-center gap-2 text-gray-600 hover:text-red-500 transition-colors">
                                    <i class="fas fa-heart"></i>
                                    <span>{{ 15 + ($i * 3) }}</span>
                                </button>
                                <button class="flex items-center gap-2 text-gray-600 hover:text-blue-500 transition-colors">
                                    <i class="fas fa-comment"></i>
                                    <span>{{ 8 + ($i * 2) }}</span>
                                </button>
                                <button class="flex items-center gap-2 text-gray-600 hover:text-green-500 transition-colors">
                                    <i class="fas fa-share"></i>
                                    <span>{{ 3 + $i }}</span>
                                </button>
                            </div>
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-bookmark"></i>
                            </button>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>

            {{-- Events Tab --}}
            <div x-show="activeTab === 'events'" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @for ($i = 0; $i < 4; $i++)
                    <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 border-gray-200 hover:shadow-2xl transition-all duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-blue-500 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-calendar text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">{{ $i % 2 == 0 ? 'Bersih-bersih Pantai' : 'Workshop Daur Ulang' }}</h3>
                                    <p class="text-gray-600 text-sm">{{ $i % 2 == 0 ? 'Pantai Kuta, Bali' : 'Ruang Komunitas Hijau' }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $i % 2 == 0 ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $i % 2 == 0 ? 'Minggu Ini' : 'Bulan Depan' }}
                            </span>
                        </div>
                        <p class="text-gray-700 mb-4">
                            {{ $i % 2 == 0 ? 'Ayo bergabung dalam aksi bersih-bersih pantai! Mari kita jaga kebersihan pantai kita bersama-sama.' : 'Belajar cara mendaur ulang sampah menjadi barang yang berguna. Workshop gratis untuk semua anggota!' }}
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-users text-gray-500"></i>
                                <span class="text-sm text-gray-600">{{ 25 + ($i * 5) }} peserta</span>
                            </div>
                            <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors font-bold border-2 border-green-700">
                                Daftar
                            </button>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>

            {{-- Members Tab --}}
            <div x-show="activeTab === 'members'" class="space-y-6">
                <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 border-gray-200 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900">Anggota Aktif</h3>
                        <div class="flex items-center gap-2">
                            <input type="text" placeholder="Cari anggota..." class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors font-bold border-2 border-green-700">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @for ($i = 0; $i < 6; $i++)
                        <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-200 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <img src="{{ asset('asset/img/user_profile.jpg') }}" alt="Member" class="w-12 h-12 rounded-full">
                                    <div class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900">{{ $i % 2 == 0 ? 'Sarah Johnson' : 'Ahmad Rahman' }}</h4>
                                    <p class="text-sm text-gray-600">{{ $i % 2 == 0 ? 'Anggota Aktif' : 'Moderator' }}</p>
                                    <div class="flex items-center gap-1 mt-1">
                                        <i class="fas fa-star text-yellow-500 text-xs"></i>
                                        <span class="text-xs text-gray-600">{{ 4 + ($i % 2) }}.5</span>
                                    </div>
                                </div>
                                <button class="text-green-600 hover:text-green-700">
                                    <i class="fas fa-user-plus"></i>
                                </button>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- Groups Tab --}}
            <div x-show="activeTab === 'groups'" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @for ($i = 0; $i < 4; $i++)
                    <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 border-gray-200 hover:shadow-2xl transition-all duration-300">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-blue-500 rounded-xl flex items-center justify-center">
                                <i class="fas fa-users text-white text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 text-lg">{{ $i % 2 == 0 ? 'Komunitas Hijau Jakarta' : 'Eco Warriors Bali' }}</h3>
                                <p class="text-gray-600 text-sm">{{ $i % 2 == 0 ? 'Kelompok peduli lingkungan Jakarta' : 'Komunitas pelestarian alam Bali' }}</p>
                                <div class="flex items-center gap-4 mt-2">
                                    <span class="text-sm text-gray-600">{{ 150 + ($i * 25) }} anggota</span>
                                    <span class="text-sm text-green-600 font-bold">• Aktif</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700 mb-4">
                            {{ $i % 2 == 0 ? 'Komunitas yang fokus pada kegiatan peduli lingkungan di Jakarta. Rutin mengadakan kegiatan bersih-bersih dan edukasi lingkungan.' : 'Kelompok yang berdedikasi untuk melestarikan alam Bali. Mengadakan berbagai kegiatan konservasi dan edukasi.' }}
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $i % 2 == 0 ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $i % 2 == 0 ? 'Terbuka' : 'Terbatas' }}
                                </span>
                            </div>
                            <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors font-bold border-2 border-green-700">
                                Bergabung
                            </button>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>

    {{-- Create Post Modal --}}
    <div x-show="showCreatePost" x-transition class="fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl p-6 w-full max-w-2xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Buat Post Baru</h3>
                    <button @click="showCreatePost = false" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('asset/img/user_profile.jpg') }}" alt="Profile" class="w-12 h-12 rounded-full">
                        <div>
                            <h4 class="font-bold text-gray-900">Sarah Johnson</h4>
                            <p class="text-sm text-gray-600">Anggota Aktif</p>
                        </div>
                    </div>
                    <textarea placeholder="Apa yang ingin Anda bagikan dengan komunitas?" class="w-full h-32 px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"></textarea>
                    <div class="flex items-center gap-4">
                        <button class="flex items-center gap-2 text-gray-600 hover:text-green-600 transition-colors">
                            <i class="fas fa-image"></i>
                            <span>Tambah Foto</span>
                        </button>
                        <button class="flex items-center gap-2 text-gray-600 hover:text-blue-600 transition-colors">
                            <i class="fas fa-video"></i>
                            <span>Tambah Video</span>
                        </button>
                        <button class="flex items-center gap-2 text-gray-600 hover:text-purple-600 transition-colors">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Tambah Lokasi</span>
                        </button>
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button @click="showCreatePost = false" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-xl hover:bg-gray-400 transition-colors font-bold border-2 border-gray-400">
                            Batal
                        </button>
                        <button @click="createPost()" class="flex-1 bg-green-600 text-black py-3 rounded-xl hover:bg-green-700 transition-colors font-bold border-2 border-green-700">
                            Post
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Event Modal --}}
    <div x-show="showCreateEvent" x-transition class="fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl p-6 w-full max-w-2xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Buat Event Baru</h3>
                    <button @click="showCreateEvent = false" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul Event</label>
                        <input type="text" placeholder="Masukkan judul event" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea placeholder="Jelaskan detail event Anda" class="w-full h-24 px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                            <input type="date" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Waktu</label>
                            <input type="time" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                        <input type="text" placeholder="Masukkan lokasi event" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kapasitas Maksimal</label>
                        <input type="number" placeholder="Jumlah peserta maksimal" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button @click="showCreateEvent = false" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-xl hover:bg-gray-400 transition-colors font-bold border-2 border-gray-400">
                            Batal
                        </button>
                        <button @click="createEvent()" class="flex-1 bg-blue-600 text-white py-3 rounded-xl hover:bg-blue-700 transition-colors font-bold border-2 border-blue-700">
                            Buat Event
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function komunitasApp() {
        return {
            sidebarOpen: false,
            activeTab: 'timeline',
            showCreatePost: false,
            showCreateEvent: false,
            
            createPost() {
                this.showNotification('Post berhasil dibuat!', 'success');
                this.showCreatePost = false;
            },
            
            createEvent() {
                this.showNotification('Event berhasil dibuat!', 'success');
                this.showCreateEvent = false;
            },
            
            showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium transition-all duration-300 transform translate-x-full`;
                
                if (type === 'success') {
                    notification.classList.add('bg-green-500');
                } else if (type === 'error') {
                    notification.classList.add('bg-red-500');
                } else {
                    notification.classList.add('bg-blue-500');
                }
                
                notification.textContent = message;
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);
                
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 3000);
            }
        }
    }

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
    </script>
    </div>
</div>
</body>
</html>