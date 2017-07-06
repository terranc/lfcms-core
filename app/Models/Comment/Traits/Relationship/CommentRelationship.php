<?php

namespace App\Models\Comment\Traits\Relationship;

/**
 * Class CommentRelationship
 */
trait CommentRelationship
{
    //
    public function commentable()
    {
        return $this->morphTo();
    }
}
