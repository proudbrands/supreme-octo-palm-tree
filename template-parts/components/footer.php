<?php
/**
 * Site Footer
 *
 * Three-layer footer: upper links, newsletter bar, copyright bar.
 *
 * @package VisitAylesbury
 */

defined( 'ABSPATH' ) || exit;

// Resolve URLs once.
$things_page = get_page_by_path( 'things-to-do' );
$things_url  = $things_page ? get_permalink( $things_page ) : home_url( '/things-to-do/' );

$food_page = get_page_by_path( 'food-and-drink' );
$food_url  = $food_page ? get_permalink( $food_page ) : home_url( '/food-and-drink/' );

$events_url    = get_post_type_archive_link( 'event' );
$directory_url = get_post_type_archive_link( 'listing' );

// Category term URLs.
$cat_slugs = array(
	'restaurants' => 'Restaurants',
	'pubs-bars'   => 'Pubs',
	'cafes'       => 'Cafes',
	'shopping'    => 'Shops',
	'services'    => 'Services',
	'arts-culture'    => 'Arts &amp; Culture',
	'nightlife'       => 'Nightlife',
);

// Guide URLs.
$guide_slugs = array(
	'visit-aylesbury'         => 'Visit Aylesbury',
	'living-in-aylesbury'     => 'Living in Aylesbury',
	'aylesbury-for-families'  => 'Aylesbury for Families',
	'aylesbury-for-foodies'   => 'Aylesbury for Foodies',
	'getting-here-and-around' => 'Getting Here &amp; Around',
	'business-in-aylesbury'   => 'Business in Aylesbury',
);

// Village data for The Vale column.
$village_slugs = array( 'waddesdon', 'wendover', 'haddenham', 'brill' );
$villages = array();
foreach ( $village_slugs as $slug ) {
	$post = get_page_by_path( $slug, OBJECT, 'area' );
	if ( $post ) {
		$hero    = get_field( 'hero_image', $post->ID );
		$img_id  = $hero ? $hero['id'] : get_post_thumbnail_id( $post->ID );
		$name    = get_field( 'area_name', $post->ID ) ?: get_the_title( $post->ID );
		$villages[] = array(
			'name'   => $name,
			'url'    => get_permalink( $post ),
			'img_id' => $img_id,
		);
	}
}

$walks_page = get_page_by_path( 'the-vale/walks' );
$walks_url  = $walks_page ? get_permalink( $walks_page ) : home_url( '/the-vale/walks/' );
?>

<!-- LAYER 1: Upper footer links -->
<div class="va-footer-upper">
	<div class="va-container">
		<div class="va-footer-grid">

			<!-- Column 1: Explore -->
			<div class="va-footer-col">
				<h3 class="va-footer-col__heading">Explore</h3>
				<ul class="va-footer-col__links">
					<li><a href="<?php echo esc_url( $things_url ); ?>">Things to Do</a></li>
					<li><a href="<?php echo esc_url( $events_url ); ?>">Events</a></li>
					<li><a href="<?php echo esc_url( $food_url ); ?>">Food &amp; Drink</a></li>
					<?php
					$shopping_term = get_term_by( 'slug', 'shopping', 'business_category' );
					$shopping_url  = $shopping_term && ! is_wp_error( $shopping_term ) ? get_term_link( $shopping_term ) : $directory_url;
					?>
					<li><a href="<?php echo esc_url( $shopping_url ); ?>">Shopping</a></li>
					<?php
					$arts_term = get_term_by( 'slug', 'arts-culture', 'business_category' );
					$arts_url  = $arts_term && ! is_wp_error( $arts_term ) ? get_term_link( $arts_term ) : $directory_url;
					?>
					<li><a href="<?php echo esc_url( $arts_url ); ?>">Arts &amp; Culture</a></li>
					<li><a href="<?php echo esc_url( $walks_url ); ?>">Outdoors</a></li>
					<?php
					$nightlife_term = get_term_by( 'slug', 'nightlife', 'business_category' );
					$nightlife_url  = $nightlife_term && ! is_wp_error( $nightlife_term ) ? get_term_link( $nightlife_term ) : $directory_url;
					?>
					<li><a href="<?php echo esc_url( $nightlife_url ); ?>">Nightlife</a></li>
				</ul>
			</div>

			<!-- Column 2: Directory -->
			<div class="va-footer-col">
				<h3 class="va-footer-col__heading">Directory</h3>
				<ul class="va-footer-col__links">
					<li><a href="<?php echo esc_url( $directory_url ); ?>">Browse All</a></li>
					<?php
					$dir_cats = array(
						'restaurants' => 'Restaurants',
						'pubs-bars'   => 'Pubs',
						'cafes'       => 'Cafes',
						'shopping'    => 'Shops',
						'services'    => 'Services',
					);
					foreach ( $dir_cats as $slug => $label ) :
						$term = get_term_by( 'slug', $slug, 'business_category' );
						$url  = $term && ! is_wp_error( $term ) ? get_term_link( $term ) : $directory_url;
					?>
						<li><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a></li>
					<?php endforeach; ?>
					<li><a href="<?php echo esc_url( home_url( '/add-your-business/' ) ); ?>">Add Your Business</a></li>
				</ul>
			</div>

			<!-- Column 3: Guides -->
			<div class="va-footer-col">
				<h3 class="va-footer-col__heading">Guides</h3>
				<ul class="va-footer-col__links">
					<?php foreach ( $guide_slugs as $slug => $label ) :
						$guide = get_page_by_path( $slug, OBJECT, 'guide' );
						$url   = $guide ? get_permalink( $guide ) : home_url( '/guides/' );
					?>
						<li><a href="<?php echo esc_url( $url ); ?>"><?php echo $label; ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<!-- Column 4: The Vale (thumbnail cards) -->
			<div class="va-footer-col">
				<h3 class="va-footer-col__heading">The Vale</h3>
				<div class="va-footer-villages">
					<?php foreach ( $villages as $village ) : ?>
						<a href="<?php echo esc_url( $village['url'] ); ?>" class="va-footer-village">
							<div class="va-footer-village__image">
								<?php if ( $village['img_id'] ) : ?>
									<?php echo wp_get_attachment_image( $village['img_id'], 'thumbnail', false, array( 'class' => 'va-footer-village__img' ) ); ?>
								<?php else : ?>
									<div class="va-footer-village__placeholder"></div>
								<?php endif; ?>
							</div>
							<div class="va-footer-village__text">
								<span class="va-footer-village__name"><?php echo esc_html( $village['name'] ); ?></span>
								<span class="va-footer-village__action">Explore village</span>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Column 5: Useful -->
			<div class="va-footer-col">
				<h3 class="va-footer-col__heading">Useful</h3>
				<ul class="va-footer-col__links">
					<?php
					$useful_pages = array(
						'about'                => 'About',
						'contact'              => 'Contact',
						'submit-an-event'      => 'Submit an Event',
						'privacy-policy'       => 'Privacy Policy',
						'terms-and-conditions' => 'Terms &amp; Conditions',
						'accessibility'        => 'Accessibility',
					);
					foreach ( $useful_pages as $slug => $label ) :
						$page = get_page_by_path( $slug );
						$url  = $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
					?>
						<li><a href="<?php echo esc_url( $url ); ?>"><?php echo $label; ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

		</div>
	</div>
</div>

<!-- LAYER 2: Newsletter bar (floats between upper and copyright) -->
<div class="va-footer-newsletter-wrap">
	<div class="va-container">
		<div class="va-footer-newsletter">
			<div class="va-footer-newsletter__content">
				<div class="va-footer-newsletter__icon">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke="var(--wp--preset--color--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</div>
				<div class="va-footer-newsletter__text">
					<h3 class="va-footer-newsletter__title">Subscribe to our newsletter</h3>
					<p class="va-footer-newsletter__subtitle">Stay updated with the best of Aylesbury, delivered weekly.</p>
				</div>
			</div>
			<form class="va-footer-newsletter__form" action="#" method="post">
				<div class="va-footer-newsletter__input-wrap">
					<input type="email" class="va-footer-newsletter__input" placeholder="Enter your email" required>
				</div>
				<button type="submit" class="va-footer-newsletter__btn">Subscribe</button>
			</form>
		</div>
	</div>
</div>

<!-- LAYER 3: Copyright bar -->
<div class="va-footer-copyright">
	<div class="va-container">
		<div class="va-footer-copyright__inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="va-footer-copyright__brand">aylesbury.town</a>
			<p class="va-footer-copyright__text">&copy; <?php echo esc_html( date( 'Y' ) ); ?> aylesbury.town. All rights reserved.</p>
		</div>
	</div>
</div>
