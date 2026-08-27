# PlentyTestPlugin

A minimal PlentyONE (plentymarkets) plugin that overrides the storefront
homepage (`/`) with a hardcoded static demo page.

## Structure

- `plugin.json` — plugin manifest (namespace, service provider, dependency on `IO`)
- `config.json` — every backend-editable content field, grouped into 5 sections (Header, Hero slider, Promo banner, Floating sidebar, Footer) under **Plugins → PlentyTestPlugin → Configuration** in the plentymarkets backend
- `composer.json` — PSR-4 autoload mapping (`PlentyTestPlugin\` → `src/`)
- `src/Providers/PlentyTestPluginServiceProvider.php` — boots the plugin, registers a route override for `/`
- `src/Controllers/DemoHomeController.php` — renders the demo template, injecting `ConfigRepository` and passing header + hero + promo + sidebar + footer content into Twig
- `src/Configs/ConfigHelper.php` — shared helper every `*Config` class uses to read a config value with a safe fallback to its hardcoded default (see "Backend configuration" below)
- `src/Configs/HeaderConfig.php` / `HeroConfig.php` / `PromoConfig.php` / `SidebarConfig.php` / `FooterConfig.php` — each section's content: a `get(ConfigRepository $config)` that reads backend settings (falling back to a private `defaults()` array) — edit `defaults()` to change the built-in content, or edit the backend settings to override it per-shop without redeploying
- `resources/views/content/Home.twig` — the homepage content; includes the header, hero, promo, sidebar, and footer partials
- `resources/views/content/partials/Header.twig` — renders `HeaderConfig`'s data into the LUMI-style sticky header/mega-menu markup
- `resources/views/content/partials/Hero.twig` — renders `HeroConfig`'s slides into the autoplaying hero slider (desktop tab bar + mobile swipe carousel)
- `resources/views/content/partials/Promo.twig` — renders `PromoConfig`'s two-panel banner ("New Arrival" / "Marketing Support" on lumi.cn)
- `resources/views/content/partials/Sidebar.twig` — renders `SidebarConfig`'s fixed vertical icon toolbar (How to Use / Inquiry / Compare / Contact Us)
- `resources/views/content/partials/Footer.twig` — renders `FooterConfig`'s data into the footer + its "Subscribe" modal
- `resources/css/demo-home.css` / `resources/js/demo-home.js` — homepage styles/behavior (external files, not inline — see note below)
- `resources/css/header.css` / `resources/js/header.js` — header styles/behavior (external files, not inline — see note below)
- `resources/css/hero.css` / `resources/js/hero.js` — hero slider styles/behavior (external files, not inline — see note below)
- `resources/css/promo.css` — promo banner styles
- `resources/css/sidebar.css` / `resources/js/sidebar.js` — floating sidebar styles/behavior
- `resources/css/footer.css` / `resources/js/footer.js` — footer styles/behavior, including the subscribe modal open/close (external files, not inline — see note below)

## Backend configuration

Every piece of content — logo images, nav/mega-menu links, hero slides, promo banner, sidebar links, footer columns/social/legal/copyright/subscribe-form-labels — is editable from **Plugins → PlentyTestPlugin → Configuration** in the plentymarkets backend, defined in `config.json`.

Two field shapes are used:
- **Plain text fields** (logo URLs, search settings, promo panel copy, sidebar labels/links, footer social/legal/copyright) — one setting per value.
- **JSON-array fields** (`headerNavJson`, `headerLanguagesJson`, `heroSlidesJson`, `footerColumnsJson`, `footerSubscribeFieldsJson`) — plentymarkets plugin config has no repeater/array field type, so repeating content (the mega menu, hero slides, footer columns, subscribe form fields) is a single `inputTextArea` field holding a JSON array.

Each JSON field ships **pre-filled with its complete built-in content** as the field's `defaultValue`, so the backend shows the real structure to edit rather than an empty box — change the entries you want and leave the rest, or clear the field entirely to fall back to the PHP `defaults()`. The pre-filled JSON is a byte-for-byte equivalent of the matching `*Config.php` `defaults()` array, so saving the field unchanged is a no-op.

### JSON field shapes

`heroSlidesJson`, `headerLanguagesJson`, `footerColumnsJson` and `footerSubscribeFieldsJson` are flat lists whose shape the field label spells out. `headerNavJson` is the involved one — a list of top-level nav entries, each with a `type`:

- `"type": "link"` — `{label, href}`, rendered as a plain nav link.
- `"type": "dropdown"` — adds `links: [{label, href}]`; a link may itself carry `sub: [{label, href}]` for one nested level.
- `"type": "mega"` — adds `columns` (a list of columns, each a list of blocks) plus `quickAccess: {label, links:[{label, href}]}` for the bar along the bottom.

Blocks inside a mega-menu column are also typed:

| `type` | Shape | Renders as |
| --- | --- | --- |
| `brand` | `{label, desc, href}` | Column heading with a sub-label |
| `group` | `{label, href, items:[{label, href, badge?}]}` | A link group; optional `badge` shows a tag such as `New` |
| `solutions` | `{heading, logos:[{href, alt, off, on}]}` | Logo row; `off`/`on` are the normal and hover image URLs |
| `news` | `{heading, headingSmall, cards:[{href, alt, img}]}` | Image card stack |

Keep these in sync: if you change a `defaults()` array in `src/Configs/`, update the matching `defaultValue` in `config.json` too, otherwise the backend will keep offering the old structure as its starting point.

**Every field is safe to leave blank or get wrong.** `ConfigHelper::text()`/`::json()`/`::int()` treat a blank value, or JSON that fails to parse, as "use the built-in default" rather than erroring — a bad edit in the backend degrades that one field back to its default, it never breaks the page. This was a deliberate design choice after `config.json` twice caused the whole plugin to silently fail plugin validation and fall back to the shop's default homepage during development (see git history) — every config read in this plugin is now defensive for exactly that reason.

**Field key naming**: every `formFields` key in `config.json` is globally unique across all 5 sections (e.g. `headerLogoHref` vs `footerLogoHref`, not `logoHref` in both) and referenced from PHP as `PlentyTestPlugin.<thatExactKey>` with no section prefix — plentymarkets resolves `ConfigRepository::get()` keys flat per-plugin, not namespaced per config-menu-section, so reusing a short field name across sections would make two different settings silently read/write the same stored value. Keep this in mind if you add more fields.

## Search

The header's search form submits a normal GET request to `headerSearchAction` (default `/search`) with the query in the `headerSearchParam` field (default `query`), matching `IO\Controllers\ItemSearchController::showSearch()`, which reads `request->get('query')`. Both are backend-editable since the search route slug can differ between shops/languages.

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

## Note on allowed PHP functions

PlentyONE runs plugin PHP in a sandbox with a whitelist of permitted native
functions, checked at **deployment** time — not at runtime. A call to a
function outside that list fails the deployment with
`Syntax errors — php function "x" is not allowed`, and **the plugin set is not
deployed at all**, so the shop keeps serving the last build that deployed
successfully. (This is why an edit can appear to "not update on the site": the
deploy that carried it never landed.)

`json_last_error()` is one such disallowed function — `ConfigHelper::json()`
therefore detects malformed JSON purely via `is_array(json_decode(...))`, which
is equivalent (`json_decode()` returns `null`, not an array, when parsing
fails). Prefer the language constructs and `is_*()` checks already used in
`ConfigHelper` over reaching for additional native functions; if you must add
one, deploy early to confirm it passes validation.
