<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Reserva;

class ReservaController extends Controller
{
    public function reservas($id){
        //print($id); die();
        $reserva=Reserva::where('id_escenarios',$id) -> get();

        if(is_object($reserva)){

            $data=array(
                'code'=> 200,
                'status'=>'sucess',
                'reserva'=>$reserva
            );
        }else{
            $data=array(
                'code'=> 400,
                'status'=>'error',
                'message'=>'el escenario no tiene reservas'
            );
        }

         return response()->json($data,$data['code']);
    }

    public function registrarReserva(Request $request){

                //recoger los datos del usurio por post
                $json = $request -> input('json', null);
                $param_array =json_decode($json,true);//array
                
                
                $param_array= array_map('trim',$param_array);
        
                //validar datos
                $validate = \Validator::make($param_array,[
                    'fecha_inicial' => 'required',
                    'fecha_final'   => 'required',
                    'estado'  => 'required|alpha'
                ]);
        
             
        
                if($validate->fails()){
                    $data = array(
                        'status'    => 'error',
                        'code'      => 404,
                        'message'   => 'la reserva no se ha creado',
                        'errors'    => $validate->errors()
                    );
                    
                }else{
                    //validacion correctamente
        
                    //crear el usuario
                    $reserva =new Reserva();
                    $id_users->id_users= $param_array['id_users'];
                    $id_escenarios->id_escenarios= $param_array['id_escenarios'];
                    $fecha_inicial->fecha_inicial= $param_array['fecha_inicial'];
                    $fecha_final->fecha_final=$param_array['fecha_final'];;
                    $estado->estado= $param_array['estado'];
        
                   //insertar datos en la tabla users
                    $reserva->save();
        
                    $data = array(
                        'status'    => 'success',
                        'code'      => 200,
                        'message'   => 'la reserva se ha creado correctamente',
                        'reserva'=> $reserva
                    );
                }
                return response()->json($data,$data['code']);
                
    }
}
