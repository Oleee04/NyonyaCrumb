@extends('v_layouts.app') 
@section('content')

<style>
    :root {
        --primary: #C47A3E;
        --primary-dark: #8A5021;
        --primary-glow: rgba(196, 122, 62, 0.35);
        --bg-main: #FFF8F3; /* Warm bakery ambient */
        --card-bg: rgba(255, 255, 255, 0.85);
        --text-dark: #2A1C14;
        --text-muted: #7A6253;
        --border-glass: rgba(255, 255, 255, 0.6);
        --glass-shadow: 0 12px 32px rgba(138, 80, 33, 0.08);
        --transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Main Container */
    .product-showcase {
        background: linear-gradient(135deg, #FFF8F3 0%, #FDF1E7 100%);
        min-height: 80vh;
        padding: 120px 0 100px;
        position: relative;
        overflow: hidden;
    }

    /* Floating Ambient Blobs */
    .product-showcase::before, .product-showcase::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        z-index: 0;
        opacity: 0.6;
        animation: floatBlob 15s infinite alternate ease-in-out;
    }
    .product-showcase::before {
        top: -10%; left: -5%;
        width: 400px; height: 400px;
        background: rgba(196, 122, 62, 0.2);
    }
    .product-showcase::after {
        bottom: -10%; right: -5%;
        width: 500px; height: 500px;
        background: rgba(240, 192, 144, 0.25);
        animation-delay: -5s;
    }

    @keyframes floatBlob {
        0% { transform: translate(0, 0) scale(1); }
        100% { transform: translate(30px, 50px) scale(1.1); }
    }

    /* Header Styling */
    .section-header {
        text-align: center;
        position: relative;
        z-index: 2;
        margin-bottom: 60px;
    }

    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 52px;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 16px;
        letter-spacing: -1px;
    }

    .section-title span {
        color: var(--primary);
        position: relative;
        display: inline-block;
    }

    .section-subtitle {
        color: var(--text-muted);
        font-size: 18px;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
        font-weight: 400;
    }

    /* Product Grid */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 36px;
        position: relative;
        z-index: 2;
    }

    /* Premium Glass Card */
    .product-card {
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--border-glass);
        border-radius: 24px;
        padding: 16px;
        position: relative;
        transition: var(--transition);
        box-shadow: var(--glass-shadow);
        display: flex;
        flex-direction: column;
        animation: fadeUp 0.8s ease backwards;
        cursor: pointer;
    }

    .product-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 24px 48px var(--primary-glow);
        border-color: rgba(196, 122, 62, 0.3);
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Image Wrapper */
    .image-wrapper {
        position: relative;
        width: 100%;
        border-radius: 18px;
        overflow: hidden;
        padding-top: 100%; /* 1:1 Aspect Ratio */
        background: #F4EBE2;
        box-shadow: inset 0 0 20px rgba(0,0,0,0.03);
    }

    .image-wrapper img {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .product-card:hover .image-wrapper img {
        transform: scale(1.1) rotate(2deg);
    }

    /* Badges */
    .badges {
        position: absolute;
        top: 16px; left: 16px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        z-index: 3;
    }

    .badge-premium {
        background: linear-gradient(135deg, #E53935, #C62828);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        box-shadow: 0 4px 10px rgba(229, 57, 53, 0.3);
        text-transform: uppercase;
    }

    .badge-new {
        background: linear-gradient(135deg, #4CAF50, #2E7D32);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        box-shadow: 0 4px 10px rgba(76, 175, 80, 0.3);
        text-transform: uppercase;
    }

    /* Wishlist Button */
    .btn-wishlist {
        position: absolute;
        top: 16px; right: 16px;
        width: 40px; height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(4px);
        display: flex; align-items: center; justify-content: center;
        color: var(--text-muted);
        border: none;
        cursor: pointer;
        z-index: 3;
        transition: var(--transition);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transform: scale(0.9);
        opacity: 0;
    }

    .product-card:hover .btn-wishlist {
        transform: scale(1);
        opacity: 1;
    }

    .btn-wishlist:hover {
        background: var(--primary);
        color: white;
        transform: scale(1.1);
    }

    /* Product Info Area */
    .info-area {
        padding: 20px 8px 8px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .product-name {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 8px;
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.3s;
    }

    .product-card:hover .product-name {
        color: var(--primary);
    }

    .product-price-wrapper {
        display: flex;
        align-items: baseline;
        gap: 8px;
        margin-bottom: 16px;
    }

    .price-main {
        font-size: 22px;
        font-weight: 800;
        color: var(--primary-dark);
        letter-spacing: -0.5px;
    }

    .price-old {
        font-size: 14px;
        color: #A0938A;
        text-decoration: line-through;
        font-weight: 500;
    }

    /* Tags */
    .tag-list {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 24px;
    }

    .tag-item {
        font-size: 11px;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 8px;
        background: rgba(196, 122, 62, 0.1);
        color: var(--primary-dark);
        transition: var(--transition);
    }

    .product-card:hover .tag-item {
        background: rgba(196, 122, 62, 0.2);
    }

    /* Action Button */
    .btn-action {
        margin-top: auto;
        width: 100%;
        padding: 14px;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        font-weight: 700;
        font-size: 14px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .btn-action::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.6s ease;
    }

    .product-card:hover .btn-action::before {
        left: 100%;
    }

    .btn-action:hover {
        box-shadow: 0 8px 20px var(--primary-glow);
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

    /* Modern Pagination */
    .pagination-wrapper {
        margin-top: 60px;
        display: flex;
        justify-content: center;
        position: relative;
        z-index: 2;
    }

    .pagination-wrapper nav ul {
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        padding: 8px;
        border-radius: 16px;
        border: 1px solid var(--border-glass);
        box-shadow: var(--glass-shadow);
        gap: 4px;
    }

    .pagination-wrapper .page-item .page-link {
        border-radius: 10px;
        border: none;
        color: var(--text-muted);
        font-weight: 600;
        padding: 10px 16px;
        margin: 0 2px;
        transition: var(--transition);
        background: transparent;
    }

    .pagination-wrapper .page-item.active .page-link {
        background: var(--primary);
        color: white;
        box-shadow: 0 4px 12px var(--primary-glow);
    }

    .pagination-wrapper .page-item:not(.active) .page-link:hover {
        background: rgba(196, 122, 62, 0.1);
        color: var(--primary-dark);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .section-title { font-size: 36px; }
        .product-grid { grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 24px; padding: 0 16px; }
        .product-card { padding: 12px; }
        .info-area { padding: 16px 4px 4px; }
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
                        <span class="badge-premium">Hot Sale</span>
                    @elseif($loop->iteration == 2)
                        <span class="badge-new">New Arrival</span>
                    @endif
                </div>

                <button class="btn-wishlist" onclick="toggleWishlist(this, event)">
                    <i class="fa fa-heart-o"></i>
                </button>

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
                    
                    <div class="product-price-wrapper">
                        <span class="price-main">Rp {{ number_format($row->harga, 0, ',', '.') }}</span>
                        @if($loop->iteration % 3 == 0)
                        <span class="price-old">Rp {{ number_format($row->harga * 1.2, 0, ',', '.') }}</span>
                        @endif
                    </div>

                    <div class="tag-list">
                        <span class="tag-item"><i class="fa fa-star text-warning"></i> {{ $row->kategori->nama_kategori ?? 'Premium' }}</span>
                        @php 
                            $tags = $row->bahan ? array_slice(explode(',', $row->bahan), 0, 2) : ['Artisan', 'Fresh Oven'];
                        @endphp
                        @foreach($tags as $tag)
                            <span class="tag-item">{{ trim($tag) }}</span>
                        @endforeach
                    </div>

                    <a href="{{ route('produk.detail', $row->id) }}" class="btn-action">
                        <i class="fa fa-shopping-bag"></i>
                        Pesan Sekarang
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