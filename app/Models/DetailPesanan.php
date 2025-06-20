<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function varianMenu()
    {
        return $this->belongsTo(VarianMenu::class);
    }

    /**
     * Relasi kembali ke Pesanan (opsional, tapi baik untuk ada).
     */
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function menu()
    {
        return $this->belongsTo(DaftarMenu::class, 'daftar_menu_id'); // Mengakses menu melalui varianMenu
    }
}
