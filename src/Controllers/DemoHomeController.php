<?php

namespace PlentyTestPlugin\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Templates\Twig;

class DemoHomeController extends Controller
{
    public function show(Twig $twig)
    {
        return $twig->render('PlentyTestPlugin::content.demo-home');
    }
}
