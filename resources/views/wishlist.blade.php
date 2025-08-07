@extends('layouts.non-nasabah-layout')

@php
$activeMenu = 'wishlist';
@endphp

@section('title', 'Wishlist - Bijak Sampah')

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

    .stats-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 16px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(117, 230, 218, 0.2);
    }

    .stat-number {
        font-size: 2rem;
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
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
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

    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .wishlist-item {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        border: 1px solid #e9ecef;
    }

    .wishlist-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .item-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 2;
    }

    .item-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .wishlist-item:hover .item-image {
        transform: scale(1.05);
    }

    .item-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
        margin: 1rem;
        margin-bottom: 0.5rem;
    }

    .item-description {
        color: #666;
        margin: 0 1rem 1rem;
        line-height: 1.5;
        font-size: 0.9rem;
    }

    .item-price {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        margin: 0 1rem 1rem;
        font-size: 1.5rem;
        font-weight: 700;
        color: #05445E;
    }

    .currency {
        font-size: 1rem;
        color: #666;
    }

    .item-actions {
        display: flex;
        gap: 0.5rem;
        margin: 1rem;
        margin-top: 0;
    }

    .btn-primary {
        flex: 1;
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
        color: white;
        border: none;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(117, 230, 218, 0.3);
    }

    .btn-danger {
        background: #ef4444;
        color: white;
        border: none;
        padding: 0.75rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-2px);
    }

    .add-item-section {
        text-align: center;
        margin: 3rem 0;
    }

    .add-item-btn {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1.1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .add-item-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(117, 230, 218, 0.3);
    }

    .no-items {
        text-align: center;
        padding: 4rem 2rem;
        color: #666;
    }

    .no-items i {
        font-size: 4rem;
        color: #ccc;
        margin-bottom: 1rem;
    }

    .load-more {
        text-align: center;
        margin: 2rem 0;
    }

    .load-more-btn {
        background: #f8f9fa;
        color: #05445E;
        border: 2px solid #e9ecef;
        padding: 0.75rem 2rem;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .load-more-btn:hover {
        background: #e9ecef;
        transform: translateY(-2px);
    }

    .load-more-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: white;
        border-radius: 16px;
        width: 90%;
        max-width: 500px;
        padding: 2rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        animation: modalFadeIn 0.3s ease-out;
        max-height: 80vh;
        overflow-y: auto;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e9ecef;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #05445E;
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #666;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .close-modal:hover {
        background: #f8f9fa;
        color: #05445E;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #75E6DA;
        box-shadow: 0 0 0 3px rgba(117, 230, 218, 0.2);
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(117, 230, 218, 0.3);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #d1d5db;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
    }

    @media (max-width: 768px) {
        .content-container {
            padding: 1rem;
        }
        
        .page-title {
            font-size: 2rem;
        }
        
        .wishlist-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .filter-buttons {
            gap: 0.5rem;
        }
        
        .filter-btn {
            padding: 0.4rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>
@endsection

@section('content')
<div class="main-content-wrapper">
    <div class="content-container">
        <h1 class="page-title">Wishlist Saya</h1>
        
        <!-- Statistics Section -->
        <div class="stats-section">
            <div class="stat-card">
                <div class="stat-number" id="totalItems">0</div>
                <div class="stat-label">Total Item</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="totalValue">Rp 0</div>
                <div class="stat-label">Total Nilai</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="avgPrice">Rp 0</div>
                <div class="stat-label">Rata-rata Harga</div>
            </div>
        </div>
        
        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">Semua</button>
                <button class="filter-btn" data-filter="tas-belanja">Tas Belanja</button>
                <button class="filter-btn" data-filter="botol-tumbler">Botol Tumbler</button>
                <button class="filter-btn" data-filter="kompos">Kompos</button>
                <button class="filter-btn" data-filter="produk-daur-ulang">Produk Daur Ulang</button>
            </div>
        </div>
        
        <!-- Search Section -->
        <div class="search-section">
            <div class="search-bar">
                <i class="fas fa-search text-gray-400"></i>
                <input type="text" id="searchInput" class="search-input" placeholder="Cari item di wishlist...">
                <button id="searchBtn" class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        
        <!-- Wishlist Grid -->
        <div class="wishlist-grid" id="wishlistGrid">
            <!-- Items will be loaded here -->
        </div>
        
        <!-- No Items Message -->
        <div class="no-items" id="noItemsMessage" style="display: none;">
            <i class="fas fa-heart"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Wishlist Kosong</h3>
            <p class="text-gray-500 mb-4">Belum ada item di wishlist Anda</p>
            <button class="add-item-btn" onclick="showAddModal()">
                <i class="fas fa-plus"></i>
                Tambah Item Pertama
            </button>
        </div>
        
        <!-- Load More Button -->
        <div class="load-more" id="loadMoreSection" style="display: none;">
            <button class="load-more-btn" id="loadMoreBtn" onclick="loadMore()">
                <i class="fas fa-plus mr-2"></i>
                Muat Lebih Banyak
            </button>
        </div>
        
        <!-- Add Item Section -->
        <div class="add-item-section">
            <button class="add-item-btn" onclick="showAddModal()">
                <i class="fas fa-plus"></i>
                Tambah Item ke Wishlist
            </button>
        </div>
    </div>
</div>

<!-- Add Item Modal -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Tambah Item ke Wishlist</h3>
            <button class="close-modal" onclick="closeAddModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="addItemForm">
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" id="itemName" required placeholder="Masukkan nama produk">
            </div>
            
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea id="itemDescription" rows="3" required placeholder="Masukkan deskripsi produk"></textarea>
            </div>
            
            <div class="form-group">
                <label>Kategori</label>
                <select id="itemCategory" required>
                    <option value="">Pilih kategori</option>
                    <option value="tas-belanja">Tas Belanja</option>
                    <option value="botol-tumbler">Botol Tumbler</option>
                    <option value="kompos">Kompos</option>
                    <option value="produk-daur-ulang">Produk Daur Ulang</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" id="itemPrice" required placeholder="Masukkan harga">
            </div>
            
            <div class="form-group">
                <label>URL Gambar</label>
                <input type="url" id="itemImage" placeholder="Masukkan URL gambar (opsional)">
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeAddModal()" class="btn btn-secondary flex-1">
                    Batal
                </button>
                <button type="submit" class="btn btn-primary flex-1">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah ke Wishlist
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Berhasil!</h3>
            <button class="close-modal" onclick="closeSuccessModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="text-center">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3 class="text-xl font-bold text-green-600 mb-2" id="successTitle">Item Berhasil Ditambahkan!</h3>
            <p class="text-gray-600 mb-4" id="successMessage">Item telah ditambahkan ke wishlist Anda.</p>
            <button class="btn btn-primary" onclick="closeSuccessModal()">
                <i class="fas fa-check mr-2"></i>
                OK
            </button>
        </div>
    </div>
</div>
@endsection

@section('additional-scripts')
<script>
    let wishlistItems = [];
    let currentFilter = 'all';
    let currentSearch = '';
    let currentPage = 1;
    const itemsPerPage = 6;

    // Sample data
    const sampleItems = [
        {
            id: 1,
            name: 'Tas Belanja Reusable Premium',
            description: 'Tas belanja ramah lingkungan dengan desain modern dan tahan lama.',
            category: 'tas-belanja',
            price: 89000,
            image: 'https://images.unsplash.com/photo-1597481499750-3e6b22637e12?w=400&h=300&fit=crop',
            addedDate: '2024-01-15'
        },
        {
            id: 2,
            name: 'Botol Tumbler Stainless Steel',
            description: 'Botol minum ramah lingkungan dengan teknologi vacuum insulation.',
            category: 'botol-tumbler',
            price: 125000,
            image: 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=400&h=300&fit=crop',
            addedDate: '2024-01-10'
        },
        {
            id: 3,
            name: 'Kompos Organik Premium',
            description: 'Kompos organik berkualitas tinggi untuk tanaman.',
            category: 'kompos',
            price: 45000,
            image: 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=400&h=300&fit=crop',
            addedDate: '2024-01-08'
        },
        {
            id: 4,
            name: 'Kotak Makan Reusable',
            description: 'Kotak makan ramah lingkungan dengan kompartemen terpisah.',
            category: 'produk-daur-ulang',
            price: 75000,
            image: 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop',
            addedDate: '2024-01-05'
        }
    ];

    // Initialize wishlist
    document.addEventListener('DOMContentLoaded', function() {
        loadWishlist();
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
                renderWishlist();
            });
        });

        // Form submission
        document.getElementById('addItemForm').addEventListener('submit', function(e) {
            e.preventDefault();
            addItem();
        });
    }

    function loadWishlist() {
        // Load from localStorage or use sample data
        const savedItems = localStorage.getItem('wishlistItems');
        if (savedItems) {
            wishlistItems = JSON.parse(savedItems);
        } else {
            wishlistItems = [...sampleItems];
            localStorage.setItem('wishlistItems', JSON.stringify(wishlistItems));
        }
        renderWishlist();
    }

    function renderWishlist() {
        const grid = document.getElementById('wishlistGrid');
        const noItemsMessage = document.getElementById('noItemsMessage');
        const loadMoreSection = document.getElementById('loadMoreSection');
        
        // Filter items
        let filteredItems = wishlistItems.filter(item => {
            const matchesFilter = currentFilter === 'all' || item.category === currentFilter;
            const matchesSearch = currentSearch === '' || 
                item.name.toLowerCase().includes(currentSearch) || 
                item.description.toLowerCase().includes(currentSearch);
            return matchesFilter && matchesSearch;
        });

        // Pagination
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const itemsToShow = filteredItems.slice(startIndex, endIndex);

        if (filteredItems.length === 0) {
            grid.innerHTML = '';
            noItemsMessage.style.display = 'block';
            loadMoreSection.style.display = 'none';
        } else {
            noItemsMessage.style.display = 'none';
            grid.innerHTML = '';
            
            itemsToShow.forEach(item => {
                const itemElement = createWishlistItem(item);
                grid.appendChild(itemElement);
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

    function createWishlistItem(item) {
        const div = document.createElement('div');
        div.className = 'wishlist-item';
        div.setAttribute('data-id', item.id);
        
        const badge = item.addedDate ? `<div class="item-badge">Baru</div>` : '';
        
        div.innerHTML = `
            ${badge}
            <img src="${item.image}" alt="${item.name}" class="item-image">
            <h3 class="item-title">${item.name}</h3>
            <p class="item-description">${item.description}</p>
            <div class="item-price">
                <span class="currency">Rp</span>
                ${item.price.toLocaleString()}
            </div>
            <div class="item-actions">
                <button class="btn-primary" onclick="buyNow(${item.id})">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    Beli Sekarang
                </button>
                <button class="btn-danger" onclick="removeItem(${item.id})">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        
        return div;
    }

    function updateStats(items) {
        const totalItems = items.length;
        const totalValue = items.reduce((sum, item) => sum + item.price, 0);
        const avgPrice = totalItems > 0 ? Math.round(totalValue / totalItems) : 0;

        document.getElementById('totalItems').textContent = totalItems;
        document.getElementById('totalValue').textContent = `Rp ${totalValue.toLocaleString()}`;
        document.getElementById('avgPrice').textContent = `Rp ${avgPrice.toLocaleString()}`;
    }

    function performSearch() {
        currentSearch = document.getElementById('searchInput').value.toLowerCase().trim();
        currentPage = 1;
        renderWishlist();
    }

    function loadMore() {
        currentPage++;
        renderWishlist();
    }

    function showAddModal() {
        document.getElementById('addModal').style.display = 'flex';
    }

    function closeAddModal() {
        document.getElementById('addModal').style.display = 'none';
        document.getElementById('addItemForm').reset();
    }

    function addItem() {
        const name = document.getElementById('itemName').value;
        const description = document.getElementById('itemDescription').value;
        const category = document.getElementById('itemCategory').value;
        const price = parseInt(document.getElementById('itemPrice').value);
        const image = document.getElementById('itemImage').value || 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop';

        if (!name || !description || !category || !price) {
            alert('Mohon lengkapi semua field yang diperlukan');
            return;
        }

        const newItem = {
            id: Date.now(),
            name: name,
            description: description,
            category: category,
            price: price,
            image: image,
            addedDate: new Date().toISOString().split('T')[0]
        };

        wishlistItems.unshift(newItem);
        localStorage.setItem('wishlistItems', JSON.stringify(wishlistItems));
        
        closeAddModal();
        renderWishlist();
        
        showSuccessModal('Item Berhasil Ditambahkan!', 'Item telah ditambahkan ke wishlist Anda.');
    }

    function removeItem(id) {
        if (confirm('Apakah Anda yakin ingin menghapus item ini dari wishlist?')) {
            wishlistItems = wishlistItems.filter(item => item.id !== id);
            localStorage.setItem('wishlistItems', JSON.stringify(wishlistItems));
            renderWishlist();
            showSuccessModal('Item Berhasil Dihapus!', 'Item telah dihapus dari wishlist Anda.');
        }
    }

    function buyNow(id) {
        const item = wishlistItems.find(item => item.id === id);
        if (item) {
            showSuccessModal('Membuka Toko!', `Mengarahkan ke halaman pembelian ${item.name}`);
            // Here you can redirect to the shop page or open a purchase modal
        }
    }

    function showSuccessModal(title, message) {
        document.getElementById('successTitle').textContent = title;
        document.getElementById('successMessage').textContent = message;
        document.getElementById('successModal').style.display = 'flex';
    }

    function closeSuccessModal() {
        document.getElementById('successModal').style.display = 'none';
    }

    // Close modals when clicking outside
    window.onclick = function(event) {
        const addModal = document.getElementById('addModal');
        const successModal = document.getElementById('successModal');
        
        if (event.target === addModal) {
            closeAddModal();
        }
        if (event.target === successModal) {
            closeSuccessModal();
        }
    }
</script>
@endsection 