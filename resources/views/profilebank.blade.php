<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Profil Bank Sampah - Bijak Sampah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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

        /* Profile Card Styles */
        .profile-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px rgba(0,0,0,0.1);
        }

        /* Stats Card */
        .stats-card {
            background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
            color: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            width: 90%;
            max-width: 600px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            animation: modalFadeIn 0.3s;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-header {
            padding: 15px 20px;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            font-size: 18px;
            font-weight: 600;
        }

        .modal-close {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }

        .modal-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #555;
        }

        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background-color: #f9f9f9;
        }

        .modal-footer {
            padding: 15px 20px;
            background-color: #f5f5f5;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-secondary {
            background-color: #e5e7eb;
            color: #333;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #d1d5db;
        }

        .btn-success {
            background-color: var(--success-color);
            color: white;
            border: none;
        }

        .btn-success:hover {
            background-color: #247532;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #04384e;
        }

        /* Profile Image */
        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .profile-image-container {
            position: relative;
            display: inline-block;
        }

        .profile-image-edit {
            position: absolute;
            bottom: 0;
            right: 0;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body class="bg-gray-50">

<div class="flex min-h-screen bg-gray-50 w-full" x-data="{ sidebarOpen: false, activeMenu: 'profile' }" x-init="activeMenu = 'profile'">
    {{-- Sidebar --}}
    <aside 
        class="fixed top-0 left-0 z-40 flex flex-col py-6 overflow-hidden shadow-2xl group sidebar-banksampah-gradient text-white"
        :class="sidebarOpen ? 'w-[250px]' : 'w-16'"
        style="transition: width 0.3s ease; height: 100vh; background: linear-gradient(135deg, #75E6DA 0%, #05445E 30%, #05445E 100%);"
    >
        <div class="relative flex flex-col h-full w-full px-4">
            
            {{-- Logo Section with Toggle Button --}}
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
                    @click="activeMenu = 'settings'"
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
        <div class="fixed top-0 left-0 right-0 h-12 z-40 flex items-center justify-between px-6 text-white" :style="'padding-left:' + (sidebarOpen ? '16rem' : '4rem') + '; background: linear-gradient(135deg, #75E6DA 0%, #05445E 30%, #05445E 100%); width: 100%;'">
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
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Profil Bank Sampah</h1>
                    <p class="text-sm text-gray-500">Kelola informasi profil bank sampah Anda</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Profile Info --}}
                <div class="lg:col-span-2">
                    <div class="profile-card p-6 mb-6">
                        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                            <div class="profile-image-container">
                                <img src="{{ asset('asset/img/user_profile.jpg') }}" alt="Profile" class="profile-image">
                                <div class="profile-image-edit" onclick="showEditPhotoModal()">
                                    <i class="fas fa-camera text-sm"></i>
                                </div>
                            </div>
                            <div class="flex-1 text-center md:text-left">
                                <h2 class="text-2xl font-bold text-gray-800 mb-2">Bank Sampah Hijau</h2>
                                <p class="text-gray-600 mb-4">Bank Sampah Terpercaya di Bogor</p>
                                <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-map-marker-alt text-red-500"></i>
                                        <span class="text-sm text-gray-600">Bogor, Jawa Barat</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-phone text-green-500"></i>
                                        <span class="text-sm text-gray-600">0812-3456-7890</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-envelope text-blue-500"></i>
                                        <span class="text-sm text-gray-600">bank@hijau.com</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bank Sampah Details --}}
                    <div class="profile-card p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Bank Sampah</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Bank Sampah</label>
                                <p class="text-gray-900">Bank Sampah Hijau</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pemilik</label>
                                <p class="text-gray-900">Ahmad Suryadi</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                                <p class="text-gray-900">Jl. Raya Bogor No. 123, Bogor, Jawa Barat 16123</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jam Operasional</label>
                                <p class="text-gray-900">Senin - Sabtu: 08:00 - 17:00</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                                <p class="text-gray-900">0812-3456-7890</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <p class="text-gray-900">bank@hijau.com</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <button class="btn btn-primary" onclick="showEditProfileModal()">
                                <i class="fas fa-edit mr-2"></i>Edit Profil
                            </button>
                        </div>
                    </div>

                    {{-- Bank Sampah Statistics --}}
                    <div class="profile-card p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Bank Sampah</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="text-center p-4 bg-blue-50 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600">156</div>
                                <div class="text-sm text-gray-600">Total Nasabah</div>
                            </div>
                            <div class="text-center p-4 bg-green-50 rounded-lg">
                                <div class="text-2xl font-bold text-green-600">2.5 ton</div>
                                <div class="text-sm text-gray-600">Sampah Terkumpul</div>
                            </div>
                            <div class="text-center p-4 bg-yellow-50 rounded-lg">
                                <div class="text-2xl font-bold text-yellow-600">89</div>
                                <div class="text-sm text-gray-600">Transaksi Bulan Ini</div>
                            </div>
                            <div class="text-center p-4 bg-purple-50 rounded-lg">
                                <div class="text-2xl font-bold text-purple-600">4.8</div>
                                <div class="text-sm text-gray-600">Rating</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar Info --}}
                <div class="space-y-6">
                    {{-- Quick Stats --}}
                    <div class="stats-card p-6">
                        <h3 class="text-lg font-semibold text-white mb-4">Ringkasan</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-white/80">Status</span>
                                <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">Aktif</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-white/80">Bergabung</span>
                                <span class="text-white">Jan 2024</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-white/80">Verifikasi</span>
                                <span class="text-white">✓ Terverifikasi</span>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Actions --}}
                    <div class="profile-card p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
                        <div class="space-y-3">
                            <button class="w-full text-left p-3 rounded-lg hover:bg-gray-50 transition-colors" onclick="showEditProfileModal()">
                                <i class="fas fa-edit text-blue-500 mr-3"></i>
                                Edit Profil
                            </button>
                            <button class="w-full text-left p-3 rounded-lg hover:bg-gray-50 transition-colors" onclick="showChangePasswordModal()">
                                <i class="fas fa-key text-green-500 mr-3"></i>
                                Ubah Password
                            </button>
                            <button class="w-full text-left p-3 rounded-lg hover:bg-gray-50 transition-colors" onclick="showSettingsModal()">
                                <i class="fas fa-cog text-purple-500 mr-3"></i>
                                Pengaturan
                            </button>
                            <button class="w-full text-left p-3 rounded-lg hover:bg-gray-50 transition-colors" onclick="showNotificationSettingsModal()">
                                <i class="fas fa-bell text-orange-500 mr-3"></i>
                                Notifikasi
                            </button>
                        </div>
                    </div>

                    {{-- Contact Info --}}
                    <div class="profile-card p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Kontak</h3>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-phone text-green-500"></i>
                                <span class="text-sm text-gray-600">0812-3456-7890</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-envelope text-blue-500"></i>
                                <span class="text-sm text-gray-600">bank@hijau.com</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-map-marker-alt text-red-500"></i>
                                <span class="text-sm text-gray-600">Bogor, Jawa Barat</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-clock text-purple-500"></i>
                                <span class="text-sm text-gray-600">08:00 - 17:00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal" id="editProfileModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Profil Bank Sampah</h3>
            <button class="modal-close" onclick="closeModal('editProfileModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="editProfileForm">
                <div class="form-group">
                    <label>Nama Bank Sampah</label>
                    <input type="text" id="bankName" value="Bank Sampah Hijau" required>
                </div>
                <div class="form-group">
                    <label>Pemilik</label>
                    <input type="text" id="ownerName" value="Ahmad Suryadi" required>
                </div>
                <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <textarea id="bankAddress" required>Jl. Raya Bogor No. 123, Bogor, Jawa Barat 16123</textarea>
                </div>
                <div class="form-group">
                    <label>Telepon</label>
                    <input type="tel" id="bankPhone" value="0812-3456-7890" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="bankEmail" value="bank@hijau.com" required>
                </div>
                <div class="form-group">
                    <label>Jam Operasional</label>
                    <input type="text" id="operatingHours" value="Senin - Sabtu: 08:00 - 17:00" required>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('editProfileModal')">Batal</button>
            <button class="btn btn-success" onclick="saveProfile()">Simpan</button>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal" id="changePasswordModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Ubah Password</h3>
            <button class="modal-close" onclick="closeModal('changePasswordModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="changePasswordForm">
                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" id="newPassword" placeholder="Masukkan password baru" required>
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" id="confirmPassword" placeholder="Konfirmasi password baru" required>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('changePasswordModal')">Batal</button>
            <button class="btn btn-success" onclick="changePassword()">Ubah Password</button>
        </div>
    </div>
</div>

<!-- Edit Photo Modal -->
<div class="modal" id="editPhotoModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Ubah Foto Profil</h3>
            <button class="modal-close" onclick="closeModal('editPhotoModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="text-center mb-4">
                <img src="{{ asset('asset/img/user_profile.jpg') }}" alt="Current Photo" class="w-32 h-32 rounded-full mx-auto mb-4">
            </div>
            <div class="form-group">
                <label>Pilih Foto Baru</label>
                <input type="file" id="newPhoto" accept="image/*">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('editPhotoModal')">Batal</button>
            <button class="btn btn-success" onclick="savePhoto()">Simpan</button>
        </div>
    </div>
</div>

<script>
    // Show Edit Profile Modal
    function showEditProfileModal() {
        document.getElementById('editProfileModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    // Show Change Password Modal
    function showChangePasswordModal() {
        document.getElementById('changePasswordModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    // Show Edit Photo Modal
    function showEditPhotoModal() {
        document.getElementById('editPhotoModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    // Show Settings Modal
    function showSettingsModal() {
        window.location.href = "{{ route('settingsbank') }}";
    }

    // Show Notification Settings Modal
    function showNotificationSettingsModal() {
        alert('Pengaturan notifikasi akan segera tersedia!');
    }

    // Close Modal
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Save Profile
    function saveProfile() {
        const bankName = document.getElementById('bankName').value;
        const ownerName = document.getElementById('ownerName').value;
        const bankAddress = document.getElementById('bankAddress').value;
        const bankPhone = document.getElementById('bankPhone').value;
        const bankEmail = document.getElementById('bankEmail').value;
        const operatingHours = document.getElementById('operatingHours').value;

        if (!bankName || !ownerName || !bankAddress || !bankPhone || !bankEmail || !operatingHours) {
            alert('Harap isi semua field yang wajib!');
            return;
        }

        alert('Profil berhasil disimpan!');
        closeModal('editProfileModal');
    }

    // Change Password
    function changePassword() {
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        if (!newPassword || !confirmPassword) {
            alert('Harap isi semua field yang wajib!');
            return;
        }

        if (newPassword !== confirmPassword) {
            alert('Password baru dan konfirmasi password tidak cocok!');
            return;
        }

        if (newPassword.length < 6) {
            alert('Password harus minimal 6 karakter!');
            return;
        }

        alert('Password berhasil diubah!');
        closeModal('changePasswordModal');
        document.getElementById('changePasswordForm').reset();
    }

    // Save Photo
    function savePhoto() {
        const fileInput = document.getElementById('newPhoto');
        if (fileInput.files.length === 0) {
            alert('Harap pilih foto terlebih dahulu!');
            return;
        }

        alert('Foto profil berhasil diubah!');
        closeModal('editPhotoModal');
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const modals = ['editProfileModal', 'changePasswordModal', 'editPhotoModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (event.target === modal) {
                closeModal(modalId);
            }
        });
    });
</script>
</body>
</html> 