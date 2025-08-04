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
    /* Fix sidebar z-index to be above main content */
    .sidebar-fixed {
        z-index: 1000 !important;
    }
    /* Ensure main content doesn't overlap sidebar */
    .main-content-area {
        position: relative;
        z-index: 1;
    }
    .emoji-radio input:checked + span {
        border: 3px solid #0CC9C8;
        box-shadow: 0 0 20px rgba(12, 201, 200, 0.4);
        transform: scale(1.3);
        background: linear-gradient(135deg, #e0f7fa 0%, #b2f5ea 100%);
        animation: pulse 2s infinite;
    }
    .emoji-radio span {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 9999px;
        padding: 0.5em 0.8em;
        display: inline-block;
        cursor: pointer;
        border: 2px solid transparent;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
    }
    .emoji-radio span:hover {
        transform: scale(1.1);
        background: rgba(255, 255, 255, 0.2);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1.3); }
        50% { transform: scale(1.4); }
    }
    .feedback-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(20px);
        transition: all 0.3s ease;
    }
    .feedback-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
    }
    .form-input {
        background: #ffffff;
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        padding: 16px 20px 16px 50px;
        font-size: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        width: 100%;
        outline: none;
    }
    .form-input:focus {
        border-color: #0CC9C8;
        box-shadow: 0 0 0 3px rgba(12, 201, 200, 0.1), 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-1px);
    }
    .input-container {
        position: relative;
        width: 100%;
    }
    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        font-size: 18px;
        z-index: 10;
    }
    .submit-btn {
        background: linear-gradient(135deg, #10b981, #0CC9C8);
        color: white;
        padding: 16px 32px;
        border-radius: 16px;
        font-weight: 600;
        font-size: 16px;
        border: none;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        position: relative;
        overflow: hidden;
    }
    .submit-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(16, 185, 129, 0.4);
    }
    .submit-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }
    .submit-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }
    .submit-btn:hover::before {
        left: 100%;
    }
    .floating-icon {
        animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    .hero-title {
        background: linear-gradient(135deg, #1f2937, #374151);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .rating-container {
        text-align: center;
        padding: 2rem;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 20px;
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
    }
    .rating-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, #10b981, #0CC9C8);
        border-radius: 20px;
        z-index: -1;
        animation: borderGlow 2s ease-in-out infinite;
    }
    .success-popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: linear-gradient(135deg, #ffffff 0%, #f0fdfa 100%);
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        text-align: center;
        min-width: 400px;
        border: 2px solid #10b981;
        animation: popupSlideIn 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .success-popup::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(135deg, #10b981, #0CC9C8);
        border-radius: 20px;
        z-index: -1;
        animation: borderGlow 2s ease-in-out infinite;
    }
    @keyframes popupSlideIn {
        from {
            opacity: 0;
            transform: translate(-50%, -50%) scale(0.8);
        }
        to {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }
    }
    @keyframes borderGlow {
        0%, 100% { opacity: 0.5; }
        50% { opacity: 1; }
    }
    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
        z-index: 999;
        animation: fadeIn 0.3s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .success-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #10b981, #0CC9C8);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        animation: iconBounce 0.6s ease-out 0.3s both;
    }
    @keyframes iconBounce {
        0% { transform: scale(0); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
</style>

<div class="flex min-h-screen bg-gradient-to-br from-blue-50 via-teal-50 to-cyan-50" x-data="feedbackApp()" x-init="init()">
    {{-- Sidebar --}}
    <aside
        x-data="{ open: false, active: 'feedback' }"
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
                <a href="{{ route('chat') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'chat' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'chat' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
                    <i class="fas fa-comment-dots text-lg"></i>
                    <span x-show="open" class="text-sm font-medium">Pesan</span>
                </a>
                
                {{-- Umpan Balik Link --}}
                <a href="{{ route('feedback') }}" class="flex items-center gap-3 p-3 rounded-lg sidebar-item-hover whitespace-nowrap w-full" :class="open ? (active === 'feedback' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/20 text-white') : (active === 'feedback' ? 'bg-white/20 text-white justify-center' : 'hover:bg-white/20 text-white justify-center')">
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
            <div class="max-w-4xl mx-auto">
                {{-- Hero Section --}}
                <div class="text-center mb-12">
                    <div class="inline-block mb-6">
                        <i class="fas fa-comments text-6xl text-teal-500 floating-icon"></i>
                    </div>
                    <h1 class="text-5xl font-bold mb-4 hero-title">
                        Mari beri <span class="text-teal-500">masukan</span><br>
                        tentang sesuatu <span class="text-teal-400">bersama-sama</span>
                    </h1>
                    <p class="text-gray-600 text-lg">Kami sangat menghargai setiap feedback dari Anda untuk pengembangan aplikasi yang lebih baik</p>
                </div>

                {{-- Feedback Card --}}
                <div class="feedback-card p-8">
                    <form class="space-y-8" method="POST" action="{{ route('feedback') }}" @submit.prevent="submitFeedback($event)">
                        @csrf
                        
                        {{-- Name Input --}}
                        <div class="input-container">
                            <i class="fas fa-user input-icon"></i>
                            <input 
                                name="name" 
                                type="text" 
                                class="form-input" 
                                placeholder="Nama Anda..." 
                                required
                                x-model="name"
                                @input="nameError = ''"
                                @blur="if (!name) nameError = 'Nama wajib diisi'"
                            >
                            <span x-show="nameError" x-text="nameError" class="text-red-500 text-xs absolute left-0 -bottom-5 pl-12"></span>
                        </div>

                        {{-- Email Input --}}
                        <div class="input-container">
                            <i class="fas fa-envelope input-icon"></i>
                            <input 
                                name="email" 
                                type="email" 
                                class="form-input" 
                                placeholder="Email Anda..." 
                                required
                                x-model="email"
                                @input="emailError = ''"
                                @blur="if (!email) emailError = 'Email wajib diisi'"
                            >
                            <span x-show="emailError" x-text="emailError" class="text-red-500 text-xs absolute left-0 -bottom-5 pl-12"></span>
                        </div>

                        {{-- Rating Section --}}
                        <div class="rating-container">
                            <label class="block text-gray-800 font-semibold text-xl mb-4 text-center">Bagaimana pengalaman Anda?</label>
                            <div class="flex gap-6 text-5xl justify-center mb-4">
                                <label class="emoji-radio">
                                    <input type="radio" name="rating" value="1" class="hidden" required x-model="rating">
                                    <span>😔</span>
                                </label>
                                <label class="emoji-radio">
                                    <input type="radio" name="rating" value="2" class="hidden" x-model="rating">
                                    <span>😟</span>
                                </label>
                                <label class="emoji-radio">
                                    <input type="radio" name="rating" value="3" class="hidden" x-model="rating">
                                    <span>🙂</span>
                                </label>
                                <label class="emoji-radio">
                                    <input type="radio" name="rating" value="4" class="hidden" x-model="rating">
                                    <span>😊</span>
                                </label>
                                <label class="emoji-radio">
                                    <input type="radio" name="rating" value="5" class="hidden" x-model="rating">
                                    <span>😁</span>
                                </label>
                            </div>
                            <p class="text-gray-500 text-center text-sm">Pilih salah satu!</p>
                        </div>

                        {{-- Message Input --}}
                        <div class="space-y-3">
                            <label class="block text-gray-800 font-semibold text-lg">Pesan Anda</label>
                            <textarea 
                                name="message" 
                                class="form-input" 
                                rows="5" 
                                placeholder="Kasih saran atau pendapat Anda!" 
                                required
                                x-model="message"
                            ></textarea>
                        </div>

                        {{-- Submit Button --}}
                        <div class="text-center pt-6">
                            <button type="submit" class="submit-btn" :disabled="!isValid" :class="!isValid ? 'opacity-50 cursor-not-allowed' : ''">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Send Feedback
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Success Popup --}}
    <div x-show="showSuccessPopup" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="popup-overlay" @click="showSuccessPopup = false">
        <div class="success-popup" @click.stop>
            <div class="success-icon">
                <i class="fas fa-check text-white text-3xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Feedback Terkirim!</h3>
            <p class="text-gray-600 mb-6">Terima kasih atas masukan Anda. Kami akan mempertimbangkan feedback ini untuk pengembangan aplikasi yang lebih baik.</p>
            <button @click="showSuccessPopup = false" class="bg-teal-500 hover:bg-teal-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
function feedbackApp() {
    return {
        sidebarOpen: false,
        showSuccessPopup: false,
        name: '',
        email: '',
        rating: '',
        message: '',
        nameError: '',
        emailError: '',
        get isValid() {
            return this.name && this.email && this.rating && this.message;
        },
        init() {
            // Initialize emoji selection
            this.$nextTick(() => {
                this.setupEmojiSelection();
            });
        },
        setupEmojiSelection() {
            document.querySelectorAll('.emoji-radio input[type=radio]').forEach(radio => {
                radio.addEventListener('change', (e) => {
                    // Reset all emojis
                    document.querySelectorAll('.emoji-radio span').forEach(span => {
                        span.style.background = '';
                        span.style.transform = '';
                        span.style.boxShadow = '';
                        span.style.border = '2px solid transparent';
                    });
                    
                    // Highlight selected emoji
                    if (e.target.checked) {
                        e.target.nextElementSibling.style.background = 'linear-gradient(135deg, #e0f7fa 0%, #b2f5ea 100%)';
                        e.target.nextElementSibling.style.transform = 'scale(1.3)';
                        e.target.nextElementSibling.style.boxShadow = '0 0 20px rgba(12, 201, 200, 0.4)';
                        e.target.nextElementSibling.style.border = '3px solid #0CC9C8';
                    }
                });
            });
        },
        submitFeedback(event) {
            console.log('Submit feedback called');
            console.log('Form data:', {
                name: this.name,
                email: this.email,
                rating: this.rating,
                message: this.message,
                isValid: this.isValid
            });
            
            // Validate form
            if (!this.name) {
                this.nameError = 'Nama wajib diisi';
                return;
            }
            if (!this.email) {
                this.emailError = 'Email wajib diisi';
                return;
            }
            if (!this.rating) {
                alert('Pilih rating pengalaman Anda!');
                return;
            }
            if (!this.message) {
                alert('Isi pesan feedback Anda!');
                return;
            }
            
            const form = event.target;
            const formData = new FormData(form);
            
            console.log('Sending request to:', form.action);
            
            // Show loading state
            const submitBtn = form.querySelector('.submit-btn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
            submitBtn.disabled = true;
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    this.showSuccessPopup = true;
                    this.name = '';
                    this.email = '';
                    this.rating = '';
                    this.message = '';
                    this.nameError = '';
                    this.emailError = '';
                    form.reset();
                    
                    // Reset emoji selection
                    document.querySelectorAll('.emoji-radio input[type=radio]').forEach(radio => {
                        radio.checked = false;
                    });
                    document.querySelectorAll('.emoji-radio span').forEach(span => {
                        span.style.background = '';
                        span.style.transform = '';
                        span.style.boxShadow = '';
                        span.style.border = '2px solid transparent';
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            })
            .finally(() => {
                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        }
    }
}
</script>

<script>
    // Add smooth scroll behavior
    document.documentElement.style.scrollBehavior = 'smooth';
</script>
@endsection