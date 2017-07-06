<?php

namespace App\Models\DocumentPost;

use App\Models\Base;
use App\Traits\AssociateModelTrait;
use App\Traits\AssociateSaveTrait;
use App\Models\DocumentPost\Traits\Scope\DocumentPostScope;
use App\Models\DocumentPost\Traits\Attribute\DocumentPostAttribute;
use App\Models\DocumentPost\Traits\Relationship\DocumentPostRelationship;

class DocumentPost extends Base
{
    use DocumentPostAttribute, DocumentPostRelationship, DocumentPostScope;
    //
    use AssociateSaveTrait, AssociateModelTrait;

    protected $primaryKey = 'post_id';
    public $incrementing = false;

    protected $dates = [
        'top_at',
    ];
    protected $touches = [
        'document',
    ];
}
