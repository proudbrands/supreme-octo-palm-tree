<?php
/**
 * Single content: Listing
 *
 * Two-column layout: main content left (62%), sticky sidebar right (38%).
 *
 * @package VisitAylesbury
 */

defined( 'ABSPATH' ) || exit;

$post_id       = get_the_ID();
$business_name = get_field( 'business_name', $post_id );
$tagline       = get_field( 'tagline', $post_id );
$description   = get_field( 'description', $post_id );
$hero_image    = get_field( 'hero_image', $post_id );
$address       = get_field( 'address', $post_id );
$postcode      = get_field( 'postcode', $post_id );
$phone         = get_field( 'phone', $post_id );
$email         = get_field( 'email', $post_id );
$website       = get_field( 'website', $post_id );
$social_links  = get_field( 'social_links', $post_id );
$opening_hours = get_field( 'opening_hours', $post_id );
$features      = get_field( 'features', $post_id );
$latitude      = get_field( 'latitude', $post_id );
$longitude     = get_field( 'longitude', $post_id );

$hero_id = $hero_image ? $hero_image['id'] : get_post_thumbnail_id( $post_id );

// Category label.
$category_name = '';
$cat_color     = 'var(--wp--preset--color--teal)';
$cats          = get_the_terms( $post_id, 'business_category' );
if ( $cats && ! is_wp_error( $cats ) ) {
	$category_name = $cats[0]->name;
}

$feature_icons = array(
	'dog_friendly'          => array( 'icon' => '🐾', 'label' => 'Dog Friendly' ),
	'wheelchair_accessible' => array( 'icon' => '♿', 'label' => 'Accessible' ),
	'wifi'                  => array( 'icon' => '📶', 'label' => 'Wi-Fi' ),
	'parking'               => array( 'icon' => '🅿️', 'label' => 'Parking' ),
	'outdoor_seating'       => array( 'icon' => '☀️', 'label' => 'Outdoor Seating' ),
	'child_friendly'        => array( 'icon' => '👶', 'label' => 'Child Friendly' ),
	'vegan_options'         => array( 'icon' => '🌱', 'label' => 'Vegan Options' ),
	'gluten_free'           => array( 'icon' => '🌾', 'label' => 'Gluten Free' ),
	'live_music'            => array( 'icon' => '🎵', 'label' => 'Live Music' ),
	'private_hire'          => array( 'icon' => '🏛️', 'label' => 'Private Hire' ),
);
?>

<article class="va-single-listing">

	<?php if ( $hero_id ) : ?>
		<div class="va-single-listing__hero">
			<?php echo wp_get_attachment_image( $hero_id, 'va-hero', false, array( 'class' => 'va-single-listing__hero-img' ) ); ?>
		</div>
	<?php endif; ?>

	<div class="va-container va-section">
		<div class="va-layout-sidebar">

			<!-- Main content -->
			<div class="va-layout-sidebar__main">

				<header class="va-single-listing__header">
					<?php if ( $category_name ) : ?>
						<span class="va-single-listing__cat">
							<span class="va-single-listing__cat-dot" style="background: <?php echo esc_attr( $cat_color ); ?>;"></span>
							<?php echo esc_html( $category_name ); ?>
						</span>
					<?php endif; ?>
					<h1 class="va-single-listing__title"><?php echo esc_html( $business_name ); ?></h1>
					<?php if ( $tagline ) : ?>
						<p class="va-single-listing__tagline"><?php echo esc_html( $tagline ); ?></p>
					<?php endif; ?>
				</header>

				<?php if ( $features && is_array( $features ) ) : ?>
					<div class="va-feature-pills">
						<?php foreach ( $features as $feature ) : ?>
							<?php if ( isset( $feature_icons[ $feature ] ) ) : ?>
								<span class="va-feature-pill">
									<span class="va-feature-pill__icon"><?php echo esc_html( $feature_icons[ $feature ]['icon'] ); ?></span>
									<?php echo esc_html( $feature_icons[ $feature ]['label'] ); ?>
								</span>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ( $description ) : ?>
					<div class="va-single-listing__description">
						<?php echo wp_kses_post( $description ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $social_links && is_array( $social_links ) ) : ?>
					<div class="va-single-listing__social">
						<h2><?php esc_html_e( 'Follow', 'visitaylesbury' ); ?></h2>
						<ul class="va-single-listing__social-list">
							<?php foreach ( $social_links as $link ) : ?>
								<?php if ( ! empty( $link['url'] ) ) : ?>
									<li>
										<a href="<?php echo esc_url( $link['url'] ); ?>" target="_blank" rel="noopener noreferrer">
											<?php echo esc_html( ucfirst( $link['platform'] ) ); ?>
										</a>
									</li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>

			</div>

			<!-- Sidebar -->
			<div class="va-layout-sidebar__aside">
				<div class="va-sidebar-card">

					<?php if ( $address || $postcode ) : ?>
						<div class="va-sidebar-card__row">
							<svg class="va-sidebar-card__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="3"/></svg>
							<span><?php echo esc_html( trim( ( $address ? $address : '' ) . ( $address && $postcode ? ', ' : '' ) . ( $postcode ? $postcode : '' ) ) ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( $phone ) : ?>
						<div class="va-sidebar-card__row">
							<svg class="va-sidebar-card__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
							<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
						</div>
					<?php endif; ?>

					<?php if ( $website ) : ?>
						<div class="va-sidebar-card__row">
							<svg class="va-sidebar-card__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>
							<a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( wp_parse_url( $website, PHP_URL_HOST ) ); ?></a>
						</div>
					<?php endif; ?>

					<?php if ( $email ) : ?>
						<div class="va-sidebar-card__row">
							<svg class="va-sidebar-card__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
							<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
						</div>
					<?php endif; ?>

					<?php if ( $opening_hours && is_array( $opening_hours ) ) : ?>
						<div class="va-sidebar-card__hours">
							<h4 class="va-sidebar-card__hours-title"><?php esc_html_e( 'Opening Hours', 'visitaylesbury' ); ?></h4>
							<table class="va-hours-table">
								<?php foreach ( $opening_hours as $row ) : ?>
									<tr>
										<td><?php echo esc_html( ucfirst( $row['day'] ) ); ?></td>
										<?php if ( ! empty( $row['closed'] ) ) : ?>
											<td><?php esc_html_e( 'Closed', 'visitaylesbury' ); ?></td>
										<?php else : ?>
											<td><?php echo esc_html( $row['open'] ); ?> &ndash; <?php echo esc_html( $row['close'] ); ?></td>
										<?php endif; ?>
									</tr>
								<?php endforeach; ?>
							</table>
						</div>
					<?php endif; ?>

					<?php if ( $latitude && $longitude ) : ?>
						<div class="va-map" data-lat="<?php echo esc_attr( $latitude ); ?>" data-lng="<?php echo esc_attr( $longitude ); ?>" data-title="<?php echo esc_attr( $business_name ); ?>" data-category="<?php echo esc_attr( $category_name ); ?>" style="margin-top: 1.25rem; border-radius: 12px;"></div>
					<?php endif; ?>

				</div>
			</div>

		</div>
	</div>

</article>
