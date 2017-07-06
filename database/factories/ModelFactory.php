<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\Models\User\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'nickname' => $faker->name,
        'mobile' => $faker->unique()->phoneNumber,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'status' => 1,
    ];
});
$factory->state(\App\Models\User\User::class, 'admin', function() {
    return [
        'username' => 'admin',
        'type' => 'admin',
        'email' => 'admin@admin.com',
        'nickname' => 'Admin',
        'mobile' => '13688888888',
        'password' => bcrypt('admin'),
        'status' => 1,
    ];
});
$factory->define(\App\Models\Category\Category::class, function(Faker\Generator $faker) {
    return [
        'type' => 'list',
        'flag' => $faker->unique()->word,
        'title' => $faker->title,
        'description' => $faker->sentence,
        'path' => '',
        'thumb' => $faker->imageUrl(),
        'is_display' => random_int(0, 1),
        'status' => 1,
    ];
});
$factory->state(\App\Models\Category\Category::class, 'advert', function(Faker\Generator $faker) {
    return [
        'type' => 'list',
        'flag' => 'advert',
        'title' => '广告位',
        'description' => '存放应用内广告位',
        'path' => '',
        'is_system' => true,
        'thumb' => '',
        'is_display' => 0,
        'status' => 1,
    ];
});

$factory->define(\App\Models\Tag\Tag::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'weight' => random_int(1,100),
        'status' => 1,
    ];
});

$factory->define(\App\Models\Document\Document::class, function(Faker\Generator $faker) {
    $categoryIds = \App\Models\Category\Category::all('id')->pluck('id')->toArray();
    return [
        'user_id' => random_int(1, 50),
        'title' => $faker->title,
        'filename' => $faker->word,
        'category_id' => $faker->randomElement($categoryIds),
        'position' => $faker->randomElements([1,2,3,4,5], 2),
        'model_id' => 1,
        'thumb' => $faker->imageUrl(),
        'status' => 1,
    ];
});

$factory->define(\App\Models\DocumentPost\DocumentPost::class, function(Faker\Generator $faker) {
    return [
        'content' => $faker->text,
    ];
});
$factory->define(\App\Models\Taggable\Taggable::class, function(Faker\Generator $faker) {
    $tagIds = \App\Models\Tag\Tag::all('id')->pluck('id')->toArray();
    return [
        'model_name' => 'post',
        'tag_id' => $faker->randomElement($tagIds),
    ];
});
$factory->define(\App\Models\DocumentModel\DocumentModel::class, function(Faker\Generator $faker) {
    return [
        'name' => '',
        'title' => '',
        'status' => 1,
    ];
});

$factory->state(\App\Models\DocumentModel\DocumentModel::class, 'post', function(Faker\Generator $faker) {
    return [
        'name' => 'post',
        'title' => '文章',
        'status' => 1,
    ];
});

$factory->define(\App\Models\Comment\Comment::class, function(Faker\Generator $faker) {
    $userIds = \App\Models\User\User::all('id')->pluck('id')->toArray();
    return [
        'parent_id' => 0,
        'user_id' => $faker->randomElement($userIds),
        'status' => 1,
        'content' => $faker->text,
    ];
});
$factory->state(\App\Models\Comment\Comment::class, 'post', function(Faker\Generator $faker) {
    $postIds = \App\Models\DocumentPost\DocumentPost::all('post_id')->pluck('post_id')->toArray();
    return [
        'commentable_id' => $faker->randomElement($postIds),
        'commentable_type' => 'post',
    ];
});
