<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function meja()
    {
        return $this->belongsTo(DaftarMeja::class, 'id_meja');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'id_user');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan');
    }
}
