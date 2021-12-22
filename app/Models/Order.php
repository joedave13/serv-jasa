<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'service_id',
        'freelancer_id',
        'buyer_id',
        'file',
        'note',
        'expired',
        'order_status_id',
    ];

    protected $hidden = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}