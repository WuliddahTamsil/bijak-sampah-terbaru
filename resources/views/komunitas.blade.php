@extends('layouts.app')

@section('content')
<style>
    html, body {
        overflow-x: hidden;
    }
    .sidebar-gradient {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
    }
    .sidebar-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .sidebar-item-hover {
        transition: all 0.2s ease-in-out;
    }
    .sidebar-item-hover:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }
    .sidebar-logo {
        transition: all 0.3s ease-in-out;
    }
    .sidebar-nav-item {
        transition: all 0.2s ease-in-out;
        border-radius: 8px;
    }
    .sidebar-nav-item:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
    .sidebar-nav-item.active {
        background-color: rgba(255, 255, 255, 0.2);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .sidebar-fixed {
        z-index: 1000 !important;
    }
    .main-content-area {
        position: relative;
        z-index: 1;
    }
    .fixed-header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 48px;
        z-index: 40;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-right: 1.5rem;
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
        transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .community-card {
        transition: all 0.3s ease;
    }
    .community-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    }
    .online-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        background-color: #10b981;
        border: 2px solid white;
        border-radius: 50%;
    }
</style>

<div class="flex min-h-screen bg-gradient-to-br from-blue-50 via-white to-teal-50" x-data="komunitasApp()" x-init="init()">
    {{-- Sidebar --}}
    <aside
        x-data="{ open: false, active: 'komunitas' }"
        x-ref="sidebar"
        @mouseenter="open = true; $root.sidebarOpen = true"
        @mouseleave="open = false; $root.sidebarOpen = false"
        class="fixed top-0 left-0 z-50 flex flex-col py-6 sidebar-hover overflow-hidden shadow-2xl group sidebar-gradient sidebar-fixed"
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
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-3 font-medium sidebar-nav-item whitespace-nowrap w-full" :class="open ? (active === 'dashboard' ? 'active text-white' : 'text-white') : (active === 'dashboard' ? 'active text-white justify-center' : 'text-white justify-center')">
                    <i class="fas fa-home text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Dashboard</span>
                </a>
                
                {{-- Bank Sampah Link --}}
                <a href="{{ route('bank-sampah') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'bank-sampah' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'bank-sampah' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-tachometer-alt text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Bank Sampah</span>
                </a>
                
                {{-- Toko Link --}}
                <a href="{{ route('toko') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'toko' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'toko' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-store text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Toko</span>
                </a>
                
                {{-- Komunitas Link --}}
                <a href="{{ route('komunitas') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'komunitas' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'komunitas' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-users text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Komunitas</span>
                </a>
                
                {{-- Berita Link --}}
                <a href="{{ route('berita') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'berita' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'berita' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-newspaper text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Berita</span>
                </a>
                
                {{-- Keuangan Link --}}
                <a href="{{ route('keuangan') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'keuangan' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'keuangan' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-file-invoice-dollar text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Keuangan</span>
                </a>
                
                {{-- Pesan Link --}}
                <a href="{{ route('chat') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'chat' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'pesan' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-comment-dots text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Pesan</span>
                </a>
                
                {{-- Umpan Balik Link --}}
                <a href="{{ route('feedback') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'feedback' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'umpan-balik' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-info-circle text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Umpan Balik</span>
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
    <div class="flex-1 min-h-screen main-content-area" :style="'padding-left:' + (sidebarOpen ? '16rem' : '4rem') + '; transition: padding-left 0.3s cubic-bezier(0.4,0,0.2,1);'">
        {{-- Top Header Bar --}}
        <div class="fixed-header" :style="'padding-left:' + (sidebarOpen ? '16rem' : '4rem') + ';'">
            <h1 class="text-white font-semibold text-lg">BijakSampah</h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('notifikasi') }}" class="relative">
                    <i class="far fa-bell text-white text-sm"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-medium">3</span>
                </a>
                <button class="focus:outline-none">
                    <i class="fas fa-search text-white text-sm"></i>
                </button>
                <div class="flex items-center gap-2">
                    <a href="{{ route('profile') }}" class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center border-2 border-gray-300">
                        <img src="{{ asset('asset/img/user_profile.jpg') }}" alt="Profile" class="w-full h-full object-cover">
                    </a>
                    <i class="fas fa-chevron-down text-white text-xs"></i>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="p-8" style="padding-top: 60px;">
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

            {{-- Search Bar --}}
            <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 border-gray-200 mb-8">
                <div class="flex items-center gap-4">
                    <div class="flex-1 relative">
                        <input 
                            x-model="globalSearchQuery" 
                            @input="performSearch($event.target.value)"
                            type="text" 
                            placeholder="Cari post, event, anggota, atau grup..." 
                            class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-lg"
                        >
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                    </div>
                    <button @click="clearSearch()" x-show="globalSearchQuery" class="bg-gray-500 text-white px-4 py-3 rounded-xl hover:bg-gray-600 transition-all duration-300 font-bold">
                        <i class="fas fa-times mr-2"></i>Clear
                    </button>
                </div>
                <div x-show="globalSearchQuery" class="mt-4 text-sm text-gray-600">
                    <span x-text="`Hasil pencarian untuk: "${globalSearchQuery}"`"></span>
                    <span x-text="` - ${filteredPosts.length} post, ${filteredEvents.length} event, ${filteredMembers.length} anggota, ${filteredGroups.length} grup`"></span>
                </div>
            </div>

            {{-- Info Panel --}}
            <div x-show="filteredPosts.some(p => p.isNew) || filteredEvents.some(e => e.isNew)" class="bg-green-50 border-2 border-green-200 rounded-2xl p-4 mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-info-circle text-green-600 text-xl"></i>
                    <div>
                        <h4 class="font-bold text-green-800">Konten Baru Tersedia!</h4>
                        <p class="text-green-700 text-sm">
                            <span x-show="filteredPosts.some(p => p.isNew)">• Post baru di tab <strong>Timeline</strong></span>
                            <span x-show="filteredEvents.some(e => e.isNew)">• Event baru di tab <strong>Events</strong></span>
                        </p>
                    </div>
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
                    <span x-show="filteredPosts.some(p => p.isNew)" class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">New</span>
                </button>
                <button 
                    @click="activeTab = 'events'" 
                    :class="activeTab === 'events' ? 'bg-blue-600 text-white shadow-2xl scale-105 border-2 border-blue-700' : 'bg-gray-100 text-gray-900 hover:bg-gray-200 border-2 border-gray-400'"
                    class="px-8 py-3 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg">
                    <i class="fas fa-calendar mr-2"></i>Events
                    <span x-show="filteredEvents.some(e => e.isNew)" class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">New</span>
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
                            <textarea x-model="newPost.content" placeholder="Apa yang ingin Anda bagikan?" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 resize-none" rows="3"></textarea>
                        </div>
                    </div>
                    
                    <!-- Upload Progress Bar -->
                    <div x-show="isUploading" class="mb-4">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full transition-all duration-300" :style="`width: ${uploadProgress}%`"></div>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">Uploading... <span x-text="uploadProgress"></span>%</p>
                    </div>
                    
                    <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 text-gray-600 hover:text-green-600 transition-colors cursor-pointer">
                            <i class="fas fa-image"></i>
                            <span>Foto</span>
                            <input type="file" accept="image/*" class="hidden" @change="handleFileUpload($event.target)">
                        </label>
                        <label class="flex items-center gap-2 text-gray-600 hover:text-blue-600 transition-colors cursor-pointer">
                            <i class="fas fa-video"></i>
                            <span>Video</span>
                            <input type="file" accept="video/*" class="hidden" @change="handleFileUpload($event.target)">
                        </label>
                        <button class="flex items-center gap-2 text-gray-600 hover:text-purple-600 transition-colors">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Lokasi</span>
                        </button>
                    </div>
                    
                    <!-- File Preview -->
                    <div x-show="selectedFile" class="mt-4 p-4 bg-gray-50 rounded-xl border-2 border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-file text-blue-500 text-xl"></i>
                                <div>
                                    <p class="font-medium text-gray-900" x-text="selectedFile?.name"></p>
                                    <p class="text-sm text-gray-600" x-text="`${(selectedFile?.size / 1024 / 1024).toFixed(2)} MB`"></p>
                                </div>
                            </div>
                            <button @click="removeSelectedFile()" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <img x-show="selectedFile && selectedFile.type.startsWith('image/')" :src="selectedFile ? URL.createObjectURL(selectedFile) : ''" alt="Preview" class="mt-3 w-full h-32 object-cover rounded-lg">
                    </div>
                        <button @click="createPost()" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors font-bold border-2 border-green-700">
                            Post
                        </button>
                    </div>
                </div>

                {{-- Posts --}}
                <div class="space-y-6">
                    <div x-show="filteredPosts.length === 0 && globalSearchQuery" class="text-center py-8">
                        <i class="fas fa-search text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-600 text-lg">Tidak ada post yang ditemukan untuk "<span x-text="globalSearchQuery"></span>"</p>
                    </div>
                    <template x-for="post in filteredPosts" :key="post.id">
                        <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 hover:shadow-2xl transition-all duration-300" :class="post.isNew ? 'border-green-400 bg-green-50' : 'border-gray-200'">
                            <div x-show="post.isNew" class="mb-3">
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    <i class="fas fa-star mr-1"></i>Post Baru
                                </span>
                            </div>
                            <div class="flex items-start gap-4 mb-4">
                                <div class="relative">
                                    <img :src="post.avatar" alt="Profile" class="w-12 h-12 rounded-full">
                                    <div x-show="post.isOnline" class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-bold text-gray-900" x-text="post.author"></h3>
                                        <span x-show="post.isOnline" class="text-green-600 text-sm font-bold">• Online</span>
                                    </div>
                                    <p class="text-gray-600 text-sm" x-text="post.time"></p>
                                </div>
                                <button class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </div>
                            <p class="text-gray-800 mb-4 leading-relaxed" x-text="post.content"></p>
                            <img x-show="post.image" :src="post.image" alt="Post Image" class="w-full h-64 object-cover rounded-xl mb-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-6">
                                    <button @click="likePost(post.id)" class="flex items-center gap-2 text-gray-600 hover:text-red-500 transition-colors">
                                        <i class="fas fa-heart"></i>
                                        <span x-text="post.likes"></span>
                                    </button>
                                    <button @click="commentPost(post.id)" class="flex items-center gap-2 text-gray-600 hover:text-blue-500 transition-colors">
                                        <i class="fas fa-comment"></i>
                                        <span x-text="post.comments"></span>
                                    </button>
                                    <button @click="sharePost(post.id)" class="flex items-center gap-2 text-gray-600 hover:text-green-500 transition-colors">
                                        <i class="fas fa-share"></i>
                                        <span x-text="post.shares"></span>
                                    </button>
                                </div>
                                <button @click="bookmarkPost(post.id)" class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-bookmark"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Events Tab --}}
            <div x-show="activeTab === 'events'" class="space-y-6">
                <div x-show="filteredEvents.length === 0 && globalSearchQuery" class="text-center py-8">
                    <i class="fas fa-calendar text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-600 text-lg">Tidak ada event yang ditemukan untuk "<span x-text="globalSearchQuery"></span>"</p>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <template x-for="event in filteredEvents" :key="event.id">
                        <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 hover:shadow-2xl transition-all duration-300" :class="event.isNew ? 'border-green-400 bg-green-50' : 'border-gray-200'">
                            <div x-show="event.isNew" class="mb-3">
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    <i class="fas fa-star mr-1"></i>Event Baru
                                </span>
                            </div>
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-blue-500 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-calendar text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900" x-text="event.title"></h3>
                                        <p class="text-gray-600 text-sm" x-text="event.location"></p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-bold" :class="event.type === 'green' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800'" x-text="event.status"></span>
                            </div>
                            <p class="text-gray-700 mb-4" x-text="event.description"></p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-users text-gray-500"></i>
                                    <span class="text-sm text-gray-600" x-text="`${event.participants} peserta`"></span>
                                </div>
                                <button @click="joinEvent(event.id)" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors font-bold border-2 border-green-700">
                                    Daftar
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Members Tab --}}
            <div x-show="activeTab === 'members'" class="space-y-6">
                <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 border-gray-200 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900">Anggota Aktif</h3>
                        <div class="flex items-center gap-2">
                            <input x-model="searchQuery" type="text" placeholder="Cari anggota..." class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <button @click="searchMembers(searchQuery)" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors font-bold border-2 border-green-700">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div x-show="filteredMembers.length === 0 && (globalSearchQuery || searchQuery)" class="text-center py-8">
                        <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-600 text-lg">Tidak ada anggota yang ditemukan untuk "<span x-text="globalSearchQuery || searchQuery"></span>"</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <template x-for="member in filteredMembers" :key="member.id">
                            <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-200 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <img :src="member.avatar" alt="Member" class="w-12 h-12 rounded-full">
                                        <div x-show="member.isOnline" class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-900" x-text="member.name"></h4>
                                        <p class="text-sm text-gray-600" x-text="member.role"></p>
                                        <div class="flex items-center gap-1 mt-1">
                                            <i class="fas fa-star text-yellow-500 text-xs"></i>
                                            <span class="text-xs text-gray-600" x-text="member.rating"></span>
                                        </div>
                                    </div>
                                    <button @click="followMember(member.id)" class="text-green-600 hover:text-green-700">
                                        <i class="fas fa-user-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Groups Tab --}}
            <div x-show="activeTab === 'groups'" class="space-y-6">
                <div x-show="filteredGroups.length === 0 && globalSearchQuery" class="text-center py-8">
                    <i class="fas fa-layer-group text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-600 text-lg">Tidak ada grup yang ditemukan untuk "<span x-text="globalSearchQuery"></span>"</p>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <template x-for="group in filteredGroups" :key="group.id">
                        <div class="bg-white rounded-2xl shadow-2xl p-6 border-2 border-gray-200 hover:shadow-2xl transition-all duration-300">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-blue-500 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-users text-white text-2xl"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900 text-lg" x-text="group.name"></h3>
                                    <p class="text-gray-600 text-sm" x-text="group.description"></p>
                                    <div class="flex items-center gap-4 mt-2">
                                        <span class="text-sm text-gray-600" x-text="`${group.members} anggota`"></span>
                                        <span x-show="group.isActive" class="text-sm text-green-600 font-bold">• Aktif</span>
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-700 mb-4" x-text="group.description"></p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold" :class="group.status === 'Terbuka' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800'" x-text="group.status"></span>
                                </div>
                                <button @click="joinGroup(group.id)" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors font-bold border-2 border-green-700">
                                    Bergabung
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
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
                    <textarea x-model="newPost.content" placeholder="Apa yang ingin Anda bagikan dengan komunitas?" class="w-full h-32 px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"></textarea>
                    
                    <!-- Upload Progress Bar -->
                    <div x-show="isUploading" class="mb-4">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full transition-all duration-300" :style="`width: ${uploadProgress}%`"></div>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">Uploading... <span x-text="uploadProgress"></span>%</p>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 text-gray-600 hover:text-green-600 transition-colors cursor-pointer">
                            <i class="fas fa-image"></i>
                            <span>Tambah Foto</span>
                            <input type="file" accept="image/*" class="hidden" @change="handleFileUpload($event.target)">
                        </label>
                        <label class="flex items-center gap-2 text-gray-600 hover:text-blue-600 transition-colors cursor-pointer">
                            <i class="fas fa-video"></i>
                            <span>Tambah Video</span>
                            <input type="file" accept="video/*" class="hidden" @change="handleFileUpload($event.target)">
                        </label>
                        <button class="flex items-center gap-2 text-gray-600 hover:text-purple-600 transition-colors">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Tambah Lokasi</span>
                        </button>
                    </div>
                    
                    <!-- File Preview for Modal -->
                    <div x-show="selectedFile" class="mt-4 p-4 bg-gray-50 rounded-xl border-2 border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-file text-blue-500 text-xl"></i>
                                <div>
                                    <p class="font-medium text-gray-900" x-text="selectedFile?.name"></p>
                                    <p class="text-sm text-gray-600" x-text="`${(selectedFile?.size / 1024 / 1024).toFixed(2)} MB`"></p>
                                </div>
                            </div>
                            <button @click="removeSelectedFile()" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <img x-show="selectedFile && selectedFile.type.startsWith('image/')" :src="selectedFile ? URL.createObjectURL(selectedFile) : ''" alt="Preview" class="mt-3 w-full h-32 object-cover rounded-lg">
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button @click="showCreatePost = false; resetNewPost()" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-xl hover:bg-gray-400 transition-colors font-bold border-2 border-gray-400">
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
                        <input x-model="newEvent.title" type="text" placeholder="Masukkan judul event" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea x-model="newEvent.description" placeholder="Jelaskan detail event Anda" class="w-full h-24 px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                            <input x-model="newEvent.date" type="date" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Waktu</label>
                            <input x-model="newEvent.time" type="time" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                        <input x-model="newEvent.location" type="text" placeholder="Masukkan lokasi event" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kapasitas Maksimal</label>
                        <input x-model="newEvent.maxCapacity" type="number" placeholder="Jumlah peserta maksimal" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button @click="showCreateEvent = false; resetNewEvent()" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-xl hover:bg-gray-400 transition-colors font-bold border-2 border-gray-400">
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
            posts: [],
            events: [],
            members: [],
            groups: [],
            filteredPosts: [],
            filteredEvents: [],
            filteredMembers: [],
            filteredGroups: [],
            newPost: {
                content: '',
                image: null,
                video: null,
                location: ''
            },
            newEvent: {
                title: '',
                description: '',
                date: '',
                time: '',
                location: '',
                maxCapacity: ''
            },
            searchQuery: '',
            globalSearchQuery: '',
            selectedFile: null,
            uploadProgress: 0,
            isUploading: false,
            
            init() {
                this.loadInitialData();
                this.setupEventListeners();
            },
            
            loadInitialData() {
                // Load sample data
                this.posts = [
                    {
                        id: 1,
                        author: 'Sarah Johnson',
                        avatar: '{{ asset("asset/img/user_profile.jpg") }}',
                        content: 'Baru saja selesai mengumpulkan sampah plastik di taman kota! Bersama-sama kita bisa membuat lingkungan lebih bersih. 🌱♻️',
                        image: '{{ asset("asset/img/bijak1.jpg") }}',
                        likes: 15,
                        comments: 8,
                        shares: 3,
                        time: '2 jam yang lalu',
                        isOnline: true
                    },
                    {
                        id: 2,
                        author: 'Ahmad Rahman',
                        avatar: '{{ asset("asset/img/user_profile.jpg") }}',
                        content: 'Event bersih-bersih pantai minggu depan! Siapa yang mau ikut? Mari kita jaga kebersihan pantai kita! 🏖️🌊',
                        image: null,
                        likes: 18,
                        comments: 10,
                        shares: 4,
                        time: '5 jam yang lalu',
                        isOnline: false
                    },
                    {
                        id: 3,
                        author: 'Budi Santoso',
                        avatar: '{{ asset("asset/img/user_profile.jpg") }}',
                        content: 'Hasil workshop daur ulang kemarin sangat memuaskan! Berhasil membuat tas dari plastik bekas. Terima kasih komunitas! 🎒♻️',
                        image: '{{ asset("asset/img/bijak2.jpg") }}',
                        likes: 22,
                        comments: 12,
                        shares: 6,
                        time: '1 hari yang lalu',
                        isOnline: true
                    },
                    {
                        id: 4,
                        author: 'Dewi Putri',
                        avatar: '{{ asset("asset/img/user_profile.jpg") }}',
                        content: 'Mengajak anak-anak untuk menanam pohon di sekolah. Pendidikan lingkungan sejak dini sangat penting! 🌳📚',
                        image: '{{ asset("asset/img/bijak3.jpg") }}',
                        likes: 31,
                        comments: 15,
                        shares: 8,
                        time: '2 hari yang lalu',
                        isOnline: false
                    }
                ];
                
                this.events = [
                    {
                        id: 1,
                        title: 'Bersih-bersih Pantai',
                        location: 'Pantai Kuta, Bali',
                        description: 'Ayo bergabung dalam aksi bersih-bersih pantai! Mari kita jaga kebersihan pantai kita bersama-sama.',
                        date: '2024-01-28',
                        time: '08:00',
                        participants: 25,
                        status: 'Minggu Ini',
                        type: 'green'
                    },
                    {
                        id: 2,
                        title: 'Workshop Daur Ulang',
                        location: 'Ruang Komunitas Hijau',
                        description: 'Belajar cara mendaur ulang sampah menjadi barang yang berguna. Workshop gratis untuk semua anggota!',
                        date: '2024-02-15',
                        time: '14:00',
                        participants: 30,
                        status: 'Bulan Depan',
                        type: 'blue'
                    },
                    {
                        id: 3,
                        title: 'Kampanye Anti Plastik',
                        location: 'Mall Central Park',
                        description: 'Kampanye untuk mengurangi penggunaan plastik sekali pakai. Mari kita mulai dari diri sendiri!',
                        date: '2024-02-20',
                        time: '10:00',
                        participants: 45,
                        status: 'Bulan Depan',
                        type: 'green'
                    },
                    {
                        id: 4,
                        title: 'Seminar Lingkungan',
                        location: 'Auditorium Universitas',
                        description: 'Seminar tentang dampak perubahan iklim dan solusi yang bisa kita lakukan bersama.',
                        date: '2024-03-05',
                        time: '19:00',
                        participants: 100,
                        status: 'Maret',
                        type: 'blue'
                    }
                ];

                // Load sample members data
                this.members = [
                    { id: 1, name: 'Sarah Johnson', role: 'Anggota Aktif', rating: 4.8, isOnline: true, avatar: '{{ asset("asset/img/user_profile.jpg") }}' },
                    { id: 2, name: 'Ahmad Rahman', role: 'Moderator', rating: 4.9, isOnline: false, avatar: '{{ asset("asset/img/user_profile.jpg") }}' },
                    { id: 3, name: 'Budi Santoso', role: 'Anggota Aktif', rating: 4.5, isOnline: true, avatar: '{{ asset("asset/img/user_profile.jpg") }}' },
                    { id: 4, name: 'Dewi Putri', role: 'Anggota Aktif', rating: 4.7, isOnline: false, avatar: '{{ asset("asset/img/user_profile.jpg") }}' },
                    { id: 5, name: 'Rina Melati', role: 'Moderator', rating: 4.6, isOnline: true, avatar: '{{ asset("asset/img/user_profile.jpg") }}' },
                    { id: 6, name: 'Joko Widodo', role: 'Anggota Aktif', rating: 4.3, isOnline: false, avatar: '{{ asset("asset/img/user_profile.jpg") }}' },
                    { id: 7, name: 'Siti Nurhaliza', role: 'Anggota Aktif', rating: 4.4, isOnline: true, avatar: '{{ asset("asset/img/user_profile.jpg") }}' },
                    { id: 8, name: 'Agus Setiawan', role: 'Moderator', rating: 4.8, isOnline: false, avatar: '{{ asset("asset/img/user_profile.jpg") }}' }
                ];

                // Load sample groups data
                this.groups = [
                    { id: 1, name: 'Komunitas Hijau Jakarta', description: 'Kelompok peduli lingkungan Jakarta', members: 150, status: 'Terbuka', isActive: true },
                    { id: 2, name: 'Eco Warriors Bali', description: 'Komunitas pelestarian alam Bali', members: 120, status: 'Terbatas', isActive: true },
                    { id: 3, name: 'Green Team Surabaya', description: 'Tim hijau untuk Surabaya yang bersih', members: 200, status: 'Terbuka', isActive: true },
                    { id: 4, name: 'Komunitas Peduli Sampah', description: 'Fokus pada pengelolaan sampah yang baik', members: 180, status: 'Terbatas', isActive: true }
                ];

                // Initialize filtered data
                this.filteredPosts = [...this.posts];
                this.filteredEvents = [...this.events];
                this.filteredMembers = [...this.members];
                this.filteredGroups = [...this.groups];
            },
            
            setupEventListeners() {
                // File upload listeners
                document.addEventListener('change', (e) => {
                    if (e.target.type === 'file') {
                        this.handleFileUpload(e.target);
                    }
                });
                
                // Search functionality
                document.addEventListener('input', (e) => {
                    if (e.target.placeholder === 'Cari anggota...') {
                        this.searchMembers(e.target.value);
                    }
                });
            },
            
            handleFileUpload(input) {
                const file = input.files[0];
                if (file) {
                    // Validasi tipe file
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    const allowedVideoTypes = ['video/mp4', 'video/avi', 'video/mov', 'video/wmv'];
                    
                    if (!allowedTypes.includes(file.type) && !allowedVideoTypes.includes(file.type)) {
                        this.showNotification('Tipe file tidak didukung! Gunakan gambar (JPG, PNG, GIF) atau video (MP4, AVI, MOV)', 'error');
                        input.value = '';
                        return;
                    }
                    
                    // Validasi ukuran file (max 5MB)
                    const maxSize = 5 * 1024 * 1024; // 5MB
                    if (file.size > maxSize) {
                        this.showNotification('Ukuran file terlalu besar! Maksimal 5MB', 'error');
                        input.value = '';
                        return;
                    }
                    
                    this.selectedFile = file;
                    this.showNotification(`File ${file.name} dipilih`, 'info');
                    
                    // Simulate upload progress
                    this.isUploading = true;
                    this.uploadProgress = 0;
                    
                    const interval = setInterval(() => {
                        this.uploadProgress += 10;
                        if (this.uploadProgress >= 100) {
                            clearInterval(interval);
                            this.isUploading = false;
                            this.showNotification('File berhasil diupload!', 'success');
                        }
                    }, 200);
                }
            },
            
            createPost() {
                if (!this.newPost.content.trim()) {
                    this.showNotification('Mohon isi konten post!', 'error');
                    return;
                }
                
                const post = {
                    id: this.posts.length + 1,
                    author: 'Sarah Johnson',
                    avatar: '{{ asset("asset/img/user_profile.jpg") }}',
                    content: this.newPost.content,
                    image: this.selectedFile ? URL.createObjectURL(this.selectedFile) : null,
                    likes: 0,
                    comments: 0,
                    shares: 0,
                    time: 'Baru saja',
                    isOnline: true,
                    isNew: true // Menandai post baru
                };
                
                // Tambahkan post baru ke array posts dan filteredPosts
                this.posts.unshift(post);
                this.filteredPosts.unshift(post);
                
                this.resetNewPost();
                this.showCreatePost = false;
                this.showNotification('Post berhasil dibuat! Post Anda muncul di timeline.', 'success');
            },
            
            createEvent() {
                if (!this.newEvent.title.trim() || !this.newEvent.description.trim()) {
                    this.showNotification('Mohon isi judul dan deskripsi event!', 'error');
                    return;
                }
                
                const event = {
                    id: this.events.length + 1,
                    title: this.newEvent.title,
                    location: this.newEvent.location,
                    description: this.newEvent.description,
                    date: this.newEvent.date,
                    time: this.newEvent.time,
                    participants: 0,
                    status: 'Baru',
                    type: 'green',
                    isNew: true // Menandai event baru
                };
                
                // Tambahkan event baru ke array events dan filteredEvents
                this.events.unshift(event);
                this.filteredEvents.unshift(event);
                
                this.resetNewEvent();
                this.showCreateEvent = false;
                this.showNotification('Event berhasil dibuat! Klik tab Events untuk melihat event Anda.', 'success');
                
                // Otomatis pindah ke tab Events setelah 2 detik
                setTimeout(() => {
                    this.activeTab = 'events';
                }, 2000);
            },
            
            resetNewPost() {
                this.newPost = {
                    content: '',
                    image: null,
                    video: null,
                    location: ''
                };
                this.selectedFile = null;
                this.uploadProgress = 0;
                this.isUploading = false;
                
                // Reset file input
                const fileInputs = document.querySelectorAll('input[type="file"]');
                fileInputs.forEach(input => {
                    if (input.closest('.bg-white.rounded-2xl')) {
                        input.value = '';
                    }
                });
            },
            
            resetNewEvent() {
                this.newEvent = {
                    title: '',
                    description: '',
                    date: '',
                    time: '',
                    location: '',
                    maxCapacity: ''
                };
            },
            
            likePost(postId) {
                const post = this.posts.find(p => p.id === postId);
                if (post) {
                    post.likes++;
                    this.showNotification('Post disukai!', 'success');
                }
            },
            
            commentPost(postId) {
                const comment = prompt('Tulis komentar Anda:');
                if (comment && comment.trim()) {
                    const post = this.posts.find(p => p.id === postId);
                    if (post) {
                        post.comments++;
                        this.showNotification('Komentar berhasil ditambahkan!', 'success');
                    }
                }
            },
            
            sharePost(postId) {
                const post = this.posts.find(p => p.id === postId);
                if (post) {
                    post.shares++;
                    this.showNotification('Post dibagikan!', 'success');
                }
            },
            
            bookmarkPost(postId) {
                this.showNotification('Post disimpan ke bookmark!', 'success');
            },
            
            joinEvent(eventId) {
                const event = this.events.find(e => e.id === eventId);
                if (event) {
                    event.participants++;
                    this.showNotification('Berhasil mendaftar event!', 'success');
                }
            },
            
            joinGroup(groupId) {
                this.showNotification('Berhasil bergabung dengan grup!', 'success');
            },
            
            followMember(memberId) {
                this.showNotification('Berhasil mengikuti anggota!', 'success');
            },
            
            searchMembers(query) {
                this.searchQuery = query;
                if (!query.trim()) {
                    this.filteredMembers = [...this.members];
                    return;
                }
                
                const searchTerm = query.toLowerCase();
                this.filteredMembers = this.members.filter(member => 
                    member.name.toLowerCase().includes(searchTerm) ||
                    member.role.toLowerCase().includes(searchTerm)
                );
                
                this.showNotification(`Ditemukan ${this.filteredMembers.length} anggota`, 'info');
            },

            searchPosts(query) {
                if (!query.trim()) {
                    this.filteredPosts = [...this.posts];
                    return;
                }
                
                const searchTerm = query.toLowerCase();
                this.filteredPosts = this.posts.filter(post => 
                    post.author.toLowerCase().includes(searchTerm) ||
                    post.content.toLowerCase().includes(searchTerm)
                );
            },

            searchEvents(query) {
                if (!query.trim()) {
                    this.filteredEvents = [...this.events];
                    return;
                }
                
                const searchTerm = query.toLowerCase();
                this.filteredEvents = this.events.filter(event => 
                    event.title.toLowerCase().includes(searchTerm) ||
                    event.location.toLowerCase().includes(searchTerm) ||
                    event.description.toLowerCase().includes(searchTerm)
                );
            },

            searchGroups(query) {
                if (!query.trim()) {
                    this.filteredGroups = [...this.groups];
                    return;
                }
                
                const searchTerm = query.toLowerCase();
                this.filteredGroups = this.groups.filter(group => 
                    group.name.toLowerCase().includes(searchTerm) ||
                    group.description.toLowerCase().includes(searchTerm)
                );
            },

            performSearch(query) {
                this.searchPosts(query);
                this.searchEvents(query);
                this.searchMembers(query);
                this.searchGroups(query);
            },

            clearSearch() {
                this.globalSearchQuery = '';
                this.searchQuery = '';
                this.filteredPosts = [...this.posts];
                this.filteredEvents = [...this.events];
                this.filteredMembers = [...this.members];
                this.filteredGroups = [...this.groups];
                this.showNotification('Pencarian dibersihkan', 'info');
            },

            removeSelectedFile() {
                this.selectedFile = null;
                this.uploadProgress = 0;
                this.isUploading = false;
                
                // Reset file inputs
                const fileInputs = document.querySelectorAll('input[type="file"]');
                fileInputs.forEach(input => {
                    input.value = '';
                });
                
                this.showNotification('File dihapus', 'info');
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
    </script>
@endsection 