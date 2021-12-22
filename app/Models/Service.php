<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'delivery_time',
        'revision_limit',
        'price',
        'note',
    ];

    protected $hidden = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function user_advantages()
    {
        return $this->hasMany(UserAdvantage::class, 'service_id', 'id');
    }

    public function taglines()
    {
        return $this->hasMany(Tagline::class, 'service_id', 'id');
    }

    public function service_advantages()
    {
        return $this->hasMany(ServiceAdvantage::class, 'service_id', 'id');
    }

    public function service_thumbnails()
    {
        return $this->hasMany(ServiceThumbnail::class, 'service_id', 'id');
    }
}
