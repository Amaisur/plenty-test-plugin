<?php

namespace PlentyTestPlugin\Providers;

use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Routing\Router;

/**
 * Boots the plugin and overrides the storefront "/" route so it renders
 * the hardcoded demo homepage instead of the shop's normal home/category page.
 */
class PlentyTestPluginServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot(Router $router)
    {
        $router->get('/', 'PlentyTestPlugin\Controllers\DemoHomeController@show');
    }
}
