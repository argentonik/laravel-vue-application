<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordinate extends Model
{
    public $timestamps = false;

    protected $fillable = ['bulletin_id', 'latitude', 'longitude'];
}
