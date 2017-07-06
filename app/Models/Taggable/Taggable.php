<?php

namespace App\Models\Taggable;

use App\Models\Base;
use App\Models\Taggable\Traits\Scope\TaggableScope;
use App\Models\Taggable\Traits\Attribute\TaggableAttribute;
use App\Models\Taggable\Traits\Relationship\TaggableRelationship;

class Taggable extends Base
{
    use TaggableAttribute, TaggableRelationship, TaggableScope;
    //
    protected $primaryKey = 'tag_id';
    public $timestamps = false;

    protected $dates = [
        'created_at',
    ];

}
