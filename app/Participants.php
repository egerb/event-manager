<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Participants extends Model
{

    //protected $hidden = ['id'];

    protected $fillable = [
        'lap_id',
        'user_id',
        'payment',
        'tracker_id',
        'additional_info',
        'additional_distance'
    ];

    public function save(array $options = [])
    {

        if (empty($this->getAttribute('uid'))) parent::setAttribute('uid',Uuid::uuid1()->toString());
        parent::save();

    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /*public function laps()
    {
        return $this->hasMany('App\Laps','lap_id');
    }*/



}
