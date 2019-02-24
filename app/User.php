<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];
    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var array
    //  */
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class, 'owner_id')->latest('updated_at');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // $role is a string not Role object
    public function assignRole($role)
    {
        return $this->roles()->save(
            Role::whereName($role)->firstOrFail()
       );
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        foreach ($role as $r) {
            if ($this->hasRole($r->name)) {
                return true;
            }
        }

        return false;
    }

    public function avatar()
    {
        return $this->avatar_path ?: 'avatars/default_avatar.jpg';
    }
}
