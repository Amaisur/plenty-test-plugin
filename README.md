# PlentyTestPlugin

A minimal PlentyONE (plentymarkets) plugin that overrides the storefront
homepage (`/`) with a hardcoded static demo page.

## Structure

- `plugin.json` — plugin manifest (namespace, service provider, dependency on `IO`, points at `config.json`)
- `config.json` — the two backend-editable settings for the header search form (`searchAction`, `searchParam`); see note below
- `composer.json` — PSR-4 autoload mapping (`PlentyTestPlugin\` → `src/`)
- `src/Providers/PlentyTestPluginServiceProvider.php` — boots the plugin, registers a route override for `/`
- `src/Controllers/DemoHomeController.php` — renders the demo template, passing header content + search config into Twig
- `src/Configs/HeaderConfig.php` — all header content (logo, nav labels/links, mega menu, language switcher, search copy) as a plain PHP array; edit this to change what the header shows, never the Twig
- `resources/views/content/Home.twig` — the homepage content; includes the header partial
- `resources/views/content/partials/Header.twig` — renders `HeaderConfig`'s data into the LUMI-style sticky header/mega-menu markup
- `resources/css/demo-home.css` / `resources/js/demo-home.js` — homepage styles/behavior (external files, not inline — see note below)
- `resources/css/header.css` / `resources/js/header.js` — header styles/behavior (external files, not inline — see note below)

## Header content & search

- All header text/links (nav, mega menu columns, language switcher, logo) live in `src/Configs/HeaderConfig.php` as a plain array — change the array, not `Header.twig`, to edit content.
- The search form submits a normal GET request to `searchAction` (default `/search`) with the query in the `searchParam` field (default `query`), matching `IO\Controllers\ItemSearchController::showSearch()`, which reads `request->get('query')`. Both are overridable per-shop from **Plugin → Configuration** (defined in `config.json`) without redeploying, since the search route slug can differ between shops/languages.

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
