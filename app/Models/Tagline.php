<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tagline extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'service_id',
        'tagline',
    ];

    protected $hidden = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
