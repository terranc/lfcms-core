<?php

namespace App\Models\Area;

use App\Models\Base;
use App\Models\Area\Traits\Scope\AreaScope;
use App\Models\Area\Traits\Attribute\AreaAttribute;
use App\Models\Area\Traits\Relationship\AreaRelationship;

class Area extends Base
{
    use AreaAttribute, AreaRelationship, AreaScope;
    //
    const COUNTRY = 0;
    const PROVINCE = 1;
    const CITY = 2;
    const AREA = 3;
}
