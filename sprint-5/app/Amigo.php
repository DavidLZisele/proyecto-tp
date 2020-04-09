<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amigo extends Model
{
    public $primaryKey = ["id_user","id_amigo"];
    public $guarded = [];
}
