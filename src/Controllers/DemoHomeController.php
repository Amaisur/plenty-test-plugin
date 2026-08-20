<?php

namespace PlentyTestPlugin\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Templates\Twig;
use PlentyTestPlugin\Configs\HeaderConfig;
use PlentyTestPlugin\Configs\HeroConfig;
use PlentyTestPlugin\Configs\PromoConfig;
use PlentyTestPlugin\Configs\SidebarConfig;
use PlentyTestPlugin\Configs\FooterConfig;

class DemoHomeController extends Controller
{
    public function show(Twig $twig, ConfigRepository $config)
    {
        $header = HeaderConfig::get($config);

        return $twig->render('PlentyTestPlugin::content.Home', [
            'header' => $header,
            'hero' => HeroConfig::get($config),
            'promo' => PromoConfig::get($config),
            'sidebar' => SidebarConfig::get($config),
            'footer' => FooterConfig::get($config),
            'searchAction' => $header['search']['action'],
            'searchParam' => $header['search']['param'],
        ]);
    }
}
