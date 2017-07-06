<?php

namespace Tests\Unit\Models;

use App\Models\Config;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ConfigTest extends TestCase
{
    use DatabaseTransactions;

    private $arrayConfig = [
        'name' => 'array_config',
        'namespace' => 'global',
        'type' => 'array',
        'options' => '',
        'value' => '0:不可见
1:所有|人可见
2:会员可见',
        'remark' => '一个array配置',
    ];
    private $enumConfig = [
        'name' => 'enum_config',
        'namespace' => 'admin',
        'type' => 'enum',
        'options' => '0:不可见
1:所有|人可见
2:会员可见',
        'value' => '2',
        'remark' => '一个enum配置',
    ];
    private $stringConfig = [
        'name' => 'string_config',
        'namespace' => 'post',
        'type' => 'string',
        'options' => '',
        'value' => 'LFCMS',
        'remark' => '一个string配置',
    ];
    private $jsonConfig = [
        'name' => 'json_config',
        'namespace' => 'global',
        'type' => 'json',
        'options' => '',
        'value' => '{"abc": 123, "xyz": { "x": 1, "y": 2, "z": 3} }',
        'remark' => '一个json配置',
    ];

    /** @test */
    public function  save_and_parse_value_of_array_type()
    {
        $newConfig = Config::create($this->arrayConfig);
        return $this->assertEquals($this->arrayConfig['value'], revert_config($newConfig->value));
    }
    /** @test */
    public function  save_and_parse_option_of_enum_type()
    {
        $newConfig = Config::create($this->enumConfig);
        return $this->assertEquals(array_search($this->enumConfig['value'], parse_config($this->enumConfig['options'])), array_search($newConfig->value, $newConfig->options));
    }

    /** @test */
    public function save_and_parse_value_of_string_type()
    {
        $newConfig = Config::create($this->stringConfig);
        return $this->assertEquals($this->stringConfig['value'], $newConfig->value);
    }

    /** @test */
    public function save_and_parse_value_of_json_type()
    {
        $newConfig = Config::create($this->jsonConfig);
        return $this->assertEquals(json_decode($this->jsonConfig['value'])->xyz->z, $newConfig->value->xyz->z) &&
            $this->assertEquals(json_decode($this->jsonConfig['value'])->abc, $newConfig->value->abc);
    }
}
