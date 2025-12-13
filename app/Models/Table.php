<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor',
        'kapasitas',
        'status'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function scopeTersedia($query)
    {
        return $query->where('status', 'tersedia');
    }

    public function scopeTerisi($query)
    {
        return $query->where('status', 'terisi');
    }
}