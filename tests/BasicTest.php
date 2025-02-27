<?php

namespace ArieTimmerman\Laravel\URLShortener\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase;
use ArieTimmerman\Laravel\URLShortener\URL;

class BasicTest extends TestCase
{

    use RefreshDatabase;

    private static $lengthMin = 4;
    private static $characterset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~';

    protected function getPackageProviders($app)
    {
        return [
            "ArieTimmerman\\Laravel\\URLShortener\\ServiceProvider"
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('urlshortener.characterset', self::$characterset);
        $app['config']->set('urlshortener.length_min', self::$lengthMin);
        $app['config']->set('urlshortener.max_tries', 20);
    }
    
    public function testUrlCode()
    {
            $url = URL::create(["url" => "https://example.com"]);

            //Check if the length is correct
            $this->assertEquals(4, strlen($url->code));

            //Check if all characters are allowed
            $this->assertTrue(strlen(str_replace(str_split(self::$characterset), "", $url->code)) == 0);
    }



    public function testNoCodeOverride()
    {
        $code = "a6Sd";

        $url = new URL;

        $url->code = $code;
        $url->url = "https://example.com";

        $url->save();

        $this->assertEquals($code, $url->code);
    }
}
