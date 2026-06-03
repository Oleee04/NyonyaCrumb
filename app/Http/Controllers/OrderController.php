<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Snap;
use Midtrans\Config;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer.user')->get();
        return view('backend.v_pesanan.index', compact('orders'));
    }

    public function statusProses()
    {
        $orders = Order::with(['customer.user'])
            ->whereIn('status', ['Paid', 'Kirim'])
            ->orderByDesc('id')
            ->get();

        return view('backend.v_pesanan.proses', [
            'judul' => 'Pesanan',
            'subJudul' => 'Pesanan Proses',
            'index' => $orders
        ]);
    }

    public function statusSelesai()
    {
        $orders = Order::with(['customer.user'])
            ->where('status', 'Selesai')
            ->orderByDesc('id')
            ->get();

        return view('backend.v_pesanan.selesai', [
            'judul' => 'Data Transaksi',
            'subJudul' => 'Pesanan Selesai',
            'index' => $orders
        ]);
    }

    public function statusDetail($id)
    {
        $order = Order::with([
            'orderItems.produk.kategori',
            'customer.user'
        ])->findOrFail($id);

        return view('v_order.detail', [
            'judul' => 'Data Transaksi',
            'subJudul' => 'Detail Pesanan',
            'order' => $order
        ]);
    }

    public function statusDetailAdmin($id)
    {
        $order = Order::with([
            'orderItems.produk.kategori',
            'customer.user'
        ])->findOrFail($id);

        return view('backend.v_pesanan.detail', [
            'judul' => 'Manajemen Pesanan',
            'subJudul' => 'Detail Transaksi',
            'order' => $order
        ]);
    }

    public function statusUpdate(Request $request, $id)
    {
        $request->validate([
            'noresi' => 'nullable|string',
            'status' => 'required|string',
            'hp' => 'nullable|string|max:15',
        ]);

        \Illuminate\Support\Facades\Log::info("Updating order $id", $request->all());

        $order = Order::findOrFail($id);
        
        \Illuminate\Support\Facades\Log::info("Before update:", $order->toArray());

        $order->update([
            'noresi' => $request->noresi,
            'status' => $request->status,
            'hp' => $request->hp,
        ]);

        \Illuminate\Support\Facades\Log::info("After update:", $order->fresh()->toArray());

        return redirect()->back()->with('success', 'Pesanan berhasil diupdate');
    }

    public function addToCart(Request $request, $id)
    {
        try {
            // Verify user is authenticated
            if (!Auth::check()) {
                return redirect()->route('beranda')->with('error', 'Silakan login terlebih dahulu.');
            }

            // Ambil data dari form
            $size          = strtoupper($request->input('size', 'BIG'));
            $qty           = max(1, (int) $request->input('quantity', 1));
            $variantPrice  = (float) $request->input('variant_price', 0);

            // Validasi ukuran
            if (!in_array($size, ['BIG', 'SMALL'])) {
                return redirect()->back()->with('error', 'Ukuran produk tidak valid.');
            }

            // Auto-create customer record if it doesn't exist
            $customer = Customer::firstOrCreate(
                ['user_id' => Auth::id()],
                ['alamat' => '', 'pos' => '']
            );

            $produk = Produk::find($id);

            if (!$produk) {
                Log::warning('Product not found: ' . $id);
                return redirect()->back()->with('error', 'Produk tidak ditemukan.');
            }

            // Tentukan harga berdasarkan ukuran yang dipilih
            if ($size === 'SMALL') {
                if ($produk->harga == 15000) {
                    $harga = 10000;
                } elseif ($produk->harga == 12000) {
                    $harga = 5000;
                } else {
                    $harga = round($produk->harga * 0.42); // Fallback
                }
            } else {
                $harga = $produk->harga; // BIG
            }

            // Cek stok
            if ($produk->stok < $qty) {
                return redirect()->back()->with('error', 'Stok produk tidak mencukupi. Tersisa: ' . $produk->stok);
            }

            $order = Order::firstOrCreate(
                ['customer_id' => $customer->id, 'status' => 'pending'],
                ['total_harga' => 0]
            );

            // Cari item yang sama (produk + ukuran yang sama)
            $item = OrderItem::where('order_id', $order->id)
                ->where('produk_id', $produk->id)
                ->where('size', $size)
                ->first();

            if ($item) {
                // Item sudah ada, tambah quantity
                $newQty = $item->quantity + $qty;
                if ($newQty > $produk->stok) {
                    return redirect()->back()->with('error', 'Jumlah produk melebihi stok yang tersedia (maksimal: ' . $produk->stok . ')');
                }
                $tambahan = $qty * $harga;
                $item->update(['quantity' => $newQty]);
                $order->increment('total_harga', $tambahan);
            } else {
                // Item baru
                OrderItem::create([
                    'order_id'  => $order->id,
                    'produk_id' => $produk->id,
                    'quantity'  => $qty,
                    'harga'     => $harga,
                    'size'      => $size,
                ]);
                $order->increment('total_harga', $qty * $harga);
            }

            Log::info("Product {$produk->id} (size: {$size}, qty: {$qty}) added to cart for customer {$customer->id}");
            return redirect()->route('v_order.cart')->with('success', "Produk berhasil ditambahkan ke keranjang (Ukuran: {$size})");

        } catch (\Throwable $e) {
            Log::error('Error adding to cart: ' . $e->getMessage(), [
                'exception'  => $e,
                'user_id'    => Auth::id(),
                'product_id' => $id
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan produk ke keranjang. Silakan coba lagi.');
        }
    }

    public function viewCart()
    {
        $order = null;
        
        if (Auth::check()) {
            $customer = Customer::firstOrCreate(
                ['user_id' => Auth::id()],
                ['alamat' => '', 'pos' => '']
            );
            $order = Order::with('orderItems.produk')
                ->where('customer_id', $customer->id)
                ->where('status', 'pending')
                ->first();
        }

        return view('v_order.cart', compact('order'));
    }

    public function updateCart(Request $request, $id)
    {
        $customer = Customer::where('user_id', Auth::id())->firstOrFail();
        $order = Order::where('customer_id', $customer->id)->where('status', 'pending')->first();

        if ($order) {
            $item = $order->orderItems()->where('id', $id)->first();
            if ($item) {
                $qty = $request->input('quantity');
                
                if ($qty < 1) {
                    return redirect()->route('v_order.cart')->with('error', 'Jumlah produk minimal 1');
                }
                
                if ($qty > $item->produk->stok) {
                    return redirect()->route('v_order.cart')->with('error', 'Jumlah produk melebihi stok yang tersedia (maksimal: ' . $item->produk->stok . ')');
                }

                $order->total_harga -= $item->harga * $item->quantity;
                $item->update(['quantity' => $qty]);
                $order->total_harga += $item->harga * $qty;
                $order->save();
            }
        }

        return redirect()->route('v_order.cart')->with('success', 'Jumlah produk berhasil diperbarui');
    }

    public function removeFromCart($id)
    {
        $customer = Customer::where('user_id', Auth::id())->firstOrFail();
        $order = Order::where('customer_id', $customer->id)->where('status', 'pending')->first();

        if ($order) {
            // Find by order item ID
            $item = OrderItem::where('order_id', $order->id)->where('id', $id)->first();
            if ($item) {
                $order->total_harga -= $item->harga * $item->quantity;
                $item->delete();

                if ($order->orderItems()->count() == 0) {
                    $order->delete();
                } else {
                    $order->save();
                }
            }
        }

        return redirect()->route('v_order.cart')->with('success', 'Produk berhasil dihapus dari keranjang');
    }

    public function checkout(Request $request) 
    {
        // Validate shipping information
        $request->validate([
            'alamat' => 'required|string',
            'pos' => 'required|string',
            'hp' => 'required|string|max:15',
            'biaya_ongkir' => 'required|numeric|min:0',
        ]);

        $customer = Customer::where('user_id', Auth::id())->first();

        if (!$customer) {
            return redirect()->route('v_order.cart')->with('error', 'Data customer tidak ditemukan.');
        }

        $order = Order::where('customer_id', $customer->id)
                      ->where('status', 'pending')
                      ->first();

        if (!$order) {
            return redirect()->route('v_order.cart')->with('error', 'Tidak ada pesanan yang pending.');
        }

        // Check stock for all items
        foreach ($order->orderItems as $item) {
            $produk = $item->produk;
            
            if ($produk->stok < $item->quantity) {
                return redirect()->route('v_order.cart')->with('error', 'Stok produk ' . $produk->nama_produk . ' tidak mencukupi (tersisa: ' . $produk->stok . ').');
            }
        }

        // Update order with shipping information
        $order->update([
            'alamat' => $request->alamat,
            'pos' => $request->pos,
            'hp' => $request->hp,
            'biaya_ongkir' => $request->biaya_ongkir,
        ]);

        // Redirect to payment selection
        return redirect()->route('order.selectpayment', ['order_id' => $order->id])
                         ->with('success', 'Checkout berhasil. Silakan pilih metode pembayaran.');
    }

    public function history()
    {
        $customer = Customer::where('user_id', Auth::id())->first();

        if (!$customer) {
            return view('v_order.history', ['orders' => collect()]);
        }

        $statuses = ['Paid', 'Kirim', 'Selesai'];

        $orders = Order::with(['customer.user', 'orderItems.produk'])
            ->where('customer_id', $customer->id)
            ->whereIn('status', $statuses)
            ->orderBy('id', 'desc')
            ->get();

        return view('v_order.history', compact('orders'));
    }

    public function selectPayment($order_id)
    {
        $user     = Auth::user();
        $customer = Customer::where('user_id', $user->id)->firstOrFail();
        $order    = Order::with('orderItems.produk')->where('id', $order_id)->firstOrFail();

        if ($order->status !== 'pending') {
            return redirect()->route('order.history')->with('error', 'Pesanan tidak valid atau sudah diproses.');
        }

        // Validasi stok sebelum bayar
        foreach ($order->orderItems as $item) {
            $produk = $item->produk;
            if ($produk->stok < $item->quantity) {
                return redirect()->route('v_order.cart')
                    ->with('error', 'Stok produk ' . $produk->nama_produk . ' tidak mencukupi (tersisa: ' . $produk->stok . ').');
            }
        }

        // Kurangi stok SEKARANG (untuk lingkungan lokal/sandbox yang
        // tidak bisa menerima webhook callback dari Midtrans).
        // Flag stock_deducted mencegah pengurangan ganda jika callback tetap masuk.
        if (!$order->stock_deducted) {
            $this->deductStock($order);
            $order->stock_deducted = true;
        }

        // Tandai order sebagai Paid
        $order->status = 'Paid';
        $order->save();

        // Setup Midtrans
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized  = true;
        Config::$is3ds        = true;

        $grossAmount = $order->total_harga + ($order->biaya_ongkir ?? 0);

        $params = [
            'transaction_details' => [
                'order_id'     => $order->id . '-' . time(),
                'gross_amount' => (int) $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $user->nama,
                'email'      => $user->email,
                'phone'      => $order->hp ?? $user->hp,
                'billing_address' => [
                    'address'     => $order->alamat,
                    'postal_code' => $order->pos,
                ],
            ],
            'item_details' => $this->getItemDetails($order),
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return view('v_order.selectpayment', [
                'order'     => $order,
                'snapToken' => $snapToken,
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            // Kembalikan stok jika gagal buat token
            $this->restoreStock($order);
            $order->stock_deducted = false;
            $order->status         = 'pending';
            $order->save();
            return redirect()->route('v_order.cart')
                ->with('error', 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
        }
    }

    private function getItemDetails($order)
    {
        $items = [];
        foreach ($order->orderItems as $item) {
            $items[] = [
                'id' => $item->produk->id,
                'price' => (int) $item->harga,
                'quantity' => (int) $item->quantity,
                'name' => substr($item->produk->nama_produk, 0, 50),
            ];
        }
        
        // Add shipping cost as an item
        if ($order->biaya_ongkir > 0) {
            $items[] = [
                'id' => 'SHIPPING',
                'price' => (int) $order->biaya_ongkir,
                'quantity' => 1,
                'name' => 'Biaya Pengiriman',
            ];
        }
        
        return $items;
    }

    public function revertCheckout($order_id)
    {
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->firstOrFail();
        $order = Order::where('id', $order_id)->where('customer_id', $customer->id)->firstOrFail();

        // Revert status to pending so it appears in the cart again
        if ($order->status === 'Paid' || $order->status === 'pending') {
            $order->status = 'pending';
            
            if ($order->stock_deducted) {
                $this->restoreStock($order);
            }
            
            $order->save();
        }

        return redirect()->route('v_order.cart')->with('success', 'Silakan perbarui pesanan Anda.');
    }

    public function callback(Request $request)
    {
        Log::info('Midtrans Callback Diterima:', $request->all());

        $serverKey = config('midtrans.server_key');
        $signatureKey = hash("sha512", 
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($signatureKey !== $request->signature_key) {
            Log::warning('Midtrans signature tidak valid.');
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $realOrderId = explode('-', $request->order_id)[0];
        $order = Order::find($realOrderId);

        if (!$order) {
            Log::error('Order tidak ditemukan: ' . $realOrderId);
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Reload order dengan relasi untuk deductStock / restoreStock
        $order->load('orderItems');

        // Process payment status
        switch ($request->transaction_status) {
            case 'capture':
                if ($request->payment_type == 'credit_card') {
                    if ($request->fraud_status == 'challenge') {
                        $order->status = 'challenge';
                    } else {
                        $order->status = 'Paid';
                        $this->deductStock($order); // aman: skip jika stock_deducted = true
                    }
                } else {
                    $order->status = 'Paid';
                    $this->deductStock($order);
                }
                break;

            case 'settlement':
                $order->status = 'Paid';
                $this->deductStock($order);
                break;

            case 'pending':
                // Jangan ubah status jika sudah Paid (misal user sudah bayar via selectPayment)
                if ($order->status !== 'Paid') {
                    $order->status = 'pending';
                }
                break;

            case 'deny':
            case 'cancel':
            case 'expire':
                $order->status = 'cancelled';
                $this->restoreStock($order); // aman: skip jika belum dikurangi
                break;

            default:
                if ($order->status !== 'Paid') {
                    $order->status = 'pending';
                }
                break;
        }

        $order->save();
        Log::info("Status order ID {$order->id} diperbarui ke: {$order->status}");

        return response()->json(['message' => 'Callback processed']);
    }

    private function deductStock($order)
    {
        // Jika stok sudah dikurangi sebelumnya (dari selectPayment), skip
        if ($order->stock_deducted) {
            Log::info("Stok order #{$order->id} sudah dikurangi sebelumnya, skip deductStock.");
            return;
        }

        foreach ($order->orderItems as $item) {
            $produk = Produk::find($item->produk_id); // fresh query, bukan cache
            if (!$produk) continue;

            if ($produk->stok >= $item->quantity) {
                $produk->decrement('stok', $item->quantity);
                Log::info("[deductStock] Stok '{$produk->nama_produk}' -{$item->quantity}. Sisa: " . ($produk->stok - $item->quantity));
            } else {
                Log::warning("[deductStock] Stok '{$produk->nama_produk}' tidak mencukupi (ada: {$produk->stok}, butuh: {$item->quantity})");
            }
        }

        $order->stock_deducted = true;
        $order->save();
    }

    private function restoreStock($order)
    {
        // Hanya kembalikan stok jika memang sudah dikurangi
        if (!$order->stock_deducted) {
            Log::info("Stok order #{$order->id} belum dikurangi, tidak perlu restore.");
            return;
        }

        foreach ($order->orderItems as $item) {
            $produk = Produk::find($item->produk_id);
            if (!$produk) continue;
            $produk->increment('stok', $item->quantity);
            Log::info("[restoreStock] Stok '{$produk->nama_produk}' +{$item->quantity}");
        }

        $order->stock_deducted = false;
        $order->save();
    }

    public function complete()
    {
        return redirect()->route('order.history')->with('success', 'Checkout berhasil');
    }

    public function formOrderProses()
    {
        return view('backend.v_pesanan.formproses', [
            'judul' => 'Laporan',
            'subJudul' => 'Laporan Pesanan Proses',
        ]);
    }

    public function cetakOrderProses(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        $orders = Order::with(['customer.user'])
            ->whereIn('status', ['Paid', 'Kirim'])
            ->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('backend.v_pesanan.cetakproses', compact('orders'));
    }

    public function invoiceBackend($id)
    {
        $order = Order::with(['orderItems.produk', 'customer.user'])->findOrFail($id);
        return view('backend.v_pesanan.invoice', compact('order'));
    }

    public function invoiceFrontend($id)
    {
        $order = Order::with(['orderItems.produk', 'customer.user'])->findOrFail($id);
        return view('v_order.invoice', compact('order'));
    }

    public function showForm()
    {
        return view('contact');
    }

    public function sendMessage(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string|max:2000',
        ]);

        // Simpan ke log (atau kirim email/simpan DB jika diperlukan)
        Log::info('Pesan Kontak Masuk:', $validated);

        // Redirect kembali dengan flash message
        return redirect()->route('contact.form')->with('success', 'Pesan berhasil dikirim!');
    }

    public function selectShipping()
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        $order = $customer ? Order::with('orderItems.produk')
            ->where('customer_id', $customer->id)
            ->where('status', 'pending')
            ->first() : null;

        return view('v_order.selectshipping', compact('order'));
    }

    public function updateOngkir(Request $request)
    {
        $request->validate([
            'biaya_ongkir' => 'required|numeric|min:0',
        ]);

        $customer = Customer::where('user_id', Auth::id())->first();
        $order = Order::where('customer_id', $customer->id)->where('status', 'pending')->first();

        if ($order) {
            $order->biaya_ongkir = $request->biaya_ongkir;
            $order->save();
        }

        return redirect()->route('order.selectpayment', ['order_id' => $order->id])->with('success', 'Biaya pengiriman berhasil diperbarui');
    }

    public function pending()
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        $order = $customer ? Order::with('orderItems.produk')
            ->where('customer_id', $customer->id)
            ->where('status', 'pending')
            ->first() : null;

        return view('v_order.pending', compact('order'));
    }

    public function orderHistory()
    {
        return $this->history();
    }

    public function formOrderSelesai()
    {
        return view('backend.v_pesanan.formselesai', [
            'judul' => 'Laporan',
            'subJudul' => 'Laporan Pesanan Selesai',
        ]);
    }

    public function cetakOrderSelesai(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        $orders = Order::with(['customer.user'])
            ->where('status', 'Selesai')
            ->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('backend.v_pesanan.cetakselesai', compact('orders'));
    }
}