## 3.8.10.48

- Fixes the Theme Settings frontend-protection panel so its CSS is loaded in the admin head instead of appearing as visible text.
- Makes sector media repair load the WordPress image API safely before generating attachment metadata.
- Refines shared card, directory, gallery and responsive alignment.
- Removes the extra gallery frame and keeps compact thumbnail pagination inside the bottom of the room image.

## 3.8.10.47

- More compact and consistent section spacing, cards and responsive layouts.
- Smaller in-frame gallery thumbnail pagination and improved light/dark contrast.
- Reliable child-owned WooCommerce product shells where the theme includes commerce.

# WP BBTheme Child Hotel 3.8.10.48
Child theme for WP BBTheme. Built to use the shared Gutenberg/WP BBuilder design system and demo importer.

## Included
- Room custom post type with room type and amenity taxonomies
- AJAX room finder with guest capacity and nightly-rate filters
- Booking request custom post type and date/guest form
- Room archive and single templates
- BBuilder proof and finder sections

## Requirements
- WordPress 6.6+
- PHP 8.0+
- Parent theme `wp-bbtheme` 3.7.0+
- WP BBuilder

### 3.8.10.46
- Dashboard-safe, resumable sector media repair; no synchronous bulk image regeneration on `admin_init`.
- Password protection controls live under **Theme Settings → General**.
- Thumbnail navigation is overlaid inside the main gallery image.
- Active-sector Blog and directory media are repaired after child-theme switching.

## SCSS structure (3.8.10.9)

Frontend styles are split into `tokens`, `tools`, `base`, `header`, `footer`, `components`, `swiper`, `motion`, `forms`, `blog`, `quality`, `sector`, `responsive` and `features`. Fluid typography uses the suite `fluid-font()` mixin and explicit viewport guards rather than `clamp()`. The generated production CSS intentionally contains no `!important` declarations.

### Build compatibility

The child build is dependency-free and works with Yarn 1.22.x as well as newer Yarn versions. No Corepack step is required. Use:

```sh
yarn prod
```

The command runs `node tools/build.mjs` and rebuilds the hashed CSS/JS manifest directly.


### 3.8.10.45
- Consistent 80/64/52px section rhythm and explicit light/dark card contrast.
- Active-theme sector media repair for demo pages, blogs, directories and galleries.
- Top-aligned About imagery plus thumbnail and modal galleries on supported directory cards and single pages.

### 3.8.10.44
- Frontend password protection is enabled by default with password `wp@demo`.
- Administrators can disable it or set a new password in **Settings → Theme Settings** at `/wp-admin/options-general.php?page=wp-theme-settings`.
- Successful visitors receive a signed access cookie valid for 24 hours by default.
- Purge full-page/server/CDN caches after changing the protection setting.

### 3.8.10.42
- Replaced demo feature icons with Tabler Icons v3.46.0 outline SVGs, sized for normal UI use and coloured from the child-theme brand token.
- Single-column imported demo rows are repaired to 12 columns at every breakpoint.
- Dark-mode demo cards use explicit dark surfaces/readable text.
- Optional frontend-only demo password protection is available in Settings → Theme Settings (default password `wp@demo`).
### 3.8.10.43
- Shared alignment and dark-mode contrast fixes across service, solution, process, directory, blog and commerce cards.
- Current child-theme media is reapplied after child-theme switches, including optimised AVIF/WebP files.
- Visible slider/grid images are loaded deterministically and duplicate single-item summary text is removed.
