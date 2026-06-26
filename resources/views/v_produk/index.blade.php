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
        <div class="spk-widget" style="margin-bottom: 50px; background: var(--bg-white); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-sm); overflow: hidden;">
            <!-- Header Widget -->
            <div class="spk-banner" id="spkBanner" style="background: linear-gradient(135deg, #8D6E63, #5D4037); color: #fff; padding: 24px 32px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
                <div style="display: flex; align-items: center; gap: 18px; text-align: left;">
                    <div style="font-size: 32px;"><i class="fa fa-cookie-bite"></i></div>
                    <div>
                        <h4 style="font-size: 20px; margin: 0 0 4px; color: #fff; font-family: 'Cormorant Garamond', serif; font-weight: 700; letter-spacing: 0.5px;">Asisten Cerdas Nyonya Crumb</h4>
                        <p style="font-size: 13.5px; margin: 0; opacity: 0.9;">Tentukan kriteria cookies impian Anda dan dapatkan rekomendasi terbaik secara real-time!</p>
                    </div>
                </div>
            </div>

            <!-- Form Body Preferensi -->
            <div class="spk-form-body" style="padding: 30px; background: var(--bg-white);">
                <div class="row g-3">
                    <!-- Kolom 1: Kategori -->
                    <div class="col-lg-3 col-md-6">
                        <label style="font-weight: 700; font-size: 13px; color: var(--text-dark); margin-bottom: 12px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">
                            <i class="fa fa-cookie" style="color: var(--primary); margin-right: 6px;"></i> Kategori
                        </label>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <select id="selectKategori" style="width: 100%; padding: 14px 16px; border: 2px solid var(--border); border-radius: var(--radius-md); background: var(--bg-white); color: var(--text-dark); font-weight: 700; font-size: 13.5px; outline: none; cursor: pointer; transition: all 0.3s; height: 58px; box-sizing: border-box; font-family: 'DM Sans', sans-serif;">
                                <option value="">Semua Kategori</option>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                            <div style="font-size: 11px; color: var(--text-muted); text-align: center; padding-top: 10px; line-height: 1.4;">
                                Tampilkan semua rasa atau pilih kategori tertentu kesukaan Anda.
                            </div>
                        </div>
                    </div>

                    <!-- Kolom 2: Popularitas -->
                    <div class="col-lg-3 col-md-6">
                        <label style="font-weight: 700; font-size: 13px; color: var(--text-dark); margin-bottom: 12px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">
                            <i class="fa fa-fire" style="color: var(--primary); margin-right: 6px;"></i> Popularitas
                        </label>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label class="choice-card checked-style" id="label-penjualan-bestseller" onclick="selectPreference('penjualan', 'bestseller')" style="padding: 12px 10px; margin: 0; min-height: 58px; display: flex; flex-direction: column; justify-content: center; align-items: center; box-sizing: border-box;">
                                <input type="radio" name="penjualan" value="bestseller" checked style="display: none;">
                                <div style="font-weight: 700; font-size: 13.5px; margin-bottom: 2px;">Terlaris (Bestseller)</div>
                                <div style="font-size: 10.5px; color: var(--text-muted);">Sangat disukai banyak orang</div>
                            </label>
                            <label class="choice-card" id="label-penjualan-biasa" onclick="selectPreference('penjualan', 'biasa')" style="padding: 12px 10px; margin: 0; min-height: 58px; display: flex; flex-direction: column; justify-content: center; align-items: center; box-sizing: border-box;">
                                <input type="radio" name="penjualan" value="biasa" style="display: none;">
                                <div style="font-weight: 700; font-size: 13.5px; margin-bottom: 2px;">Koleksi Lainnya</div>
                                <div style="font-size: 10.5px; color: var(--text-muted);">Cari varian rasa yang unik</div>
                            </label>
                        </div>
                    </div>

                    <!-- Kolom 3: Ukuran Cookies -->
                    <div class="col-lg-3 col-md-6">
                        <label style="font-weight: 700; font-size: 13px; color: var(--text-dark); margin-bottom: 12px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">
                            <i class="fa fa-box-open" style="color: var(--primary); margin-right: 6px;"></i> Ukuran
                        </label>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label class="choice-card checked-style" id="label-ukuran-besar" onclick="selectPreference('ukuran', 'besar')" style="padding: 12px 10px; margin: 0; min-height: 58px; display: flex; flex-direction: column; justify-content: center; align-items: center; box-sizing: border-box;">
                                <input type="radio" name="ukuran" value="besar" checked style="display: none;">
                                <div style="font-weight: 700; font-size: 13.5px; margin-bottom: 2px;">Porsi Besar (>50g)</div>
                                <div style="font-size: 10.5px; color: var(--text-muted);">Satu gigitan besar yang puas</div>
                            </label>
                            <label class="choice-card" id="label-ukuran-mini" onclick="selectPreference('ukuran', 'mini')" style="padding: 12px 10px; margin: 0; min-height: 58px; display: flex; flex-direction: column; justify-content: center; align-items: center; box-sizing: border-box;">
                                <input type="radio" name="ukuran" value="mini" style="display: none;">
                                <div style="font-weight: 700; font-size: 13.5px; margin-bottom: 2px;">Porsi Mini (≤50g)</div>
                                <div style="font-size: 10.5px; color: var(--text-muted);">Imut & pas untuk sekali makan</div>
                            </label>
                        </div>
                    </div>

                    <!-- Kolom 4: Kisaran Harga -->
                    <div class="col-lg-3 col-md-6">
                        <label style="font-weight: 700; font-size: 13px; color: var(--text-dark); margin-bottom: 12px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">
                            <i class="fa fa-tags" style="color: var(--primary); margin-right: 6px;"></i> Kisaran Harga
                        </label>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label class="choice-card checked-style" id="label-harga-terendah" onclick="selectPreference('harga', 'terendah')" style="padding: 12px 10px; margin: 0; min-height: 58px; display: flex; flex-direction: column; justify-content: center; align-items: center; box-sizing: border-box;">
                                <input type="radio" name="harga" value="terendah" checked style="display: none;">
                                <div style="font-weight: 700; font-size: 13.5px; margin-bottom: 2px;">Harga Bersahabat</div>
                                <div style="font-size: 10.5px; color: var(--text-muted);">Lebih hemat & terjangkau</div>
                            </label>
                            <label class="choice-card" id="label-harga-tertinggi" onclick="selectPreference('harga', 'tertinggi')" style="padding: 12px 10px; margin: 0; min-height: 58px; display: flex; flex-direction: column; justify-content: center; align-items: center; box-sizing: border-box;">
                                <input type="radio" name="harga" value="tertinggi" style="display: none;">
                                <div style="font-weight: 700; font-size: 13.5px; margin-bottom: 2px;">Rasa Premium</div>
                                <div style="font-size: 10.5px; color: var(--text-muted);">Bahan eksklusif rasa mewah</div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 30px; border-top: 1px solid var(--border); padding-top: 20px;">
                    <button type="button" id="btnResetQuiz" onclick="resetQuiz()" style="display: none; background: #e0e0e0; border: 1px solid #ccc; color: #333; padding: 10px 24px; font-weight: 700; font-size: 12px; cursor: pointer; border-radius: 4px; height: 45px; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.3s;" title="Reset Rekomendasi">
                        <i class="fa fa-sync"></i> Reset
                    </button>
                    <button type="button" onclick="submitQuiz()" style="background: var(--primary); border: 1px solid rgba(0,0,0,0.1); color: #fff; padding: 12px 32px; font-weight: 700; font-size: 12px; cursor: pointer; border-radius: 4px; height: 45px; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: var(--shadow-sm); text-transform: uppercase; letter-spacing: 0.5px; transition: all 0.3s;">
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

    function selectPreference(kriteria, value) {
        // Cari element input radio dan set checked
        const input = document.querySelector(`input[name="${kriteria}"][value="${value}"]`);
        if (input) {
            input.checked = true;
        }
        
        // Hapus class checked-style dari card kriteria yang sama
        const cards = document.querySelectorAll(`[id^="label-${kriteria}-"]`);
        cards.forEach(card => card.classList.remove('checked-style'));
        
        // Tambahkan class checked-style ke card yang dipilih
        const selectedCard = document.getElementById(`label-${kriteria}-${value}`);
        if (selectedCard) {
            selectedCard.classList.add('checked-style');
        }
    }

    function resetQuiz() {
        // Reset pilihan form ke default
        document.getElementById('selectKategori').value = "";
        
        selectPreference('penjualan', 'bestseller');
        selectPreference('ukuran', 'besar');
        selectPreference('harga', 'terendah');

        document.getElementById('spkResultsContainer').style.display = 'none';
        document.getElementById('spkResultsContainer').innerHTML = '';
        document.getElementById('spkPlaceholder').style.display = 'block';
        document.getElementById('defaultProductsContainer').style.display = 'block';
        
        updateResetButtonVisibility();
    }

    async function submitQuiz() {
        // Tampilkan loading overlay
        document.getElementById('loadingOverlay').style.display = 'flex';

        // Dapatkan semua nilai preferensi terpilih
        const kategori_id = document.getElementById('selectKategori').value;
        const penjualan = document.querySelector('input[name="penjualan"]:checked')?.value || 'bestseller';
        const ukuran = document.querySelector('input[name="ukuran"]:checked')?.value || 'besar';
        const harga = document.querySelector('input[name="harga"]:checked')?.value || 'terendah';

        try {
            const response = await fetch("{{ route('produk.rekomendasi') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": window.csrfToken
                },
                body: JSON.stringify({
                    kategori_id: kategori_id,
                    penjualan: penjualan,
                    ukuran: ukuran,
                    harga: harga
                })
            });

            const result = await response.json();
            
            // Sembunyikan loading overlay
            document.getElementById('loadingOverlay').style.display = 'none';

            if (result.success && result.data.length > 0) {
                // Sembunyikan daftar default & placeholder
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