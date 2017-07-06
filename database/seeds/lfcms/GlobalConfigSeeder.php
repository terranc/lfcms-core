<?php

use Illuminate\Database\Seeder;

class GlobalConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Config\Config::create([
            'name' => 'site_name',
            'namespace' => 'global',
            'type' => 'string',
            'remark' => '站点名称',
            'value' => 'LFCMS',
        ]);
//        \App\Models\Config\Config::create([
//            'name' => 'upload_path',
//            'namespace' => 'global',
//            'type' => 'string',
//            'remark' => '上传文件夹',
//            'value' => 'public/upfile',
//        ]);
    }
}
