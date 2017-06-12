<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Base
{
    public function getStatusTextAttribute($value)
    {
        return $this->getStatusArrAttribute()[$this->status];
    }
    public function getStatusArrAttribute()
    {
        return ['禁用', '启用'];
    }

//    public function setStatusAttribute($value)
//    {
//        $this->attributes['status'] = implode(',', $value);
//    }
}
