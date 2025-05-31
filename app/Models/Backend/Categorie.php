<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
