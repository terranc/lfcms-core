<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * App\Models\Base
 *
 * @mixin \Eloquent
 */
class Base extends Model
{
    protected $guarded = ['password_confirmation', 'from_url'];

    /**
     * 判断是否需要加载全局查询作用域（默认对于非 Http\Controller\Admin 的查询自动添加全局作用域）
     * @return bool
     */
    protected function isAddGlobalScopes() {
        $route = request()->route();
        return !($route && str_is("App\Http\Controllers\Admin*", $route->getAction()['namespace']) === FALSE);
    }

    protected static function boot()
    {
        parent::boot();
    }

    public function getMorphClassAlias($class)
    {
        $morphMap = Relation::morphMap();

        if (! empty($morphMap) && in_array($class, $morphMap)) {
            return array_search($class, $morphMap, true);
        }

        return $class;
    }

}
