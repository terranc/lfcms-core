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
$factory->define(\App\Models\User::class, function (Faker\Generator $faker) {
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
$factory->define(\App\Models\Category::class, function(Faker\Generator $faker) {
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

$factory->define(\App\Models\Tag::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'weight' => random_int(1,100),
        'status' => 1,
    ];
});

$factory->define(\App\Models\Document::class, function(Faker\Generator $faker) {
    $categoryIds = \App\Models\Category::all('id')->pluck('id')->toArray();
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

$factory->define(\App\Models\Post::class, function(Faker\Generator $faker) {
    return [
        'content' => $faker->text,
    ];
});
$factory->define(\App\Models\Taggable::class, function(Faker\Generator $faker) {
    $tagIds = \App\Models\Tag::all('id')->pluck('id')->toArray();
    return [
        'model_name' => 'post',
        'tag_id' => $faker->randomElement($tagIds),
    ];
});

$factory->define(\App\Models\DocumentModel::class, function(Faker\Generator $faker) {
    return [
        'name' => 'post',
        'title' => '文章',
        'status' => 1,
    ];
});

