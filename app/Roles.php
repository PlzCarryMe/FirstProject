<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Roles extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $table = 'roles';

    protected $fillable = [
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany('App\User', 'roles_user', 'roles_id', 'user_id');
    }
}
