<?php

namespace App\Models\Area\Traits\Scope;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class AreaScope
 */
trait AreaScope
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $parent_id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByPid(Builder $query, int $parent_id): Builder
    {
        return $query->where('parent_id', $parent_id);
    }
}
