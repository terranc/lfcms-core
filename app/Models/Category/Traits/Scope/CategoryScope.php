<?php

namespace App\Models\Category\Traits\Scope;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class CategoryScope
 */
trait CategoryScope
{
    public function scopeIsSystem(Builder $builder)
    {
        return $builder->where('is_system', 1);
    }
    public function scopeAllowComment(Builder $builder)
    {
        return $builder->where('is_comment', 1);
    }
    public function scopeMustCheck(Builder $builder)
    {
        return $builder->where('is_check', 1);
    }
    public function scopeIsDisplay(Builder $builder)
    {
        return $builder->where('is_display', 1);
    }
}
