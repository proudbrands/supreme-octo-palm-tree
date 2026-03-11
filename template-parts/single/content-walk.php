<?php
/**
 * Single content: Walk
 *
 * @package VisitAylesbury
 */

defined( 'ABSPATH' ) || exit;

$post_id            = get_the_ID();
$walk_name          = get_field( 'walk_name', $post_id );
$description        = get_field( 'description', $post_id );
$difficulty         = get_field( 'difficulty', $post_id );
$distance_miles     = get_field( 'distance_miles', $post_id );
$estimated_time     = get_field( 'estimated_time', $post_id );
$start_point        = get_field( 'start_point', $post_id );
$start_postcode     = get_field( 'start_postcode', $post_id );
$start_lat          = get_field( 'start_lat', $post_id );
$start_lng          = get_field( 'start_lng', $post_id );
$gpx_file           = get_field( 'gpx_file', $post_id );
$terrain            = get_field( 'terrain', $post_id );
$dog_friendly       = get_field( 'dog_friendly', $post_id );
$pushchair_friendly = get_field( 'pushchair_friendly', $post_id );
$pub_on_route       = get_field( 'pub_on_route', $post_id );
$cafe_on_route      = get_field( 'cafe_on_route', $post_id );
$parking            = get_field( 'parking', $post_id );
$highlights         = get_field( 'highlights', $post_id );
$seasonal_notes     = get_field( 'seasonal_notes', $post_id );
$gallery            = get_field( 'gallery', $post_id );
$nearby_listings    = get_field( 'nearby_listings', $post_id );
$hero_image         = get_field( 'hero_image', $post_id );

$hero_id = $hero_image ? $hero_image['id'] : get_post_thumbnail_id( $post_id );

$terrain_labels = array(
	'paved'  => 'Paved',
	'gravel' => 'Gravel',
	'grass'  => 'Grass',
	'muddy'  => 'Muddy',
	'stiles' => 'Stiles',
	'steps'  => 'Steps',
	'steep'  => 'Steep',
);
?>

<article class="va-single-walk">

	<?php if ( $hero_id ) : ?>
		<div class="va-single-walk__hero">
			<?php echo wp_get_attachment_image( $hero_id, 'va-hero', false, array( 'class' => 'va-single-walk__hero-img' ) ); ?>
		</div>
	<?php endif; ?>

	<div class="va-container va-section">

		<h1 class="va-single-walk__title"><?php echo esc_html( $walk_name ); ?></h1>

		<div class="va-walk-stats">
			<?php if ( $distance_miles ) : ?>
				<span class="va-walk-stats__item"><?php echo esc_html( $distance_miles ); ?> miles</span>
			<?php endif; ?>
			<?php if ( $difficulty ) : ?>
				<span class="va-badge va-badge--<?php echo esc_attr( strtolower( $difficulty ) ); ?>"><?php echo esc_html( $difficulty ); ?></span>
			<?php endif; ?>
			<?php if ( $estimated_time ) : ?>
				<span class="va-walk-stats__item"><?php echo esc_html( $estimated_time ); ?></span>
			<?php endif; ?>
			<?php if ( $dog_friendly ) : ?>
				<span class="va-walk-stats__item">Dog friendly</span>
			<?php endif; ?>
			<?php if ( $pushchair_friendly ) : ?>
				<span class="va-walk-stats__item">Pushchair friendly</span>
			<?php endif; ?>
		</div>

		<?php if ( $description ) : ?>
			<div class="va-single-walk__description">
				<?php echo wp_kses_post( $description ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $start_lat && $start_lng ) : ?>
			<div class="va-single-walk__map">
				<h2><?php esc_html_e( 'Route Map', 'visitaylesbury' ); ?></h2>
				<div
					id="va-walk-map"
					class="va-map va-map--tall"
					data-lat="<?php echo esc_attr( $start_lat ); ?>"
					data-lng="<?php echo esc_attr( $start_lng ); ?>"
					<?php if ( $gpx_file && ! empty( $gpx_file['url'] ) ) : ?>
						data-gpx="<?php echo esc_url( $gpx_file['url'] ); ?>"
						data-elevation="true"
					<?php endif; ?>
				></div>
				<?php if ( $gpx_file && ! empty( $gpx_file['url'] ) ) : ?>
					<div id="va-elevation-va-walk-map" class="va-elevation-profile"></div>
				<?php endif; ?>
				<?php if ( $start_point || $start_postcode ) : ?>
					<p class="va-single-walk__start">
						<strong><?php esc_html_e( 'Start:', 'visitaylesbury' ); ?></strong>
						<?php if ( $start_point ) : ?>
							<?php echo esc_html( $start_point ); ?>
						<?php endif; ?>
						<?php if ( $start_point && $start_postcode ) : ?>,<?php endif; ?>
						<?php if ( $start_postcode ) : ?>
							<?php echo esc_html( $start_postcode ); ?>
						<?php endif; ?>
					</p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $terrain && is_array( $terrain ) ) : ?>
			<div class="va-single-walk__terrain">
				<h2><?php esc_html_e( 'Terrain', 'visitaylesbury' ); ?></h2>
				<div class="va-single-walk__terrain-list">
					<?php foreach ( $terrain as $type ) : ?>
						<?php if ( isset( $terrain_labels[ $type ] ) ) : ?>
							<span class="va-badge va-badge--category"><?php echo esc_html( $terrain_labels[ $type ] ); ?></span>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $pub_on_route || $cafe_on_route ) : ?>
			<div class="va-single-walk__on-route">
				<h2><?php esc_html_e( 'On the Route', 'visitaylesbury' ); ?></h2>
				<ul>
					<?php if ( $pub_on_route ) : ?>
						<li>
							<a href="<?php echo esc_url( get_permalink( $pub_on_route->ID ) ); ?>">
								<?php echo esc_html( get_the_title( $pub_on_route->ID ) ); ?>
							</a>
						</li>
					<?php endif; ?>
					<?php if ( $cafe_on_route ) : ?>
						<li>
							<a href="<?php echo esc_url( get_permalink( $cafe_on_route->ID ) ); ?>">
								<?php echo esc_html( get_the_title( $cafe_on_route->ID ) ); ?>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		<?php endif; ?>

		<?php if ( $parking ) : ?>
			<div class="va-single-walk__parking">
				<h2><?php esc_html_e( 'Parking', 'visitaylesbury' ); ?></h2>
				<p><?php echo esc_html( $parking ); ?></p>
			</div>
		<?php endif; ?>

		<?php if ( $seasonal_notes ) : ?>
			<div class="va-single-walk__seasonal">
				<h2><?php esc_html_e( 'Seasonal Notes', 'visitaylesbury' ); ?></h2>
				<p><?php echo esc_html( $seasonal_notes ); ?></p>
			</div>
		<?php endif; ?>

		<?php if ( $highlights && is_array( $highlights ) ) : ?>
			<div class="va-single-walk__highlights">
				<h2><?php esc_html_e( 'Highlights', 'visitaylesbury' ); ?></h2>
				<?php foreach ( $highlights as $highlight ) : ?>
					<div class="va-single-walk__highlight">
						<?php if ( ! empty( $highlight['name'] ) ) : ?>
							<h3><?php echo esc_html( $highlight['name'] ); ?></h3>
						<?php endif; ?>
						<?php if ( ! empty( $highlight['description'] ) ) : ?>
							<p><?php echo esc_html( $highlight['description'] ); ?></p>
						<?php endif; ?>
						<?php if ( ! empty( $highlight['image'] ) && ! empty( $highlight['image']['id'] ) ) : ?>
							<?php echo wp_get_attachment_image( $highlight['image']['id'], 'va-gallery', false, array( 'loading' => 'lazy' ) ); ?>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( $gallery && is_array( $gallery ) ) : ?>
			<div class="va-single-walk__gallery">
				<h2><?php esc_html_e( 'Gallery', 'visitaylesbury' ); ?></h2>
				<div class="va-grid va-grid--3">
					<?php foreach ( $gallery as $image ) : ?>
						<?php if ( ! empty( $image['id'] ) ) : ?>
							<?php echo wp_get_attachment_image( $image['id'], 'va-gallery', false, array( 'loading' => 'lazy' ) ); ?>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $nearby_listings && is_array( $nearby_listings ) ) : ?>
			<div class="va-single-walk__nearby">
				<h2><?php esc_html_e( 'Nearby', 'visitaylesbury' ); ?></h2>
				<div class="va-grid va-grid--3">
					<?php foreach ( $nearby_listings as $listing ) : ?>
						<?php get_template_part( 'template-parts/cards/card-listing', null, array( 'post_id' => $listing->ID ) ); ?>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

	</div>

</article>
