<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\Schema;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Database\Eloquent\Model::unguard();
        Schema::disableForeignKeyConstraints();

        // 全局配置
        $this->call(GlobalConfigSeeder::class);

        $this->call(DocumentModelSeeder::class);

        // 用户
        $this->call(UserGroupSeeder::class);
        $this->call(UserPermissionGroupSeeder::class);

        // 后台管理
        $this->call(AdminRoleSeeder::class);

        // 组件
        $this->call(AdvertCategorySeeder::class);

        // 省市区
//        $this->call(AreasTableSeeder::class);
        Schema::enableForeignKeyConstraints();

        \Illuminate\Database\Eloquent\Model::reguard();
    }
}
