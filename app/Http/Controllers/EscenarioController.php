<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Escenarios;

class EscenarioController extends Controller
{
    public function index(){
       $escenarios=Escenarios::all();

       return response()->json([
            'code' => 200,
            'status'=> 'sucess',
            'escenarios'=> $escenarios
       ]);
    }
}
