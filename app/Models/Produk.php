<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Produk extends Model
{
    public $timestamps = true;
    protected $table = "produk";
    protected $guarded = ['id'];
    
    // Accessor untuk mendapatkan URL foto utama
    public function getFotoUtamaUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/img-produk/thumb_lg_' . $this->foto);
        }
        
        $firstFoto = $this->fotoProduk()->first();
        if ($firstFoto) {
            return asset('storage/img-produk/' . $firstFoto->foto);
        }
        
        return asset('frontend/images/default-product.jpg');
    }
    
    // Accessor untuk thumbnail
    public function getFotoThumbnailAttribute()
    {
        if ($this->foto) {
            return asset('storage/img-produk/thumb_sm_' . $this->foto);
        }
        
        $firstFoto = $this->fotoProduk()->first();
        if ($firstFoto) {
            return asset('storage/img-produk/' . $firstFoto->foto);
        }
        
        return asset('frontend/images/default-product.jpg');
    }
    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function fotoProduk()
    {
        return $this->hasMany(FotoProduk::class);
    }
}