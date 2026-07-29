# PlentyTestPlugin

A minimal PlentyONE (plentymarkets) plugin that overrides the storefront
homepage (`/`) with a hardcoded static demo page.

## Structure

- `plugin.json` — plugin manifest (namespace, service provider, dependency on `IO`)
- `composer.json` — PSR-4 autoload mapping (`PlentyTestPlugin\` → `src/`)
- `src/Providers/PlentyTestPluginServiceProvider.php` — boots the plugin, registers a route override for `/`
- `src/Controllers/DemoHomeController.php` — renders the demo template, passing header + hero + footer content into Twig
- `src/Configs/HeaderConfig.php` — all header content (logo, nav labels/links, mega menu, language switcher, search copy) as a plain PHP array; edit this to change what the header shows, never the Twig
- `src/Configs/HeroConfig.php` — the homepage hero slider's slides (image, link, series label, title) as a plain PHP array
- `src/Configs/FooterConfig.php` — the footer's link columns, social links, legal links, copyright and "Subscribe" form fields as a plain PHP array (mirrors lumi.cn's own footer content)
- `resources/views/content/Home.twig` — the homepage content; includes the header, hero, and footer partials
- `resources/views/content/partials/Header.twig` — renders `HeaderConfig`'s data into the LUMI-style sticky header/mega-menu markup
- `resources/views/content/partials/Hero.twig` — renders `HeroConfig`'s slides into the autoplaying hero slider (desktop tab bar + mobile swipe carousel)
- `resources/views/content/partials/Footer.twig` — renders `FooterConfig`'s data into the footer + its "Subscribe" modal
- `resources/css/demo-home.css` / `resources/js/demo-home.js` — homepage styles/behavior (external files, not inline — see note below)
- `resources/css/header.css` / `resources/js/header.js` — header styles/behavior (external files, not inline — see note below)
- `resources/css/hero.css` / `resources/js/hero.js` — hero slider styles/behavior (external files, not inline — see note below)
- `resources/css/footer.css` / `resources/js/footer.js` — footer styles/behavior, including the subscribe modal open/close (external files, not inline — see note below)

## Footer content

- Column links, social links, legal links, copyright and the subscribe form's field list all live in `src/Configs/FooterConfig.php`, matching lumi.cn's actual footer content (verified from the live site, not invented).
- The "Subscribe" button opens a modal with the same fields lumi.cn's inquiry form has (name, country, company, email, product, question). **The form doesn't submit anywhere** — lumi.cn's version posts to their internal CRM, which isn't something this plugin has access to. `Footer.twig`'s `<form>` has `onsubmit="return false;"` as a placeholder; wire up a real `action` (or an AJAX call to your own backend) before relying on it to actually capture inquiries.
- The footer's visual design (dark background, spacing, typography) reuses the header's design tokens (`--brand`, `--ink`, `--font`, etc.) for consistency, but was built fresh rather than copied from lumi.cn's actual CSS, since only the content/structure was fetched, not their stylesheet.

## Header content & search

- All header text/links (nav, mega menu columns, language switcher, logo) live in `src/Configs/HeaderConfig.php` as a plain array — change the array, not `Header.twig`, to edit content.
- The search form submits a normal GET request to `/search` with the query in the `query` field, matching `IO\Controllers\ItemSearchController::showSearch()`, which reads `request->get('query')`. Both values are hardcoded in `DemoHomeController::show()` rather than pulled from a `config.json` backend setting — a `config.json` was tried here and repeatedly failed plugin validation with no visible error (the plugin just silently fell back to the shop's default homepage), so it was removed to eliminate that as a variable. If you want these backend-editable again, reintroduce `config.json` on its own afterward, deploy, and confirm the plugin still loads before adding anything else on top of it.

## How it works

The service provider's `boot()` method registers a `GET /` route that points
at `DemoHomeController::show()`, which renders `Home.twig` instead of
whatever the shop normally shows on its homepage (category page, CMS page, etc).

## Testing this

This plugin only runs inside a real PlentyONE backend — there's no local
runtime for it, so it can't be started or previewed from this machine. To try it:

1. Zip this folder's contents (or push to a Git repo) and upload it as a new
   plugin in your plentymarkets backend under **Plugins → Plugin overview → Upload plugin**.
2. Add the plugin to your active **plugin set** and set it to **active**.
3. Deploy the plugin set.
4. Open the shop's homepage — it should now show the hardcoded demo page.

## Note on CSS/JS and Content-Security-Policy

CSS and JS are kept as separate files (`resources/css/demo-home.css`,
`resources/js/demo-home.js`) rather than inline `<style>`/`<script>` blocks,
because PlentyONE shops commonly send a Content-Security-Policy header that
blocks inline styles/scripts (`unsafe-inline` disabled) — inline blocks will
silently fail with a CSP console error in that case.

The `<link>`/`<script src>` paths in `Home.twig` use the platform's
`plugin_path('PlentyTestPlugin')` Twig function
(e.g. `{{ plugin_path('PlentyTestPlugin') }}/css/demo-home.css`), which
resolves to this plugin's `resources` folder at render time. This is the
documented plentymarkets convention for referencing a plugin's own static
resources from Twig — no manual CDN/URL wiring needed.

## Note on the manifest schema

`plugin.json`'s exact required/optional fields can change between
plentymarkets platform versions. Before deploying, it's worth generating a
fresh plugin skeleton from your backend's **Plugin IDE / Plugin Builder** and
diffing its `plugin.json` against this one, in case your platform version
expects slightly different fields.
# plenty-test-plugin
