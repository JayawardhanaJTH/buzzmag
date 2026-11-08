# COMPONENT MAP: How the Theme Works

> Visual map of how the pieces connect. Diagrams use Mermaid (they render in VS Code with a Mermaid preview extension, and on GitHub/GitLab).
> For file-by-file details see [`PROJECT_MEMORY.md`](PROJECT_MEMORY.md).

---

## 1. Big Picture

```mermaid
flowchart TD
    WP["WordPress Core"] --> FN["functions.php (bootstrap)"]
    FN --> CUS["functions/customizer.php<br/>settings + CSS variables"]
    FN --> LOOPS["functions/loops.php<br/>query loops + AJAX"]
    FN --> MEGA["functions/mega-menu.php"]
    FN --> CATOPT["functions/category-options.php"]
    FN --> WOO["functions/woocommerce.php<br/>(only if WooCommerce active)"]
    FN --> TGM["TGMPA → addon plugin zip"]
    TGM --> PLUGIN["flatlayers-buzzmag-addons plugin<br/>post-format fields, user socials, 7 widgets"]

    WP --> TPL["Template chosen by WP hierarchy<br/>index / single / page / archive / category / tag / author / search / 404"]
    TPL --> HEAD["header.php"]
    TPL --> BODY["Page body"]
    TPL --> SIDE["sidebar.php"]
    TPL --> FOOT["footer.php"]

    BODY --> PARTS["includes/* template parts"]
    BODY --> LOOPS
    CUS -. "inline CSS vars" .-> CSS["style.css"]
    LOOPS -. "AJAX HTML" .-> JS["js/buzzmag.js"]
    MEGA -. "AJAX HTML" .-> JS
    PLUGIN -. "post meta: _format_*" .-> BODY
```

---

## 2. Page Skeleton (every front-end page)

```
┌──────────────────────────── header.php ─────────────────────────────┐
│ #fl-top (scroll-to-top button)                                       │
│ <header id="fl-header">                                              │
│   [☰ #fl-drawer-icon] [#fl-logo] [#fl-topmenu main-menu + megamenu]  │
│   [.header-icons: social | account | cart | dark switch | search]   │
│ </header>                                                            │
│ #fl-drawer  ← "Drawer" widget area (off-canvas)                      │
│ .push-overlay   #fl-search-overlay (search form + top 7 categories)  │
│ <div id="fl-main-warp">                                              │
├────────────────────────── template body ────────────────────────────┤
│  .fl-container                                                       │
│   ┌──────────── #fl-post-container ───────────┐ ┌── #fl-sidebar ──┐ │
│   │ content / loops                           │ │ sidebar.php     │ │
│   └───────────────────────────────────────────┘ └─────────────────┘ │
├──────────────────────────── footer.php ─────────────────────────────┤
│ </div> (closes #fl-main-warp)                                        │
│ .fl-ad (footer_ad)                                                   │
│ <footer id="fl-footer">  3× footer widget columns                    │
│   #fl-copyright: footer-menu + copyright text                        │
└──────────────────────────────────────────────────────────────────────┘
```

---

## 3. Template → Template-Part Map

```mermaid
flowchart LR
    subgraph Templates
        IDX["index.php (Home)"]
        SGL["single.php<br/>+ templates/post-*.php"]
        PG["page.php<br/>+ templates/page-*.php"]
        ARC["archive / category / tag / author / search"]
        LP["templates/loop-*.php<br/>(Latest/Trending/Audio/Video/Gallery pages)"]
        E404["404.php"]
    end

    subgraph Parts["includes/"]
        FEAT["home-desktop.php (Ada Derana 3-Col)<br/>home-mobile.php (Unusuma.lk Single-Stream)"]
        LEAD["Lead Post 3D Hero<br/>(_buzzmag_is_lead_post checkbox)"]
        CARD["Horizontal 3D Post Cards<br/>[Image] - [Title / Date]"]
        CHANNELS["Standalone 4-Channel 3D Cards<br/>(5 Videos Each - No Tabs)"]
        UTIL["sri-lankan-utilities.php<br/>Calendar · Rahu Kalaya · Subha/Maru · Cartoon · WhatsApp"]
        SINGW["single-post-widgets.php<br/>Latest 6 · Most Read 36h 6 · 6-Cat Sidebar"]
        AUTH["author-box.php"]
        FOOT["footer.php (Unusuma.lk modern footer)"]
    end

    IDX --> FEAT
    FEAT --> LEAD
    FEAT --> CARD
    FEAT --> CHANNELS
    FEAT --> UTIL
    SGL --> SINGW
    SGL --> AUTH
    SGL --> CMT["comments.php"]
    PG --> CMT
    E404 --> PICK["editor-picks.php"]
    HDR["header.php"] --> SOC["social-icons.php"]
    HDR --> SF["searchform.php"]
```

---

## 4. Layout Engine: `buzzmag_layout_settings()` (functions.php L281)

Decides **sidebar on/off**, **container width class**, **loop CSS class**, and **thumbnail size** for every listing page.

```mermaid
flowchart TD
    A{"Which page?"} -->|"is_home() or loop-* page template"| H["theme_mod home_layout"]
    A -->|"is_category()"| C{"term meta<br/>buzzmag_cat_layout"}
    C -->|"set"| CL["category's own layout"]
    C -->|"default / empty"| CD["theme_mod category_layout"]
    A -->|"is_author()"| AU["theme_mod author_layout"]
    A -->|"is_search()"| S["theme_mod search_layout"]
    A -->|"else (tag/date)"| AR["theme_mod archive_layout"]
    H & CL & CD & AU & S & AR --> SW["switch(layout)"]
    SW --> OUT["returns: sidebar · width_class · loop_class · thumb_size"]
```

| Layout key | Sidebar | Loop class | Thumb |
|---|---|---|---|
| `grid` | ✗ | `fl-grid` | medium |
| `grid_sidebar` (default) | ✓ | `fl-grid` | medium |
| `grid_col_3` | ✗ | `fl-grid col-3` | medium |
| `list` / `list_sidebar` | ✗ / ✓ | `fl-list` | medium |
| `masonry` / `masonry_sidebar` | ✗ / ✓ | `fl-grid fl-masonry` | masonry |
| `masonry_col_3` | ✗ | `fl-grid col-3 fl-masonry` | masonry |
| `standard` / `standard_sidebar` | ✗ / ✓ | `fl-standard` | large |

No sidebar → `width_class = fl-full-width`.

---

## 5. Homepage Render + AJAX Tabs

```mermaid
sequenceDiagram
    participant B as Browser
    participant I as index.php
    participant L as loops.php
    participant J as buzzmag.js
    participant A as admin-ajax.php

    B->>I: GET /
    I->>I: featured block (featured_style → includes/featured-loops/*)
    I->>I: home_ad
    I->>I: loop-tabs.php (Latest / Trending / Audios / Videos / Galleries)
    I->>L: buzzmag_default_loop(page 1) → #fl-latest-posts
    I-->>B: HTML (other tab panels are EMPTY divs)
    B->>J: user clicks "Trending" tab
    J->>A: POST action=buzzmag_loops_ajax, loop=trending, next=1, thumb_size
    A->>L: buzzmag_trending_loop(1)
    L-->>J: HTML cards + "Load More" link
    J->>B: inject into #fl-trending-posts, re-run Masonry
    B->>J: click "Load More" (or scroll if infinite_scroll)
    J->>A: POST loop=…, next=N+1, query_vars (for default loop)
    A-->>J: next page cards → appended to .fl-loop-posts
```

**Loop queries (loops.php):**
| Loop | Query |
|---|---|
| default | current page's main query (`$wp_query->query`) |
| latest | all posts |
| trending | `meta_key=post_views_count` desc, published in last `trending_date` days |
| audio / video / gallery | `post_format` taxonomy |

---

## 6. Single Post Composition (`single.php`)

```mermaid
flowchart TD
    S["single.php"] --> MF{"get_post_format()"}
    MF -->|gallery| G["Owl Carousel of _format_gallery_images"]
    MF -->|audio| AU["oEmbed _format_audio_embed"]
    MF -->|video| V["oEmbed _format_video_embed"]
    MF -->|standard| T["Featured image (buzzmag_large)"]
    S --> HD["Category · H1 title · excerpt · meta (author/date/comments/views)"]
    S --> CT["the_content() + wp_link_pages"]
    S --> TG["Tags"]
    S --> AD["post_ad"]
    S --> AB["includes/author-box.php"]
    S --> RP["includes/related-posts.php (tags or category, 6 posts)"]
    S --> EP["includes/editor-picks.php (editor_cats, 6 posts)"]
    S --> CM["comments.php (collapsed toggle)"]
    S --> SB{"hide_sidebar_post?"}
    SB -->|no| SBR["sidebar.php"]
    J["buzzmag.js"] -. "POST buzzmag_setpostviews" .-> PV["post_views_count +1"]
```

Post templates `post-full-width / post-sidebar-left / post-sidebar-right` are **copies** of `single.php` with a fixed sidebar setting. Any change to single.php must be repeated in these 3 files.

---

## 7. JavaScript Behaviour Map (`js/buzzmag.js`)

| Feature | Trigger / selector | Notes |
|---|---|---|
| Dark mode switch | `#fl-darkmode` change | sets `<html data-theme>` + cookie `buzzmag_color_theme` |
| Search overlay | `#fl-topsearch` click | fades `#fl-search-overlay` |
| Drawer | `#fl-drawer-icon`, `.push-overlay` | toggles `.open` on `#fl-drawer` |
| FitVids | `.fl-media-wrap` | responsive video embeds |
| Widget menu accordion | `.fl-widget .menu .arrow` | |
| Header offset | `#fl-header` fixed + `#wpadminbar` | used by sticky tabs/sidebar/scrolls |
| Sticky sidebar | `.fl-sticky-sidebar` | Theia Sticky Sidebar |
| Scroll-to-top | `#fl-top` | |
| Gallery slider | `.fl-gallery` | Owl Carousel, RTL-aware |
| Comments toggle | `.fl-comments-toggle`, `.fl-meta a.comments` | |
| Masonry | `.fl-masonry .fl-loop-posts` | re-run after each AJAX load |
| Views counter | `body.single-post` | AJAX `buzzmag_setpostviews` |
| Mega menu tabs | `.fl-megamenu .cats-list .cat-link` | AJAX `buzzmag_megamenu_posts_ajax` |
| Loop tabs | `.fl-loop-tabs a` | AJAX `buzzmag_loops_ajax` |
| Load more / infinite | `.fl-load-more(.infinite)` | AJAX `buzzmag_loops_ajax` |

---

## 8. Customizer → CSS Pipeline

```mermaid
flowchart LR
    ADM["Appearance → Customize"] -->|"save"| DB[("wp_options<br/>theme_mods_buzzmag")]
    DB --> OUT["buzzmag_customizer_output()"]
    OUT -->|"wp_add_inline_style('buzzmag-style')"| FE[":root { --fl-accent-color … }<br/>+ [data-theme=dark] palette"]
    OUT -->|"enqueue_block_editor_assets"| ED["Block editor preview"]
    DB --> GF["buzzmag_google_fonts()"] --> FONTS["fonts.googleapis.com"]
    FE --> STY["style.css uses var(--fl-*)"]
```

---

## 9. Dark Mode Flow

```mermaid
flowchart TD
    A{"theme_mod dark_mode<br/>(= disable)"} -->|"checked"| OFF["No switch, no dark palette"]
    A -->|"unchecked"| B{"dark_mode_default?"}
    B -->|"yes & no 'light' cookie"| C["head script sets cookie = dark"]
    B -->|"no"| D["read cookie"]
    C --> D
    D -->|"dark"| E["html data-theme=dark + check #fl-darkmode"]
    E --> F["CSS vars switch to [data-theme=dark] values"]
    SW["User toggles switch"] --> G["buzzmag.js updates data-theme + cookie"]
```

---

## 10. Mega Menu Flow

```mermaid
flowchart TD
    ADM["Appearance → Menus: tick 'Enable Mega Menu'<br/>(top-level CATEGORY item, no children)"] --> META["nav menu item meta _menu_item_megamenu"]
    META --> CLS["nav_menu_css_class → adds .fl-megamenu"]
    META --> HTML["walker_nav_menu_start_el → injects .megamenu<br/>(5 sub-cats list + 5 latest posts of parent)"]
    HTML --> HOVER["Click sub-cat tab (first load only)"]
    HOVER --> AJ["AJAX buzzmag_megamenu_posts_ajax(term_id)"]
    AJ --> LIST["fills ul#megamenu-cat-ID"]
```

---

## 11. WooCommerce Integration (only if the plugin is active)

```mermaid
flowchart LR
    WC["WooCommerce templates"] -->|"woocommerce_before_main_content"| W1["buzzmag_woocommerce_before_wrapper<br/>opens .fl-container / .fl-box"]
    WC -->|"woocommerce_archive_description"| W2["buzzmag_woocommerce_after_archive<br/>closes box, opens #fl-post-container"]
    WC -->|"woocommerce_after_main_content"| W3["buzzmag_woocommerce_after_wrapper<br/>closes + sidebar.php"]
    WC -->|"loop_shop_columns"| W4["3 cols with sidebar / 4 without"]
    WC -->|"add_to_cart_fragments"| W5["header cart count refresh"]
    HDR["header.php"] --> ICONS["My Account + Cart icons"]
    PG["page.php"] --> CART["cart/checkout/account → no sidebar"]
```

---

## 12. "Where do I change…?" Quick Lookup

| I want to change… | Edit |
|---|---|
| Theme name / author shown in admin | `style.css` header, `readme.txt`, `screenshot.png` |
| Logo | Customizer → Header Settings (or the fallback text in `header.php` L38–44) |
| Brand colours | Customizer defaults in `functions/customizer.php` (setting + `buzzmag_customizer_output`) |
| Dark mode colours | `functions/customizer.php` L1210–1230 |
| Fonts | Customizer Typography defaults + `buzzmag_google_fonts()` in `functions.php` |
| Header layout/icons | `header.php` + style.css §4 |
| Footer / copyright | `footer.php` + customizer `copyrights` default |
| Post card look | `includes/loop-post.php` + style.css §6 |
| Featured (hero) block | `includes/featured-loops/*` + style.css §5 |
| Single post layout | `single.php` **and** the 3 `templates/post-*.php` copies |
| Home tabs | `index.php`, `includes/loop-tabs.php`, `loops.php`, `buzzmag.js` |
| Ads | `index.php`, `footer.php`, `single.php`, `templates/post-*.php` defaults |
| Widgets list | inside the addon plugin zip |
| Translations | `languages/` (regenerate .pot with Poedit / WP-CLI `wp i18n make-pot`) |
