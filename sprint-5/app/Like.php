<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = "likes";
    protected $guarded = [];
    public function posteo()
    {
        return $this->belongsTo("App\Posteo", "id_posteo");
    }
    public function usuario()
    {
        return $this->belongsTo("App\User", "id_user");
    }
}
