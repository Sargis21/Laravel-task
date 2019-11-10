<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded =[];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function images()
    {
        return $this->morphMany('App\Image','imageable');
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
}
