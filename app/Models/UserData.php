<?php

namespace App\Models;

class UserData extends Base
{
    //
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $casts = [
        'meta' => 'array',
    ];

    protected $touches = [
        'user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function setLastLoginIpAttribute($value)
    {
        $this->attributes['last_login_ip'] = ip2long($value);
    }

    public function getLastLoginIpAttribute($value)
    {
        return long2ip($value);
    }
}
