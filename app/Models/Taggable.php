<?php

namespace App\Models;

class Taggable extends Base
{
    protected $primaryKey = ['taggable_type', 'taggable_id', 'tag_id'];
    public $timestamps = false;

    protected $dates = [
        'created_at',
    ];

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }
}
