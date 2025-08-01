@extends('layouts.app')

@section('content')
<style>
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
    
    .main-content-transition {
        transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>

<div class="flex min-h-screen bg-gray-50">

    {{-- Sidebar dengan hover effect --}}
    <aside 
        x-data="{ open: false, active: 'pesan' }" 
        @mouseenter="open = true" 
        @mouseleave="open = false"
        class="fixed top-0 left-0 h-full z-20 flex flex-col py-6 
               sidebar-hover overflow-hidden shadow-2xl group sidebar-gradient" 
        :class="open ? 'w-64' : 'w-16'"
    >
        <div class="relative flex flex-col h-full w-full px-4">
            
            {{-- Logo Section --}}
            <div class="flex items-center justify-center mb-8 mt-2">
                <img x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                     class="w-24 h-auto" src="{{ asset('asset/img/logo_full.png') }}" alt="Logo Penuh">
                <img x-show="!open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                     class="w-6 h-6" src="{{ asset('asset/img/logo_icon.png') }}" alt="Logo Ikon">
            </div>
            
            {{-- Navigation Menu --}}
            <nav class="flex flex-col gap-2 w-full flex-1">
                {{-- Dashboard Link --}}
                <a 
                    href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 p-3 rounded-lg font-medium sidebar-item-hover
                           whitespace-nowrap w-full" 
                    :class="open ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white justify-center'"
                >
                    <i class="fas fa-home text-lg"></i>
                    <span x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                          class="text-sm font-medium">Dashboard</span>
                </a>
                
                {{-- Bank Sampah Link --}}
                <a 
                    href="{{ route('bank-sampah') }}"
                    class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full"
                    :class="open ? (active === 'bank-sampah' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : 
                                   (active === 'bank-sampah' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')"
                >
                    <i class="fas fa-tachometer-alt text-lg"></i>
                    <span x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                          class="text-sm font-medium">Bank Sampah</span>
                </a>
                
                {{-- Toko Link --}}
                <a 
                    href="{{ route('toko') }}"
                    class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full"
                    :class="open ? (active === 'toko' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : 
                                   (active === 'toko' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')"
                >
                    <i class="fas fa-store text-lg"></i>
                    <span x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                          class="text-sm font-medium">Toko</span>
                </a>
                
                {{-- Komunitas Link --}}
                <a 
                    href="{{ route('komunitas') }}"
                    class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full"
                    :class="open ? (active === 'komunitas' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : 
                                   (active === 'komunitas' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')"
                >
                    <i class="fas fa-users text-lg"></i>
                    <span x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                          class="text-sm font-medium">Komunitas</span>
                </a>
                
                {{-- Berita Link --}}
                <a 
                    href="{{ route('berita') }}"
                    class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full"
                    :class="open ? (active === 'berita' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : 
                                   (active === 'berita' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')"
                >
                    <i class="fas fa-newspaper text-lg"></i>
                    <span x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                          class="text-sm font-medium">Berita</span>
                </a>
                
                {{-- Keuangan Link --}}
                <a 
                    href="{{ route('keuangan') }}"
                    class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full"
                    :class="open ? (active === 'keuangan' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : 
                                   (active === 'keuangan' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')"
                >
                    <i class="fas fa-file-invoice-dollar text-lg"></i>
                    <span x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                          class="text-sm font-medium">Keuangan</span>
                </a>
                
                {{-- Pesan Link --}}
                <a 
                    href="{{ route('pesan') }}"
                    class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full"
                    :class="open ? (active === 'pesan' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : 
                                   (active === 'pesan' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')"
                >
                    <i class="fas fa-comment-dots text-lg"></i>
                    <span x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                          class="text-sm font-medium">Pesan</span>
                </a>
                
                {{-- Umpan Balik Link --}}
                <a 
                    href="{{ route('umpan-balik') }}"
                    class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full"
                    :class="open ? (active === 'umpan-balik' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : 
                                   (active === 'umpan-balik' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')"
                >
                    <i class="fas fa-info-circle text-lg"></i>
                    <span x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                          class="text-sm font-medium">Umpan Balik</span>
                </a>
                
                {{-- Settings Link --}}
                <a 
                    href="{{ route('settings') }}"
                    class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full"
                    :class="open ? (active === 'settings' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : 
                                   (active === 'settings' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')"
                >
                    <i class="fas fa-cog text-lg"></i>
                    <span x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                          class="text-sm font-medium">Settings</span>
                </a>
            </nav>
            
            {{-- Logout Section --}}
            <div class="w-full flex items-center py-3 mt-auto">
                <a href="{{ route('logout') }}" class="flex items-center gap-3 text-white hover:text-red-300 transition-all duration-200 w-full whitespace-nowrap sidebar-item-hover"
                   :class="open ? '' : 'justify-center'">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                    <span x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                          class="text-sm font-medium">Logout</span>
                </a>
            </div>
            
        </div>
    </aside>

    {{-- Main Content Area --}}
    <div class="flex-1 bg-white relative" 
         :class="open ? 'ml-64' : 'ml-16'"
         style="min-height: 100vh;">
        
        {{-- Top Header Bar --}}
        <div class="bg-gray-800 h-12 flex items-center justify-between px-6 w-full">
            <h1 class="text-white font-semibold text-lg">Pesan</h1>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('notifikasi') }}" class="relative">
                    <i class="far fa-bell text-white text-sm"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-medium">2</span>
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
        <div class="p-8 w-full">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Pesan</h1>
                <p class="text-gray-600 mt-2">Halaman Pesan - Coming Soon</p>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-center py-12">
                    <i class="fas fa-comment-dots text-6xl text-gray-300 mb-4"></i>
                    <h2 class="text-2xl font-semibold text-gray-700 mb-2">Pesan</h2>
                    <p class="text-gray-500">Fitur pesan akan segera hadir!</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 