<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarMeja extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'daftar_meja_id');
    }
}
