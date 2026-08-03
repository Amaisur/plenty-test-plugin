<?php

namespace PlentyTestPlugin\Configs;

/**
 * Content for the fixed vertical icon toolbar stuck to the right edge of
 * the viewport (How to Use / Inquiry / Compare / Contact Us on lumi.cn).
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
    public static function get(): array
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
