<?php

namespace App\Models\Category;

use App\Events\AddRecycleBin;
use App\Models\Base;
use App\Models\Category\Traits\Scope\CategoryScope;
use App\Models\Category\Traits\Attribute\CategoryAttribute;
use App\Models\Category\Traits\Relationship\CategoryRelationship;
use App\Traits\AttributeStatusTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Base
{
    use CategoryAttribute, CategoryRelationship, CategoryScope;
    //
    use SoftDeletes, AttributeStatusTrait;

    protected $casts = [
        'meta' => 'array',
        'is_system' => 'boolean',
        'is_check' => 'boolean',
        'is_comment' => 'boolean',
        'is_display' => 'boolean',
    ];

    const TYPES = [
        'list' => '列表',
        'page' => '单页',
        'link' => '链接',
    ];

    protected $events = [
        'deleted' => AddRecycleBin::class,
    ];
}
