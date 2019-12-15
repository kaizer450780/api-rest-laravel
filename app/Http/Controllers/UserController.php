<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller{
    public function pruebas(Request $request){
        return "accion de pruebas de USER-CONTROLLER" ;
    }
    
    //registro y login de la api
    public function register(Request $request){

        //recoger los datos del usurio por post
        $json = $request -> input('json', null);
        $param= json_decode($json);//objeto
        $param_array =json_decode($json,true);//array
        
        
        $param_array= array_map('trim',$param_array);

        //validar datos
        $validate = \Validator::make($param_array,[
            'name'      => 'required|regex:/^[\pL\s\-]+$/u',
            'surname'   => 'required|regex:/^[\pL\s\-]+$/u',
            'email'     => 'required|email|unique:users',
            'password'  => 'required',
            'user_type' => 'required'
        ]);

     

        if($validate->fails()){
            $data = array(
                'status'    => 'error',
                'code'      => 500,
                'message'   => 'El usuario no se ha creado',
                'errors'    => $validate->errors()
            );
            
        }else{
            //validacion correctamente

            //cifrar la contraseña
            $pdw=hash('sha256',$param->password);
            //$pdw = password_hash($param->password,PASSWORD_BCRYPT,['cost'=> 4]);

            //crear el usuario
            $user =new User();
            $user->name= $param_array['name'];
            $user->surname= $param_array['surname'];
            $user->email= $param_array['email'];
            $user->password=$pdw;
            $user->user_type= $param_array['user_type'];

           //insertar datos en la tabla users
            $user->save();

            $data = array(
                'status'    => 'success',
                'code'      => 200,
                'message'   => 'El usuario se ha creado correctamente',
                'user'=> $user
            );
        }
        return response()->json($data,$data['code']);
        
    }

    public function login(Request $request){

        $jwtAuth =new \JWTAuth();
        
        //recibir datos por post
        $json = $request -> input('json', null);
        $param= json_decode($json);//objeto
        $param_array =json_decode($json,true);//array
        
        //validar datos
        $validate = \Validator::make($param_array,[
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        if($validate->fails()){
            $signup = array(
                'status'    => 'error',
                'code'      => 404,
                'message'   => 'el usuario no se ha podido identificar',
                'errors'    => $validate->errors()
            );
            
        }else{
            //cifrar la contraseña
            $pdw=hash('sha256',$param->password);

            //devolver token o datos
            $signup= $jwtAuth->signup($param->email,$pdw);

            if(!empty($param->gettoken)){
                $signup= $jwtAuth->signup($param->email,$pdw,true);
            }
        }
        return  response()->json($signup,200);
    }

    public function update(Request $request){

        //comprobar si el usuario esta identificado
        $token= $request->header('Authorization');
        $jwtAuth = new \JWTAuth();
        $checkToken=$jwtAuth->checkToken($token);

        if($checkToken){
            //actualizar usuario
            //recoger los datos del usurio por post
            $json = $request -> input('json', null);
            $param_array =json_decode($json,true);//array

            //sacar usuario identificado
            $user = $jwtAuth->checkToken($token,true);

            //validar datos
            $validate = \Validator::make($param_array,[
                'name'      => 'required|alpha',
                'surname'   => 'required|alpha',
                'email'     => 'required|email|unique:users'.$user->sub,
                'user_type' => 'required'
            ]);


        }else{
             $data = array(
                'status'    => 'error',
                'code'      => 400,
                'message'   => 'El usuario se ha identificado correctamente'
            );
        }

        return  response()->json($data,$data['code']);
    }
}
