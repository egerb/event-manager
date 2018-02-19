<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Ramsey\Uuid\Uuid;


class User extends Authenticatable
{
    use Notifiable;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'id', 'type'
    ];

    protected $appends = ['profile'];
    public function getProfileAttribute()
    {
        return $this->profile()->first();
    }

    public function save(array $options = [])
    {

        parent::setAttribute('uid',Uuid::uuid1()->toString());
        parent::save();

    }
    public function participants()
    {
        return $this->belongsToMany('App\Participants','participants', 'user_id');
    }
    public function profile()
    {
        return $this->hasOne('App\Profiles', 'user_id');
    }
}
