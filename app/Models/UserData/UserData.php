<?php

namespace App\Models\UserData;

use App\Models\Base;
use App\Models\UserData\Traits\Scope\UserDataScope;
use App\Models\UserData\Traits\Attribute\UserDataAttribute;
use App\Models\UserData\Traits\Relationship\UserDataRelationship;

class UserData extends Base
{
    use UserDataAttribute, UserDataRelationship, UserDataScope;
    //
}
