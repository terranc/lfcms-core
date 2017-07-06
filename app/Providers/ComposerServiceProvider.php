<?php
/**
 * Created by PhpStorm.
 * User: terranc
 * Date: 17/7/3
 * Time: 16:02
 */

namespace App\Providers;


use App\Http\ViewComposers\Backend\BaseComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
//        View::composer([
//            'admin.*.index',
//        ], BaseComposer::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
