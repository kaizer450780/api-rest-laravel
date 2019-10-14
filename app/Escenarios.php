<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escenarios extends Model
{
    protected $table ='escenarios';
    
    //relacion de uno a muchos
    public function reservas(){
        return $this->hasMany('App/Reserva');
    }
}
