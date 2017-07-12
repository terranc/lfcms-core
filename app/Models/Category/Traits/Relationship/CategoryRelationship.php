<?php

namespace App\Models\Category\Traits\Relationship;

/**
 * Class CategoryRelationship
 */
trait CategoryRelationship
{
    public function parent()
    {
        return $this->belongsTo(__CLASS__, 'id', 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(__CLASS__, 'parent_id', 'id');
    }
}
