<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use App\Model\Category;
use App\Model\Post;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function($view){
            $firstCategoryShare = Category::offset(0)->limit(7)->get();
            $categoryShare = Category::all();
            $newPostsSidebar = Post::latest('date')->limit(10)->get();
            $bestViewSidebar = Post::latest('view')->limit(8)->get();
            // $url = 'https://api.weatherbit.io/v2.0/forecast/daily?lat=21.022736&lon=105.8019441&key=090c2dc48ed34d0c8266a2fd7ac722cb&lang=en';      
            // $weather = json_decode(file_get_contents($url), true);
            $data = [
                'firstCategoryShare' => $firstCategoryShare,
                'categoryShare' => $categoryShare,
                'newPostsSidebar' => $newPostsSidebar,
                'bestViewSidebar' => $bestViewSidebar,
                // 'weather' => $weather['data'],
            ];
            
            $view->with($data);
        });
    }
}
