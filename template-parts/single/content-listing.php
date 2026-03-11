<?php
/**
 * Single content: Listing
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

$feature_labels = array(
	'dog_friendly'          => 'Dog Friendly',
	'wheelchair_accessible' => 'Wheelchair Accessible',
	'wifi'                  => 'Wi-Fi',
	'parking'               => 'Parking',
	'outdoor_seating'       => 'Outdoor Seating',
	'child_friendly'        => 'Child Friendly',
	'vegan_options'         => 'Vegan Options',
	'gluten_free'           => 'Gluten Free',
	'live_music'            => 'Live Music',
	'private_hire'          => 'Private Hire',
);
?>

<article class="va-single-listing">

	<?php if ( $hero_id ) : ?>
		<div class="va-single-listing__hero">
			<?php echo wp_get_attachment_image( $hero_id, 'va-hero', false, array( 'class' => 'va-single-listing__hero-img' ) ); ?>
		</div>
	<?php endif; ?>

	<div class="va-container va-section">

		<header class="va-single-listing__header">
			<h1 class="va-single-listing__title"><?php echo esc_html( $business_name ); ?></h1>
			<?php if ( $tagline ) : ?>
				<p class="va-single-listing__tagline"><?php echo esc_html( $tagline ); ?></p>
			<?php endif; ?>
		</header>

		<?php if ( $description ) : ?>
			<div class="va-single-listing__description">
				<?php echo wp_kses_post( $description ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $features && is_array( $features ) ) : ?>
			<div class="va-single-listing__features">
				<h2><?php esc_html_e( 'Features', 'visitaylesbury' ); ?></h2>
				<div class="va-single-listing__features-list">
					<?php foreach ( $features as $feature ) : ?>
						<?php if ( isset( $feature_labels[ $feature ] ) ) : ?>
							<span class="va-badge va-badge--category"><?php echo esc_html( $feature_labels[ $feature ] ); ?></span>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $opening_hours && is_array( $opening_hours ) ) : ?>
			<div class="va-single-listing__hours">
				<h2><?php esc_html_e( 'Opening Hours', 'visitaylesbury' ); ?></h2>
				<table class="va-single-listing__hours-table">
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

		<div class="va-single-listing__contact">
			<h2><?php esc_html_e( 'Contact', 'visitaylesbury' ); ?></h2>

			<?php if ( $address || $postcode ) : ?>
				<p class="va-single-listing__address">
					<?php if ( $address ) : ?>
						<?php echo esc_html( $address ); ?>
					<?php endif; ?>
					<?php if ( $address && $postcode ) : ?>,<?php endif; ?>
					<?php if ( $postcode ) : ?>
						<?php echo esc_html( $postcode ); ?>
					<?php endif; ?>
				</p>
			<?php endif; ?>

			<?php if ( $phone ) : ?>
				<p class="va-single-listing__phone">
					<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
				</p>
			<?php endif; ?>

			<?php if ( $email ) : ?>
				<p class="va-single-listing__email">
					<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
				</p>
			<?php endif; ?>

			<?php if ( $website ) : ?>
				<p class="va-single-listing__website">
					<a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( wp_parse_url( $website, PHP_URL_HOST ) ); ?></a>
				</p>
			<?php endif; ?>
		</div>

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

		<?php if ( $latitude && $longitude ) : ?>
			<div class="va-single-listing__map">
				<h2><?php esc_html_e( 'Location', 'visitaylesbury' ); ?></h2>
				<div class="va-map" data-lat="<?php echo esc_attr( $latitude ); ?>" data-lng="<?php echo esc_attr( $longitude ); ?>"></div>
			</div>
		<?php endif; ?>

	</div>

</article>
