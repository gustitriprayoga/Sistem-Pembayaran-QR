<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriMenu extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function menu()
    {
        return $this->hasMany(Menu::class, 'kategori_id');
    }
}
