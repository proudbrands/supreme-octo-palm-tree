<?php
/**
 * Single content: Listing
 *
 * Two-column layout: main content left, sticky sidebar right.
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

					<h3><?php esc_html_e( 'Practical Info', 'visitaylesbury' ); ?></h3>

					<?php if ( $address || $postcode ) : ?>
						<div class="va-sidebar-card__row">
							<span><?php echo esc_html( trim( ( $address ? $address : '' ) . ( $address && $postcode ? ', ' : '' ) . ( $postcode ? $postcode : '' ) ) ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( $phone ) : ?>
						<div class="va-sidebar-card__row">
							<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
						</div>
					<?php endif; ?>

					<?php if ( $email ) : ?>
						<div class="va-sidebar-card__row">
							<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
						</div>
					<?php endif; ?>

					<?php if ( $website ) : ?>
						<div class="va-sidebar-card__row">
							<a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( wp_parse_url( $website, PHP_URL_HOST ) ); ?></a>
						</div>
					<?php endif; ?>

					<?php if ( $opening_hours && is_array( $opening_hours ) ) : ?>
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
					<?php endif; ?>

					<?php if ( $latitude && $longitude ) : ?>
						<div class="va-map" data-lat="<?php echo esc_attr( $latitude ); ?>" data-lng="<?php echo esc_attr( $longitude ); ?>" style="margin-top: 1rem;"></div>
					<?php endif; ?>

				</div>
			</div>

		</div>
	</div>

</article>
