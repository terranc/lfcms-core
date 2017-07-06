<?php

namespace App\Models\Comment;

use App\Models\Base;
use App\Models\Comment\Traits\Scope\CommentScope;
use App\Models\Comment\Traits\Attribute\CommentAttribute;
use App\Models\Comment\Traits\Relationship\CommentRelationship;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Base
{
    use CommentAttribute, CommentRelationship, CommentScope;
    //
    use SoftDeletes;

    protected $dates = [
        'top_at',
    ];
}
