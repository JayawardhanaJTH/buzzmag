# Changelog

All notable changes to this theme are documented here.
Format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and [Semantic Versioning](https://semver.org/).

**How to use**
- Add every change under `[Unreleased]` in the right group: `Added`, `Changed`, `Fixed`, `Removed`, `Security`, `Deprecated`.
- On release: rename `[Unreleased]` to `[x.y.z] - YYYY-MM-DD`, bump `Version:` in `style.css` **and** `fl_theme_version` in `functions.php`, then run `build-zip.ps1`.
- Note any **database-affecting** change (renamed theme_mod, sidebar ID, image size, folder slug) with a ⚠️ and the migration steps.

---

## [Unreleased]

## [3.1.0] - 2026-11-14

### Added
- **Modern 3D Category Page Architecture** (`category.php`, `css/3d-components.css`, `functions/news-loops.php`):
  - Upgraded the category archive template to match the 70/30 baseline-aligned architecture of `single.php`.
  - Added a modern **3D Category Header Card** (`.fl-category-header-card`) featuring dynamic icon badges, category accent colors (`buzzmag_get_category_badge_meta`), total article count pill, subcategories chips, and category descriptions.
  - Rendered category posts in a responsive 2-column **3D Cards Grid** (`.fl-category-3d-grid`) with thumbnail hover physics and metadata.
  - Implemented modern 3D pagination buttons (`.fl-category-pagination`) with smooth hover elevation and active page styling.
  - Integrated the sticky **6-Category 3D Side Panel** (`buzzmag_render_single_sidebar_categories`) aligned flush with the category header.
  - Integrated the **Below Sections** (`buzzmag_render_single_under_post`) rendering Latest News (6 posts) and Most Read (staged 96h, 6 posts) directly under the category archive feed.
- **Staged 96-Hour Window Strategy for Most Read Posts** (`functions/news-loops.php`):
  - Updated `buzzmag_query_most_viewed_hours()` with a multi-stage backfill architecture.
  - Posts published in the primary 96-hour window (0 to 96 hours ago) are strictly preserved at the top of the list.
  - If fewer than 6 posts exist in that window, it queries the preceding 96-hour window (96 to 192 hours ago) to backfill slots rather than discarding the recent posts.
  - Only fills any remaining unfilled slots with all-time most viewed or latest posts, maintaining strict chronological priority and eliminating abrupt all-time post replacement.
- **3rd Column Promotional Cards: "Advertise With Us", "Facebook Page", & "TikTok"** (`functions/sri-lankan-utilities.php`, `includes/home-desktop.php`, `includes/home-mobile.php`, `functions/customizer.php`, `css/3d-components.css`):
  - Added **"Advertise With Us"** card styled identically to the WhatsApp community card with an energetic amber-orange gradient (`linear-gradient(135deg, #f39c12 0%, #d35400 100%)`), megaphone icon (`fa-bullhorn`), and WhatsApp CTA button with green hover feedback.
  - Added **"Facebook Page"** card with official Facebook blue gradient (`linear-gradient(135deg, #1877f2 0%, #0d5cb6 100%)`), Facebook icon badge (`fa-facebook`), and "Follow on Facebook" action button.
  - Added **"TikTok"** card featuring dark obsidian styling (`linear-gradient(135deg, #010101 0%, #171822 60%, #0d0f18 100%)`), signature cyan/magenta chromatic offset icon badge, inline SVG vector graphic, and pink neon CTA button hover effect (`#fe2c55`).
  - Full WordPress Customizer controls added under *Rebrand 3D Settings* to customize titles, descriptions, links, button labels, or toggle visibility (`hide_advertise_banner`, `hide_facebook_banner`, `hide_tiktok_banner`).
  - Seamlessly rendered on both desktop Column 3 and mobile layout utilities section.
- **English-First Localization Across All Category Cards & Sidebars**:
  - Replaced Sinhala default labels across category cards, sidebar widgets, and footer with clean English labels (e.g. *Lead Story*, *Read Story*, *View All*, *Political News*).
  - Cleaned up footer navigation columns and links.
- **Unusuma.lk Inspired Card Shadow System** (`css/3d-components.css`):
  - Updated `.fl-3d-card` with the exact compact, crisp shadow styling used on Unusuma.lk (`box-shadow: 1px 1px 10px 1px #abb8c3`).
  - Eliminates excessive spread and wide blur, providing a sharp, defined contour outline around cards.
  - Hover elevation updated to `1px 3px 12px 1px #9aaab6` with `translateY(-3px)`.
  - Added dark theme equivalent (`box-shadow: 1px 1px 10px 1px rgba(0, 0, 0, 0.65)`).
- **Theme Header Comments & Attribution** (`header.php`, `functions.php`):
  - Added HTML source header banner comment block to `header.php` displaying rebrand authorship, maintainer contact, and theme version.
  - Added standard `<meta name="author" content="Tiran Jayawardhana">` tag in the `<head>` block.
  - Added full PHP docblocks with `@author`, `@package`, and `@version` annotations to both `header.php` and `functions.php`.
- **Rebranding Credit Tag in Site Footer** (`footer.php`, `css/3d-components.css`):
  - Added a dedicated modern rebranding badge tag to the footer bottom bar next to the copyright text (`.fl-rebrand-tag`).
  - Hardcoded directly into the template with an icon badge (`<i class="fa fa-code"></i> REBRANDED BY`), linked author attribution to `Tiran Jayawardhana` (`mailto:jayawardhanatiran@gmail.com`), and theme accent hover animations.
  - Fully responsive with flex wrap alignment on desktop and clean centered alignment on mobile devices.
  - Updated copyright year generation to utilize timezone-aware `buzzmag_date('Y')`.
- **Atmospheric Site Canvas & Sunlight Aura** (`css/3d-components.css`):
  - Replaced the flat `#ffffff` canvas with a light, warm morning sunbeam aura radiating from the top behind the header, diffusing into a soft `#f6f8fb` tone.
  - Layered with an ultra-fine 20px micro-texture grid (`rgba(15, 23, 42, 0.032)`) to eliminate the "empty" stark look across wide desktop gutters while maximizing 3D card elevation and contrast.
  - Added glassmorphic backdrop-blur (`12px`) and soft ambient shadows to `#fl-header` so the sunlight glow filters through naturally.
  - Implemented automatic dark mode translation with deep obsidian/crimson/sapphire ambient glows.

### Fixed
- **Homepage Column 1 Most Viewed Cards Gap**:
  - Fixed issue where the cards in the "වැඩිම පිරිසක් නැරඹූ (Top Viewed)" section in Column 1 were rendered directly without vertical separation, causing cards to touch with 0px gap.
  - Wrapped loop items in `.fl-most-viewed-stack` in `includes/home-desktop.php` and defined `display: flex; flex-direction: column; gap: 12px;` in `css/3d-components.css` with a sibling selector fallback, matching the exact clean 12px card spacing of the Latest 10 section.
- **Timezone Drift & Sri Lankan Astrological/Calendar Alignment**:
  - Fixed issue where the theme evaluated dates and times in UTC instead of the site's local Sri Lankan timezone (`Asia/Colombo` / UTC+05:30), causing the interactive calendar widget, Rahu Kalaya, astrological directions (Subha/Maru Sitina Dishawa), daily cartoon, and relative query filters to drift or show yesterday's values during early morning hours.
  - Added `buzzmag_ensure_default_timezone()` in `functions.php` on `after_setup_theme` (priority 5) to automatically configure WordPress options `timezone_string` to `'Asia/Colombo'` and `gmt_offset` to `'5.5'` if left unconfigured at fresh WordPress / XAMPP defaults.
  - Implemented unified, timezone-aware helpers in `functions/sri-lankan-utilities.php`:
    - `buzzmag_get_timezone()`: Returns a `DateTimeZone` object adhering to Customizer choice, `wp_timezone()`, with automatic fallback to `Asia/Colombo`.
    - `buzzmag_current_datetime()`: Returns a `DateTimeImmutable` pinned to the localized site timezone.
    - `buzzmag_date($format, $timestamp)`: Reliable date/time formatter unaffected by PHP core `date_default_timezone_set('UTC')`.
  - Re-anchored Rahu Kalaya day-of-week indexing to `(int) buzzmag_date('w')` and Cartoon query to `buzzmag_date('Y-m-d')`.
  - Rebuilt the Interactive Monthly Calendar card calculations with `buzzmag_current_datetime()`, eliminating UTC day boundary skews for today's highlighted day, month lengths, first day of the month offset, and Sinhala/English localized labels.
  - Fixed relative post age in news loops (`functions/news-loops.php`) by creating `buzzmag_get_time_ago()` with exact epoch seconds `get_post_time('U', true, $post)` and `time()`, and aligned `buzzmag_query_most_viewed_days()`, `buzzmag_query_most_viewed_hours()`, and `buzzmag_query_top_stories_week()` date queries with `buzzmag_current_datetime()`.
  - Added `site_timezone` setting and dropdown control to the WordPress Customizer (`Appearance > Customize > Rebrand 3D Settings > Site Timezone`), giving site administrators full control (`Auto / Sri Lanka`, `Asia/Colombo`, `WordPress Default`, `UTC`).
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
- **Modern 3D Category Page Architecture** (`category.php`, `css/3d-components.css`, `functions/news-loops.php`):
  - Upgraded the category archive template to match the 70/30 baseline-aligned architecture of `single.php`.
  - Added a modern **3D Category Header Card** (`.fl-category-header-card`) featuring dynamic icon badges, category accent colors (`buzzmag_get_category_badge_meta`), total article count pill, subcategories chips, and category descriptions.
  - Rendered category posts in a responsive 2-column **3D Cards Grid** (`.fl-category-3d-grid`) with thumbnail hover physics and metadata.
  - Implemented modern 3D pagination buttons (`.fl-category-pagination`) with smooth hover elevation and active page styling.
  - Integrated the sticky **6-Category 3D Side Panel** (`buzzmag_render_single_sidebar_categories`) aligned flush with the category header.
  - Integrated the **Below Sections** (`buzzmag_render_single_under_post`) rendering Latest News (6 posts) and Most Read (staged 96h, 6 posts) directly under the category archive feed.
- **3D Card Design System** (`css/3d-components.css`):
  - Elevated multi-layer box shadows and rounded edges (`border-radius: 14px`).
  - Hover physics (`translateY(-4px)` with depth transition).
  - Complete dark mode palette and contrast border styling.
- **Lead Post Checkbox**:
  - Meta box in post edit screen (`functions/lead-post.php`) allowing editors to mark any post as "Lead Post" (`_buzzmag_is_lead_post`).
  - Automated fallback query helper `buzzmag_get_lead_post()`.
- **Desktop Homepage** (`includes/home-desktop.php`):
  - Hero Lead Post 3D card.
  - 3-Column Grid:
    - Col 1: Latest 10 posts (excluding lead) + Top Viewed post from last 4 days.
    - Col 2: Category blocks (5 posts each) - Local, Off road / Foreign, Business, Sports (3D overall card).
    - Col 3: Sri Lankan utility cards - Biz Today / Video channels, Calendar, Rahu Kalaya (රාහු කාලය), Subha Dishawa (සුබ දිශාව), Maru Sitina Dishawa (මරු සිටින දිශාව), Cartoon of the Day, WhatsApp Community Banner.
  - Below Sections (Desktop only): Politics (6 posts) and Featured (6 posts) in equal 3D grid cards.
- **Mobile Homepage** (`includes/home-mobile.php`):
  - Lead post as main post.
  - Latest 10 posts list (3D each).
  - Top Story (6 posts within the past week).
  - Category sections (3 posts each): Local, Off road, Business, Sports, Foreign, Featured (3D overall card).
  - Bottom video channel & astrology stream.
- **Single Post Enhancements** (`single.php` & `includes/single-post-widgets.php`):
  - Main article enclosed in 3D elevated card.
  - Under-post sections: Latest (6 posts) and Most Read (last 36 hours, 6 posts).
  - Desktop sidebar: Main 6 categories with 3 posts from each (Local, Off road, Business, Sports, Foreign, Featured) in 3D category cards.
- **Modern Portal Footer** (`footer.php`):
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
  - **Columns 1 & 2 News Cards**: Refactored post cards to the `[Image] - [Title / Date]` format (`.fl-post-card-horizontal`) with calendar date icon (`fa-calendar`), bold headline, and rounded thumbnail.
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

### Changed
- **Footer Navigation Columns Simplification**:
  - Commented out the `Main News`, `Categories & Features`, and `Services & Utilities` footer link columns in `footer.php`.
  - In `Information & Support`, commented out the `Contact Us` link, keeping only `About Us` and `Privacy Policy`.
  - Updated footer navigation columns CSS grid to `repeat(auto-fit, minmax(220px, 1fr))` with `max-width: 340px` on `.fl-fcol` so single-column display renders cleanly without artificial empty slots.
- **Removed Sinhala Wording across Portal (Category Cards, Footer, Post Side Panel)**:
  - Cleaned all category cards in Column 2, mobile loops, and single post sidebar by replacing Sinhala labels with clean English equivalents (`Local News`, `Off Road`, `Business`, `Sports`, `Foreign`, `Featured Stories`, `More`, `View All`).
  - Updated homepage hero and below sections: `Lead Story`, `Read Story`, `Latest News`, `Top Viewed`, `Politics`, `Featured Stories`.
  - Converted the entire modern footer (`footer.php`) to professional English: mission description, navigation column headers (`Main News`, `Categories & Features`, `Services & Utilities`, `Information & Support`), quick links, and copyright text.
  - Retained 3rd column utilities (`functions/sri-lankan-utilities.php` - astrology, calendar, cartoon, channels) untouched per roadmap instructions.

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

