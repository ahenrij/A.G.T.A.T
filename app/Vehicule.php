<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    //
    protected $fillable = [
        'immatriculation', 'marque', 'type_vehicule_id', 'user_id'
    ];

    public function typeVehicule(){
        return $this->belongsTo('App\TypeVehicule');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
