<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'surname','photo','strikes'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function amigosMiSolicitud()
    {
       return $this->belongsToMany("App\User","amigos","id_user","id_amigo")->wherePivot('respuesta',1);
    }
    public function amigosSuSolicitud()
    {
       return $this->belongsToMany("App\User","amigos","id_amigo","id_user")->wherePivot('respuesta',1);
    }
    public function miSolicitudes()
    {
       return $this->belongsToMany("App\User","amigos","id_amigo","id_user")->wherePivot('respuesta',3);
    }
    public function envioSolicitudes()
    {
       return $this->belongsToMany("App\User","amigos","id_user","id_amigo")->wherePivot('respuesta',3);
    }
    public function posteos()
    {
        return $this->hasMany("App\Posteo","id_user");
    }
    public function likes()
    {
        return $this->hasMany("App\Likes","id_user");
    }
    public function fotos()
    {
        return $this->hasMany("App\UsuarioFoto", "id_user");
    }
}
