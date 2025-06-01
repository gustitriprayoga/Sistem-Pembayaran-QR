<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $guarded = [];

    // public function kategori()
    // {
    //     return $this->belongsTo(KategoriMenu::class, 'kategori_id', 'nama');
    // }

    public function kategori()
    {
        return $this->belongsTo(KategoriMenu::class);
    }

    public function varianMenu()
    {
        return $this->hasMany(VarianMenu::class, 'menu_id');
    }
}
