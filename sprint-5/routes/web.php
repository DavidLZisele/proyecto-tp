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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get("perfil",function(){
    return view("perfil");
});

Route::post("perfil",function(){
    return view("perfil");
});
Route::get('perfil', "CategoriaController@index")->name('categoria.index');
Route::put('datos/{usuario}/cambiarDatos', "UsuarioController@updateDatos")->name('datos.cambiarDatos');
Route::put('datos/{usuario}/cambiarPassword', "UsuarioController@updatePassword")->name('datos.cambiarPassword');
Route::put('datos/{usuario}/cambiarFoto', "UsuarioController@updateFoto")->name('datos.cambiarFoto');
Route::get('datos', "UsuarioController@index")->name('datos.index');
