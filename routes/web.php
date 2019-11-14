<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('reserva/pruebas','ReservaController@pruebas');

//api routes
Route::post('api/register','UserController@register');
Route::post('api/login','UserController@login');
Route::post('api/user/update','UserController@update');

//rutas del controlador de escenarios 

Route::resource('api/escenarios','EscenarioController');

//ruta controlador de reservas
Route::post('api/reserva/actualizar','ReservaController@actualizarReserva');
Route::post('api/reserva/crear','ReservaController@registrarReserva');
Route::post('api/reserva/pendientesHoy','ReservaController@reservasPendientesDiaActual');
Route::get('api/reserva/pendientes/{estado}','ReservaController@reservasPendientes');
Route::get('api/reserva/{id}','ReservaController@reservas');


//rutas del controlador de implementos
Route::get('api/implementos','ImplementosController@implementos');
Route::get('api/implementos/seleccion/{implemento}','ImplementosController@verImplemento');

//ruta controlador de prestamos

Route::get('api/prestamo/{id}','PrestamoController@prestamo');
Route::post('api/prestamo/crear','PrestamoController@registrarPrestamo');

//ruta envio de correos

Route::post('api/reserva/correo', 'EmailController@contact')->name('contact');