<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom', 'prenom', 'login', 'password', 'structure_id', 'groupe_id', 'type_user_id', 'telephone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function structure(){
        return $this->belongsTo('App\Structure');
    }

    public function typeUser(){
        return $this->belongsTo('App\TypeUser');
    }

    public function groupe(){
        return $this->belongsTo('App\Groupe');
    }

    public function titres(){
        return $this->hasMany('App\Titre');
    }
    public function vehicule(){
        return $this->hasOne('App\Vehicule');
    }
    public function logs(){
        return $this->hasMany('App\Log');
    }

}
