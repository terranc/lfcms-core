<?php

namespace App\Traits;


/**
 * Class ScopePositionTrait
 * @package App\Traits
 */
trait ScopePositionTrait {

    public static function scopePosition($query, $position)
    {
        // 支持多种传参方式， 如：
        //      ->position(1,2,4,6)
        //      ->position([1,2,4,6])
        //      ->position('home', 'list')
        //      ->position(['home', 'list'])
        if (!is_array($position)) {
            $position = array_slice(func_get_args(), 1);
        }
        $query->where(function($q) use ($position) {
            foreach ((array)$position as $k => $v) {
                $q->orWhere("position->pos__${v}", true);
            }
        });
    }


    public function getPositionAttribute($value)
    {
        return json_decode($value, true);
    }


    /**
     *
     *
     * @param array $value 如：['home', 'list']、[1,3,4,5]
     */
    public function setPositionAttribute($value = [])
    {
        if (is_array($value)) {
            $position = [];
            foreach ($value as $k => $v) {
                $position['pos__' . $v] = true;
            }
            $this->attributes['position'] = json_encode($position);
        } else {
            $this->attributes['position'] = null;
        }
    }

}
