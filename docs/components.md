# Component Library — visitaylesbury.uk

> This file is the single source of truth for all approved UI components.
> Claude Code MUST use these exact patterns. Do not redesign or deviate.
> If a component doesn't exist here yet, build it, get approval, then add it.

## Status Key
- ✅ Approved — use exactly as documented
- 🚧 Draft — built but not yet approved
- ❌ Rejected — do not use

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

Key styles:
```css
.va-card--listing {
  background: var(--wp--preset--color--white);
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 1px 3px rgba(0,0,0,0.08);
  transition: box-shadow 0.2s ease, transform 0.2s ease;
}
.va-card--listing:hover {
  box-shadow: 0 4px 12px rgba(0,0,0,0.12);
  transform: translateY(-2px);
}
.va-card__image {
  position: relative;
  aspect-ratio: 16 / 10;
  overflow: hidden;
}
.va-card__img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.va-card__body {
  padding: 1rem;
}
.va-card__title {
  font-size: 1.1rem;
  font-weight: 600;
  color: var(--wp--preset--color--primary);
  margin: 0 0 0.25rem;
}
.va-card__tagline {
  font-size: 0.9rem;
  color: var(--wp--preset--color--grey-600);
  margin: 0 0 0.5rem;
}
.va-card__meta {
  display: flex;
  gap: 0.75rem;
  font-size: 0.8rem;
  color: var(--wp--preset--color--grey-600);
}
```

Image size: `va-card-thumb` registered at 480x300, hard crop.

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

Key difference from listing-card: `.va-card__body` uses flexbox with date block on left, details on right.
```css
.va-card--event .va-card__body {
  display: flex;
  gap: 1rem;
  padding: 1rem;
}
.va-card__date {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-width: 3rem;
  padding: 0.5rem;
  background: var(--wp--preset--color--light);
  border-radius: 6px;
  text-align: center;
}
.va-card__date-day {
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--wp--preset--color--accent);
  line-height: 1;
}
.va-card__date-month {
  font-size: 0.7rem;
  font-weight: 600;
  text-transform: uppercase;
  color: var(--wp--preset--color--grey-600);
}
.va-card__venue {
  font-size: 0.85rem;
  color: var(--wp--preset--color--grey-600);
  margin: 0.15rem 0 0;
}
.va-card__time {
  font-size: 0.8rem;
  color: var(--wp--preset--color--teal);
}
```

---

### walk-card 🚧
Used on: the-vale/walks, area pages, Walk of the Week

Same outer shell as listing-card. Additional meta row:
```html
<div class="va-card__stats">
  <span class="va-card__stat"><?php echo esc_html( $distance ); ?> miles</span>
  <span class="va-card__stat va-card__stat--<?php echo esc_attr( strtolower($difficulty) ); ?>">
    <?php echo esc_html( $difficulty ); ?>
  </span>
  <?php if ( $dog_friendly ) : ?>
    <span class="va-card__stat">🐕 Dog friendly</span>
  <?php endif; ?>
</div>
```

---

### area-card 🚧
Used on: the-vale hub, homepage explore section

Same outer shell as listing-card but no meta row. Larger image (aspect-ratio: 16/9). Village name as title. Short intro as tagline. Population as small meta if available.

---

## Badges

### va-badge ✅
```html
<span class="va-badge va-badge--{variant}">{Label}</span>
```

Variants:
```css
.va-badge {
  display: inline-block;
  padding: 0.2rem 0.6rem;
  font-size: 0.7rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.03em;
  border-radius: 4px;
  line-height: 1.4;
}
.va-badge--category {
  background: var(--wp--preset--color--primary);
  color: var(--wp--preset--color--white);
}
.va-badge--featured {
  background: var(--wp--preset--color--accent);
  color: var(--wp--preset--color--white);
}
.va-badge--free {
  background: var(--wp--preset--color--teal);
  color: var(--wp--preset--color--white);
}
.va-badge--family {
  background: #F4A261;
  color: var(--wp--preset--color--dark);
}
```

Position on card images: `position: absolute; top: 0.75rem; left: 0.75rem; z-index: 2;`

---

## Grids

### va-grid ✅
Responsive card grid. Used everywhere cards appear.

```html
<div class="va-grid va-grid--{columns}">
  <!-- card components here -->
</div>
```

```css
.va-grid {
  display: grid;
  gap: 1.5rem;
}
.va-grid--3 {
  grid-template-columns: repeat(1, 1fr);
}
@media (min-width: 640px) {
  .va-grid--3 { grid-template-columns: repeat(2, 1fr); }
}
@media (min-width: 1024px) {
  .va-grid--3 { grid-template-columns: repeat(3, 1fr); }
}
.va-grid--4 {
  grid-template-columns: repeat(1, 1fr);
}
@media (min-width: 640px) {
  .va-grid--4 { grid-template-columns: repeat(2, 1fr); }
}
@media (min-width: 1024px) {
  .va-grid--4 { grid-template-columns: repeat(4, 1fr); }
}
```

---

## Horizontal Scroll Row

### va-scroll-row ✅
Used for: homepage event row, "more like this" sections

```html
<div class="va-scroll-row">
  <div class="va-scroll-row__inner">
    <!-- card components here -->
  </div>
</div>
```

```css
.va-scroll-row {
  overflow: hidden;
  margin: 0 -1.5rem;
  padding: 0 1.5rem;
}
.va-scroll-row__inner {
  display: flex;
  gap: 1.25rem;
  overflow-x: auto;
  scroll-snap-type: x mandatory;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: none;
  padding-bottom: 0.5rem;
}
.va-scroll-row__inner::-webkit-scrollbar {
  display: none;
}
.va-scroll-row__inner > * {
  flex: 0 0 280px;
  scroll-snap-align: start;
}
@media (min-width: 768px) {
  .va-scroll-row__inner > * {
    flex: 0 0 320px;
  }
}
```

---

## Section Headers

### va-section-header ✅
Used to introduce every homepage and hub page section.

```html
<div class="va-section-header">
  <h2 class="va-section-header__title"><?php echo esc_html( $title ); ?></h2>
  <?php if ( $link_url ) : ?>
    <a href="<?php echo esc_url( $link_url ); ?>" class="va-section-header__link">
      <?php echo esc_html( $link_text ); ?> →
    </a>
  <?php endif; ?>
</div>
```

```css
.va-section-header {
  display: flex;
  justify-content: space-between;
  align-items: baseline;
  margin-bottom: 1.25rem;
}
.va-section-header__title {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--wp--preset--color--primary);
  margin: 0;
}
.va-section-header__link {
  font-size: 0.9rem;
  font-weight: 500;
  color: var(--wp--preset--color--teal);
  text-decoration: none;
}
.va-section-header__link:hover {
  text-decoration: underline;
}
```

---

## Adding New Components

When a new component is needed:
1. Build it following existing conventions (va- prefix, BEM, theme.json tokens)
2. Show me for approval
3. Once approved, add the full HTML + CSS pattern to this file with ✅ status
4. From that point forward, use the documented pattern exactly
