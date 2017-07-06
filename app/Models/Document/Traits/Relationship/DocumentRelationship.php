<?php

namespace App\Models\Document\Traits\Relationship;
use App\Models\Comment\Comment;
use App\Models\DocumentModel\DocumentModel;
use App\Models\DocumentPost\DocumentPost;

/**
 * Class DocumentRelationship
 */
trait DocumentRelationship
{
    //
    public function post()
    {
        return $this->hasOne(DocumentPost::class, 'post_id', 'id');
    }

    /**
     * 关联查询所属评论
     * @param null $type 设定 commentable_type
     *
     * @return mixed
     */
    public function comments($type = null) {
        return $this->hasMany(Comment::class, 'commentable_id', 'id')->where(function($query) use ($type) {
            if ($type) {
                $query->where('commentable_type', $this->getMorphClassAlias($type));
            }
        })->orderBy('id', 'desc');
    }

    public function model()
    {
        return $this->belongsTo(DocumentModel::class, 'model_id','id');
    }
}
