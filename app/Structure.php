<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    protected $fillable = [
        'raison_sociale','contact','adresse'
    ];
    //
    public function users(){
        return $this->hasMany('App\User');
    }
}
