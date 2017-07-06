<?php

namespace App\Models\Document\Traits\Scope;
use App\Traits\ScopePositionTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class DocumentScope
 */
trait DocumentScope
{
    //
    use ScopePositionTrait;

    protected static function boot()
    {
        parent::boot();
        if (!(new static)->isAddGlobalScopes()) {
            // 查询已发布的内容
            static::addGlobalScope('published', function(Builder $builder) {
                $builder->whereNull('published_at')->orWhere('published_at', '>=', Carbon::now());
            });
            // 查询未过期的内容
            static::addGlobalScope('expired', function(Builder $builder) {
                $builder->whereNull('expired_at')->orWhere('expired_at', '<=', Carbon::now());
            });
            // 查询已启用的内容
            static::addGlobalScope('status', function(Builder $builder) {
                $builder->where('status','>',0);
            });
        }
    }
}
