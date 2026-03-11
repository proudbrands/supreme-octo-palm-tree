<?php
/**
 * Card: Listing
 *
 * Vertical card with inset image, category pill, divider, meta row.
 * Receives post ID via $args['post_id'].
 *
 * @package VisitAylesbury
 */

defined( 'ABSPATH' ) || exit;

$post_id = $args['post_id'] ?? get_the_ID();

// ACF fields.
$business_name = get_field( 'business_name', $post_id );
$tagline       = get_field( 'tagline', $post_id );
$hero_image    = get_field( 'hero_image', $post_id );
$price_range   = get_field( 'price_range', $post_id );
$tier          = get_field( 'listing_tier', $post_id );

$hero_image_id = $hero_image ? $hero_image['id'] : get_post_thumbnail_id( $post_id );

// Primary business category.
$category_name = '';
$cat_emoji     = '';
$cats          = get_the_terms( $post_id, 'business_category' );
if ( $cats && ! is_wp_error( $cats ) ) {
	$category_name = $cats[0]->name;
	$emoji_map     = array(
		'restaurants'   => '🍽️',
		'pubs'          => '🍺',
		'cafes'         => '☕',
		'hotels'        => '🏨',
		'shops'         => '🛍️',
		'entertainment' => '🎭',
		'health-beauty' => '💆',
		'services'      => '🔧',
	);
	$cat_emoji = $emoji_map[ $cats[0]->slug ] ?? '📍';
}

// Area name.
$area_name = '';
$areas     = get_the_terms( $post_id, 'area_tax' );
if ( $areas && ! is_wp_error( $areas ) ) {
	$area_name = $areas[0]->name;
}
?>

<article class="va-card va-card--listing<?php echo ( $tier === 'featured' || $tier === 'premium' || $tier === 'sponsor' ) ? ' va-card--featured' : ''; ?>">
	<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="va-card__link">
		<div class="va-card__image-wrap">
			<div class="va-card__image">
				<?php if ( $hero_image_id ) : ?>
					<?php echo wp_get_attachment_image( $hero_image_id, 'va-card-thumb', false, array( 'class' => 'va-card__img', 'loading' => 'lazy' ) ); ?>
				<?php else : ?>
					<div class="va-card__image--placeholder"></div>
				<?php endif; ?>
				<?php if ( $category_name ) : ?>
					<span class="va-card__cat-pill">
						<span class="va-card__cat-pill-emoji"><?php echo esc_html( $cat_emoji ); ?></span>
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
			<hr class="va-card__divider" />
			<div class="va-card__meta">
				<?php if ( $area_name ) : ?>
					<span class="va-card__meta-item">
						<svg class="va-card__meta-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="3"/></svg>
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
