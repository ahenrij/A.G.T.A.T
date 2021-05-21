<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeUser extends Model
{
    //
    protected $table  = 'type_users';

    protected $fillable = [
        'libelle'
    ];

    public function users(){
        return $this->hasMany('App\User');
    }
}
