<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $guarded =[];

    public function products()
    {
        return $this->belongsToMany('App\Product');
    }

    public function images()
    {
        return $this->hasMany('App\Image');
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
}
