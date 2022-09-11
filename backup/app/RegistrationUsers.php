<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class RegistrationUsers extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $guarded = ['email_verfied_at'];
    protected $table = 't_registrasi_users';
    public $timestamps = false;

    /**
     * Has Many relation ship with Kta Model
     *
     * @return string
     */
    public function kta()
    {
        return $this->hasMany(\App\Kta::class);
    }

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    // /**
    //  * The channels the user receives notification broadcasts on.
    //  *
    //  * @return string
    //  */
    // public function receivesBroadcastNotificationsOn()
    // {
    //     return 'users.'.$this->id;
    // }
}
