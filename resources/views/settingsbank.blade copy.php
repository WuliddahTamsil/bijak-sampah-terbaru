@extends('layouts.app')

@section('content')
<style>
    html, body {
        overflow-x: hidden;
    }
    .sidebar-gradient {
        background: var(--sidebar-gradient);
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
    .settings-card {
        background: var(--bg-primary) !important;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--border-primary) !important;
        color: var(--text-primary) !important;
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
        background: var(--sidebar-gradient) !important;
        transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
    input:checked + .slider { background-color: var(--success); }
    input:checked + .slider:before { transform: translateX(26px); }
    
    /* Dark theme overrides for settings page */
    .dark .text-gray-900 { color: var(--text-primary) !important; }
    .dark .text-gray-600 { color: var(--text-secondary) !important; }
    .dark .text-gray-500 { color: var(--text-muted) !important; }
    .dark .border-gray-100 { border-color: var(--border-primary) !important; }
    .dark .border-gray-300 { border-color: var(--border-secondary) !important; }
    .dark .bg-gray-50 { background-color: var(--bg-secondary) !important; }
    .dark .bg-white { background-color: var(--bg-primary) !important; }
    
    /* Ensure all text elements use theme colors */
    .text-gray-900 { color: var(--text-primary) !important; }
    .text-gray-600 { color: var(--text-secondary) !important; }
    .text-gray-500 { color: var(--text-muted) !important; }
    .border-gray-100 { border-color: var(--border-primary) !important; }
    .border-gray-300 { border-color: var(--border-secondary) !important; }
    .bg-gray-50 { background-color: var(--bg-secondary) !important; }
    .bg-white { background-color: var(--bg-primary) !important; }
</style>
<div class="flex min-h-screen" style="background-color: var(--bg-secondary);" x-data="settingsApp()" x-init="init()">
    {{-- Sidebar --}}
    <aside
        x-data="{ open: false, active: 'settings' }"
        x-ref="sidebar"
        @mouseenter="open = true; $root.sidebarOpen = true"
        @mouseleave="open = false; $root.sidebarOpen = false"
        class="fixed top-0 left-0 z-20 flex flex-col py-6 sidebar-hover overflow-hidden shadow-2xl group sidebar-gradient"
        :class="open ? 'w-64' : 'w-16'"
        style="transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); margin-top: 48px; height: calc(100vh - 48px);"
    >
        <div class="relative flex flex-col h-full w-full px-4">
            {{-- Logo Section --}}
            <div class="flex items-center justify-center mb-8 mt-2 sidebar-logo">
                <img x-show="open" class="w-16 h-auto" src="{{ asset('asset/img/logo.png') }}" alt="Logo Penuh">
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
     <div class="flex-1 min-h-screen" style="background-color: var(--bg-primary);" :style="'padding-left:' + (sidebarOpen ? '16rem' : '4rem') + '; transition: padding-left 0.3s cubic-bezier(0.4,0,0.2,1);'">
        {{-- Top Header Bar --}}
        <div class="fixed-header" :style="'padding-left:' + (sidebarOpen ? '16rem' : '4rem') + ';'">
            <h1 class="text-white font-semibold text-lg">BijakSampah</h1>
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
        <div class="p-8 w-full" style="padding-top: 60px;">
            {{-- Settings Title --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900" x-text="labels.settings"></h1>
                <p class="text-gray-600 mt-2" x-text="labels.settingsDesc"></p>
            </div>
            {{-- Settings Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Account Settings --}}
                <div class="settings-card p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900" x-text="labels.account"></h3>
                            <p class="text-sm text-gray-600" x-text="labels.accountDesc"></p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900" x-text="labels.editProfile"></h4>
                                <p class="text-sm text-gray-600" x-text="labels.editProfileDesc"></p>
                            </div>
                            <a href="{{ route('profile') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                                <span x-text="labels.edit"></span>
                            </a>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900" x-text="labels.changePassword"></h4>
                                <p class="text-sm text-gray-600" x-text="labels.changePasswordDesc"></p>
                            </div>
                            <button class="text-blue-600 hover:text-blue-700 font-medium" @click="showPasswordModal = true">
                                <span x-text="labels.change"></span>
                            </button>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <div>
                                <h4 class="font-medium text-gray-900" x-text="labels.verifyEmail"></h4>
                                <p class="text-sm text-gray-600" x-text="labels.verifyEmailDesc"></p>
                            </div>
                            <span class="text-green-600 text-sm font-medium" x-text="labels.verified"></span>
                        </div>
                    </div>
                </div>
                {{-- Notification Settings --}}
                <div class="settings-card p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-bell text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900" x-text="labels.notifications"></h3>
                            <p class="text-sm text-gray-600" x-text="labels.notificationsDesc"></p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900" x-text="labels.emailNotif"></h4>
                                <p class="text-sm text-gray-600" x-text="labels.emailNotifDesc"></p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" x-model="settings.notifications.email" @change="save()">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900" x-text="labels.pushNotif"></h4>
                                <p class="text-sm text-gray-600" x-text="labels.pushNotifDesc"></p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" x-model="settings.notifications.push" @change="save()">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <div>
                                <h4 class="font-medium text-gray-900" x-text="labels.smsNotif"></h4>
                                <p class="text-sm text-gray-600" x-text="labels.smsNotifDesc"></p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" x-model="settings.notifications.sms" @change="save()">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                </div>
                {{-- Privacy Settings --}}
                <div class="settings-card p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-shield-alt text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900" x-text="labels.privacy"></h3>
                            <p class="text-sm text-gray-600" x-text="labels.privacyDesc"></p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900" x-text="labels.profileVisibility"></h4>
                                <p class="text-sm text-gray-600" x-text="labels.profileVisibilityDesc"></p>
                            </div>
                            <select x-model="settings.privacy.profileVisibility" @change="save()" class="text-sm border border-gray-300 rounded px-2 py-1">
                                <option value="public" x-text="labels.public"></option>
                                <option value="friends" x-text="labels.friends"></option>
                                <option value="private" x-text="labels.private"></option>
                            </select>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900" x-text="labels.dataSharing"></h4>
                                <p class="text-sm text-gray-600" x-text="labels.dataSharingDesc"></p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" x-model="settings.privacy.dataSharing" @change="save()">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <div>
                                <h4 class="font-medium text-gray-900" x-text="labels.locationSharing"></h4>
                                <p class="text-sm text-gray-600" x-text="labels.locationSharingDesc"></p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" x-model="settings.privacy.locationSharing" @change="save()">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                </div>
                {{-- Appearance Settings --}}
                <div class="settings-card p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-palette text-orange-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900" x-text="labels.appearance"></h3>
                            <p class="text-sm text-gray-600" x-text="labels.appearanceDesc"></p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900" x-text="labels.theme"></h4>
                                <p class="text-sm text-gray-600" x-text="labels.themeDesc"></p>
                            </div>
                            <select x-model="settings.appearance.theme" @change="applyTheme();save()" class="text-sm border border-gray-300 rounded px-2 py-1">
                                <option value="light" x-text="labels.light"></option>
                                <option value="dark" x-text="labels.dark"></option>
                                <option value="auto" x-text="labels.auto"></option>
                            </select>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900" x-text="labels.language"></h4>
                                <p class="text-sm text-gray-600" x-text="labels.languageDesc"></p>
                            </div>
                            <select x-model="settings.appearance.language" @change="applyLanguage();save()" class="text-sm border border-gray-300 rounded px-2 py-1">
                                <option value="id">Indonesia</option>
                                <option value="en">English</option>
                                <option value="ja">日本語</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <div>
                                <h4 class="font-medium text-gray-900" x-text="labels.fontSize"></h4>
                                <p class="text-sm text-gray-600" x-text="labels.fontSizeDesc"></p>
                            </div>
                            <select x-model="settings.appearance.fontSize" @change="applyFontSize();save()" class="text-sm border border-gray-300 rounded px-2 py-1">
                                <option value="small" x-text="labels.small"></option>
                                <option value="medium" x-text="labels.medium"></option>
                                <option value="large" x-text="labels.large"></option>
                            </select>
                        </div>
                    </div>
                </div>
                {{-- Data & Storage --}}
                <div class="settings-card p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-database text-red-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900" x-text="labels.data"></h3>
                            <p class="text-sm text-gray-600" x-text="labels.dataDesc"></p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900" x-text="labels.cache"></h4>
                                <p class="text-sm text-gray-600" x-text="labels.cacheDesc"></p>
                            </div>
                            <button class="text-blue-600 hover:text-blue-700 font-medium" @click="clearCache()">
                                <span x-text="labels.clear"></span>
                            </button>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900" x-text="labels.download"></h4>
                                <p class="text-sm text-gray-600" x-text="labels.downloadDesc"></p>
                            </div>
                            <button class="text-blue-600 hover:text-blue-700 font-medium" @click="downloadData()">
                                <span x-text="labels.downloadBtn"></span>
                            </button>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <div>
                                <h4 class="font-medium text-gray-900" x-text="labels.delete"></h4>
                                <p class="text-sm text-gray-600" x-text="labels.deleteDesc"></p>
                            </div>
                            <button class="text-red-600 hover:text-red-700 font-medium" @click="showDeleteModal = true">
                                <span x-text="labels.deleteBtn"></span>
                            </button>
                        </div>
                    </div>
                </div>
                {{-- Help & Support --}}
                <div class="settings-card p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-question-circle text-yellow-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900" x-text="labels.help"></h3>
                            <p class="text-sm text-gray-600" x-text="labels.helpDesc"></p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900" x-text="labels.faq"></h4>
                                <p class="text-sm text-gray-600" x-text="labels.faqDesc"></p>
                            </div>
                            <a href="#" class="text-blue-600 hover:text-blue-700 font-medium" @click.prevent="alert(labels.faqAlert)"><span x-text="labels.open"></span></a>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <h4 class="font-medium text-gray-900" x-text="labels.contact"></h4>
                                <p class="text-sm text-gray-600" x-text="labels.contactDesc"></p>
                            </div>
                            <a href="#" class="text-blue-600 hover:text-blue-700 font-medium" @click.prevent="alert(labels.contactAlert)"><span x-text="labels.contactBtn"></span></a>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <div>
                                <h4 class="font-medium text-gray-900" x-text="labels.about"></h4>
                                <p class="text-sm text-gray-600" x-text="labels.aboutDesc"></p>
                            </div>
                            <span class="text-gray-500 text-sm">v1.0.0</span>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Password Modal --}}
            <div x-show="showPasswordModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                <div class="bg-white rounded-lg p-6 shadow-xl w-full max-w-sm">
                    <h2 class="text-lg font-semibold mb-4" x-text="labels.changePassword"></h2>
                    <input type="password" class="w-full border rounded px-3 py-2 mb-3" placeholder="Password baru">
                    <input type="password" class="w-full border rounded px-3 py-2 mb-3" placeholder="Konfirmasi password">
                    <div class="flex justify-end gap-2">
                        <button class="px-4 py-2 bg-gray-200 rounded" @click="showPasswordModal = false">Batal</button>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded" @click="showPasswordModal = false; alert(labels.passwordChanged)">Simpan</button>
                    </div>
                </div>
            </div>
            {{-- Delete Modal --}}
            <div x-show="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                <div class="bg-white rounded-lg p-6 shadow-xl w-full max-w-sm">
                    <h2 class="text-lg font-semibold mb-4" x-text="labels.deleteConfirm"></h2>
                    <p class="mb-4" x-text="labels.deleteWarning"></p>
                    <div class="flex justify-end gap-2">
                        <button class="px-4 py-2 bg-gray-200 rounded" @click="showDeleteModal = false">Batal</button>
                        <button class="px-4 py-2 bg-red-600 text-white rounded" @click="deleteAccount()">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function settingsApp() {
    return {
        sidebarOpen: false,
        showPasswordModal: false,
        showDeleteModal: false,
        labels: {
            settings: 'Pengaturan', settingsDesc: 'Kelola pengaturan akun dan aplikasi Anda',
            account: 'Akun', accountDesc: 'Pengaturan akun dan profil', editProfile: 'Edit Profil', editProfileDesc: 'Ubah informasi profil Anda', edit: 'Edit', changePassword: 'Ubah Password', changePasswordDesc: 'Perbarui kata sandi akun', change: 'Ubah', verifyEmail: 'Verifikasi Email', verifyEmailDesc: 'Konfirmasi alamat email Anda', verified: 'Terverifikasi',
            notifications: 'Notifikasi', notificationsDesc: 'Kelola notifikasi aplikasi', emailNotif: 'Notifikasi Email', emailNotifDesc: 'Terima notifikasi via email', pushNotif: 'Notifikasi Push', pushNotifDesc: 'Notifikasi langsung di aplikasi', smsNotif: 'Notifikasi SMS', smsNotifDesc: 'Terima notifikasi via SMS',
            privacy: 'Privasi', privacyDesc: 'Pengaturan keamanan dan privasi', profileVisibility: 'Visibilitas Profil', profileVisibilityDesc: 'Siapa yang dapat melihat profil Anda', public: 'Publik', friends: 'Teman', private: 'Pribadi', dataSharing: 'Berbagi Data', dataSharingDesc: 'Izinkan berbagi data untuk analisis', locationSharing: 'Bagikan Lokasi', locationSharingDesc: 'Izinkan aplikasi mengakses lokasi',
            appearance: 'Tampilan', appearanceDesc: 'Kustomisasi tampilan aplikasi', theme: 'Tema', themeDesc: 'Pilih tema aplikasi', light: 'Terang', dark: 'Gelap', auto: 'Otomatis', language: 'Bahasa', languageDesc: 'Pilih bahasa aplikasi', fontSize: 'Ukuran Font', fontSizeDesc: 'Sesuaikan ukuran teks', small: 'Kecil', medium: 'Sedang', large: 'Besar',
            data: 'Data & Penyimpanan', dataDesc: 'Kelola data dan penyimpanan', cache: 'Cache Aplikasi', cacheDesc: 'Bersihkan cache aplikasi', clear: 'Bersihkan', download: 'Unduh Data', downloadDesc: 'Unduh data akun Anda', downloadBtn: 'Unduh', delete: 'Hapus Akun', deleteDesc: 'Hapus akun secara permanen', deleteBtn: 'Hapus', deleteConfirm: 'Konfirmasi Hapus Akun', deleteWarning: 'Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.',
            help: 'Bantuan & Dukungan', helpDesc: 'Dapatkan bantuan dan dukungan', faq: 'Pusat Bantuan', faqDesc: 'Temukan jawaban untuk pertanyaan umum', faqAlert: 'Fitur pusat bantuan belum tersedia.', open: 'Buka', contact: 'Hubungi Kami', contactDesc: 'Hubungi tim dukungan pelanggan', contactAlert: 'Fitur kontak belum tersedia.', contactBtn: 'Kontak', about: 'Tentang Aplikasi', aboutDesc: 'Informasi versi dan lisensi', passwordChanged: 'Password berhasil diubah!',
        },
        settings: {
            notifications: { email: true, push: true, sms: false },
            privacy: { profileVisibility: 'public', dataSharing: true, locationSharing: false },
            appearance: { theme: 'light', language: 'id', fontSize: 'medium' },
        },
        init() {
            // Load from localStorage
            const saved = localStorage.getItem('settingsApp');
            if (saved) {
                this.settings = JSON.parse(saved);
            }
            
            // Sync with global settings
            const globalSettings = localStorage.getItem('globalSettings');
            if (globalSettings) {
                const global = JSON.parse(globalSettings);
                this.settings.appearance.theme = global.theme || this.settings.appearance.theme;
                this.settings.appearance.language = global.language || this.settings.appearance.language;
                this.settings.appearance.fontSize = global.fontSize || this.settings.appearance.fontSize;
            }
            
            // Update labels based on current language
            this.updateLabels();
            
            // Listen for language changes from other pages
            window.addEventListener('languageChanged', (e) => {
                console.log('Settings: Language changed event received:', e.detail.language);
                this.settings.appearance.language = e.detail.language;
                this.updateLabels();
            });
            
            // Listen for font size changes from other pages
            window.addEventListener('fontSizeChanged', (e) => {
                console.log('Settings: Font size changed event received:', e.detail.fontSize);
                this.settings.appearance.fontSize = e.detail.fontSize;
            });
        },
        save() {
            localStorage.setItem('settingsApp', JSON.stringify(this.settings));
            
            // Update global settings
            const globalSettings = {
                theme: this.settings.appearance.theme,
                language: this.settings.appearance.language,
                fontSize: this.settings.appearance.fontSize
            };
            localStorage.setItem('globalSettings', JSON.stringify(globalSettings));
            
            // Update global theme
            if (window.globalTheme) {
                window.globalTheme.updateSettings(globalSettings);
            }
        },
        applyTheme() {
            console.log('Settings: Applying theme:', this.settings.appearance.theme);
            // Update global settings
            const globalSettings = {
                theme: this.settings.appearance.theme,
                language: this.settings.appearance.language,
                fontSize: this.settings.appearance.fontSize
            };
            
            if (window.globalTheme) {
                window.globalTheme.updateSettings(globalSettings);
                console.log('Settings: Theme updated via globalTheme');
            } else {
                console.error('Settings: globalTheme not available');
            }
        },
        applyFontSize() {
            const globalSettings = {
                theme: this.settings.appearance.theme,
                language: this.settings.appearance.language,
                fontSize: this.settings.appearance.fontSize
            };
            
            if (window.globalTheme) {
                window.globalTheme.updateSettings(globalSettings);
            }
        },
        applyLanguage() {
            console.log('Settings: Applying language:', this.settings.appearance.language);
            
            // Update labels based on language
            this.updateLabels();
            
            // Update global settings
            const globalSettings = {
                theme: this.settings.appearance.theme,
                language: this.settings.appearance.language,
                fontSize: this.settings.appearance.fontSize
            };
            
            if (window.globalTheme) {
                window.globalTheme.updateSettings(globalSettings);
            }
        },
        
        updateLabels() {
            // Demo: hanya ganti label, tidak multi-bahasa penuh
            if (this.settings.appearance.language === 'en') {
                this.labels = { ...this.labels, settings: 'Settings', settingsDesc: 'Manage your account and app settings', account: 'Account', accountDesc: 'Account and profile settings', editProfile: 'Edit Profile', editProfileDesc: 'Change your profile info', edit: 'Edit', changePassword: 'Change Password', changePasswordDesc: 'Update your account password', change: 'Change', verifyEmail: 'Verify Email', verifyEmailDesc: 'Confirm your email address', verified: 'Verified', notifications: 'Notifications', notificationsDesc: 'Manage app notifications', emailNotif: 'Email Notifications', emailNotifDesc: 'Receive notifications via email', pushNotif: 'Push Notifications', pushNotifDesc: 'In-app notifications', smsNotif: 'SMS Notifications', smsNotifDesc: 'Receive notifications via SMS', privacy: 'Privacy', privacyDesc: 'Security and privacy settings', profileVisibility: 'Profile Visibility', profileVisibilityDesc: 'Who can see your profile', public: 'Public', friends: 'Friends', private: 'Private', dataSharing: 'Data Sharing', dataSharingDesc: 'Allow data sharing for analytics', locationSharing: 'Location Sharing', locationSharingDesc: 'Allow app to access location', appearance: 'Appearance', appearanceDesc: 'Customize app appearance', theme: 'Theme', themeDesc: 'Choose app theme', light: 'Light', dark: 'Dark', auto: 'Auto', language: 'Language', languageDesc: 'Choose app language', fontSize: 'Font Size', fontSizeDesc: 'Adjust text size', small: 'Small', medium: 'Medium', large: 'Large', data: 'Data & Storage', dataDesc: 'Manage data and storage', cache: 'App Cache', cacheDesc: 'Clear app cache', clear: 'Clear', download: 'Download Data', downloadDesc: 'Download your account data', downloadBtn: 'Download', delete: 'Delete Account', deleteDesc: 'Delete your account permanently', deleteBtn: 'Delete', deleteConfirm: 'Confirm Delete Account', deleteWarning: 'Are you sure you want to delete your account? This action cannot be undone.', help: 'Help & Support', helpDesc: 'Get help and support', faq: 'Help Center', faqDesc: 'Find answers to common questions', faqAlert: 'Help center feature not available.', open: 'Open', contact: 'Contact Us', contactDesc: 'Contact support team', contactAlert: 'Contact feature not available.', contactBtn: 'Contact', about: 'About App', aboutDesc: 'Version and license info', passwordChanged: 'Password changed successfully!', };
            } else if (this.settings.appearance.language === 'ja') {
                this.labels = { ...this.labels, settings: '設定', settingsDesc: 'アカウントとアプリの設定を管理', account: 'アカウント', accountDesc: 'アカウントとプロフィールの設定', editProfile: 'プロフィール編集', editProfileDesc: 'プロフィール情報を変更', edit: '編集', changePassword: 'パスワード変更', changePasswordDesc: 'アカウントのパスワードを更新', change: '変更', verifyEmail: 'メール認証', verifyEmailDesc: 'メールアドレスを確認', verified: '認証済み', notifications: '通知', notificationsDesc: 'アプリの通知を管理', emailNotif: 'メール通知', emailNotifDesc: 'メールで通知を受け取る', pushNotif: 'プッシュ通知', pushNotifDesc: 'アプリ内通知', smsNotif: 'SMS通知', smsNotifDesc: 'SMSで通知を受け取る', privacy: 'プライバシー', privacyDesc: 'セキュリティとプライバシー設定', profileVisibility: 'プロフィール公開範囲', profileVisibilityDesc: '誰がプロフィールを見れるか', public: '公開', friends: '友達', private: '非公開', dataSharing: 'データ共有', dataSharingDesc: '分析のためにデータ共有を許可', locationSharing: '位置情報共有', locationSharingDesc: 'アプリに位置情報へのアクセスを許可', appearance: '外観', appearanceDesc: 'アプリの外観をカスタマイズ', theme: 'テーマ', themeDesc: 'アプリのテーマを選択', light: 'ライト', dark: 'ダーク', auto: '自動', language: '言語', languageDesc: 'アプリの言語を選択', fontSize: 'フォントサイズ', fontSizeDesc: 'テキストサイズを調整', small: '小', medium: '中', large: '大', data: 'データとストレージ', dataDesc: 'データとストレージを管理', cache: 'アプリキャッシュ', cacheDesc: 'アプリのキャッシュをクリア', clear: 'クリア', download: 'データダウンロード', downloadDesc: 'アカウントデータをダウンロード', downloadBtn: 'ダウンロード', delete: 'アカウント削除', deleteDesc: 'アカウントを完全に削除', deleteBtn: '削除', deleteConfirm: 'アカウント削除の確認', deleteWarning: '本当にアカウントを削除しますか？この操作は元に戻せません。', help: 'ヘルプとサポート', helpDesc: 'ヘルプとサポートを受ける', faq: 'ヘルプセンター', faqDesc: 'よくある質問の回答を探す', faqAlert: 'ヘルプセンター機能は利用できません。', open: '開く', contact: 'お問い合わせ', contactDesc: 'サポートチームに連絡', contactAlert: 'お問い合わせ機能は利用できません。', contactBtn: '連絡', about: 'アプリについて', aboutDesc: 'バージョンとライセンス情報', passwordChanged: 'パスワードが変更されました！', };
            } else {
                // Indonesia (default)
                this.labels = settingsApp().labels;
            }
        },
        clearCache() {
            localStorage.removeItem('settingsApp');
            localStorage.removeItem('globalSettings');
            this.settings = settingsApp().settings;
            this.applyTheme();
            this.applyFontSize();
            this.applyLanguage();
            alert('Cache dibersihkan!');
        },
        downloadData() {
            const data = JSON.stringify(this.settings, null, 2);
            const blob = new Blob([data], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'data-akun.json';
            a.click();
            URL.revokeObjectURL(url);
        },
        deleteAccount() {
            localStorage.removeItem('settingsApp');
            localStorage.removeItem('globalSettings');
            this.settings = settingsApp().settings;
            this.showDeleteModal = false;
            alert('Akun berhasil dihapus!');
            location.reload();
        },
    };
}
</script>
@endsection 