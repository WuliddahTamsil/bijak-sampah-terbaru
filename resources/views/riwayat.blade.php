@extends('layouts.non-nasabah-layout')

@php
$activeMenu = 'riwayat';
@endphp

@section('title', 'Riwayat - Bijak Sampah')

@section('additional-styles')
<style>
    .main-content-wrapper {
        background: white;
        min-height: 100vh;
        width: 100%;
        margin: 0;
        padding: 0;
    }

    .content-container {
        width: 100%;
        margin: 0;
        padding: 2rem;
        max-width: none;
    }

    .page-title {
        color: #05445E;
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 2rem;
    }

    .page-subtitle {
        color: #666;
        text-align: center;
        font-size: 1.1rem;
        margin-bottom: 3rem;
    }

    .stats-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 16px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(117, 230, 218, 0.2);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(117, 230, 218, 0.3);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .filter-section {
        margin-bottom: 2rem;
    }

    .filter-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }

    .filter-btn {
        background: #f8f9fa;
        color: #05445E;
        border: 2px solid #e9ecef;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .filter-btn:hover {
        background: #e9ecef;
        transform: translateY(-2px);
    }

    .filter-btn.active {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
        color: white;
        border-color: transparent;
        font-weight: 600;
    }

    .search-section {
        margin-bottom: 2rem;
    }

    .search-bar {
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 25px;
        padding: 0.75rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        max-width: 500px;
        margin: 0 auto;
    }

    .search-bar:focus-within {
        border-color: #75E6DA;
        box-shadow: 0 0 0 3px rgba(117, 230, 218, 0.2);
    }

    .search-input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 1rem;
        color: #333;
        background: transparent;
    }

    .search-btn {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .search-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(117, 230, 218, 0.3);
    }

    .history-list {
        margin-bottom: 2rem;
    }

    .history-item {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .history-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .history-item.success {
        border-left-color: #10b981;
    }

    .history-item.pending {
        border-left-color: #f59e0b;
    }

    .history-item.failed {
        border-left-color: #ef4444;
    }

    .history-item.info {
        border-left-color: #3b82f6;
    }

    .history-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .history-left {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex: 1;
    }

    .history-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .history-icon.success {
        background: #d1fae5;
        color: #10b981;
    }

    .history-icon.pending {
        background: #fef3c7;
        color: #f59e0b;
    }

    .history-icon.failed {
        background: #fee2e2;
        color: #ef4444;
    }

    .history-icon.info {
        background: #dbeafe;
        color: #3b82f6;
    }

    .history-details h3 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.25rem;
    }

    .history-details p {
        color: #666;
        font-size: 0.9rem;
        margin: 0;
    }

    .history-status {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .history-status.success {
        background: #d1fae5;
        color: #065f46;
    }

    .history-status.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .history-status.failed {
        background: #fee2e2;
        color: #991b1b;
    }

    .history-status.info {
        background: #dbeafe;
        color: #1e40af;
    }

    .load-more {
        text-align: center;
        margin: 2rem 0;
    }

    .load-more-btn {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .load-more-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(117, 230, 218, 0.3);
    }

    .load-more-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    .no-results {
        text-align: center;
        padding: 4rem 2rem;
        color: #666;
    }

    .no-results i {
        font-size: 4rem;
        color: #ccc;
        margin-bottom: 1rem;
    }

    .history-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #75E6DA 0%, #05445E 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .history-item:hover::before {
        opacity: 1;
    }

    .history-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e9ecef;
    }

    .action-btn {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
    }

    .action-btn.primary {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
        color: white;
    }

    .action-btn.secondary {
        background: #f8f9fa;
        color: #666;
        border: 1px solid #e9ecef;
    }

    .action-btn:hover {
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .content-container {
            padding: 1rem;
        }
        
        .page-title {
            font-size: 2rem;
        }
        
        .history-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .history-left {
            width: 100%;
        }
        
        .filter-buttons {
            gap: 0.5rem;
        }
        
        .filter-btn {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>
@endsection

@section('content')
<div class="main-content-wrapper">
    <div class="content-container">
        <h1 class="page-title">
            <i class="fas fa-history text-blue-500 mr-3"></i>
            Riwayat Aktivitas
        </h1>
        <p class="page-subtitle">Lihat semua aktivitas dan transaksi Anda</p>
        
        <!-- Statistics Section -->
        <div class="stats-section">
            <div class="stat-card">
                <div class="stat-number" id="totalActivities">0</div>
                <div class="stat-label">Total Aktivitas</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="successCount">0</div>
                <div class="stat-label">Berhasil</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="pendingCount">0</div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="failedCount">0</div>
                <div class="stat-label">Gagal</div>
            </div>
        </div>
        
        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">Semua</button>
                <button class="filter-btn" data-filter="transaksi">Transaksi</button>
                <button class="filter-btn" data-filter="aktivitas">Aktivitas</button>
                <button class="filter-btn" data-filter="reward">Reward</button>
                <button class="filter-btn" data-filter="challenge">Challenge</button>
            </div>
        </div>
        
        <!-- Search Section -->
        <div class="search-section">
            <div class="search-bar">
                <i class="fas fa-search text-gray-400"></i>
                <input type="text" id="searchInput" class="search-input" placeholder="Cari aktivitas...">
                <button id="searchBtn" class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        
        <!-- History List -->
        <div class="history-list" id="historyList">
            <!-- Items will be loaded here -->
        </div>
        
        <!-- No Results Message -->
        <div class="no-results" id="noResultsMessage" style="display: none;">
            <i class="fas fa-search"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak ada aktivitas ditemukan</h3>
            <p class="text-gray-500">Coba ubah filter atau kata kunci pencarian</p>
        </div>
        
        <!-- Load More Button -->
        <div class="load-more" id="loadMoreSection" style="display: none;">
            <button class="load-more-btn" id="loadMoreBtn" onclick="loadMore()">
                <i class="fas fa-plus mr-2"></i>
                Muat Lebih Banyak
            </button>
        </div>
    </div>
</div>
@endsection

@section('additional-scripts')
<script>
    let historyItems = [];
    let currentFilter = 'all';
    let currentSearch = '';
    let currentPage = 1;
    const itemsPerPage = 10;

    // Sample data
    const sampleHistory = [
        {
            id: 1,
            title: 'Pembelian Tas Belanja',
            description: 'Rp 89.000 • 2 jam yang lalu',
            type: 'transaksi',
            status: 'success',
            icon: 'fas fa-shopping-cart',
            date: '2024-01-15T10:30:00',
            amount: 89000,
            details: 'Pembelian tas belanja reusable premium'
        },
        {
            id: 2,
            title: 'Penukaran Poin',
            description: '1.000 Poin • 5 jam yang lalu',
            type: 'reward',
            status: 'pending',
            icon: 'fas fa-gift',
            date: '2024-01-15T08:15:00',
            amount: 1000,
            details: 'Penukaran poin untuk voucher belanja'
        },
        {
            id: 3,
            title: 'Eco Challenge Selesai',
            description: '+50 Poin • 1 hari yang lalu',
            type: 'challenge',
            status: 'success',
            icon: 'fas fa-star',
            date: '2024-01-14T15:45:00',
            amount: 50,
            details: 'Menyelesaikan challenge "Kurangi Sampah Plastik"'
        },
        {
            id: 4,
            title: 'Donasi Sampah',
            description: '5 kg • 2 hari yang lalu',
            type: 'aktivitas',
            status: 'success',
            icon: 'fas fa-recycle',
            date: '2024-01-13T09:20:00',
            amount: 5,
            details: 'Donasi sampah organik ke bank sampah'
        },
        {
            id: 5,
            title: 'Pembayaran Gagal',
            description: 'Rp 125.000 • 3 hari yang lalu',
            type: 'transaksi',
            status: 'failed',
            icon: 'fas fa-credit-card',
            date: '2024-01-12T14:30:00',
            amount: 125000,
            details: 'Pembayaran botol tumbler gagal diproses'
        },
        {
            id: 6,
            title: 'Eco Challenge Baru',
            description: 'Challenge "Hemat Air" • 4 hari yang lalu',
            type: 'challenge',
            status: 'info',
            icon: 'fas fa-trophy',
            date: '2024-01-11T11:00:00',
            amount: 0,
            details: 'Memulai challenge baru untuk menghemat air'
        },
        {
            id: 7,
            title: 'Reward Poin',
            description: '+25 Poin • 5 hari yang lalu',
            type: 'reward',
            status: 'success',
            icon: 'fas fa-coins',
            date: '2024-01-10T16:20:00',
            amount: 25,
            details: 'Mendapatkan poin reward dari aktivitas harian'
        },
        {
            id: 8,
            title: 'Pembelian Kompos',
            description: 'Rp 45.000 • 1 minggu yang lalu',
            type: 'transaksi',
            status: 'success',
            icon: 'fas fa-seedling',
            date: '2024-01-08T13:15:00',
            amount: 45000,
            details: 'Pembelian kompos organik premium'
        }
    ];

    // Initialize history
    document.addEventListener('DOMContentLoaded', function() {
        loadHistory();
        setupEventListeners();
    });

    function setupEventListeners() {
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const searchBtn = document.getElementById('searchBtn');
        
        searchBtn.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
        
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(performSearch, 300);
        });

        // Filter functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                currentFilter = this.getAttribute('data-filter');
                currentPage = 1;
                renderHistory();
            });
        });
    }

    function loadHistory() {
        // Load from localStorage or use sample data
        const savedHistory = localStorage.getItem('historyItems');
        if (savedHistory) {
            historyItems = JSON.parse(savedHistory);
        } else {
            historyItems = [...sampleHistory];
            localStorage.setItem('historyItems', JSON.stringify(historyItems));
        }
        renderHistory();
    }

    function renderHistory() {
        const list = document.getElementById('historyList');
        const noResultsMessage = document.getElementById('noResultsMessage');
        const loadMoreSection = document.getElementById('loadMoreSection');
        
        // Filter items
        let filteredItems = historyItems.filter(item => {
            const matchesFilter = currentFilter === 'all' || item.type === currentFilter;
            const matchesSearch = currentSearch === '' || 
                item.title.toLowerCase().includes(currentSearch) || 
                item.description.toLowerCase().includes(currentSearch) ||
                item.details.toLowerCase().includes(currentSearch);
            return matchesFilter && matchesSearch;
        });

        // Sort by date (newest first)
        filteredItems.sort((a, b) => new Date(b.date) - new Date(a.date));

        // Pagination
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const itemsToShow = filteredItems.slice(startIndex, endIndex);

        if (filteredItems.length === 0) {
            list.innerHTML = '';
            noResultsMessage.style.display = 'block';
            loadMoreSection.style.display = 'none';
        } else {
            noResultsMessage.style.display = 'none';
            list.innerHTML = '';
            
            itemsToShow.forEach(item => {
                const itemElement = createHistoryItem(item);
                list.appendChild(itemElement);
            });

            // Show/hide load more button
            if (endIndex < filteredItems.length) {
                loadMoreSection.style.display = 'block';
            } else {
                loadMoreSection.style.display = 'none';
            }
        }

        updateStats(filteredItems);
    }

    function createHistoryItem(item) {
        const div = document.createElement('div');
        div.className = `history-item ${item.status}`;
        div.setAttribute('data-id', item.id);
        
        const statusText = getStatusText(item.status);
        const timeAgo = getTimeAgo(new Date(item.date));
        
        div.innerHTML = `
            <div class="history-content">
                <div class="history-left">
                    <div class="history-icon ${item.status}">
                        <i class="${item.icon}"></i>
                    </div>
                    <div class="history-details">
                        <h3>${item.title}</h3>
                        <p>${item.description.replace(/• \d+ (jam|hari|minggu) yang lalu/, `• ${timeAgo}`)}</p>
                    </div>
                </div>
                <span class="history-status ${item.status}">${statusText}</span>
            </div>
            <div class="history-actions">
                <button class="action-btn primary" onclick="viewDetails(${item.id})">
                    <i class="fas fa-eye mr-1"></i>
                    Detail
                </button>
                <button class="action-btn secondary" onclick="shareActivity(${item.id})">
                    <i class="fas fa-share mr-1"></i>
                    Bagikan
                </button>
            </div>
        `;
        
        return div;
    }

    function getStatusText(status) {
        const statusMap = {
            'success': 'Berhasil',
            'pending': 'Pending',
            'failed': 'Gagal',
            'info': 'Info'
        };
        return statusMap[status] || status;
    }

    function getTimeAgo(date) {
        const now = new Date();
        const diffInSeconds = Math.floor((now - date) / 1000);
        
        if (diffInSeconds < 60) {
            return 'Baru saja';
        } else if (diffInSeconds < 3600) {
            const minutes = Math.floor(diffInSeconds / 60);
            return `${minutes} menit yang lalu`;
        } else if (diffInSeconds < 86400) {
            const hours = Math.floor(diffInSeconds / 3600);
            return `${hours} jam yang lalu`;
        } else if (diffInSeconds < 2592000) {
            const days = Math.floor(diffInSeconds / 86400);
            return `${days} hari yang lalu`;
        } else {
            const weeks = Math.floor(diffInSeconds / 604800);
            return `${weeks} minggu yang lalu`;
        }
    }

    function updateStats(items) {
        const totalActivities = items.length;
        const successCount = items.filter(item => item.status === 'success').length;
        const pendingCount = items.filter(item => item.status === 'pending').length;
        const failedCount = items.filter(item => item.status === 'failed').length;

        document.getElementById('totalActivities').textContent = totalActivities;
        document.getElementById('successCount').textContent = successCount;
        document.getElementById('pendingCount').textContent = pendingCount;
        document.getElementById('failedCount').textContent = failedCount;
    }

    function performSearch() {
        currentSearch = document.getElementById('searchInput').value.toLowerCase().trim();
        currentPage = 1;
        renderHistory();
    }

    function loadMore() {
        currentPage++;
        renderHistory();
    }

    function viewDetails(id) {
        const item = historyItems.find(item => item.id === id);
        if (item) {
            alert(`Detail Aktivitas:\n\nJudul: ${item.title}\nDeskripsi: ${item.details}\nStatus: ${getStatusText(item.status)}\nTanggal: ${new Date(item.date).toLocaleString()}`);
        }
    }

    function shareActivity(id) {
        const item = historyItems.find(item => item.id === id);
        if (item) {
            const shareText = `Saya baru saja ${item.title.toLowerCase()} di BijakSampah! 🌱♻️`;
            if (navigator.share) {
                navigator.share({
                    title: 'Aktivitas BijakSampah',
                    text: shareText,
                    url: window.location.href
                });
            } else {
                // Fallback for browsers that don't support Web Share API
                const textArea = document.createElement('textarea');
                textArea.value = shareText;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                alert('Teks telah disalin ke clipboard!');
            }
        }
    }
</script>
@endsection 