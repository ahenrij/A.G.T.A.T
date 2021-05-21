<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    protected $fillable = [
        'libelle'
    ];
    public function users(){
        return $this->hasMany('App\User');
    }
}
