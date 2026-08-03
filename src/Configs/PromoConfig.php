<?php

namespace PlentyTestPlugin\Configs;

/**
 * Content for the two-panel promo banner shown right below the hero
 * ("New Arrival" / "Marketing Support" on lumi.cn). Edit this array to
 * change the images, links or labels — Promo.twig only renders it.
 */
class PromoConfig
{
    public static function get(): array
    {
        return [
            'panels' => [
                [
                    'href'    => 'https://www.lumi.cn/en/new-arrivals',
                    'img'     => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/prd/wwwroot/images/index-img1.png',
                    'tagline' => 'COMMITMENT TO INNOVATION SPEED TO MARKET',
                    'label'   => 'New Arrival',
                ],
                [
                    'href'    => 'https://www.lumi.cn/en/resources/marketing-support',
                    'img'     => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/prd/wwwroot/images/index-img2.png',
                    'tagline' => null,
                    'label'   => 'Marketing Support',
                ],
            ],
        ];
    }
}
