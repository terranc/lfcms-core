<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Area\Area;
use App\Exceptions\GeneralException;

class AreaRepository extends BaseRepository
{
    public $model;
    const COUNTRY = Area::COUNTRY;
    const PROVINCE = Area::PROVINCE;
    const CITY = Area::CITY;
    const AREA = Area::AREA;

    public function __construct(Area $area)
    {
        $this->model = $area;
    }

    /**
     * 获取国家列表
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getCountries()
    {
        return $this->model->countries()->get();
    }

    /**
     * 获取身份列表
     * @param string $countryCode
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getProvinces($countryCode = '086')
    {
        return $this->model->provinces($countryCode)->get();
    }

    /**
     * 获取城市列表
     * @param string $provinceCode
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getCities($provinceCode = '')
    {
        return $this->model->cities($provinceCode)->get();
    }

    /**
     * 获取区列表
     * @param string $cityCode
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAreas($cityCode = '')
    {
        return $this->model->areas($cityCode)->get();
    }

    public function getTree()
    {
        $countries = $this->getCountries();
        $json = [];
        foreach ($countries as $country) {
            $json[$country->code] = $country->toArray();
            $provinces = $country->provinces($country->code)->get();
            if ($provinces) {
                foreach ($provinces as $province) {
                    $json[$country->code]['items'][$province->code] = $province->toArray();
                    $cities = $province->cities($province->code)->get();
                    if ($cities) {
                        foreach ($cities as $city) {
                            $json[$country->code]['items'][$province->code]['items'][$city->code] = $city->toArray();
                            $areas = $city->areas($city->code)->get();
                            if ($areas) {
                                foreach ($areas as $area) {
                                    $json[$country->code]['items'][$province->code]['items'][$city->code]['items'][$area->code] = $area->toArray();
                                }
                            }
                        }
                    }
                }
            }
        }
        return $json;
    }
}
