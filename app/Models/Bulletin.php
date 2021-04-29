<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'phone', 'country', 'email', 'valid_to', 'image'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function coordinate()
    {
        return $this->hasOne('App\Models\Coordinate');
    }
}
