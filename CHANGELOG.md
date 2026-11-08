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
- `PROJECT_MEMORY.md`: full theme map: files, boot sequence, Customizer keys, DB storage, AJAX endpoints, brand footprint, known issues, decisions log.
- `COMPONENT_MAP.md`: Mermaid diagrams showing how templates, parts, loops, AJAX, layout engine, dark mode, mega menu and WooCommerce connect.
- `DEPLOYMENT.md`: step-by-step guide to package and upload the theme zip to live hosting.
- `build-zip.ps1`: one-command builder that makes a clean, Linux-safe upload zip in `dist/`.
- `.gitignore`: ignores `dist/` and OS/editor files.

### Changed
- _Nothing yet. Theme code is still the original BuzzMag 2.1._

---

## [2.1] - Original baseline (BuzzMag by FlatLayers)

Starting point of this project, imported as-is from FlatLayers BuzzMag v2.1.
- Classic PHP theme, Customizer-driven, jQuery front-end.
- Bundled required plugin: `flatlayers-buzzmag-addons` v1.0.

