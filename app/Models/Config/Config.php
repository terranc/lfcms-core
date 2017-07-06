<?php

namespace App\Models\Config;

use App\Models\Base;
use App\Models\Config\Traits\Scope\ConfigScope;
use App\Models\Config\Traits\Attribute\ConfigAttribute;
use App\Models\Config\Traits\Relationship\ConfigRelationship;
use Illuminate\Support\Facades\Cache;

class Config extends Base
{
    use ConfigAttribute, ConfigRelationship, ConfigScope;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    const TYPES = ['string', 'enum', 'array', 'json'];


    protected static function boot() {
        parent::boot();
        // 每次添加、更新配置都更新缓存
        static::saved(function() {
            Config::forgetCache();
            Config::loadConfigs();
        });
    }
    /**
     * 删除缓存
     * @return mixed
     */
    public static function forgetCache()
    {
        return Cache::forget('__configs');
    }

    /**
     * 缓存并加载配置
     * @return mixed
     */
    public static function loadConfigs()
    {
        if (env('app_debug')) {
            $configs = Config::all();
        } else {
            $configs = Cache::rememberForever('__configs', function () {
                return Config::all();
            });
        }
        return $configs->each(function($item) {
            switch ($item->type) {
                case 'enum':
                    config([
                        $item->namespace . '.' . $item->name => $item->value,
                    ]);
                    break;
                default:
                    config([
                        $item->namespace . '.' . $item->name => $item->value,
                    ]);
                    break;
            }
        });
    }
}
