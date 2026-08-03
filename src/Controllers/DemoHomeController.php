<?php

namespace PlentyTestPlugin\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Templates\Twig;
use PlentyTestPlugin\Configs\HeaderConfig;
use PlentyTestPlugin\Configs\HeroConfig;
use PlentyTestPlugin\Configs\PromoConfig;
use PlentyTestPlugin\Configs\SidebarConfig;
use PlentyTestPlugin\Configs\FooterConfig;

class DemoHomeController extends Controller
{
    public function show(Twig $twig)
    {
        return $twig->render('PlentyTestPlugin::content.Home', [
            'header' => HeaderConfig::get(),
            'hero' => HeroConfig::get(),
            'promo' => PromoConfig::get(),
            'sidebar' => SidebarConfig::get(),
            'footer' => FooterConfig::get(),
            'searchAction' => '/search',
            'searchParam' => 'query',
        ]);
    }
}
