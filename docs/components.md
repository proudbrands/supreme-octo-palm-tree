# Component Library — visitaylesbury.uk

> This file is the single source of truth for all approved UI components.
> Claude Code MUST use these exact patterns. Do not redesign or deviate.
> If a component doesn't exist here yet, build it, get approval, then add it.

## Status Key
- ✅ Approved — use exactly as documented
- 🚧 Draft — built but not yet approved
- ❌ Rejected — do not use

---

## Card Base ✅

All cards share the `.va-card` base class. Every card variant (`--listing`, `--event`, `--walk`, `--area`, `--guide`) inherits from this base.

```css
.va-card {
  background: white;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
  /* hover: shadow 0 8px 25px rgba(0,0,0,0.08), 0 4px 10px rgba(0,0,0,0.04) + translateY(-3px) */
}
```

**Inset image wrapper**: All standard cards (listing, event, walk, guide) use `.va-card__image-wrap` with `padding: 0.75rem 0.75rem 0` to create a white border effect around the image.

**Card image**: aspect-ratio 3/2, `border-radius: 12px`, image scales to 1.03 on hover (0.4s ease). Placeholder uses `#f5f5f5` with centred SVG landscape icon.

**Card body**: padding `1rem 1.25rem 1.25rem`. Title is 1.05rem/600 primary colour, single line with ellipsis overflow. Tagline 0.9rem `#666`, 2-line clamp.

**Card divider**: `<hr class="va-card__divider">` — `border-top: 1px solid #e8e8ec`, separates tagline from meta row.

**Card meta row**: `display: flex; justify-content: space-between; align-items: center;` — 0.8rem `#888`. Left side has `.va-card__meta-item` with SVG icon + text. Right side has `.va-card__price` in teal.

Image size: `va-card-thumb` registered at 480×300, hard crop.

---

## Cards

### listing-card ✅
Used on: directory archive, food-and-drink pages, homepage featured, area pages, search results

```html
<article class="va-card va-card--listing">
  <a href="..." class="va-card__link">
    <div class="va-card__image-wrap">
      <div class="va-card__image">
        <?php echo wp_get_attachment_image( $hero_id, 'va-card-thumb', false, ['class' => 'va-card__img', 'loading' => 'lazy'] ); ?>
        <?php if ( $category_name ) : ?>
          <span class="va-card__cat-pill">
            <span class="va-card__cat-pill-emoji"><?php echo esc_html( $emoji ); ?></span>
            <?php echo esc_html( $category_name ); ?>
          </span>
        <?php endif; ?>
      </div>
    </div>
    <div class="va-card__body">
      <h3 class="va-card__title"><?php echo esc_html( $business_name ); ?></h3>
      <?php if ( $tagline ) : ?>
        <p class="va-card__tagline"><?php echo esc_html( $tagline ); ?></p>
      <?php endif; ?>
      <hr class="va-card__divider">
      <div class="va-card__meta">
        <?php if ( $area_name ) : ?>
          <span class="va-card__meta-item">
            <svg class="va-card__meta-icon"><!-- map-pin SVG --></svg>
            <?php echo esc_html( $area_name ); ?>
          </span>
        <?php endif; ?>
        <?php if ( $price_range ) : ?>
          <span class="va-card__price"><?php echo esc_html( $price_range ); ?></span>
        <?php endif; ?>
      </div>
    </div>
  </a>
</article>
```

Listing-specific styles:
- Category pill on image: white pill with emoji + category name, `border-radius: 20px`, positioned `top: 0.65rem; left: 0.65rem`
- Featured/premium listings get a 3px left border in accent red via `.va-card--featured` or `.va-card--premium`
- Meta icon: 14×14px SVG map pin in accent colour
- Price range displayed in teal, right-aligned via `margin-left: auto`

Category emoji map (used in card-listing.php):
| Category | Emoji |
|----------|-------|
| Restaurants | 🍽️ |
| Cafes & Coffee | ☕ |
| Pubs & Bars | 🍺 |
| Takeaways | 🥡 |
| Hotels & B&Bs | 🏨 |
| Shopping | 🛍️ |
| Health & Beauty | 💆 |
| Services | 🔧 |
| Arts & Culture | 🎭 |
| Sports & Fitness | ⚽ |

---

### event-card ✅
Used on: events hub, homepage what's on row, area pages

```html
<article class="va-card va-card--event">
  <a href="..." class="va-card__link">
    <div class="va-card__image-wrap">
      <div class="va-card__image">
        <?php echo wp_get_attachment_image( $hero_id, 'va-card-thumb', false, ['class' => 'va-card__img', 'loading' => 'lazy'] ); ?>
      </div>
    </div>
    <div class="va-card__body">
      <div class="va-card__date">
        <span class="va-card__date-day"><?php echo esc_html( $day ); ?></span>
        <span class="va-card__date-month"><?php echo esc_html( $month ); ?></span>
      </div>
      <div class="va-card__details">
        <h3 class="va-card__title"><?php echo esc_html( $event_name ); ?></h3>
        <?php if ( $venue_name ) : ?>
          <p class="va-card__venue"><?php echo esc_html( $venue_name ); ?></p>
        <?php endif; ?>
        <?php if ( $time_display ) : ?>
          <span class="va-card__time"><?php echo esc_html( $time_display ); ?></span>
        <?php endif; ?>
      </div>
    </div>
  </a>
</article>
```

Event-specific styles:
- Card body is flexbox: 52×52px date block left, details right, gap 0.85rem
- Date block: `#f7f7f9` bg (surface colour), `border-radius: 10px`, centred text
- Day: 1.15rem/700 in accent red, line-height 1
- Month: 0.6rem/600 uppercase, `letter-spacing: 0.05em`, `#888`
- Venue: 0.85rem `#666`
- Time: 0.8rem teal

---

### walk-card ✅
Used on: the-vale/walks, area pages, Walk of the Week

```html
<article class="va-card va-card--walk">
  <a href="..." class="va-card__link">
    <div class="va-card__image-wrap">
      <div class="va-card__image">
        <?php echo wp_get_attachment_image( $hero_id, 'va-card-thumb', false, ['class' => 'va-card__img', 'loading' => 'lazy'] ); ?>
        <?php if ( $difficulty ) : ?>
          <span class="va-badge va-badge--<?php echo esc_attr( strtolower( $difficulty ) ); ?>">
            <?php echo esc_html( $difficulty ); ?>
          </span>
        <?php endif; ?>
      </div>
    </div>
    <div class="va-card__body">
      <h3 class="va-card__title"><?php echo esc_html( $walk_name ); ?></h3>
      <div class="va-card__stats">
        <span class="va-card__stat"><?php echo esc_html( $distance_miles ); ?> miles</span>
        <span class="va-card__stat"><?php echo esc_html( $estimated_time ); ?></span>
        <?php if ( $dog_friendly ) : ?>
          <span class="va-card__stat va-card__stat--dog">Dog friendly</span>
        <?php endif; ?>
      </div>
    </div>
  </a>
</article>
```

Walk-specific styles:
- Stats use pill-shaped tags: `background: #f2f1ed`, `border-radius: 20px`, `0.75rem/500`, `padding: 0.3rem 0.75rem`
- Dog friendly stat has `va-card__stat--dog` which adds a paw emoji via `::before`
- Difficulty badge positioned on image: easy=teal, moderate=amber `#f59e0b`, challenging=accent red

---

### area-card ✅
Used on: the-vale hub, homepage explore section

```html
<article class="va-card va-card--area">
  <a href="..." class="va-card__link">
    <div class="va-card__image va-card__image--area">
      <?php echo wp_get_attachment_image( $hero_id, 'va-card-wide', false, ['class' => 'va-card__img', 'loading' => 'lazy'] ); ?>
      <div class="va-card__overlay">
        <h3 class="va-card__title"><?php echo esc_html( $area_name ); ?></h3>
      </div>
    </div>
  </a>
</article>
```

Area-specific styles:
- No inset image wrapper — image goes edge-to-edge
- Image aspect-ratio 16/10, `border-radius: 16px`
- Gradient overlay from transparent to `rgba(0,0,0,0.65)` on the image
- Title overlaid on image bottom: white, 1.15rem/600, text-shadow for readability
- No separate body section — text sits on the image
- Hover: image scales to 1.04 (not default 1.03)

---

## Category Pill (on card images) ✅

White pill positioned on card images showing emoji + category name.

```html
<span class="va-card__cat-pill">
  <span class="va-card__cat-pill-emoji">🍽️</span>
  Restaurants
</span>
```

```css
.va-card__cat-pill {
  position: absolute;
  top: 0.65rem;
  left: 0.65rem;
  z-index: 2;
  display: inline-flex;
  align-items: center;
  gap: 0.3rem;
  padding: 0.25rem 0.7rem;
  background: white;
  border-radius: 20px;
  font-size: 0.7rem;
  font-weight: 600;
  color: var(--wp--preset--color--primary);
  box-shadow: 0 1px 4px rgba(0,0,0,0.1);
}
```

---

## Badges ✅

```html
<span class="va-badge va-badge--{variant}">{Label}</span>
```

All badges use frosted glass effect with `backdrop-filter: blur(8px)`.

```css
.va-badge {
  padding: 0.3rem 0.65rem;
  font-size: 0.65rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  border-radius: 6px;
  backdrop-filter: blur(8px);
}
```

Variants:
| Variant | Background | Text |
|---------|-----------|------|
| `--category` | `rgba(29,53,87,0.85)` (primary 85%) | white |
| `--featured` | `rgba(230,57,70,0.9)` (accent 90%) | white |
| `--free` | `rgba(42,157,143,0.9)` (teal 90%) | white |
| `--family` | `rgba(244,162,97,0.9)` | dark |
| `--easy` | `rgba(42,157,143,0.9)` (teal 90%) | white |
| `--moderate` | `rgba(245,158,11,0.9)` (amber 90%) | dark |
| `--challenging` | `rgba(230,57,70,0.9)` (accent 90%) | white |

Position on card images: `position: absolute; top: 0.65rem; left: 0.65rem; z-index: 2;`
Second badge: `left: auto; right: 0.65rem;`

---

## Grids ✅

Responsive card grid. Used everywhere cards appear.

```html
<div class="va-grid va-grid--{columns}">
  <!-- card components here -->
</div>
```

- Gap: `1.5rem` always
- `va-grid--2`: 1 col → 2 col (768px)
- `va-grid--3`: 1 col → 2 col (640px) → 3 col (1024px)
- `va-grid--4`: 1 col → 2 col (640px) → 3 col (1024px) → 4 col (1280px)

---

## Horizontal Scroll Row ✅

Used for: homepage event row, "more like this" sections

```html
<div class="va-scroll-row">
  <div class="va-scroll-row__inner">
    <!-- card components here -->
  </div>
</div>
```

- Negative margins bleed cards to screen edge on mobile
- Flex row, gap 1rem, overflow-x auto, scroll-snap-type x mandatory
- Hidden scrollbar (both webkit and Firefox)
- Children: 280px on mobile, 320px on desktop, scroll-snap-align start
- Right-edge gradient fade hint via `::after` pseudo-element (adapts to section bg)

---

## Section Headers ✅

Used to introduce every homepage and hub page section.

### With link variant:
```html
<div class="va-section-header">
  <h2 class="va-section-header__title">Section Title</h2>
  <a href="..." class="va-section-header__link">View all</a>
</div>
```

### With button variant:
```html
<div class="va-section-header">
  <h2 class="va-section-header__title">Section Title</h2>
  <a href="..." class="va-section-header__btn">View all →</a>
</div>
```

- Flex row, space-between, baseline aligned, `margin-bottom: 2rem`
- Title: `clamp(1.35rem, 3vw, 1.75rem)`, 700 weight, primary colour
- **Link**: 0.9rem/500 teal with arrow `→` via `::after` pseudo, hover translateX 3px
- **Button**: white bg, `border: 1px solid primary`, `border-radius: 8px`, `padding: 0.6rem 1.25rem`, 0.85rem/500. Hover: primary bg, white text.

Note: the arrow on the link variant is generated by CSS `::after`. Do NOT include the arrow character in the HTML.

---

## Pills & Filters ✅

For filter bars on archive pages. Horizontal scrollable row.

```html
<div class="va-filter-bar">
  <div class="va-filter-bar__inner">
    <div class="va-pill-row">
      <a href="..." class="va-pill is-active">All</a>
      <a href="..." class="va-pill">Restaurants</a>
      <a href="..." class="va-pill">Cafes</a>
    </div>
  </div>
</div>
```

- Horizontal scroll on mobile (snap pattern)
- Each pill: white bg, `1px solid #e8e8ec` border, `border-radius: 24px`, `padding: 0.5rem 1.25rem`, 0.85rem/500, `#555` text
- Hover: border and text become primary colour
- Active: primary bg, white text, border transparent
- Hidden scrollbar

---

## Buttons ✅

Three global button variants:

```html
<!-- Solid (primary CTA) -->
<a href="..." class="va-btn">Search</a>

<!-- Outline -->
<a href="..." class="va-btn va-btn--secondary">View all</a>

<!-- Dark -->
<a href="..." class="va-btn va-btn--dark">Learn more</a>
```

- **Solid** (`.va-btn`): accent bg, white text, `border-radius: 10px`, `padding: 0.75rem 1.5rem`, 600 weight. Hover: primary bg.
- **Outline** (`.va-btn--secondary`): white bg, primary text, `border: 1px solid primary`. Hover: primary bg, white text.
- **Dark** (`.va-btn--dark`): primary bg, white text. Hover: slightly lighter.
- All buttons: `min-height: 44px`, `transition: 0.2s ease`.

---

## Newsletter ✅

Full-width section, typically inside `.va-section--dark`.

```html
<div class="va-newsletter">
  <h2>Stay in the loop</h2>
  <p>The best of Aylesbury, delivered weekly.</p>
  <form class="va-newsletter__form">
    <input type="email" class="va-newsletter__input" placeholder="Your email address" required />
    <button type="submit" class="va-newsletter__btn">Subscribe</button>
  </form>
</div>
```

- Centred text, max-width 560px
- Heading: 1.5rem white. Subtitle: 1rem `rgba(255,255,255,0.7)`
- Form: stacked on mobile, inline (flex-row) from 640px
- Input: `rgba(255,255,255,0.1)` bg, `rgba(255,255,255,0.2)` border, white text. Desktop: left-rounded only. Mobile: fully rounded.
- Button: accent red bg, white text, 1rem/600. Desktop: right-rounded only. Mobile: fully rounded. Min-height 44px.

---

## Single Listing Sidebar ✅

Sticky sidebar card on single listing pages (38% width column).

```css
.va-sidebar-card {
  border: 1px solid #e8e8ec;
  border-radius: 16px;
  padding: 1.75rem;
}
```

- Contact rows: SVG icon (20×20px, teal) + text, `gap: 0.75rem`, `padding: 0.65rem 0`, `border-bottom: 1px solid #f0f0f0`
- Opening hours: dedicated `va-sidebar-card__hours` section with table
- Map: `border-radius: 12px`, `margin-top: 1.25rem`

---

## Archive Header ✅

Used on all archive/taxonomy pages above the filter bar.

```html
<div class="va-container">
  <div class="va-archive-header">
    <h1>Page Title</h1>
    <p>Optional description</p>
  </div>
</div>
```

- `padding: 2rem 0 1rem`
- H1: primary colour, clamp sizing
- Description: grey-600

---

## Map Pins ✅

Custom branded SVG pins replace the default Leaflet blue markers. Built with `L.divIcon` — no external image files needed.

**Pin shape**: Teardrop SVG (30×40px) with white inner circle. Drop shadow via CSS `filter: drop-shadow()`. Scales to 1.15 on hover.

**Category colours**: Pins are colour-coded by category on multi-marker maps:

| Category | Colour | Hex |
|----------|--------|-----|
| Restaurants | Accent red | `#E63946` |
| Cafes & Coffee | Warm brown | `#D4A574` |
| Pubs & Bars | Amber | `#C77D3A` |
| Takeaways | Orange | `#F4A261` |
| Hotels & B&Bs | Purple | `#6A5ACD` |
| Shopping | Pink | `#E07BE0` |
| Health & Beauty | Hot pink | `#FF69B4` |
| Services | Grey | `#888888` |
| Arts & Culture | Violet | `#9B59B6` |
| Sports & Fitness | Teal | `#2A9D8F` |
| Village | Teal | `#2A9D8F` |
| Town | Primary | `#1D3557` |
| Default/unknown | Accent red | `#E63946` |

**Single marker maps** (listing, event, area singles): Pin uses category colour if `data-category` is set, otherwise accent red.

**Data attributes on `.va-map`**:
- `data-title="Business Name"` — shown in popup
- `data-category="Restaurants"` — sets pin colour + shown in popup
- `data-markers='[{...}]'` — JSON array for multi-marker maps

```css
.va-map-pin {
  background: none;
  border: none;
  filter: drop-shadow(0 2px 4px rgba(0,0,0,0.25));
  transition: transform 0.15s ease;
}
.va-map-pin:hover {
  transform: scale(1.15);
}
```

---

## Map Popups ✅

Styled popups that match the VA design system. Replace Leaflet's default popup styling.

```html
<!-- Generated by JS — do not write manually -->
<div class="va-map-popup">
  <span class="va-map-popup__cat">Restaurants</span>
  <a href="/listing/example" class="va-map-popup__title">Business Name</a>
  <a href="/listing/example" class="va-map-popup__link">View details →</a>
</div>
```

- Popup wrapper: `border-radius: 12px`, `box-shadow: 0 4px 16px rgba(0,0,0,0.12)`
- Close button: 22px circle, white bg, subtle shadow, top-right corner
- Inner padding: `1rem 1.25rem`
- Category label: `0.65rem`, uppercase, teal, `letter-spacing: 0.04em`
- Title: `0.95rem/600`, primary colour, hover to accent
- View details link: `0.8rem/500`, teal, hover to primary
- Max width: 240px, min width: 180px
- Font: Inter (matches site)

---

## Mega Menu Navigation ✅

Full-width mega menu navigation replacing the simple nav links. PHP partial at `template-parts/components/mega-menu.php`. JS in `assets/js/navigation.js`.

### Header (`.va-header`)
- Sticky, `z-index: 1000`, white bg, subtle shadow `0 1px 3px rgba(0,0,0,0.06)`
- Inner: max-width container, `height: 64px`, flex between
- Logo: `aylesbury.town` text, 1.25rem/700 primary, no underline
- CTA: `Add Your Business`, accent bg, white text, `border-radius: 8px`, `padding: 0.5rem 1.15rem`

### Desktop Nav (`.va-nav`)
- Visible from 1024px, hidden below
- Top-level links: 0.95rem/500, `color: #333`, hover → teal, active → teal + 600 weight
- Items with dropdowns use `<button>` with SVG chevron (10×6px), rotates 180deg when open
- Generous padding per item (`0.5rem 1rem`)

### Mega Panels (`.va-mega`)
- `z-index: 999`, full-width, white bg, `border-radius: 0 0 16px 16px`
- `box-shadow: 0 12px 32px rgba(0,0,0,0.08)`, `border-top: 1px solid #e8e8ec`
- Animate: `opacity 0→1, translateY(-8px)→0` over 0.2s ease
- Open delay: 100ms, close delay: 200ms (lets cursor travel into panel)
- Column headings: 0.75rem uppercase/700, `color: #888`, `letter-spacing: 0.05em`
- Links: 0.95rem/400, `color: #333`, hover → teal + translateX(3px)

### Mega Panels Content
- **Things to Do**: 3 columns (Explore links, Popular links, featured guide card)
- **The Vale**: 3 columns (Villages links, Explore links, featured area card)
- **Guides**: 2 columns (Visitor Guides, Living & Business), max-width 640px

### Featured Card in Mega Panel (`.va-mega-card`)
- `border-radius: 12px`, surface bg, image `aspect-ratio: 16/9`
- Label: 0.65rem uppercase teal, title: 1rem/600 primary, action: 0.85rem teal
- Hover: shadow + translateY(-2px) + image scale 1.03

### Mobile Menu
- Hamburger (`.va-header__burger`): 3 lines, 20px wide, 2px height, 5px gap, animates to X
- Overlay (`.va-mobile-overlay`): `z-index: 998`, `rgba(0,0,0,0.3)`, fade in
- Drawer (`.va-mobile-drawer`): slides from right, `z-index: 999`, `max-width: 380px`, full height below header
- Nav items: 1.15rem/500, `padding: 1rem 1.5rem`, `min-height: 56px`
- Accordion: plus icon → rotates 45deg to X, sub-links indented to `padding-left: 2.5rem`, max-height animation 0.25s, only one open at a time
- CTA at bottom: full-width accent red button

---

## Spacing Rhythm ✅

- `.va-section`: `padding: 3rem 0` mobile, `padding: 5rem 0` from 1024px
- Section header: `margin-bottom: 2rem`
- Grid gap: `1.5rem` always
- Page background: surface colour `#F7F7F9`
- Cards: white background for depth contrast

---

## Adding New Components

When a new component is needed:
1. Build it following existing conventions (va- prefix, BEM, theme.json tokens via CSS custom properties)
2. Show me for approval
3. Once approved, add the full HTML + CSS pattern to this file with ✅ status
4. From that point forward, use the documented pattern exactly
