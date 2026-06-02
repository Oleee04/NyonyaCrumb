<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'customer_id',
        'status',
        'total_harga',
        'order_date',
        'alamat',
        'pos',
        'hp',
        'biaya_ongkir',
        'ekspedisi',
        'noresi',
        'snap_token',
    ];

    protected $casts = [
        'total_harga' => 'float',
        'biaya_ongkir' => 'float',
        'order_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Relasi ke OrderItem
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /**
     * Update total harga order
     */
    public function updateTotal()
    {
        $total = $this->orderItems()->sum(\DB::raw('harga * quantity'));
        $this->update(['total_harga' => $total + ($this->biaya_ongkir ?? 0)]);
    }
}