<?php

namespace App\Http\Middleware;
use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class ConvertEmptyStringsToNull extends TransformsRequest {
    public function transform($key, $value)
    {
        if (request()->getRealMethod() == 'GET') {
            return $value;
        } else {
            return is_string($value) && $value === '' ? null : $value;
        }
    }
}
