<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // app/Models/Order.php
    protected $fillable = [
        'user_id',
        'items',
        'status',
        'address'
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}
}
