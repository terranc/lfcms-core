<?php

namespace App\Models\UserData\Traits\Relationship;
use App\Models\User\User;


/**
 * Class UserDataRelationship
 */
trait UserDataRelationship
{
    //

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
