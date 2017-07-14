<?php
/**
 * Created by PhpStorm.
 * User: terranc
 * Date: 17/7/14
 * Time: 12:16
 */

namespace App\Scopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;


class HideContentScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        return $builder->fields(['content'], true);
    }
}
