<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    protected $fillable = [
        'name',
    ];

    public function pets(){
        return $this->hasMany('App\Pets', 'species_id', 'id');
    }
}
