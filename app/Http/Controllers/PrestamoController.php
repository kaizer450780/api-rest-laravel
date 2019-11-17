<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Prestamo;
use App\Implementos;


class PrestamoController extends Controller
{
    

    public function registrarPrestamo(Request $request){

        //recoger los datos del usurio por post
        $json = $request -> input('json', null);
        $param_array =json_decode($json,true);//array

        $count= count($param_array);
        for($i = 0; $i < $count; $i++){
            
            
            //validar datos
            $validate = \Validator::make($param_array[$i],[
                'fecha_inicial' => 'required',
                'fecha_final'   => 'required',
                'estado'  => 'required|alpha'
            ]);
            
            $array = $param_array[$i];
            
            
            if($validate->fails()){
                $data = array(
                    'status'    => 'error',
                    'code'      => 404,
                    'message'   => 'el prestamo no se ha creado',
                    'errors'    => $validate->errors()
                );
                
            }else{
                //validacion correctamente

                $id =Implementos::where('id',$array['id_implementos'])->get(['descripcion']);
                $param_descripcion =json_decode($id,true);//array
                $param_descripcion2=$param_descripcion[0];
                $descripcion=$param_descripcion2['descripcion'];

                $id=Implementos::where('descripcion',$descripcion)->get();
                $param_descripcion =json_decode($id,true);//array
                $param_descripcion2=$param_descripcion[$i];
 
                
                    //crear el usuario
                    $prestamo =new Prestamo();
                    
                    $prestamo->id_users= $array['id_user'];
                    $prestamo->id_implementos= $param_descripcion2['id'];
                    $prestamo->estado= $array['estado'];
                    $prestamo->fecha_inicial= $array['fecha_inicial'];
                    $prestamo->fecha_final=$array['fecha_final'];;
                    

                    //insertar datos en la tabla users
                    $prestamo->save();
    
                    $data = array(
                        'status'    => 'success',
                        'code'      => 200,
                        'message'   => 'el prestamo se ha creado correctamente'
                    );
            }
            
        }
        
        return response()->json($data); 
        
        
    }


    public function PrestamoImplementopendientes(){

        $reserva = Implementos::join("prestamo","implementos.id","=","prestamo.id_implementos")
      ->where('prestamo.estado','=','pendiente')
      ->get(['implementos.id','implementos.placa','implementos.descripcion','prestamo.fecha_inicial','prestamo.fecha_final','prestamo.estado']);

        return response()->json([
             'code' => 200,
             'status'=> 'sucess',
             'implementos'=> $reserva
        ]);
     }

     public function actualizarPrestamo(Request $request){

        //recoger los datos del usurio por post
        $json = $request -> input('json', null);
        $param_array =json_decode($json,true);//array


        $prestamo=Prestamo::find($param_array['id']);
        $prestamo->estado = $param_array['estado'];
        $prestamo->save();



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
                'message'=>'error en el cambio de estado'
            );
        }

         return response()->json($data,$data['code']);
    }
}
