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
    .reading-progress {
        position: fixed;
        top: 48px;
        left: 0;
        width: 100%;
        height: 3px;
        background: #e5e7eb;
        z-index: 30;
    }
    .reading-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #10b981, #059669);
        width: 0%;
        transition: width 0.3s ease;
    }
    .article-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        width: 100%;
    }
    .article-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }
    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: white;
        border-radius: 25px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        font-size: 0.875rem;
        color: #6b7280;
    }
    .article-content {
        line-height: 1.8;
        font-size: 1.1rem;
        color: #374151;
    }
    .article-content p {
        margin-bottom: 1.5rem;
    }
    .article-content h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin: 2rem 0 1rem 0;
        border-left: 4px solid #10b981;
        padding-left: 1rem;
    }
    .article-content h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #374151;
        margin: 1.5rem 0 1rem 0;
    }
    .social-share {
        display: flex;
        gap: 1rem;
        margin: 2rem 0;
        justify-content: center;
        flex-wrap: wrap;
    }
    .share-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .share-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .share-facebook {
        background: #1877f2;
        color: white;
    }
    .share-twitter {
        background: #1da1f2;
        color: white;
    }
    .share-whatsapp {
        background: #25d366;
        color: white;
    }
    .share-telegram {
        background: #0088cc;
        color: white;
    }
    .related-articles {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-top: 3rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        width: 100%;
    }
    .article-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
        width: 100%;
        max-width: 350px;
    }
    .article-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    .article-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .article-info {
        padding: 1.5rem;
    }
    .article-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }
    .article-excerpt {
        color: #6b7280;
        font-size: 0.875rem;
        line-height: 1.5;
        margin-bottom: 1rem;
    }
    .article-date {
        color: #9ca3af;
        font-size: 0.75rem;
    }
    .back-btn {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 25px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }
    .back-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        color: white;
    }
    .decorative-element {
        position: absolute;
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #75E6DA, #05445E);
        border-radius: 50%;
        opacity: 0.1;
        z-index: -1;
    }
    .decorative-element.top-right {
        top: -50px;
        right: -50px;
    }
    .decorative-element.bottom-left {
        bottom: -50px;
        left: -50px;
    }
    .article-stats {
        display: flex;
        gap: 2rem;
        margin: 2rem 0;
        justify-content: center;
        flex-wrap: wrap;
    }
    .stat-item {
        text-align: center;
        padding: 1rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        min-width: 100px;
    }
    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #10b981;
    }
    .stat-label {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }
    .main-content-wrapper {
        min-height: 100vh;
        background: #f8fafc;
        padding-top: 60px;
        padding-left: 1.5cm;
        padding-right: 1.5cm;
        transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .content-container {
        width: 100%;
        margin: 0;
        padding: 0;
        position: relative;
    }
    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 45;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    .sidebar-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    
    /* Responsive fixes */
    @media (max-width: 768px) {
        .main-content-wrapper {
            padding-left: 0.5cm;
            padding-right: 0.5cm;
        }
        .content-container {
            padding: 0;
        }
    }
    
    @media (min-width: 769px) and (max-width: 1023px) {
        .main-content-wrapper {
            padding-left: 1cm;
            padding-right: 1cm;
        }
    }
    
    @media (min-width: 1024px) {
        .main-content-wrapper {
            padding-left: 1.5cm;
            padding-right: 1.5cm;
        }
    }
    
    /* Remove any unwanted spacing */
    .article-header,
    .related-articles,
    .bg-white.rounded-2xl {
        margin-left: 0;
        margin-right: 0;
        width: 100%;
    }
    
    /* Ensure full width content */
    .max-w-4xl,
    .max-w-6xl {
        max-width: none !important;
    }
    
    /* Full width for all content */
    .article-header,
    .related-articles,
    .bg-white.rounded-2xl,
    .social-share,
    .text-center {
        width: 100% !important;
        max-width: 100% !important;
    }
</style>

<div class="flex min-h-screen bg-gray-50" x-data="{ sidebarOpen: false }">
    {{-- Reading Progress Bar --}}
    <div class="reading-progress">
        <div class="reading-progress-bar" id="readingProgress"></div>
    </div>

    {{-- Sidebar Overlay --}}
    <div class="sidebar-overlay" :class="{ 'active': sidebarOpen }" @click="sidebarOpen = false"></div>

    {{-- Sidebar --}}
    <aside
        x-data="{ open: false, active: 'berita' }"
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
            <h1 class="text-white font-semibold text-lg">Berita</h1>
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
            <div class="w-full h-full relative">
                {{-- Decorative Elements --}}
                <div class="decorative-element top-right"></div>
                <div class="decorative-element bottom-left"></div>

                {{-- Article Header --}}
                <div class="article-header w-full">
                    <div class="article-meta">
                        <div class="meta-item">
                            <i class="fas fa-user text-blue-500"></i>
                            <span>Wugis</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calendar text-green-500"></i>
                            <span>15 Januari 2024</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock text-purple-500"></i>
                            <span>5 menit baca</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-tag text-orange-500"></i>
                            <span>Teknologi</span>
                        </div>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                        Pentingnya Pengelolaan Sampah Berbasis Teknologi
                    </h1>
                    
                    <p class="text-xl text-gray-600 leading-relaxed">
                        Inovasi teknologi dalam pengelolaan sampah menjadi kunci keberhasilan menuju masa depan yang lebih hijau dan berkelanjutan.
                    </p>
                </div>

                {{-- Featured Image --}}
                <div class="relative mb-8">
                    <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80" 
                         class="w-full h-96 object-cover rounded-2xl shadow-2xl" alt="Berita">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent rounded-2xl"></div>
                </div>

                {{-- Article Stats --}}
                <div class="article-stats">
                    <div class="stat-item">
                        <div class="stat-number">2.5K</div>
                        <div class="stat-label">Dibaca</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">156</div>
                        <div class="stat-label">Suka</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">23</div>
                        <div class="stat-label">Komentar</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">89</div>
                        <div class="stat-label">Bagikan</div>
                    </div>
                </div>

                {{-- Article Content --}}
                <div class="bg-white rounded-2xl p-8 shadow-xl mb-8 w-full">
                    <div class="article-content">
                        <p class="text-lg leading-relaxed mb-6">
                            Para pelaku UMKM semakin memperhatikan pentingnya pengelolaan sampah melalui pendekatan daur ulang yang berbasis teknologi. Dengan inovasi dan kolaborasi, pengelolaan sampah kini menjadi peluang bisnis sekaligus solusi lingkungan. Teknologi digital, IoT, dan edukasi masyarakat menjadi kunci sukses pengelolaan sampah modern.
                        </p>

                        <h2>Revolusi Teknologi dalam Pengelolaan Sampah</h2>
                        <p>
                            Teknologi digital telah mengubah cara kita melihat dan mengelola sampah. Dari aplikasi mobile yang memudahkan pelaporan sampah hingga sistem IoT yang memantau volume sampah secara real-time, teknologi memberikan solusi yang lebih efisien dan efektif.
                        </p>

                        <h3>Manfaat Teknologi dalam Pengelolaan Sampah</h3>
                        <ul class="list-disc list-inside space-y-2 mb-6">
                            <li>Efisiensi dalam pengumpulan dan pemilahan sampah</li>
                            <li>Peningkatan kesadaran masyarakat melalui edukasi digital</li>
                            <li>Optimasi rute pengangkutan sampah</li>
                            <li>Monitoring real-time volume dan jenis sampah</li>
                            <li>Peningkatan nilai ekonomi dari sampah daur ulang</li>
                        </ul>

                        <p>
                Selain itu, peran komunitas sangat penting dalam mendorong perubahan perilaku dan membangun ekosistem daur ulang yang berkelanjutan. Pemerintah, pelaku usaha, dan masyarakat perlu bersinergi agar pengelolaan sampah tidak hanya berdampak pada lingkungan, tetapi juga ekonomi lokal.
                        </p>

                        <h2>Kolaborasi Multi-Stakeholder</h2>
                        <p>
                            Keberhasilan pengelolaan sampah berbasis teknologi membutuhkan kolaborasi dari berbagai pihak. Pemerintah sebagai regulator, pelaku usaha sebagai inovator, dan masyarakat sebagai pengguna aktif harus bekerja sama menciptakan sistem yang berkelanjutan.
                        </p>
                    </div>
                </div>

                {{-- Social Share --}}
                <div class="social-share">
                    <a href="#" class="share-btn share-facebook">
                        <i class="fab fa-facebook-f"></i>
                        <span>Bagikan</span>
                    </a>
                    <a href="#" class="share-btn share-twitter">
                        <i class="fab fa-twitter"></i>
                        <span>Tweet</span>
                    </a>
                    <a href="#" class="share-btn share-whatsapp">
                        <i class="fab fa-whatsapp"></i>
                        <span>WhatsApp</span>
                    </a>
                    <a href="#" class="share-btn share-telegram">
                        <i class="fab fa-telegram-plane"></i>
                        <span>Telegram</span>
                    </a>
                </div>

                {{-- Back Button --}}
                <div class="text-center mb-8">
                    <a href="/berita" class="back-btn">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali ke Berita</span>
                    </a>
                </div>

                {{-- Related Articles --}}
                <div class="related-articles w-full">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Artikel Terkait</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 justify-items-center">
                        <div class="article-card">
                            <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=400&q=80" 
                                 class="article-image" alt="Artikel 1">
                            <div class="article-info">
                                <h4 class="article-title">Inovasi Teknologi Daur Ulang</h4>
                                <p class="article-excerpt">Teknologi terbaru dalam proses daur ulang sampah plastik...</p>
                                <div class="article-date">12 Januari 2024</div>
                            </div>
                        </div>
                        <div class="article-card">
                            <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?auto=format&fit=crop&w=400&q=80" 
                                 class="article-image" alt="Artikel 2">
                            <div class="article-info">
                                <h4 class="article-title">Komunitas Hijau di Indonesia</h4>
                                <p class="article-excerpt">Gerakan komunitas peduli lingkungan di berbagai kota...</p>
                                <div class="article-date">10 Januari 2024</div>
                            </div>
                        </div>
                        <div class="article-card">
                            <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?auto=format&fit=crop&w=400&q=80" 
                                 class="article-image" alt="Artikel 3">
                            <div class="article-info">
                                <h4 class="article-title">Ekonomi Sirkular Berkelanjutan</h4>
                                <p class="article-excerpt">Membangun sistem ekonomi yang ramah lingkungan...</p>
                                <div class="article-date">8 Januari 2024</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Reading Progress Bar
window.addEventListener('scroll', () => {
    const scrollTop = window.pageYOffset;
    const docHeight = document.body.offsetHeight - window.innerHeight;
    const scrollPercent = (scrollTop / docHeight) * 100;
    document.getElementById('readingProgress').style.width = scrollPercent + '%';
});
</script>
@endsection 