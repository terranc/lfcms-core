<?php

namespace App\Models;

use App\Traits\ScopePositionTrait;
use App\Traits\StatusAttributeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Base
{
    protected $primaryKey = 'id';
    use SoftDeletes, StatusAttributeTrait, ScopePositionTrait;

    protected $casts = [
        'position' => 'array',
    ];

    public function post()
    {
        return $this->hasOne(Post::class, 'id', 'id');
    }
}
