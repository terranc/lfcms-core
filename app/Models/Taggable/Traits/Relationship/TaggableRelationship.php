<?php

namespace App\Models\Taggable\Traits\Relationship;
use App\Models\DocumentPost\DocumentPost;

/**
 * Class TaggableRelationship
 */
trait TaggableRelationship
{
    //

    public function posts()
    {
        return $this->morphedByMany(DocumentPost::class, 'taggable');
    }
}
