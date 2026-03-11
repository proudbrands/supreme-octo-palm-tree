<?php
/**
 * Card: Area
 *
 * Overlay card — title sits on top of the image with a gradient.
 * No separate body section. Receives post ID via $args['post_id'].
 *
 * @package VisitAylesbury
 */

defined( 'ABSPATH' ) || exit;

$post_id = $args['post_id'] ?? get_the_ID();

// ACF fields.
$area_name  = get_field( 'area_name', $post_id );
$area_type  = get_field( 'area_type', $post_id );
$population = get_field( 'population', $post_id );
$hero_image = get_field( 'hero_image', $post_id );

$hero_image_id = $hero_image ? $hero_image['id'] : get_post_thumbnail_id( $post_id );
?>

<article class="va-card va-card--area">
	<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="va-card__link">
		<div class="va-card__image va-card__image--wide">
			<?php if ( $hero_image_id ) : ?>
				<?php echo wp_get_attachment_image( $hero_image_id, 'va-card-wide', false, array( 'class' => 'va-card__img', 'loading' => 'lazy' ) ); ?>
			<?php endif; ?>
			<?php if ( $area_type ) : ?>
				<span class="va-badge va-badge--category"><?php echo esc_html( $area_type ); ?></span>
			<?php endif; ?>
			<div class="va-card__overlay">
				<h3 class="va-card__title"><?php echo esc_html( $area_name ); ?></h3>
				<?php if ( $population ) : ?>
					<p class="va-card__population">Pop. <?php echo esc_html( $population ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</a>
</article>
