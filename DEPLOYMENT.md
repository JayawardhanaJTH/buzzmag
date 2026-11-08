# DEPLOYMENT GUIDE: From Local (XAMPP) to Live Hosting

> How to package this theme as a `.zip` and install or update it on your live WordPress site.

---

## 0. Before Your First Upload (one-time decisions)

### ⚠️ Theme folder name (slug) decides whether your settings survive
WordPress saves all Customizer settings, menu locations and widget placement against the **folder name** (`theme_mods_<folder>`).

| Situation on the live site | What to do |
|---|---|
| Live site **does not** have BuzzMag yet | Any slug is fine. Pick your final brand slug now (e.g. `-Slug newbrand`) so you never have to rename later. |
| Live site **already runs BuzzMag** (`buzzmag` folder) and you want to keep its settings | Keep slug `buzzmag` (the default). Only the *displayed* name changes (from `style.css`). |
| Live site runs BuzzMag and you **want** a new slug | First install the *Customizer Export/Import* plugin and export settings. Then upload the new theme, activate it, import the settings, and re-assign menus + widgets. |

### Check the hosting upload limit
wp-admin → **Media → Add New** shows "Maximum upload file size". The zip is ~1 MB, so this is almost always fine.

---

## 1. Build the Zip (every release)

1. Finish and test your changes locally at `http://localhost/wordpress`.
2. Bump the version in **both** places:
   - `style.css` → `Version: 3.0.0`
   - `functions.php` → `define('fl_theme_version', '3.0.0');` (forces browsers to reload JS)
3. Move the `[Unreleased]` notes in `CHANGELOG.md` under the new version heading.
4. Open a terminal in the theme folder and run:

```powershell
# keep current folder name (buzzmag)
pwsh -File .\build-zip.ps1

# OR build with a new slug (new theme identity, see section 0)
pwsh -File .\build-zip.ps1 -Slug newbrand
```

5. Output: `dist\<slug>-<version>.zip`, e.g. `dist\buzzmag-3.0.0.zip`.

**What the script does for you:**
- Puts everything inside a top-level `<slug>/` folder (WordPress requires `<slug>/style.css`)
- Uses `/` path separators, which Linux servers need. Windows "Send to → Compressed folder" can break this.
- Leaves out `.git`, `dist/`, the `.md` docs and the build script itself

6. Commit and tag in git: `git add -A; git commit -m "Release 3.0.0"; git tag v3.0.0`

---

## 2. Back Up the Live Site First (always)

- Use your host's backup tool (cPanel → Backup, or a plugin such as UpdraftPlus).
- At minimum, download the current `wp-content/themes/<slug>` folder through File Manager/FTP.

---

## 3A. First-Time Install

1. wp-admin → **Appearance → Themes → Add New Theme → Upload Theme**
2. Choose the zip → **Install Now** → **Activate**
3. An admin notice asks you to install the required plugin (*BuzzMag Theme Addons*). Click **Begin installing plugin** and activate it. It powers post-format fields, author socials and the widgets.
4. Configure:
   - **Appearance → Customize**: logo, colours, home layout, featured categories, ads, footer copyright
   - **Appearance → Menus**: assign *Main Menu* and *Footer Menu* (tick "Enable Mega Menu" on top-level category items if you want it)
   - **Appearance → Widgets**: Sidebar, Drawer, Footer 1–3
   - **Settings → Reading**: "Your latest posts" for the magazine homepage
5. If you changed image sizes, run the *Regenerate Thumbnails* plugin once.

## 3B. Updating an Existing Install (same slug)

1. wp-admin → **Appearance → Themes → Add New Theme → Upload Theme** → choose the new zip → **Install Now**
2. WordPress detects that the theme already exists and shows **"Replace active with uploaded"**. Click it.
3. Your Customizer settings, menus and widgets stay because the slug is unchanged.
4. Hard-refresh the site (Ctrl+F5) and purge any cache plugin or CDN (LiteSpeed, WP Rocket, Cloudflare…).

## 3C. Alternative: Upload via cPanel File Manager / FTP

1. Upload the zip to `public_html/wp-content/themes/`
2. Extract it. You should get `wp-content/themes/<slug>/style.css`.
3. If updating, delete or rename the old folder first (e.g. `buzzmag-old`). Same slug = settings are kept.
4. Activate in wp-admin → Appearance → Themes.

---

## 4. Post-Deploy Checklist

- [ ] Homepage loads, featured block and tabs (Latest / Trending / …) work
- [ ] "Load More" works (it uses AJAX, so a security/firewall plugin blocking `admin-ajax.php` would break it)
- [ ] Single post: media, author box, related posts, comments toggle
- [ ] Dark-mode switch, search overlay, mobile drawer menu
- [ ] Mega menu (if used)
- [ ] WooCommerce shop/cart (if used)
- [ ] No PHP errors (Tools → Site Health → Info, or the host's error log)
- [ ] Theme shows the new name/screenshot in Appearance → Themes

---

## 5. Rollback

- **Same slug:** upload the previous zip from `dist/` (keep old builds!) → "Replace active with uploaded".
- **New slug:** just re-activate the old theme in Appearance → Themes; its settings are still stored under its own slug.

---

## 6. Troubleshooting

| Symptom | Cause / Fix |
|---|---|
| "The package could not be installed. The theme is missing the style.css stylesheet." | The zip has no top-level folder, or it is nested twice. Rebuild with `build-zip.ps1`. |
| "The uploaded file exceeds the upload_max_filesize directive" | Raise the limit in hosting PHP settings, or use File Manager/FTP (3C). |
| All settings gone after upload | The slug changed. See section 0, or re-upload with the old slug. |
| Styles/JS look old | Bump `fl_theme_version`, purge cache/CDN, Ctrl+F5. |
| Tabs / Load More spin forever | `admin-ajax.php` is blocked (security plugin/WAF), or there is a PHP error; check the browser console Network tab. |
| White screen | PHP error. Enable `WP_DEBUG_LOG` in `wp-config.php` and read `wp-content/debug.log`. |

