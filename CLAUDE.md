# visitaylesbury.uk

## Project
Local discovery platform for Aylesbury and the Vale of Aylesbury.
WordPress FSE theme with ACF Pro, registered Gutenberg blocks, Gravity Forms, RankMath.
This is a directory-driven editorial site. Not a blog. Not a brochure. A local product.

## Stack
- PHP 8.2+, WordPress 6.7+
- ACF Pro for all CPT fields and block registrations
- theme.json for design tokens (single source of truth for colours, type, spacing)
- Vanilla CSS with custom properties from theme.json. No Tailwind. No SCSS.
- Vanilla JS. No jQuery unless a plugin dependency requires it.
- Leaflet.js + OpenStreetMap for all maps
- Gravity Forms for submissions
- RankMath for SEO and Schema
- Matomo for analytics

## Architecture
- FSE templates for page shells (header, footer, page/single/archive wrappers)
- ACF registered blocks for reusable UI components (cards, grids, carousels, maps, CTAs)
- PHP template parts for CPT rendering (single-listing, single-event, archive views)
- Gutenberg native blocks available in guide and post editors for editorial content
- All CPT archive/single views use traditional template hierarchy, NOT FSE templates

## File Structure
```
theme/
├── CLAUDE.md                    ← you are here
├── style.css                    ← theme header only
├── theme.json                   ← design tokens
├── functions.php                ← loader, includes only
├── inc/
│   ├── setup.php                ← theme supports, menus, image sizes
│   ├── cpt.php                  ← all CPT registrations
│   ├── taxonomies.php           ← all taxonomy registrations
│   ├── blocks.php               ← all ACF block registrations
│   ├── acf-fields.php           ← ACF field groups (PHP, not JSON)
│   ├── schema.php               ← JSON-LD Schema output functions
│   ├── helpers.php              ← template helper functions
│   └── enqueue.php              ← script and style enqueueing
├── assets/
│   ├── css/
│   │   ├── global.css           ← base styles, resets, utilities
│   │   ├── components.css       ← all component styles
│   │   └── blocks.css           ← block editor styles
│   ├── js/
│   │   ├── navigation.js
│   │   ├── map.js               ← Leaflet initialisation
│   │   └── search-filters.js    ← directory faceted search
│   └── img/                     ← theme images, icons, SVGs
├── blocks/                      ← ACF Gutenberg blocks
│   ├── listing-card/
│   │   ├── block.json
│   │   └── render.php
│   ├── event-card/
│   ├── featured-grid/
│   ├── events-row/
│   ├── map-embed/
│   ├── cta-banner/
│   └── newsletter-signup/
├── templates/                   ← FSE HTML templates
│   ├── index.html
│   ├── front-page.html
│   ├── page.html
│   ├── single.html
│   └── archive.html
├── parts/                       ← FSE template parts
│   ├── header.html
│   └── footer.html
├── template-parts/              ← PHP partials
│   ├── cards/
│   │   ├── card-listing.php
│   │   ├── card-event.php
│   │   ├── card-walk.php
│   │   └── card-area.php
│   ├── single/
│   │   ├── content-listing.php
│   │   ├── content-event.php
│   │   ├── content-walk.php
│   │   └── content-area.php
│   └── components/
│       ├── badge.php
│       ├── features-list.php
│       ├── opening-hours.php
│       ├── social-links.php
│       └── map-single.php
├── single-listing.php
├── single-event.php
├── single-walk.php
├── single-area.php
├── archive-listing.php
├── archive-event.php
├── taxonomy-business_category.php
├── taxonomy-area.php
└── docs/                        ← reference docs for Claude Code
    ├── components.md            ← approved component HTML/CSS
    ├── acf-fields.md            ← full field reference per CPT
    ├── schema-patterns.md       ← JSON-LD patterns per CPT
    └── tokens.md                ← extended design token reference
```

## Custom Post Types
- `listing` — businesses, shops, restaurants, venues, services
- `event` — date-based events with submission flow
- `walk` — walking routes with GPX, distance, difficulty
- `area` — villages, neighbourhoods, distinct locations
- `guide` — evergreen SEO pillar pages and seasonal content

## Key Taxonomies
- `business_category` — hierarchical (Eat & Drink > Restaurants)
- `area_tax` — flat (Town Centre, Old Town, Bedgrove, Fairford Leys, etc.)
- `vale_village` — flat (Waddesdon, Wendover, Haddenham, Brill, etc.)
- `event_category` — flat (Music, Theatre, Family, Food & Drink, etc.)
- `guide_type` — flat (Visitor, Seasonal, Living, Business, Audience)

## Design Tokens
All values come from theme.json. Never hardcode colours, sizes, or fonts.
Use CSS custom properties: var(--wp--preset--color--primary) etc.

### Colours
| Name       | Var                                    | Hex     | Usage                    |
|------------|----------------------------------------|---------|--------------------------|
| primary    | --wp--preset--color--primary           | #1D3557 | Headings, nav, dark UI   |
| accent     | --wp--preset--color--accent            | #E63946 | CTAs, badges, highlights |
| teal       | --wp--preset--color--teal              | #2A9D8F | Success, links, tags     |
| dark       | --wp--preset--color--dark              | #0F1B2D | Footer, dark sections    |
| light      | --wp--preset--color--light             | #F1FAEE | Card backgrounds, alt    |
| grey-600   | --wp--preset--color--grey-600          | #555555 | Meta text, captions      |
| grey-200   | --wp--preset--color--grey-200          | #E5E5E5 | Borders, dividers        |
| white      | --wp--preset--color--white             | #FFFFFF | Backgrounds              |

### Typography
Font family: "Inter", system-ui, sans-serif (loaded via theme.json fontFace)
Body: 1rem/1.6, 400 weight
H1: 2.25rem, 700 | H2: 1.75rem, 700 | H3: 1.35rem, 600 | H4: 1.15rem, 600
Small/meta: 0.85rem, 400

### Spacing (use theme.json spacing scale)
20: 0.25rem | 30: 0.5rem | 40: 1rem | 50: 1.5rem | 60: 2rem | 70: 3rem | 80: 4rem

### Radius
sm: 4px | md: 8px | lg: 12px | full: 9999px

## CSS Conventions
- BEM naming: `.va-card`, `.va-card__image`, `.va-card__title`, `.va-card--featured`
- Prefix all custom classes with `va-` to avoid conflicts
- No `!important`. No inline styles. No IDs for styling.
- Responsive: mobile-first. Breakpoints: 640px, 768px, 1024px, 1280px
- Use `clamp()` for fluid typography where appropriate

## PHP Conventions
- WordPress coding standards
- Use `get_field()` not `the_field()` — assign to variables, then escape on output
- Escape everything: `esc_html()`, `esc_url()`, `esc_attr()`, `wp_kses_post()`
- Use `wp_get_attachment_image()` with named sizes, never raw `<img>` tags
- Schema output via JSON-LD in `wp_head`, not inline microdata
- Template parts loaded via `get_template_part()` with `$args` array for data passing
- No direct DB queries. Use WP_Query or get_posts.
- Register ACF fields in PHP (inc/acf-fields.php), not JSON exports

## Component Library
Approved component patterns are documented in `docs/components.md`.
**Always read docs/components.md before building any card, grid, or UI element.**
If a component exists there, use it exactly. Do not redesign.
If a new component is needed, build it, then I will approve it and we add it to the reference.

## ACF Field Reference
Full field names, types, and return formats are documented in `docs/acf-fields.md`.
**Always read docs/acf-fields.md before writing any template that uses get_field().**

## Schema Reference
JSON-LD patterns for each CPT are documented in `docs/schema-patterns.md`.

## Key Rules
1. Read docs/components.md before building ANY visual component
2. Read docs/acf-fields.md before writing ANY template that calls get_field()
3. Never hardcode colours, font sizes, or spacing — use theme.json tokens
4. Every listing page outputs LocalBusiness Schema (or appropriate subtype)
5. Every event page outputs Event Schema
6. All images use wp_get_attachment_image() with lazy loading
7. Card components are IDENTICAL everywhere they appear. Same HTML, same classes.
8. New components get built, approved by me, then added to docs/components.md
9. Front-page.php is a PHP template, not an FSE template (needs dynamic queries)
10. No page builder plugins. No Elementor. No Divi. ACF blocks and Gutenberg only.
