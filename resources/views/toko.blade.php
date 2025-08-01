<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Daur Ulang - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('asset/js/theme-manager.js') }}"></script>
    <script src="{{ asset('asset/js/update-themes.js') }}"></script>
    <style>
        html, body { overflow-x: hidden; }
        .sidebar-gradient { background: var(--sidebar-gradient); }
        .sidebar-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .sidebar-item-hover { transition: all 0.2s ease-in-out; }
        .sidebar-item-hover:hover { background-color: rgba(255, 255, 255, 0.2); }
        .sidebar-logo { transition: all 0.3s ease-in-out; }
        .sidebar-nav-item { transition: all 0.2s ease-in-out; border-radius: 8px; }
        .sidebar-nav-item:hover { background-color: rgba(255, 255, 255, 0.1); }
        .sidebar-nav-item.active { background-color: rgba(255, 255, 255, 0.2); box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .fixed-header { position: fixed; top: 0; left: 0; right: 0; height: 48px; z-index: 40; display: flex; align-items: center; justify-content: space-between; padding-right: 1.5rem; background: var(--sidebar-gradient) !important; transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .ecommerce-card { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); border: 1px solid #e5e7eb; }
        .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .notification-badge { position: absolute; top: -5px; right: -5px; background: #ef4444; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 10px; display: flex; align-items: center; justify-content: center; z-index: 10; }
        .modal-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); display: flex; align-items: center; justify-content: center; z-index: 1000; }
        .modal-content { background: white; border-radius: 12px; padding: 24px; max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto; position: relative; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen" style="background-color: var(--bg-secondary);" x-data="tokoApp()" x-init="init()">
        <!-- Sidebar -->
        <aside
            x-data="{ open: false, active: 'toko' }"
            x-ref="sidebar"
            @mouseenter="open = true; $root.sidebarOpen = true"
            @mouseleave="open = false; $root.sidebarOpen = false"
            class="fixed top-0 left-0 z-20 flex flex-col py-6 sidebar-hover overflow-hidden shadow-2xl group sidebar-gradient"
            :class="open ? 'w-64' : 'w-16'"
            style="transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); margin-top: 48px; height: calc(100vh - 48px);"
        >
            <div class="relative flex flex-col h-full w-full px-4">
                <!-- Logo Section -->
                <div class="flex items-center justify-center mb-8 mt-2 sidebar-logo">
                    <img x-show="open" class="w-16 h-auto" src="{{ asset('asset/img/logo.png') }}" alt="Logo Penuh">
                    <img x-show="!open" class="w-6 h-6" src="{{ asset('asset/img/logo.png') }}" alt="Logo Ikon">
                </div>
                
                <!-- Navigation Menu -->
                <nav class="flex flex-col gap-2 w-full flex-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-3 font-medium sidebar-nav-item whitespace-nowrap w-full" :class="open ? (active === 'dashboard' ? 'active text-white' : 'text-white') : (active === 'dashboard' ? 'active text-white justify-center' : 'text-white justify-center')">
                        <i class="fas fa-home text-lg"></i>
                        <span x-show="open" class="text-sm font-medium">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('bank-sampah') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'bank-sampah' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'bank-sampah' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                        <i class="fas fa-tachometer-alt text-lg"></i>
                        <span x-show="open" class="text-sm font-medium">Bank Sampah</span>
                    </a>
                    
                    <a href="{{ route('toko') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'toko' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'toko' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                        <i class="fas fa-store text-lg"></i>
                        <span x-show="open" class="text-sm font-medium">Toko</span>
                    </a>
                    
                    <a href="{{ route('komunitas') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'komunitas' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'komunitas' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                        <i class="fas fa-users text-lg"></i>
                        <span x-show="open" class="text-sm font-medium">Komunitas</span>
                    </a>
                    
                    <a href="{{ route('berita') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'berita' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'berita' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                        <i class="fas fa-newspaper text-lg"></i>
                        <span x-show="open" class="text-sm font-medium">Berita</span>
                    </a>
                    
                    <a href="{{ route('keuangan') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'keuangan' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'keuangan' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                        <i class="fas fa-file-invoice-dollar text-lg"></i>
                        <span x-show="open" class="text-sm font-medium">Keuangan</span>
                    </a>
                    
                    <a href="{{ route('chat') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'chat' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'pesan' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                        <i class="fas fa-comment-dots text-lg"></i>
                        <span x-show="open" class="text-sm font-medium">Pesan</span>
                    </a>
                    
                    <a href="{{ route('feedback') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'feedback' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'umpan-balik' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                        <i class="fas fa-info-circle text-lg"></i>
                        <span x-show="open" class="text-sm font-medium">Umpan Balik</span>
                    </a>
                    
                    <a href="{{ route('settings') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'settings' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'settings' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                        <i class="fas fa-cog text-lg"></i>
                        <span x-show="open" class="text-sm font-medium">Settings</span>
                    </a>
                </nav>
                
                <!-- User Profile -->
                <div class="mt-auto">
                    <div class="flex items-center gap-3 p-3 sidebar-item-hover rounded-lg">
                        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-teal-600"></i>
                        </div>
                        <div x-show="open" class="flex-1">
                            <p class="text-white font-medium text-sm">Admin Toko</p>
                            <p class="text-white text-xs opacity-75">E-Commerce Manager</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1" :style="'padding-left: ' + (sidebarOpen ? '16rem' : '4rem') + '; transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);'">
            <!-- Top Header -->
            <header class="fixed top-0 left-0 right-0 h-12 z-40 flex items-center justify-between px-6 fixed-header" :style="'padding-left: ' + (sidebarOpen ? '16rem' : '4rem') + '; transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);'">
                <div class="flex items-center gap-4">
                    <h1 class="text-white font-bold text-xl">Toko Daur Ulang</h1>
                    <span class="bg-white bg-opacity-20 text-white px-3 py-1 rounded-full text-sm">E-Commerce Admin</span>
                </div>
                <div class="flex items-center gap-4">
                    <button @click="showNotifications = true" class="relative text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-bell text-lg"></i>
                        <span x-show="unreadNotifications > 0" class="notification-badge" x-text="unreadNotifications"></span>
                    </button>
                    <button @click="showSearch = true" class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-search text-lg"></i>
                    </button>
                    <div class="relative">
                        <button @click="showProfileDropdown = !showProfileDropdown" class="flex items-center gap-2 text-white hover:text-gray-200 transition-colors">
                            <img src="https://via.placeholder.com/32x32/75E6DA/ffffff?text=A" alt="Profile" class="w-8 h-8 rounded-full">
                            <span class="text-sm font-medium">Admin</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div x-show="showProfileDropdown" @click.away="showProfileDropdown = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-[90]">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                            <hr class="my-2">
                            <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="pt-16 px-6 pb-6" style="background-color: var(--bg-primary);">
                <!-- Navigation Tabs -->
                <div class="mb-8">
                    <nav class="flex space-x-8 border-b border-gray-200">
                        <button @click="setActiveTab('dashboard')" 
                                :class="activeTab === 'dashboard' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </button>
                        <button @click="setActiveTab('products')" 
                                :class="activeTab === 'products' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                            <i class="fas fa-box mr-2"></i>Produk
                        </button>
                        <button @click="setActiveTab('orders')" 
                                :class="activeTab === 'orders' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                            <i class="fas fa-shopping-cart mr-2"></i>Pesanan
                        </button>
                        <button @click="setActiveTab('customers')" 
                                :class="activeTab === 'customers' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                            <i class="fas fa-users mr-2"></i>Pelanggan
                        </button>
                        <button @click="setActiveTab('analytics')" 
                                :class="activeTab === 'analytics' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                            <i class="fas fa-chart-line mr-2"></i>Analitik
                        </button>
                    </nav>
                </div> 

                <!-- Dashboard Tab -->
                <div x-show="activeTab === 'dashboard'" class="space-y-6">
                    <!-- Welcome Banner -->
                    <div class="bg-gradient-to-r from-teal-500 via-teal-600 to-teal-700 rounded-2xl p-8 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-4xl font-bold mb-2">Selamat Datang di Admin Panel</h1>
                                <p class="text-teal-100 text-lg">Kelola toko daur ulang Anda dengan mudah dan efisien</p>
                                <div class="flex gap-4 mt-4">
                                    <button @click="showAddProduct = true" class="bg-white text-teal-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                                        <i class="fas fa-plus mr-2"></i>Tambah Produk
                                    </button>
                                    <button @click="setActiveTab('analytics')" class="bg-teal-400 text-white px-6 py-3 rounded-lg font-semibold hover:bg-teal-500 transition-colors">
                                        <i class="fas fa-chart-bar mr-2"></i>Lihat Statistik
                                    </button>
                                </div>
                            </div>
                            <div class="hidden lg:block">
                                <i class="fas fa-store text-8xl text-teal-200"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="ecommerce-card p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm font-medium">Total Produk</p>
                                    <p class="text-3xl font-bold text-gray-900" x-text="totalProducts"></p>
                                    <p class="text-green-600 text-sm">+12% dari bulan lalu</p>
                                </div>
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-box text-blue-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="ecommerce-card p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm font-medium">Pesanan Masuk</p>
                                    <p class="text-3xl font-bold text-gray-900" x-text="totalOrders"></p>
                                    <p class="text-orange-600 text-sm">+5 pesanan baru</p>
                                </div>
                                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-shopping-cart text-orange-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="ecommerce-card p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm font-medium">Pendapatan</p>
                                    <p class="text-3xl font-bold text-gray-900" x-text="formatPrice(totalRevenue)"></p>
                                    <p class="text-green-600 text-sm">+8% dari bulan lalu</p>
                                </div>
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="ecommerce-card p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm font-medium">Rating</p>
                                    <p class="text-3xl font-bold text-gray-900" x-text="averageRating"></p>
                                    <p class="text-yellow-600 text-sm">★★★★★</p>
                                </div>
                                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-star text-yellow-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity & Quick Actions -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Recent Orders -->
                        <div class="ecommerce-card p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Pesanan Terbaru</h3>
                            <div class="space-y-4">
                                <template x-for="order in orders.slice(0, 3)" :key="order.id">
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-box text-teal-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900" x-text="order.products[0]"></p>
                                                <p class="text-sm text-gray-600" x-text="order.id"></p>
                                            </div>
                                        </div>
                                        <span class="status-badge" :class="getStatusColor(order.status)" x-text="order.status"></span>
                                    </div>
                                </template>
                            </div>
                            <button @click="setActiveTab('orders')" class="w-full mt-4 bg-teal-600 text-white py-2 rounded-lg hover:bg-teal-700 transition-colors">
                                Lihat Semua Pesanan
                            </button>
                        </div>

                        <!-- Quick Actions -->
                        <div class="ecommerce-card p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Aksi Cepat</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <button @click="showAddProduct = true" class="p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                    <i class="fas fa-plus text-blue-600 text-2xl mb-2"></i>
                                    <p class="font-semibold text-gray-900">Tambah Produk</p>
                                </button>
                                <button @click="setActiveTab('products')" class="p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                                    <i class="fas fa-boxes text-green-600 text-2xl mb-2"></i>
                                    <p class="font-semibold text-gray-900">Kelola Produk</p>
                                </button>
                                <button @click="setActiveTab('orders')" class="p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                                    <i class="fas fa-shopping-cart text-purple-600 text-2xl mb-2"></i>
                                    <p class="font-semibold text-gray-900">Pesanan</p>
                                </button>
                                <button @click="setActiveTab('analytics')" class="p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                                    <i class="fas fa-chart-line text-orange-600 text-2xl mb-2"></i>
                                    <p class="font-semibold text-gray-900">Analitik</p>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Tab -->
                <div x-show="activeTab === 'products'" class="space-y-6">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold text-gray-900">Kelola Produk</h2>
                        <button @click="showAddProduct = true" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Tambah Produk
                        </button>
                    </div>

                    <!-- Search and Filter -->
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <input type="text" x-model="searchQuery" placeholder="Cari produk..." 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        </div>
                        <select x-model="selectedCategory" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                            <option value="all">Semua Kategori</option>
                            <template x-for="category in categories" :key="category.id">
                                <option :value="category.id" x-text="category.name"></option>
                            </template>
                        </select>
                    </div>

                    <!-- Products Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        <template x-for="product in products" :key="product.id">
                            <div class="ecommerce-card overflow-hidden">
                                <img :src="product.image" :alt="product.name" class="w-full h-48 object-cover">
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 mb-2" x-text="product.name"></h3>
                                    <p class="text-sm text-gray-600 mb-2" x-text="product.description"></p>
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-lg font-bold text-teal-600" x-text="formatPrice(product.price)"></span>
                                        <span class="text-sm text-gray-500">Stok: <span x-text="product.stock"></span></span>
                                    </div>
                                    <div class="flex gap-2">
                                        <button @click="editProduct(product)" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </button>
                                        <button @click="deleteProduct(product.id)" class="flex-1 bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition-colors">
                                            <i class="fas fa-trash mr-1"></i>Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Orders Tab -->
                <div x-show="activeTab === 'orders'" class="space-y-6">
                    <h2 class="text-2xl font-bold text-gray-900">Kelola Pesanan</h2>
                    
                    <!-- Order Filters -->
                    <div class="flex gap-4">
                        <button @click="orderFilter = 'all'" 
                                :class="orderFilter === 'all' ? 'bg-teal-600 text-white' : 'bg-gray-200 text-gray-700'"
                                class="px-4 py-2 rounded-lg transition-colors">
                            Semua
                        </button>
                        <button @click="orderFilter = 'pending'" 
                                :class="orderFilter === 'pending' ? 'bg-teal-600 text-white' : 'bg-gray-200 text-gray-700'"
                                class="px-4 py-2 rounded-lg transition-colors">
                            Pending
                        </button>
                        <button @click="orderFilter = 'shipped'" 
                                :class="orderFilter === 'shipped' ? 'bg-teal-600 text-white' : 'bg-gray-200 text-gray-700'"
                                class="px-4 py-2 rounded-lg transition-colors">
                            Dikirim
                        </button>
                        <button @click="orderFilter = 'completed'" 
                                :class="orderFilter === 'completed' ? 'bg-teal-600 text-white' : 'bg-gray-200 text-gray-700'"
                                class="px-4 py-2 rounded-lg transition-colors">
                            Selesai
                        </button>
                    </div>

                    <!-- Orders Table -->
                    <div class="ecommerce-card overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <template x-for="order in orders" :key="order.id">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" x-text="order.id"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" x-text="order.customer"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" x-text="order.products[0]"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" x-text="formatPrice(order.total)"></td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="status-badge" :class="getStatusColor(order.status)" x-text="order.status"></span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" x-text="formatDate(order.date)"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button @click="viewOrder(order)" class="text-teal-600 hover:text-teal-900 mr-3">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button @click="updateOrderStatus(order.id, 'completed')" class="text-green-600 hover:text-green-900">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Customers Tab -->
                <div x-show="activeTab === 'customers'" class="space-y-6">
                    <h2 class="text-2xl font-bold text-gray-900">Kelola Pelanggan</h2>
                    
                    <!-- Customers Table -->
                    <div class="ecommerce-card overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pesanan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Belanja</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bergabung</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <template x-for="customer in customers" :key="customer.id">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" x-text="customer.name"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" x-text="customer.email"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" x-text="customer.phone"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" x-text="customer.totalOrders"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" x-text="formatPrice(customer.totalSpent)"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" x-text="formatDate(customer.joinDate)"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button @click="viewCustomer(customer)" class="text-teal-600 hover:text-teal-900">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Analytics Tab -->
                <div x-show="activeTab === 'analytics'" class="space-y-6">
                    <h2 class="text-2xl font-bold text-gray-900">Analitik & Laporan</h2>
                    
                    <!-- Analytics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="ecommerce-card p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100">
                                    <i class="fas fa-chart-line text-blue-600"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Penjualan Bulan Ini</p>
                                    <p class="text-2xl font-semibold text-gray-900">Rp 8.5M</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="ecommerce-card p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100">
                                    <i class="fas fa-users text-green-600"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Pelanggan Baru</p>
                                    <p class="text-2xl font-semibold text-gray-900">+45</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="ecommerce-card p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-yellow-100">
                                    <i class="fas fa-star text-yellow-600"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Rating Rata-rata</p>
                                    <p class="text-2xl font-semibold text-gray-900">4.8</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="ecommerce-card p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-100">
                                    <i class="fas fa-shopping-bag text-purple-600"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Produk Terjual</p>
                                    <p class="text-2xl font-semibold text-gray-900">1,247</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Placeholder -->
                    <div class="ecommerce-card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Grafik Penjualan</h3>
                        <div class="h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                            <p class="text-gray-500">Grafik penjualan akan ditampilkan di sini</p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div x-show="showAddProduct" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[100]" @click.away="showAddProduct = false">
        <div class="bg-white rounded-xl p-8 w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-900">Tambah Produk Baru</h3>
                <button @click="showAddProduct = false" class="text-gray-400 hover:text-gray-600 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form @submit.prevent="addProduct()">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk</label>
                        <input type="text" x-model="newProduct.name" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                        <select x-model="newProduct.category" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-colors">
                            <option value="">Pilih Kategori</option>
                            <option value="Plastik">Plastik</option>
                            <option value="Kertas">Kertas</option>
                            <option value="Logam">Logam</option>
                            <option value="Elektronik">Elektronik</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Harga</label>
                            <input type="number" x-model="newProduct.price" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Stok</label>
                            <input type="number" x-model="newProduct.stock" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-colors">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                        <textarea x-model="newProduct.description" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-colors resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">URL Gambar</label>
                        <input type="url" x-model="newProduct.image" placeholder="https://example.com/image.jpg"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-colors">
                    </div>
                </div>
                <div class="flex gap-4 mt-8">
                    <button type="submit" class="flex-1 bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 transition-colors font-semibold">
                        <i class="fas fa-plus mr-2"></i>Tambah Produk
                    </button>
                    <button type="button" @click="showAddProduct = false" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg hover:bg-gray-400 transition-colors font-semibold">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div x-show="showEditProduct" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[100]" @click.away="showEditProduct = false">
        <div class="bg-white rounded-xl p-8 w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-900">Edit Produk</h3>
                <button @click="showEditProduct = false" class="text-gray-400 hover:text-gray-600 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form @submit.prevent="updateProduct()">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk</label>
                        <input type="text" x-model="newProduct.name" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                        <select x-model="newProduct.category" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-colors">
                            <option value="">Pilih Kategori</option>
                            <option value="Plastik">Plastik</option>
                            <option value="Kertas">Kertas</option>
                            <option value="Logam">Logam</option>
                            <option value="Elektronik">Elektronik</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Harga</label>
                            <input type="number" x-model="newProduct.price" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Stok</label>
                            <input type="number" x-model="newProduct.stock" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-colors">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                        <textarea x-model="newProduct.description" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-colors resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">URL Gambar</label>
                        <input type="url" x-model="newProduct.image" placeholder="https://example.com/image.jpg"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-colors">
                    </div>
                </div>
                <div class="flex gap-4 mt-8">
                    <button type="submit" class="flex-1 bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 transition-colors font-semibold">
                        <i class="fas fa-save mr-2"></i>Update Produk
                    </button>
                    <button type="button" @click="showEditProduct = false" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg hover:bg-gray-400 transition-colors font-semibold">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Order Detail Modal -->
    <div x-show="showOrderDetail" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[100]" @click.away="showOrderDetail = false">
        <div class="bg-white rounded-xl p-8 w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-900">Detail Pesanan</h3>
                <button @click="showOrderDetail = false" class="text-gray-400 hover:text-gray-600 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div x-show="selectedOrder" class="space-y-6">
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-600 mb-1">Order ID</p>
                        <p class="text-lg font-bold text-gray-900" x-text="selectedOrder?.id"></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-600 mb-1">Status</p>
                        <span class="status-badge text-sm px-3 py-1" :class="getStatusColor(selectedOrder?.status)" x-text="selectedOrder?.status"></span>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-600 mb-1">Pelanggan</p>
                        <p class="text-lg font-bold text-gray-900" x-text="selectedOrder?.customer"></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-600 mb-1">Total</p>
                        <p class="text-lg font-bold text-teal-600" x-text="formatPrice(selectedOrder?.total)"></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-600 mb-1">Tanggal</p>
                        <p class="text-lg font-bold text-gray-900" x-text="formatDate(selectedOrder?.date)"></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-600 mb-1">Pembayaran</p>
                        <p class="text-lg font-bold text-gray-900" x-text="selectedOrder?.payment"></p>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-700 mb-3">Produk</p>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <template x-for="product in selectedOrder?.products" :key="product">
                            <p class="text-gray-900 font-medium" x-text="product"></p>
                        </template>
                    </div>
                </div>
                <div class="flex gap-3 pt-4">
                    <button @click="updateOrderStatus(selectedOrder?.id, 'processing')" 
                            class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                        <i class="fas fa-cog mr-2"></i>Proses
                    </button>
                    <button @click="updateOrderStatus(selectedOrder?.id, 'shipped')" 
                            class="flex-1 bg-purple-600 text-white py-3 rounded-lg hover:bg-purple-700 transition-colors font-semibold">
                        <i class="fas fa-truck mr-2"></i>Kirim
                    </button>
                    <button @click="updateOrderStatus(selectedOrder?.id, 'completed')" 
                            class="flex-1 bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition-colors font-semibold">
                        <i class="fas fa-check mr-2"></i>Selesai
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Detail Modal -->
    <div x-show="showCustomerDetail" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[100]" @click.away="showCustomerDetail = false">
        <div class="bg-white rounded-xl p-8 w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-900">Detail Pelanggan</h3>
                <button @click="showCustomerDetail = false" class="text-gray-400 hover:text-gray-600 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div x-show="selectedCustomer" class="space-y-6">
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-600 mb-1">Nama</p>
                        <p class="text-lg font-bold text-gray-900" x-text="selectedCustomer?.name"></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-600 mb-1">Email</p>
                        <p class="text-lg font-bold text-gray-900" x-text="selectedCustomer?.email"></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-600 mb-1">Telepon</p>
                        <p class="text-lg font-bold text-gray-900" x-text="selectedCustomer?.phone"></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-600 mb-1">Bergabung</p>
                        <p class="text-lg font-bold text-gray-900" x-text="formatDate(selectedCustomer?.joinDate)"></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Pesanan</p>
                        <p class="text-lg font-bold text-gray-900" x-text="selectedCustomer?.totalOrders"></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Belanja</p>
                        <p class="text-lg font-bold text-teal-600" x-text="formatPrice(selectedCustomer?.totalSpent)"></p>
                    </div>
                </div>
                <div class="flex gap-4 pt-4">
                    <button class="flex-1 bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 transition-colors font-semibold">
                        <i class="fas fa-envelope mr-2"></i>Kirim Email
                    </button>
                    <button class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                        <i class="fas fa-phone mr-2"></i>Hubungi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications Modal -->
    <div x-show="showNotifications" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[100]" @click.away="showNotifications = false">
        <div class="bg-white rounded-xl p-8 w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-900">Notifikasi</h3>
                <button @click="showNotifications = false" class="text-gray-400 hover:text-gray-600 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="space-y-4">
                <div class="flex items-start p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Pesanan baru diterima</p>
                        <p class="text-xs text-gray-600 mt-1">2 menit yang lalu</p>
                    </div>
                </div>
                <div class="flex items-start p-4 bg-green-50 rounded-lg border border-green-200">
                    <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Pembayaran berhasil</p>
                        <p class="text-xs text-gray-600 mt-1">5 menit yang lalu</p>
                    </div>
                </div>
                <div class="flex items-start p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                    <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-3"></i>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Stok produk menipis</p>
                        <p class="text-xs text-gray-600 mt-1">10 menit yang lalu</p>
                    </div>
                </div>
                <div class="flex items-start p-4 bg-purple-50 rounded-lg border border-purple-200">
                    <i class="fas fa-user-plus text-purple-600 mt-1 mr-3"></i>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Pelanggan baru mendaftar</p>
                        <p class="text-xs text-gray-600 mt-1">15 menit yang lalu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Modal -->
    <div x-show="showSearch" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[100]" @click.away="showSearch = false">
        <div class="bg-white rounded-xl p-8 w-full max-w-lg mx-4">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-900">Cari</h3>
                <button @click="showSearch = false" class="text-gray-400 hover:text-gray-600 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kata Kunci</label>
                    <input type="text" x-model="searchQuery" placeholder="Cari produk, pesanan, atau pelanggan..." 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-colors">
                </div>
                <div class="flex gap-4">
                    <button @click="performSearch()" class="flex-1 bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 transition-colors font-semibold">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>
                    <button @click="showSearch = false" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg hover:bg-gray-400 transition-colors font-semibold">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function tokoApp() {
            return {
                // Navigation & UI State
                sidebarOpen: false,
                activeTab: 'dashboard',
                
                // Modal States
                showAddProduct: false,
                showEditProduct: false,
                showNotifications: false,
                showSearch: false,
                showProfileDropdown: false,
                showOrderDetail: false,
                showCustomerDetail: false,
                
                // Data States
                searchQuery: '',
                orderFilter: 'all',
                selectedCategory: 'all',
                selectedProduct: null,
                selectedOrder: null,
                selectedCustomer: null,
                
                // Statistics
                unreadNotifications: 5,
                totalProducts: 247,
                totalOrders: 89,
                totalRevenue: 12500000,
                totalCustomers: 1200,
                averageRating: 4.8,
                
                // Sample Data
                products: [
                    {
                        id: 1,
                        name: 'Botol Plastik Daur Ulang',
                        category: 'Plastik',
                        price: 15000,
                        stock: 50,
                        sold: 120,
                        rating: 4.5,
                        image: 'https://via.placeholder.com/300x200/75E6DA/ffffff?text=Botol+Plastik',
                        description: 'Botol plastik berkualitas tinggi hasil daur ulang',
                        status: 'active'
                    },
                    {
                        id: 2,
                        name: 'Kertas Bekas Premium',
                        category: 'Kertas',
                        price: 25000,
                        stock: 30,
                        sold: 85,
                        rating: 4.8,
                        image: 'https://via.placeholder.com/300x200/43E97B/ffffff?text=Kertas+Bekas',
                        description: 'Kertas bekas premium untuk keperluan kantor',
                        status: 'active'
                    },
                    {
                        id: 3,
                        name: 'Kaleng Aluminium',
                        category: 'Logam',
                        price: 18000,
                        stock: 25,
                        sold: 65,
                        rating: 4.2,
                        image: 'https://via.placeholder.com/300x200/F093FB/ffffff?text=Kaleng+Aluminium',
                        description: 'Kaleng aluminium daur ulang berkualitas',
                        status: 'active'
                    }
                ],
                
                orders: [
                    {
                        id: 'ORD-001',
                        customer: 'Ahmad Rahman',
                        products: ['Botol Plastik Daur Ulang'],
                        total: 15000,
                        status: 'pending',
                        date: '2024-01-15',
                        payment: 'transfer'
                    },
                    {
                        id: 'ORD-002',
                        customer: 'Siti Nurhaliza',
                        products: ['Kertas Bekas Premium'],
                        total: 25000,
                        status: 'completed',
                        date: '2024-01-14',
                        payment: 'cash'
                    },
                    {
                        id: 'ORD-003',
                        customer: 'Budi Santoso',
                        products: ['Kaleng Aluminium'],
                        total: 18000,
                        status: 'shipped',
                        date: '2024-01-13',
                        payment: 'transfer'
                    }
                ],
                
                customers: [
                    {
                        id: 1,
                        name: 'Ahmad Rahman',
                        email: 'ahmad@email.com',
                        phone: '081234567890',
                        totalOrders: 5,
                        totalSpent: 75000,
                        joinDate: '2023-12-01'
                    },
                    {
                        id: 2,
                        name: 'Siti Nurhaliza',
                        email: 'siti@email.com',
                        phone: '081234567891',
                        totalOrders: 3,
                        totalSpent: 50000,
                        joinDate: '2023-12-15'
                    }
                ],
                
                categories: [
                    { id: 'all', name: 'Semua Kategori', count: 247 },
                    { id: 'plastik', name: 'Plastik', count: 89 },
                    { id: 'kertas', name: 'Kertas', count: 67 },
                    { id: 'logam', name: 'Logam', count: 45 },
                    { id: 'elektronik', name: 'Elektronik', count: 23 },
                    { id: 'lainnya', name: 'Lainnya', count: 23 }
                ],
                
                // Form Data
                newProduct: {
                    name: '',
                    category: '',
                    price: '',
                    stock: '',
                    description: '',
                    image: ''
                },
                
                // Methods
                init() {
                    console.log('Toko app initialized');
                    this.showNotification('Selamat datang di Admin Panel E-Commerce Toko Daur Ulang!');
                },
                
                // Navigation
                setActiveTab(tab) {
                    this.activeTab = tab;
                },
                
                // Product Management
                addProduct() {
                    if (!this.newProduct.name || !this.newProduct.price || !this.newProduct.stock) {
                        this.showNotification('Mohon lengkapi semua field yang diperlukan!', 'error');
                        return;
                    }
                    
                    const product = {
                        id: this.products.length + 1,
                        ...this.newProduct,
                        sold: 0,
                        rating: 0,
                        status: 'active',
                        image: this.newProduct.image || 'https://via.placeholder.com/300x200/75E6DA/ffffff?text=Produk+Baru'
                    };
                    
                    this.products.push(product);
                    this.totalProducts++;
                    this.showNotification('Produk berhasil ditambahkan!');
                    this.showAddProduct = false;
                    this.resetProductForm();
                },
                
                editProduct(product) {
                    this.selectedProduct = product;
                    this.newProduct = { ...product };
                    this.showEditProduct = true;
                },
                
                updateProduct() {
                    const index = this.products.findIndex(p => p.id === this.selectedProduct.id);
                    if (index !== -1) {
                        this.products[index] = { ...this.selectedProduct, ...this.newProduct };
                        this.showNotification('Produk berhasil diperbarui!');
                        this.showEditProduct = false;
                        this.resetProductForm();
                    }
                },
                
                deleteProduct(productId) {
                    if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                        this.products = this.products.filter(p => p.id !== productId);
                        this.totalProducts--;
                        this.showNotification('Produk berhasil dihapus!');
                    }
                },
                
                resetProductForm() {
                    this.newProduct = {
                        name: '',
                        category: '',
                        price: '',
                        stock: '',
                        description: '',
                        image: ''
                    };
                },
                
                // Order Management
                viewOrder(order) {
                    this.selectedOrder = order;
                    this.showOrderDetail = true;
                },
                
                updateOrderStatus(orderId, status) {
                    const order = this.orders.find(o => o.id === orderId);
                    if (order) {
                        order.status = status;
                        this.showNotification(`Status pesanan ${orderId} berhasil diperbarui!`);
                    }
                },
                
                // Customer Management
                viewCustomer(customer) {
                    this.selectedCustomer = customer;
                    this.showCustomerDetail = true;
                },
                
                // Search
                performSearch() {
                    console.log('Searching for:', this.searchQuery);
                    this.showNotification('Mencari: ' + this.searchQuery);
                    this.showSearch = false;
                },
                
                // Notifications
                showNotification(message, type = 'success') {
                    const notification = document.createElement('div');
                    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
                    notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50`;
                    notification.textContent = message;
                    document.body.appendChild(notification);
                    
                    setTimeout(() => {
                        if (document.body.contains(notification)) {
                            document.body.removeChild(notification);
                        }
                    }, 3000);
                },
                
                // Utility Methods
                formatPrice(price) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(price);
                },
                
                formatDate(date) {
                    return new Date(date).toLocaleDateString('id-ID');
                },
                
                getStatusColor(status) {
                    const colors = {
                        'pending': 'bg-yellow-100 text-yellow-800',
                        'processing': 'bg-blue-100 text-blue-800',
                        'shipped': 'bg-purple-100 text-purple-800',
                        'completed': 'bg-green-100 text-green-800',
                        'cancelled': 'bg-red-100 text-red-800'
                    };
                    return colors[status] || 'bg-gray-100 text-gray-800';
                }
            }
        }
    </script>
</body>
</html> 