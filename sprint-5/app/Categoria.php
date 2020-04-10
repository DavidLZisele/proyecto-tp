<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public $table= "categorias";
    public $timestamps= false;
    public $primaryKey = "id";
    public $guarded = [];
}
