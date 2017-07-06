<?php

namespace App\Models\Tag;

use App\Traits\AttributeStatusTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag\Traits\Scope\TagScope;
use App\Models\Tag\Traits\Attribute\TagAttribute;
use App\Models\Tag\Traits\Relationship\TagRelationship;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use TagAttribute, TagRelationship, TagScope;
    //
    use SoftDeletes, AttributeStatusTrait;
}
