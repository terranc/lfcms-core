<?php

namespace App\Models;

use App\Traits\StatusAttributeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Base
{
    use SoftDeletes, StatusAttributeTrait;
}
