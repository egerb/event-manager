<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;
use DateTime;

class Events extends Model
{

    //protected $hidden = ['id'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'title',
        'date',
        'place',
        'slug',
        'main_page',
        'contacts',
        'letter_agreement',
        'additional_info',
        'active',
        'email',
        'email_from',
        'email_subject',
        'email_text',
        'email_subject_success_payment',
        'email_text_success_payment',
        'email_subject_success_payment_admin',
        'email_text_success_payment_admin',
        'sms_user',
        'sms_pass',
        'sms_sender_from',
        'sms_text',
        'liqpay_id',
        'liqpay_secret',
        'liqpay_url',
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    protected $appends = ['all_laps','link'];

    public function getAllLapsAttribute() {
        return $this->laps()->count();
    }

    public function getLinkAttribute() {
        return env('APP_URL').'/event/'.$this->attributes['date'].'/'.$this->attributes['slug'];
    }

    public function getDateAttribute()
    {
        return $date = date('d-m-Y', strtotime($this->attributes['date']));
    }

    public function laps()
    {
        return $this->hasMany('App\Laps', 'event_id');
    }

    public function save(array $options = [])
    {

        if (empty($this->getAttribute('uid'))) parent::setAttribute('uid',Uuid::uuid1()->toString());
        parent::setAttribute('slug', str_slug(parent::getAttribute('place')));
        parent::save();

    }

    public function active_laps()
    {
        return $this->laps()->whereActive(1)->get();
    }


}
