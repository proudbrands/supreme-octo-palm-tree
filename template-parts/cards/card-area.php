<?php
/**
 * Card: Area
 *
 * Same outer shell as listing-card but larger image (16/9),
 * no meta row. Area name as title, short intro as tagline,
 * population as small meta.
 * Receives post ID via $args['post_id'].
 *
 * @package VisitAylesbury
 */

defined( 'ABSPATH' ) || exit;

$post_id = $args['post_id'] ?? get_the_ID();

// ACF fields.
$area_name  = get_field( 'area_name', $post_id );
$area_type  = get_field( 'area_type', $post_id );
$intro      = get_field( 'introduction', $post_id );
$population = get_field( 'population', $post_id );
$hero_image = get_field( 'hero_image', $post_id );

$hero_image_id = $hero_image ? $hero_image['id'] : get_post_thumbnail_id( $post_id );

// Strip HTML from intro and truncate for card tagline.
$intro_text = $intro ? wp_strip_all_tags( $intro ) : '';
$intro_text = $intro_text ? wp_trim_words( $intro_text, 18, '…' ) : '';
?>

<article class="va-card va-card--area">
	<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="va-card__link">
		<div class="va-card__image va-card__image--wide">
			<?php if ( $hero_image_id ) : ?>
				<?php echo wp_get_attachment_image( $hero_image_id, 'va-card-thumb', false, array( 'class' => 'va-card__img', 'loading' => 'lazy' ) ); ?>
			<?php endif; ?>
			<?php if ( $area_type ) : ?>
				<span class="va-badge va-badge--category"><?php echo esc_html( $area_type ); ?></span>
			<?php endif; ?>
		</div>
		<div class="va-card__body">
			<h3 class="va-card__title"><?php echo esc_html( $area_name ); ?></h3>
			<?php if ( $intro_text ) : ?>
				<p class="va-card__tagline"><?php echo esc_html( $intro_text ); ?></p>
			<?php endif; ?>
			<?php if ( $population ) : ?>
				<div class="va-card__meta">
					<span class="va-card__population">Pop. <?php echo esc_html( $population ); ?></span>
				</div>
			<?php endif; ?>
		</div>
	</a>
</article>
