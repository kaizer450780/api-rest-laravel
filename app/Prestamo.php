<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $table ='prestamo';
    
    //relacion de uno a muchos inversa
    public function user(){
        return $this->belongsTo('App/User','id_users');
    }

    public function implemento(){
        return $this->belongsTo('App/Implementos','id_implementos');
    }
}
