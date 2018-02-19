<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class PromoCodes extends Model
{

    //protected $hidden = ['id'];

    protected $fillable = [
        'lap_id',
        'promo_code',
        'discount_percent',
        'used'
    ];

    protected $casts = [
        'used' => 'boolean'
    ];

    protected $appends = ['lap_name'];

    public function getLapNameAttribute()
    {
        return ($this->lap()->count() > 0) ? $this->lap()->get()->pluck('title')[0]:null;
    }

    public function lap()
    {
        return $this->belongsTo('App\Laps','lap_id');
    }

    public function save(array $options = [])
    {

        if (empty($this->getAttribute('uid'))) parent::setAttribute('uid',Uuid::uuid1()->toString());
        parent::save();

    }
}
