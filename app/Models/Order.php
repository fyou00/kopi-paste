<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pelanggan',
        'table_id',
        'status',
        'total',
        'waktu'
    ];

    protected $casts = [
        'waktu' => 'datetime'
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function scopeDiproses($query)
    {
        return $query->where('status', 'diproses');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    public function calculateTotal()
    {
        return $this->items->sum('subtotal');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($order) {
            if ($order->table_id) {
                Table::find($order->table_id)->update(['status' => 'terisi']);
            }
        });

        static::updated(function ($order) {
            if ($order->status === 'selesai' && $order->table_id) {
                Table::find($order->table_id)->update(['status' => 'tersedia']);
            }
        });
    }
}
