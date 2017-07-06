<?php

namespace App\Models\RecycleBin;

use App\Models\Base;
use App\Models\RecycleBin\Traits\Scope\RecycleBinScope;
use App\Models\RecycleBin\Traits\Attribute\RecycleBinAttribute;
use App\Models\RecycleBin\Traits\Relationship\RecycleBinRelationship;

class RecycleBin extends Base
{
    use RecycleBinAttribute, RecycleBinRelationship, RecycleBinScope;
    //
    protected $table = 'recycle_bin';

    public $timestamps = false;

    protected $dates = [
        'created_at',
    ];
}
