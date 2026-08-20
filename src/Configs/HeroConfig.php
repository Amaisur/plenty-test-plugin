<?php

namespace PlentyTestPlugin\Configs;

use Plenty\Plugin\ConfigRepository;

/**
 * Content for the homepage hero slider.
 *
 * Editable from the plentymarkets backend under Plugins -> PlentyTestPlugin
 * -> Configuration ("Hero" section) as a single JSON-array text field,
 * since plugin config has no repeater field type. Each slide needs `href`,
 * `img` (desktop), `series` (small label) and `title` (the headline); the
 * Hero.twig partial renders both the slide and its matching desktop tab
 * from the same entry. `imgMobile` is optional: a portrait-cropped image
 * to show on screens <=1100px — omit/leave blank to fall back to `img`.
 *
 * A blank or invalid JSON field falls back to defaults() below.
 */
class HeroConfig
{
    public static function get(ConfigRepository $config): array
    {
        $defaults = self::defaults();

        return [
            'slides' => ConfigHelper::json($config, 'PlentyTestPlugin.heroSlidesJson', $defaults['slides']),
        ];
    }

    private static function defaults(): array
    {
        return [
            'slides' => [
                [
                    'href'      => 'https://www.lumi.cn/en/series/lumi-home/speaker-mounts/speaker-mount-and-stand/sb76-series',
                    'img'       => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/Doc/3a2291173e2ebe8fc1a4ac2bbb8c5196.png',
                    'imgMobile' => null,
                    'series'    => 'SB76 Series',
                    'title'     => 'Universal Heavy-Duty Wall & Ceiling Speaker Mounts',
                ],
                [
                    'href'      => 'https://www.lumi.cn/en/series/lumi-ergo/standing-desks/sit-stand-desk/da22-series',
                    'img'       => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/Doc/3a227681ed92d398c552c4ed2511bc76.png',
                    'imgMobile' => null,
                    'series'    => 'DA22 Series',
                    'title'     => 'Modern Stylish Under-Desk Drawers',
                ],
                [
                    'href'      => 'https://www.lumi.cn/en/series/lumi-ergo/monitor-arms/counterbalance-monitor-mount/ldt133-series',
                    'img'       => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/Doc/3a220b41c430632cbd3cd6d9c9954f91.png',
                    'imgMobile' => null,
                    'series'    => 'LDT133 Series',
                    'title'     => 'Refined Space-Efficient Gas Spring Monitor Arms',
                ],
                [
                    'href'      => 'https://www.lumi.cn/en/series/lumi-home/tv-stands-media-console/studio-tv-stand/fs67-series',
                    'img'       => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/Doc/3a22097bd8f1a4e473808a836124d51e.png',
                    'imgMobile' => null,
                    'series'    => 'FS67 Series',
                    'title'     => 'Premium Minimalist TV Carts',
                ],
                [
                    'href'      => 'https://www.lumi.cn/en/series/organization-solutions/organizers/medical-mounting-olutions/med14-series',
                    'img'       => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/Doc/3a220a962742ac5836ae6d98c11202f6.png',
                    'imgMobile' => null,
                    'series'    => 'MED14 Series',
                    'title'     => 'Electric Height-Adjustable Medical Carts',
                ],
            ],
        ];
    }
}
