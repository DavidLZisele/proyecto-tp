<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $guarded = [];
    protected $table = "comentarios";
    public function usuario()
    {
        return $this->belongsTo('App\User', "id_user");
    }
}
