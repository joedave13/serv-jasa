<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserExperience extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_detail_id',
        'experience',
    ];

    protected $hidden = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function user_detail()
    {
        return $this->belongsTo(UserDetail::class, 'user_detail_id', 'id');
    }
}
