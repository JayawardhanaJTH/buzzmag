# PROJECT MEMORY — BuzzMag Theme Rebrand

> **Purpose:** The single source of truth for this project. Read this first before any change.
> Update the **"Rebrand Decisions"** and **"Session Log"** sections every time something changes.
> Companion docs: [`COMPONENT_MAP.md`](COMPONENT_MAP.md) · [`DEPLOYMENT.md`](DEPLOYMENT.md) · [`CHANGELOG.md`](CHANGELOG.md)

---

## 1. Project Snapshot

| Item | Value |
|---|---|
| Original theme | **BuzzMag** v2.1 by **FlatLayers** (ThemeForest item 19207752) |
| Rebrander & Maintainer | **Tiran Jayawardhana** (`jayawardhanatiran@gmail.com`) |
| Type | Classic PHP WordPress theme (NOT a block/FSE theme), jQuery-based front-end |
| Local path | `c:\xampp\htdocs\wordpress\wp-content\themes\buzzmag` (XAMPP) |
| Theme slug (folder name) | `buzzmag` ⚠️ see §11 before renaming |
| Text domain | `buzzmag` (611 usages across 44 files) |
| PHP function prefix | `buzzmag_` |
| PHP constants | `fl_theme_name`, `fl_theme_path`, `fl_theme_version` (in `functions.php`) |
| CSS class/ID prefix | `fl-` (e.g. `#fl-header`, `.fl-post`), CSS vars `--fl-*` |
| JS global object | `buzzmag` (from `wp_localize_script`) |
| Declared support | `Tested up to: 5.9`, `Requires PHP: 5.6` (out of date, update during rebrand) |
| Required companion plugin | `flatlayers-buzzmag-addons` v1.0 (bundled zip, force-activated via TGMPA) |
| Third-party libs | Font Awesome 4.7.0, Owl Carousel 2.3.4, Masonry 4.2.2, FitVids 1.1, Theia Sticky Sidebar 1.4.0, TGM Plugin Activation |
| Git | Repo is initialized on `master` but has **no commits yet**. Make a baseline commit before you edit anything. |

---

## 2. Directory Map (every file and what it does)

```
buzzmag/
├── style.css                 Theme header (name/author/version) + ALL front-end CSS (3,244 lines, 14 sections)
├── rtl.css                   RTL overrides (WordPress loads it automatically when the site is RTL)
├── screenshot.png            Theme thumbnail in wp-admin (should be 1200×900). REBRAND
├── readme.txt                Theme info. REBRAND
├── functions.php             Bootstrap: constants, theme supports, enqueue, sidebars, post views, layout engine, dark mode, TGMPA
│
├── header.php                <head>, header bar (drawer btn, logo, main menu, social, cart, dark switch, search), drawer, search overlay; opens #fl-main-warp
├── footer.php                Footer ad, 3 footer widget columns, footer menu, copyright; closes #fl-main-warp
├── sidebar.php               #fl-sidebar (sticky option); shows WooCommerce sidebar on shop pages
├── searchform.php            Search form markup
├── comments.php              Comment toggle button + list + form
│
├── index.php                 HOME / blog: featured block + home ad + tabbed loops (Latest/Trending/Audio/Video/Gallery)
├── single.php                Single post: post-format media, header/meta, content, tags, post ad, author box, related, editor picks, comments
├── page.php                  Default page (WooCommerce cart/checkout/account aware)
├── archive.php               Date/other archives
├── category.php              Category archive (shows sub-category links + per-category layout)
├── tag.php                   Tag archive
├── author.php                Author archive with avatar + socials
├── search.php                Search results
├── attachment.php            Attachment page
├── 404.php                   Not found + search + editor picks
│
├── functions/
│   ├── customizer.php        ALL Customizer panels/settings + buzzmag_customizer_output() → inline CSS variables
│   ├── loops.php             Loop engine: buzzmag_loop(), pagination, 6 query loops, AJAX handler buzzmag_loops_ajax
│   ├── mega-menu.php         Category mega-menu: admin checkbox, front-end markup, AJAX posts
│   ├── category-options.php  Per-category "layout" field (term meta buzzmag_cat_layout)
│   ├── woocommerce.php       WooCommerce wrappers, columns, cart fragment (only loaded if WooCommerce is active)
│   ├── class-tgm-plugin-activation.php  3rd-party lib that installs/forces the addon plugin
│   └── flatlayers-buzzmag-addons.zip    Bundled companion plugin (see §9). REBRAND
│
├── includes/                 Reusable template parts (get_template_part)
│   ├── loop-post.php         ONE post card (used by every loop)
│   ├── loop-tabs.php         Home tab bar
│   ├── social-icons.php      Header social icons (from Customizer)
│   ├── author-box.php        "Written By" box on single posts
│   ├── related-posts.php     "You might also like" (by tags or category)
│   ├── editor-picks.php      "Editor Picks" (by category slugs)
│   └── featured-loops/
│       ├── 1post.php         Big hero post (background image)
│       ├── 4posts.php        4-post featured grid
│       ├── 5posts.php        5-post featured grid (accepts offset arg)
│       └── 6posts.php        = 1post + 5posts(offset 1)  ← default
│
├── templates/                Page/Post templates (selectable in editor "Template" dropdown)
│   ├── loop-latest.php       "Latest Posts Page"
│   ├── loop-trending.php     "Trending Posts Page"
│   ├── loop-audio.php        "Audio Posts Page"
│   ├── loop-video.php        "Video Posts Page"
│   ├── loop-gallery.php      "Gallery Posts Page"
│   ├── page-full-width.php   "Full Width Page"
│   ├── page-sidebar-left.php "Left Sidebar Page"
│   ├── page-sidebar-right.php"Right Sidebar Page"
│   ├── post-full-width.php   "Full Width Post"
│   ├── post-sidebar-left.php "Left Sidebar Post"
│   └── post-sidebar-right.php"Right Sidebar Post"
│
├── css/
│   ├── editor-style.css / editor-style-rtl.css   Gutenberg editor styling
│   ├── woocommerce.css / woocommerce-rtl.css     Shop styling
│   ├── font-awesome.min.css + font-awesome/      Icon font (FA 4.7)
│   └── owl.carousel.min.css
├── js/
│   ├── buzzmag.js            ALL custom front-end behaviour (see COMPONENT_MAP §7)
│   ├── fitvids.js, masonry.pkgd.min.js, owl.carousel.min.js, theia-sticky-sidebar.js
├── img/
│   ├── ad.jpg                Default ad banner (FlatLayers promo). REBRAND/remove
│   ├── buzzmag_small.png     Placeholder thumb 200×165. REBRAND
│   └── buzzmag_medium.png    Placeholder thumb 554×346. REBRAND
└── languages/
    ├── buzzmag.pot           Translation template
    └── ar.po / ar.mo         Arabic translation
```

---

## 3. Boot Sequence (`functions.php`)

| Lines | What happens |
|---|---|
| 3–6 | Constants `fl_theme_name='BuzzMag'`, `fl_theme_path=get_template_directory_uri()`, `fl_theme_version='2.1'` |
| 9–11 | `$content_width = 800` |
| 14–68 | `buzzmag_theme_setup` on `after_setup_theme`: menus, feed links, post formats (video/audio/gallery), thumbnails + 4 image sizes, textdomain, title-tag, editor styles + Google Fonts, responsive embeds, align-wide, WooCommerce |
| 71–74 | Inline customizer CSS added to block editor |
| 77–115 | `buzzmag_addons_scripts` on `wp_enqueue_scripts`: all CSS/JS, inline CSS vars, localizes `buzzmag` JS object |
| 118–184 | 6 widget areas registered |
| 187–190 | Pages get excerpt support |
| 194 / 197 / 201–203 | Includes `category-options.php`, `customizer.php`, `woocommerce.php` (only when WooCommerce is active) |
| 207–219 | `buzzmag_google_fonts()` builds Google Fonts URL from Customizer |
| 223–272 | Post views counter (AJAX setter + getter) |
| 275 / 278 | Includes `mega-menu.php`, `loops.php` |
| 281–385 | `buzzmag_layout_settings()`, the **layout engine** (see COMPONENT_MAP §4) |
| 388–409 | `buzzmag_color_mode()` prints dark-mode cookie script in `<head>` |
| 412–461 | TGMPA: requires and force-activates the bundled addon plugin |

---

## 4. Registered WordPress Features

**Menus:** `main-menu` (header), `footer-menu` (footer, depth 1). Menus assigned to any *other* location (e.g. inside the Drawer as a widget) get accordion arrows.

**Widget areas (sidebar IDs):**
| ID | Name | Rendered in |
|---|---|---|
| `buzzmag_sidebar` | Sidebar | `sidebar.php` |
| `buzzmag_drawer` | Drawer | `header.php` (slide-out off-canvas panel) |
| `buzzmag_footer1..3` | Footer Widget 1–3 | `footer.php` |
| `buzzmag_woocommerce_sidebar` | WooCommerce Sidebar | `sidebar.php` on WooCommerce pages |

**Image sizes:** `buzzmag_small` 200×165 crop · `buzzmag_medium` 554×346 crop · `buzzmag_masonry` 554×auto · `buzzmag_large` 1140×640 crop

**Post formats:** standard, `audio`, `video`, `gallery` (the media fields come from the addon plugin)

---

## 5. Customizer Settings Reference (`get_theme_mod` keys)

All of these live in `functions/customizer.php`. They are stored in the DB option **`theme_mods_buzzmag`** (tied to the folder name!).

| Section | Key | Default | Used in |
|---|---|---|---|
| General | `sidebar_position` | right | customizer output CSS |
| | `disable_sticky_sidebar` | off | sidebar.php |
| | `hide_sidebar_post` / `hide_sidebar_page` | off | single.php / page.php |
| | `infinite_scroll` | off | loops.php pagination |
| | `trending_date` | 30 (days) | trending loop |
| | `category_layout` / `author_layout` / `search_layout` / `archive_layout` | grid_sidebar | layout engine |
| | `shop_layout`, `hide_sidebar_product` | grid_sidebar / off | woocommerce.php |
| Header | `logo`, `logo_dark` | none (falls back to site title) | header.php |
| | `dark_mode` (= **disable** dark mode), `dark_mode_default` | off | header, functions, customizer |
| | `fixed_header` (= **disable** fixed) | off | CSS output |
| | `header_drawer` (hide drawer desktop), `header_social`, `header_search`, `header_cart`, `header_account` | off | header.php |
| Home | `home_layout` | grid_sidebar | layout engine |
| | `featured_style` | 6posts (`none`/`1post`/`4posts`/`5posts`/`6posts`) | index.php |
| | `featured_cats` | empty (comma-separated slugs) | featured-loops |
| | `hide_trending` / `hide_audio` / `hide_video` / `hide_gallery` | off | index.php, loop-tabs.php |
| | `sticky_tabs` (= **disable**) | off | CSS output |
| | `home_ad` | ad.jpg HTML | index.php |
| Post | `related_type` | tags | related-posts.php |
| | `editor_cats` | empty | editor-picks.php |
| | `hide_author_box`, `hide_related_box`, `hide_editorpicks_box` | off | includes |
| | `hide_meta_author/date/views/tags/comments` | off | all post cards & single |
| | `post_ad` | ad.jpg HTML | single.php, post templates |
| Footer | `hide_footer_widgets` | off | footer.php |
| | `copyrights` | "© YEAR Site. Designed & Developed by FlatLayers" | footer.php. REBRAND |
| | `footer_ad` | ad.jpg HTML | footer.php |
| Colors: General | `accent_color` **#ed0e28**, `body_bg` #fff, `content_color` #444, `headings_color` #111, `meta_color` #777, `buttons_bg` #111 | | CSS vars |
| Colors: Header | `header_bg` #fff, `header_color` #111, `submenu_bg` #fff, `submenu_color` #111 | | CSS vars |
| Colors: Footer | `footer_bg` #111, `footer_color` #777, `footer_headings_color` #fff | | CSS vars |
| Typography | `headings_font` Montserrat, `headings_font_weight` 700, `body_font` Roboto, `body_font_size` 16 | | Google Fonts + CSS vars |
| Social (Header) | `twitter facebook instagram vimeo youtube soundcloud dribbble pinterest linkedin vk behance flickr mail rss` | empty | social-icons.php |

**CSS variables emitted** (`customizer.php` L1181–1230): `--fl-body-font-size, --fl-body-font, --fl-headings-font, --fl-headings-font-weight, --fl-accent-color, --fl-body-background, --fl-body-color, --fl-headings-color, --fl-meta-color, --fl-button-background, --fl-header-background, --fl-header-color, --fl-submenu-background, --fl-submenu-color, --fl-footer-background, --fl-footer-color, --fl-footer-headings-color, --fl-input-background` + a hard-coded `[data-theme="dark"]` palette.

> 💡 **Rebrand tip:** changing the brand colour = change the defaults in `customizer.php` (setting default **and** the fallback in `buzzmag_customizer_output()`). `style.css` uses the vars, so most colours follow automatically.

---

## 6. Data the Theme Stores in the Database

| Storage | Key | Written by | Notes |
|---|---|---|---|
| Option | `theme_mods_buzzmag` | Customizer | All settings in §5 + menu locations. **Folder-name dependent** |
| Post meta | `post_views_count` | AJAX `buzzmag_setpostviews` | Powers Trending + view counts |
| Post meta | `_format_gallery_images`, `_format_audio_embed`, `_format_video_embed` | Addon plugin | Read in single.php / post templates |
| Term meta | `buzzmag_cat_layout` | category-options.php | Per-category layout |
| Nav menu item meta | `_menu_item_megamenu` | mega-menu.php | Enables mega menu per category item |
| User meta | `twitter facebook instagram youtube linkedin pinterest vk` | Addon plugin | Author box / author page socials |
| Transient | `{IP}x{postID}` (60 s) | post views | Throttles view counting |
| Browser cookie | `buzzmag_color_theme` = light/dark | functions.php + buzzmag.js | Dark mode persistence |

---

## 7. AJAX Endpoints (`admin-ajax.php`, all public: `wp_ajax_` + `wp_ajax_nopriv_`)

| Action | Handler | Params | Purpose |
|---|---|---|---|
| `buzzmag_setpostviews` | functions.php `buzzmag_setpostviews` | `postID` | +1 view (skips admins, 60 s per IP) |
| `buzzmag_loops_ajax` | loops.php `buzzmag_loops_ajax` | `loop`, `next`, `thumb_size`, `query_vars` | Tabs + Load More + Infinite scroll |
| `buzzmag_megamenu_posts_ajax` | mega-menu.php | `term_id` | Mega-menu sub-category posts |

---

## 8. Front-end Assets (enqueue handles)

CSS: `font-awesome`, `owl-carousel`, `buzzmag-google-fonts`, `buzzmag-style` (style.css + inline vars), `buzzmag-woocommerce-style`(+rtl)
JS (footer): `jquery-fitvids`, `masonry-script`, `jquery-theia-sticky-sidebar`, `owl-carousel`, `buzzmag-script` (js/buzzmag.js), `comment-reply`

`style.css` sections: 1 Reset/Gutenberg (L36) · 3 Headings (L657) · 2 Containers (L680) · 4 Header+Drawer (L723) · 5 Featured (L1333) · 6 Loops (L1620) · 7 Sidebar/Widgets (L1790) · 8 Article (L2185) · 9 Ajax pagination (L2281) · 10 Single/Page (L2328) · 11 Comments (L2566) · 12 Footer (L2717) · 13 Archive boxes (L2789) · 14 Media queries (L2838)

---

## 9. Bundled Plugin: `functions/flatlayers-buzzmag-addons.zip`

Plugin "BuzzMag Theme Addons" v1.0 by FlatLayers, text domain `flatlayers`, prefix `fl_` / `FL_`.
- `addons/post-formats.php`: "Post Formats" metabox (audio/video embed URL, gallery image picker) → the `_format_*` post meta
- `addons/user-socials.php`: social URL fields on user profiles
- Widgets (labels use the theme constant `fl_theme_name`, so renaming the constant renames them): `FL_About`, `FL_Category_Posts`, `FL_IDs_Posts`, `FL_Latest_Posts`, `FL_Random_Posts`, `FL_Trending_Posts`, `Fl_Socials`
- TGMPA config: `required`, `force_activation`, `force_deactivation` = true

> To rebrand the plugin: unzip it, edit, re-zip with the **folder at the zip root**, and update `slug`/`source` in `functions.php` L423–432. Changing its slug means WordPress sees a *new* plugin. Deactivate/delete the old one on the live site.

---

## 10. Brand Footprint: Where "BuzzMag / FlatLayers" Appears

### Tier 1: Visible branding (safe to change, no data loss)
| File | Location | What |
|---|---|---|
| `style.css` | L1–14 | Theme Name, URI, Author, Author URI, Description, Version, Tested up to, Tags |
| `readme.txt` | all | Same metadata + wrong doc link (`/docs/tulip/`) |
| `screenshot.png` | | Admin thumbnail (1200×900) |
| `functions.php` | L4 `fl_theme_name` | Also used for widget names |
| `functions.php` | L424 | Plugin display name "BuzzMag Theme Addons" |
| `footer.php` | L6 | Default footer ad → ThemeForest affiliate link + `img/ad.jpg` |
| `footer.php` | L42 | Default copyright "Designed & Developed by FlatLayers" |
| `index.php` | L13 | Default home ad → ThemeForest link |
| `single.php` | L149 | Default post ad → ThemeForest link |
| `templates/post-full-width.php` L141, `post-sidebar-left.php` L144, `post-sidebar-right.php` L144 | | Default post ad → ThemeForest link |
| `functions/customizer.php` | L461, 610, 657 | Ad defaults (`href="#"` + ad.jpg) |
| `functions/customizer.php` | L644 | Copyright default (FlatLayers) |
| `functions/customizer.php` | L680 + L1130 | Accent colour #ed0e28 (brand red) |
| `functions/customizer.php` | L866/899 + L1150/1152 + functions.php L208–209 | Fonts Montserrat / Roboto |
| `img/ad.jpg`, `img/buzzmag_small.png`, `img/buzzmag_medium.png` | | Brand images |
| Comment headers | `customizer.php` L4, `mega-menu.php` L2, `woocommerce.php` L3, `functions.php` L196, `css/woocommerce.css` L2, `css/woocommerce-rtl.css` L2 | "BuzzMag/FlatLayers" in comments |

### Tier 2: Internal identifiers (change only with a plan, can break saved data)
| Identifier | Risk if renamed |
|---|---|
| Folder name `buzzmag` | **Loses all Customizer settings, menu locations, widget placement** (see §11) |
| Text domain `buzzmag` + `languages/*` | Must match the new slug; translations must be regenerated |
| Function prefix `buzzmag_` | Safe if renamed everywhere consistently (611 hits). Cosmetic only |
| Sidebar IDs `buzzmag_*` | Widgets become "Inactive" and have to be re-assigned |
| Image sizes `buzzmag_*` | Must run "Regenerate Thumbnails" afterwards |
| Term meta `buzzmag_cat_layout` | Per-category layouts are lost unless migrated |
| Cookie `buzzmag_color_theme` | Visitors' dark-mode choice resets (harmless) |
| JS object `buzzmag` | Must rename in functions.php + buzzmag.js together |
| CSS prefix `fl-` / `--fl-*` | Huge (CSS+PHP+JS). Not recommended; invisible to visitors |
| Addon plugin slug/text domain | WordPress treats it as a new plugin |

---

## 11. Critical Rule: Theme Folder Name = Theme Identity

WordPress stores Customizer settings under `theme_mods_<folder-name>`. If the folder goes from `buzzmag` to e.g. `newbrand`:
- All Customizer settings (logo, colours, ads, layouts, social links) go back to defaults
- Menu locations become unassigned
- Widgets may move to "Inactive widgets"

**Options:**
1. **Keep folder `buzzmag`, change only the visible name** in `style.css`. Zero data loss. Easiest.
2. **Rename the folder**, then before switching export settings with the *Customizer Export/Import* plugin and import them on the new theme, and re-assign menus/widgets.

➡️ Decision is recorded in §13.

---

## 12. Known Issues / Tech Debt & Fix Status

| # | File:Line | Issue | Severity | Status (v3.0.0) |
|---|---|---|---|---|
| 1 | `functions.php` | Second `elseif ($count >= 1000)` was duplicate, making "M" unreachable | Low | **Fixed** |
| 2 | `functions.php` | WooCommerce sidebar had duplicate `description` key ("Footer Widget 3") | Low | **Fixed** |
| 3 | `functions.php` | `buzzmag_setpostviews` lacked integer sanitization & nonce verification | **Medium** | **Fixed** (`absint`, transient key hash, nonce support) |
| 4 | `header.php` | `get_bloginfo('name')` echoed without escaping | Low | **Fixed** (escaped with `esc_html` / `esc_attr`) |
| 5 | `attachment.php` | Stray `</article>` closing a `<div>` (invalid HTML) | Low | **Fixed** |
| 6 | `includes/loop-tabs.php` | `echo esc_html_e(...)` (double echo) | Cosmetic | **Fixed** |
| 7 | `search.php` | Extra unbounded `WP_Query("s=$s&showposts=-1")` just to count; use `$wp_query->found_posts` | Perf | **Fixed** |
| 8 | `buzzmag_getpostviews()` | Called `delete/add_post_meta` on every read when empty (writes to DB on GET requests) | Perf | **Fixed** (returns empty/0 without writing to DB) |
| 9 | Hard-coded ad defaults | Templates used ThemeForest affiliate links as fallbacks | Branding | **Fixed** (clean fallbacks, no ThemeForest links) |
| 10 | `style.css` | `Tested up to: 5.9`, `Requires PHP: 5.6` | Meta | **Fixed** (Updated to PHP 7.4+, WP 6.7+) |

---

## 13. Rebrand Decisions (fill in as we go)

| Decision | Value | Date |
|---|---|---|
| Theme Identity & Concept | 3D News & Magazine | 2026-11-09 |
| Design Glossary | 3D Cards: rounded edges (`14px`) + multi-layer elevation shadows | 2026-11-09 |
| Keep folder `buzzmag` or rename? | Keep `buzzmag` (safest: zero database/customizer loss) | 2026-11-09 |
| Lead Post System | Post edit screen meta box checkbox (`_buzzmag_is_lead_post`) | 2026-11-09 |
| Desktop Homepage Architecture 3-column grid + below sections (Politics & Featured) | 2026-11-09 |
| Mobile Homepage Architecture single-stream flow (Lead -> Latest 10 -> Top Story 6 -> Categories 3-each -> Videos/Utilities) | 2026-11-09 |
| Single Post Architecture | Desktop: Under post (Latest 6, Most Read 36h 6) + 6-Category Sidebar (3-each)<br/>Mobile: Under post (Latest 6, Most Read 6) | 2026-11-09 |
| Footer Style modern news portal footer with Sinhala/English brand & quick links | 2026-11-09 |
| Sri Lankan Utilities | Interactive Calendar, Rahu Kalaya, Subha Dishawa, Maru Sitina Dishawa, Cartoon, WhatsApp Banner | 2026-11-09 |
| 4 Channels x 5 Videos Section | Channel-wise separated 3D layout (4 channels, 5 videos each = 20 total) with interactive channel filter tabs & Customizer settings | 2026-11-09 |
| Standalone Channel 3D Cards | Removed channel filter tabs; each of the 4 channels rendered as a distinct standalone 3D card with badge pill, featured lead video, and 4 compact rows | 2026-11-09 |
| Post Card Layout Optimization | Columns 1 & 2 post cards updated to Image - [Title / Date] format (`.fl-post-card-horizontal` & `.fl-cat-post-item`) with calendar icon, matching desktop reference | 2026-11-09 |
| Full Feature Customization | Visibility toggles and Customizer overrides for Calendar, Rahu Kalaya, Directions, Cartoon, WhatsApp & Channels | 2026-11-09 |
| Timezone & Sri Lankan DateTime System | Pinned to `Asia/Colombo` (+05:30) with `DateTimeImmutable` helpers (`buzzmag_get_timezone`, `buzzmag_current_datetime`, `buzzmag_date`), automatic WP options default bootstrap, and Customizer override | 2026-11-12 |
| Tech debt & security fixes | Approved & completed in v3.0.0 | 2026-11-09 |
| Version scheme | `3.0.0` (First rebranded release) | 2026-11-09 |

---

## 14. Working Conventions for This Project

1. Every change → add a line under `[Unreleased]` in `CHANGELOG.md`.
2. On release → bump `Version:` in `style.css` **and** `fl_theme_version` in `functions.php` (busts JS cache), then move `[Unreleased]` to a version heading.
3. Build the upload zip with `build-zip.ps1` (see `DEPLOYMENT.md`). Never zip by hand from Explorer with `.git` inside.
4. Test locally at `http://localhost/wordpress` before uploading.
5. **No auto-commits**: Do NOT auto-commit to git. Build the distribution zip (`build-zip.ps1`) when work is ready so it can be tested, and leave changes uncommitted in the working tree for the user to review first.

---

## 15. Session Log

| Date | Summary |
|---|---|
| 2026-11-09 | Full theme analysis. Created PROJECT_MEMORY.md, COMPONENT_MAP.md, DEPLOYMENT.md, CHANGELOG.md, build-zip.ps1, .gitignore. |
| 2026-11-09 | Implemented v3.0.0 Rebrand: 3D card styling, Lead post checkbox, 3-col layout, mobile layout, 36hr/4-day/week query filters, single post under-post/sidebar blocks, modern footer, astrology/calendar/cartoon/whatsapp utilities, Customizer controls, and bug/security fixes. Zip built cleanly in dist/buzzmag-3.0.0.zip. |
| 2026-11-09 | Visual Optimization: Updated Columns 1 & 2 to Image - [Title / Date] card format with calendar date icon matching  desktop image; converted Column 3 to 4 distinct standalone 3D Channel cards (removed tabs); rebuilt dist/buzzmag-3.0.0.zip. |
| 2026-11-09 | Visual Gap & Alignment Fixes: Increased spacing between columns and bottom sections (margin-top 60px, padding-top 40px) and expanded Politics vs Featured gap to 70px; set height 205px and object-position: top center on bottom cards to stop top image cropping; added 25px bottom margin to inner sidebar category cards; aligned single post image and sidebar to start at the exact same horizontal top baseline; removed transparent category badge overlay (.fl-cat-badge) and filtered out "Uncategorized" pills. |
| 2026-11-09 | Actionable CI/CD Pipeline: Configured .github/workflows/php.yml for automated PHP linting, theme structure/version checks, automated zip compilation, artifact upload, and GitHub Releases on tags; added composer.json with php-parallel-lint; excluded dev CI files from production zip. |
| 2026-11-10 | Category Card "More" Button & Navigation Fix: Resolved non-functioning "More" buttons in Column 2 category cards. Built `buzzmag_resolve_category_term()` with multi-stage resolution (IDs, exact/sanitized slugs, names, title parsing, fuzzy keywords) and `buzzmag_get_category_link()` (never returns `#`). Added 4 clickable touchpoints (category icon, title header link, 3D pill button, bottom card footer link) and below sections archive links. |
| 2026-11-11 | Lead Hero News Card Overlay Fix: Fixed black transparent overlay covering the entire lead post image on desktop and mobile. Scoped 100% width/height in `.fl-lead-media` strictly to `.fl-lead-thumb-link` and sized `.fl-cat-pill` to `width: auto; height: auto` so it remains a neat badge chip in the corner and never masks the image or hijacks clicks. |
| 2026-11-11 | Atmospheric Background Canvas: Replaced flat #ffffff background with a warm morning sunlight aura and subtle 20px editorial micro-texture; added 12px glassmorphism to #fl-header; implemented cohesive dark mode ambient glows. Eliminates the stark "empty" margin look while dramatically increasing 3D card elevation and contrast. |
| 2026-11-11 | Back to Top Button Desktop Fix: Fixed `.fl-back-to-top` footer button not scrolling to top on desktop by delegating click event in `buzzmag.js` to both `#fl-top` and `.fl-back-to-top`, retargeting fallback anchor to `#fl-header`, adding cursor pointer and hover elevation in CSS, and enabling automatic `filemtime` cache-busting for scripts. |
| 2026-11-11 | Lead Hero Card & 3-Column Grid Flush Alignment: Replaced `grid-template-columns: 31% 40% 29%` with `minmax(0, 31fr) minmax(0, 40fr) minmax(0, 29fr)` in `.fl-home-3col-grid` to eliminate the 44px gap overflow, perfectly aligning the Lead hero card, 3-column grid, and below sections flush on both left and right edges. |
| 2026-11-12 | Timezone Drift & Sri Lankan Astrological/Calendar Alignment: Fixed theme evaluating dates/times in UTC rather than Asia/Colombo (+05:30). Added `buzzmag_ensure_default_timezone()` in `functions.php` to bootstrap default WordPress options to Sri Lanka time. Created unified `DateTimeImmutable` helpers (`buzzmag_get_timezone`, `buzzmag_current_datetime`, `buzzmag_date`) in `functions/sri-lankan-utilities.php`, re-anchored Rahu Kalaya, astrological directions, daily cartoon, and monthly calendar widget calculations, eliminated drift in post time-ago (`buzzmag_get_time_ago`) and query boundaries, and added a `site_timezone` Customizer control. |
| 2026-11-12 | Rebranding Credit Tag in Footer: Added modern rebranding tag badge (`.fl-rebrand-tag`) to footer bottom bar beside copyright line, attributing "Rebranded by Tiran Jayawardhana" with mailto link, subtle theme accent pill styling, and Customizer controls (`show_rebrand_tag`, `rebrand_tag_text`, `rebrand_author_name`, `rebrand_author_url`). |
| 2026-11-12 | Theme Header Comments & Metadata: Added HTML source header banner comment in `header.php`, `<meta name="author">` in `<head>`, and standard PHP file docblocks to `header.php` and `functions.php`. |
| 2026-11-12 | Unusuma.lk Compact Card Shadow: Applied exact Unusuma.lk card shadow architecture (`1px 1px 10px 1px #abb8c3`, border-radius 12px) to `.fl-3d-card`, eliminating excessive spread/blur in favor of a crisp, defined card contour. |
