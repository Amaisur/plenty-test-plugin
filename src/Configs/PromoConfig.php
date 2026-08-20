<?php

namespace PlentyTestPlugin\Configs;

use Plenty\Plugin\ConfigRepository;

/**
 * Content for the two-panel promo banner shown right below the hero
 * ("New Arrival" / "Marketing Support" on lumi.cn).
 *
 * Editable from the plentymarkets backend under Plugins -> PlentyTestPlugin
 * -> Configuration ("Promo" section). Fixed at two panels, so each field is
 * a plain text setting rather than a JSON blob. Blank fields fall back to
 * defaults() below.
 */
class PromoConfig
{
    public static function get(ConfigRepository $config): array
    {
        $defaults = self::defaults();

        return [
            'panels' => [
                [
                    'href'    => ConfigHelper::text($config, 'PlentyTestPlugin.promoPanel1Href', $defaults['panels'][0]['href']),
                    'img'     => ConfigHelper::text($config, 'PlentyTestPlugin.promoPanel1Img', $defaults['panels'][0]['img']),
                    'tagline' => ConfigHelper::text($config, 'PlentyTestPlugin.promoPanel1Tagline', $defaults['panels'][0]['tagline']),
                    'label'   => ConfigHelper::text($config, 'PlentyTestPlugin.promoPanel1Label', $defaults['panels'][0]['label']),
                ],
                [
                    'href'    => ConfigHelper::text($config, 'PlentyTestPlugin.promoPanel2Href', $defaults['panels'][1]['href']),
                    'img'     => ConfigHelper::text($config, 'PlentyTestPlugin.promoPanel2Img', $defaults['panels'][1]['img']),
                    'tagline' => ConfigHelper::text($config, 'PlentyTestPlugin.promoPanel2Tagline', ''),
                    'label'   => ConfigHelper::text($config, 'PlentyTestPlugin.promoPanel2Label', $defaults['panels'][1]['label']),
                ],
            ],
        ];
    }

    private static function defaults(): array
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
