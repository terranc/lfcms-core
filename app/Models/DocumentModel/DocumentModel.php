<?php

namespace App\Models\DocumentModel;

use App\Models\Base;
use App\Traits\AttributeStatusTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\DocumentModel\Traits\Scope\DocumentModelScope;
use App\Models\DocumentModel\Traits\Attribute\DocumentModelAttribute;
use App\Models\DocumentModel\Traits\Relationship\DocumentModelRelationship;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentModel extends Base
{
    use DocumentModelAttribute, DocumentModelRelationship, DocumentModelScope;
    //
    use AttributeStatusTrait;

    protected $casts = [
        'meta' => 'array',
    ];
}
