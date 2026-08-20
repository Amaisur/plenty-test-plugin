<?php

namespace PlentyTestPlugin\Configs;

use Plenty\Plugin\ConfigRepository;

/**
 * Content for the storefront footer, mirroring lumi.cn's footer:
 * link columns, social links, legal/bottom links, copyright, and the
 * "Subscribe" inquiry form fields.
 *
 * Editable from the plentymarkets backend under Plugins -> PlentyTestPlugin
 * -> Configuration ("Footer" section). Simple/fixed-shape fields (logo,
 * social hrefs, legal links, copyright, subscribe labels) are individual
 * text settings; the link columns and the subscribe field list are each a
 * single JSON-array text field, since plugin config has no repeater field
 * type. A blank or invalid field falls back to defaults() below.
 *
 * The inquiry form has no working submit target here — lumi.cn's own
 * version posts to their internal CRM, which this plugin has no access to.
 * The fields are rendered so the markup/design is faithful, but
 * Footer.twig's form needs a real `action` (or an AJAX handler wired to
 * your own backend/CRM) before it will actually send anything.
 */
class FooterConfig
{
    public static function get(ConfigRepository $config): array
    {
        $defaults = self::defaults();

        return [
            'logo' => [
                'href' => ConfigHelper::text($config, 'PlentyTestPlugin.footerLogoHref', $defaults['logo']['href']),
                'src'  => ConfigHelper::text($config, 'PlentyTestPlugin.footerLogoSrc', $defaults['logo']['src']),
                'alt'  => ConfigHelper::text($config, 'PlentyTestPlugin.footerLogoAlt', $defaults['logo']['alt']),
            ],

            'columns' => ConfigHelper::json($config, 'PlentyTestPlugin.footerColumnsJson', $defaults['columns']),

            'subscribe' => [
                'label'       => ConfigHelper::text($config, 'PlentyTestPlugin.footerSubscribeLabel', $defaults['subscribe']['label']),
                'fields'      => ConfigHelper::json($config, 'PlentyTestPlugin.footerSubscribeFieldsJson', $defaults['subscribe']['fields']),
                'submitLabel' => ConfigHelper::text($config, 'PlentyTestPlugin.footerSubmitLabel', $defaults['subscribe']['submitLabel']),
                'cancelLabel' => ConfigHelper::text($config, 'PlentyTestPlugin.footerCancelLabel', $defaults['subscribe']['cancelLabel']),
            ],

            'social' => [
                ['label' => 'Facebook', 'icon' => 'facebook', 'href' => ConfigHelper::text($config, 'PlentyTestPlugin.footerSocialFacebook', $defaults['social'][0]['href'])],
                ['label' => 'Twitter', 'icon' => 'twitter', 'href' => ConfigHelper::text($config, 'PlentyTestPlugin.footerSocialTwitter', $defaults['social'][1]['href'])],
                ['label' => 'LinkedIn', 'icon' => 'linkedin', 'href' => ConfigHelper::text($config, 'PlentyTestPlugin.footerSocialLinkedin', $defaults['social'][2]['href'])],
                ['label' => 'YouTube', 'icon' => 'youtube', 'href' => ConfigHelper::text($config, 'PlentyTestPlugin.footerSocialYoutube', $defaults['social'][3]['href'])],
                ['label' => 'Instagram', 'icon' => 'instagram', 'href' => ConfigHelper::text($config, 'PlentyTestPlugin.footerSocialInstagram', $defaults['social'][4]['href'])],
            ],

            'legalLinks' => [
                ['label' => ConfigHelper::text($config, 'PlentyTestPlugin.footerLegalDmcaLabel', $defaults['legalLinks'][0]['label']), 'href' => ConfigHelper::text($config, 'PlentyTestPlugin.footerLegalDmcaHref', $defaults['legalLinks'][0]['href'])],
                ['label' => ConfigHelper::text($config, 'PlentyTestPlugin.footerLegalPrivacyLabel', $defaults['legalLinks'][1]['label']), 'href' => ConfigHelper::text($config, 'PlentyTestPlugin.footerLegalPrivacyHref', $defaults['legalLinks'][1]['href'])],
                ['label' => ConfigHelper::text($config, 'PlentyTestPlugin.footerLegalSitemapLabel', $defaults['legalLinks'][2]['label']), 'href' => ConfigHelper::text($config, 'PlentyTestPlugin.footerLegalSitemapHref', $defaults['legalLinks'][2]['href'])],
                ['label' => ConfigHelper::text($config, 'PlentyTestPlugin.footerLegalContactLabel', $defaults['legalLinks'][3]['label']), 'href' => ConfigHelper::text($config, 'PlentyTestPlugin.footerLegalContactHref', $defaults['legalLinks'][3]['href'])],
            ],

            'copyright' => [
                'startYear' => ConfigHelper::int($config, 'PlentyTestPlugin.footerCopyrightStartYear', $defaults['copyright']['startYear']),
                'owner'     => ConfigHelper::text($config, 'PlentyTestPlugin.footerCopyrightOwner', $defaults['copyright']['owner']),
            ],
        ];
    }

    private static function defaults(): array
    {
        return [
            'logo' => [
                'href' => 'https://www.lumi.cn/en/',
                'src'  => 'https://hk-portal-web.oss-cn-hongkong.aliyuncs.com/prd/wwwroot/images/lumilegend.png',
                'alt'  => 'LUMI Legend',
            ],

            'columns' => [
                [
                    'heading' => 'About us',
                    'links' => [
                        ['label' => 'Overview', 'href' => 'https://www.lumi.cn/en/overview'],
                        ['label' => 'Factory Tour', 'href' => 'https://www.lumi.cn/en/factorytour'],
                        ['label' => 'Quality Control', 'href' => 'https://www.lumi.cn/en/qc'],
                    ],
                ],
                [
                    'heading' => 'Products',
                    'links' => [
                        ['label' => 'LUMI Ergo', 'href' => 'https://www.lumi.cn/en/fullproductdirectory/lumi-ergo'],
                        ['label' => 'LUMI Home', 'href' => 'https://www.lumi.cn/en/fullproductdirectory/lumi-home'],
                        ['label' => 'LUMI Pro', 'href' => 'https://www.lumi.cn/en/fullproductdirectory/lumi-pro'],
                        ['label' => 'LUMI New Category', 'href' => 'https://www.lumi.cn/en/organization-solutions/organizers'],
                        ['label' => 'LUMI Game', 'href' => 'https://www.lumigame.cn/en'],
                    ],
                ],
                [
                    'heading' => 'Support',
                    'links' => [
                        ['label' => 'Catalogs', 'href' => 'https://www.lumi.cn/en/resources/e-catalogue'],
                        ['label' => 'Brochures', 'href' => 'https://www.lumi.cn/en/resources/leaflet'],
                        ['label' => 'Certifications', 'href' => 'https://www.lumi.cn/en/resources/certification'],
                        ['label' => 'Videos', 'href' => 'https://www.lumi.cn/en/resources/videolist'],
                        ['label' => "Buyer's Guide", 'href' => 'https://www.lumi.cn/en/buying-guide'],
                        ['label' => 'White Papers', 'href' => 'https://www.lumi.cn/en/resources/white-papers'],
                        ['label' => 'Marketing Support', 'href' => 'https://www.lumi.cn/en/resources/marketing-support'],
                        ['label' => 'Troubleshooting Guide', 'href' => 'https://www.lumi.cn/en/troubleshooting'],
                        ['label' => 'FAQ', 'href' => 'https://www.lumi.cn/en/faq'],
                    ],
                ],
                [
                    'heading' => 'News',
                    'links' => [
                        ['label' => 'News & Blog', 'href' => 'https://www.lumi.cn/en/news&blog'],
                        ['label' => 'Trade Show Calendar', 'href' => 'https://www.lumi.cn/en/news/trade-show'],
                    ],
                ],
            ],

            'subscribe' => [
                'label' => 'Subscribe',
                'fields' => [
                    ['name' => 'name', 'label' => 'Your Name', 'type' => 'text'],
                    ['name' => 'country', 'label' => 'Select Country or Region', 'type' => 'text'],
                    ['name' => 'company', 'label' => 'Your Company', 'type' => 'text'],
                    ['name' => 'email', 'label' => 'Email Address', 'type' => 'email'],
                    ['name' => 'product', 'label' => 'Product Name', 'type' => 'text'],
                    ['name' => 'message', 'label' => 'Question or Comment', 'type' => 'textarea'],
                ],
                'submitLabel' => 'Submit',
                'cancelLabel' => 'Cancel',
            ],

            'social' => [
                ['label' => 'Facebook', 'href' => 'https://www.facebook.com/LumiLegend/', 'icon' => 'facebook'],
                ['label' => 'Twitter', 'href' => 'https://twitter.com/#!/Lumi_Legend', 'icon' => 'twitter'],
                ['label' => 'LinkedIn', 'href' => 'https://www.linkedin.com/company/lumi-legend-corporation/', 'icon' => 'linkedin'],
                ['label' => 'YouTube', 'href' => 'http://www.youtube.com/user/LumiLegend2005?feature=mhee', 'icon' => 'youtube'],
                ['label' => 'Instagram', 'href' => 'https://www.instagram.com/lumilegendofficial/', 'icon' => 'instagram'],
            ],

            'legalLinks' => [
                ['label' => 'DMCA Notice', 'href' => 'https://www.lumi.cn/en/dmca'],
                ['label' => 'Privacy Policy', 'href' => 'https://www.lumi.cn/en/privacypolicy'],
                ['label' => 'Site Map', 'href' => 'https://www.lumi.cn/en/sitemap'],
                ['label' => 'Contact us', 'href' => 'https://www.lumi.cn/en/contactus'],
            ],

            'copyright' => [
                'startYear' => 2005,
                'owner' => 'LUMI CORP. All Rights Reserved.',
            ],
        ];
    }
}
