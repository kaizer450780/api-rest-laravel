<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Prestamo;
use App\Implementos;


class PrestamoController extends Controller
{
    public function prestamo($id){
        
        $prestamo=Prestamo::where('id_implementos',$id) -> get();
       
        if(is_object($prestamo)){

            $data=array(
                'code'=> 200,
                'status'=>'sucess',
                'reserva'=>$prestamo
            );
        }else{
            $data=array(
                'code'=> 400,
                'status'=>'error',
                'message'=>'el implemento no esta prestados'
            );
        }

         return response()->json($data,$data['code']);
    }

    public function registrarPrestamo(Request $request){

        //recoger los datos del usurio por post
        $json = $request -> input('json', null);
        $param_array =json_decode($json,true);//array
        $auxjson=$param_array['id_implementos'];
        
        $implementos=Implementos::where('id',$auxjson)->get();
        
        return response()->json($implementos); die();
        
        $param_array= array_map('trim',$param_array);
        //$count= count($param_array);
        //for($i = 0; $i < $count; $i++){
            

            //validar datos
            $validate = \Validator::make($param_array[$i],[
                'fecha_inicial' => 'required',
                'fecha_final'   => 'required',
                'cantidad'   => 'required',
                'estado'  => 'required|alpha'
            ]);
            
            $array = $param_array[$i];
            

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
                    $prestamo =new Prestamo();
                    
                    $prestamo->id_users= $array['id_users'];
                    $prestamo->id_implementos= $array['id_implementos'];
                    $prestamo->cantidad= $array['cantidad'];
                    $prestamo->estado= $array['estado'];
                    $prestamo->fecha_inicial= $array['fecha_inicial'];
                    $prestamo->fecha_final=$array['fecha_final'];;
                    

                    //insertar datos en la tabla users
                    $prestamo->save();
    
                    $data = array(
                        'status'    => 'success',
                        'code'      => 200,
                        'message'   => 'el prestamo se ha creado correctamente',
                        'prestamo'=>  $prestamo
                    );
            }
            
        //}
        
        return response()->json($data,$data['code']); 
        
        
    }
}
