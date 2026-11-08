# BuzzMag 3D News Portal — User & Administrator Guide

> **Theme Version:** 3.0.0  
> **Architecture:** Modern 3D Card Sri Lankan News Portal (Ada Derana Desktop + Unusuma.lk Mobile)  
> **Rebrander & Maintainer:** Tiran Jayawardhana ([jayawardhanatiran@gmail.com](mailto:jayawardhanatiran@gmail.com))  
> **Directory Slug:** `buzzmag`  
> **Release Package:** `dist/buzzmag-3.0.0.zip`

---

## 1. Overview of the Portal

BuzzMag has been redesigned into a high-performance **3D Card Sri Lankan News & Magazine Portal**.
- **Visual Design:** Elevated 3D cards with rounded corners (`12px–14px`), subtle multi-layer drop shadows, and responsive hover physics.
- **Desktop Homepage Layout:** 3-column Ada Derana Sinhala layout with Lead Story hero, 10 Latest News + 4-Day Most Viewed, 4 Category blocks (5 posts each), 4 standalone Video Channels, Astrology (Rahu Kalaya, Subha/Maru Dishawa), Calendar, Cartoon of the Day, WhatsApp Community Banner, and Below Sections (Politics & Featured Stories).
- **Mobile Homepage Layout:** Unusuma.lk single-stream flow optimized for smartphones: Lead Story → Latest 10 → Top Stories of the Week (6) → Category blocks (3 each) → Video Channels & Utilities stream.
- **Inner Post Layout:** 70/30 split layout where the post image and the sidebar start at the **exact same vertical top baseline**. Below the article: Latest 6 News and Most Read in Last 36 Hours (6 posts).

---

## 2. How Post Suggestion & Query Engines Work

### A. Homepage (Desktop View)

| Section | Query & Suggestion Logic | Post Count | How to Manage / Override |
|---|---|:---:|---|
| **Lead Post (Hero)** | Queries newest post with `_buzzmag_is_lead_post = 'yes'`. Falls back to latest post if none marked. | 1 | Check/uncheck **"Mark as Lead Post"** box in the Post Editor sidebar. |
| **Column 1: Latest News** | Queries newest published posts, **automatically excluding** the active Lead story so there are never duplicates. | 10 | Automatic by publication date/time. Format: `[Image] - [Title / Date]`. |
| **Column 1: Top Viewed (4 Days)** | Queries posts published in the last 4 days, sorted by highest view count (`post_views_count` DESC). Gracefully falls back if under 4 days. | 1 | Driven automatically by readership traffic. Format: `[Image] - [Title / Date]`. |
| **Column 2: Category Blocks** | Queries the 5 latest posts from each of the 4 main categories: Local, Off Road / Foreign, Business, Sports. | 5 each (20 total) | Fully customizable in `Appearance > Customize > 3D News Portal Settings`. You can remap category slugs and rename titles anytime. |
| **Column 3: 4 Video Channels** | Independent 3D cards for Channel 1, Channel 2, Channel 3, and Channel 4. Video 1 has large playable overlay; Videos 2–5 have compact rows. | 5 each (20 total) | Configure Channel titles, badge pills, theme colors, and 5 video URLs/titles per channel in `Appearance > Customize > 3D News Portal Settings > Video Channels`. |
| **Below Sections: Politics & Featured** | Queries 6 posts each from the `politics` and `featured` categories. Rendered in a clean 3-column card grid with generous 70px separation and 205px uncropped image framing. | 6 each (12 total) | Configure category slugs in `Appearance > Customize > 3D News Portal Settings`. |

---

### B. Homepage (Mobile View)

Automatically activates on screens smaller than `992px`:
1. **Lead Post Hero Card (3D)**: Displays the current lead story.
2. **Latest 10 Posts**: Single-column stream of horizontal `[Image] - [Title / Date]` 3D cards.
3. **Top Stories (This Week)**: 6 highest-viewed posts published in the past 7 days.
4. **Category Blocks**: 3 posts from each of the 6 categories (Local, Off road, Business, Sports, Foreign, Featured).
5. **Video & Utility Stream**: Standalone cards for the 4 Video Channels, Astrology (Rahu Kalaya), WhatsApp Community Banner, and Cartoon of the Day.
6. **Modern Unusuma.lk Footer**.

---

### C. Inner Article Page (`single.php`)

| Block | Query & Suggestion Logic | Post Count | How to Manage |
|---|---|:---:|---|
| **Top Article & Sidebar Alignment** | The post image and the right-hand sidebar start on the **exact same top baseline** (`align-items: flex-start; gap: 32px;`). | — | Default in single post view. For no sidebar, pick the "Full Width Post" template. |
| **Sidebar 6 Categories** | Displays 3 posts each from Local, Off road, Business, Sports, Foreign, and Featured. Each category is an individual 3D card with a 25px bottom margin. | 3 each (18 total) | Category assignments and slugs can be updated in Customizer. |
| **Under-Post: Latest News** | Queries 6 newest posts, automatically excluding the current article being read. | 6 | Automatic based on publication timestamp. |
| **Under-Post: Most Read (36 Hours)** | Queries posts published within the last 36 hours, ordered by view count (`post_views_count` DESC). If fewer than 6 exist, automatically backfills with all-time most-viewed posts. | 6 | Driven automatically by readership traffic within a rolling 36-hour window. |

---

## 3. How to Manage Everything in WordPress Admin

### 1. Setting a Lead Post
1. Go to **wp-admin > Posts > Add New** (or **Edit** an existing post).
2. In the right-hand sidebar (or below the content editor in Classic Editor), locate the **"Lead Post Setting (ප්‍රධාන පුවත)"** box.
3. Check the box **"Mark as Lead Post (ප්‍රධාන පුවතක් ලෙස සකසන්න)"**.
4. Click **Publish** or **Update**.
5. *Result:* This post immediately becomes the main Hero story on desktop and mobile. Column 1's "Latest 10" automatically excludes it to prevent duplicate headlines.

### 2. Customizing Categories & Slugs
1. Go to **wp-admin > Appearance > Customize > 3D News Portal Settings**.
2. Expand **Category Slugs & Section Titles**:
   - **Local News**: Slug (default: `local`) & Title (default: `දේශීය පුවත් (Local News)`)
   - **Off Road / Foreign**: Slug (default: `off-road`) & Title (default: `පිටරට / Off Road (Foreign)`)
   - **Business**: Slug (default: `business`) & Title (default: `ව්‍යාපාරික පුවත් (Business)`)
   - **Sports**: Slug (default: `sports`) & Title (default: `ක්‍රීඩා පුවත් (Sports)`)
   - **Foreign**: Slug (default: `foreign`) & Title (default: `විදේශීය පුවත් (Foreign)`)
   - **Featured**: Slug (default: `featured`) & Title (default: `විශේෂාංග (Featured Stories)`)
   - **Politics**: Slug (default: `politics`) & Title (default: `දේශපාලන (Politics)`)
3. *Flexibility:* If you ever want to change a category (e.g., swap "Off Road" with "Technology"), simply create the category in WordPress (`Posts > Categories`), then set the slug to `technology` and title to `තාක්ෂණික (Technology)`. The entire site adapts instantly!

### 3. Managing the 4 Video Channels (5 Videos Each)
1. Go to **wp-admin > Appearance > Customize > 3D News Portal Settings > Video Channels**.
2. For each channel (1 to 4):
   - **Channel Title**: e.g., `Channel 1 - Biz Today (ව්‍යාපාරික පුවත්)`
   - **Channel Badge Tag**: e.g., `Biz Today`
   - **Accent Color**: Choose any brand color hex
   - **5 Videos**: For each video (1 through 5), enter a custom **Video Title** and paste a **YouTube or Vimeo URL**.
3. *Automatic Thumbnails:* The theme automatically extracts high-definition YouTube/Vimeo video thumbnails and generates playable overlay links.

### 4. Managing Astrology (Rahu Kalaya, Subha & Maru Dishawa)
- **Automatic Calculations:** The theme includes a built-in astrological calculation engine covering Sunday through Saturday with traditional Sri Lankan times and directions.
- **Manual Overrides:**
  - Go to **Appearance > Customize > 3D News Portal Settings > Astrology & Rahu Kalaya**.
  - Enter custom text for **Rahu Kalaya Override**, **Subha Dishawa Override**, or **Maru Dishawa Override** whenever you need to publish special auspicious times or holiday adjustments.
  - Leave blank to keep the automatic calculations.

### 5. Managing Cartoon of the Day
1. Go to **Appearance > Customize > 3D News Portal Settings > Cartoon of the Day**.
2. Click **Select Image** and upload today's cartoon graphic.
3. Enter a custom **Title**, optional **Caption / Description**, and optional **Link URL** (defaults to image lightbox if left blank).
4. *Built-in Fallback:* If no image has been uploaded yet, the theme displays an SVG placeholder (`img/cartoon-placeholder.svg`) so your site never displays broken image icons.

### 6. Managing the WhatsApp Community Banner
1. Go to **Appearance > Customize > 3D News Portal Settings > WhatsApp Banner**.
2. Paste your **WhatsApp Group or Channel Invite Link** (e.g., `https://chat.whatsapp.com/your-group-id`).
3. Set your custom banner title, descriptive subtitle, and button text.

### 7. Managing the Modern Footer
1. Go to **Appearance > Customize > 3D News Portal Settings > Footer Settings**.
2. Update the **Footer Mission / Description Text** (Sinhala and English).
3. Connect your official social links under **Appearance > Customize > Social Icons** (Facebook, YouTube, WhatsApp, Twitter, Instagram).
4. Menu links in the footer can also be assigned in **Appearance > Menus > Footer Menu**.

---

## 4. Key Theme Files Map

```
buzzmag/
├── functions/
│   ├── lead-post.php              Lead post meta box & query helper
│   ├── news-loops.php             Query engine: latest, top-viewed (4d/36h/week), category cards, 3D card renderers
│   ├── sri-lankan-utilities.php   Astrology, Rahu Kalaya, Calendar, Cartoon, WhatsApp, and 4 standalone Channel cards
│   └── customizer.php             Customizer settings panel with all portal controls
├── includes/
│   ├── home-desktop.php           Desktop 3-column Ada Derana layout & below sections
│   ├── home-mobile.php            Mobile Unusuma.lk single-stream layout
│   └── single-post-widgets.php    Single post under-post blocks (Latest 6, Most Read 36h 6) and 6-cat sidebar
├── css/
│   └── 3d-components.css          3D card physics, horizontal news cards, standalone channel cards, dark mode
├── img/
│   └── cartoon-placeholder.svg    Clean fallback graphic for cartoon widget
├── single.php                     Single post template (image and sidebar aligned at top)
├── templates/                     Post and page layout templates
├── footer.php                     Modern Unusuma.lk footer
└── build-zip.ps1                  Build script for generating uploadable zip
```

---

## 5. Deployment to Live Hosting

To deploy updates to your live WordPress hosting:
1. Run `pwsh -File .\build-zip.ps1` in your terminal.
2. Locate the output zip: `dist/buzzmag-3.0.0.zip`.
3. In your live WordPress admin:
   - Go to **Appearance > Themes > Add New > Upload Theme**.
   - Select `buzzmag-3.0.0.zip` and click **Install Now**.
   - Click **Replace active with uploaded**.
4. All existing Customizer settings, menus, and widgets are preserved because the directory slug remains `buzzmag`.

