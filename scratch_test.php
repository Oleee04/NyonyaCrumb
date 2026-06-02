<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Produk;
use Illuminate\Support\Facades\DB;

foreach(Produk::all() as $p) {
    $qty = DB::table('order_item')->where('produk_id', $p->id)->sum('quantity');
    echo $p->id . '|' . $p->nama_produk . '|' . $qty . PHP_EOL;
}
