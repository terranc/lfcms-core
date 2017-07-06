<?php

namespace App\Models\Area\Traits\Relationship;

/**
 * Class AreaRelationship
 */
trait AreaRelationship
{
    /**
     * 上级区域
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent()
    {
        return $this->belongsTo(__CLASS__, 'id', 'parent_code', 'code');
    }

    /**
     * 关联子区域
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(__CLASS__, 'parent_code', 'code');
    }

    public function countries() {
        return $this->where('level', $this::COUNTRY);
    }

    public function provinces($countryCode = '086')
    {
        return $this->hasMany(__CLASS__, 'parent_code', 'code')->where('parent_code', $countryCode)->where('level', $this::PROVINCE);
    }
    public function cities($provinceCode = '')
    {
        return $this->hasMany(__CLASS__, 'parent_code', 'code')->where('parent_code', $provinceCode)->where('level', $this::CITY);
    }
    public function areas($cityCode = '')
    {
        return $this->hasMany(__CLASS__, 'parent_code', 'code')->where('parent_code', $cityCode)->where('level', $this::AREA);
    }
}
