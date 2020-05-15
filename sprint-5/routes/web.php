<?php

use Illuminate\Support\Facades\Route;

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
    return redirect()->route('home');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('faq','FaqController@create')->name('faq.create');
Route::post('faq','FaqController@store')->name('faq.store');

Route::middleware('auth')->group(function(){
    Route::delete('datos/deletePos',"PosteoController@destroy")->name('datos.deletePos');
    Route::get('datos', "UsuarioController@index")->name('datos.index');
    Route::get('perfil', "CategoriaController@index")->name('categoria.index');
    Route::post('categorias/store', "CategoriaController@store")->name('categoria.store');
    Route::delete('categorias/destroy', "CategoriaController@destroy")->name('categoria.destroy');
    Route::post('like/store', "LikeController@store")->name('like.store');
    Route::delete('amigo/destroy', "UsuarioController@eliminarAmigo")->name('datos.eliminarAmigo');
    Route::put('amigo/bloquear', "UsuarioController@bloquearAmigo")->name('datos.bloquearAmigo');
    Route::post('comentario/store', "ComentarioController@store")->name('comentario.store');


    Route::delete('usuario/{usuario}/destroy', "UsuarioController@destroy")->name('usuario.destroy');
    Route::put('comentario/{comentario}/update', "ComentarioController@update")->name('comentario.update');
    Route::delete('comentario/{comentario}/destroy', "ComentarioController@destroy")->name('comentario.destroy');
    Route::delete('like/{like}/destroy', "LikeController@destroy")->name('like.destroy');
    Route::put('datos/{usuario}/cambiarDatos', "UsuarioController@updateDatos")->name('datos.cambiarDatos');
    Route::put('datos/{usuario}/cambiarPassword', "UsuarioController@updatePassword")->name('datos.cambiarPassword');
    Route::put('datos/{usuario}/cambiarFoto', "UsuarioController@updateFoto")->name('datos.cambiarFoto');
    Route::post('datos/{usuario}/insertSolicitud',"UsuarioController@insertSolicitud")->name('datos.insertSolicitud');
    Route::post('datos/{usuario}/enviarSolicitud',"UsuarioController@enviarSolicitud")->name('datos.enviarSolicitud');
    Route::put('datos/{usuario}/agregarAmigo', "UsuarioController@agregarAmigo")->name('datos.agregarAmigo');
    Route::post('datos/{usuario}/insertPos', "PosteoController@store")->name('datos.insertPos');
    Route::get('datos/{posteo}/editPos',"PosteoController@edit")->name('datos.editPos');
    Route::put('datos/{posteo}/updatePos',"PosteoController@update")->name('datos.updatePos');
});









