# ACF Field Reference — visitaylesbury.uk

> Always read this file before writing any template that uses get_field().
> Field names, types, and return formats are exact. Do not guess.

## listing (CPT)

| Field Name | Type | Return | Notes |
|---|---|---|---|
| business_name | text | string | Required |
| tagline | text | string | Max 120 chars |
| description | wysiwyg | string (HTML) | Use wp_kses_post() |
| logo | image | array | Use $logo['id'] for wp_get_attachment_image() |
| hero_image | image | array | Use $hero['id'] |
| gallery | gallery | array of arrays | Each item has 'id', 'url', 'alt' |
| address | text | string | |
| postcode | text | string | |
| latitude | number | float | |
| longitude | number | float | |
| phone | text | string | |
| email | email | string | |
| website | url | string | |
| social_links | repeater | array | Sub: platform (select), url (url) |
| opening_hours | repeater | array | Sub: day (select), open (text), close (text), closed (true_false) |
| price_range | select | string | Values: £, ££, £££, ££££ |
| features | checkbox | array | Values: dog_friendly, wheelchair_accessible, wifi, parking, outdoor_seating, child_friendly, vegan_options, gluten_free, live_music, private_hire |
| food_drink_subcategory | taxonomy (food_subcategory) | array of WP_Term | Multiple. Used for F&D section filtering |
| listing_tier | select | string | Values: free, featured, premium, sponsor |
| featured_until | date | string | Format: Ymd |
| offers | repeater | array | Sub: offer_title (text), offer_description (textarea), offer_expiry (date) |
| claim_status | select | string | Values: unclaimed, pending, claimed, verified |
| owner_user | user | array | WP user array |

**Taxonomies on listing:**
- `business_category` — hierarchical
- `area_tax` — flat
- `vale_village` — flat

**Common query pattern:**
```php
$listings = new WP_Query([
  'post_type' => 'listing',
  'posts_per_page' => 12,
  'tax_query' => [
    [
      'taxonomy' => 'business_category',
      'field' => 'slug',
      'terms' => 'restaurants',
    ],
  ],
  'meta_query' => [
    [
      'key' => 'listing_tier',
      'value' => ['featured', 'premium', 'sponsor'],
      'compare' => 'IN',
    ],
  ],
  'orderby' => 'meta_value',
  'meta_key' => 'listing_tier',
]);
```

---

## event (CPT)

| Field Name | Type | Return | Notes |
|---|---|---|---|
| event_name | text | string | Required |
| description | wysiwyg | string (HTML) | |
| start_date | date | string | Format: Ymd |
| end_date | date | string | Format: Ymd |
| start_time | time | string | Format: H:i |
| end_time | time | string | Format: H:i |
| recurrence | select | string | Values: one-off, weekly, monthly, annually |
| venue_name | text | string | |
| venue_listing | post_object | WP_Post | Points to listing CPT |
| address | text | string | |
| postcode | text | string | |
| latitude | number | float | |
| longitude | number | float | |
| ticket_url | url | string | |
| price | text | string | Free-form: "Free", "£5-£15", "From £10" |
| is_free | true_false | bool | |
| is_family_friendly | true_false | bool | |
| hero_image | image | array | |
| organiser_name | text | string | |
| organiser_email | email | string | |
| featured | true_false | bool | |
| submission_status | select | string | Values: draft, pending, approved, expired |

**Taxonomies on event:**
- `event_category` — flat

**Common query (upcoming events):**
```php
$events = new WP_Query([
  'post_type' => 'event',
  'posts_per_page' => 8,
  'meta_key' => 'start_date',
  'orderby' => 'meta_value',
  'order' => 'ASC',
  'meta_query' => [
    [
      'key' => 'start_date',
      'value' => date('Ymd'),
      'compare' => '>=',
      'type' => 'DATE',
    ],
    [
      'key' => 'submission_status',
      'value' => 'approved',
    ],
  ],
]);
```

**Date display helper:**
```php
$start = get_field('start_date');
$day = date('j', strtotime($start));
$month = date('M', strtotime($start));
```

---

## walk (CPT)

| Field Name | Type | Return | Notes |
|---|---|---|---|
| walk_name | text | string | |
| description | wysiwyg | string (HTML) | |
| difficulty | select | string | Values: Easy, Moderate, Challenging |
| distance_miles | number | float | |
| estimated_time | text | string | "1.5 hours" |
| start_point | text | string | |
| start_postcode | text | string | |
| start_lat | number | float | |
| start_lng | number | float | |
| gpx_file | file | array | $gpx['url'] for download link |
| terrain | checkbox | array | Values: paved, gravel, grass, muddy, stiles, steps, steep |
| dog_friendly | true_false | bool | |
| pushchair_friendly | true_false | bool | |
| pub_on_route | post_object | WP_Post | Points to listing CPT |
| cafe_on_route | post_object | WP_Post | Points to listing CPT |
| parking | text | string | |
| highlights | repeater | array | Sub: name (text), description (textarea), image (image) |
| seasonal_notes | textarea | string | |
| gallery | gallery | array | |
| nearby_listings | relationship | array of WP_Post | Points to listing CPT |

**Taxonomies on walk:**
- `area_tax`
- `vale_village`

---

## area (CPT)

| Field Name | Type | Return | Notes |
|---|---|---|---|
| area_name | text | string | |
| area_type | select | string | Values: Village, Neighbourhood, Town |
| introduction | wysiwyg | string (HTML) | |
| history | wysiwyg | string (HTML) | |
| getting_there | wysiwyg | string (HTML) | |
| hero_image | image | array | |
| gallery | gallery | array | |
| latitude | number | float | |
| longitude | number | float | |
| key_attractions | repeater | array | Sub: name (text), description (textarea), link (url) |
| fun_fact | text | string | |
| population | text | string | |
| local_walks | relationship | array of WP_Post | Points to walk CPT |
| nearest_pub | post_object | WP_Post | Points to listing CPT |
| nearest_cafe | post_object | WP_Post | Points to listing CPT |

**Related content:** Listings and events in this area are queried dynamically using the shared `area_tax` or `vale_village` taxonomy, not hardcoded relationships.

---

## guide (CPT)

| Field Name | Type | Return | Notes |
|---|---|---|---|
| hero_image | image | array | |
| related_listings | relationship | array of WP_Post | |
| related_events | relationship | array of WP_Post | |
| related_walks | relationship | array of WP_Post | |
| related_areas | relationship | array of WP_Post | |
| call_to_action | group | array | Sub: cta_text (text), cta_url (url) |
| last_verified | date | string | Format: Ymd. Display as "Updated March 2026" |
| seasonal_flag | select | string | Values: none, spring, summer, autumn, winter, christmas, easter |

**Taxonomies on guide:**
- `guide_type` — flat

Guide body content uses the Gutenberg editor. ACF fields are for structured metadata and cross-references only.

---

## Image Sizes

Register in inc/setup.php:
```php
add_image_size( 'va-card-thumb', 480, 300, true );
add_image_size( 'va-hero', 1200, 600, true );
add_image_size( 'va-gallery', 800, 600, true );
add_image_size( 'va-avatar', 80, 80, true );
```

Always use named sizes in wp_get_attachment_image(). Never use 'full' in card contexts.
