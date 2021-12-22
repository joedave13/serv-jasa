<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatus extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    protected $hidden = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'order_status_id', 'id');
    }
}
