<?php

namespace PlentyTestPlugin\Configs;

use Plenty\Plugin\ConfigRepository;

/**
 * Content for the fixed vertical icon toolbar stuck to the right edge of
 * the viewport (How to Use / Inquiry / Compare / Contact Us on lumi.cn).
 *
 * Editable from the plentymarkets backend under Plugins -> PlentyTestPlugin
 * -> Configuration ("Sidebar" section). Fixed at these 4 items (icon +
 * action type stay code-defined — only label/href text is configurable),
 * so each field is a plain text setting rather than a JSON blob. Blank
 * fields fall back to defaults() below.
 *
 * `action` is either:
 *  - 'link'  -> renders a normal <a href="...">
 *  - 'guide' -> renders a <button> that Sidebar.twig/js hook up to open a
 *               "how to use" guide; lumi.cn's own version opens a popup
 *               this plugin has no equivalent of, so it's a no-op stub —
 *               see the comment in sidebar.js.
 */
class SidebarConfig
{
    public static function get(ConfigRepository $config): array
    {
        $defaults = self::defaults();

        return [
            'items' => [
                [
                    'label'  => ConfigHelper::text($config, 'PlentyTestPlugin.sidebarGuideLabel', $defaults['items'][0]['label']),
                    'icon'   => 'guide',
                    'action' => 'guide',
                ],
                [
                    'label'  => ConfigHelper::text($config, 'PlentyTestPlugin.sidebarInquiryLabel', $defaults['items'][1]['label']),
                    'icon'   => 'inquiry',
                    'action' => 'link',
                    'href'   => ConfigHelper::text($config, 'PlentyTestPlugin.sidebarInquiryHref', $defaults['items'][1]['href']),
                ],
                [
                    'label'  => ConfigHelper::text($config, 'PlentyTestPlugin.sidebarCompareLabel', $defaults['items'][2]['label']),
                    'icon'   => 'compare',
                    'action' => 'link',
                    'href'   => ConfigHelper::text($config, 'PlentyTestPlugin.sidebarCompareHref', $defaults['items'][2]['href']),
                ],
                [
                    'label'  => ConfigHelper::text($config, 'PlentyTestPlugin.sidebarContactLabel', $defaults['items'][3]['label']),
                    'icon'   => 'contact',
                    'action' => 'link',
                    'href'   => ConfigHelper::text($config, 'PlentyTestPlugin.sidebarContactHref', $defaults['items'][3]['href']),
                ],
            ],
        ];
    }

    private static function defaults(): array
    {
        return [
            'items' => [
                ['label' => 'How to Use', 'icon' => 'guide', 'action' => 'guide'],
                ['label' => 'Inquiry', 'icon' => 'inquiry', 'action' => 'link', 'href' => 'https://www.lumi.cn/en/inquiry'],
                ['label' => 'Compare', 'icon' => 'compare', 'action' => 'link', 'href' => 'https://www.lumi.cn/en/comparepage'],
                ['label' => 'Contact Us', 'icon' => 'contact', 'action' => 'link', 'href' => 'https://www.lumi.cn/en/contactus'],
            ],
        ];
    }
}
