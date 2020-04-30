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
Route::delete('datos/deletePos',"PosteoController@destroy")->name('datos.deletePos');
Route::get('datos', "UsuarioController@index")->name('datos.index')->middleware('auth');
Route::get('perfil', "CategoriaController@index")->name('categoria.index')->middleware('auth');
Route::post('categorias/store', "CategoriaController@store")->name('categoria.store');
Route::delete('categorias/destroy', "CategoriaController@destroy")->name('categoria.destroy');

Route::put('datos/{usuario}/cambiarDatos', "UsuarioController@updateDatos")->name('datos.cambiarDatos');
Route::put('datos/{usuario}/cambiarPassword', "UsuarioController@updatePassword")->name('datos.cambiarPassword');
Route::put('datos/{usuario}/cambiarFoto', "UsuarioController@updateFoto")->name('datos.cambiarFoto');
Route::post('datos/{usuario}/insertSolicitud',"UsuarioController@insertSolicitud")->name('datos.insertSolicitud');
Route::put('datos/{usuario}/agregarAmigo', "UsuarioController@agregarAmigo")->name('datos.agregarAmigo');
Route::post('datos/{usuario}/insertPos', "PosteoController@store")->name('datos.insertPos');
Route::get('datos/{posteo}/editPos',"PosteoController@edit")->name('datos.editPos');
Route::put('datos/{posteo}/updatePos',"PosteoController@update")->name('datos.updatePos');




