<?php

namespace App\Models\User;

use App\Models\Base;
use App\Models\UserData\UserData;
use App\Traits\AttributeStatusTrait;
use App\Models\User\Traits\Scope\UserScope;
use App\Models\User\Traits\Attribute\UserAttribute;
use App\Models\User\Traits\Relationship\UserRelationship;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Base
{
    use UserAttribute, UserRelationship, UserScope;
    //
    use SoftDeletes, AttributeStatusTrait;


    protected static function boot() {
        parent::boot();
        static::created(function($data) {
            UserData::firstOrCreate([
                'user_id' => $data->id,
            ]);
        });
    }
}
