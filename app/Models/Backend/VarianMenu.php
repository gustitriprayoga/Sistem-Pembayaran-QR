<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VarianMenu extends Model
{
    use HasFactory;

    protected $tguarded = [];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
