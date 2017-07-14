<?php

namespace App\Models\Category;

use App\Events\AddRecycleBin;
use App\Models\Base;
use App\Models\Category\Traits\Scope\CategoryScope;
use App\Models\Category\Traits\Attribute\CategoryAttribute;
use App\Models\Category\Traits\Relationship\CategoryRelationship;
use App\Scopes\HideContentScope;
use App\Traits\AttributeStatusTrait;
use App\Traits\ScopeHideContentTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Base
{
    use CategoryAttribute, CategoryRelationship, CategoryScope;
    //
    use SoftDeletes, AttributeStatusTrait;

    protected $parent = 'parent_id';

    protected $casts = [
        'meta' => 'array',
//        'is_system' => 'boolean',
//        'is_check' => 'boolean',
//        'is_comment' => 'boolean',
//        'is_display' => 'boolean',
    ];

//    protected $hidden = [
//        'content',
//    ];

    const TYPES = [
        'list' => '列表',
        'page' => '单页',
        'link' => '链接',
    ];

    const DISPLAY = [
        '隐藏',
        '显示',
    ];

    const CHECK = [
        '不需要',
        '需要',
    ];

    const COMMENT = [
        '不允许',
        '允许',
    ];

    protected $events = [
        'deleted' => AddRecycleBin::class,
    ];

    protected $scopes = [
        HideContentScope::class,
    ];
}
