<?php

namespace App\Models;

use App\Traits\AssociateCreateTrait;

class Post extends Base
{
    use AssociateCreateTrait;

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $dates = [
        'top_at',
    ];
    protected $touches = [
        'document',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class, 'id', 'id');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }


//    protected static function boot() {
//        parent::boot();
//        // 创建 Post 时可直接创建对应 Document 记录
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
