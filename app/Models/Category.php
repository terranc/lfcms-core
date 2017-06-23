<?php

namespace App\Models;

use App\Traits\StatusAttributeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Base
{
    use SoftDeletes, StatusAttributeTrait;

    protected $casts = [
        'meta' => 'array',
    ];

    public $typeOptions = [
        'link' => '链接',
        'page' => '单页',
        'list' => '列表',
    ];

    public function getTypeOptionsAttribute()
    {
        return $this->typeOptions;
    }
}
