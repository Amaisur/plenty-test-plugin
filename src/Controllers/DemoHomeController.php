<?php

namespace PlentyTestPlugin\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Templates\Twig;
use PlentyTestPlugin\Configs\HeaderConfig;
use PlentyTestPlugin\Configs\HeroConfig;

class DemoHomeController extends Controller
{
    public function show(Twig $twig)
    {
        return $twig->render('PlentyTestPlugin::content.Home', [
            'header' => HeaderConfig::get(),
            'hero' => HeroConfig::get(),
            'searchAction' => '/search',
            'searchParam' => 'query',
        ]);
    }
}
