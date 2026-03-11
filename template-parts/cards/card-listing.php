<?php
/**
 * Card: Listing
 *
 * Approved component from docs/components.md.
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
$cats          = get_the_terms( $post_id, 'business_category' );
if ( $cats && ! is_wp_error( $cats ) ) {
	$category_name = $cats[0]->name;
}

// Area name.
$area_name = '';
$areas     = get_the_terms( $post_id, 'area_tax' );
if ( $areas && ! is_wp_error( $areas ) ) {
	$area_name = $areas[0]->name;
}
?>

<article class="va-card va-card--listing">
	<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="va-card__link">
		<div class="va-card__image">
			<?php if ( $hero_image_id ) : ?>
				<?php echo wp_get_attachment_image( $hero_image_id, 'va-card-thumb', false, array( 'class' => 'va-card__img', 'loading' => 'lazy' ) ); ?>
			<?php endif; ?>
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
