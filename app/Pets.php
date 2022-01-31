<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pets extends Model
{
    protected $fillable = [
        'date_of_birth','petnames_id','species_id','users_id',
    ];

    public function users(){
        return $this->belongsTo('App\User');
    }

    public function species(){
        return $this->belongsTo('App\Species');
    }

    public function petnames(){
        return $this->belongsTo('App\Petnames');
    }
}
