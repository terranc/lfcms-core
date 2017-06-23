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
        if (App::environment() === 'production') {
            exit('兄弟,这是正式环境!');
        }
        \Illuminate\Database\Eloquent\Model::unguard();
        // $this->call(UsersTableSeeder::class);
        Schema::disableForeignKeyConstraints();
        factory(\App\Models\User::class, 50)->create();
        factory(\App\Models\Tag::class, 10)->create();
        factory(\App\Models\Category::class, 5)->create();
        factory(\App\Models\Document::class, 50)->create()->each(function($document) {
            $document->post()->save(factory(\App\Models\Post::class)->make(['id' => $document->id]));
//            $document->post()->tag()->save(factory(\App\Models\Tag::class)->make(['object_id' => $document->id]));
        });
        Schema::enableForeignKeyConstraints();
        \Illuminate\Database\Eloquent\Model::reguard();
    }
}
