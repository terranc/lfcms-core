<?php

use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\User\User::class, 50)->create();
        factory(\App\Models\Tag\Tag::class, 10)->create();
        factory(\App\Models\Category\Category::class, 5)->create();
        factory(\App\Models\Document\Document::class, 50)->create()->each(function($document) {
            $document->post()->save(factory(\App\Models\DocumentPost\DocumentPost::class)->make(['post_id' => $document->id]));
        });
        factory(\App\Models\Comment\Comment::class, 100)->states('post')->create();
    }
}
