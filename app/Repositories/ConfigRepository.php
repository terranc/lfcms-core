<?php

namespace App\Repositories;

use App\Models\Config\Config;
use App\Exceptions\GeneralException;

class ConfigRepository extends BaseRepository
{
    public $model;

    public function __construct(Config $config)
    {
        $this->model = $config;
    }

    public function getNamespaceLists()
    {
        return $this->model->groupBy('namespace')->select('namespace')->get('namespace')->pluck('namespace')->toArray() ?? [];
    }
}
