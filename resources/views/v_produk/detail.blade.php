@extends('v_layouts.app')

@section('content')
<style>
    /* Main Container */
    .product-detail-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 160px 24px 80px;
        position: relative;
        z-index: 2;
    }

    /* Product Card */
    .product-card {
        background: var(--bg-white);
        border: 1px solid var(--border);
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 60px;
    }

    /* Gallery Section */
    .product-gallery {
        flex: 1 1 500px;
        padding: 40px;
        background: var(--bg-creme);
        border-right: 1px solid var(--border);
    }

    .main-image-container {
        width: 100%;
        aspect-ratio: 1/1;
        overflow: hidden;
        margin-bottom: 20px;
        background: white;
        border: 1px solid var(--border);
    }

    .main-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.5s;
    }

    .thumbnail-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
    }

    .thumbnail-item {
        aspect-ratio: 1/1;
        overflow: hidden;
        cursor: pointer;
        border: 1px solid var(--border);
        transition: 0.3s;
    }

    .thumbnail-item:hover, .thumbnail-item.active {
        border-color: var(--primary);
    }

    .thumbnail-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Product Info Section */
    .product-info-section {
        flex: 1 1 400px;
        padding: 40px;
        display: flex;
        flex-direction: column;
    }

    .category-badge {
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--primary);
        margin-bottom: 15px;
        display: block;
        font-weight: 600;
    }

    .product-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(32px, 5vw, 48px);
        font-weight: 600;
        color: var(--text-dark);
        line-height: 1.1;
        margin-bottom: 25px;
    }

    .price-wrapper {
        margin-bottom: 30px;
    }

    .current-price {
        font-size: 28px;
        font-weight: 600;
        color: var(--primary);
    }

    /* Size Selector */
    .size-wrapper {
        margin-bottom: 35px;
    }

    .size-label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 15px;
        display: block;
    }

    .size-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .size-btn {
        padding: 12px 24px;
        background: transparent;
        border: 1px solid var(--border);
        font-size: 11px;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    .size-btn:hover:not(.disabled) {
        border-color: var(--text-dark);
    }

    .size-btn.active {
        background: var(--text-dark);
        color: white;
        border-color: var(--text-dark);
    }

    .size-btn.disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    /* Specs */
    .specs-wrapper {
        margin-bottom: 35px;
        padding: 20px 0;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
    }

    .spec-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 13px;
    }

    .spec-label { color: var(--text-muted); }
    .spec-value { font-weight: 600; color: var(--text-dark); }

    /* Quantity */
    .quantity-wrapper {
        margin-bottom: 35px;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .quantity-btn {
        width: 32px;
        height: 32px;
        background: transparent;
        border: 1px solid var(--border);
        cursor: pointer;
        font-size: 16px;
        transition: 0.2s;
    }

    .quantity-btn:hover:not(:disabled) {
        background: var(--bg-creme);
    }

    .quantity-input {
        width: 40px;
        text-align: center;
        border: none;
        background: transparent;
        font-weight: 600;
        font-size: 15px;
    }

    /* Primary Button */
    .btn-primary-nc {
        width: 100%;
        padding: 16px;
        background: var(--text-dark);
        color: white;
        border: none;
        font-size: 11px;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        text-decoration: none;
        text-align: center;
    }

    .btn-primary-nc:hover:not(:disabled) {
        background: var(--primary);
    }

    /* Reviews Section */
    .reviews-section {
        background: var(--bg-white);
        border: 1px solid var(--border);
        padding: 40px;
    }

    .reviews-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 32px;
        font-weight: 600;
        margin-bottom: 30px;
    }

    @media (max-width: 768px) {
        .product-detail-container { padding: 180px 16px 60px; }
        .product-gallery, .product-info-section { padding: 25px; }
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
                <div class="product-info-section reveal">
                    <span class="category-badge">{{ $row->kategori->nama_kategori ?? 'Cookies' }}</span>
                    <h1 class="product-title">{{ $row->nama_produk }}</h1>
                    
                    <div class="price-wrapper">
                        <span class="current-price">Rp {{ number_format($row->harga, 0, ',', '.') }}</span>
                    </div>

                    <!-- Size Selection -->
                    <div class="size-wrapper">
                        <span class="size-label">Pilih Ukuran</span>
                        <div class="size-buttons">
                            @php 
                                $isBigAvailable = $row->stok > 0;
                                $isSmallAvailable = $row->stok > 0;
                                
                                if ($row->harga == 15000) {
                                    $smallPrice = 10000;
                                } elseif ($row->harga == 12000) {
                                    $smallPrice = 5000;
                                } else {
                                    $smallPrice = round($row->harga * 0.42);
                                }
                            @endphp
                            <button type="button" class="size-btn {{ $isBigAvailable ? '' : 'disabled' }}" 
                                    onclick="{{ $isBigAvailable ? "selectSize('BIG', $row->harga, $row->stok, this)" : '' }}">
                                Besar (Big)
                            </button>
                            <button type="button" class="size-btn {{ $isSmallAvailable ? '' : 'disabled' }}" 
                                    onclick="{{ $isSmallAvailable ? "selectSize('SMALL', $smallPrice, $row->stok, this)" : '' }}">
                                Kecil (Small)
                            </button>
                        </div>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('order.addToCart', $row->id) }}" method="POST" id="order-form">
                        @csrf
                        <input type="hidden" name="produk_id" value="{{ $row->id }}">
                        <input type="hidden" name="size" id="form-variant" value="">
                        <input type="hidden" name="quantity" id="form-quantity" value="1">

                        <div class="quantity-wrapper">
                            <span class="size-label">Jumlah</span>
                            <div class="quantity-control">
                                <button type="button" class="quantity-btn" onclick="updateQty(-1)">-</button>
                                <input type="text" id="quantity-input" class="quantity-input" value="1" readonly>
                                <button type="button" class="quantity-btn" onclick="updateQty(1)">+</button>
                                <span id="display-stock" style="font-size: 12px; color: var(--text-muted); margin-left: 10px;">
                                    Pilih ukuran untuk cek stok
                                </span>
                            </div>
                        </div>

                        <button type="submit" class="btn-primary-nc" id="btn-submit-order" disabled>
                            Tambah ke Keranjang
                        </button>
                    </form>

                    <div style="margin-top: 30px; font-size: 14px; color: var(--text-muted); line-height: 1.6;">
                        {{ $row->deskripsi }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="reviews-section reveal" style="margin-top: 40px;">
        <h2 class="reviews-title">Ulasan <i>Pelanggan</i></h2>
        
        <div class="rating-overview" style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px; padding-bottom: 30px; border-bottom: 1px solid var(--border);">
            <div class="average-rating" style="text-align: center;">
                <div class="review-rating" style="color: var(--primary); font-size: 24px; margin-bottom: 5px;">
                    @php $averageRating = $reviews->avg('rating'); @endphp
                    @for($i=1; $i<=5; $i++)
                        @if($i <= round($averageRating ?: 5))
                            <i class="fa fa-star"></i>
                        @else
                            <i class="fa fa-star-o"></i>
                        @endif
                    @endfor
                </div>
                <div class="rating-text" style="font-size: 14px; color: var(--text-muted);">
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
    let selectedSize = '';
    let maxStock = 0;

    function changeImage(url, thumb) {
        document.getElementById('mainImage').src = url;
        document.querySelectorAll('.thumbnail-item').forEach(item => item.classList.remove('active'));
        thumb.classList.add('active');
    }

    // Set up thumbnail listeners
    document.addEventListener('DOMContentLoaded', function() {
        const thumbnails = document.querySelectorAll('.thumbnail-item');
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                changeImage(this.getAttribute('data-image'), this);
            });
        });
    });

    function selectSize(size, price, stock, btn) {
        selectedSize = size;
        maxStock = stock;
        
        // Update price and stock display
        document.querySelector('.current-price').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
        document.getElementById('display-stock').textContent = stock + ' Pcs tersedia';
        
        // Update buttons
        document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        
        // Update form
        document.getElementById('form-variant').value = size;
        document.getElementById('btn-submit-order').disabled = false;
        
        // Reset qty
        document.getElementById('quantity-input').value = 1;
        document.getElementById('form-quantity').value = 1;
    }

    function updateQty(delta) {
        if (!selectedSize) {
            alert('Silakan pilih ukuran terlebih dahulu.');
            return;
        }
        
        let input = document.getElementById('quantity-input');
        let current = parseInt(input.value);
        let next = current + delta;
        
        if (next >= 1 && next <= maxStock) {
            input.value = next;
            document.getElementById('form-quantity').value = next;
        } else if (next > maxStock) {
            alert('Stok tidak mencukupi untuk ukuran ini.');
        }
    }

    function closeLightbox() {
        document.getElementById('lightbox').classList.remove('active');
    }

    function closeSizeGuide() {
        document.getElementById('sizeGuideModal').style.display = 'none';
    }
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection