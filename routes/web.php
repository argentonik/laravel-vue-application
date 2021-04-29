<?php

use App\Models\Bulletin;
use Illuminate\Support\Facades\Route;

Route::get('/{any}', 'SinglePageController@index')->where('any', '.*');