<?php
namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Suport\Facades\DB;
use App\User;

class jwtAuth{

    public $key;

    public function __construct(){
        $this->key='esto_es_una_clave_secreta-u888';
    }

    public function signUp($email,$password,$getToken=null){
        //buscar si existe el usuario con sus credenciales
        $user = User::where([
            'email'=> $email,
            'password'=> $password
        ])->first();

        //comprobar si son correctas(objeto)
        $signup =false;
        if(is_object($user)){
            $signup=true;
        }

        //generar el token con los datos del usuario identificado
        if($signup){
            $token = array(
                'sub'=>$user->id,
                'email'=>$user->email,
                'name' => $user->name,
                'surname'=>$user->ssurname,
                'iat' => time(),
                'exp'=> time()+(7*24*60*60)
            );

            $jwt = JWT::encode($token,$this->key,'HS256');


            //devolver los datos decodificados o el token, en funcion de un parametro
                $data =array(
                    'status'=>'success',
                    'id'=> $user->id_user,
                    'name_user'=> $user->name,
                    'user_type'=>$user->user_type,
                    'message'=> $jwt
                );

        }else{

            $data =array(
                'status'=>'error',
                'message'=>'login incorrecto'
            );
        }
        
        return $data;
    }

    public function checkToken($jwt,$getIdentity=false){
        $auth=false;

        try{
            $jwt = str_replace('"','',$jwt);
            $decoded=JWT::decode($jwt,$this->key,['HS256']);
        }catch(\UnexpectedValueException $e){
            $auth=false;
        }catch(\DomainException $e){
            $auth=false;
        }

        if(!empty($decoded) && is_object($decoded)){
            $auth=true;
        }else{
            $auth=false;
        }
        if($getIdentity){
            return $decoded;
        }
        return $auth;
    }
}
