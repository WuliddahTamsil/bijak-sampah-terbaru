@extends('layouts.app')

@section('content')
<style>
    html, body { 
        overflow-x: hidden; 
        margin: 0;
        padding: 0;
        scroll-behavior: smooth;
    }
    .sidebar-gradient { background: var(--sidebar-gradient); }
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
        padding: 0 1.5rem; background: var(--sidebar-gradient);
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
    
    .modal-overlay {
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }
    
    .success-popup {
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    .file-input-wrapper {
        position: relative;
        display: inline-block;
    }
    
    .file-input-wrapper input[type=file] {
        position: absolute;
        left: -9999px;
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
        x-data="{ open: false, active: 'profile' }"
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
                <a href="/dashboard" class="flex items-center gap-3 p-3 font-medium sidebar-nav-item whitespace-nowrap w-full" :class="open ? (active === 'dashboard' ? 'active text-white' : 'text-white') : (active === 'dashboard' ? 'active text-white justify-center' : 'text-white justify-center')">
                    <i class="fas fa-home text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Dashboard</span>
                </a>
                
                {{-- Bank Sampah Link --}}
                <a href="/bank-sampah" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'bank-sampah' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'bank-sampah' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-balance-scale text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Bank Sampah</span>
                </a>
                
                {{-- Toko Link --}}
                <a href="/toko" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'toko' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'toko' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-store text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Toko</span>
                </a>
                
                {{-- Komunitas Link --}}
                <a href="/komunitas" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'komunitas' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'komunitas' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-users text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Komunitas</span>
                </a>
                
                {{-- Berita Link --}}
                <a href="/berita" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'berita' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'berita' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-newspaper text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Berita</span>
                </a>
                
                {{-- Keuangan Link --}}
                <a href="/keuangan" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'keuangan' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'keuangan' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-file-invoice-dollar text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Keuangan</span>
                </a>
                
                {{-- Pesan Link --}}
                <a href="/chat" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'chat' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'chat' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-comment-dots text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Pesan</span>
                </a>
                
                {{-- Umpan Balik Link --}}
                <a href="/feedback" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'feedback' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'feedback' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-info-circle text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Umpan Balik</span>
                </a>
                
                {{-- Settings Link --}}
                <a href="/settings" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'settings' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'settings' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-cog text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Settings</span>
                </a>
            </nav>
            
            {{-- Logout Section --}}
            <div class="w-full flex items-center py-3 mt-auto">
                <a href="/logout" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover text-white hover:text-red-300 transition-all duration-200 w-full whitespace-nowrap" :class="open ? (active === 'logout' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'logout' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
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
                <a href="/notifikasi" class="relative">
                    <i class="far fa-bell text-white text-sm"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-medium">2</span>
                </a>
                <button class="focus:outline-none">
                    <i class="fas fa-search text-white text-sm"></i>
                </button>
                <div class="flex items-center gap-2">
                    <a href="/profile" class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center border-2 border-gray-300">
                        <img :src="savedProfileImage || '{{ asset('asset/img/user_profile.jpg') }}'" alt="Profile" class="w-full h-full object-cover">
                    </a>
                    <i class="fas fa-chevron-down text-white text-xs"></i>
                </div>
            </div>
        </div>
        
        {{-- Content Container --}}
        <div class="content-container" x-data="{ 
            edit: false, 
            passwordFieldType: 'password',
            showSuccessPopup: false,
            profileData: {
                fullName: 'Putri Cantika',
                shortName: 'Putri',
                email: 'putricantika@gmail.com',
                phone: '087806181962',
                gender: 'Perempuan',
                umkmName: 'UMKM ASIK',
                umkmAddress: 'Lodaya II, Bogor',
                password: 'passworddummy'
            },
            newPassword: '',
            confirmPassword: '',
            profileImage: null,
            imagePreview: null,
            savedProfileImage: null
        }">
            
            {{-- Success Popup --}}
            <div x-show="showSuccessPopup" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-50 flex items-center justify-center modal-overlay">
                <div class="bg-white rounded-lg p-6 shadow-xl success-popup max-w-sm w-full mx-4">
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">Berhasil!</h3>
                    <p class="text-gray-600 text-center mb-4">Data profil berhasil diperbarui.</p>
                    <button @click="showSuccessPopup = false" 
                            class="w-full bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg font-medium transition">
                        Tutup
                    </button>
                </div>
            </div>
            
            {{-- Profile Title --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Profil</h1>
            </div>

            {{-- Profile Header Section --}}
            <div class="relative w-full h-32 rounded-lg mb-8 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-[#B6D0E2] to-[#F7EEDD]"></div>
                <div class="absolute inset-0 flex items-center p-6">
                    <div class="relative">
                        <img :src="savedProfileImage || imagePreview || '{{ asset('asset/img/user_profile.jpg') }}'" 
                             class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-lg" 
                             alt="Profile">
                        <div x-show="edit" class="file-input-wrapper">
                            <label class="absolute bottom-0 right-0 bg-blue-500 hover:bg-blue-600 text-white rounded-full p-1 cursor-pointer transition">
                                <i class="fas fa-camera text-xs"></i>
                            </label>
                            <input type="file" 
                                   @change="
                                       const file = $event.target.files[0];
                                       if (file) {
                                           console.log('File selected:', file.name);
                                           profileImage = file;
                                           const reader = new FileReader();
                                           reader.onload = function(e) {
                                               console.log('File loaded successfully');
                                               imagePreview = e.target.result;
                                               savedProfileImage = e.target.result;
                                               console.log('Image preview set');
                                           };
                                           reader.onerror = function() {
                                               console.error('Error reading file');
                                           };
                                           reader.readAsDataURL(file);
                                       }
                                   "
                                   accept="image/*" 
                                   class="hidden">
                        </div>
                    </div>
                    <div class="ml-6">
                        <h2 class="text-2xl font-bold text-gray-800" x-show="!edit" x-text="profileData.fullName"></h2>
                        <input x-show="edit" 
                               type="text" 
                               x-model="profileData.fullName"
                               class="text-2xl font-bold text-gray-800 bg-transparent border-b border-gray-300 focus:outline-none focus:border-blue-500">
                        <p class="text-blue-600 mt-1" x-show="!edit" x-text="profileData.email"></p>
                        <input x-show="edit" 
                               type="email" 
                               x-model="profileData.email"
                               class="text-blue-600 bg-transparent border-b border-gray-300 focus:outline-none focus:border-blue-500 mt-1">
                    </div>
                    
                    <button 
                        class="ml-auto bg-[#4285F4] hover:bg-[#357ae8] text-white px-6 py-2 rounded-lg font-semibold transition"
                        x-show="!edit"
                        @click="edit = true"
                        type="button"
                    >Edit</button>
                    <div class="flex gap-2 ml-auto" x-show="edit">
                        <button 
                            class="bg-[#34A853] hover:bg-[#2e944d] text-white px-4 py-2 rounded-lg font-semibold transition"
                            type="button"
                            @click="
                                edit = false;
                                showSuccessPopup = true;
                                setTimeout(() => showSuccessPopup = false, 3000);
                            "
                        >Simpan</button>
                        <button 
                            class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg font-semibold transition"
                            type="button"
                            @click="
                                edit = false;
                                profileData = {
                                    fullName: 'Putri Cantika',
                                    shortName: 'Putri',
                                    email: 'putricantika@gmail.com',
                                    phone: '087806181962',
                                    gender: 'Perempuan',
                                    umkmName: 'UMKM ASIK',
                                    umkmAddress: 'Lodaya II, Bogor',
                                    password: 'passworddummy'
                                };
                                newPassword = '';
                                confirmPassword = '';
                                profileImage = null;
                                imagePreview = null;
                                savedProfileImage = null;
                            "
                        >Batal</button>
                    </div>
                </div>
            </div>

            {{-- Profile Form --}}
            <form @submit.prevent="
                edit = false;
                showSuccessPopup = true;
                setTimeout(() => showSuccessPopup = false, 3000);
            ">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                        <input :readonly="!edit" 
                               type="text" 
                               x-model="profileData.fullName"
                               class="w-full bg-white text-gray-900 rounded-lg px-4 py-3 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4">
                        
                        <label class="block text-gray-700 font-semibold mb-2">Gender</label>
                        <div class="relative">
                            <select :disabled="!edit" 
                                    x-model="profileData.gender"
                                    class="w-full bg-white text-gray-900 rounded-lg px-4 py-3 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4 appearance-none">
                                <option value="Perempuan">Perempuan</option>
                                <option value="Laki-laki">Laki-laki</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" x-show="edit"></i>
                        </div>

                        <label class="block text-gray-700 font-semibold mb-2">No. Telepon/Email</label>
                        <input :readonly="!edit" 
                               type="text" 
                               x-model="profileData.phone"
                               class="w-full bg-white text-gray-900 rounded-lg px-4 py-3 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Nama Pendek</label>
                        <input :readonly="!edit" 
                               type="text" 
                               x-model="profileData.shortName"
                               class="w-full bg-white text-gray-900 rounded-lg px-4 py-3 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4">
                        
                        <label class="block text-gray-700 font-semibold mb-2">Nama UMKM</label>
                        <input :readonly="!edit" 
                               type="text" 
                               x-model="profileData.umkmName"
                               class="w-full bg-white text-gray-900 rounded-lg px-4 py-3 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4">
                        
                        <label class="block text-gray-700 font-semibold mb-2">Alamat UMKM</label>
                        <input :readonly="!edit" 
                               type="text" 
                               x-model="profileData.umkmAddress"
                               class="w-full bg-white text-gray-900 rounded-lg px-4 py-3 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Alamat e-mail saya</label>
                        <div class="flex items-center gap-4 bg-white rounded-lg p-4 mb-2 shadow-sm border border-gray-200">
                            <span class="bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center"><i class="fas fa-envelope"></i></span>
                            <div>
                                <div class="text-gray-800" x-text="profileData.email"></div>
                                <div class="text-gray-400 text-xs">1 bulan yang lalu</div>
                            </div>
                        </div>
                        <button class="text-blue-500 font-semibold flex items-center gap-2 hover:text-blue-700 transition" type="button"><i class="fas fa-plus"></i> Tambah alamat email</button>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Password Anda</label>
                        <div class="relative">
                            <input 
                                :readonly="!edit" 
                                :type="edit ? passwordFieldType : 'password'" 
                                :value="edit ? profileData.password : '••••••••'"
                                class="w-full bg-white text-gray-900 rounded-lg px-4 py-3 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10"
                            >
                            <button 
                                type="button" 
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 focus:outline-none"
                                @click="passwordFieldType = (passwordFieldType === 'password' ? 'text' : 'password')"
                                x-show="edit"
                            >
                                <i class="fas" :class="passwordFieldType === 'password' ? 'fa-eye' : 'fa-eye-slash'"></i>
                            </button>
                        </div>
                        
                        {{-- Password Change Section --}}
                        <div x-show="edit" class="mt-4 space-y-3">
                            <div>
                                <label class="block text-gray-700 font-medium mb-1 text-sm">Password Baru</label>
                                <input type="password" 
                                       x-model="newPassword"
                                       placeholder="Masukkan password baru"
                                       class="w-full bg-white text-gray-900 rounded-lg px-3 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-1 text-sm">Konfirmasi Password</label>
                                <input type="password" 
                                       x-model="confirmPassword"
                                       placeholder="Konfirmasi password baru"
                                       class="w-full bg-white text-gray-900 rounded-lg px-3 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>
                            <div x-show="newPassword && confirmPassword && newPassword !== confirmPassword" 
                                 class="text-red-500 text-xs">
                                Password tidak cocok!
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
