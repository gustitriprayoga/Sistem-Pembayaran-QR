<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriMenu extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function daftarMenu()
    {
        return $this->hasMany(DaftarMenu::class, 'id_kategori_menu');
    }
}
