<?php

namespace ArieTimmerman\Laravel\URLShortener;

use ArieTimmerman\Laravel\URLShortener\Http\Controllers\RedirectController;
use ArieTimmerman\Laravel\URLShortener\Http\Controllers\URLController;
use Illuminate\Support\Facades\Route;

/**
 * Helper class for the URL shortener
 */
class URLShortener
{
    
    public static function routes(array $options = []): void
    {
            
        $prefix = config("urlshortener.url_prefix");
        
        if(!empty($prefix)) {
            Route::prefix($prefix)->group(
                function () use ($options) {
                    self::allRoutes($options);
                }
            );
        }else{
            self::allRoutes($options);
        }
        
    }
    
    private static function allRoutes(array $options = []): void
    {
        
        if(config('urlshortener.route_resource_enabled')) {
            self::routeResource($options);
        }

        self::routeRedirect($options);
        
    }
    
    public static function routeResource(array $options = []): void
    {
        Route::resource('urls', URLController::class)->except(['edit']);
    }
    
    public static function routeRedirect(array $options = []): void
    {

        $prefixCode = config("urlshortener.url_prefix_code");

        Route::get($prefixCode . '{code}', [RedirectController::class, 'index'])
            ->where('code', '[^/]+')
            ->name('urlshortener.redirect');
    }
    
    public static function shorten($url)
    {
        
        $url = new URL([ "url" => $url ]);
        $url->save();

        return $url;
        
    }
    
}
