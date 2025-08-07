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
    
    /* Sidebar alignment fixes */
    .sidebar-nav-item {
        justify-content: flex-start !important;
        text-align: left !important;
    }
    
    .sidebar-nav-item.justify-center {
        justify-content: center !important;
    }
    
    .sidebar-nav-item.justify-start {
        justify-content: flex-start !important;
    }
    
    .settings-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    .settings-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }
    
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 24px; }
    .slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; }
    input:checked + .slider { background-color: #10B981; }
    input:checked + .slider:before { transform: translateX(26px); }
    
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

<div class="flex min-h-screen bg-gray-50">
    {{-- Sidebar --}}
    <aside
        id="sidebar"
        class="fixed top-0 left-0 z-50 flex flex-col py-6 sidebar-hover overflow-hidden shadow-2xl group sidebar-gradient w-16"
        style="transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); margin-top: 48px; height: calc(100vh - 48px);"
    >
        <div class="relative flex flex-col h-full w-full px-4">
            {{-- Logo Section --}}
            <div class="flex items-center justify-center mb-8 mt-2 sidebar-logo">
                <img id="logoFull" class="w-32 h-auto hidden" src="{{ asset('asset/img/logo1.png') }}" alt="Logo Penuh">
                <img id="logoIcon" class="w-6 h-6" src="{{ asset('asset/img/logo.png') }}" alt="Logo Ikon">
            </div>
            
            {{-- Navigation Menu --}}
            <nav class="flex flex-col gap-2 w-full flex-1">
                {{-- Dashboard Link --}}
                <a href="/dashboard" class="flex items-center gap-3 p-3 font-medium sidebar-nav-item whitespace-nowrap w-full text-white justify-center">
                    <i class="fas fa-home text-lg"></i>
                    <span id="dashboardText" class="text-sm font-medium hidden">Dashboard</span>
                </a>
                
                {{-- Bank Sampah Link --}}
                <a href="/bank-sampah" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover sidebar-nav-item whitespace-nowrap w-full text-white justify-center">
                    <i class="fas fa-balance-scale text-lg"></i>
                    <span id="bankSampahText" class="text-sm font-medium hidden">Bank Sampah</span>
                </a>
                
                {{-- Toko Link --}}
                <a href="/toko" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover sidebar-nav-item whitespace-nowrap w-full text-white justify-center">
                    <i class="fas fa-store text-lg"></i>
                    <span id="tokoText" class="text-sm font-medium hidden">Toko</span>
                </a>
                
                {{-- Komunitas Link --}}
                <a href="/komunitas" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover sidebar-nav-item whitespace-nowrap w-full text-white justify-center">
                    <i class="fas fa-users text-lg"></i>
                    <span id="komunitasText" class="text-sm font-medium hidden">Komunitas</span>
                </a>
                
                {{-- Berita Link --}}
                <a href="/berita" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover sidebar-nav-item whitespace-nowrap w-full text-white justify-center">
                    <i class="fas fa-newspaper text-lg"></i>
                    <span id="beritaText" class="text-sm font-medium hidden">Berita</span>
                </a>
                
                {{-- Keuangan Link --}}
                <a href="/keuangan" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover sidebar-nav-item whitespace-nowrap w-full text-white justify-center">
                    <i class="fas fa-file-invoice-dollar text-lg"></i>
                    <span id="keuanganText" class="text-sm font-medium hidden">Keuangan</span>
                </a>
                
                {{-- Pesan Link --}}
                <a href="/chat" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover sidebar-nav-item whitespace-nowrap w-full text-white justify-center">
                    <i class="fas fa-comment-dots text-lg"></i>
                    <span id="pesanText" class="text-sm font-medium hidden">Pesan</span>
                </a>
                
                {{-- Umpan Balik Link --}}
                <a href="/feedback" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover sidebar-nav-item whitespace-nowrap w-full text-white justify-center">
                    <i class="fas fa-info-circle text-lg"></i>
                    <span id="feedbackText" class="text-sm font-medium hidden">Umpan Balik</span>
                </a>
                
                {{-- Settings Link --}}
                <a href="/settings" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover sidebar-nav-item whitespace-nowrap w-full bg-white/20 text-white shadow-lg justify-center">
                    <i class="fas fa-cog text-lg"></i>
                    <span id="settingsText" class="text-sm font-medium hidden">Settings</span>
                </a>
            </nav>
            
            {{-- Logout Section --}}
            <div class="w-full flex items-center py-3 mt-auto">
                <a href="/logout" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover sidebar-nav-item text-white hover:text-red-300 transition-all duration-200 w-full whitespace-nowrap justify-center">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                    <span id="logoutText" class="text-sm font-medium hidden">Logout</span>
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
                        <img src="{{ asset('asset/img/user_profile.jpg') }}" alt="Profile" class="w-full h-full object-cover">
                    </a>
                        <i class="fas fa-chevron-down text-white text-xs"></i>
                </div>
            </div>
        </div>
        
        {{-- Content Container --}}
        <div class="content-container">
            {{-- Settings Title --}}
            <div class="mb-8 text-content">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Pengaturan Aplikasi ⚙️</h1>
                <p class="text-gray-600 text-lg">Kelola pengaturan akun dan aplikasi Anda</p>
            </div>
            
            {{-- Settings Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Account Settings --}}
                <div class="settings-card p-6 text-content">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Akun</h3>
                            <p class="text-sm text-gray-600">Kelola informasi akun Anda</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900">Ubah Profil</h4>
                                <p class="text-sm text-gray-600">Perbarui informasi profil Anda</p>
                            </div>
                            <a href="/profile" class="text-blue-600 hover:text-blue-700 font-medium">
                                <span>Ubah</span>
                            </a>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900">Ubah Password</h4>
                                <p class="text-sm text-gray-600">Perbarui kata sandi akun</p>
                            </div>
                            <button class="text-blue-600 hover:text-blue-700 font-medium" onclick="alert('Fitur ubah password akan segera tersedia!')">
                                <span>Ubah</span>
                            </button>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <div>
                                <h4 class="font-medium text-gray-900">Verifikasi Email</h4>
                                <p class="text-sm text-gray-600">Konfirmasi alamat email Anda</p>
                            </div>
                            <span class="text-green-600 text-sm font-medium">Terverifikasi</span>
                        </div>
                    </div>
                </div>
                
                {{-- Notification Settings --}}
                <div class="settings-card p-6 text-content">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-bell text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Notifikasi</h3>
                            <p class="text-sm text-gray-600">Kelola pengaturan notifikasi</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900">Email Notifikasi</h4>
                                <p class="text-sm text-gray-600">Dapatkan notifikasi melalui email</p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" data-setting="email-notifications">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900">Push Notifikasi</h4>
                                <p class="text-sm text-gray-600">Dapatkan notifikasi melalui aplikasi</p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" data-setting="push-notifications">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <div>
                                <h4 class="font-medium text-gray-900">SMS Notifikasi</h4>
                                <p class="text-sm text-gray-600">Dapatkan notifikasi melalui SMS</p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" data-setting="sms-notifications">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                </div>
                
                {{-- Privacy Settings --}}
                <div class="settings-card p-6 text-content">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-shield-alt text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Privasi</h3>
                            <p class="text-sm text-gray-600">Kelola pengaturan privasi akun Anda</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900">Tampilan Profil</h4>
                                <p class="text-sm text-gray-600">Kontrol siapa yang dapat melihat profil Anda</p>
                            </div>
                            <select data-setting="profile-visibility" class="text-sm border border-gray-300 rounded px-2 py-1">
                                <option value="public">Publik</option>
                                <option value="friends">Teman</option>
                                <option value="private">Pribadi</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900">Berbagi Data</h4>
                                <p class="text-sm text-gray-600">Izinkan aplikasi untuk berbagi data Anda</p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" data-setting="data-sharing">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <div>
                                <h4 class="font-medium text-gray-900">Berbagi Lokasi</h4>
                                <p class="text-sm text-gray-600">Izinkan aplikasi untuk menggunakan lokasi Anda</p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" data-setting="location-sharing">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                </div>
                
                {{-- Appearance Settings --}}
                <div class="settings-card p-6 text-content">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-palette text-orange-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Penampilan</h3>
                            <p class="text-sm text-gray-600">Kelola tampilan dan preferensi bahasa</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900">Tema</h4>
                                <p class="text-sm text-gray-600">Pilih tema gelap atau terang</p>
                            </div>
                            <select data-setting="theme" class="text-sm border border-gray-300 rounded px-2 py-1">
                                <option value="light">Terang</option>
                                <option value="dark">Gelap</option>
                                <option value="auto">Auto</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900">Bahasa</h4>
                                <p class="text-sm text-gray-600">Pilih bahasa aplikasi</p>
                            </div>
                            <select data-setting="language" class="text-sm border border-gray-300 rounded px-2 py-1">
                                <option value="id">Indonesia</option>
                                <option value="en">English</option>
                                <option value="ja">日本語</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <div>
                                <h4 class="font-medium text-gray-900">Ukuran Huruf</h4>
                                <p class="text-sm text-gray-600">Pilih ukuran huruf aplikasi</p>
                            </div>
                            <select data-setting="font-size" class="text-sm border border-gray-300 rounded px-2 py-1">
                                <option value="small">Kecil</option>
                                <option value="medium">Sedang</option>
                                <option value="large">Besar</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                {{-- Data & Storage --}}
                <div class="settings-card p-6 text-content">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-database text-red-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Data & Penyimpanan</h3>
                            <p class="text-sm text-gray-600">Kelola data dan cache aplikasi</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900">Cache</h4>
                                <p class="text-sm text-gray-600">Membersihkan cache aplikasi</p>
                            </div>
                            <button class="text-blue-600 hover:text-blue-700 font-medium" data-action="clear-cache">
                                <span>Bersihkan</span>
                            </button>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900">Unduh Data</h4>
                                <p class="text-sm text-gray-600">Unduh data pengaturan aplikasi</p>
                            </div>
                            <button class="text-blue-600 hover:text-blue-700 font-medium" data-action="download-data">
                                <span>Unduh</span>
                            </button>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <div>
                                <h4 class="font-medium text-gray-900">Hapus Akun</h4>
                                <p class="text-sm text-gray-600">Hapus akun dan data Anda</p>
                            </div>
                            <button class="text-red-600 hover:text-red-700 font-medium" data-action="delete-account">
                                <span>Hapus</span>
                            </button>
                        </div>
                    </div>
                </div>
                
                {{-- Help & Support --}}
                <div class="settings-card p-6 text-content">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-question-circle text-yellow-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Bantuan & Dukungan</h3>
                            <p class="text-sm text-gray-600">Dapatkan bantuan dan dukungan</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900">FAQ</h4>
                                <p class="text-sm text-gray-600">Pertanyaan yang sering ditanyakan</p>
                            </div>
                            <a href="#" class="text-blue-600 hover:text-blue-700 font-medium" data-action="faq-link">
                                <span>Buka</span>
                            </a>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900">Hubungi Kami</h4>
                                <p class="text-sm text-gray-600">Hubungi tim dukungan kami</p>
                            </div>
                            <a href="#" class="text-blue-600 hover:text-blue-700 font-medium" data-action="contact-link">
                                <span>Hubungi</span>
                            </a>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <div>
                                <h4 class="font-medium text-gray-900">Tentang</h4>
                                <p class="text-sm text-gray-600">Versi aplikasi dan informasi lebih lanjut</p>
                            </div>
                            <span class="text-gray-500 text-sm">v1.0.0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Initialize settings page
document.addEventListener('DOMContentLoaded', function() {
    // Wait for global settings to be available
    function initializeSettingsPage() {
        console.log('Initializing settings page...');
        
        // Apply initial settings using global function
        if (window.applyGlobalSettings) {
            window.applyGlobalSettings();
        }
        
        // Toggle switches functionality
        const toggles = document.querySelectorAll('.toggle-switch input');
        toggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const settingName = this.getAttribute('data-setting');
                if (settingName) {
                    if (window.saveSettings) {
                        window.saveSettings(settingName, this.checked);
                    } else {
                        localStorage.setItem(settingName, this.checked);
                    }
                }
            });
        });

        // Theme selector functionality
        const themeSelect = document.querySelector('select[data-setting="theme"]');
        if (themeSelect) {
            const currentTheme = window.globalSettings?.theme || localStorage.getItem('theme') || 'light';
            themeSelect.value = currentTheme;
            console.log('Theme select initialized with value:', currentTheme);
            
            themeSelect.addEventListener('change', function() {
                console.log('Theme changed to:', this.value);
                if (window.saveSettings) {
                    window.saveSettings('theme', this.value);
                } else {
                    localStorage.setItem('theme', this.value);
                    if (window.applyGlobalSettings) {
                        window.applyGlobalSettings();
                    }
                }
            });
        }

        // Language selector functionality
        const languageSelect = document.querySelector('select[data-setting="language"]');
        if (languageSelect) {
            const currentLanguage = window.globalSettings?.language || localStorage.getItem('language') || 'id';
            languageSelect.value = currentLanguage;
            console.log('Language select initialized with value:', currentLanguage);
            
            languageSelect.addEventListener('change', function() {
                console.log('Language changed to:', this.value);
                if (window.saveSettings) {
                    window.saveSettings('language', this.value);
                } else {
                    localStorage.setItem('language', this.value);
                }
                // Show message that language change will take effect on next page load
                alert('Perubahan bahasa akan diterapkan pada halaman berikutnya.');
            });
        }

        // Font size selector functionality
        const fontSizeSelect = document.querySelector('select[data-setting="font-size"]');
        if (fontSizeSelect) {
            const currentFontSize = window.globalSettings?.fontSize || localStorage.getItem('fontSize') || 'medium';
            fontSizeSelect.value = currentFontSize;
            console.log('Font size select initialized with value:', currentFontSize);
            
            fontSizeSelect.addEventListener('change', function() {
                console.log('Font size changed to:', this.value);
                if (window.saveSettings) {
                    window.saveSettings('fontSize', this.value);
                } else {
                    localStorage.setItem('fontSize', this.value);
                    if (window.applyGlobalSettings) {
                        window.applyGlobalSettings();
                    }
                }
            });
        }

        // Clear cache functionality
        const clearCacheBtn = document.querySelector('[data-action="clear-cache"]');
        if (clearCacheBtn) {
            clearCacheBtn.addEventListener('click', function() {
                if (confirm('Apakah Anda yakin ingin membersihkan cache?')) {
                    localStorage.clear();
                    alert('Cache berhasil dibersihkan!');
                    location.reload();
                }
            });
        }

        // Download data functionality
        const downloadDataBtn = document.querySelector('[data-action="download-data"]');
        if (downloadDataBtn) {
            downloadDataBtn.addEventListener('click', function() {
                const data = {
                    settings: window.globalSettings || {
                        theme: localStorage.getItem('theme') || 'light',
                        language: localStorage.getItem('language') || 'id',
                        fontSize: localStorage.getItem('fontSize') || 'medium'
                    },
                    timestamp: new Date().toISOString()
                };
                
                const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'bijak-sampah-settings.json';
                a.click();
                URL.revokeObjectURL(url);
            });
        }

        // Delete account functionality
        const deleteAccountBtn = document.querySelector('[data-action="delete-account"]');
        if (deleteAccountBtn) {
            deleteAccountBtn.addEventListener('click', function() {
                if (confirm('Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.')) {
                    localStorage.clear();
                    alert('Akun berhasil dihapus!');
                    window.location.href = '/logout';
                }
            });
        }

        // FAQ link functionality
        const faqLink = document.querySelector('[data-action="faq-link"]');
        if (faqLink) {
            faqLink.addEventListener('click', function(e) {
                e.preventDefault();
                alert('Fitur FAQ akan segera tersedia!');
            });
        }

        // Contact link functionality
        const contactLink = document.querySelector('[data-action="contact-link"]');
        if (contactLink) {
            contactLink.addEventListener('click', function(e) {
                e.preventDefault();
                alert('Fitur kontak akan segera tersedia!');
            });
        }

        // Set toggle states
        const savedSettings = {
            'email-notifications': localStorage.getItem('email-notifications') === 'true',
            'push-notifications': localStorage.getItem('push-notifications') === 'true',
            'sms-notifications': localStorage.getItem('sms-notifications') === 'true',
            'data-sharing': localStorage.getItem('data-sharing') === 'true',
            'location-sharing': localStorage.getItem('location-sharing') === 'true'
        };

        Object.keys(savedSettings).forEach(setting => {
            const toggle = document.querySelector(`[data-setting="${setting}"]`);
            if (toggle) {
                toggle.checked = savedSettings[setting];
            }
        });

        // Sidebar hover functionality
        const sidebar = document.getElementById('sidebar');
        const logoFull = document.getElementById('logoFull');
        const logoIcon = document.getElementById('logoIcon');
        const textElements = [
            'dashboardText', 'bankSampahText', 'tokoText', 'komunitasText', 
            'beritaText', 'keuanganText', 'pesanText', 'feedbackText', 
            'settingsText', 'logoutText'
        ];

        if (sidebar) {
            sidebar.addEventListener('mouseenter', function() {
                sidebar.style.width = '16rem';
                if (logoFull) logoFull.classList.remove('hidden');
                if (logoIcon) logoIcon.classList.add('hidden');
                textElements.forEach(id => {
                    const element = document.getElementById(id);
                    if (element) element.classList.remove('hidden');
                });
                
                // Update alignment for expanded state
                const navItems = sidebar.querySelectorAll('.sidebar-nav-item');
                navItems.forEach(item => {
                    item.classList.remove('justify-center');
                    item.classList.add('justify-start');
                });
            });

            sidebar.addEventListener('mouseleave', function() {
                sidebar.style.width = '4rem';
                if (logoFull) logoFull.classList.add('hidden');
                if (logoIcon) logoIcon.classList.remove('hidden');
                textElements.forEach(id => {
                    const element = document.getElementById(id);
                    if (element) element.classList.add('hidden');
                });
                
                // Update alignment for collapsed state
                const navItems = sidebar.querySelectorAll('.sidebar-nav-item');
                navItems.forEach(item => {
                    item.classList.remove('justify-start');
                    item.classList.add('justify-center');
                });
            });
        }
        
        console.log('Settings page initialized successfully');
    }

    // Initialize immediately and also wait a bit for global settings to load
    initializeSettingsPage();
    setTimeout(initializeSettingsPage, 100);
    setTimeout(initializeSettingsPage, 500);
    setTimeout(initializeSettingsPage, 1000);
});
</script>
@endsection 