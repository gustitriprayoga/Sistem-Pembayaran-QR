<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarMenu extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kategori()
    {
        return $this->belongsTo(KategoriMenu::class, 'id_kategori');
    }

    public function varian()
    {
        return $this->hasMany(VarianMenu::class, 'id_menu');
    }
}
