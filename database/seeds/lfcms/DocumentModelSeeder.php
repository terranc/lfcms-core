<?php

use Illuminate\Database\Seeder;

class DocumentModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\DocumentModel\DocumentModel::class, 1)->states('post')->create();
    }
}
