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
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
  /* hover: shadow 0 8px 25px rgba(0,0,0,0.08), 0 4px 10px rgba(0,0,0,0.04) + translateY(-3px) */
}
```

**Card image**: aspect-ratio 16/10, image scales to 1.03 on hover (0.4s ease). Placeholder uses `#f5f5f5` with centred SVG landscape icon.

**Card body**: padding 1.25rem. Title is 1.05rem/600, single line with ellipsis overflow. Tagline 0.9rem `#666`, 2-line clamp. Meta row flex with gap 0.5rem, 0.8rem `#888`.

Image size: `va-card-thumb` registered at 480×300, hard crop.

---

## Cards

### listing-card ✅
Used on: directory archive, food-and-drink pages, homepage featured, area pages, search results

```html
<article class="va-card va-card--listing">
  <a href="<?php echo esc_url( get_permalink() ); ?>" class="va-card__link">
    <div class="va-card__image">
      <?php echo wp_get_attachment_image( $hero_image_id, 'va-card-thumb', false, ['class' => 'va-card__img', 'loading' => 'lazy'] ); ?>
      <?php if ( $category_name ) : ?>
        <span class="va-badge va-badge--category"><?php echo esc_html( $category_name ); ?></span>
      <?php endif; ?>
      <?php if ( $tier === 'featured' || $tier === 'premium' || $tier === 'sponsor' ) : ?>
        <span class="va-badge va-badge--featured">Featured</span>
      <?php endif; ?>
    </div>
    <div class="va-card__body">
      <h3 class="va-card__title"><?php echo esc_html( $business_name ); ?></h3>
      <?php if ( $tagline ) : ?>
        <p class="va-card__tagline"><?php echo esc_html( $tagline ); ?></p>
      <?php endif; ?>
      <div class="va-card__meta">
        <?php if ( $area_name ) : ?>
          <span class="va-card__area"><?php echo esc_html( $area_name ); ?></span>
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
- Featured/premium listings get a 3px left border in accent red via `.va-card--featured` or `.va-card--premium`
- Dot separator between area name and price range via `::before` pseudo
- Price range displayed in teal

---

### event-card ✅
Used on: events hub, homepage what's on row, area pages

```html
<article class="va-card va-card--event">
  <a href="<?php echo esc_url( get_permalink() ); ?>" class="va-card__link">
    <div class="va-card__image">
      <?php echo wp_get_attachment_image( $hero_image_id, 'va-card-thumb', false, ['class' => 'va-card__img', 'loading' => 'lazy'] ); ?>
      <?php if ( $is_free ) : ?>
        <span class="va-badge va-badge--free">Free</span>
      <?php endif; ?>
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
- Card body is flexbox: 56×56px date block left, details right
- Date block: light cream bg, rounded, centred text. Day 1.35rem/700 in accent red, month 0.65rem/600 uppercase with 0.05em letter-spacing in `#888`
- Venue 0.85rem `#666`, time 0.8rem teal

---

### walk-card ✅
Used on: the-vale/walks, area pages, Walk of the Week

```html
<article class="va-card va-card--walk">
  <a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="va-card__link">
    <div class="va-card__image">
      <?php echo wp_get_attachment_image( $hero_image_id, 'va-card-thumb', false, ['class' => 'va-card__img', 'loading' => 'lazy'] ); ?>
      <?php if ( $difficulty ) : ?>
        <span class="va-badge va-badge--<?php echo esc_attr( strtolower( $difficulty ) ); ?>"><?php echo esc_html( $difficulty ); ?></span>
      <?php endif; ?>
    </div>
    <div class="va-card__body">
      <h3 class="va-card__title"><?php echo esc_html( $walk_name ); ?></h3>
      <div class="va-card__stats">
        <span class="va-card__stat"><?php echo esc_html( $distance_miles ); ?> miles</span>
        <span class="va-card__stat"><?php echo esc_html( $estimated_time ); ?></span>
        <?php if ( $dog_friendly ) : ?>
          <span class="va-card__stat va-card__stat--dog">Dog friendly</span>
        <?php endif; ?>
        <?php if ( $pushchair ) : ?>
          <span class="va-card__stat">Pushchair friendly</span>
        <?php endif; ?>
      </div>
      <?php if ( $terrain && is_array( $terrain ) ) : ?>
        <div class="va-card__terrain">
          <?php foreach ( $terrain as $type ) : ?>
            <span class="va-card__terrain-tag"><?php echo esc_html( ucfirst( $type ) ); ?></span>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      <?php if ( $parking ) : ?>
        <p class="va-card__parking"><?php echo esc_html( $parking ); ?></p>
      <?php endif; ?>
      <?php if ( $seasonal_notes ) : ?>
        <p class="va-card__seasonal"><?php echo esc_html( $seasonal_notes ); ?></p>
      <?php endif; ?>
    </div>
  </a>
</article>
```

Walk-specific styles:
- Stats use pill-shaped tags: `#f5f5f5` bg, 20px border-radius, 0.75rem/500
- Dog friendly stat has `va-card__stat--dog` which adds a paw emoji via `::before`
- Difficulty colour: easy=teal, moderate=amber `#f59e0b`, challenging=accent red
- Terrain tags: small inline tags below stats
- Parking: 0.8rem, 2-line clamp
- Seasonal notes: italic with top border, 0.75rem, 2-line clamp

---

### area-card ✅
Used on: the-vale hub, homepage explore section

```html
<article class="va-card va-card--area">
  <a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="va-card__link">
    <div class="va-card__image va-card__image--wide">
      <?php echo wp_get_attachment_image( $hero_image_id, 'va-card-wide', false, ['class' => 'va-card__img', 'loading' => 'lazy'] ); ?>
      <div class="va-card__overlay">
        <h3 class="va-card__title"><?php echo esc_html( $area_name ); ?></h3>
        <?php if ( $population ) : ?>
          <p class="va-card__population"><?php echo esc_html( $population ); ?></p>
        <?php endif; ?>
      </div>
    </div>
  </a>
</article>
```

Area-specific styles:
- Image aspect-ratio 16/9 (wider than standard cards)
- Gradient overlay from transparent to `rgba(0,0,0,0.7)` on the image
- Title overlaid on image bottom: white, 1.2rem/600, text-shadow for readability
- No separate body section — text sits on the image
- Population in `rgba(255,255,255,0.8)`

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

Position on card images: `position: absolute; top: 0.75rem; left: 0.75rem; z-index: 2;`
Second badge: `left: auto; right: 0.75rem;`

---

## Grids ✅

Responsive card grid. Used everywhere cards appear.

```html
<div class="va-grid va-grid--{columns}">
  <!-- card components here -->
</div>
```

- Gap: 1rem on mobile, 1.5rem from 640px
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
- Right-edge gradient fade hint via `::after` pseudo-element (white→transparent)
- Gradient adapts to section background (light/dark variants)

---

## Section Headers ✅

Used to introduce every homepage and hub page section.

```html
<div class="va-section-header">
  <h2 class="va-section-header__title"><?php echo esc_html( $title ); ?></h2>
  <?php if ( $link_url ) : ?>
    <a href="<?php echo esc_url( $link_url ); ?>" class="va-section-header__link">
      <?php echo esc_html( $link_text ); ?>
    </a>
  <?php endif; ?>
</div>
```

- Flex row, space-between, baseline aligned, margin-bottom 1.5rem
- Title uses fluid clamp() sizing, no extra margin
- Link: 0.9rem/500 teal with arrow `→` via `::after` pseudo
- On hover: arrow translates X 3px as a motion hint

Note: the arrow is generated by CSS `::after`. Do NOT include the arrow character in the HTML.

---

## Pills & Filters ✅

For filter bars on archive pages. Horizontal scrollable row.

```html
<div class="va-pill-row">
  <a href="..." class="va-pill is-active">All</a>
  <a href="..." class="va-pill">Restaurants</a>
  <a href="..." class="va-pill">Cafes</a>
  <a href="..." class="va-pill">Pubs</a>
</div>
```

- Horizontal scroll on mobile (same snap pattern as scroll row)
- Each pill: white bg, 1px `#e5e5e5` border, 20px radius, 0.85rem/500, `#555` text
- Hover: border and text become teal
- Active: primary bg, white text, border transparent
- Hidden scrollbar

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
- Heading: 1.5rem white. Subtitle: 1rem `rgba(255,255,255,0.7)`, max-width 500px
- Form: stacked on mobile, inline (flex-row) from 640px
- Input: `rgba(255,255,255,0.1)` bg, `rgba(255,255,255,0.2)` border, white text, placeholder at 0.4 opacity. On desktop: left-rounded only (8px 0 0 8px). On mobile: fully rounded (8px).
- Button: accent red bg, white text, 0.85rem 2rem padding, 600 weight. On desktop: right-rounded only. On mobile: fully rounded. Min-height 44px.

---

## Adding New Components

When a new component is needed:
1. Build it following existing conventions (va- prefix, BEM, theme.json tokens via CSS custom properties)
2. Show me for approval
3. Once approved, add the full HTML + CSS pattern to this file with ✅ status
4. From that point forward, use the documented pattern exactly
