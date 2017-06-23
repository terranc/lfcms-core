<?php

namespace App\Models;


class DocumentModel extends Base
{
    public function post()
    {
        return $this->hasOne(Post::class, 'id', 'id');
    }
}
