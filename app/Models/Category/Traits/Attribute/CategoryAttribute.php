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
        return $value ? \Storage::url($value) : '';
    }
    public function setMetaAttribute($value)
    {
        $this->attributes['meta'] = trim($value) ?: null;
    }

    public function getMetaAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getListTplAttribute($value)
    {
        return $value ?? 'document/index';
    }

    public function getShowTplAttribute($value)
    {
        return $value ?? 'document/show';
    }

    public function getPathAttribute()
    {
        $path = [];

        return $path;
    }
}
