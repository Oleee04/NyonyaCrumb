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

    /* Choice card styling for SPK */
    .choice-card {
        position: relative;
        display: block;
        padding: 20px 15px;
        border: 2px solid var(--border);
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
        background: var(--bg-white);
    }
    .choice-card:hover {
        border-color: var(--primary-light) !important;
        background: rgba(141, 110, 99, 0.04);
        transform: translateY(-2px);
    }
    .choice-card.checked-style {
        border-color: var(--primary) !important;
        background: rgba(141, 110, 99, 0.08) !important;
        box-shadow: 0 4px 12px rgba(141, 110, 99, 0.15) !important;
    }

    /* SPK Recommendation styling fixes */
    .spk-rekomendasi-results {
        margin-bottom: 60px;
        background: var(--bg-white);
        border: 1px solid var(--border);
        padding: 40px;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-md);
        text-align: left;
    }
    .spk-best-card {
        border: 2px solid var(--primary);
        border-radius: var(--radius-md);
        overflow: hidden;
        margin-bottom: 40px;
        position: relative;
        background: var(--bg-white);
        box-shadow: var(--shadow-sm);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .spk-best-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }
    .spk-alt-card {
        display: flex;
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        overflow: hidden;
        background: #fff;
        flex-direction: row;
        min-height: 140px;
        align-items: stretch;
        height: 100%;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .spk-alt-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-sm);
        border-color: var(--primary-light);
    }
</style>

<section class="product-showcase">
    <div class="container">
        
        <div class="section-header">
            <h1 class="section-title">Koleksi <span>Terbaik</span> Kami</h1>
            <p class="section-subtitle">Temukan mahakarya rasa dalam setiap gigitan cookies premium kami. Dipanggang dengan cinta, disajikan untuk kesempurnaan momen Anda.</p>
        </div>

        <!-- BANNER INTERAKTIF SPK -->
        <div class="spk-widget" style="margin-bottom: 50px;">
            <!-- Banner Widget -->
            <div class="spk-banner" id="spkBanner" style="background: linear-gradient(135deg, #8D6E63, #5D4037); color: #fff; padding: 24px 32px; border-radius: var(--radius-md); display: flex; align-items: center; justify-content: space-between; box-shadow: var(--shadow-sm); transition: transform 0.3s; flex-wrap: wrap; gap: 15px;">
                <div style="display: flex; align-items: center; gap: 18px; text-align: left;">
                    <div style="font-size: 32px;"><i class="fa fa-info-circle"></i></div>
                    <div>
                        <h4 style="font-size: 18px; margin: 0 0 4px; color: #fff; font-family: 'DM Sans', sans-serif; font-weight: 700;">Bingung Pilih Varian Cookies?</h4>
                        <p style="font-size: 13px; margin: 0; opacity: 0.9;">Temukan cookies rekomendasi terbaik secara real-time dengan asisten cerdas kami!</p>
                    </div>
                </div>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <button type="button" id="btnResetQuiz" onclick="resetQuiz()" style="display: none; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); color: #fff; padding: 10px 18px; font-weight: 700; font-size: 12px; cursor: pointer; border-radius: 4px; height: 45px; display: flex; align-items: center; justify-content: center; gap: 6px; transition: all 0.3s;" title="Reset Rekomendasi">
                        <i class="fa fa-sync"></i> Reset
                    </button>
                    <button type="button" onclick="submitQuiz()" style="background: var(--primary); border: 1px solid rgba(255,255,255,0.4); color: #fff; padding: 12px 24px; font-weight: 700; font-size: 12px; cursor: pointer; border-radius: 4px; height: 45px; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: var(--shadow-sm); text-transform: uppercase; letter-spacing: 0.5px; transition: all 0.3s;">
                        Analisis Rekomendasi <i class="fa fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Loading Overlay -->
        <div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6); z-index: 99999; justify-content: center; align-items: center; flex-direction: column; backdrop-filter: blur(5px);">
            <div style="width: 50px; height: 50px; border: 5px solid rgba(255,255,255,0.3); border-radius: 50%; border-top-color: #fff; animation: spin 1s ease-in-out infinite; -webkit-animation: spin 1s ease-in-out infinite;"></div>
            <div style="color: #fff; font-size: 18px; font-weight: 600; margin-top: 20px; font-family: 'DM Sans', sans-serif;">Menganalisis rekomendasi...</div>
        </div>

        <style>
            @keyframes spin {
                to { transform: rotate(360deg); }
            }
            @-webkit-keyframes spin {
                to { -webkit-transform: rotate(360deg); }
            }
        </style>

        <!-- Container for AJAX recommendation results -->
        <div id="spkResultsContainer" style="display: none; margin-bottom: 60px;"></div>

        <!-- Tampilan Awal: Sebelum Filter -->
        <div id="spkPlaceholder" class="text-center py-5 initial-placeholder reveal" style="position: relative; z-index: 2; background: var(--bg-white); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 60px 40px; box-shadow: var(--shadow-sm); margin-top: 30px;">
            <div style="font-size: 64px; margin-bottom: 24px; color: var(--primary); opacity: 0.8;"><i class="fa fa-cookie-bite"></i></div>
            <h3 style="color: var(--text-dark); font-family: 'Cormorant Garamond', serif; font-size: 28px; font-weight: 600; margin-bottom: 12px;">Temukan Cookies Pilihan Anda</h3>
            <p style="color: var(--text-muted); max-width: 500px; margin: 0 auto; font-size: 14.5px; line-height: 1.7;">
                Silakan tekan tombol "Analisis Rekomendasi" di atas untuk melihat rekomendasi cookies terbaik yang paling sesuai untuk Anda secara real-time!
            </p>
        </div>

        <!-- Default product list when no recommendation results are active -->
        <div id="defaultProductsContainer">
            @if($produk->count() > 0)
            <div class="product-grid">
                @foreach ($produk as $index => $row)
                <div class="product-card" style="animation-delay: {{ $index * 0.1 }}s; position: relative;">
                    
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
    </div>
</section>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
    window.isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
    window.cartUrlTemplate = "{{ route('order.addToCart', ':id') }}";
    window.loginUrl = "{{ route('auth.login') }}";
    window.csrfToken = "{{ csrf_token() }}";

    document.addEventListener('DOMContentLoaded', function() {
        updateResetButtonVisibility();
    });

    function updateResetButtonVisibility() {
        const btnReset = document.getElementById('btnResetQuiz');
        if (document.getElementById('spkResultsContainer').style.display === 'block') {
            btnReset.style.display = 'flex';
        } else {
            btnReset.style.display = 'none';
        }
    }

    function resetQuiz() {
        document.getElementById('spkResultsContainer').style.display = 'none';
        document.getElementById('spkResultsContainer').innerHTML = '';
        document.getElementById('spkPlaceholder').style.display = 'block';
        document.getElementById('defaultProductsContainer').style.display = 'block';
        
        updateResetButtonVisibility();
    }

    function toggleGapDetails(id) {
        const detailsDiv = document.getElementById('gap-details-' + id);
        const chevron = document.getElementById('gap-chevron-' + id);
        if (detailsDiv.style.display === 'none') {
            detailsDiv.style.display = 'block';
            chevron.classList.remove('fa-chevron-down');
            chevron.classList.add('fa-chevron-up');
        } else {
            detailsDiv.style.display = 'none';
            chevron.classList.remove('fa-chevron-up');
            chevron.classList.add('fa-chevron-down');
        }
    }

    async function submitQuiz() {
        // Show loading overlay
        document.getElementById('loadingOverlay').style.display = 'flex';

        try {
            const response = await fetch("{{ route('produk.rekomendasi') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": window.csrfToken
                },
                body: JSON.stringify({})
            });

            const result = await response.json();
            
            // Hide loading overlay
            document.getElementById('loadingOverlay').style.display = 'none';

            if (result.success && result.data.length > 0) {
                // Hide default list & placeholder
                document.getElementById('spkPlaceholder').style.display = 'none';
                document.getElementById('defaultProductsContainer').style.display = 'none';
                
                const resultsContainer = document.getElementById('spkResultsContainer');
                resultsContainer.style.display = 'block';
                
                let htmlContent = `
                    <div class="spk-rekomendasi-results">
                        <h3 style="font-size: 24px; color: var(--text-dark); margin-bottom: 8px; display: flex; align-items: center; gap: 8px; font-family: 'Cormorant Garamond', serif; font-weight: 600;">
                            Rekomendasi Spesial Anda
                        </h3>
                        <p style="font-size: 14px; color: var(--text-muted); margin-bottom: 30px;">Berikut adalah hasil kalkulasi Profile Matching terbaik yang paling sesuai dengan selera Anda:</p>
                `;

                // Peringkat 1
                const bestMatch = result.data[0];
                let bestCartBtn = '';
                if (window.isLoggedIn) {
                    let actionUrl = window.cartUrlTemplate.replace(':id', bestMatch.produk_id);
                    bestCartBtn = `
                        <form action="${actionUrl}" method="POST" style="flex: 1; min-width: 150px;">
                            <input type="hidden" name="_token" value="${window.csrfToken}">
                            <button type="submit" style="width: 100%; border: none; padding: 10px; background: var(--primary); color: #fff; font-size: 12px; font-weight: 700; border-radius: 4px; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 6px;">
                                <i class="fa fa-shopping-cart"></i> Tambah ke Keranjang
                            </button>
                        </form>
                    `;
                } else {
                    bestCartBtn = `
                        <a href="${window.loginUrl}" style="flex: 1; min-width: 150px; text-align: center; text-decoration: none; padding: 10px; background: var(--primary); color: #fff; font-size: 12px; font-weight: 700; border-radius: 4px; display: flex; align-items: center; justify-content: center; gap: 6px;">
                            <i class="fa fa-sign-in"></i> Masuk untuk Membeli
                        </a>
                    `;
                }

                // Stars rating rendering
                let bestStarsHtml = '';
                const roundedBestStars = Math.round(parseFloat(bestMatch.rating_stars) || 5);
                for (let i = 1; i <= 5; i++) {
                    if (i <= roundedBestStars) {
                        bestStarsHtml += '<i class="fa fa-star" style="color: #D4A373; margin-right: 2px;"></i>';
                    } else {
                        bestStarsHtml += '<i class="fa fa-star-o" style="color: #D4A373; margin-right: 2px;"></i>';
                    }
                }

                htmlContent += `
                    <!-- Peringkat 1 (Best Match) -->
                    <div class="spk-best-card">
                        <div style="position: absolute; top: 16px; right: 16px; background: var(--primary); color: #fff; padding: 4px 12px; font-size: 12px; font-weight: 700; border-radius: 30px; z-index: 10;">
                            🏆 Rank ${bestMatch.ranking} | ${bestMatch.match_score}% Match
                        </div>

                        <div class="row g-0 align-items-stretch">
                            <!-- Img wrapper -->
                            <div class="col-md-5 col-lg-4" style="position: relative; min-height: 260px; overflow: hidden; background: var(--bg-creme);">
                                <img src="${bestMatch.foto}" alt="${bestMatch.nama_produk}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                <span style="position: absolute; bottom: 12px; left: 12px; background: #3E2723; color: #fff; font-size: 9px; padding: 3px 8px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; z-index: 2;">Rekomendasi Utama</span>
                            </div>

                            <!-- Info wrapper -->
                            <div class="col-md-7 col-lg-8" style="display: flex; flex-direction: column; justify-content: center; background: #fff;">
                                <div style="padding: 30px 40px;">
                                    <span style="color: var(--primary); font-size: 10px; font-weight: 700; text-transform: uppercase; margin-bottom: 4px; display: block;">Nilai Akhir: ${bestMatch.nilai_akhir}</span>
                                    <h4 style="font-size: 26px; color: var(--text-dark); margin: 0 0 8px; font-family: 'Cormorant Garamond', serif; font-weight: 600;">${bestMatch.nama_produk}</h4>
                                    <div style="font-size: 18px; font-weight: 700; color: var(--primary); margin-bottom: 12px;">${bestMatch.harga_formatted}</div>

                                    <!-- Rating & Social Proof -->
                                     <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; margin-bottom: 12px;">
                                         <span style="display: inline-flex;">${bestStarsHtml}</span>
                                         <span style="font-weight: 700; color: var(--text-dark);">${bestMatch.rating_stars}</span>
                                         <span style="color: var(--text-muted);">(${bestMatch.review_count} ulasan)</span>
                                     </div>

                                     <!-- Decision Badges -->
                                     <div style="margin-bottom: 15px; display: flex; flex-wrap: wrap; gap: 6px;">
                                         ${bestMatch.details.c1.profil === 'Banyak Terjual' ? `<span style="background: #2563eb; color: #fff; font-size: 9px; padding: 4px 8px; font-weight: 700; border-radius: 3px; text-transform: uppercase;"><i class="fa fa-fire"></i> Terlaris</span>` : ''}
                                         ${bestMatch.details.c2.profil.includes('Besar') ? `<span style="background: #059669; color: #fff; font-size: 9px; padding: 4px 8px; font-weight: 700; border-radius: 3px; text-transform: uppercase;"><i class="fa fa-box"></i> Porsi Besar</span>` : ''}
                                         ${bestMatch.details.c3.gap == 0 ? `<span style="background: #d97706; color: #fff; font-size: 9px; padding: 4px 8px; font-weight: 700; border-radius: 3px; text-transform: uppercase;"><i class="fa fa-tags"></i> Best Deal</span>` : ''}
                                         ${bestMatch.stok <= 5 ? `<span style="background: #dc2626; color: #fff; font-size: 9px; padding: 4px 8px; font-weight: 700; border-radius: 3px; text-transform: uppercase;"><i class="fa fa-hourglass-half"></i> Stok Tipis</span>` : ''}
                                     </div>

                                    <!-- Testimoni / Penjelasan singkat -->
                                    <p style="font-size: 13.5px; color: var(--text-dark); font-style: italic; background: var(--bg-creme); padding: 12px 16px; border-left: 3px solid var(--primary); margin: 0 0 15px 0; line-height: 1.5;">
                                        "${bestMatch.review_text}"
                                    </p>
                                    
                                    <p style="font-size: 13.5px; color: var(--text-dark); margin-bottom: 15px; line-height: 1.5;">
                                        💬 <strong>Hasil Analisis:</strong> ${bestMatch.explanation}
                                    </p>

                                    <!-- Stok Urgency -->
                                    <div style="font-size: 11px; color: #b45309; font-weight: 700; margin-bottom: 18px;">
                                        <i class="fa fa-exclamation-circle"></i> Stok Terbatas: Hanya sisa ${bestMatch.stok} kemasan lagi!
                                    </div>

                                    <!-- CTAs -->
                                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                        ${bestCartBtn}
                                        <a href="${bestMatch.detail_url}" style="padding: 10px 18px; border: 1px solid var(--primary); background: transparent; color: var(--primary); font-size: 12px; font-weight: 600; border-radius: 4px; text-decoration: none; text-align: center; display: inline-block;">
                                            Detail
                                        </a>
                                    </div>

                                    <!-- Collapsible GAP Detail -->
                                    <div class="gap-detail-header" onclick="toggleGapDetails(${bestMatch.produk_id})" style="cursor: pointer; display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-top: 1px solid var(--border); margin-top: 18px; font-size: 13px; font-weight: 600; color: var(--primary);">
                                        <span>Lihat Detail Perhitungan GAP</span>
                                        <i class="fa fa-chevron-down" id="gap-chevron-${bestMatch.produk_id}"></i>
                                    </div>
                                    <div id="gap-details-${bestMatch.produk_id}" style="display: none; padding-top: 12px;">
                                        <table class="table table-sm table-borderless" style="font-size: 12px; margin-bottom: 0; width: 100%;">
                                            <thead>
                                                <tr style="border-bottom: 1px solid var(--border); font-weight: bold; color: var(--text-dark);">
                                                    <th style="padding: 6px 0;">Kriteria</th>
                                                    <th class="text-center" style="padding: 6px 0;">Profil Produk</th>
                                                    <th class="text-center" style="padding: 6px 0;">Profil Ideal</th>
                                                    <th class="text-center" style="padding: 6px 0;">GAP</th>
                                                    <th class="text-center" style="padding: 6px 0;">Bobot</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="padding: 6px 0;">C1: Jumlah Penjualan (Core)</td>
                                                    <td class="text-center" style="padding: 6px 0;">${bestMatch.details.c1.profil}</td>
                                                    <td class="text-center" style="padding: 6px 0;">${bestMatch.details.c1.ideal}</td>
                                                    <td class="text-center" style="padding: 6px 0;">${bestMatch.details.c1.gap}</td>
                                                    <td class="text-center" style="padding: 6px 0;">${bestMatch.details.c1.bobot}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 6px 0;">C2: Ukuran (Core)</td>
                                                    <td class="text-center" style="padding: 6px 0;">${bestMatch.details.c2.profil}</td>
                                                    <td class="text-center" style="padding: 6px 0;">${bestMatch.details.c2.ideal}</td>
                                                    <td class="text-center" style="padding: 6px 0;">${bestMatch.details.c2.gap}</td>
                                                    <td class="text-center" style="padding: 6px 0;">${bestMatch.details.c2.bobot}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 6px 0;">C3: Harga (Secondary)</td>
                                                    <td class="text-center" style="padding: 6px 0;">${bestMatch.details.c3.profil}</td>
                                                    <td class="text-center" style="padding: 6px 0;">${bestMatch.details.c3.ideal}</td>
                                                    <td class="text-center" style="padding: 6px 0;">${bestMatch.details.c3.gap}</td>
                                                    <td class="text-center" style="padding: 6px 0;">${bestMatch.details.c3.bobot}</td>
                                                </tr>
                                                <tr style="border-top: 1px solid var(--border); font-weight: bold;">
                                                    <td colspan="4" style="padding: 6px 0;">Core Factor (NCF)</td>
                                                    <td class="text-center" style="padding: 6px 0;">${parseFloat(bestMatch.ncf).toFixed(2)}</td>
                                                </tr>
                                                <tr style="font-weight: bold;">
                                                    <td colspan="4" style="padding: 6px 0;">Secondary Factor (NSF)</td>
                                                    <td class="text-center" style="padding: 6px 0;">${parseFloat(bestMatch.nsf).toFixed(2)}</td>
                                                </tr>
                                                <tr style="border-top: 2px solid var(--primary); font-weight: bold; color: var(--primary);">
                                                    <td colspan="4" style="padding: 6px 0;">Nilai Total (70% NCF + 30% NSF)</td>
                                                    <td class="text-center" style="padding: 6px 0;">${bestMatch.nilai_akhir}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                `;

                // Alternatif Lainnya
                if (result.data.length > 1) {
                    htmlContent += `
                        <h5 style="font-size: 13px; font-weight: 700; text-transform: uppercase; color: var(--text-dark); margin: 40px 0 20px; letter-spacing: 1px; font-family: 'DM Sans', sans-serif; display: flex; align-items: center; gap: 8px;">
                            Alternatif Lainnya
                        </h5>
                        <div class="row g-4">
                    `;

                    result.data.slice(1).forEach((alt, idx) => {
                        let altCartBtn = '';
                        if (window.isLoggedIn) {
                            let actionUrl = window.cartUrlTemplate.replace(':id', alt.produk_id);
                            altCartBtn = `
                                <form action="${actionUrl}" method="POST" style="width: 100%;">
                                    <input type="hidden" name="_token" value="${window.csrfToken}">
                                    <button type="submit" style="width: 100%; border: none; padding: 10px 12px; background: var(--primary); color: #fff; font-size: 11px; font-weight: 700; border-radius: 4px; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 4px; height: 38px;">
                                        <i class="fa fa-shopping-cart"></i> + Keranjang
                                    </button>
                                </form>
                            `;
                        } else {
                            altCartBtn = `
                                <a href="${window.loginUrl}" style="width: 100%; text-decoration: none; padding: 10px 12px; background: var(--primary); color: #fff; font-size: 11px; font-weight: 700; border-radius: 4px; display: flex; align-items: center; justify-content: center; gap: 4px; height: 38px;">
                                    <i class="fa fa-sign-in"></i> Masuk
                                </a>
                            `;
                        }

                        // Decision Triggers Badges
                        let badgeHtml = '';
                        if (alt.details.c1.profil === 'Banyak Terjual') {
                            badgeHtml += `<span style="background: #2563eb; color: #fff; font-size: 8.5px; padding: 3px 6px; font-weight: 700; border-radius: 3px; text-transform: uppercase; display: inline-block; margin-right: 4px; margin-bottom: 4px;"><i class="fa fa-fire"></i> Terlaris</span>`;
                        }
                        if (alt.details.c2.profil.includes('Besar')) {
                            badgeHtml += `<span style="background: #059669; color: #fff; font-size: 8.5px; padding: 3px 6px; font-weight: 700; border-radius: 3px; text-transform: uppercase; display: inline-block; margin-right: 4px; margin-bottom: 4px;"><i class="fa fa-box"></i> Porsi Besar</span>`;
                        }
                        if (alt.details.c3.gap == 0) {
                            badgeHtml += `<span style="background: #d97706; color: #fff; font-size: 8.5px; padding: 3px 6px; font-weight: 700; border-radius: 3px; text-transform: uppercase; display: inline-block; margin-right: 4px; margin-bottom: 4px;"><i class="fa fa-tags"></i> Best Deal</span>`;
                        }
                        if (alt.stok <= 5) {
                            badgeHtml += `<span style="background: #dc2626; color: #fff; font-size: 8.5px; padding: 3px 6px; font-weight: 700; border-radius: 3px; text-transform: uppercase; display: inline-block; margin-right: 4px; margin-bottom: 4px;"><i class="fa fa-hourglass-half"></i> Stok Tipis</span>`;
                        }

                        // Stars rendering
                        let altStarsHtml = '';
                        const roundedAltStars = Math.round(parseFloat(alt.rating_stars) || 5);
                        for (let i = 1; i <= 5; i++) {
                            if (i <= roundedAltStars) {
                                altStarsHtml += '<i class="fa fa-star" style="color: #D4A373; margin-right: 2px;"></i>';
                            } else {
                                altStarsHtml += '<i class="fa fa-star-o" style="color: #D4A373; margin-right: 2px;"></i>';
                            }
                        }

                        htmlContent += `
                            <div class="col-md-6">
                                <div class="spk-alt-card" style="display: flex; flex-direction: column; justify-content: space-between; border: 1px solid var(--border); border-radius: var(--radius-md); overflow: hidden; background: #fff; transition: all 0.3s; height: 100%;">
                                    <div style="display: flex; flex-direction: row; align-items: stretch; flex-grow: 1;">
                                        <!-- Img wrapper -->
                                        <div style="width: 35%; min-width: 110px; position: relative; overflow: hidden; background: var(--bg-creme);">
                                            <img src="${alt.foto}" alt="${alt.nama_produk}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                            <span style="position: absolute; bottom: 8px; left: 8px; background: #5D4037; color: #fff; font-size: 8px; padding: 2px 6px; font-weight: 700; z-index: 2;">#${alt.ranking}</span>
                                        </div>
                                        <!-- Info wrapper -->
                                        <div style="width: 65%; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; text-align: left; align-items: flex-start;">
                                            <div style="width: 100%;">
                                                <span style="color: var(--primary); font-size: 9px; font-weight: 700; text-transform: uppercase; margin-bottom: 2px; display: block;">${alt.match_score}% Match | Nilai: ${alt.nilai_akhir}</span>
                                                <h5 style="font-size: 16px; margin: 0 0 4px; font-family: 'DM Sans', sans-serif; font-weight: 700; color: var(--text-dark);">${alt.nama_produk}</h5>
                                                
                                                <!-- Stars rating -->
                                                <div style="display: flex; align-items: center; gap: 4px; font-size: 11px; margin-bottom: 6px;">
                                                    <span style="display: inline-flex; font-size: 9px;">${altStarsHtml}</span>
                                                    <span style="font-weight: 700; color: var(--text-dark);">${alt.rating_stars}</span>
                                                    <span style="color: var(--text-muted);">(${alt.review_count})</span>
                                                </div>

                                                <!-- Price -->
                                                <div style="font-size: 14px; font-weight: 700; color: var(--primary); margin-bottom: 8px;">${alt.harga_formatted}</div>
                                                
                                                <!-- Badges -->
                                                <div style="margin-bottom: 8px; display: flex; flex-wrap: wrap;">
                                                    ${badgeHtml}
                                                </div>

                                                <p style="font-size: 11.5px; color: var(--text-muted); margin-bottom: 12px; line-height: 1.4;">
                                                    ${alt.explanation}
                                                </p>
                                            </div>

                                            <!-- Cart and Detail Buttons -->
                                            <div style="display: flex; gap: 8px; align-items: center; width: 100%; margin-top: auto;">
                                                <div style="flex-grow: 1;">
                                                    ${altCartBtn}
                                                </div>
                                                <a href="${alt.detail_url}" style="padding: 10px 12px; border: 1px solid var(--border); background: transparent; color: var(--text-dark); font-size: 11px; font-weight: 600; border-radius: 4px; text-decoration: none; text-align: center; height: 38px; display: flex; align-items: center; justify-content: center; box-sizing: border-box;">
                                                    Detail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Collapsible GAP Detail inside alternative card -->
                                    <div style="padding: 10px 20px; border-top: 1px solid var(--border); background: var(--bg-creme);">
                                        <div onclick="toggleGapDetails(${alt.produk_id})" style="cursor: pointer; display: flex; align-items: center; justify-content: space-between; font-size: 11px; font-weight: 700; color: var(--primary);">
                                            <span>Detail GAP</span>
                                            <i class="fa fa-chevron-down" id="gap-chevron-${alt.produk_id}"></i>
                                        </div>
                                        <div id="gap-details-${alt.produk_id}" style="display: none; padding-top: 8px;">
                                            <table style="width: 100%; font-size: 10.5px; border-collapse: collapse;">
                                                <tr style="border-bottom: 1px solid var(--border); font-weight: bold;">
                                                    <td style="padding: 4px 0;">Kriteria</td>
                                                    <td class="text-center" style="padding: 4px 0;">GAP</td>
                                                    <td class="text-right" style="padding: 4px 0;">Bobot</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 4px 0;">C1: Penjualan</td>
                                                    <td class="text-center" style="padding: 4px 0;">${alt.details.c1.gap}</td>
                                                    <td class="text-right" style="padding: 4px 0;">${alt.details.c1.bobot}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 4px 0;">C2: Ukuran</td>
                                                    <td class="text-center" style="padding: 4px 0;">${alt.details.c2.gap}</td>
                                                    <td class="text-right" style="padding: 4px 0;">${alt.details.c2.bobot}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 4px 0;">C3: Harga</td>
                                                    <td class="text-center" style="padding: 4px 0;">${alt.details.c3.gap}</td>
                                                    <td class="text-right" style="padding: 4px 0;">${alt.details.c3.bobot}</td>
                                                </tr>
                                                <tr style="border-top: 1px solid var(--border); font-weight: bold; color: var(--text-dark);">
                                                    <td colspan="2" style="padding: 4px 0;">Nilai Total</td>
                                                    <td class="text-right" style="padding: 4px 0;">${alt.nilai_akhir}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    htmlContent += `
                        </div>
                    `;
                }

                htmlContent += `
                    </div>
                `;

                resultsContainer.innerHTML = htmlContent;
                updateResetButtonVisibility();
            } else {
                alert(result.message || 'Gagal menganalisis rekomendasi.');
            }
        } catch (error) {
            document.getElementById('loadingOverlay').style.display = 'none';
            console.error('Error:', error);
            alert('Terjadi kesalahan koneksi ke server.');
        }
    }
</script>


@endsection