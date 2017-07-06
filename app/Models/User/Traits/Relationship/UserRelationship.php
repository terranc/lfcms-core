<?php

namespace App\Models\User\Traits\Relationship;
use App\Models\UserData\UserData;

/**
 * Class UserRelationship
 */
trait UserRelationship
{
    //
    public function datas()
    {
        return $this->hasOne(UserData::class, 'user_id');
    }
}
