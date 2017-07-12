<?php

namespace App\Models\Document;

use App\Events\AddRecycleBin;
use App\Models\Base;
use App\Models\Document\Traits\Scope\DocumentScope;
use App\Models\Document\Traits\Attribute\DocumentAttribute;
use App\Models\Document\Traits\Relationship\DocumentRelationship;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Base
{
    use DocumentAttribute, DocumentRelationship, DocumentScope, SoftDeletes;
    //

    protected $primaryKey = 'id';

    protected $dates = [
        'expired_at',
        'published_at',
    ];

    protected $casts = [
        'position' => 'array',
//        'is_comment' => 'boolean',
    ];

    protected $events = [
        'deleted' => AddRecycleBin::class,
    ];

}

