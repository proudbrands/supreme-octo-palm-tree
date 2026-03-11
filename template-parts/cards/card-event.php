<?php
/**
 * Card: Event
 *
 * Approved component from docs/components.md.
 * Receives post ID via $args['post_id'].
 *
 * @package VisitAylesbury
 */

defined( 'ABSPATH' ) || exit;

$post_id = $args['post_id'] ?? get_the_ID();

// ACF fields.
$event_name = get_field( 'event_name', $post_id );
$start_date = get_field( 'start_date', $post_id );
$start_time = get_field( 'start_time', $post_id );
$end_time   = get_field( 'end_time', $post_id );
$venue_name = get_field( 'venue_name', $post_id );
$is_free    = get_field( 'is_free', $post_id );
$hero_image = get_field( 'hero_image', $post_id );

$hero_image_id = $hero_image ? $hero_image['id'] : get_post_thumbnail_id( $post_id );

// Date display.
$day   = '';
$month = '';
if ( $start_date ) {
	$day   = date( 'j', strtotime( $start_date ) );
	$month = date( 'M', strtotime( $start_date ) );
}

// Time display.
$time_display = '';
if ( $start_time ) {
	$time_display = date( 'g:ia', strtotime( $start_time ) );
	if ( $end_time ) {
		$time_display .= ' – ' . date( 'g:ia', strtotime( $end_time ) );
	}
}
?>

<article class="va-card va-card--event">
	<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="va-card__link">
		<div class="va-card__image">
			<?php if ( $hero_image_id ) : ?>
				<?php echo wp_get_attachment_image( $hero_image_id, 'va-card-thumb', false, array( 'class' => 'va-card__img', 'loading' => 'lazy' ) ); ?>
			<?php endif; ?>
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
