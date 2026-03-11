<?php
/**
 * Single content: Event
 *
 * Two-column layout: main content left, sticky sidebar with date/CTA right.
 *
 * @package VisitAylesbury
 */

defined( 'ABSPATH' ) || exit;

$post_id       = get_the_ID();
$event_name    = get_field( 'event_name', $post_id );
$description   = get_field( 'description', $post_id );
$start_date    = get_field( 'start_date', $post_id );
$end_date      = get_field( 'end_date', $post_id );
$start_time    = get_field( 'start_time', $post_id );
$end_time      = get_field( 'end_time', $post_id );
$venue_name    = get_field( 'venue_name', $post_id );
$venue_listing = get_field( 'venue_listing', $post_id );
$address       = get_field( 'address', $post_id );
$postcode      = get_field( 'postcode', $post_id );
$latitude      = get_field( 'latitude', $post_id );
$longitude     = get_field( 'longitude', $post_id );
$price         = get_field( 'price', $post_id );
$is_free       = get_field( 'is_free', $post_id );
$ticket_url    = get_field( 'ticket_url', $post_id );
$hero_image    = get_field( 'hero_image', $post_id );
$organiser     = get_field( 'organiser_name', $post_id );
$is_family     = get_field( 'is_family_friendly', $post_id );

$hero_id = $hero_image ? $hero_image['id'] : get_post_thumbnail_id( $post_id );

// Date formatting.
$date_display = '';
$day_num      = '';
$month_abbr   = '';
if ( $start_date ) {
	$date_display = date( 'l j F Y', strtotime( $start_date ) );
	$day_num      = date( 'j', strtotime( $start_date ) );
	$month_abbr   = date( 'M', strtotime( $start_date ) );
	if ( $end_date && $end_date !== $start_date ) {
		$date_display .= ' – ' . date( 'l j F Y', strtotime( $end_date ) );
	}
}

// Time formatting.
$time_display = '';
if ( $start_time ) {
	$time_display = date( 'g:ia', strtotime( $start_time ) );
	if ( $end_time ) {
		$time_display .= ' – ' . date( 'g:ia', strtotime( $end_time ) );
	}
}
?>

<article class="va-single-event">

	<?php if ( $hero_id ) : ?>
		<div class="va-single-event__hero">
			<?php echo wp_get_attachment_image( $hero_id, 'va-hero', false, array( 'class' => 'va-single-event__hero-img' ) ); ?>
		</div>
	<?php endif; ?>

	<div class="va-container va-section">
		<div class="va-layout-sidebar">

			<!-- Main content -->
			<div class="va-layout-sidebar__main">

				<header class="va-single-event__header">
					<h1 class="va-single-event__title"><?php echo esc_html( $event_name ); ?></h1>
					<?php if ( $is_free ) : ?>
						<span class="va-badge va-badge--free">Free</span>
					<?php endif; ?>
					<?php if ( $is_family ) : ?>
						<span class="va-badge va-badge--family">Family Friendly</span>
					<?php endif; ?>
				</header>

				<div class="va-single-event__meta">
					<?php if ( $date_display ) : ?>
						<p class="va-single-event__date"><?php echo esc_html( $date_display ); ?></p>
					<?php endif; ?>
					<?php if ( $time_display ) : ?>
						<p class="va-single-event__time"><?php echo esc_html( $time_display ); ?></p>
					<?php endif; ?>
					<?php if ( $venue_name ) : ?>
						<p class="va-single-event__venue">
							<?php if ( $venue_listing ) : ?>
								<a href="<?php echo esc_url( get_permalink( $venue_listing->ID ) ); ?>"><?php echo esc_html( $venue_name ); ?></a>
							<?php else : ?>
								<?php echo esc_html( $venue_name ); ?>
							<?php endif; ?>
						</p>
					<?php endif; ?>
				</div>

				<?php if ( $description ) : ?>
					<div class="va-single-event__description">
						<?php echo wp_kses_post( $description ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $organiser ) : ?>
					<div class="va-single-event__details">
						<p class="va-single-event__organiser">
							<strong><?php esc_html_e( 'Organised by:', 'visitaylesbury' ); ?></strong>
							<?php echo esc_html( $organiser ); ?>
						</p>
					</div>
				<?php endif; ?>

				<?php if ( $address || $postcode ) : ?>
					<div class="va-single-event__location">
						<h2><?php esc_html_e( 'Location', 'visitaylesbury' ); ?></h2>
						<p class="va-single-event__address">
							<?php if ( $address ) : ?>
								<?php echo esc_html( $address ); ?>
							<?php endif; ?>
							<?php if ( $address && $postcode ) : ?>,<?php endif; ?>
							<?php if ( $postcode ) : ?>
								<?php echo esc_html( $postcode ); ?>
							<?php endif; ?>
						</p>

						<?php if ( $latitude && $longitude ) : ?>
							<div class="va-map" data-lat="<?php echo esc_attr( $latitude ); ?>" data-lng="<?php echo esc_attr( $longitude ); ?>"></div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

			</div>

			<!-- Sidebar -->
			<div class="va-layout-sidebar__aside">
				<div class="va-sidebar-card">

					<?php if ( $day_num && $month_abbr ) : ?>
						<div class="va-sidebar-card__date">
							<span class="va-sidebar-card__date-day"><?php echo esc_html( $day_num ); ?></span>
							<span class="va-sidebar-card__date-month"><?php echo esc_html( $month_abbr ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( $time_display ) : ?>
						<div class="va-sidebar-card__row">
							<span><?php echo esc_html( $time_display ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( $venue_name ) : ?>
						<div class="va-sidebar-card__row">
							<?php if ( $venue_listing ) : ?>
								<a href="<?php echo esc_url( get_permalink( $venue_listing->ID ) ); ?>"><?php echo esc_html( $venue_name ); ?></a>
							<?php else : ?>
								<span><?php echo esc_html( $venue_name ); ?></span>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ( $price || $is_free ) : ?>
						<div class="va-sidebar-card__row">
							<span>
								<?php if ( $is_free ) : ?>
									<?php esc_html_e( 'Free', 'visitaylesbury' ); ?>
								<?php else : ?>
									<?php echo esc_html( $price ); ?>
								<?php endif; ?>
							</span>
						</div>
					<?php endif; ?>

					<?php if ( $ticket_url ) : ?>
						<a href="<?php echo esc_url( $ticket_url ); ?>" class="va-btn" target="_blank" rel="noopener noreferrer">
							<?php esc_html_e( 'Book Tickets', 'visitaylesbury' ); ?>
						</a>
					<?php endif; ?>

				</div>
			</div>

		</div>
	</div>

</article>
