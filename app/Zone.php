<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    //
    protected $fillable = [
        'libelle'
    ];
    public function titres(){
        return $this->hasMany('App\Titre');
    }
}
