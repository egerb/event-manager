<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Profiles extends Model
{
    //protected $hidden = ['id'];

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'birth_date',
        'gender',
        'city',
        'contacts_data',
        'team',
        'club',
        't_shirt_size',
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

}
