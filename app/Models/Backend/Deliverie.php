<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliverie extends Model
{
    use HasFactory;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
