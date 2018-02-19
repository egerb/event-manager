<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Laps extends Model
{


    //protected $hidden = ['id'];

    protected $dates = [

    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    protected $fillable = [
        'title',
        'price',
        'active',
        'age_from',
        'age_to',
        'participants_limit',
        'additional_conditions',
        'partisipant_start_number',
        'event_id'
    ];

    protected $appends = ['count_promo','count_participants'];

    public function getCountPromoAttribute()
    {
        return $this->promo()->count();
    }

    public function getCountParticipantsAttribute()
    {
        return $this->participants()->count();
    }


    public function event()
    {
        return $this->belongsTo('App\Events', 'event_id');

    }

    public function promo()
    {
        return $this->hasMany('App\PromoCodes','lap_id');
    }

    public function participants()
    {
        return $this->hasMany('App\Participants','lap_id');
    }

    public function save(array $options = [])
    {

        if (empty($this->getAttribute('uid'))) parent::setAttribute('uid',Uuid::uuid1()->toString());
        parent::save();

    }




}
