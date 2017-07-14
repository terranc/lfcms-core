<?php
/**
 * Created by PhpStorm.
 * User: terranc
 * Date: 17/7/13
 * Time: 15:48
 */

namespace App\Traits;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

trait ScopeFieldsTrait
{

    /**
     * 快捷指定搜索字段，支持排除
     * @param       $query
     * @param array $fields
     * @param bool  $exclude
     */
    public function scopeFields($query, $fields = [], $exclude = false)
    {
        if (!(is_bool($fields) && $fields === FALSE)) {
            if (is_string($fields)) {
                $fields = explode(',', $fields);
            }
            $tableFields =  Cache::tags(['table_column'])->rememberForever('table_column:' . $this->getTable(), function(){
                return Schema::getColumnListing($this->getTable());
            });
            if ($exclude) {
                $query->select(array_flip(array_except(array_flip($tableFields), $fields)));
            } else {
                $query->select($fields);
            }
        }
    }
}
