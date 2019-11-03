<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Implementos extends Model
{
    protected $table ='implementos';
    
    //relacion de uno a muchos
    public function prestamo(){
        return $this->hasMany('App/Prestamo');
    }
}