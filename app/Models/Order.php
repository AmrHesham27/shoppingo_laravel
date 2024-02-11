<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'status',
    ];

    protected $casts = [
        'status' => StatusEnum::class
    ];
}
