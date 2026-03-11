<?php
/**
 * Single content: Area
 *
 * @package VisitAylesbury
 */

defined( 'ABSPATH' ) || exit;

$post_id         = get_the_ID();
$area_name       = get_field( 'area_name', $post_id );
$area_type       = get_field( 'area_type', $post_id );
$introduction    = get_field( 'introduction', $post_id );
$history         = get_field( 'history', $post_id );
$getting_there   = get_field( 'getting_there', $post_id );
$hero_image      = get_field( 'hero_image', $post_id );
$gallery         = get_field( 'gallery', $post_id );
$latitude        = get_field( 'latitude', $post_id );
$longitude       = get_field( 'longitude', $post_id );
$key_attractions = get_field( 'key_attractions', $post_id );
$fun_fact        = get_field( 'fun_fact', $post_id );
$population      = get_field( 'population', $post_id );
$local_walks     = get_field( 'local_walks', $post_id );
$nearest_pub     = get_field( 'nearest_pub', $post_id );
$nearest_cafe    = get_field( 'nearest_cafe', $post_id );

$hero_id = $hero_image ? $hero_image['id'] : get_post_thumbnail_id( $post_id );

// Determine the taxonomy term for dynamic queries.
// Areas map to area_tax (town neighbourhoods) or vale_village (vale villages).
$area_tax_terms    = wp_get_post_terms( $post_id, 'area_tax', array( 'fields' => 'slugs' ) );
$vale_village_terms = wp_get_post_terms( $post_id, 'vale_village', array( 'fields' => 'slugs' ) );

// Build a tax_query to find listings in this area.
$listing_tax_query = array();
if ( ! is_wp_error( $area_tax_terms ) && ! empty( $area_tax_terms ) ) {
	$listing_tax_query[] = array(
		'taxonomy' => 'area_tax',
		'field'    => 'slug',
		'terms'    => $area_tax_terms,
	);
}
if ( ! is_wp_error( $vale_village_terms ) && ! empty( $vale_village_terms ) ) {
	$listing_tax_query[] = array(
		'taxonomy' => 'vale_village',
		'field'    => 'slug',
		'terms'    => $vale_village_terms,
	);
}
if ( count( $listing_tax_query ) > 1 ) {
	$listing_tax_query['relation'] = 'OR';
}
?>

<article class="va-single-area">

	<?php if ( $hero_id ) : ?>
		<div class="va-single-area__hero">
			<?php echo wp_get_attachment_image( $hero_id, 'va-hero', false, array( 'class' => 'va-single-area__hero-img' ) ); ?>
		</div>
	<?php endif; ?>

	<div class="va-container va-section">

		<header class="va-single-area__header">
			<h1 class="va-single-area__title"><?php echo esc_html( $area_name ); ?></h1>
			<?php if ( $area_type ) : ?>
				<span class="va-badge va-badge--category va-single-area__type"><?php echo esc_html( $area_type ); ?></span>
			<?php endif; ?>
		</header>

		<?php if ( $population || $fun_fact ) : ?>
			<div class="va-single-area__quick-facts">
				<?php if ( $population ) : ?>
					<span class="va-single-area__fact">Pop. <?php echo esc_html( $population ); ?></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $introduction ) : ?>
			<div class="va-single-area__intro">
				<?php echo wp_kses_post( $introduction ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $latitude && $longitude ) : ?>
			<div class="va-single-area__map">
				<div class="va-map" data-lat="<?php echo esc_attr( $latitude ); ?>" data-lng="<?php echo esc_attr( $longitude ); ?>"></div>
			</div>
		<?php endif; ?>

		<?php if ( $key_attractions && is_array( $key_attractions ) ) : ?>
			<div class="va-single-area__attractions">
				<h2><?php esc_html_e( 'Key Attractions', 'visitaylesbury' ); ?></h2>
				<?php foreach ( $key_attractions as $attraction ) : ?>
					<div class="va-single-area__attraction">
						<?php if ( ! empty( $attraction['name'] ) ) : ?>
							<h3><?php echo esc_html( $attraction['name'] ); ?></h3>
						<?php endif; ?>
						<?php if ( ! empty( $attraction['description'] ) ) : ?>
							<p><?php echo esc_html( $attraction['description'] ); ?></p>
						<?php endif; ?>
						<?php if ( ! empty( $attraction['link'] ) ) : ?>
							<a href="<?php echo esc_url( $attraction['link'] ); ?>"><?php esc_html_e( 'Find out more', 'visitaylesbury' ); ?></a>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( $history ) : ?>
			<div class="va-single-area__history">
				<h2><?php esc_html_e( 'History', 'visitaylesbury' ); ?></h2>
				<?php echo wp_kses_post( $history ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $fun_fact ) : ?>
			<div class="va-single-area__fun-fact">
				<p><?php echo esc_html( $fun_fact ); ?></p>
			</div>
		<?php endif; ?>

		<?php if ( $nearest_pub || $nearest_cafe ) : ?>
			<div class="va-single-area__refreshments">
				<h2><?php esc_html_e( 'Eat & Drink', 'visitaylesbury' ); ?></h2>
				<ul>
					<?php if ( $nearest_pub ) : ?>
						<li>
							<a href="<?php echo esc_url( get_permalink( $nearest_pub->ID ) ); ?>">
								<?php echo esc_html( get_the_title( $nearest_pub->ID ) ); ?>
							</a>
						</li>
					<?php endif; ?>
					<?php if ( $nearest_cafe ) : ?>
						<li>
							<a href="<?php echo esc_url( get_permalink( $nearest_cafe->ID ) ); ?>">
								<?php echo esc_html( get_the_title( $nearest_cafe->ID ) ); ?>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		<?php endif; ?>

		<?php if ( $getting_there ) : ?>
			<div class="va-single-area__getting-there">
				<h2><?php esc_html_e( 'Getting There', 'visitaylesbury' ); ?></h2>
				<?php echo wp_kses_post( $getting_there ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $local_walks && is_array( $local_walks ) ) : ?>
			<div class="va-single-area__walks">
				<h2><?php esc_html_e( 'Local Walks', 'visitaylesbury' ); ?></h2>
				<div class="va-grid va-grid--3">
					<?php foreach ( $local_walks as $walk ) : ?>
						<?php get_template_part( 'template-parts/cards/card-walk', null, array( 'post_id' => $walk->ID ) ); ?>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $gallery && is_array( $gallery ) ) : ?>
			<div class="va-single-area__gallery">
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

		<?php
		// Dynamic listings in this area (queried by shared taxonomy).
		if ( ! empty( $listing_tax_query ) ) :
			$area_listings = new WP_Query( array(
				'post_type'      => 'listing',
				'posts_per_page' => 6,
				'post_status'    => 'publish',
				'orderby'        => 'title',
				'order'          => 'ASC',
				'tax_query'      => $listing_tax_query,
			) );

			if ( $area_listings->have_posts() ) :
				?>
				<div class="va-single-area__listings">
					<h2><?php esc_html_e( 'Places in This Area', 'visitaylesbury' ); ?></h2>
					<div class="va-grid va-grid--3">
						<?php while ( $area_listings->have_posts() ) : $area_listings->the_post(); ?>
							<?php get_template_part( 'template-parts/cards/card-listing', null, array( 'post_id' => get_the_ID() ) ); ?>
						<?php endwhile; ?>
					</div>
				</div>
				<?php
				wp_reset_postdata();
			endif;
		endif;
		?>

	</div>

</article>
