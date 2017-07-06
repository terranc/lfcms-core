<?php

namespace App\Models\UserData\Traits\Attribute;

/**
 * Class UserDataAttribute
 */
trait UserDataAttribute
{
    //
    public function setLastLoginIpAttribute($value)
    {
        $this->attributes['last_login_ip'] = ip2long($value);
    }

    public function getLastLoginIpAttribute($value)
    {
        return long2ip($value);
    }

    public function getGenderAttribute($value)
    {
        return is_null($value) ? '保密' : $value;
    }

    public function setGenderAttribute($value) {
        if ($value === '保密') {
            $value = null;
        }
        $this->attributes['gender'] = $value;
    }
}
