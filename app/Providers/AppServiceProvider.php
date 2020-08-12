<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use App\Model\Category;
use App\Model\Post;
use Illuminate\Support\Facades\Cache;

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
            $newPostsSidebar = Post::latest('date')->limit(10)->get();
            $value = Cache::remember('users', 1440, function() {
                $firstCategoryShare = Category::offset(0)->limit(10)->get();
                $categoryShare = Category::all();
                $bestViewSidebar = Post::latest('view')->limit(8)->get();
                $url = 'https://api.weatherbit.io/v2.0/forecast/daily?lat=21.022736&lon=105.8019441&key=090c2dc48ed34d0c8266a2fd7ac722cb&lang=en';      
                $weather = json_decode(file_get_contents($url), true);
                $data = [
                    'firstCategoryShare' => $firstCategoryShare,
                    'categoryShare' => $categoryShare,
                    'bestViewSidebar' => $bestViewSidebar,
                    'weather' => $weather['data'],
                    'server' => 'https://diembao24h.s3-ap-southeast-1.amazonaws.com/photos',
                ];

                return $data;
            });
            $value = array_merge(array('newPostsSidebar' => $newPostsSidebar), $value);
            
            $view->with($value);
        });
    }
}
