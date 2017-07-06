<?php

namespace App\Models\Category\Traits\Attribute;

/**
 * Class CategoryAttribute
 */
trait CategoryAttribute
{
    public function getTypeLists()
    {
        return self::TYPES;
    }

    public function getTypeTextAttribute()
    {
        return $this->getTypeLists()[$this->attributes['type']];
    }

    public function getThumbAttribute($value)
    {
        return \Storage::url($value);
    }
}
