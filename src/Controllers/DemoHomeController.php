<?php

namespace PlentyTestPlugin\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Templates\Twig;
use PlentyTestPlugin\Configs\HeaderConfig;

class DemoHomeController extends Controller
{
    public function show(Twig $twig, ConfigRepository $config)
    {
        return $twig->render('PlentyTestPlugin::content.Home', [
            'header' => HeaderConfig::get(),
            'searchAction' => $config->get('PlentyTestPlugin.searchAction', '/search'),
            'searchParam' => $config->get('PlentyTestPlugin.searchParam', 'query'),
        ]);
    }
}
