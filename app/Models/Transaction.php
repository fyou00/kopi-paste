<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'metode_pembayaran',
        'status_pembayaran',
        'total'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeLunas($query)
    {
        return $query->where('status_pembayaran', 'Lunas');
    }

    public function scopeBelumLunas($query)
    {
        return $query->where('status_pembayaran', 'Belum Lunas');
    }
}