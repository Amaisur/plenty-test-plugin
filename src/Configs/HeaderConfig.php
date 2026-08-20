<?php

namespace PlentyTestPlugin\Configs;

use Plenty\Plugin\ConfigRepository;

/**
 * Content for the LUMI-style storefront header.
 *
 * Every field is editable from the plentymarkets backend under
 * Plugins -> PlentyTestPlugin -> Configuration (see config.json, "Header"
 * section). Simple fields (logo, search copy, current-language label) are
 * individual text settings; the nav menu and the language list are each a
 * single JSON-array text field, since plentymarkets plugin config has no
 * repeater/array field type. Whatever is left blank (or fails to parse as
 * JSON) falls back to the defaults() below, so a bad edit never breaks the
 * page — it just reverts that one field to its built-in value.
 */
class HeaderConfig
{
    public static function get(ConfigRepository $config): array
    {
        $defaults = self::defaults();

        return [
            'logo' => [
                'href' => ConfigHelper::text($config, 'PlentyTestPlugin.headerLogoHref', $defaults['logo']['href']),
                'src'  => ConfigHelper::text($config, 'PlentyTestPlugin.headerLogoSrc', $defaults['logo']['src']),
                'alt'  => ConfigHelper::text($config, 'PlentyTestPlugin.headerLogoAlt', $defaults['logo']['alt']),
            ],

            'nav' => ConfigHelper::json($config, 'PlentyTestPlugin.headerNavJson', $defaults['nav']),

            'languages' => [
                'current' => [
                    'label' => ConfigHelper::text($config, 'PlentyTestPlugin.headerLangCurrentLabel', $defaults['languages']['current']['label']),
                    'flag'  => ConfigHelper::text($config, 'PlentyTestPlugin.headerLangCurrentFlag', $defaults['languages']['current']['flag']),
                ],
                'options' => ConfigHelper::json($config, 'PlentyTestPlugin.headerLanguagesJson', $defaults['languages']['options']),
            ],

            'search' => [
                'placeholder' => ConfigHelper::text($config, 'PlentyTestPlugin.headerSearchPlaceholder', $defaults['search']['placeholder']),
                'action'      => ConfigHelper::text($config, 'PlentyTestPlugin.headerSearchAction', $defaults['search']['action']),
                'param'       => ConfigHelper::text($config, 'PlentyTestPlugin.headerSearchParam', $defaults['search']['param']),
            ],
        ];
    }

    /**
     * Built-in fallback content — also what a fresh install shows before
     * anyone has touched the backend configuration.
     */
    private static function defaults(): array
    {
        return [
            'logo' => [
                'href' => 'https://www.lumi.cn/en/',
                'src'  => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/prd/wwwroot/images/logo.svg',
                'alt'  => 'LUMI',
            ],

            'nav' => [

                // Simple dropdown with one nested sub-list
                [
                    'label' => 'About us',
                    'href'  => 'https://www.lumi.cn/en/overview',
                    'type'  => 'dropdown',
                    'links' => [
                        [
                            'label' => 'Overview',
                            'href'  => 'https://www.lumi.cn/en/overview',
                            'sub'   => [
                                ['label' => 'Who We Are', 'href' => 'https://www.lumi.cn/en/overview#who'],
                                ['label' => 'Why We Differ', 'href' => 'https://www.lumi.cn/en/overview#why'],
                                ['label' => 'LUMI Culture', 'href' => 'https://www.lumi.cn/en/overview#culture'],
                                ['label' => 'LUMI History', 'href' => 'https://www.lumi.cn/en/overview#history'],
                            ],
                        ],
                        ['label' => 'History', 'href' => 'https://www.lumi.cn/en/history'],
                        ['label' => 'Factory Tour', 'href' => 'https://www.lumi.cn/en/factorytour'],
                        ['label' => 'Quality Control', 'href' => 'https://www.lumi.cn/en/qc'],
                        ['label' => 'Lumi Culture', 'href' => 'https://www.lumi.cn/en/culture'],
                    ],
                ],

                // Mega menu
                [
                    'label' => 'Products',
                    'href'  => 'https://www.lumi.cn/en/fullproductdirectory/lumi-ergo',
                    'type'  => 'mega',
                    'columns' => [

                        // Column 1 — LUMI Ergo
                        [
                            ['type' => 'brand', 'label' => 'LUMI Ergo', 'desc' => 'Home Office & Office Solution', 'href' => 'https://www.lumi.cn/en/fullproductdirectory/lumi-ergo'],
                            ['type' => 'group', 'label' => 'Monitor Arms', 'href' => 'https://www.lumi.cn/en/lumi-ergo/monitor-arms', 'items' => [
                                ['label' => 'Gas Spring Monitor Arms', 'href' => 'https://www.lumi.cn/en/lumi-ergo/monitor-arms/counterbalance-monitor-mount'],
                                ['label' => 'Mechanical Spring Monitor Arms', 'href' => 'https://www.lumi.cn/en/lumi-ergo/monitor-arms/spring-assisted-monitor-arm'],
                                ['label' => 'Articulating Monitor Arms', 'href' => 'https://www.lumi.cn/en/lumi-ergo/monitor-arms/articulating-monitor-arm'],
                                ['label' => 'Pro Gaming Monitor Arms', 'href' => 'https://www.lumi.cn/en/lumi-ergo/monitor-arms/pro-gaming-monitor-arm'],
                                ['label' => 'Other Monitor Arms', 'href' => 'https://www.lumi.cn/en/lumi-ergo/monitor-arms/monitor-arm'],
                                ['label' => 'Adaptors & Components', 'href' => 'https://www.lumi.cn/en/lumi-ergo/monitor-arms/monitor-accessories'],
                            ]],
                            ['type' => 'group', 'label' => 'Standing Desks', 'href' => 'https://www.lumi.cn/en/lumi-ergo/standing-desks', 'items' => [
                                ['label' => 'Electric/Manual Sit-Stand Desks & Tabletops', 'href' => 'https://www.lumi.cn/en/lumi-ergo/standing-desks/sit-stand-desk'],
                                ['label' => 'Gas-Lift Sit-Stand Desks', 'href' => 'https://www.lumi.cn/en/lumi-ergo/standing-desks/gas-lift-sit-stand-desk'],
                                ['label' => 'Desk Converters', 'href' => 'https://www.lumi.cn/en/lumi-ergo/standing-desks/desk-converter'],
                                ['label' => 'Freestanding/Mobile Workstations', 'href' => 'https://www.lumi.cn/en/lumi-ergo/standing-desks/mobile-workstation'],
                            ]],
                            ['type' => 'group', 'label' => 'Risers & Stands', 'href' => 'https://www.lumi.cn/en/lumi-ergo/monitor-laptop-risers', 'items' => [
                                ['label' => 'Monitor Risers', 'href' => 'https://www.lumi.cn/en/lumi-ergo/monitor-laptop-risers/monitor-riser'],
                                ['label' => 'Laptop Risers & Stands', 'href' => 'https://www.lumi.cn/en/lumi-ergo/monitor-laptop-risers/laptop-risers-stands'],
                            ]],
                            ['type' => 'group', 'label' => 'Others', 'href' => 'https://www.lumi.cn/en/lumi-ergo/office-accessories', 'items' => [
                                ['label' => 'CPU Mounts', 'href' => 'https://www.lumi.cn/en/lumi-ergo/office-accessories/cpu-mount'],
                                ['label' => 'Keyboard Tray/Work Riser', 'href' => 'https://www.lumi.cn/en/lumi-ergo/office-accessories/keyboard-tray-and-keyboard-riser'],
                                ['label' => 'Foot Rests/Mats', 'href' => 'https://www.lumi.cn/en/lumi-ergo/office-accessories/foot-rest'],
                                ['label' => 'Partitions & Whiteboards', 'href' => 'https://www.lumi.cn/en/lumi-ergo/office-accessories/partitions-dividers'],
                                ['label' => 'Office Chair & Stool', 'href' => 'https://www.lumi.cn/en/lumi-ergo/office-accessories/chairs---stools'],
                                ['label' => 'Desk Organizers', 'href' => 'https://www.lumi.cn/en/lumi-ergo/office-accessories/desk-organizers'],
                                ['label' => 'Cable Management', 'href' => 'https://www.lumi.cn/en/lumi-ergo/office-accessories/cable-management'],
                            ]],
                        ],

                        // Column 2 — LUMI Home
                        [
                            ['type' => 'brand', 'label' => 'LUMI Home', 'desc' => 'Residential Mounting Solution', 'href' => 'https://www.lumi.cn/en/fullproductdirectory/lumi-home'],
                            ['type' => 'group', 'label' => 'TV Mounts', 'href' => 'https://www.lumi.cn/en/lumi-home/tv-mounts', 'items' => [
                                ['label' => 'Fixed & Tilt TV Wall Mounts', 'href' => 'https://www.lumi.cn/en/lumi-home/tv-mounts/fixed-tilt-tv-wall-mount'],
                                ['label' => 'Full-Motion TV Wall Mounts', 'href' => 'https://www.lumi.cn/en/lumi-home/tv-mounts/full-motion-tv-wall-mount'],
                                ['label' => 'Motorized TV Mount', 'href' => 'https://www.lumi.cn/en/lumi-home/tv-mounts/motorized-tv-mount'],
                                ['label' => 'Other TV Mount', 'href' => 'https://www.lumi.cn/en/lumi-home/tv-mounts/other-tv-mount'],
                                ['label' => 'Adaptors & Components', 'href' => 'https://www.lumi.cn/en/lumi-home/tv-mounts/tv-mount-adaptors-components'],
                            ]],
                            ['type' => 'group', 'label' => 'TV Stands & Media Consoles', 'href' => 'https://www.lumi.cn/en/lumi-home/tv-stands-media-console', 'items' => [
                                ['label' => 'TV Stand & Media Console', 'href' => 'https://www.lumi.cn/en/lumi-home/tv-stands-media-console/tv-stand'],
                                ['label' => 'Studio TV Floor/Tabletop Stand', 'href' => 'https://www.lumi.cn/en/lumi-home/tv-stands-media-console/studio-tv-stand'],
                            ]],
                            ['type' => 'group', 'label' => 'Speaker Mounts', 'href' => 'https://www.lumi.cn/en/lumi-home/speaker-mounts', 'items' => [
                                ['label' => 'Soundbar Shelves & Brackets', 'href' => 'https://www.lumi.cn/en/lumi-home/speaker-mounts/soundbar-bracket'],
                                ['label' => 'Speaker Mounts & Stands', 'href' => 'https://www.lumi.cn/en/lumi-home/speaker-mounts/speaker-mount-and-stand'],
                            ]],
                            ['type' => 'group', 'label' => 'Gaming & Studio', 'href' => 'https://www.lumi.cn/en/lumi-home/gaming', 'items' => [
                                ['label' => 'Racing & Flight Simulators', 'href' => 'https://www.lumi.cn/en/lumi-home/gaming/racing-simulator-cockpit'],
                                ['label' => 'Gaming Desk & Chair', 'href' => 'https://www.lumi.cn/en/lumi-home/gaming/gaming-desk'],
                                ['label' => 'Studio Setup Equipment', 'href' => 'https://www.lumi.cn/en/lumi-home/gaming/studio-mounts'],
                                ['label' => 'Accessories', 'href' => 'https://www.lumi.cn/en/lumi-home/gaming/headphone-stand---holder'],
                            ]],
                            ['type' => 'group', 'label' => 'Others', 'href' => 'https://www.lumi.cn/en/lumi-home/other-mounts-stands', 'items' => [
                                ['label' => 'AV Components/Media Player Mounts', 'href' => 'https://www.lumi.cn/en/lumi-home/other-mounts-stands/av-component-shelf'],
                                ['label' => 'Mobile & Tablet Device Holders', 'href' => 'https://www.lumi.cn/en/lumi-home/other-mounts-stands/tablet-mounts-stands'],
                                ['label' => 'Appliance Mounts & Holders', 'href' => 'https://www.lumi.cn/en/lumi-home/other-mounts-stands/appliance-mount-and-holder'],
                                ['label' => 'Cabinets & Racks', 'href' => 'https://www.lumi.cn/en/lumi-home/other-mounts-stands/cabinets-racks'],
                                ['label' => 'Threshold Ramps', 'href' => 'https://www.lumi.cn/en/lumi-home/other-mounts-stands/threshold-ramps'],
                                ['label' => 'Screen Cleaners', 'href' => 'https://www.lumi.cn/en/lumi-home/other-mounts-stands/screen-cleaner'],
                                ['label' => 'Indoor Gardening', 'href' => 'https://www.lumi.cn/en/lumi-home/other-mounts-stands/indoor-garden'],
                            ]],
                        ],

                        // Column 3 — LUMI Pro
                        [
                            ['type' => 'brand', 'label' => 'LUMI Pro', 'desc' => 'Prosumer Mounting Solution', 'href' => 'https://www.lumi.cn/en/fullproductdirectory/lumi-pro'],
                            ['type' => 'group', 'label' => 'Digital Signage Mounts', 'href' => 'https://www.lumi.cn/en/lumi-pro/digital-signage-display-mount', 'items' => [
                                ['label' => 'Menu Board Mounts', 'href' => 'https://www.lumi.cn/en/lumi-pro/digital-signage-display-mount/menuboard-mount'],
                                ['label' => 'Video Wall Mounts & Stands', 'href' => 'https://www.lumi.cn/en/lumi-pro/digital-signage-display-mount/video-wall-mount'],
                                ['label' => 'Interactive Display Mounts & Stands', 'href' => 'https://www.lumi.cn/en/lumi-pro/digital-signage-display-mount/interactive-display-mount'],
                            ]],
                            ['type' => 'group', 'label' => 'TV Carts & Stands', 'href' => 'https://www.lumi.cn/en/lumi-pro/tv-cart', 'items' => [
                                ['label' => 'TV Carts & Stands', 'href' => 'https://www.lumi.cn/en/lumi-pro/tv-cart/tv-cart-stand'],
                            ]],
                            ['type' => 'group', 'label' => 'Prosumer TV Mounts', 'href' => 'https://www.lumi.cn/en/lumi-pro/prosumer-tv-mounts', 'items' => [
                                ['label' => 'Anti-theft TV Mounts', 'href' => 'https://www.lumi.cn/en/lumi-pro/prosumer-tv-mounts/anti-theft-tv-mount'],
                                ['label' => 'Recreational Vehicle TV Mounts', 'href' => 'https://www.lumi.cn/en/lumi-pro/prosumer-tv-mounts/recreational-vehicle-tv-mount'],
                                ['label' => 'TV Ceiling Mounts', 'href' => 'https://www.lumi.cn/en/lumi-pro/prosumer-tv-mounts/tv-ceiling-mount'],
                                ['label' => 'More Mounts', 'href' => 'https://www.lumi.cn/en/lumi-pro/prosumer-tv-mounts/more-mounts'],
                            ]],
                            ['type' => 'group', 'label' => 'Others', 'href' => 'https://www.lumi.cn/en/lumi-pro/other-mounts', 'items' => [
                                ['label' => 'Projector Mounts & Stands', 'href' => 'https://www.lumi.cn/en/lumi-pro/other-mounts/projector-mount'],
                                ['label' => 'Anti-Theft Tablet Mounts/Kiosks', 'href' => 'https://www.lumi.cn/en/lumi-pro/other-mounts/anti-theft-tablet-mount-kiosk'],
                                ['label' => 'POS Mounts', 'href' => 'https://www.lumi.cn/en/lumi-pro/other-mounts/pos-mount'],
                                ['label' => 'EV Charging Stands', 'href' => 'https://www.lumi.cn/en/lumi-pro/other-mounts/ev-charging-stands'],
                                ['label' => 'Projection Screens', 'href' => 'https://www.lumi.cn/en/lumi-pro/other-mounts/projection-screens'],
                            ]],
                        ],

                        // Column 4 — LUMI Game / New Category / Solutions
                        [
                            ['type' => 'brand', 'label' => 'LUMI Game', 'desc' => 'Gaming & Streaming Solution', 'href' => 'https://www.lumigame.cn/en'],
                            ['type' => 'group', 'label' => 'Gaming Peripherals and Accessories', 'href' => 'https://www.lumigame.cn/en', 'items' => [
                                ['label' => 'Sim Racing Cockpits', 'href' => 'https://www.lumigame.cn/en/racing---flight-simulators/sim-racing---flight-cockpits'],
                                ['label' => 'Gaming Monitor Arms', 'href' => 'https://www.lumigame.cn/en/gaming-gears/gaming-monitor-arms'],
                                ['label' => 'Studio Setup Equipment', 'href' => 'https://www.lumigame.cn/en/streaming-gears'],
                                ['label' => 'Gaming Furniture & Accessories', 'href' => 'https://www.lumigame.cn/en/gaming-organization---storage'],
                            ]],
                            ['type' => 'brand', 'label' => 'LUMI New Category', 'desc' => 'Keep Pace with Market Trends', 'href' => 'https://www.lumi.cn/en/organization-solutions/organizers'],
                            ['type' => 'group', 'label' => 'Trending Products', 'href' => 'https://www.lumi.cn/en/organization-solutions/organizers', 'items' => [
                                ['label' => 'Bike Mounts & Hitch Bike Racks', 'href' => 'https://www.lumi.cn/en/organization-solutions/organizers/bike-racks-stands', 'badge' => 'New'],
                                ['label' => 'Medical Mounting Solutions', 'href' => 'https://www.lumi.cn/en/organization-solutions/organizers/medical-mounting-olutions', 'badge' => 'New'],
                                ['label' => 'Garage Storage Solutions', 'href' => 'https://www.lumi.cn/en/organization-solutions/organizers/garage-storage-solutions', 'badge' => 'New'],
                            ]],
                            ['type' => 'solutions', 'heading' => 'Explore Full Solutions', 'logos' => [
                                ['href' => 'https://www.lumisourcing.com/en/', 'alt' => 'Lumisourcing', 'off' => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/prd/wwwroot/images/logo/lumisourcing1.png', 'on' => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/prd/wwwroot/images/logo/lumisourcing1-mouseover.png'],
                                ['href' => 'https://www.lumivida.com/', 'alt' => 'Lumivida', 'off' => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/prd/wwwroot/images/logo/lumivida1.png', 'on' => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/prd/wwwroot/images/logo/lumivida1-mouseover.png'],
                                ['href' => 'https://www.lumigame.cn/en/', 'alt' => 'Lumigame', 'off' => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/prd/wwwroot/images/logo/lumigame1.png', 'on' => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/prd/wwwroot/images/logo/lumigame1-mouseover.png'],
                                ['href' => 'http://lumiaudio.cn/', 'alt' => 'Lumiaudio', 'off' => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/prd/wwwroot/images/logo/lumiaudio1.png', 'on' => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/prd/wwwroot/images/logo/lumiaudio1-mouseover.png'],
                            ]],
                        ],

                        // Column 5 — What's New
                        [
                            ['type' => 'news', 'heading' => "What's New", 'headingSmall' => 'Speed to Market', 'cards' => [
                                ['href' => 'https://www.lumi.cn/en/new-arrivals', 'alt' => 'New arrivals', 'img' => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/Doc/3a0869ddd1f38f02b2f21b5c2854ed58.jpg?x-oss-process=image/resize,m_lfit,h_160,w_256'],
                                ['href' => 'https://www.lumi.cn/en/buying-guide', 'alt' => 'Buying guide', 'img' => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/Doc/3a0869de52f9028a77ca92d52da79a63.jpg?x-oss-process=image/resize,m_lfit,h_160,w_256'],
                                ['href' => 'https://www.lumi.cn/en/resources/e-catalogue', 'alt' => 'E-catalogue', 'img' => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/Doc/3a05fa3050d4007d44fca8f6e5e26e1b.jpg?x-oss-process=image/resize,m_lfit,h_160,w_256'],
                            ]],
                        ],
                    ],

                    'quickAccess' => [
                        'label' => 'Quick Access:',
                        'links' => [
                            ['label' => 'FULL PRODUCT DIRECTORY', 'href' => 'https://www.lumi.cn/en/fullproductdirectory/lumi-ergo'],
                            ['label' => 'MARKETING SUPPORT', 'href' => 'https://www.lumi.cn/en/resources/marketing-support'],
                            ['label' => 'CATALOG DOWNLOAD', 'href' => 'https://www.lumi.cn/en/resources/e-catalogue'],
                            ['label' => 'SHOWROOM', 'href' => 'https://www.lumi.cn/en/showroom'],
                        ],
                    ],
                ],

                // Support dropdown
                [
                    'label' => 'Support',
                    'href'  => 'https://www.lumi.cn/en/resources/e-catalogue',
                    'type'  => 'dropdown',
                    'links' => [
                        ['label' => 'Catalogs', 'href' => 'https://www.lumi.cn/en/resources/e-catalogue'],
                        ['label' => 'Brochures', 'href' => 'https://www.lumi.cn/en/resources/leaflet'],
                        ['label' => 'Certifications', 'href' => 'https://www.lumi.cn/en/resources/certification'],
                        ['label' => 'Videos', 'href' => 'https://www.lumi.cn/en/resources/videolist'],
                        ["label" => "Buyer's Guide", 'href' => 'https://www.lumi.cn/en/buying-guide'],
                        ['label' => 'White Papers', 'href' => 'https://www.lumi.cn/en/resources/white-papers'],
                        ['label' => 'Marketing Support', 'href' => 'https://www.lumi.cn/en/resources/marketing-support'],
                        ['label' => 'Troubleshooting Guide', 'href' => 'https://www.lumi.cn/en/troubleshooting'],
                        ['label' => 'FAQ', 'href' => 'https://www.lumi.cn/en/faq'],
                    ],
                ],

                // Plain link
                ['label' => 'R&D', 'href' => 'https://www.lumi.cn/en/research-and-development', 'type' => 'link'],

                // News dropdown
                [
                    'label' => 'News',
                    'href'  => 'https://www.lumi.cn/en/news&blog',
                    'type'  => 'dropdown',
                    'links' => [
                        ['label' => 'News & Blog', 'href' => 'https://www.lumi.cn/en/news&blog'],
                        ['label' => 'Trade Show Calendar', 'href' => 'https://www.lumi.cn/en/news/trade-show'],
                    ],
                ],

                // Plain link
                ['label' => 'Contact us', 'href' => 'https://www.lumi.cn/en/contactus', 'type' => 'link'],
            ],

            'languages' => [
                'current' => [
                    'label' => 'English',
                    'flag'  => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/Doc/3a03e8a0c64b4a4bd8944110fe9c604e.png',
                ],
                'options' => [
                    ['label' => 'English', 'href' => 'https://www.lumi.cn/en/', 'flag' => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/Doc/3a03e8a0c64b4a4bd8944110fe9c604e.png'],
                    ['label' => 'русский', 'href' => 'https://www.lumi.cn/ru/', 'flag' => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/Doc/3a03e8a0a9ad70d8929de17546a12e8e.png'],
                    ['label' => 'Español', 'href' => 'https://www.lumi.cn/es/', 'flag' => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/Doc/3a03e8a088aa434a5b8df1605080e404.png'],
                    ['label' => '日本語', 'href' => 'https://www.lumi.cn/ja/', 'flag' => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/Doc/3a03e8a05b3d349e138e4b0f1ae9f070.png'],
                ],
            ],

            'search' => [
                'placeholder' => 'Search products',
                'action'      => '/search',
                'param'       => 'query',
            ],
        ];
    }
}
