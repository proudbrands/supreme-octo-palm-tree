# visitaylesbury.uk — Revised Site Architecture
## People-first local discovery platform
### March 2026

---

## 1. Platform Positioning

visitaylesbury.uk is the digital front door to Aylesbury and the Vale.

Not a directory with content bolted on. Not an SEO project with local branding. A genuinely useful local product that people return to because it helps them do something.

The platform serves three audiences:

- **Visitors** looking for inspiration, events, places to eat, attractions, and day-trip ideas
- **Residents** looking for useful local discovery, practical guides, trusted recommendations, and things to do
- **Businesses and venues** looking for visibility, promotion, and measurable value where local intent already exists

Every architectural decision follows from one question: does this help someone use Aylesbury better?

---

## 2. What the Competitors Are Missing

### visitaylesbury.co.uk (Buckinghamshire Council)
Seven thin pages. No business directory. No blog. No Schema markup. Still running deprecated Google Analytics UA. No SEO strategy. No newsletter. No user engagement. No walks, no villages, no seasonal content.

### aylesbury.info (Independent)
Has a directory skeleton but listings are sparse with many empty categories. News is entirely scraped RSS from the Bucks Free Press (half the stories are about High Wycombe). No original editorial content. No SEO-optimised guides. No Aylesbury Vale village coverage. No walks. Design is dated.

### Our opportunity
Neither competitor has: SEO-first editorial content, rich business profiles, village/Vale coverage, walks and outdoors content, seasonal campaign pages, interactive maps, Schema.org structured data, newsletter infrastructure, revenue infrastructure, or any content that would make someone come back a second time.

---

## 3. Top-Level Navigation

```
Home
Things to Do
Events
Food & Drink
Directory
The Vale
Guides
About
```

Eight items. Clean, practical, journey-led. Every section answers a real question.

**Why this structure:**
- "Things to Do" is clearer than "Explore" and matches the highest-volume search pattern
- "Food & Drink" is elevated to top-level because it's the highest-repeat local use case and the strongest commercial section
- "The Vale" is the strategic differentiator that neither competitor attempts
- "Guides" houses the evergreen SEO pillar pages
- "Directory" is the commercial engine but not the lead item
- No "Stories" or "Blog" in the nav — editorial content lives within each section contextually and through Guides, not as a separate silo

---

## 4. URL Architecture

### Core Hubs
```
/                                   → Homepage
/things-to-do/                      → Activity discovery hub
/events/                            → Events hub
/food-and-drink/                    → Food & Drink hub
/directory/                         → Business directory
/the-vale/                          → Aylesbury Vale hub
/guides/                            → Editorial guides index
/about/                             → About, contact, work with us
```

### Things to Do
```
/things-to-do/today/
/things-to-do/this-weekend/
/things-to-do/free/
/things-to-do/family/
/things-to-do/indoor/
/things-to-do/outdoors/
/things-to-do/arts-and-culture/
/things-to-do/shopping/
/things-to-do/attractions/
/things-to-do/nightlife/
```

### Events
```
/events/this-week/
/events/this-weekend/
/events/this-month/
/events/free/
/events/family/
/events/food-and-drink/
/events/seasonal/
/events/submit/
```

### Food & Drink
```
/food-and-drink/restaurants/
/food-and-drink/pubs/
/food-and-drink/cafes/
/food-and-drink/brunch/
/food-and-drink/sunday-lunch/
/food-and-drink/independent-favourites/
/food-and-drink/offers/
```

### Directory
```
/directory/browse/
/directory/restaurants/
/directory/shops/
/directory/services/
/directory/trades/
/directory/health-and-wellbeing/
/directory/professional-services/
/directory/venues/
/directory/[business-slug]/           → Single listing page
/directory/add-business/
/directory/claim/
```

### The Vale
```
/the-vale/waddesdon/
/the-vale/wendover/
/the-vale/haddenham/
/the-vale/long-crendon/
/the-vale/brill/
/the-vale/quainton/
/the-vale/weston-turville/
/the-vale/stoke-mandeville/
/the-vale/walks/
/the-vale/walks/coombe-hill/
/the-vale/walks/aylesbury-ring/
/the-vale/day-trips-from-aylesbury/
/the-vale/day-trips-to-aylesbury/
```

### Guides
```
/guides/visit-aylesbury/
/guides/living-in-aylesbury/
/guides/aylesbury-for-families/
/guides/aylesbury-for-foodies/
/guides/aylesbury-for-dog-owners/
/guides/aylesbury-for-history-lovers/
/guides/aylesbury-for-commuters/
/guides/business-in-aylesbury/
/guides/getting-here-and-around/
/guides/christmas-in-aylesbury/
/guides/best-market-towns-buckinghamshire/
/guides/hidden-gems-near-oxford/
/guides/day-trips-from-london-buckinghamshire/
/guides/david-bowie-aylesbury/
```

---

## 5. Content Model & WordPress Data Structure

Five content types. Lean enough for Phase 1, structured enough for Phase 2.

### 5.1 Listing (CPT: `listing`)

The commercial engine. Every business, shop, restaurant, service, venue.

**ACF Fields:**
```
Business Details
  - business_name (text)
  - tagline (text, 120 chars)
  - description (wysiwyg)
  - logo (image)
  - hero_image (image)
  - gallery (gallery, up to 10)

Taxonomy
  - business_category (taxonomy)
  - area (taxonomy: Town Centre, Old Town, Fairford Leys, Bedgrove, Berryfields, etc.)
  - vale_village (taxonomy: for businesses outside Aylesbury proper)

Contact & Location
  - address (text)
  - postcode (text)
  - latitude (number)
  - longitude (number)
  - phone (text)
  - email (email)
  - website (url)
  - social_links (repeater: platform + url)
  - opening_hours (repeater: day + open + close + closed_bool)

Features & Attributes
  - price_range (select: £ / ££ / £££ / ££££)
  - features (checkbox: dog_friendly, wheelchair_accessible, wifi,
    parking, outdoor_seating, child_friendly, vegan_options,
    gluten_free, live_music, private_hire)
  - food_drink_subcategory (taxonomy: used for Food & Drink section
    filtering — Brunch, Sunday Lunch, Independent Favourites, etc.)

Commercial
  - listing_tier (select: free / featured / premium / sponsor)
  - featured_until (date)
  - offers (repeater: title + description + expiry)
  - claim_status (select: unclaimed / pending / claimed / verified)
  - owner_user (user)
```

**Schema output:** `LocalBusiness` (or subtype: `Restaurant`, `BarOrPub`, `Store`, `ProfessionalService`) with structured address, openingHours, priceRange, image, telephone.

**Listing tier logic:**
- **Free:** Name, category, address, phone, website link. Auto-populated at launch from scraped data.
- **Featured:** All free fields plus hero image, gallery, tagline, description, opening hours. Appears in "Featured" slots on homepage and category pages. £25-35/month.
- **Premium:** All featured fields plus offers, social links, analytics dashboard (page views, click-throughs). Priority placement. £40-50/month.
- **Sponsor:** Premium plus branded content slot, newsletter inclusion, seasonal guide placement. Negotiated pricing.

### 5.2 Event (CPT: `event`)

**ACF Fields:**
```
  - event_name (text)
  - description (wysiwyg)
  - event_category (taxonomy: Music, Theatre, Family, Food & Drink,
    Community, Sports, Markets, Seasonal, Free)
  - start_date (date)
  - end_date (date)
  - start_time (time)
  - end_time (time)
  - recurrence (select: one-off / weekly / monthly / annually)
  - venue_name (text)
  - venue_listing (post object → listing CPT)
  - address (text)
  - postcode (text)
  - latitude (number)
  - longitude (number)
  - ticket_url (url)
  - price (text — handles "Free", "£5-£15", "From £10")
  - is_free (boolean)
  - is_family_friendly (boolean)
  - hero_image (image)
  - organiser_name (text)
  - organiser_email (email)
  - featured (boolean)
  - submission_status (select: draft / pending / approved / expired)
```

**Schema output:** `Event` with name, startDate, endDate, location, offers, image.

**Submission flow:** Gravity Forms front-end form → pending queue → admin approval → published. Venues with claimed listings get a streamlined submission path.

### 5.3 Walk (CPT: `walk`)

Walks are structurally different enough from listings and places to warrant their own CPT. A walk has a route, distance, terrain, GPX file, and a completely different page layout.

**ACF Fields:**
```
  - walk_name (text)
  - description (wysiwyg)
  - difficulty (select: Easy / Moderate / Challenging)
  - distance_miles (number)
  - estimated_time (text)
  - start_point (text)
  - start_postcode (text)
  - start_lat (number)
  - start_lng (number)
  - gpx_file (file — downloadable)
  - terrain (checkbox: paved, gravel, grass, muddy, stiles, steps, steep)
  - dog_friendly (boolean)
  - pushchair_friendly (boolean)
  - pub_on_route (post object → listing)
  - cafe_on_route (post object → listing)
  - parking (text)
  - highlights (repeater: name + description + image)
  - seasonal_notes (textarea)
  - gallery (gallery)
  - nearby_listings (relationship → listing CPT)
  - area (taxonomy — links to Vale village or Aylesbury area)
```

### 5.4 Area (CPT: `area`)

Villages, neighbourhoods, and distinct areas. Each area page is a mini-hub that automatically pulls in related listings, events, and walks.

**ACF Fields:**
```
  - area_name (text)
  - area_type (select: Village / Neighbourhood / Town)
  - introduction (wysiwyg)
  - history (wysiwyg)
  - getting_there (wysiwyg)
  - hero_image (image)
  - gallery (gallery)
  - latitude (number)
  - longitude (number)
  - key_attractions (repeater: name + description + link)
  - fun_fact (text)
  - population (text)
  - local_walks (relationship → walk CPT)
  - nearest_pub (post object → listing)
  - nearest_cafe (post object → listing)
```

Related listings and events are pulled dynamically via the shared `area` and `vale_village` taxonomies rather than hardcoded relationships.

### 5.5 Guide (CPT: `guide`)

The SEO pillar pages and seasonal content. Uses the Gutenberg editor for rich editorial layout with ACF for structured metadata.

**ACF Fields:**
```
  - guide_type (taxonomy: Visitor, Seasonal, Living, Business,
    Day Trip, Audience — e.g. "for Families", "for Foodies")
  - hero_image (image)
  - related_listings (relationship → listing CPT)
  - related_events (relationship → event CPT)
  - related_walks (relationship → walk CPT)
  - related_areas (relationship → area CPT)
  - call_to_action (group: cta_text + cta_url)
  - last_verified (date — trust signal: "Updated March 2026")
  - seasonal_flag (select: none / spring / summer / autumn / winter / christmas / easter)
```

**Important:** Guides are not blog posts. They are maintained, updated, and evergreen. They are the pages that rank for "things to do in Aylesbury," "living in Aylesbury," "best market towns near London." They get refreshed quarterly, not published and forgotten.

### Standard Posts (Blog / Editorial)

Standard WordPress posts with categories: People & Community, Heritage & History, Food & Drink, Outdoors, Business, Seasonal. These are the publishing-velocity content that keeps the site fresh and builds topical authority. One per week minimum.

Examples: "10 Best Sunday Roasts in Aylesbury," "Walking the Aylesbury Ring in Winter," "The Story Behind Friars Aylesbury," "5 Dog-Friendly Pubs You Should Know About."

Posts link to listings, events, walks, and areas through inline links and a "Related Listings" block at the bottom of each post. This is how editorial content drives directory engagement.

---

## 6. Homepage Architecture

The homepage answers six questions:

1. What's happening soon?
2. What can I do?
3. Where should I eat and drink?
4. What's beyond the town centre?
5. Who's worth knowing about?
6. Why should I come back?

### Section-by-section:

**1. Hero**
Full-width image (seasonal rotation). Search bar: "What are you looking for?" Quick-action pills below: Things to Do, Events, Eat & Drink, The Vale, Directory. On mobile, these stack vertically as the primary entry points.

**2. What's On This Week**
Auto-populated horizontal scroll of the next 6-8 events. Image, title, date, venue, "Free" badge. Zero manual curation needed — pulls from events CPT by date.

**3. Things to Do This Weekend**
Curated or auto-populated cards. Mix of events and guide teasers. "Family days out," "Free things to do," featured attraction. This section changes every week and creates a reason to return.

**4. Featured Food & Drink**
3-4 restaurant/pub/cafe cards from listings with `food_drink` category and `featured` or `premium` tier. Seasonal rotation. Revenue slot. "Where to eat this week."

**5. Explore the Vale**
Interactive Leaflet.js map with village pins. Brief intro text. 3 featured village cards (Waddesdon, Wendover, Brill or seasonal rotation). This is the differentiator section that signals the site covers more than the town centre.

**6. Useful Guides**
3 guide cards. Rotate based on season and audience: "Visit Aylesbury" in summer, "Christmas in Aylesbury" in December, "Living in Aylesbury" for evergreen traffic.

**7. Featured Businesses**
3-4 business cards from the directory. Spotlight Lottery: one randomly featured free-tier business alongside 2-3 paid featured/premium listings. Refreshes weekly.

**8. Newsletter Signup**
"Get the best of Aylesbury in your inbox. Weekly events, local picks, and exclusive offers." Simple email capture. Builds the community list that becomes a revenue channel.

---

## 7. Recurring Content Formats

These are the editorial engines that keep the site alive, build SEO authority, and create shareable social content.

### The Aylesbury Dozen
Monthly curated list of 12 things to do. Visually designed as a numbered card layout that people screenshot and share. Each item links to an event, listing, or guide. Published first of every month.

### Walk of the Week
Featured walk every week with photos, GPX download, and a recommended pub stop. Cross-links to the pub's listing. Builds the walks library while targeting outdoor search terms.

### Spotlight Lottery
Every week, one free-tier business gets randomly featured on the homepage for 7 days. Free, fair, generates goodwill and word-of-mouth. When businesses see the traffic bump, they upgrade to guaranteed placement.

### Ask a Local
Q&A format blog post. "Where's the best breakfast in Aylesbury?" answered by a named local with their photo. Builds community, creates authentic content, targets long-tail search terms.

### Seasonal Guides
Christmas in Aylesbury (November publish), Summer in the Vale (May), Easter Half-Term (March), Autumn Walks (September). Each is a rich guide page with related events, listings, and walks pulled in via ACF relationships. Sponsorable.

---

## 8. Technical Stack

### WordPress FSE + ACF
- Custom FSE theme. No page builder. Clean, fast, accessible.
- Registered Gutenberg blocks for listings, events, maps, featured sections.
- ACF Pro for all structured data on CPTs.
- RankMath for on-page SEO and Schema.org output.
- Gravity Forms for business submissions, event submissions, contact, and newsletter signup.
- Matomo for analytics (self-hosted, GDPR-compliant, council-friendly).

### Maps
- Leaflet.js with OpenStreetMap tiles (free, no API costs).
- Custom markers by category. Cluster at zoom-out.
- Map on: directory page, individual listings, area pages, walk pages, homepage Vale section.

### Search
- Relevanssi or SearchWP for proper cross-CPT search.
- Faceted filtering on directory: category, area, features, price range.
- "Near me" functionality using browser geolocation + Leaflet.

### Schema.org
- `LocalBusiness` (and subtypes) on every listing
- `Event` on every event
- `TouristAttraction` on attraction listings
- `ExerciseAction` and `TouristAttraction` on walks
- `FAQPage` on guide pages where appropriate
- `BreadcrumbList` sitewide

### Performance
- Target sub-2-second load. Lazy-loaded images. Minimal JS. Server-side caching. CDN.
- Managed WordPress hosting (Cloudways, SpinupWP, or GridPane on a VPS).

---

## 9. Phase 1: Launch Scope

### Objective
Build the minimum complete experience that proves usefulness, attracts an audience, and generates early commercial interest.

### Phase 1 delivers:
- Homepage with all 8 sections functional
- Things to Do hub with 5+ child pages
- Events hub with date filtering and submission form
- Food & Drink hub with category pages
- Directory with 500+ pre-populated listings (scraped from Google Business Profiles, Yell, existing sources)
- Business claim and submission flow
- 6-8 Vale area pages (Waddesdon, Wendover, Haddenham, Brill, Long Crendon, Quainton, Stoke Mandeville, Weston Turville)
- 3-5 walks with GPX downloads
- 10-15 guide pages targeting priority keywords
- Newsletter signup
- Leaflet.js map integration
- Schema.org markup on all CPTs
- Matomo analytics
- Featured listing placements (revenue-ready from day one)

### Priority launch content:
1. Home
2. Things to Do in Aylesbury (hub)
3. What's On in Aylesbury (events hub)
4. Food and Drink in Aylesbury (hub)
5. Visit Aylesbury (guide)
6. Living in Aylesbury (guide)
7. Aylesbury for Families (guide)
8. Free Things to Do in Aylesbury (guide)
9. Best Sunday Lunch in Aylesbury (editorial)
10. Waddesdon (area)
11. Wendover / Wendover Woods (area + walk)
12. Haddenham (area)
13. Brill (area)
14. Coombe Hill Walk (walk)
15. Aylesbury Town Centre (guide)
16. David Bowie's Aylesbury (guide)
17. Seasonal guide (whichever season we launch in)
18. Business directory with 500+ listings

---

## 10. Phase 2: Participation & Intelligence (Month 6+)

### Objective
Add user participation, business tooling, and smarter content operations.

### Phase 2 delivers:
- Business self-service dashboard (update listing, view analytics, manage offers)
- Offers board (dedicated page showing current deals from premium listings)
- Self-service event publishing with moderation queue
- Smarter related-content automation (auto-suggest related listings on guides, auto-populate "nearby" on area pages)
- Newsletter segmentation by interest
- Premium listing tier with analytics reporting
- Sponsored guide modules
- Editorial automation (scheduled Spotlight Lottery rotation, auto-expiry of events)
- AI-assisted content drafts for new area pages, listing descriptions
- Walk of the Week and Aylesbury Dozen as established weekly/monthly features
- Stronger map filtering (by category, by feature, by area)
- "Visit Aylesbury Awards" (annual community-voted awards — massive engagement and PR)

### Phase 2 commercial expansion:
- Premium business profiles with analytics
- Sponsored categories ("Restaurants presented by [brand]")
- Promoted offers
- Campaign partnerships (Christmas Guide Sponsor, Summer in the Vale Sponsor)
- Seasonal sponsorship packages
- Council licensing or acquisition conversation (backed by 6+ months of traffic data)

---

## 11. Outreach & Community Building

### Launch (Month 1)
- Scrape and import 500+ businesses from public sources
- Set all to `claim_status: unclaimed`
- Email every business: "Your business is listed on visitaylesbury.uk — claim your free listing"
- This populates the directory and starts relationships

### Months 2-4
- Partner with Business Buzz Aylesbury for cross-promotion
- Approach Waterside Theatre, Discover Bucks Museum, Waddesdon Manor for event feed partnerships
- Contact Aylesbury Town Council events team for calendar data
- Target 500 newsletter subscribers

### Months 4-8
- Approach 50 businesses for premium listing upgrades
- Launch Business of the Month sponsorship
- Pitch seasonal guide sponsorship
- Engage local photographers for content partnerships

### Months 8-12
- Approach council with traffic data and partnership conversation
- Explore advertising partnerships with regional brands
- Consider "Visit Aylesbury Awards" for annual engagement
- Revenue review and Phase 2 planning

---

## 12. Publishing Cadence

### Weekly
- 1 editorial post (rotate: food, outdoors, family, history, living)
- Events updated (community submissions + manual curation)
- 1 social cross-post per article

### Monthly
- Business of the Month spotlight
- The Aylesbury Dozen
- Newsletter digest
- Directory maintenance (closed businesses, new listings)

### Quarterly
- Seasonal guide (publish or refresh)
- Traffic report (publishable content + value demonstration)
- Outreach push (20-30 unclaimed businesses contacted)

### Annually
- Full directory audit
- SEO audit and keyword refresh
- Revenue review
- Content strategy planning

---

## 13. Editorial Principles

Content should:
- Answer real questions quickly
- Help people take action (go somewhere, eat something, do something)
- Connect related content naturally through internal links and ACF relationships
- Support repeat visits through freshness and regularity
- Feel local, current, and trustworthy
- Avoid thin SEO-only pages — every page should be genuinely useful to a human

The site should feel alive. If someone visits on a Tuesday and again on a Friday, something should have changed. Events auto-expire, featured businesses rotate, the Spotlight Lottery picks a new business, the latest editorial post appears. The homepage is never stale.

---

## 14. Why WordPress, Not Headless

The headless Next.js + Sanity approach has merits for scale, but for this project WordPress is the right choice because:

- **Speed to market.** WordPress FSE + ACF gets us live in 6-8 weeks. A headless build doubles that.
- **Cost.** The build is largely in-house Proud Brands capability. No additional developer needed for Sanity/Next.js.
- **Content operations.** WordPress's admin is familiar and fast for non-technical editors (council staff, business contributors, event submitters).
- **Community submissions.** Gravity Forms + WordPress handles front-end submissions, moderation queues, and email notifications out of the box. Replicating this in a headless stack requires custom backend work.
- **Plugin ecosystem.** RankMath, Relevanssi, Matomo, Gravity Forms — all battle-tested, all maintained, all cheap.
- **Portability.** If the council acquires the site, WordPress is the most widely understood CMS in the world. Any developer can maintain it. That's a selling point.
- **Future flexibility.** If the site grows to a point where headless makes sense, WordPress can serve as a headless backend (WPGraphQL or REST API) with a Next.js frontend added later. The data model doesn't change.

The architecture described in this document maps cleanly to WordPress CPTs + ACF. It also maps to Sanity document types if the stack ever migrates. The content model is stack-agnostic. The delivery choice is pragmatic.
