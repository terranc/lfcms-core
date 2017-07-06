<?php

namespace App\Models\Config\Traits\Attribute;

/**
 * Class ConfigAttribute
 */
trait ConfigAttribute
{
    protected $typeLists;

    /**
     * @return mixed
     */
    public function getTypeLists()
    {
        return $this->typeLists ?: collect(self::TYPES)->combine(array_map(function($item) { return strtoupper($item); }, self::TYPES))->all();
    }
    public function getTypeListsText()
    {
        $arr = [
            'string' => '文本',
            'json' => 'JSON',
            'enum' => '枚举',
            'array' => '数组',
        ];
        return array_map(function($item) use ($arr) {
            return $arr[strtolower($item)];
        }, $this->getTypeLists());
    }

    public function getTypeTextAttribute($value)
    {
        return $this->getTypeListsText()[$this->attributes['type']];
    }

    public function setValueAttribute($value)
    {
        switch ($this->attributes['type']) {
            case 'array':
                $this->attributes['value'] = revert_array_config(parse_array_config($value));
                break;
            case 'json':
            default:
                $this->attributes['value'] = trim($value);
                break;
        }
    }

    public function getValueAttribute($value)
    {
        switch ($this->attributes['type']) {
            case 'array':
                return parse_array_config($value);
            case 'json':
                return json_decode($value, true);
            case 'enum':
                return parse_enum_config($value);
            default:
                return $value;
        }
    }

    public function getValueOriginalAttribute()
    {
        return $this->attributes['value'];
    }
}
