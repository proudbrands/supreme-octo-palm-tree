<?php
/**
 * Card: Walk
 *
 * Vertical card with inset image, difficulty badge, stat pills.
 * Receives post ID via $args['post_id'].
 *
 * @package VisitAylesbury
 */

defined( 'ABSPATH' ) || exit;

$post_id = $args['post_id'] ?? get_the_ID();

// ACF fields.
$walk_name      = get_field( 'walk_name', $post_id );
$distance_miles = get_field( 'distance_miles', $post_id );
$difficulty     = get_field( 'difficulty', $post_id );
$estimated_time = get_field( 'estimated_time', $post_id );
$dog_friendly   = get_field( 'dog_friendly', $post_id );
$hero_image     = get_field( 'hero_image', $post_id );
$pushchair      = get_field( 'pushchair_friendly', $post_id );

$hero_image_id = $hero_image ? $hero_image['id'] : get_post_thumbnail_id( $post_id );
?>

<article class="va-card va-card--walk">
	<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="va-card__link">
		<div class="va-card__image-wrap">
			<div class="va-card__image">
				<?php if ( $hero_image_id ) : ?>
					<?php echo wp_get_attachment_image( $hero_image_id, 'va-card-thumb', false, array( 'class' => 'va-card__img', 'loading' => 'lazy' ) ); ?>
				<?php else : ?>
					<div class="va-card__image--placeholder"></div>
				<?php endif; ?>
				<?php if ( $difficulty ) : ?>
					<span class="va-badge va-badge--<?php echo esc_attr( strtolower( $difficulty ) ); ?>"><?php echo esc_html( $difficulty ); ?></span>
				<?php endif; ?>
			</div>
		</div>
		<div class="va-card__body">
			<h3 class="va-card__title"><?php echo esc_html( $walk_name ); ?></h3>
			<div class="va-card__stats">
				<?php if ( $distance_miles ) : ?>
					<span class="va-card__stat"><?php echo esc_html( $distance_miles ); ?> miles</span>
				<?php endif; ?>
				<?php if ( $estimated_time ) : ?>
					<span class="va-card__stat"><?php echo esc_html( $estimated_time ); ?></span>
				<?php endif; ?>
				<?php if ( $dog_friendly ) : ?>
					<span class="va-card__stat va-card__stat--dog">Dog friendly</span>
				<?php endif; ?>
				<?php if ( $pushchair ) : ?>
					<span class="va-card__stat">Pushchair friendly</span>
				<?php endif; ?>
			</div>
		</div>
	</a>
</article>
