<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    protected $guarded = ['password_confirmation', 'from_url'];
}
