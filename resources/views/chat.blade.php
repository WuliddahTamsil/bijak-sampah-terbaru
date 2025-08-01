@extends('layouts.app')

@section('content')
<style>
    html, body { overflow-x: hidden; }
    .sidebar-gradient { background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%); }
    .sidebar-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .sidebar-item-hover { transition: all 0.2s ease-in-out; }
    .sidebar-item-hover:hover { background-color: rgba(255, 255, 255, 0.2); }
    .sidebar-logo { transition: all 0.3s ease-in-out; }
    .sidebar-nav-item { transition: all 0.2s ease-in-out; border-radius: 8px; }
    .sidebar-nav-item:hover { background-color: rgba(255, 255, 255, 0.1); }
    .sidebar-nav-item.active { background-color: rgba(255, 255, 255, 0.2); box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
    .fixed-header { position: fixed; top: 0; left: 0; right: 0; height: 48px; z-index: 40; display: flex; align-items: center; justify-content: space-between; padding-right: 1.5rem; background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%); transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    
    /* Fix sidebar z-index to be above main content */
    .sidebar-fixed {
        z-index: 1000 !important;
    }
    /* Ensure main content doesn't overlap sidebar */
    .main-content-area {
        position: relative;
        z-index: 1;
    }
    
    /* Enhanced Chat Styles */
    .chat-container {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(20px);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .chat-container:hover {
        transform: translateY(-2px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }
    
    /* Chat List Styles */
    .chat-list-item {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 16px;
        margin: 8px 16px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        border: 2px solid transparent;
    }
    .chat-list-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }
    .chat-list-item:hover::before {
        left: 100%;
    }
    .chat-list-item:hover {
        transform: translateX(4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        border-color: rgba(12, 201, 200, 0.3);
    }
    .chat-list-item.active {
        background: linear-gradient(135deg, #05445E 0%, #75E6DA 100%);
        box-shadow: 0 8px 20px rgba(5, 68, 94, 0.3);
        border-color: #0CC9C8;
    }
    .chat-list-item.unread {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-color: #f59e0b;
    }
    .unread-badge {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        animation: pulse 2s infinite;
    }
    
    /* Message Styles */
    .message-bubble {
        animation: messageSlideIn 0.3s ease-out;
        position: relative;
        max-width: 70%;
        word-wrap: break-word;
        margin: 12px 0;
        padding: 12px 16px;
        line-height: 1.4;
        font-size: 14px;
        position: relative;
    }
    .message-bubble.sent {
        background: linear-gradient(135deg, #05445E 0%, #0CC9C8 100%);
        color: white;
        border-radius: 20px 20px 6px 20px;
        box-shadow: 0 4px 12px rgba(5, 68, 94, 0.3);
        margin-left: auto;
        margin-right: 8px;
        align-self: flex-end;
    }
    .message-bubble.received {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        color: #1a1a1a;
        border-radius: 20px 20px 20px 6px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-right: auto;
        margin-left: 8px;
        align-self: flex-start;
        border: 1px solid #e5e7eb;
    }
    .message-bubble.sent::before {
        content: '';
        position: absolute;
        bottom: 0;
        right: -8px;
        width: 0;
        height: 0;
        border-left: 8px solid #0CC9C8;
        border-bottom: 8px solid transparent;
    }
    .message-bubble.received::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: -8px;
        width: 0;
        height: 0;
        border-right: 8px solid #ffffff;
        border-bottom: 8px solid transparent;
    }
    .message-time {
        font-size: 10px;
        opacity: 0.8;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
        font-weight: 400;
    }
    .message-status {
        font-size: 10px;
        margin-left: 4px;
        opacity: 0.9;
    }
    .status-sent { color: rgba(255, 255, 255, 0.8); }
    .status-delivered { color: rgba(255, 255, 255, 0.9); }
    .status-read { color: rgba(255, 255, 255, 1); }
    
    /* Message container for better alignment */
    .message-container {
        display: flex;
        flex-direction: column;
        width: 100%;
        gap: 4px;
    }
    
    /* Message group styling */
    .message-group {
        display: flex;
        flex-direction: column;
        gap: 2px;
        margin: 8px 0;
    }
    
    .message-group.sent {
        align-items: flex-end;
    }
    
    .message-group.received {
        align-items: flex-start;
    }
    
    @keyframes messageSlideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Typing Indicator */
    .typing-indicator {
        display: flex;
        gap: 4px;
        padding: 12px 16px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        width: fit-content;
        border: 1px solid #e5e7eb;
        margin: 8px 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        position: relative;
    }
    .typing-indicator::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: -8px;
        width: 0;
        height: 0;
        border-right: 8px solid rgba(255, 255, 255, 0.95);
        border-bottom: 8px solid transparent;
    }
    .typing-dot {
        width: 8px;
        height: 8px;
        background: #05445E;
        border-radius: 50%;
        animation: typing 1.4s infinite ease-in-out;
    }
    .typing-dot:nth-child(1) { animation-delay: -0.32s; }
    .typing-dot:nth-child(2) { animation-delay: -0.16s; }
    @keyframes typing {
        0%, 80%, 100% { transform: scale(0.8); opacity: 0.5; }
        40% { transform: scale(1); opacity: 1; }
    }
    
    /* Input Area Styles */
    .message-input-container {
        background: white;
        border-top: 1px solid #e5e7eb;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .message-input {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 2px solid #e5e7eb;
        border-radius: 24px;
        padding: 12px 20px;
        font-size: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        flex: 1;
        resize: none;
        min-height: 48px;
        max-height: 120px;
    }
    .message-input:focus {
        outline: none;
        border-color: #0CC9C8;
        box-shadow: 0 0 0 3px rgba(12, 201, 200, 0.1), 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-1px);
    }
    
    /* Action Buttons */
    .action-button {
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        color: #6b7280;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    .action-button:hover {
        background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
        color: #374151;
        transform: scale(1.05);
    }
    
    .send-button {
        background: linear-gradient(135deg, #05445E 0%, #0CC9C8 100%);
        color: white;
        border: none;
        border-radius: 50%;
        width: 48px;
        height: 48px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(5, 68, 94, 0.3);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .send-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(5, 68, 94, 0.4);
    }
    .send-button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }
    
    /* Online Indicator */
    .online-indicator {
        width: 12px;
        height: 12px;
        background: #10b981;
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 0 0 2px #10b981;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { box-shadow: 0 0 0 2px #10b981; }
        50% { box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.3); }
    }
    
    /* New Message Button */
    .new-message-button {
        background: linear-gradient(135deg, #05445E 0%, #0CC9C8 100%);
        color: white;
        border: none;
        border-radius: 50%;
        width: 56px;
        height: 56px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(5, 68, 94, 0.3);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .new-message-button:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 20px rgba(5, 68, 94, 0.4);
    }
    
    /* Chat Header */
    .chat-header {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-bottom: 1px solid #e5e7eb;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .chat-header-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .chat-header-actions {
        display: flex;
        gap: 8px;
    }
    .header-action-btn {
        background: transparent;
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b7280;
    }
    .header-action-btn:hover {
        background: #f3f4f6;
        color: #374151;
    }
    
    /* Scrollbar Styling */
    .chat-messages::-webkit-scrollbar {
        width: 6px;
    }
    .chat-messages::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    .chat-messages::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    .chat-messages::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

<div class="flex min-h-screen bg-gradient-to-br from-blue-50 via-teal-50 to-cyan-50" x-data="chatApp()" x-init="init()">
    {{-- Sidebar --}}
    <aside
        x-data="{ open: false, active: 'chat' }"
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
                <img x-show="open" class="w-16 h-auto" src="{{ asset('asset/img/logo.png') }}" alt="Logo Penuh">
                <img x-show="!open" class="w-6 h-6" src="{{ asset('asset/img/logo.png') }}" alt="Logo Ikon">
            </div>
            {{-- Navigation Menu --}}
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
                <a href="{{ route('chat') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'chat' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'chat' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-comment-dots text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Pesan</span>
                </a>
                <a href="{{ route('feedback') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'feedback' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'feedback' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-info-circle text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Umpan Balik</span>
                </a>
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
            <div class="chat-container flex h-[80vh] overflow-hidden">
                <!-- Daftar Chat -->
                <div class="w-80 border-r bg-white flex flex-col">
                    <div class="p-6 text-2xl font-bold text-gray-800 bg-gradient-to-r from-teal-500 to-cyan-500 bg-clip-text text-transparent">
                        <i class="fas fa-comments mr-2"></i>Pesan
                    </div>
                    <div class="flex-1 overflow-y-auto">
                        <div class="chat-list-item active flex items-center gap-4 p-4" @click="selectChat('BS Lodaya II')">
                            <div class="relative">
                                <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-lg">
                                <div class="online-indicator absolute -bottom-1 -right-1"></div>
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-white">BS Lodaya II</div>
                                <div class="text-white/80 text-xs">Baik Terima Kasih</div>
                            </div>
                            <div class="text-white/60 text-xs">12:30</div>
                        </div>
                        <div class="chat-list-item unread flex items-center gap-4 p-4" @click="selectChat('Wugis')">
                            <div class="relative">
                                <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-lg">
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-gray-800">Wugis</div>
                                <div class="text-gray-500 text-xs">Baik...terima kasih</div>
                            </div>
                            <div class="flex flex-col items-end gap-1">
                                <div class="text-gray-400 text-xs">11:45</div>
                                <div class="unread-badge">3</div>
                            </div>
                        </div>
                        <div class="chat-list-item flex items-center gap-4 p-4" @click="selectChat('Bank Sampah Central')">
                            <div class="relative">
                                <img src="https://randomuser.me/api/portraits/men/45.jpg" class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-lg">
                                <div class="online-indicator absolute -bottom-1 -right-1"></div>
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-gray-800">Bank Sampah Central</div>
                                <div class="text-gray-500 text-xs">Sampah sudah dijemput</div>
                            </div>
                            <div class="text-gray-400 text-xs">10:20</div>
                        </div>
                    </div>
                    <div class="p-4 flex justify-end">
                        <button class="new-message-button" @click="showNewMessageModal = true" title="Pesan Baru">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <!-- Area Chat -->
                <div class="flex-1 flex flex-col">
                    <!-- Chat Header -->
                    <div class="chat-header">
                        <div class="chat-header-info">
                            <div class="relative">
                                <img :src="currentChat.avatar" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-lg">
                                <div class="online-indicator absolute -bottom-1 -right-1" x-show="currentChat.online"></div>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800" x-text="currentChat.name"></div>
                                <div class="text-xs text-teal-500 flex items-center gap-1" x-show="currentChat.online">
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    Online
                                </div>
                                <div class="text-xs text-gray-500" x-show="!currentChat.online">
                                    Terakhir online <span x-text="currentChat.lastSeen"></span>
                                </div>
                            </div>
                        </div>
                        <div class="chat-header-actions">
                            <button class="header-action-btn" @click="toggleVoiceCall()" title="Panggilan Suara">
                                <i class="fas fa-phone"></i>
                            </button>
                            <button class="header-action-btn" @click="toggleVideoCall()" title="Panggilan Video">
                                <i class="fas fa-video"></i>
                            </button>
                            <button class="header-action-btn" @click="toggleSearch()" title="Cari Pesan">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="header-action-btn" @click="toggleChatMenu()" title="Menu Chat">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Messages Area -->
                    <div class="flex-1 bg-gradient-to-br from-gray-50 to-blue-50 p-6 overflow-y-auto chat-messages flex flex-col gap-2" x-ref="messagesContainer">
                        <template x-for="message in currentChat.messages" :key="message.id">
                            <div class="message-group" :class="message.type">
                                <div class="message-bubble" :class="message.type" x-html="message.content"></div>
                            </div>
                        </template>
                        
                        <!-- Typing indicator -->
                        <div x-show="currentChat.typing" class="self-start">
                            <div class="typing-indicator">
                                <div class="typing-dot"></div>
                                <div class="typing-dot"></div>
                                <div class="typing-dot"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Message Input Area -->
                    <div class="message-input-container">
                        <button class="action-button" @click="toggleEmojiPicker()" title="Emoji">
                            <i class="far fa-smile"></i>
                        </button>
                        <div class="file-upload">
                            <input type="file" @change="handleFileUpload($event)" accept="image/*,video/*,audio/*,.pdf,.doc,.docx" id="file-upload" x-ref="fileInput">
                            <button class="action-button" @click="$refs.fileInput.click()" title="Lampirkan File">
                                <i class="fas fa-paperclip"></i>
                            </button>
                        </div>
                        <div class="relative flex-1">
                            <textarea 
                                x-ref="messageInput"
                                class="message-input" 
                                placeholder="Tulis pesan..." 
                                x-model="newMessage"
                                @input="handleTyping()"
                                @keydown.enter.prevent="sendMessage()"
                                rows="1"
                            ></textarea>
                        </div>
                        <button type="button" class="send-button" @click="sendMessage()" :disabled="!newMessage.trim()" title="Kirim Pesan">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function chatApp() {
    return {
        sidebarOpen: false,
        selectedChat: 'BS Lodaya II',
        newMessage: '',
        chats: {
            'BS Lodaya II': {
                name: 'BS Lodaya II',
                avatar: 'https://randomuser.me/api/portraits/men/32.jpg',
                online: true,
                lastSeen: '2 menit yang lalu',
                typing: false,
                messages: [
                    {
                        id: 1,
                        type: 'received',
                        content: 'Baik <span class="message-time">00:08</span>',
                        timestamp: '00:08'
                    },
                    {
                        id: 2,
                        type: 'sent',
                        content: 'Halo, saya akan kesana ya. Mohon ditunggu <span class="message-time">00:08 <i class="fas fa-check-double status-read"></i></span>',
                        timestamp: '00:08',
                        status: 'read'
                    },
                    {
                        id: 3,
                        type: 'sent',
                        content: 'Baik terima kasih <span class="message-time">00:08 <i class="fas fa-check-double status-read"></i></span>',
                        timestamp: '00:08',
                        status: 'read'
                    },
                    {
                        id: 4,
                        type: 'received',
                        content: 'Terima kasih sudah menghubungi kami. Sampah akan segera dijemput dalam waktu 30 menit. <span class="message-time">00:10</span>',
                        timestamp: '00:10'
                    },
                    {
                        id: 5,
                        type: 'sent',
                        content: 'Baik, saya tunggu. Lokasi sudah saya kirim di maps. <span class="message-time">00:11 <i class="fas fa-check-double status-read"></i></span>',
                        timestamp: '00:11',
                        status: 'read'
                    }
                ]
            },
            'Wugis': {
                name: 'Wugis',
                avatar: 'https://randomuser.me/api/portraits/women/44.jpg',
                online: false,
                lastSeen: '1 jam yang lalu',
                typing: false,
                messages: [
                    {
                        id: 1,
                        type: 'received',
                        content: 'Halo, ada sampah untuk dijemput <span class="message-time">11:30</span>',
                        timestamp: '11:30'
                    },
                    {
                        id: 2,
                        type: 'sent',
                        content: 'Baik, akan saya jemput sebentar lagi <span class="message-time">11:35 <i class="fas fa-check-double status-delivered"></i></span>',
                        timestamp: '11:35',
                        status: 'delivered'
                    }
                ]
            },
            'Bank Sampah Central': {
                name: 'Bank Sampah Central',
                avatar: 'https://randomuser.me/api/portraits/men/45.jpg',
                online: true,
                lastSeen: '5 menit yang lalu',
                typing: false,
                messages: [
                    {
                        id: 1,
                        type: 'received',
                        content: 'Sampah sudah dijemput dan diproses <span class="message-time">10:20</span>',
                        timestamp: '10:20'
                    }
                ]
            }
        },
        
        get currentChat() {
            return this.chats[this.selectedChat] || this.chats['BS Lodaya II'];
        },
        
        init() {
            this.$nextTick(() => {
                this.scrollToBottom();
                this.autoResizeTextarea();
            });
        },
        
        selectChat(chatName) {
            this.selectedChat = chatName;
            this.newMessage = '';
            
            // Update active state in chat list
            document.querySelectorAll('.chat-list-item').forEach(item => {
                item.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
            
            this.$nextTick(() => {
                this.scrollToBottom();
            });
        },
        
        sendMessage() {
            if (this.newMessage.trim()) {
                const message = {
                    id: Date.now(),
                    type: 'sent',
                    content: `${this.newMessage} <span class="message-time">${this.getCurrentTime()} <i class="fas fa-check status-sent"></i></span>`,
                    timestamp: this.getCurrentTime(),
                    status: 'sent'
                };
                
                this.currentChat.messages.push(message);
                this.newMessage = '';
                
                this.$nextTick(() => {
                    this.scrollToBottom();
                    this.autoResizeTextarea();
                });
                
                // Simulate typing response
                setTimeout(() => {
                    this.currentChat.typing = true;
                    setTimeout(() => {
                        this.currentChat.typing = false;
                        const responses = [
                            'Pesan diterima! Terima kasih',
                            'Baik, akan kami proses segera',
                            'Terima kasih atas informasinya',
                            'Sampah akan dijemput sesuai jadwal',
                            'Konfirmasi diterima'
                        ];
                        const randomResponse = responses[Math.floor(Math.random() * responses.length)];
                        const response = {
                            id: Date.now(),
                            type: 'received',
                            content: `${randomResponse} <span class="message-time">${this.getCurrentTime()}</span>`,
                            timestamp: this.getCurrentTime()
                        };
                        this.currentChat.messages.push(response);
                        this.$nextTick(() => {
                            this.scrollToBottom();
                        });
                    }, 1500);
                }, 1000);
            }
        },
        
        handleTyping() {
            if (this.currentChat.typing) return;
            
            this.currentChat.typing = true;
            setTimeout(() => {
                this.currentChat.typing = false;
            }, 3000);
        },
        
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const message = {
                    id: Date.now(),
                    type: 'sent',
                    content: `<div class="flex items-center gap-2 p-2 bg-white/20 rounded-lg">
                        <i class="fas fa-file text-lg"></i>
                        <div>
                            <div class="font-medium">${file.name}</div>
                            <div class="text-xs opacity-70">${this.formatFileSize(file.size)}</div>
                        </div>
                    </div>
                    <span class="message-time">${this.getCurrentTime()} <i class="fas fa-check status-sent"></i></span>`,
                    timestamp: this.getCurrentTime(),
                    status: 'sent'
                };
                
                this.currentChat.messages.push(message);
                event.target.value = '';
                
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
            }
        },
        
        formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        },
        
        getCurrentTime() {
            return new Date().toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit'
            });
        },
        
        scrollToBottom() {
            const container = this.$refs.messagesContainer;
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        },
        
        autoResizeTextarea() {
            const textarea = this.$refs.messageInput;
            if (textarea) {
                textarea.style.height = 'auto';
                textarea.style.height = Math.min(textarea.scrollHeight, 120) + 'px';
            }
        },
        
        toggleVoiceCall() {
            // Simulate voice call
            const chatName = this.currentChat.name;
            alert(`Memulai panggilan suara dengan ${chatName}...`);
        },
        
        toggleVideoCall() {
            // Simulate video call
            const chatName = this.currentChat.name;
            alert(`Memulai panggilan video dengan ${chatName}...`);
        },
        
        toggleSearch() {
            // Simulate search functionality
            const searchTerm = prompt('Masukkan kata kunci pencarian:');
            if (searchTerm) {
                alert(`Mencari: "${searchTerm}" dalam chat ${this.currentChat.name}`);
            }
        },
        
        toggleChatMenu() {
            // Simulate chat menu
            const options = ['Lihat Profil', 'Blokir', 'Hapus Chat', 'Ekspor Chat'];
            const choice = prompt(`Menu Chat ${this.currentChat.name}:\n${options.map((opt, i) => `${i + 1}. ${opt}`).join('\n')}\n\nPilih opsi (1-4):`);
            if (choice && choice >= 1 && choice <= 4) {
                alert(`Anda memilih: ${options[choice - 1]}`);
            }
        },
        
        toggleEmojiPicker() {
            // Simulate emoji picker
            const emojis = ['😊', '😂', '❤️', '👍', '🎉', '🔥', '😍', '🤔', '👏', '💯', '✨', '🙏'];
            const randomEmoji = emojis[Math.floor(Math.random() * emojis.length)];
            this.newMessage += randomEmoji;
            this.$refs.messageInput.focus();
        }
    }
}
</script>
@endsection 