@extends('v_layouts.app') 

@section('content') 
<div class="payment-section">
    <div class="container">
        <div class="d-flex align-items-center mb-4 reveal" style="gap: 20px; flex-wrap: wrap;">
            <a href="{{ route('order.revert_checkout', ['order_id' => $order->id]) }}" style="text-decoration: none; color: var(--text-dark); border: 1px solid var(--border); padding: 10px 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; background: var(--bg-white); transition: 0.3s; display: inline-block;">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
            <h1 class="section-title m-0" style="margin-bottom: 0;">Konfirmasi <i>Pembayaran</i></h1>
        </div>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="payment-card reveal">
                    <span class="card-subtitle">Detail Pesanan</span>
                    
                    @if(session()->has('success'))
                        <div class="alert alert-success mb-4" style="border-radius:0; border:none; background:#E8F5E9; color:#2E7D32;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="product-list">
                        @php 
                            $totalHarga = 0; 
                            $totalBerat = 0; 
                        @endphp 
                        @foreach($order->orderItems as $item)
                            @php 
                                $totalHarga += $item->harga * $item->quantity; 
                                $totalBerat += $item->produk->berat * $item->quantity; 
                            @endphp 
                            <div class="product-item">
                                <div class="product-img">
                                    <img src="{{ asset('storage/img-produk/' . $item->produk->foto) }}" alt="{{ $item->produk->nama_produk }}">
                                </div>
                                <div class="product-info">
                                    <h5>{{ $item->produk->nama_produk }}</h5>
                                    @if($item->size)
                                        <p style="color: var(--primary); font-weight: 600; text-transform: uppercase; font-size: 11px; margin-bottom: 2px;">Ukuran: {{ $item->size }}</p>
                                    @endif
                                    <p>Qty: {{ $item->quantity }} &bull; Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                </div>
                                <div style="margin-left: auto; font-weight: 600;">
                                    Rp {{ number_format($item->harga * $item->quantity, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="payment-card reveal" style="height: auto;">
                    <span class="card-subtitle">Ringkasan</span>
                    
                    <div class="summary-row" style="margin-top: 20px;">
                        <span>Total Harga</span>
                        <span>Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Biaya Pengiriman</span>
                        <span>Rp {{ number_format($order->biaya_ongkir, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="summary-total">
                        <span>Total Bayar</span>
                        <span>Rp {{ number_format($totalHarga + $order->biaya_ongkir, 0, ',', '.') }}</span>
                    </div>

                    <button class="btn-pay-nc" id="pay-button">
                        Bayar Sekarang
                    </button>
                    
                    <div style="margin-top: 20px; text-align: center;">
                        <img src="https://midtrans.com/assets/img/midtrans-logo-new.svg" alt="Midtrans" style="height: 20px; opacity: 0.5;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .payment-section {
        padding: 160px 0 100px;
        min-height: 80vh;
        background: var(--bg-creme);
    }

    .section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 32px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 30px;
    }

    .payment-card {
        background: var(--bg-white);
        border: 1px solid var(--border);
        padding: 40px;
        height: 100%;
    }

    .card-subtitle {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 10px;
        display: block;
    }

    .product-item {
        display: flex;
        align-items: center;
        padding: 20px 0;
        border-bottom: 1px solid var(--border-light);
    }

    .product-img {
        width: 80px;
        height: 80px;
        background: var(--bg-creme);
        border: 1px solid var(--border);
        overflow: hidden;
        margin-right: 20px;
    }

    .product-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-info h5 {
        font-size: 16px;
        font-weight: 600;
        margin: 0 0 5px;
    }

    .product-info p {
        font-size: 13px;
        color: var(--text-muted);
        margin: 0;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .summary-total {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        font-size: 18px;
        font-weight: 600;
        color: var(--primary);
    }

    .btn-pay-nc {
        width: 100%;
        padding: 16px;
        background: var(--text-dark);
        color: white;
        border: none;
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        margin-top: 30px;
    }

    .btn-pay-nc:hover {
        background: var(--primary);
    }

    @media (max-width: 768px) {
        .payment-section { padding: 180px 0 60px; }
        .payment-card { padding: 25px; margin-bottom: 20px; }
    }
</style>
@endpush
@endsection

@section('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                console.log('Success:', result);
                window.location.href = "{{ route('order.complete', ['order_id' => $order->id]) }}";
            },
            onPending: function(result) {
                console.log('Pending:', result);
                window.location.href = "{{ route('order.history') }}";
            },
            onError: function(result) {
                console.log('Error:', result);
                alert("Payment failed. Redirecting to cart.");
                window.location.href = "{{ route('order.revert_checkout', ['order_id' => $order->id]) }}";
            },
            onClose: function() {
                alert('Transaction canceled. Redirecting to cart.');
                window.location.href = "{{ route('order.revert_checkout', ['order_id' => $order->id]) }}";
            }
        });
    });
</script>
@endsection
