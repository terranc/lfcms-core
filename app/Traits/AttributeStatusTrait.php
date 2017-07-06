<?php

namespace App\Traits;


/**
 * Trait StatusAttributeTrait
 *
 * @package App\Traits
 */
trait AttributeStatusTrait
{
    protected $statusLists;

    /**
     * @return mixed
     */
    public function getStatusLists()
    {
        return $this->statusLists ?: ['禁用', '启用'];
    }

    /**
     * @param mixed $value
     */
    public function setStatusListsAttribute($value)
    {
        $this->statusLists = $value;
    }
    public function getStatusArrAttribute()
    {
        return $this->getStatusLists();
    }
    public function getStatusTextAttribute()
    {
        return $this->getStatusArrAttribute()[$this->status];
    }

    /**
     * 状态范围查询（可传参指定要限定的状态范围，默认为大于0的内容）
     * @param      $query
     * @param array $status
     *
     * @return mixed
     */
    public function scopeStatus($query, $status = [])
    {
        if (!empty($status)) {
            return $query->whereIn('status', (array) $status);
        }
        return $query->where('status','>',0);
    }
}
