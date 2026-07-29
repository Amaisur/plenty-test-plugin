<?php

namespace PlentyTestPlugin\Configs;

/**
 * Content for the homepage hero slider.
 *
 * Each slide needs `href`, `img` (desktop), `series` (small label) and
 * `title` (the headline) — the Hero.twig partial renders both the slide and
 * its matching desktop tab from the same entry, so there is only one place
 * to edit per slide.
 *
 * `imgMobile` is optional: set it to a portrait-cropped image to show on
 * screens <=1100px (the same breakpoint the header collapses at); leave it
 * `null` to fall back to the desktop `img` on mobile too.
 */
class HeroConfig
{
    public static function get(): array
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
