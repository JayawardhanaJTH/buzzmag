# Changelog

All notable changes to this theme are documented here.
Format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and [Semantic Versioning](https://semver.org/).

**How to use**
- Add every change under `[Unreleased]` in the right group: `Added`, `Changed`, `Fixed`, `Removed`, `Security`, `Deprecated`.
- On release: rename `[Unreleased]` to `[x.y.z] - YYYY-MM-DD`, bump `Version:` in `style.css` **and** `fl_theme_version` in `functions.php`, then run `build-zip.ps1`.
- Note any **database-affecting** change (renamed theme_mod, sidebar ID, image size, folder slug) with a ⚠️ and the migration steps.

---

## [Unreleased]

### Added
- **Atmospheric Site Canvas & Sunlight Aura** (`css/3d-components.css`):
  - Replaced the flat `#ffffff` canvas with a light, warm morning sunbeam aura radiating from the top behind the header, diffusing into a soft `#f6f8fb` tone.
  - Layered with an ultra-fine 20px micro-texture grid (`rgba(15, 23, 42, 0.032)`) to eliminate the "empty" stark look across wide desktop gutters while maximizing 3D card elevation and contrast.
  - Added glassmorphic backdrop-blur (`12px`) and soft ambient shadows to `#fl-header` so the sunlight glow filters through naturally.
  - Implemented automatic dark mode translation with deep obsidian/crimson/sapphire ambient glows.

### Fixed
- **Homepage Lead Section & 3-Column Grid Alignment**:
  - Fixed horizontal misalignment where the 3-column section (`.fl-home-3col-grid`) was 44px wider than the Lead Hero card (`.fl-lead-section`) and stuck out past the right boundary.
  - Root cause: `grid-template-columns: 31% 40% 29%` combined with `gap: 22px` produced an effective width of `100% + 44px`.
  - Replaced percentage track definitions with fractional units `minmax(0, 31fr) minmax(0, 40fr) minmax(0, 29fr)` so column tracks are computed strictly within 100% of the container width minus the gaps, aligning the lead hero card, the 3-column grid, and the bottom sections perfectly flush on both left and right edges.
- **Footer "Back to Top" Button Desktop Interaction**:
  - Fixed issue where clicking the `.fl-back-to-top` pill button in the modern footer did not scroll to the top of the page on desktop.
  - Bound delegated click handler `$( document ).on( 'click', '#fl-top, .fl-back-to-top' )` in `js/buzzmag.js` with smooth animated scroll (`scrollTop: 0`).
  - Updated anchor link target in `footer.php` from `#fl-top` (`position: fixed`) to `#fl-header` for reliable native fallback.
  - Added dynamic `filemtime` cache-busting to `buzzmag-script` in `functions.php`.
- **Lead Hero News Card Full-Image Dark Mask**:
  - Fixed issue where a black transparent overlay (`rgba(0, 0, 0, 0.75)`) covered the entire image on the desktop and mobile Lead Hero news card (`.fl-lead-hero-card`).
  - Root cause: `.fl-lead-media a` applied `width: 100%; height: 100%` across all child links, forcing the category badge link (`.fl-cat-pill`) to stretch across the entire media container and intercept click events.
  - Scoped full dimensions strictly to the post thumbnail anchor (`.fl-lead-thumb-link`), explicitly sized `.fl-cat-pill` to `width: auto !important; height: auto !important; display: inline-flex;` at the bottom-left corner, and disabled rogue pseudo-element overlays.

## [3.0.0] - 2026-11-09

### Added
- **3D Card Design System** (`css/3d-components.css`):
  - Elevated multi-layer box shadows and rounded edges (`border-radius: 14px`).
  - Hover physics (`translateY(-4px)` with depth transition).
  - Complete dark mode palette and contrast border styling.
- **Lead Post Checkbox**:
  - Meta box in post edit screen (`functions/lead-post.php`) allowing editors to mark any post as "Lead Post" (`_buzzmag_is_lead_post`).
  - Automated fallback query helper `buzzmag_get_lead_post()`.
- **Desktop Homepage (Ada Derana Sinhala style)** (`includes/home-desktop.php`):
  - Hero Lead Post 3D card.
  - 3-Column Grid:
    - Col 1: Latest 10 posts (excluding lead) + Top Viewed post from last 4 days.
    - Col 2: Category blocks (5 posts each) - Local, Off road / Foreign, Business, Sports (3D overall card).
    - Col 3: Sri Lankan utility cards - Biz Today / Video channels, Calendar, Rahu Kalaya (රාහු කාලය), Subha Dishawa (සුබ දිශාව), Maru Sitina Dishawa (මරු සිටින දිශාව), Cartoon of the Day, WhatsApp Community Banner.
  - Below Sections (Desktop only): Politics (6 posts) and Featured (6 posts) in equal 3D grid cards.
- **Mobile Homepage (Unusuma.lk style)** (`includes/home-mobile.php`):
  - Lead post as main post.
  - Latest 10 posts list (3D each).
  - Top Story (6 posts within the past week).
  - Category sections (3 posts each): Local, Off road, Business, Sports, Foreign, Featured (3D overall card).
  - Bottom video channel & astrology stream.
- **Single Post Enhancements** (`single.php` & `includes/single-post-widgets.php`):
  - Main article enclosed in 3D elevated card.
  - Under-post sections: Latest (6 posts) and Most Read (last 36 hours, 6 posts).
  - Desktop sidebar: Main 6 categories with 3 posts from each (Local, Off road, Business, Sports, Foreign, Featured) in 3D category cards.
- **Modern Portal Footer (Unusuma.lk style)** (`footer.php`):
  - Top brand section with Sinhala / English mission description and round social pills.
  - 4-column quick news links (Main News, Categories, Utilities & Astrology, About & Legal).
  - Clean bottom copyright bar with "Back to Top" pill.
- **Customizer Portal Controls** (`functions/customizer.php`):
  - Category slug re-mapping (Local, Off road, Business, Sports, Foreign, Featured, Politics).
  - **4 Video Channels with 5 Videos Each**: Fully customizable channel names, badge tags, accent colors, and 5 video titles and embed URLs per channel (20 videos total).
  - **Calendar**: Custom title and visibility toggle.
  - **Rahu Kalaya & Astrology**: Visibility toggles, custom labels, and manual calculation overrides for Rahu Kalaya, Subha Dishawa, and Maru Sitina Dishawa.
  - **Cartoon of the Day**: Image upload, custom title, caption/description, custom destination link, and visibility toggle.
  - **WhatsApp Community Banner**: Channel/group link, title, description, custom button label, and visibility toggle.
  - Footer description text.
- **Visual Optimization & Column Layout Polish**:
  - **Columns 1 & 2 News Cards**: Refactored post cards to the `[Image] - [Title / Date]` format (`.fl-post-card-horizontal`) with calendar date icon (`fa-calendar`), bold headline, and rounded thumbnail matching the Unusuma.lk desktop reference.
  - **Column 2 Category Cards**: Updated each 3D category card to render all 5 posts with the horizontal `[Image] - [Title / Date]` layout (`.fl-cat-post-item`).
  - **Column 3 Channel Cards**: Removed channel filter tabs; separated each of the 4 channels into its own standalone 3D card (`.fl-channel-card`) featuring channel badge pill, lead video with playable overlay, and 4 compact video rows.
  - **Mobile Responsive Polish**: Tuned horizontal card proportions for mobile devices (<576px) ensuring clean title typography and responsive thumbnail scaling.
  - **Homepage Bottom Sections Spacing**: Expanded separation after the 3-column grid (`margin-top: 60px; padding-top: 40px; border-top`) and expanded gap between Politics and Featured sections to `70px`.
  - **Bottom Section Image Aspect & Framing**: Increased card thumbnail height to `205px` and set `object-position: top center` so headlines and faces are never cropped from the top.
  - **Single Post Sidebar Baseline Alignment**: Relocated `.fl-media-wrap` inside `#fl-post-container` and configured `.fl-single-columns-wrap` as a flex container (`align-items: flex-start; gap: 32px;`), aligning the post image and the top of the sidebar on the exact same horizontal level.
  - **Sidebar Category Card Margins**: Added distinct `margin-bottom: 25px` to `.fl-sidebar-cat-widget` ensuring all 6 category cards have clean vertical breathing room.
  - **Cartoon Placeholder**: Added SVG illustration placeholder at `img/cartoon-placeholder.svg` to eliminate broken image icons before user upload.
  - **Category Overlay Removal**: Removed the dark transparent category badge mask (`.fl-cat-badge`) overlaid across bottom card images and filtered out "Uncategorized" pills from lead posts to ensure clean, unmasked visuals.
  - **Actionable CI/CD Workflow**: Upgraded `.github/workflows/php.yml` into a fully automated pipeline running composer validation, PHP parallel syntax checks, WordPress theme structure audits, automated zip packaging, artifact upload, and GitHub Releases on tags. Added root `composer.json` with `php-parallel-lint`. Updated `build-zip.ps1` to exclude `.github/`, `vendor/`, and `composer.*` from distribution zips.

### Fixed & Security
- **Category Card "More" Button & Navigation**:
  - Fixed issue where clicking the "More" button (`.fl-cat-more` / `තවත් (More)`) in Column 2 category cards failed to navigate due to `$term_link = '#'` when category terms did not have an exact matching slug in the database.
  - Created `buzzmag_resolve_category_term()` providing robust multi-stage resolution: numeric IDs, exact slugs, sanitized slugs, exact term names, title parenthesis parsing, and fuzzy keyword mappings (`local` -> `deshiya`/`lanka`, `sports` -> `krida`, `business` -> `vyaparika`, `offroad` -> `foreign`/`pitarata`, etc.).
  - Created `buzzmag_get_category_link()` ensuring all category links generate valid, canonical URLs based on the site's permalink structure and never return `#`.
  - Added dynamic fallback to resolve category from the first query post if not matched in advance.
  - Upgraded category card interactivity with 4 navigation touchpoints: clickable category icon (`.fl-cat-icon-link`), clickable title (`.fl-cat-name a`), prominent 3D pill button (`.fl-cat-more`), and dedicated card footer button (`.fl-cat-card-footer` / `.fl-cat-footer-more`).
  - Added clickable section header links and "More" action buttons to the desktop below sections (`.fl-section-header-link`, `.fl-section-more`).
- **Security**: Added nonce and integer validation to post views AJAX counter (`buzzmag_setpostviews`).
- **View Counter**: Fixed million view count bug where posts over 1M showed "1000 K" instead of "M", and eliminated duplicate database writes during read requests.
- **Performance**: Removed secondary unconstrained `WP_Query` in `search.php`, leveraging `$wp_query->found_posts`.
- **WooCommerce Sidebar**: Removed duplicate `description` attribute in `functions.php`.
- **HTML Validity**: Fixed stray unclosed `</article>` tag in `attachment.php`.
- **PHP Syntax**: Fixed double-echo in `includes/loop-tabs.php`.
- **Header Escaping**: Escaped `get_bloginfo('name')` in `header.php`.
- **Compatibility**: Declared PHP 7.4+ and WordPress 6.7+ support in `style.css`.

---

## [2.1] - Original baseline (BuzzMag by FlatLayers)

Starting point of this project, imported as-is from FlatLayers BuzzMag v2.1.
- Classic PHP theme, Customizer-driven, jQuery front-end.
- Bundled required plugin: `flatlayers-buzzmag-addons` v1.0.

