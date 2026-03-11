<?php
/**
 * Card: Guide
 *
 * Receives post ID via $args['post_id'].
 *
 * @package VisitAylesbury
 */

defined( 'ABSPATH' ) || exit;

$post_id = $args['post_id'] ?? get_the_ID();

// ACF fields.
$hero_image    = get_field( 'hero_image', $post_id );
$last_verified = get_field( 'last_verified', $post_id );
$seasonal_flag = get_field( 'seasonal_flag', $post_id );

$hero_image_id = $hero_image ? $hero_image['id'] : get_post_thumbnail_id( $post_id );

// Guide type taxonomy.
$guide_type_name = '';
$types           = get_the_terms( $post_id, 'guide_type' );
if ( $types && ! is_wp_error( $types ) ) {
	$guide_type_name = $types[0]->name;
}

// Updated date display.
$updated_display = '';
if ( $last_verified ) {
	$updated_display = date( 'F Y', strtotime( $last_verified ) );
}
?>

<article class="va-card va-card--guide">
	<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="va-card__link">
		<div class="va-card__image<?php echo ! $hero_image_id ? ' va-card__image--placeholder' : ''; ?>">
			<?php if ( $hero_image_id ) : ?>
				<?php echo wp_get_attachment_image( $hero_image_id, 'va-card-thumb', false, array( 'class' => 'va-card__img', 'loading' => 'lazy' ) ); ?>
			<?php endif; ?>
			<?php if ( $guide_type_name ) : ?>
				<span class="va-badge va-badge--category"><?php echo esc_html( $guide_type_name ); ?></span>
			<?php endif; ?>
			<?php if ( $seasonal_flag && 'none' !== $seasonal_flag ) : ?>
				<span class="va-badge va-badge--featured"><?php echo esc_html( ucfirst( $seasonal_flag ) ); ?></span>
			<?php endif; ?>
		</div>
		<div class="va-card__body">
			<h3 class="va-card__title"><?php echo esc_html( get_the_title( $post_id ) ); ?></h3>
			<?php if ( has_excerpt( $post_id ) ) : ?>
				<p class="va-card__tagline"><?php echo esc_html( get_the_excerpt( $post_id ) ); ?></p>
			<?php endif; ?>
			<?php if ( $updated_display ) : ?>
				<span class="va-card__updated"><?php echo esc_html( 'Updated ' . $updated_display ); ?></span>
			<?php endif; ?>
		</div>
	</a>
</article>
