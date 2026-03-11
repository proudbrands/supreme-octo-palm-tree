<?php
/**
 * Archive: Listing (Business Directory)
 *
 * @package VisitAylesbury
 */

get_header();
?>

<main class="va-main">

	<div class="va-container">
		<div class="va-archive-header">
			<h1><?php esc_html_e( 'Business Directory', 'visitaylesbury' ); ?></h1>
		</div>
	</div>

	<div class="va-filter-bar">
		<div class="va-filter-bar__inner">
			<div class="va-pill-row">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'listing' ) ); ?>" class="va-pill is-active"><?php esc_html_e( 'All', 'visitaylesbury' ); ?></a>
				<?php
				$top_cats = get_terms( array(
					'taxonomy'   => 'business_category',
					'parent'     => 0,
					'hide_empty' => true,
					'number'     => 8,
				) );
				if ( ! is_wp_error( $top_cats ) && ! empty( $top_cats ) ) :
					foreach ( $top_cats as $cat ) :
				?>
					<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="va-pill"><?php echo esc_html( $cat->name ); ?></a>
				<?php
					endforeach;
				endif;
				?>
			</div>
		</div>
	</div>

	<div class="va-section">
		<div class="va-container">

			<?php
			$listings = new WP_Query( array(
				'post_type'      => 'listing',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'orderby'        => 'title',
				'order'          => 'ASC',
			) );
			?>

			<?php if ( $listings->have_posts() ) : ?>

				<?php
				// Build markers JSON for the directory map.
				$markers = array();
				while ( $listings->have_posts() ) :
					$listings->the_post();
					$lid  = get_the_ID();
					$lat  = get_field( 'latitude', $lid );
					$lng  = get_field( 'longitude', $lid );

					if ( $lat && $lng ) {
						$cat_terms = wp_get_post_terms( $lid, 'business_category', array( 'fields' => 'names' ) );
						$markers[] = array(
							'lat'      => (float) $lat,
							'lng'      => (float) $lng,
							'title'    => get_field( 'business_name', $lid ) ?: get_the_title( $lid ),
							'url'      => get_permalink( $lid ),
							'category' => ! is_wp_error( $cat_terms ) && ! empty( $cat_terms ) ? $cat_terms[0] : '',
						);
					}
				endwhile;
				$listings->rewind_posts();
				?>

				<?php if ( $markers ) : ?>
					<div class="va-map va-map--tall" data-markers="<?php echo esc_attr( wp_json_encode( $markers ) ); ?>"></div>
				<?php endif; ?>

				<div class="va-grid va-grid--3">
					<?php while ( $listings->have_posts() ) : $listings->the_post(); ?>
						<?php get_template_part( 'template-parts/cards/card-listing', null, array( 'post_id' => get_the_ID() ) ); ?>
					<?php endwhile; ?>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<p><?php esc_html_e( 'No listings found.', 'visitaylesbury' ); ?></p>
			<?php endif; ?>

		</div>
	</div>

</main>

<?php
get_footer();
