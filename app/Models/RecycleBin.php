<?php

namespace App\Models;

class RecycleBin extends Base
{
    //
    protected $table = 'recycle_bin';

    public $timestamps = false;

    protected $dates = [
        'created_at',
    ];
}
