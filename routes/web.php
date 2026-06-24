<?php 
 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http; 
use App\Http\Controllers\BerandaController; 
use App\Http\Controllers\LoginController; 
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ElectreController;
use App\Http\Controllers\ProfileMatchingController;
 
Route::get('/', function () { 
    // return view('welcome'); 
    return redirect()->route('beranda');
});


Route::get('backend/login', [LoginController::class, 'loginBackend'])->name('backend.login'); 
Route::post('backend/login', [LoginController::class, 'authenticateBackend'])->name('backend.login'); 
Route::match(['get', 'post'], 'backend/logout', [LoginController::class, 'logoutBackend'])->name('backend.logout'); 

Route::middleware(['auth', 'is.admin'])->group(function () {
    Route::get('backend/beranda', [BerandaController::class, 'berandaBackend'])->name('backend.beranda'); 
   Route::get('/backend/electre', [ElectreController::class, 'index'])
    ->name('backend.electre.index');

Route::post('/backend/electre/hitung', [ElectreController::class, 'hitung'])
    ->name('backend.electre.hitung');

Route::get('/backend/electre/hasil', [ElectreController::class, 'hasil'])
    ->name('backend.electre.hasil');

// Optional biar kalau /backend/electre/hitung kebuka langsung tidak error
Route::get('/backend/electre/hitung', function () {
    return redirect()->route('backend.electre.index')
        ->with('error', 'Silakan upload file Excel terlebih dahulu.');
});
    // Route untuk User 
    Route::resource('backend/user', UserController::class, ['as' => 'backend']); 
    // Route untuk laporan user 
    Route::get('backend/laporan/formuser', [UserController::class, 'formUser'])->name('backend.laporan.formuser');
    Route::post('backend/laporan/cetakuser', [UserController::class, 'cetakUser'])->name('backend.laporan.cetakuser');

    // Laporan Penjualan
    Route::get('backend/laporan/formpenjualan', [UserController::class, 'formPenjualan'])->name('backend.laporan.formpenjualan');
    Route::post('backend/laporan/formpenjualan', [UserController::class, 'cetakPenjualan'])->name('backend.laporan.cetakpenjualan');
    
    // Route untuk Kategori 
    Route::resource('backend/kategori', KategoriController::class, ['as' => 'backend']); 
    Route::get('/pesanan/create', [UserController::class, 'create'])->name('backend.pesanan.create');
    Route::post('/pesanan/store', [UserController::class, 'store'])->name('backend.pesanan.store');

    // Route untuk Pesanan Backend
    Route::get('backend/pesanan', [OrderController::class, 'index'])->name('backend.pesanan.index');
    Route::get('/pesanan/proses', [OrderController::class, 'statusProses'])->name('pesanan.proses');
    Route::get('/pesanan/selesai', [OrderController::class, 'statusSelesai'])->name('pesanan.selesai');
    Route::get('/backend/pesanan/{id}/detail', [OrderController::class, 'statusDetailAdmin'])
        ->name('backend.v_pesanan.detail');

    Route::put('/pesanan/update/{id}', [OrderController::class, 'statusUpdate'])->name('pesanan.update');
    Route::get('/pesanan/invoice/{id}', [OrderController::class, 'invoiceBackend'])->name('pesanan.invoice');

    // Route untuk Laporan Pesanan
    Route::get('backend/laporan/formproses', [OrderController::class, 'formOrderProses'])->name('backend.laporan.formproses');
    Route::post('backend/laporan/cetakproses', [OrderController::class, 'cetakOrderProses'])->name('backend.laporan.cetakproses');
    Route::get('backend/laporan/formselesai', [OrderController::class, 'formOrderSelesai'])->name('backend.laporan.formselesai');
    Route::post('backend/laporan/cetakselesai', [OrderController::class, 'cetakOrderSelesai'])->name('backend.laporan.cetakselesai');

    // Route untuk Produk 
    Route::resource('backend/produk', ProdukController::class, ['as' => 'backend']); 
    // Route untuk menambahkan foto 
    Route::post('foto-produk/store', [ProdukController::class, 'storeFoto'])->name('backend.foto_produk.store'); 
    // Route untuk menghapus foto
    Route::delete('foto-produk/{id}', [ProdukController::class, 'destroyFoto'])->name('backend.foto_produk.destroy');
    // Route untuk laporan produk 
    Route::get('backend/laporan/formproduk', [ProdukController::class, 'formProduk'])->name('backend.laporan.formproduk'); 
    Route::post('backend/laporan/cetakproduk', [ProdukController::class, 'cetakProduk'])->name('backend.laporan.cetakproduk');

    // Route untuk Customer 
    Route::resource('backend/customer', CustomerController::class, ['as' => 'backend']);
});

// Frontend 
Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
Route::get('/cara-pesan', function () {
    return view('cara-pesan');
})->name('cara.pesan');

// Contact routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

//Produk
Route::get('/produk/detail/{id}', [ProdukController::class, 'detail'])->name('produk.detail');
Route::get('/produk/kategori/{id}', [ProdukController::class, 'produkKategori'])->name('produk.kategori');
Route::get('/produk/all', [ProdukController::class, 'produkAll'])->name('produk.all');
Route::post('/produk/rekomendasi', [ProfileMatchingController::class, 'analyze'])->name('produk.rekomendasi');

// Cart route (accessible to all to allow viewing empty cart)
Route::get('/cart', [OrderController::class, 'viewCart'])->name('v_order.cart');

//API Google 
Route::get('/auth/redirect', [CustomerController::class, 'redirect'])->name('auth.redirect'); 
Route::get('/auth/google/callback', [CustomerController::class, 'callback'])->name('auth.callback'); 

// Frontend Auth Views
Route::get('/auth/login', function () { return view('v_customer.login'); })->name('auth.login');
Route::post('/auth/login', [CustomerController::class, 'loginSubmit'])->name('auth.login.submit');
Route::get('/auth/register', function () { return view('v_customer.register'); })->name('auth.register');
Route::post('/auth/register', [CustomerController::class, 'registerSubmit'])->name('auth.register.submit');

// Password Reset Routes
Route::get('/auth/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('auth.forgot-password.form');
Route::post('/auth/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('auth.forgot-password.send');
Route::get('/auth/verify-otp', [ForgotPasswordController::class, 'showOtpForm'])->name('auth.verify-otp.form');
Route::post('/auth/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('auth.verify-otp.submit');
Route::get('/auth/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('auth.reset-password.form');
Route::post('/auth/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('auth.reset-password.submit');

// Logout 
Route::match(['get', 'post'], '/logout', [CustomerController::class, 'logout'])->name('logout');

// Midtrans Callback (harus di luar middleware untuk menerima notifikasi dari Midtrans)
Route::post('/midtrans/callback', [OrderController::class, 'callback'])->name('midtrans.callback');

// Group route untuk customer 
Route::middleware('is.customer')->group(function () { 
    // Route untuk menampilkan halaman akun customer 
    Route::get('/customer/akun/{id}', [CustomerController::class, 'akun']) 
        ->name('customer.akun'); 
 
    // Route untuk mengupdate data akun customer 
    Route::put('/customer/updateakun/{id}', [CustomerController::class, 'updateAkun']) 
        ->name('customer.akun.update'); 
 
    // Route keranjang belanja 
    Route::post('add-to-cart/{id}', [OrderController::class, 'addToCart'])->name('order.addToCart'); 
    Route::post('cart/update/{id}', [OrderController::class, 'updateCart'])->name('order.updateCart'); 
    Route::post('remove/{id}', [OrderController::class, 'removeFromCart'])->name('order.remove');
    
    // Route Ulasan (Review)
    Route::post('/produk/{id}/review', [ReviewController::class, 'store'])->name('produk.review.store');
    
    // Route untuk proses checkout dan shipping
    Route::post('checkout', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::get('/order/selectshipping', [OrderController::class, 'selectShipping'])->name('order.selectshipping');
    Route::post('/order/updateongkir', [OrderController::class, 'updateOngkir'])->name('order.updateongkir');
    
    // Route untuk payment
    Route::get('/order/selectpayment/{order_id}', [OrderController::class, 'selectPayment'])->name('order.selectpayment');
    Route::get('/order/{order_id}/revert-checkout', [OrderController::class, 'revertCheckout'])->name('order.revert_checkout');
    Route::get('/order/pending', [OrderController::class, 'pending'])->name('order.pending');
    Route::get('/order/complete/{order_id}', [OrderController::class, 'complete'])->name('order.complete');


    // Route untuk history
    Route::get('/history', [OrderController::class, 'history'])->name('order.history');
    Route::get('/order/history', [OrderController::class, 'orderHistory'])->name('order.orderhistory'); // Alias
    Route::get('/history/{id}', [OrderController::class, 'statusDetail'])->name('order.detail');
    Route::get('/history/{id}/invoice', [OrderController::class, 'invoiceFrontend'])->name('order.invoice');
});