<?php

use Illuminate\Database\Seeder;

class AdvertCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Category\Category::class, 1)->states('advert')->create();
    }
}
