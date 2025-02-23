<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    use HasFactory;

    // app/Models/Order.php
    protected $fillable = [
        'user_id',
        'items',
        'address',
        'phone', 
        'status',
    ];


}
