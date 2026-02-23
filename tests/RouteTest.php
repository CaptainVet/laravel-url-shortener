<?php

namespace ArieTimmerman\Laravel\URLShortener\Tests;

use Orchestra\Testbench\TestCase;
use ArieTimmerman\Laravel\URLShortener\URLShortener;
use Illuminate\Support\Facades\Route;

class RouteTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            "ArieTimmerman\\Laravel\\URLShortener\\ServiceProvider"
        ];
    }
    
    protected function getEnvironmentSetUp($app)
    {
        $app ['config']->set('urlshortener.route_resource_enabled', false);
    }
    
    public function testRoutesRegistered()
    {

        URLShortener::routes();

        $redirectRoute = Route::getRoutes()->getByName('urlshortener.redirect');
        $this->assertNotNull($redirectRoute);
        $this->assertSame('__{code}', $redirectRoute->uri());

    }
    
}
            
            
            
