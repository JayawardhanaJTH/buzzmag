# Changelog

All notable changes to this theme are documented here.
Format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and [Semantic Versioning](https://semver.org/).

**How to use**
- Add every change under `[Unreleased]` in the right group: `Added`, `Changed`, `Fixed`, `Removed`, `Security`, `Deprecated`.
- On release: rename `[Unreleased]` to `[x.y.z] - YYYY-MM-DD`, bump `Version:` in `style.css` **and** `fl_theme_version` in `functions.php`, then run `build-zip.ps1`.
- Note any **database-affecting** change (renamed theme_mod, sidebar ID, image size, folder slug) with a ⚠️ and the migration steps.

---

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
  - Cartoon image, title, and description.
  - WhatsApp Community invite link and text.
  - Video channel titles and embed URLs (Biz Today & 3 more).
  - Footer description text.

### Fixed & Security
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

