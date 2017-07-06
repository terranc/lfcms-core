<?php

namespace App\Models\DocumentPost\Traits\Relationship;
use App\Models\Comment\Comment;
use App\Models\Document\Document;
use App\Models\Tag\Tag;

/**
 * Class PostRelationship
 */
trait DocumentPostRelationship
{
    //
    public function document()
    {
        return $this->belongsTo(Document::class, 'post_id', 'id');
    }

    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }


//    protected static function boot() {
//        parent::boot();
//        // 创建 DocumentPost 时可直接创建对应 Document 记录
////        static::creating(function($data) {
////            $data->documentData = array_only($data->toArray(), Schema::getColumnListing((new Document)->getTable()));
////            $instance = new static;
////            $document = Document::create($data->documentData);
////            if ($document) {
////                $data->attributes = array_only($data->toArray(), Schema::getColumnListing($instance->getTable()));
////                $data->attributes['id'] = $document->id;
////                return true;
////            } else {
////                return false;
////            }
////        });
//    }
}
