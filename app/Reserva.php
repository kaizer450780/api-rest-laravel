<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table ='reserva';
    
    //relacion de uno a muchos inversa
    public function user(){
        return $this->belongsTo('App/User','id_users');
    }

    public function escenario(){
        return $this->belongsTo('App/Escenario','id_escenarios');
    }
}
