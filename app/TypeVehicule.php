<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeVehicule extends Model
{
    //
    protected $table = 'type_vehicules';

    protected $fillable = [
        'libelle'
    ];

    public $timestamps = false;

    public function vehicules(){
        return $this->hasMany('App\Vehicule');
    }
}
