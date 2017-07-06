<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        error_reporting(E_ALL ^ E_NOTICE);
        Schema::defaultStringLength(120);   // 兼容低版本数据库
        Carbon::setLocale('zh');

        if ($this->app->environment() == 'local') {
            $this->app->singleton(\Faker\Generator::class, function () {
                return \Faker\Factory::create('zh_CN');
            });
            $this->app->register(\Lookfeel\Boilerplate\GeneratorCommandServiceProvider::class);
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            DB::listen(function ($query) {
                Log::debug($query->sql, $query->bindings, $query->time);
            });
        }

        //小于等于某个时间
        \Validator::extend('before_equal', function($attribute, $value, $parameters, $validator) {
            $validator->addReplacer('before_equal', function ($message, $attribute, $rule, $parameters) use ($validator) {
                return str_replace(':date', $validator->getTranslator()->trans('validation.attributes.' . $parameters[0]) , $message);
            });
            return strtotime($validator->getData()[$parameters[0]]) >= strtotime($value);
        });

        //小于等于某个时间
        \Validator::extend('after_equal', function($attribute, $value, $parameters, $validator) {
            $validator->addReplacer('after_equal', function ($message, $attribute, $rule, $parameters) use ($validator) {
                return str_replace(':date', $validator->getTranslator()->trans('validation.attributes.' . $parameters[0]) , $message);
            });
            return strtotime($validator->getData()[$parameters[0]]) <= strtotime($value);
        });


        Relation::morphMap([
            'post' => \App\Models\DocumentPost\DocumentPost::class,
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
