@extends('v_layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:wght@400;500;600;700&display=swap');

    /* Root Variables */
    :root {
        --primary: #C47A3E;
        --primary-dark: #A05A2A;
        --primary-light: #FDE8D4;
        --secondary: #2C1810;
        --bg-light: #FFF9F5;
        --bg-white: #FFFFFF;
        --bg-gray: #F8F8F8;
        --text-dark: #1A1A1A;
        --text-muted: #6B6B6B;
        --text-light: #999999;
        --border: #E5E5E5;
        --border-light: #F0F0F0;
        --success: #4CAF50;
        --danger: #C62828;
        --warning: #FF9800;
        --shadow-xs: 0 1px 2px rgba(0,0,0,0.05);
        --shadow-sm: 0 2px 8px rgba(0,0,0,0.04);
        --shadow-md: 0 4px 16px rgba(0,0,0,0.06);
        --shadow-lg: 0 8px 32px rgba(0,0,0,0.08);
        --radius-sm: 6px;
        --radius-md: 10px;
        --radius-lg: 16px;
        --radius-xl: 24px;
    }

    /* Main Container */
    .product-detail-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 120px 24px 80px;
    }

    /* Breadcrumb */
    .breadcrumb-wrapper {
        margin-bottom: 32px;
    }

    .breadcrumb-nav {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
    }

    .breadcrumb-nav a {
        color: var(--text-muted);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .breadcrumb-nav a:hover {
        color: var(--primary);
    }

    .breadcrumb-nav span {
        color: var(--text-light);
    }

    .breadcrumb-nav .separator {
        color: var(--border);
        font-size: 12px;
    }

    .breadcrumb-nav .current {
        color: var(--primary);
        font-weight: 500;
    }

    /* Product Card */
    .product-card {
        background: var(--bg-white);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: box-shadow 0.3s ease;
    }

    .product-card:hover {
        box-shadow: var(--shadow-lg);
    }

    /* Gallery Section */
    .product-gallery {
        padding: 32px;
        background: var(--bg-white);
        border-right: 1px solid var(--border-light);
    }

    .main-image-container {
        position: relative;
        width: 100%;
        padding-top: 100%;
        background: var(--bg-gray);
        border-radius: var(--radius-lg);
        overflow: hidden;
        margin-bottom: 20px;
        cursor: zoom-in;
    }

    .main-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .main-image-container:hover .main-image {
        transform: scale(1.05);
    }

    .thumbnail-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }

    .thumbnail-item {
        position: relative;
        padding-top: 100%;
        background: var(--bg-gray);
        border-radius: var(--radius-md);
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.2s ease;
    }

    .thumbnail-item:hover {
        border-color: var(--primary-light);
    }

    .thumbnail-item.active {
        border-color: var(--primary);
        box-shadow: var(--shadow-sm);
    }

    .thumbnail-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Product Info Section */
    .product-info-section {
        padding: 32px;
        background: var(--bg-white);
    }

    /* Category Badge */
    .category-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        background: var(--primary-light);
        border-radius: 50px;
        margin-bottom: 20px;
    }

    .category-badge i {
        font-size: 12px;
        color: var(--primary);
    }

    .category-badge span {
        font-size: 12px;
        font-weight: 600;
        color: var(--primary-dark);
        letter-spacing: 0.5px;
    }

    /* Product Title */
    .product-title {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        font-weight: 700;
        color: var(--text-dark);
        line-height: 1.3;
        margin-bottom: 16px;
    }

    /* Rating */
    .rating-wrapper {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
        padding-bottom: 24px;
        border-bottom: 1px solid var(--border-light);
    }

    .stars {
        display: flex;
        gap: 4px;
        color: #FFB800;
        font-size: 14px;
    }

    .rating-text {
        font-size: 13px;
        color: var(--text-muted);
    }

    .rating-text strong {
        color: var(--text-dark);
        font-weight: 600;
    }

    /* Price */
    .price-wrapper {
        margin-bottom: 24px;
        padding-bottom: 24px;
        border-bottom: 1px solid var(--border-light);
    }

    .current-price {
        font-size: 32px;
        font-weight: 800;
        color: var(--primary);
        letter-spacing: -0.5px;
    }

    .price-suffix {
        font-size: 14px;
        font-weight: 500;
        color: var(--text-muted);
        margin-left: 8px;
    }

    /* Size Selector Styles */
    .size-wrapper {
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-light);
    }

    .size-label {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .size-label i {
        color: var(--primary);
        font-size: 16px;
    }

    .size-required {
        font-size: 11px;
        font-weight: 500;
        color: var(--danger);
        background: #FFEBEE;
        padding: 2px 8px;
        border-radius: 20px;
        margin-left: 8px;
    }

    .size-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 12px;
    }

    .size-btn {
        min-width: 100px;
        padding: 12px 24px;
        background: var(--bg-white);
        border: 2px solid var(--border);
        border-radius: var(--radius-md);
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .size-btn:hover:not(.disabled) {
        border-color: var(--primary);
        color: var(--primary);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .size-btn.active {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .size-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background: var(--bg-gray);
        text-decoration: line-through;
    }

    .size-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: var(--danger);
        color: white;
        font-size: 9px;
        font-weight: 600;
        padding: 2px 6px;
        border-radius: 20px;
        white-space: nowrap;
    }

    .size-guide {
        margin-top: 12px;
    }

    .size-guide a {
        font-size: 12px;
        color: var(--primary);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: color 0.2s ease;
    }

    .size-guide a:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    /* Description */
    .description-wrapper {
        margin-bottom: 24px;
    }

    .description-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 12px;
    }

    .description-text {
        color: var(--text-muted);
        line-height: 1.7;
        font-size: 14px;
    }

    /* Product Specs */
    .specs-wrapper {
        background: var(--bg-gray);
        border-radius: var(--radius-md);
        padding: 20px;
        margin-bottom: 24px;
    }

    .specs-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .spec-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .spec-label {
        font-size: 13px;
        color: var(--text-muted);
    }

    .spec-value {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 14px;
    }

    .stock-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
    }

    .stock-available {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .stock-low {
        background: #FFF3E0;
        color: #E65100;
    }

    .stock-out {
        background: #FFEBEE;
        color: #C62828;
    }

    /* Quantity Selector */
    .quantity-wrapper {
        margin-bottom: 24px;
    }

    .quantity-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 12px;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .quantity-btn {
        width: 40px;
        height: 40px;
        background: var(--bg-white);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        cursor: pointer;
        font-size: 18px;
        font-weight: 600;
        color: var(--text-dark);
        transition: all 0.2s ease;
    }

    .quantity-btn:hover:not(:disabled) {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .quantity-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .quantity-input {
        width: 80px;
        height: 40px;
        text-align: center;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        font-size: 14px;
        font-weight: 600;
    }

    .quantity-input:disabled {
        background: var(--bg-gray);
        cursor: not-allowed;
    }

    /* Action Buttons */
    .action-buttons {
        margin-bottom: 0;
    }

    .btn-primary {
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 24px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-primary:hover:not(:disabled) {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .btn-primary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Lightbox */
    .lightbox {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.95);
        z-index: 10000;
        cursor: pointer;
    }

    .lightbox.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lightbox-image {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
    }

    .lightbox-close {
        position: absolute;
        top: 24px;
        right: 32px;
        font-size: 40px;
        color: white;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .lightbox-close:hover {
        color: var(--primary);
    }

    /* Modal Size Guide */
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.8);
        z-index: 10002;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: var(--radius-lg);
        max-width: 600px;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
        animation: slideInUp 0.3s ease;
    }

    .modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
        font-family: 'Playfair Display', serif;
    }

    .modal-close {
        font-size: 28px;
        cursor: pointer;
        color: var(--text-muted);
        transition: color 0.2s ease;
    }

    .modal-close:hover {
        color: var(--danger);
    }

    .modal-body {
        padding: 24px;
    }

    .size-table {
        width: 100%;
        border-collapse: collapse;
    }

    .size-table th,
    .size-table td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid var(--border-light);
    }

    .size-table th {
        background: var(--primary-light);
        font-weight: 600;
        color: var(--primary-dark);
    }

    .size-note {
        margin-top: 16px;
        font-size: 12px;
        color: var(--text-muted);
        text-align: center;
    }

    @keyframes slideInUp {
        from {
            transform: translateY(50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Notification */
    .notification {
        position: fixed;
        top: 24px;
        right: 24px;
        padding: 12px 20px;
        background: white;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-lg);
        z-index: 10001;
        animation: slideInRight 0.3s ease;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .notification.success {
        border-left: 4px solid var(--success);
    }

    .notification.error {
        border-left: 4px solid var(--danger);
    }

    .notification.info {
        border-left: 4px solid var(--warning);
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Reviews Section */
    .reviews-section {
        margin-top: 48px;
        background: var(--bg-white);
        border-radius: var(--radius-xl);
        padding: 32px;
        box-shadow: var(--shadow-sm);
    }
    .reviews-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        border-bottom: 1px solid var(--border-light);
        padding-bottom: 16px;
    }
    .reviews-title {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        font-weight: 700;
        color: var(--text-dark);
    }
    .review-item {
        padding: 24px 0;
        border-bottom: 1px solid var(--border-light);
    }
    .review-item:last-child {
        border-bottom: none;
    }
    .review-user {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .review-date {
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 400;
        margin-left: 8px;
    }
    .review-rating {
        color: #FFB800;
        font-size: 14px;
        margin-bottom: 12px;
    }
    .review-text {
        color: var(--text-muted);
        line-height: 1.6;
        font-size: 14px;
    }
    .review-form {
        margin-top: 32px;
        background: var(--bg-gray);
        padding: 24px;
        border-radius: var(--radius-lg);
    }
    .review-form h4 {
        margin-bottom: 16px;
        font-family: 'Inter', sans-serif;
        font-size: 16px;
        font-weight: 600;
    }
    .star-rating-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 8px;
        margin-bottom: 16px;
    }
    .star-rating-input input {
        display: none;
    }
    .star-rating-input label {
        color: #ddd;
        font-size: 24px;
        cursor: pointer;
        transition: color 0.2s ease;
    }
    .star-rating-input input:checked ~ label,
    .star-rating-input label:hover,
    .star-rating-input label:hover ~ label {
        color: #FFB800;
    }
    .form-control-custom {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        margin-bottom: 16px;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .product-gallery {
            border-right: none;
            border-bottom: 1px solid var(--border-light);
        }
    }

    @media (max-width: 768px) {
        .product-detail-container {
            padding: 100px 16px 60px;
        }

        .product-title {
            font-size: 24px;
        }

        .current-price {
            font-size: 28px;
        }

        .specs-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .thumbnail-grid {
            gap: 8px;
        }

        .size-btn {
            min-width: 80px;
            padding: 10px 16px;
        }
    }

    @media (max-width: 480px) {
        .product-gallery,
        .product-info-section {
            padding: 20px;
        }
    }
</style>

<div class="product-detail-container">
    <!-- Breadcrumb -->
    <div class="breadcrumb-wrapper">
        <div class="breadcrumb-nav">
            <a href="{{ url('/') }}">Beranda</a>
            <span class="separator">/</span>
            <a href="{{ route('produk.all') }}">Produk</a>
            <span class="separator">/</span>
            <span class="current">{{ $row->nama_produk }}</span>
        </div>
    </div>

    <!-- Product Card -->
    <div class="product-card">
        <div class="row" style="margin: 0;">
            <!-- Gallery Section -->
            <div class="col-md-6" style="padding: 0;">
                <div class="product-gallery">
                    <!-- Main Image -->
                    <div class="main-image-container" id="mainImageContainer">
                        <img src="{{ asset('storage/img-produk/' . $row->foto) }}" 
                             alt="{{ $row->nama_produk }}" 
                             class="main-image" 
                             id="mainImage">
                    </div>

                    <!-- Thumbnails -->
                    <div class="thumbnail-grid" id="thumbnailGrid">
                        <div class="thumbnail-item active" data-image="{{ asset('storage/img-produk/' . $row->foto) }}">
                            <img src="{{ asset('storage/img-produk/' . $row->foto) }}" alt="Thumbnail 1" class="thumbnail-image">
                        </div>
                        @foreach ($fotoProdukTambahan as $item)
                            @if ($item->produk_id == $row->id)
                                <div class="thumbnail-item" data-image="{{ asset('storage/img-produk/' . $item->foto) }}">
                                    <img src="{{ asset('storage/img-produk/' . $item->foto) }}" alt="Thumbnail {{ $loop->iteration + 1 }}" class="thumbnail-image">
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Product Info Section -->
            <div class="col-md-6" style="padding: 0;">
                <div class="product-info-section">
                    <!-- Category -->
                    <div class="category-badge">
                        <i class="fa fa-tag"></i>
                        <span>{{ $row->kategori->nama_kategori ?? 'Premium Product' }}</span>
                    </div>

                    <!-- Title -->
                    <h1 class="product-title">{{ $row->nama_produk }}</h1>

                    <!-- Rating -->
                    <div class="rating-wrapper">
                        <div class="stars">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i>
                        </div>
                        <div class="rating-text">
                            <strong>4.8</strong> dari 5 · <strong>{{ rand(50, 500) }}</strong> ulasan
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="price-wrapper">
                        <span class="current-price" id="currentPrice">Rp {{ number_format($row->harga, 0, ',', '.') }}</span>
                        <span class="price-suffix" id="priceSuffix">/pcs (BIG)</span>
                    </div>

                    <!-- SIZE SELECTOR SECTION -->
                    <div class="size-wrapper">
                        <div class="size-label">
                            <i class="fa fa-arrows"></i>
                            Pilih Ukuran
                            <span class="size-required">*wajib</span>
                        </div>
                        
                        <div class="size-buttons" id="sizeButtons">
                            <!-- Data ukuran akan di-generate oleh JavaScript -->
                        </div>
                        
                        <div class="size-guide">
                            <a href="#" onclick="showSizeGuide(event)">
                                <i class="fa fa-ruler"></i> Panduan Ukuran
                            </a>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="description-wrapper">
                        <div class="description-title">Deskripsi Produk</div>
                        <div class="description-text">
                            {!! $row->detail !!}
                        </div>
                    </div>

                    <!-- Specifications -->
                    <div class="specs-wrapper">
                        <div class="specs-grid">
                            <div class="spec-item">
                                <span class="spec-label">Berat</span>
                                <span class="spec-value">{{ $row->berat }} Gram</span>
                            </div>
                            <div class="spec-item">
                                <span class="spec-label">SKU</span>
                                <span class="spec-value" id="skuValue">PROD-{{ str_pad($row->id, 5, '0', STR_PAD_LEFT) }}-BIG</span>
                            </div>
                            <div class="spec-item">
                                <span class="spec-label">Stok</span>
                                <span class="spec-value" id="stockValue">
                                    <span class="stock-status stock-available">
                                        <i class="fa fa-check-circle"></i> Tersedia ({{ $row->stok }})
                                    </span>
                                </span>
                            </div>
                            <div class="spec-item">
                                <span class="spec-label">Terjual</span>
                                <span class="spec-value">{{ rand(100, 5000) }}+ pcs</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quantity -->
                    <div class="quantity-wrapper">
                        <div class="quantity-label">Jumlah</div>
                        <div class="quantity-control">
                            <button type="button" class="quantity-btn" id="decrementBtn" onclick="decrementQuantity()">−</button>
                            <input type="number" id="quantity" class="quantity-input" value="1" min="1" max="{{ $row->stok }}">
                            <button type="button" class="quantity-btn" id="incrementBtn" onclick="incrementQuantity()">+</button>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="action-buttons">
                        <form action="{{ route('order.addToCart', $row->id) }}" method="POST" style="width: 100%;" id="cartForm">
                            @csrf
                            <input type="hidden" name="quantity" id="cartQuantity" value="1">
                            <input type="hidden" name="size" id="selectedSizeInput" value="BIG">
                            <input type="hidden" name="variant_price" id="variantPriceInput" value="{{ (int) $row->harga }}">
                            <button type="submit" class="btn-primary" id="addToCartBtn">
                                <i class="fa fa-shopping-cart"></i>
                                Tambah ke Keranjang (BIG)
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="reviews-section">
        <div class="reviews-header">
            <h2 class="reviews-title">Ulasan Pelanggan</h2>
            <div class="rating-wrapper" style="margin: 0; padding: 0; border: none;">
                <div class="stars">
                    @php $avgRating = $averageRating ? round($averageRating) : 5; @endphp
                    @for($i=1; $i<=5; $i++)
                        @if($i <= $avgRating)
                            <i class="fa fa-star"></i>
                        @else
                            <i class="fa fa-star-o"></i>
                        @endif
                    @endfor
                </div>
                <div class="rating-text">
                    <strong>{{ number_format($averageRating ?: 5, 1) }}</strong> dari 5 · <strong>{{ $reviews->count() }}</strong> ulasan
                </div>
            </div>
        </div>

        @if($reviews->count() > 0)
            <div class="reviews-list">
                @foreach($reviews as $review)
                    <div class="review-item">
                        <div class="review-user">
                            <i class="fa fa-user-circle" style="font-size: 24px; color: var(--border);"></i>
                            {{ $review->user->nama ?? 'Anonim' }}
                            <span class="review-date">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="review-rating">
                            @for($i=1; $i<=5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fa fa-star"></i>
                                @else
                                    <i class="fa fa-star-o"></i>
                                @endif
                            @endfor
                        </div>
                        <div class="review-text">
                            {{ $review->comment }}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">Belum ada ulasan untuk produk ini. Jadilah yang pertama memberikan ulasan!</p>
        @endif

        @auth
            <div class="review-form">
                <h4>Tulis Ulasan Anda</h4>
                <form action="{{ route('produk.review.store', $row->id) }}" method="POST">
                    @csrf
                    <div class="star-rating-input">
                        <input type="radio" id="star5" name="rating" value="5" required />
                        <label for="star5" title="5 stars"><i class="fa fa-star"></i></label>
                        <input type="radio" id="star4" name="rating" value="4" />
                        <label for="star4" title="4 stars"><i class="fa fa-star"></i></label>
                        <input type="radio" id="star3" name="rating" value="3" />
                        <label for="star3" title="3 stars"><i class="fa fa-star"></i></label>
                        <input type="radio" id="star2" name="rating" value="2" />
                        <label for="star2" title="2 stars"><i class="fa fa-star"></i></label>
                        <input type="radio" id="star1" name="rating" value="1" />
                        <label for="star1" title="1 star"><i class="fa fa-star"></i></label>
                    </div>
                    <textarea name="comment" class="form-control-custom" rows="4" placeholder="Bagaimana pendapat Anda tentang produk ini?" required></textarea>
                    <button type="submit" class="btn-primary" style="width: auto;">Kirim Ulasan</button>
                </form>
            </div>
        @else
            <div class="review-form" style="text-align: center;">
                <p>Silakan <a href="{{ route('auth.redirect') }}" style="color: var(--primary); font-weight: bold;">Login</a> untuk memberikan ulasan.</p>
            </div>
        @endauth
    </div>
</div>

<!-- Lightbox -->
<div id="lightbox" class="lightbox" onclick="closeLightbox()">
    <span class="lightbox-close">&times;</span>
    <img id="lightboxImage" class="lightbox-image" src="">
</div>

<!-- Modal Size Guide -->
<div id="sizeGuideModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Panduan Ukuran Cookies</h3>
            <span class="modal-close" onclick="closeSizeGuide()">&times;</span>
        </div>
        <div class="modal-body">
            <table class="size-table">
                <thead>
                    <tr>
                        <th>Ukuran</th>
                        <th>Diameter (cm)</th>
                        <th>Berat (gram)</th>
                        <th>Harga</th>
                        <th>Cocok Untuk</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>BIG</strong></td>
                        <td>8 - 10 cm</td>
                        <td>70 gr</td>
                        <td>Rp 12.000</td>
                        <td>Porsi besar / sharing / dessert utama</td>
                    </tr>
                    <tr>
                        <td><strong>SMALL</strong></td>
                        <td>5 - 6 cm</td>
                        <td>40 gr</td>
                        <td>Rp 5.000</td>
                        <td>Snack ringan / sekali makan</td>
                    </tr>
                </tbody>
            </table>

            <p class="size-note">
                <i class="fa fa-info-circle"></i> 
                Ukuran dapat sedikit berbeda karena proses handmade. Berat dan diameter bersifat estimasi.
            </p>
        </div>
    </div>
</div>

<script>
    // DATA UKURAN — harga BIG diambil dari database, SMALL dihitung 42% dari BIG
    const bigPrice   = {{ (int) $row->harga }};
    const smallPrice = Math.round(bigPrice * 0.42);

    const sizeData = {
        'BIG': {
            price: bigPrice,
            stock: {{ $row->stok }},
            sku: 'PROD-{{ str_pad($row->id, 5, '0', STR_PAD_LEFT) }}-BIG'
        },
        'SMALL': {
            price: smallPrice,
            stock: {{ $row->stok }},
            sku: 'PROD-{{ str_pad($row->id, 5, '0', STR_PAD_LEFT) }}-SML'
        }
    };

    // Variabel global
    let selectedSize = 'BIG';
    let currentMaxStock = {{ $row->stok }};

    // Initialize halaman
    document.addEventListener('DOMContentLoaded', function() {
        initializeGallery();
        initializeSizeButtons();
        updateCartQuantity();
        
        // Set default ke BIG
        setTimeout(() => {
            selectSize('BIG');
        }, 100);
    });

    // Gallery functionality
    function initializeGallery() {
        const thumbnails = document.querySelectorAll('.thumbnail-item');
        const mainImage = document.getElementById('mainImage');
        const mainContainer = document.getElementById('mainImageContainer');
        const lightbox = document.getElementById('lightbox');
        const lightboxImage = document.getElementById('lightboxImage');

        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                thumbnails.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                const imageUrl = this.getAttribute('data-image');
                mainImage.src = imageUrl;
            });
        });

        mainContainer.addEventListener('click', function() {
            lightboxImage.src = mainImage.src;
            lightbox.classList.add('active');
        });
    }

    // Initialize size buttons
    function initializeSizeButtons() {
        const container = document.getElementById('sizeButtons');
        container.innerHTML = '';
        
        const sizes = ['BIG', 'SMALL'];
        
        sizes.forEach(size => {
            const data = sizeData[size];
            const isAvailable = data.stock > 0;
            
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = `size-btn ${!isAvailable ? 'disabled' : ''}`;
            btn.setAttribute('data-size', size);
            btn.setAttribute('data-price', data.price);
            btn.setAttribute('data-stock', data.stock);
            btn.setAttribute('data-sku', data.sku);
            btn.onclick = () => selectSize(size);
            
            // Tampilkan harga di tombol
            btn.innerHTML = `${size}<br><small style="font-size: 11px;">Rp ${formatNumber(data.price)}</small>`;
            
            if (!isAvailable) {
                const badge = document.createElement('span');
                badge.className = 'size-badge';
                badge.textContent = 'Habis';
                btn.appendChild(badge);
            }
            
            container.appendChild(btn);
        });
    }

    // Select size function
    function selectSize(size) {
        const data = sizeData[size];
        
        if (!data || data.stock === 0) {
            showNotification(`Ukuran ${size} sedang habis`, 'error');
            return;
        }
        
        selectedSize = size;
        currentMaxStock = data.stock;
        
        // Update UI buttons
        document.querySelectorAll('.size-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.getAttribute('data-size') === size) {
                btn.classList.add('active');
            }
        });
        
        // Update price display
        updatePriceDisplay(data.price, size);
        
        // Update stock display
        updateStockDisplay(data.stock, size);
        
        // Update SKU
        updateSKU(data.sku);
        
        // Update quantity max
        updateQuantityMax(data.stock);
        
        // Update form inputs
        document.getElementById('selectedSizeInput').value = size;
        document.getElementById('variantPriceInput').value = data.price;
        
        // Update cart button text
        const cartBtn = document.getElementById('addToCartBtn');
        cartBtn.innerHTML = `<i class="fa fa-shopping-cart"></i> Tambah ke Keranjang (${size})`;
        cartBtn.disabled = false;
        
        // Reset quantity to 1
        const quantityInput = document.getElementById('quantity');
        quantityInput.value = 1;
        updateCartQuantity();
        
        // Show notification
        showNotification(`Ukuran ${size} dipilih - Rp ${formatNumber(data.price)}`, 'success');
    }

    // Update price display
    function updatePriceDisplay(price, size) {
        const priceElement = document.getElementById('currentPrice');
        const suffixElement = document.getElementById('priceSuffix');
        
        priceElement.innerHTML = `Rp ${formatNumber(price)}`;
        suffixElement.innerHTML = `/pcs (${size})`;
    }

    // Update stock display
    function updateStockDisplay(stock, size) {
        const stockContainer = document.getElementById('stockValue');
        
        if (stock > 10) {
            stockContainer.innerHTML = `<span class="stock-status stock-available">
                <i class="fa fa-check-circle"></i> Tersedia (${stock}) untuk ${size}
            </span>`;
        } else if (stock > 0) {
            stockContainer.innerHTML = `<span class="stock-status stock-low">
                <i class="fa fa-exclamation-triangle"></i> Sisa ${stock} untuk ${size}
            </span>`;
        } else {
            stockContainer.innerHTML = `<span class="stock-status stock-out">
                <i class="fa fa-times-circle"></i> Habis untuk ${size}
            </span>`;
        }
    }

    // Update SKU
    function updateSKU(sku) {
        const skuElement = document.getElementById('skuValue');
        if (skuElement) {
            skuElement.textContent = sku;
        }
    }

    // Update quantity max
    function updateQuantityMax(maxStock) {
        const quantityInput = document.getElementById('quantity');
        const decrementBtn = document.getElementById('decrementBtn');
        const incrementBtn = document.getElementById('incrementBtn');
        
        quantityInput.max = maxStock;
        
        if (parseInt(quantityInput.value) > maxStock) {
            quantityInput.value = maxStock > 0 ? 1 : 0;
        }
        
        if (maxStock === 0) {
            quantityInput.disabled = true;
            decrementBtn.disabled = true;
            incrementBtn.disabled = true;
        } else {
            quantityInput.disabled = false;
            decrementBtn.disabled = false;
            incrementBtn.disabled = false;
        }
        
        updateCartQuantity();
    }

    // Quantity functions
    function incrementQuantity() {
        const input = document.getElementById('quantity');
        let value = parseInt(input.value);
        const maxStock = currentMaxStock;
        
        if (value < maxStock) {
            input.value = value + 1;
            updateCartQuantity();
        } else {
            showNotification(`Stok tersedia hanya ${maxStock} item untuk ukuran ${selectedSize}`, 'error');
        }
    }

    function decrementQuantity() {
        const input = document.getElementById('quantity');
        let value = parseInt(input.value);
        if (value > 1) {
            input.value = value - 1;
            updateCartQuantity();
        }
    }

    function updateCartQuantity() {
        const quantity = document.getElementById('quantity').value;
        document.getElementById('cartQuantity').value = quantity;
    }

    // Size Guide Modal
    function showSizeGuide(event) {
        event.preventDefault();
        const modal = document.getElementById('sizeGuideModal');
        modal.classList.add('active');
    }

    function closeSizeGuide() {
        const modal = document.getElementById('sizeGuideModal');
        modal.classList.remove('active');
    }

    // Lightbox
    function closeLightbox() {
        document.getElementById('lightbox').classList.remove('active');
    }

    // Notification
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <i class="fa ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
            <span>${message}</span>
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // Format number to Indonesian currency format
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Validate quantity change
    document.getElementById('quantity').addEventListener('change', function() {
        let value = parseInt(this.value);
        const max = currentMaxStock;
        
        if (isNaN(value) || value < 1) {
            this.value = 1;
        }
        if (value > max) {
            this.value = max;
            showNotification(`Stok maksimal ${max} item untuk ukuran ${selectedSize}`, 'error');
        }
        updateCartQuantity();
    });

    // Validate form before submit
    document.getElementById('cartForm').addEventListener('submit', function(e) {
        if (!selectedSize) {
            e.preventDefault();
            showNotification('Silakan pilih ukuran terlebih dahulu!', 'error');
            return false;
        }
        
        const quantity = parseInt(document.getElementById('quantity').value);
        const maxStock = currentMaxStock;
        
        if (quantity > maxStock) {
            e.preventDefault();
            showNotification(`Stok untuk ukuran ${selectedSize} hanya ${maxStock} pcs`, 'error');
            return false;
        }
        
        if (quantity < 1) {
            e.preventDefault();
            showNotification('Minimal pembelian 1 item', 'error');
            return false;
        }
        
        return true;
    });

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('sizeGuideModal');
        if (event.target === modal) {
            modal.classList.remove('active');
        }
        
        const lightbox = document.getElementById('lightbox');
        if (event.target === lightbox) {
            lightbox.classList.remove('active');
        }
    }
</script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@endsection