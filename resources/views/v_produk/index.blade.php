@extends('v_layouts.app') 
@section('content')

<style>
    /* Main Container */
    .product-showcase {
        min-height: 80vh;
        padding: 140px 0 100px;
        position: relative;
    }

    /* Header Styling */
    .section-header {
        text-align: center;
        position: relative;
        z-index: 2;
        margin-bottom: 60px;
    }

    .section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(34px, 6vw, 52px);
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 16px;
    }

    .section-title span {
        color: var(--primary);
        font-style: italic;
    }

    .section-subtitle {
        color: var(--text-muted);
        font-size: 16px;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Product Grid */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 40px;
        position: relative;
        z-index: 2;
    }

    /* Premium Card */
    .product-card {
        background: var(--bg-white);
        border: 1px solid var(--border);
        padding: 16px;
        position: relative;
        transition: 0.35s ease;
        display: flex;
        flex-direction: column;
        animation: revealUp 0.8s ease backwards;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-md);
        border-color: transparent;
    }

    @keyframes revealUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Image Wrapper */
    .image-wrapper {
        position: relative;
        width: 100%;
        overflow: hidden;
        aspect-ratio: 1/1;
        background: var(--bg-creme);
    }

    .image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.5s;
    }

    .product-card:hover .image-wrapper img {
        transform: scale(1.05);
    }

    /* Badges */
    .badges {
        position: absolute;
        top: 24px; left: 24px;
        z-index: 3;
    }

    .badge-nc {
        background: var(--primary);
        color: white;
        padding: 4px 12px;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    /* Info Area */
    .info-area {
        padding: 24px 8px 8px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .product-name {
        font-family: 'DM Sans', sans-serif;
        font-size: 18px;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0 0 10px;
        text-decoration: none;
        transition: 0.3s;
    }

    .product-card:hover .product-name {
        color: var(--primary);
    }

    .price-main {
        font-size: 18px;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 15px;
        display: block;
    }

    .tag-list {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 20px;
    }

    .tag-item {
        font-size: 11px;
        background: var(--bg-creme);
        padding: 4px 12px;
        letter-spacing: 0.3px;
        color: var(--text-muted);
    }

    /* Action Button */
    .btn-action {
        margin-top: auto;
        width: 100%;
        padding: 12px;
        background: transparent;
        border: 1px solid var(--border);
        color: var(--text-dark);
        font-weight: 600;
        font-size: 11px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-action:hover {
        background: var(--text-dark);
        color: white;
        border-color: var(--text-dark);
    }

    /* Modern Pagination */
    .pagination-wrapper {
        margin-top: 60px;
        display: flex;
        justify-content: center;
    }

    .pagination-wrapper .page-item .page-link {
        border: 1px solid var(--border);
        color: var(--text-muted);
        font-weight: 600;
        padding: 10px 16px;
        margin: 0 4px;
        transition: 0.3s;
        background: var(--bg-white);
        border-radius: 0;
    }

    .pagination-wrapper .page-item.active .page-link {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    @media (max-width: 768px) {
        .product-showcase { padding: 180px 0 80px; }
        .product-grid { grid-template-columns: 1fr; max-width: 460px; margin: 0 auto; }
    }
</style>

<section class="product-showcase">
    <div class="container">
        
        <div class="section-header">
            <h1 class="section-title">Koleksi <span>Terbaik</span> Kami</h1>
            <p class="section-subtitle">Temukan mahakarya rasa dalam setiap gigitan cookies premium kami. Dipanggang dengan cinta, disajikan untuk kesempurnaan momen Anda.</p>
        </div>

        @if($produk->count() > 0)
        <div class="product-grid">
            @foreach ($produk as $index => $row)
            <div class="product-card" style="animation-delay: {{ $index * 0.1 }}s">
                
                <div class="badges">
                    @if($loop->first)
                        <span class="badge-nc">Hot Sale</span>
                    @elseif($loop->iteration == 2)
                        <span class="badge-nc">New Arrival</span>
                    @endif
                </div>

                <a href="{{ route('produk.detail', $row->id) }}" class="image-wrapper">
                    @php
                        $fotoUrl = asset('frontend/images/default-product.jpg');
                        if($row->foto) {
                            $fotoUrl = asset('storage/img-produk/' . $row->foto);
                        } elseif($row->fotoProduk->first()) {
                            $fotoUrl = asset('storage/img-produk/' . $row->fotoProduk->first()->foto);
                        }
                    @endphp
                    <img src="{{ $fotoUrl }}" alt="{{ $row->nama_produk }}">
                </a>

                <div class="info-area">
                    <a href="{{ route('produk.detail', $row->id) }}" class="product-name">
                        {{ $row->nama_produk }}
                    </a>
                    
                    <span class="price-main">Rp {{ number_format($row->harga, 0, ',', '.') }}</span>

                    <div class="tag-list">
                        <span class="tag-item">{{ $row->kategori->nama_kategori ?? 'Premium' }}</span>
                        @php 
                            $tags = $row->bahan ? array_slice(explode(',', $row->bahan), 0, 2) : ['Artisan', 'Fresh Oven'];
                        @endphp
                        @foreach($tags as $tag)
                            <span class="tag-item">{{ trim($tag) }}</span>
                        @endforeach
                    </div>

                    <a href="{{ route('produk.detail', $row->id) }}" class="btn-action">
                        Lihat Detail
                    </a>
                </div>

            </div>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $produk->links('vendor.pagination.custom') }}
        </div>
        
        @else
        <div class="text-center py-5" style="position: relative; z-index: 2;">
            <i class="fa fa-cookie-bite" style="font-size: 80px; color: var(--text-muted); opacity: 0.3; margin-bottom: 20px;"></i>
            <h3 style="color: var(--text-dark); font-family: 'Playfair Display', serif;">Etalase Kosong</h3>
            <p style="color: var(--text-muted);">Master baker kami sedang menyiapkan resep baru.<br>Silakan kembali lagi nanti.</p>
        </div>
        @endif
    </div>
</section>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
    function toggleWishlist(btn, event) {
        event.preventDefault();
        event.stopPropagation();
        
        const icon = btn.querySelector('i');
        if (icon.classList.contains('fa-heart-o')) {
            icon.classList.remove('fa-heart-o');
            icon.classList.add('fa-heart');
            btn.style.background = '#E53935';
            icon.style.color = 'white';
        } else {
            icon.classList.remove('fa-heart');
            icon.classList.add('fa-heart-o');
            btn.style.background = 'rgba(255, 255, 255, 0.9)';
            icon.style.color = 'var(--text-muted)';
        }
    }
</script>

@endsection