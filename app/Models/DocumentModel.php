<?php

namespace App\Models;


use App\Traits\StatusAttributeTrait;

class DocumentModel extends Base
{
    use StatusAttributeTrait;

    protected $casts = [
        'meta' => 'array',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function posts()
    {
        return $this->hasManyThrough(Post::class, Document::class, 'model_id', 'id', 'id');
    }
}
