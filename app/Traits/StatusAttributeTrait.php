<?php

namespace App\Traits;


/**
 * Trait StatusAttributeTrait
 *
 * @package App\Traits
 */
trait StatusAttributeTrait
{
    protected $statusLists;

    /**
     * @param mixed $value
     */
    public function setStatusListsAttribute($value)
    {
        $this->statusLists = $value;
    }

    public function getStatusArrAttribute()
    {
        return $this->statusLists ?: ['禁用', '启用'];
    }
    public function getStatusTextAttribute()
    {
        return $this->getStatusArrAttribute()[$this->status];
    }
}
