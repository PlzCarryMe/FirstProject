<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Petnames extends Model
{
    protected $fillable = [
        'name',
    ];

    public function pets(){
        return $this->hasMany('App\Pets');
    }
}
