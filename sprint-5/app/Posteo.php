<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posteo extends Model
{
    public $guarded = [];
    public function usuario()
    {
        return $this->belongsTo("App\User","id_user");
    }
    public function likes()
    {
        return $this->hasMany("App\Like", "id_posteo");
    }
}
