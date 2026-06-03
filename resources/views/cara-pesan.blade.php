@extends('v_layouts.app')

@section('content')
<style>
    /* Custom styles for Cara Pesan that are not in app.blade.php */
    .page-title {
        text-align: center;
        padding: 60px 0 30px;
    }

    .page-title h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 48px;
        color: var(--primary);
        margin-bottom: 15px;
    }

    .page-title p {
        color: var(--text-muted);
        max-width: 600px;
        margin: 0 auto;
    }

    .garis {
        width: 80px;
        height: 2px;
        background: var(--primary);
        margin: 20px auto;
        border-radius: 10px;
    }

    .steps-container {
        max-width: 900px;
        margin: 0 auto;
        background: var(--bg-white);
        border-radius: var(--radius-md);
        padding: 40px;
        box-shadow: var(--shadow-md);
        margin-bottom: 50px;
        border: 1px solid var(--border);
    }

    .step-item {
        display: flex;
        gap: 25px;
        margin-bottom: 45px;
        padding-bottom: 35px;
        border-bottom: 1px solid var(--border);
    }

    .step-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .step-icon {
        width: 60px;
        height: 60px;
        background: var(--bg-creme);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid var(--border);
    }

    .step-icon i {
        font-size: 24px;
        color: var(--primary);
    }

    .step-content h3 {
        font-size: 24px;
        color: var(--text-dark);
        margin-bottom: 10px;
        font-family: 'Cormorant Garamond', serif;
    }

    .step-content p {
        color: var(--text-muted);
        line-height: 1.7;
        margin-bottom: 10px;
        font-size: 15px;
    }

    .badge-list {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .badge-custom {
        background: var(--bg-creme);
        color: var(--primary-dark);
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        letter-spacing: 0.5px;
        border: 1px solid var(--border);
    }

    .info-box {
        background: var(--bg-creme);
        border-radius: var(--radius-md);
        padding: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 30px;
        border: 1px solid var(--border);
    }

    .info-wa {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .info-wa i {
        font-size: 28px;
        color: #25D366;
    }

    .btn-nc-back {
        background: var(--bg-white);
        border: 1px solid var(--primary);
        padding: 12px 28px;
        border-radius: 0;
        text-decoration: none;
        color: var(--primary);
        font-weight: 600;
        font-size: 11px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: 0.3s;
    }

    .btn-nc-back:hover {
        background: var(--primary);
        color: white;
    }

    .tips-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        margin: 50px 0;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .tip-card {
        background: var(--bg-white);
        padding: 30px;
        text-align: center;
        border-radius: var(--radius-md);
        border: 1px solid var(--border);
        transition: 0.3s;
        box-shadow: var(--shadow-sm);
    }

    .tip-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
    }

    .tip-card i {
        font-size: 32px;
        color: var(--primary);
        margin-bottom: 15px;
    }

    .tip-card h4 {
        font-size: 18px;
        margin-bottom: 10px;
        font-family: 'DM Sans', sans-serif;
    }

    .tip-card p {
        font-size: 14px;
        color: var(--text-muted);
        line-height: 1.6;
    }

    @media (max-width: 768px) {
        .steps-container { padding: 25px; }
        .step-item { flex-direction: column; align-items: flex-start; gap: 15px; }
        .tips-grid { grid-template-columns: 1fr; }
        .info-box { flex-direction: column; text-align: center; }
        .info-wa { justify-content: center; width: 100%; }
    }
</style>

<div class="container section-padding">
    <div class="page-title reveal">
        <h1>Cara <span style="font-style: italic;">Pemesanan</span></h1>
        <div class="garis"></div>
        <p>Mudah, Cepat, dan Aman! Ikuti langkah-langkah berikut untuk menikmati kelezatan Nyonya Crumb.</p>
    </div>
    
    <div class="steps-container reveal">
        <!-- STEP 1 -->
        <div class="step-item">
            <div class="step-icon">
                <i class="fa fa-search"></i>
            </div>
            <div class="step-content">
                <h3>1. Jelajahi Produk</h3>
                <p>Kunjungi halaman <strong>Produk</strong> dan temukan berbagai varian kue kering homemade premium favorit Anda yang dibuat dengan bahan artisan terbaik.</p>
            </div>
        </div>
        
        <!-- STEP 2 -->
        <div class="step-item">
            <div class="step-icon">
                <i class="fa fa-mouse-pointer"></i>
            </div>
            <div class="step-content">
                <h3>2. Pilih & Klik Pesan</h3>
                <p>Klik produk yang Anda inginkan untuk melihat detail, lalu tekan tombol <strong>"Tambah ke Keranjang"</strong> untuk memasukkan kue pilihan Anda.</p>
            </div>
        </div>
        
        <!-- STEP 3 -->
        <div class="step-item">
            <div class="step-icon">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="step-content">
                <h3>3. Review Keranjang</h3>
                <p>Klik ikon <strong>Keranjang</strong> di pojok kanan atas. Periksa kembali pesanan, jumlah, dan total harga sebelum melanjutkan ke pembayaran.</p>
            </div>
        </div>
        
        <!-- STEP 4 -->
        <div class="step-item">
            <div class="step-icon">
                <i class="fa fa-credit-card"></i>
            </div>
            <div class="step-content">
                <h3>4. Pilih Metode Pembayaran</h3>
                <p>Lanjutkan ke checkout dan pilih metode pembayaran yang paling nyaman bagi Anda: <strong>Transfer Bank, E-Wallet, atau COD</strong>.</p>
            </div>
        </div>
        
        <!-- STEP 5 -->
        <div class="step-item">
            <div class="step-icon">
                <i class="fa fa-truck"></i>
            </div>
            <div class="step-content">
                <h3>5. Pesanan Dikirim</h3>
                <p>Setelah pembayaran dikonfirmasi, pesanan akan segera diproses dan dikirim ke alamat Anda dengan pengemasan yang aman dan higienis.</p>
                <div class="badge-list">
                    <span class="badge-custom"><i class="fa fa-clock-o"></i> Estimasi: 2-4 hari (Jabodetabek)</span>
                    <span class="badge-custom">3-7 hari (Luar kota)</span>
                </div>
            </div>
        </div>
        
        <!-- INFO BANTUAN -->
        <div class="info-box">
            <div class="info-wa">
                <i class="fa fa-whatsapp"></i>
                <div>
                    <strong style="font-family: 'DM Sans', sans-serif;">Butuh bantuan?</strong><br>
                    <small style="color: var(--text-muted);">Hubungi CS: +62 812-3456-7890 (WhatsApp)</small>
                </div>
            </div>
            <a href="{{ route('beranda') }}" class="btn-nc-back">← Kembali ke Beranda</a>
        </div>
    </div>
    
    <div class="tips-grid reveal">
        <div class="tip-card">
            <i class="fa fa-shield"></i>
            <h4>Garansi Kepuasan</h4>
            <p>Jika produk bermasalah atau rusak saat pengiriman, kami siap mengganti dengan produk baru demi kepuasan Anda.</p>
        </div>
        <div class="tip-card">
            <i class="fa fa-leaf"></i>
            <h4>Homemade & Higienis</h4>
            <p>Setiap gigitan diproduksi dengan standar kualitas premium, tanpa pengawet, dan diproses secara higienis.</p>
        </div>
    </div>
</div>
@endsection