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
        // Relasi ke model DaftarMenu
        return $this->hasMany(DaftarMenu::class, 'kategori_menu_id');
    }
}
