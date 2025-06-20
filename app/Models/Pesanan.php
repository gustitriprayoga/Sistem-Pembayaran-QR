<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function meja()
    {
        return $this->belongsTo(DaftarMeja::class);
    }

    public function mejas()
    {
        return $this->belongsTo(DaftarMeja::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class);
    }
}
