@extends('v_layouts.app')

@section('content')
<style>
    .order-detail-section {
        padding: 160px 0 100px;
        min-height: 80vh;
        background: var(--bg-creme);
    }

    .detail-card {
        background: var(--bg-white);
        border: 1px solid var(--border);
        padding: 40px;
        margin-bottom: 30px;
    }

    .section-title-nc {
        font-family: 'Cormorant Garamond', serif;
        font-size: 32px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 25px;
        border-bottom: 1px solid var(--border);
        padding-bottom: 10px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 40px;
    }

    @media (max-width: 768px) {
        .info-grid { grid-template-columns: 1fr; }
    }

    .info-box h4 {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 15px;
    }

    .info-box p {
        font-size: 14px;
        margin-bottom: 8px;
        color: var(--text-dark);
    }

    .badge-nc {
        padding: 4px 12px;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-paid { background: #E8F5E9; color: #2E7D32; }
    .badge-shipped { background: #FFF3E0; color: #E65100; }
    .badge-completed { background: #E3F2FD; color: #1565C0; }
    .badge-default { background: var(--bg-creme); color: var(--text-muted); }

    .table-nc {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table-nc th {
        text-align: left;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
        padding: 15px 10px;
        border-bottom: 1px solid var(--border);
    }

    .table-nc td {
        padding: 20px 10px;
        border-bottom: 1px solid var(--border-light);
        font-size: 14px;
    }

    .btn-review-nc {
        background: transparent;
        border: 1px solid var(--border);
        padding: 8px 16px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        margin-top: 10px;
    }

    .btn-review-nc:hover {
        background: var(--text-dark);
        color: white;
    }

    .review-form-nc {
        background: var(--bg-creme);
        padding: 25px;
        margin-top: 15px;
        border: 1px solid var(--border);
        display: none;
    }

    .review-form-nc.active {
        display: block;
    }

    .star-rating-nc {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 10px;
        margin-bottom: 15px;
    }

    .star-rating-nc input { display: none; }
    .star-rating-nc label {
        font-size: 20px;
        color: #DDD;
        cursor: pointer;
    }

    .star-rating-nc input:checked ~ label,
    .star-rating-nc label:hover,
    .star-rating-nc label:hover ~ label {
        color: var(--primary);
    }

    .textarea-nc {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--border);
        background: white;
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        margin-bottom: 15px;
        resize: vertical;
    }

    .btn-submit-nc {
        background: var(--text-dark);
        color: white;
        border: none;
        padding: 12px 25px;
        font-size: 11px;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-submit-nc:hover {
        background: var(--primary);
    }
</style>

<div class="order-detail-section">
    <div class="container">
        <div class="detail-card reveal">
            <h1 class="section-title-nc">Pesanan #{{ $order->id }}</h1>
            
            @if(session()->has('success'))
                <div class="alert alert-success mb-4" style="border-radius:0; border:none; background:#E8F5E9; color:#2E7D32; font-size:14px;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="info-grid">
                <div class="info-box">
                    <h4>Informasi Pengiriman</h4>
                    <p><strong>Penerima:</strong> {{ $order->customer && $order->customer->user ? $order->customer->user->nama : 'Pelanggan' }}</p>
                    <p><strong>Alamat:</strong> {{ $order->alamat }}</p>
                    <p><strong>Kode Pos:</strong> {{ $order->pos }}</p>
                    @if($order->ekspedisi)
                        <p><strong>Ekspedisi:</strong> {{ $order->ekspedisi }}</p>
                    @endif
                </div>
                <div class="info-box">
                    <h4>Status Pesanan</h4>
                    <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                    <p><strong>Status:</strong> 
                        @switch($order->status)
                            @case('Paid') <span class="badge-nc badge-paid">Dibayar</span> @break
                            @case('Kirim') <span class="badge-nc badge-shipped">Dikirim</span> @break
                            @case('Selesai') <span class="badge-nc badge-completed">Selesai</span> @break
                            @default <span class="badge-nc badge-default">{{ $order->status }}</span>
                        @endswitch
                    </p>
                    @if($order->noresi)
                        <p><strong>No. Resi:</strong><br> {!! nl2br(e($order->noresi)) !!}</p>
                    @endif
                </div>
            </div>

            <h4 style="font-size: 12px; text-transform: uppercase; letter-spacing: 2px; color: var(--primary); font-weight: 600; margin-bottom: 20px;">Daftar Produk</h4>
            
            <div class="table-responsive">
                <table class="table-nc">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th></th>
                            <th>Harga</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td style="width: 80px;">
                                    <img src="{{ asset('storage/img-produk/' . ($item->produk->foto ?? 'default.jpg')) }}" style="width: 60px; height: 60px; object-fit: cover; border: 1px solid var(--border);">
                                </td>
                                <td>
                                    <strong>{{ $item->produk->nama_produk }}</strong>
                                    @if($item->size)
                                        <br><small style="color: var(--primary); text-transform: uppercase; letter-spacing: 1px; font-size: 10px;">Ukuran: {{ $item->size }}</small>
                                    @endif

                                    @if(in_array($order->status, ['Selesai', 'Paid', 'Kirim']))
                                        <div class="mt-2">
                                            <button class="btn-review-nc" onclick="toggleReview('{{ $item->id }}')">
                                                Tulis Ulasan
                                            </button>
                                            <div id="review-{{ $item->id }}" class="review-form-nc">
                                                <form action="{{ route('produk.review.store', $item->produk->id) }}" method="POST">
                                                    @csrf
                                                    <div class="star-rating-nc">
                                                        <input type="radio" id="star5-{{ $item->id }}" name="rating" value="5" required /><label for="star5-{{ $item->id }}"><i class="fa fa-star"></i></label>
                                                        <input type="radio" id="star4-{{ $item->id }}" name="rating" value="4" /><label for="star4-{{ $item->id }}"><i class="fa fa-star"></i></label>
                                                        <input type="radio" id="star3-{{ $item->id }}" name="rating" value="3" /><label for="star3-{{ $item->id }}"><i class="fa fa-star"></i></label>
                                                        <input type="radio" id="star2-{{ $item->id }}" name="rating" value="2" /><label for="star2-{{ $item->id }}"><i class="fa fa-star"></i></label>
                                                        <input type="radio" id="star1-{{ $item->id }}" name="rating" value="1" /><label for="star1-{{ $item->id }}"><i class="fa fa-star"></i></label>
                                                    </div>
                                                    <textarea name="comment" class="textarea-nc" rows="3" placeholder="Bagaimana pendapat Anda?" required></textarea>
                                                    <button type="submit" class="btn-submit-nc">Kirim Ulasan</button>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-right" style="font-weight: 600;">Rp {{ number_format($item->harga * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right" style="padding-top: 30px;">Subtotal</td>
                            <td class="text-right" style="padding-top: 30px;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        @if($order->biaya_ongkir > 0)
                        <tr>
                            <td colspan="4" class="text-right">Biaya Pengiriman</td>
                            <td class="text-right">Rp {{ number_format($order->biaya_ongkir, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="4" class="text-right" style="font-weight: 600; font-size: 18px; color: var(--primary);">Total Pembayaran</td>
                            <td class="text-right" style="font-weight: 600; font-size: 18px; color: var(--primary);">Rp {{ number_format($order->total_harga + $order->biaya_ongkir, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div style="text-align: center; margin-top: 50px;">
                <a href="{{ route('order.history') }}" class="btn-review-nc" style="text-decoration: none; display: inline-block;">
                    Kembali ke Riwayat
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleReview(id) {
        const el = document.getElementById('review-' + id);
        el.classList.toggle('active');
    }
</script>
@endsection
