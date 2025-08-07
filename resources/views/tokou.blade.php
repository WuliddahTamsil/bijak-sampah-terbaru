@extends('layouts.non-nasabah-layout')

@php
$activeMenu = 'marketplace';
@endphp

@section('title', 'Toko - Bijak Sampah')

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

    .search-bar {
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 25px;
        padding: 0.75rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
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

    .filter-section {
        margin-bottom: 2rem;
    }

    .category-filter {
        background: #f8f9fa;
        color: #05445E;
        border: 2px solid #e9ecef;
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .category-filter:hover {
        background: #e9ecef;
        transform: translateY(-2px);
    }

    .category-filter.active {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
        color: white;
        border-color: transparent;
        font-weight: 600;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .product-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        border: 1px solid #e9ecef;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .product-badge {
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

    .product-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    .product-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
        margin: 1rem;
        margin-bottom: 0.5rem;
    }

    .product-description {
        color: #666;
        margin: 0 1rem 1rem;
        line-height: 1.5;
        font-size: 0.9rem;
    }

    .product-price {
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

    .product-actions {
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

    .btn-secondary {
        background: #f8f9fa;
        color: #666;
        border: 1px solid #e9ecef;
        padding: 0.75rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: #e9ecef;
        transform: translateY(-2px);
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin: 2rem 0;
    }

    .pagination-btn {
        background: #f8f9fa;
        color: #05445E;
        border: 1px solid #e9ecef;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .pagination-btn:hover {
        background: #e9ecef;
        transform: translateY(-2px);
    }

    .pagination-btn.active {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
        color: white;
        font-weight: 600;
    }

    .footer {
        text-align: center;
        color: #666;
        margin-top: 3rem;
        font-size: 0.9rem;
    }

    .footer strong {
        color: #05445E;
        font-weight: 600;
    }

    .no-results {
        text-align: center;
        padding: 3rem 1rem;
        color: #666;
    }

    .no-results i {
        font-size: 4rem;
        color: #ccc;
        margin-bottom: 1rem;
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

    .product-summary {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .product-summary img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
    }

    .payment-methods {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .payment-method {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 1rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .payment-method:hover {
        border-color: #75E6DA;
        background: #f0fdf4;
    }

    .payment-method.selected {
        border-color: #75E6DA;
        background: #f0fdf4;
    }

    .success-icon {
        font-size: 4rem;
        color: #10b981;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .content-container {
            padding: 1rem;
        }
        
        .page-title {
            font-size: 2rem;
        }
        
        .products-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .category-filter {
            padding: 0.4rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>
@endsection

@section('content')
<div class="main-content-wrapper">
    <div class="content-container">
        <h1 class="page-title">Toko BijakSampah</h1>
        
        <div class="search-bar">
            <i class="fas fa-search text-gray-400"></i>
            <input type="text" id="searchInput" class="search-input" placeholder="Cari produk ramah lingkungan...">
            <button id="searchBtn" class="search-btn">
                <i class="fas fa-search"></i>
            </button>
        </div>
        
        <div class="filter-section">
            <div class="flex gap-2 flex-wrap">
                <button class="category-filter active" data-category="semua">Semua</button>
                <button class="category-filter" data-category="tas-belanja">Tas Belanja</button>
                <button class="category-filter" data-category="botol-tumbler">Botol Tumbler</button>
                <button class="category-filter" data-category="kompos">Kompos</button>
                <button class="category-filter" data-category="produk-daur-ulang">Produk Daur Ulang</button>
            </div>
        </div>
        
        <div class="products-grid" id="productsGrid">
            <!-- Product Card 1 -->
            <div class="product-card" data-category="tas-belanja" data-name="Tas Belanja Reusable Premium" data-description="Tas belanja ramah lingkungan dengan desain modern dan tahan lama. Mengurangi penggunaan plastik sekali pakai.">
                <div class="product-badge">Terlaris</div>
                <img src="https://images.unsplash.com/photo-1597481499750-3e6b22637e12?w=400&h=300&fit=crop" alt="Tas Belanja Reusable" class="product-image">
                <h3 class="product-title">Tas Belanja Reusable Premium</h3>
                <p class="product-description">Tas belanja ramah lingkungan dengan desain modern dan tahan lama. Mengurangi penggunaan plastik sekali pakai.</p>
                <div class="product-price">
                    <span class="currency">Rp</span>
                    89.000
                </div>
                <div class="product-actions">
                    <button class="btn-primary" onclick="showCheckoutModal('Tas Belanja Reusable Premium', 89000, 'https://images.unsplash.com/photo-1597481499750-3e6b22637e12?w=400&h=300&fit=crop')">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Beli Sekarang
                    </button>
                    <button class="btn-secondary">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
            </div>

            <!-- Product Card 2 -->
            <div class="product-card" data-category="botol-tumbler" data-name="Botol Tumbler Stainless Steel" data-description="Botol minum ramah lingkungan dengan teknologi vacuum insulation. Tahan panas dan dingin hingga 24 jam.">
                <div class="product-badge">Baru</div>
                <img src="https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=400&h=300&fit=crop" alt="Botol Tumbler Stainless" class="product-image">
                <h3 class="product-title">Botol Tumbler Stainless Steel</h3>
                <p class="product-description">Botol minum ramah lingkungan dengan teknologi vacuum insulation. Tahan panas dan dingin hingga 24 jam.</p>
                <div class="product-price">
                    <span class="currency">Rp</span>
                    125.000
                </div>
                <div class="product-actions">
                    <button class="btn-primary" onclick="showCheckoutModal('Botol Tumbler Stainless Steel', 125000, 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=400&h=300&fit=crop')">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Beli Sekarang
                    </button>
                    <button class="btn-secondary">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
            </div>

            <!-- Product Card 3 -->
            <div class="product-card" data-category="kompos" data-name="Kompos Organik Premium" data-description="Kompos organik berkualitas tinggi untuk tanaman. Mengandung nutrisi lengkap dan ramah lingkungan.">
                <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=400&h=300&fit=crop" alt="Kompos Organik" class="product-image">
                <h3 class="product-title">Kompos Organik Premium</h3>
                <p class="product-description">Kompos organik berkualitas tinggi untuk tanaman. Mengandung nutrisi lengkap dan ramah lingkungan.</p>
                <div class="product-price">
                    <span class="currency">Rp</span>
                    45.000
                </div>
                <div class="product-actions">
                    <button class="btn-primary" onclick="showCheckoutModal('Kompos Organik Premium', 45000, 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=400&h=300&fit=crop')">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Beli Sekarang
                    </button>
                    <button class="btn-secondary">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
            </div>

            <!-- Product Card 4 -->
            <div class="product-card" data-category="produk-daur-ulang" data-name="Kotak Makan Reusable" data-description="Kotak makan ramah lingkungan dengan kompartemen terpisah. Aman untuk microwave dan tahan lama.">
                <div class="product-badge">Eco</div>
                <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop" alt="Kotak Makan Reusable" class="product-image">
                <h3 class="product-title">Kotak Makan Reusable</h3>
                <p class="product-description">Kotak makan ramah lingkungan dengan kompartemen terpisah. Aman untuk microwave dan tahan lama.</p>
                <div class="product-price">
                    <span class="currency">Rp</span>
                    75.000
                </div>
                <div class="product-actions">
                    <button class="btn-primary" onclick="showCheckoutModal('Kotak Makan Reusable', 75000, 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop')">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Beli Sekarang
                    </button>
                    <button class="btn-secondary">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
            </div>

            <!-- Product Card 5 -->
            <div class="product-card" data-category="produk-daur-ulang" data-name="Sikat Gigi Bambu Organik" data-description="Sikat gigi ramah lingkungan terbuat dari bambu organik. Bebas plastik dan biodegradable.">
                <img src="https://images.unsplash.com/photo-1606787366850-de6330128bfc?w=400&h=300&fit=crop" alt="Sikat Gigi Bambu" class="product-image">
                <h3 class="product-title">Sikat Gigi Bambu Organik</h3>
                <p class="product-description">Sikat gigi ramah lingkungan terbuat dari bambu organik. Bebas plastik dan biodegradable.</p>
                <div class="product-price">
                    <span class="currency">Rp</span>
                    25.000
                </div>
                <div class="product-actions">
                    <button class="btn-primary" onclick="showCheckoutModal('Sikat Gigi Bambu Organik', 25000, 'https://images.unsplash.com/photo-1606787366850-de6330128bfc?w=400&h=300&fit=crop')">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Beli Sekarang
                    </button>
                    <button class="btn-secondary">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
            </div>

            <!-- Product Card 6 -->
            <div class="product-card" data-category="produk-daur-ulang" data-name="Straw Stainless Steel" data-description="Sedotan stainless steel ramah lingkungan. Tahan lama, mudah dibersihkan, dan bebas plastik.">
                <div class="product-badge">Hemat</div>
                <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop" alt="Straw Stainless Steel" class="product-image">
                <h3 class="product-title">Straw Stainless Steel</h3>
                <p class="product-description">Sedotan stainless steel ramah lingkungan. Tahan lama, mudah dibersihkan, dan bebas plastik.</p>
                <div class="product-price">
                    <span class="currency">Rp</span>
                    35.000
                </div>
                <div class="product-actions">
                    <button class="btn-primary" onclick="showCheckoutModal('Straw Stainless Steel', 35000, 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop')">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Beli Sekarang
                    </button>
                    <button class="btn-secondary">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="pagination">
            <button class="pagination-btn active">1</button>
            <button class="pagination-btn">2</button>
            <button class="pagination-btn">3</button>
            <button class="pagination-btn">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
        
        <div class="footer">
            <p>© 2025 <strong>BijakSampah</strong>. Semua produk ramah lingkungan untuk masa depan yang lebih hijau.</p>
        </div>
    </div>
</div>

<!-- Checkout Modal -->
<div id="checkoutModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Checkout</h3>
            <button class="close-modal" onclick="closeCheckoutModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div id="checkoutContent">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Pembayaran</h3>
            <button class="close-modal" onclick="closePaymentModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div id="paymentContent">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Pembayaran Berhasil!</h3>
            <button class="close-modal" onclick="closeSuccessModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="text-center">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3 class="text-xl font-bold text-green-600 mb-2">Terima Kasih!</h3>
            <p class="text-gray-600 mb-4">Pesanan Anda telah berhasil diproses. Anda akan menerima email konfirmasi dalam beberapa menit.</p>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                <p class="text-sm text-green-800"><strong>Order ID:</strong> <span id="orderId"></span></p>
                <p class="text-sm text-green-800"><strong>Total Pembayaran:</strong> <span id="totalPayment"></span></p>
            </div>
            <button class="btn btn-primary" onclick="closeSuccessModal()">
                <i class="fas fa-home mr-2"></i>
                Kembali ke Beranda
            </button>
        </div>
    </div>
</div>
@endsection

@section('additional-scripts')
<script>
    let currentProduct = null;
    let currentPrice = 0;
    let currentFilter = 'semua';
    let currentSearch = '';

    // Product interaction functions
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const searchBtn = document.getElementById('searchBtn');
        
        // Search on button click
        searchBtn.addEventListener('click', function() {
            performSearch();
        });
        
        // Search on Enter key
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
        
        // Real-time search with debounce
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch();
            }, 300);
        });

        // Category filter functionality
        const categoryFilters = document.querySelectorAll('.category-filter');
        categoryFilters.forEach(filter => {
            filter.addEventListener('click', function() {
                // Remove active class from all filters
                categoryFilters.forEach(f => f.classList.remove('active'));
                // Add active class to clicked filter
                this.classList.add('active');
                
                // Get the category
                currentFilter = this.getAttribute('data-category');
                
                // Apply filters
                filterProducts();
            });
        });

        // Product card hover effects
        const productCards = document.querySelectorAll('.product-card');
        productCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Wishlist button functionality
        const wishlistButtons = document.querySelectorAll('.btn-secondary');
        wishlistButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productTitle = this.closest('.product-card').querySelector('.product-title').textContent;
                alert(`Menambahkan "${productTitle}" ke wishlist!`);
            });
        });
    });

    function performSearch() {
        currentSearch = document.getElementById('searchInput').value.toLowerCase().trim();
        filterProducts();
    }

    function filterProducts() {
        const products = document.querySelectorAll('.product-card');
        let visibleCount = 0;

        products.forEach(product => {
            const category = product.getAttribute('data-category');
            const name = product.getAttribute('data-name').toLowerCase();
            const description = product.getAttribute('data-description').toLowerCase();
            
            // Check if product matches current filter
            const matchesFilter = currentFilter === 'semua' || category === currentFilter;
            
            // Check if product matches search term
            const matchesSearch = currentSearch === '' || 
                name.includes(currentSearch) || 
                description.includes(currentSearch);
            
            // Show/hide product based on filters
            if (matchesFilter && matchesSearch) {
                product.style.display = 'block';
                visibleCount++;
            } else {
                product.style.display = 'none';
            }
        });

        // Show no results message if no products are visible
        showNoResultsMessage(visibleCount === 0);
    }

    function showNoResultsMessage(show) {
        let noResultsDiv = document.getElementById('noResultsMessage');
        
        if (show) {
            if (!noResultsDiv) {
                noResultsDiv = document.createElement('div');
                noResultsDiv.id = 'noResultsMessage';
                noResultsDiv.className = 'no-results';
                noResultsDiv.innerHTML = `
                    <i class="fas fa-search"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak ada produk ditemukan</h3>
                    <p class="text-gray-500">Coba ubah kata kunci pencarian atau pilih kategori yang berbeda</p>
                `;
                document.getElementById('productsGrid').appendChild(noResultsDiv);
            }
            noResultsDiv.style.display = 'block';
        } else {
            if (noResultsDiv) {
                noResultsDiv.style.display = 'none';
            }
        }
    }

    function showNoResultsMessage(show) {
        let noResultsDiv = document.getElementById('noResultsMessage');
        
        if (show) {
            if (!noResultsDiv) {
                noResultsDiv = document.createElement('div');
                noResultsDiv.id = 'noResultsMessage';
                noResultsDiv.className = 'no-results';
                noResultsDiv.innerHTML = `
                    <i class="fas fa-search"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak ada produk ditemukan</h3>
                    <p class="text-gray-500">Coba ubah kata kunci pencarian atau pilih kategori yang berbeda</p>
                `;
                document.getElementById('productsGrid').appendChild(noResultsDiv);
            }
            noResultsDiv.style.display = 'block';
        } else {
            if (noResultsDiv) {
                noResultsDiv.style.display = 'none';
            }
        }
    }

    function showCheckoutModal(productName, price, imageUrl) {
        currentProduct = productName;
        currentPrice = price;
        
        const modal = document.getElementById('checkoutModal');
        const content = document.getElementById('checkoutContent');
        
        content.innerHTML = `
            <div class="product-summary">
                <div class="flex items-center gap-3">
                    <img src="${imageUrl}" alt="${productName}" class="rounded-lg">
                    <div>
                        <h4 class="font-semibold text-gray-800">${productName}</h4>
                        <p class="text-lg font-bold text-green-600">Rp ${price.toLocaleString()}</p>
                    </div>
                </div>
            </div>
            
            <form id="checkoutForm">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" id="fullName" required placeholder="Masukkan nama lengkap">
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="email" required placeholder="Masukkan email">
                </div>
                
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="tel" id="phone" required placeholder="Masukkan nomor telepon">
                </div>
                
                <div class="form-group">
                    <label>Alamat Pengiriman</label>
                    <textarea id="address" rows="3" required placeholder="Masukkan alamat lengkap"></textarea>
                </div>
                
                <div class="form-group">
                    <label>Metode Pembayaran</label>
                    <div class="payment-methods">
                        <div class="payment-method" onclick="selectPaymentMethod(this, 'dana')">
                            <i class="fas fa-wallet text-2xl text-blue-500 mb-2"></i>
                            <p class="text-sm font-semibold">DANA</p>
                        </div>
                        <div class="payment-method" onclick="selectPaymentMethod(this, 'ovo')">
                            <i class="fas fa-mobile-alt text-2xl text-purple-500 mb-2"></i>
                            <p class="text-sm font-semibold">OVO</p>
                        </div>
                        <div class="payment-method" onclick="selectPaymentMethod(this, 'gopay')">
                            <i class="fas fa-credit-card text-2xl text-green-500 mb-2"></i>
                            <p class="text-sm font-semibold">GoPay</p>
                        </div>
                        <div class="payment-method" onclick="selectPaymentMethod(this, 'shopeepay')">
                            <i class="fas fa-shopping-bag text-2xl text-orange-500 mb-2"></i>
                            <p class="text-sm font-semibold">ShopeePay</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex gap-3">
                    <button type="button" onclick="closeCheckoutModal()" class="btn btn-secondary flex-1">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary flex-1">
                        <i class="fas fa-credit-card mr-2"></i>
                        Lanjut ke Pembayaran
                    </button>
                </div>
            </form>
        `;
        
        modal.style.display = 'flex';
        
        // Form submission
        document.getElementById('checkoutForm').addEventListener('submit', function(e) {
            e.preventDefault();
            closeCheckoutModal();
            showPaymentModal();
        });
    }

    function closeCheckoutModal() {
        document.getElementById('checkoutModal').style.display = 'none';
    }

    function selectPaymentMethod(element, method) {
        // Remove selected class from all payment methods
        document.querySelectorAll('.payment-method').forEach(el => {
            el.classList.remove('selected');
        });
        
        // Add selected class to clicked element
        element.classList.add('selected');
    }

    function showPaymentModal() {
        const modal = document.getElementById('paymentModal');
        const content = document.getElementById('paymentContent');
        
        content.innerHTML = `
            <div class="text-center mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-2">Konfirmasi Pembayaran</h3>
                <p class="text-gray-600">Total yang harus dibayar</p>
                <p class="text-3xl font-bold text-green-600">Rp ${currentPrice.toLocaleString()}</p>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h4 class="font-semibold text-gray-800 mb-2">Detail Pesanan:</h4>
                <p class="text-gray-600">${currentProduct}</p>
                <p class="text-gray-600">Harga: Rp ${currentPrice.toLocaleString()}</p>
                <p class="text-gray-600">Ongkir: Rp 15.000</p>
                <hr class="my-2">
                <p class="font-semibold text-gray-800">Total: Rp ${(currentPrice + 15000).toLocaleString()}</p>
            </div>
            
            <div class="text-center">
                <button onclick="processPayment()" class="btn btn-primary">
                    <i class="fas fa-lock mr-2"></i>
                    Bayar Sekarang
                </button>
            </div>
        `;
        
        modal.style.display = 'flex';
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').style.display = 'none';
    }

    function processPayment() {
        // Simulate payment processing
        setTimeout(() => {
            closePaymentModal();
            showSuccessModal();
        }, 2000);
    }

    function showSuccessModal() {
        const modal = document.getElementById('successModal');
        const orderId = 'ORD-' + Date.now();
        const totalPayment = currentPrice + 15000;
        
        document.getElementById('orderId').textContent = orderId;
        document.getElementById('totalPayment').textContent = 'Rp ' + totalPayment.toLocaleString();
        
        modal.style.display = 'flex';
    }

    function closeSuccessModal() {
        document.getElementById('successModal').style.display = 'none';
    }

    // Close modals when clicking outside
    window.onclick = function(event) {
        const checkoutModal = document.getElementById('checkoutModal');
        const paymentModal = document.getElementById('paymentModal');
        const successModal = document.getElementById('successModal');
        
        if (event.target === checkoutModal) {
            closeCheckoutModal();
        }
        if (event.target === paymentModal) {
            closePaymentModal();
        }
        if (event.target === successModal) {
            closeSuccessModal();
        }
    }
</script>
@endsection 