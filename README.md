# PlentyTestPlugin

A minimal PlentyONE (plentymarkets) plugin that overrides the storefront
homepage (`/`) with a hardcoded static demo page.

## Structure

- `plugin.json` — plugin manifest (namespace, service provider, dependency on `IO`)
- `composer.json` — PSR-4 autoload mapping (`PlentyTestPlugin\` → `src/`)
- `src/Providers/PlentyTestPluginServiceProvider.php` — boots the plugin, registers a route override for `/`
- `src/Controllers/DemoHomeController.php` — renders the demo template
- `resources/views/content/Home.twig` — the hardcoded homepage content
- `resources/css/demo-home.css` — homepage styles (external file, not inline — see note below)
- `resources/js/demo-home.js` — hero carousel + background-image behavior (external file, not inline — see note below)

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
