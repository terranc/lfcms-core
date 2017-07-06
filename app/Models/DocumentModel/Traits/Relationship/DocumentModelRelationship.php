<?php

namespace App\Models\DocumentModel\Traits\Relationship;
use App\Models\Document\Document;
use App\Models\DocumentPost\DocumentPost;

/**
 * Class DocumentModelRelationship
 */
trait DocumentModelRelationship
{
    //
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function posts()
    {
        return $this->hasManyThrough(DocumentPost::class, Document::class, 'model_id', 'id', 'id');
    }
}
