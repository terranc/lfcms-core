<?php

namespace App\Models;

use App\Traits\ScopeFieldsTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;

/**
 * App\Models\Base
 *
 * @mixin \Eloquent
 */
class Base extends Model
{
    use ScopeFieldsTrait;

    protected $guarded = ['password_confirmation', 'from_url'];

    // 定义全局的 scope，有别于 globalScopes，方便扩展类重载
    protected $scopes = [];

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
        $scopes = (new static)->scopes;
        foreach ($scopes as $key => $scope) {
            static::addGlobalScope(new $scope);
        }
    }

    public function getMorphClassAlias($class)
    {
        $morphMap = Relation::morphMap();

        if (! empty($morphMap) && in_array($class, $morphMap)) {
            return array_search($class, $morphMap, true);
        }

        return $class;
    }

//    public function __construct(array $attributes = [])
//    {
//        parent::__construct($attributes);
//    }


}
