<?php

namespace App\Models;

use App\Traits\StatusAttributeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Base
{
    use SoftDeletes, StatusAttributeTrait;

    public function datas()
    {
        return $this->hasOne(UserData::class, 'user_id');
    }

    protected static function boot() {
        parent::boot();
        static::created(function($data) {
            UserData::firstOrCreate([
                'user_id' => $data->id,
            ]);
        });
    }

//    public function setStatusAttribute($value)
//    {
//        $this->attributes['status'] = implode(',', $value);
//    }
}
