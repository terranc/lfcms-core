<?php

namespace App\Models\Area\Traits\Attribute;

/**
 * Class AreaAttribute
 */
trait AreaAttribute
{
    protected $levelLists;

    /**
     * @return mixed
     */
    public function getLevelLists()
    {
        return $this->levelLists ?: [
            self::COUNTRY => '国家',
            self::PROVINCE => '省份',
            self::CITY => '城市',
            self::AREA => '区',
        ];
    }
    public function setLevelListsAttribute($value)
    {
        $this->levelLists = $value;
    }

    public function getLevelArrAttribute()
    {
        return $this->getLevelLists();
    }
    public function getLevelTextAttribute()
    {
        return $this->getLevelArrAttribute()[$this->level];
    }
}
