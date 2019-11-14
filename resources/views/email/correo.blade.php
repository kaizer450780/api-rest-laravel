<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
    </head>
   
    <body>
        <h2>Correo estado reserva</h2>
        <div>Su reserva : 
            <ol>
                <li>Id: {!! $id !!}</li>
                <li>Nombre :  {!! $name !!}</li>
                <li>Escenario : {!! $nombre !!}</li>
                <li>Ubicacion : {!! $codigo !!}</li>
                <li>fecha y hora inicial : {!! $fecha_inicial !!}</li>
                <li>fecha y hora final : {!! $fecha_final !!}</li>
                <li>Estado : {!! $estado !!}</li>
            </ol>
        </div>
    </body>
</html>
