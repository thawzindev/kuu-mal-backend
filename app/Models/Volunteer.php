<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Volunteer extends Authenticatable  implements JWTSubject
{
    use HasFactory,Notifiable;

    protected $guarded = [];

    // public $hidden = [
        // 'password', 'ip_address', 'user_agent'
    // ];


    public function scopeActive($query){
        return $query->where('active', 1);
    }

    public function state()
    {
        return $this->belongsTo(\App\Models\State::class);
    }

    public function township()
    {
    	return $this->belongsTo(\App\Models\Township::class);
    }

    public function label() 
    {
        if ($this->active == 1) return 'success';
        if ($this->active == 0) return 'danger';
    }

    public function buttonLabel() 
    {
        if ($this->active == 1) return 'warning';
        if ($this->active == 0) return 'success';
    }

    public function isActive()
    {
        return $this->active == 1 ? 'active' : 'unactive';
    }


    public function scopeFilter($query, $filter)
    {
        $filter->apply($query);
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
}
