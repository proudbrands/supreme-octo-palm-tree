<?php
/**
 * Front Page template.
 *
 * PHP template (not FSE) — needs dynamic queries for CPT sections.
 * Architecture: 8 sections answering 6 visitor questions.
 *
 * @package VisitAylesbury
 */

get_header();
?>

<main class="va-main">

	<!-- 1. Hero -->
	<section class="va-hero">
		<div class="va-hero__content">
			<h1><?php esc_html_e( 'Discover Aylesbury and the Vale', 'visitaylesbury' ); ?></h1>
			<p><?php esc_html_e( 'Your guide to everything local — places, events, food, walks, and more.', 'visitaylesbury' ); ?></p>
			<div class="va-hero__search">
				<input type="search" class="va-hero__input" placeholder="<?php esc_attr_e( 'Search for places, events, and more…', 'visitaylesbury' ); ?>" />
			</div>
			<div class="va-hero__pills">
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'things-to-do' ) ) ); ?>" class="va-hero__pill"><?php esc_html_e( 'Things to Do', 'visitaylesbury' ); ?></a>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>" class="va-hero__pill"><?php esc_html_e( 'Events', 'visitaylesbury' ); ?></a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'food-and-drink' ) ) ); ?>" class="va-hero__pill"><?php esc_html_e( 'Eat & Drink', 'visitaylesbury' ); ?></a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'the-vale' ) ) ); ?>" class="va-hero__pill"><?php esc_html_e( 'The Vale', 'visitaylesbury' ); ?></a>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'listing' ) ); ?>" class="va-hero__pill"><?php esc_html_e( 'Directory', 'visitaylesbury' ); ?></a>
			</div>
		</div>
	</section>

	<!-- 2. What's On This Week -->
	<section class="va-section">
		<div class="va-container">
			<div class="va-section-header">
				<h2 class="va-section-header__title"><?php esc_html_e( "What's On This Week", 'visitaylesbury' ); ?></h2>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>" class="va-section-header__link">
					<?php esc_html_e( 'All events', 'visitaylesbury' ); ?>
				</a>
			</div>

			<?php
			$events = new WP_Query( array(
				'post_type'      => 'event',
				'posts_per_page' => 6,
				'meta_key'       => 'start_date',
				'orderby'        => 'meta_value',
				'order'          => 'ASC',
				'meta_query'     => array(
					array(
						'key'     => 'start_date',
						'value'   => date( 'Ymd' ),
						'compare' => '>=',
						'type'    => 'DATE',
					),
				),
			) );
			?>

			<?php if ( $events->have_posts() ) : ?>
				<div class="va-scroll-row">
					<div class="va-scroll-row__inner">
						<?php while ( $events->have_posts() ) : $events->the_post(); ?>
							<?php get_template_part( 'template-parts/cards/card-event', null, array( 'post_id' => get_the_ID() ) ); ?>
						<?php endwhile; ?>
					</div>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
	</section>

	<!-- 3. Featured Food & Drink -->
	<section class="va-section va-section--light">
		<div class="va-container">
			<div class="va-section-header">
				<h2 class="va-section-header__title"><?php esc_html_e( 'Featured Food and Drink', 'visitaylesbury' ); ?></h2>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'food-and-drink' ) ) ); ?>" class="va-section-header__link">
					<?php esc_html_e( 'All food & drink', 'visitaylesbury' ); ?>
				</a>
			</div>

			<?php
			$food = new WP_Query( array(
				'post_type'      => 'listing',
				'posts_per_page' => 3,
				'tax_query'      => array(
					array(
						'taxonomy' => 'business_category',
						'field'    => 'slug',
						'terms'    => array( 'restaurants', 'pubs', 'cafes' ),
					),
				),
			) );
			?>

			<?php if ( $food->have_posts() ) : ?>
				<div class="va-grid va-grid--3">
					<?php while ( $food->have_posts() ) : $food->the_post(); ?>
						<?php get_template_part( 'template-parts/cards/card-listing', null, array( 'post_id' => get_the_ID() ) ); ?>
					<?php endwhile; ?>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
	</section>

	<!-- 4. Explore the Vale -->
	<section class="va-section">
		<div class="va-container">
			<div class="va-section-header">
				<h2 class="va-section-header__title"><?php esc_html_e( 'Explore the Vale', 'visitaylesbury' ); ?></h2>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'the-vale' ) ) ); ?>" class="va-section-header__link">
					<?php esc_html_e( 'All villages', 'visitaylesbury' ); ?>
				</a>
			</div>

			<?php
			$areas = new WP_Query( array(
				'post_type'      => 'area',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'orderby'        => 'title',
				'order'          => 'ASC',
			) );

			$area_markers = array();
			if ( $areas->have_posts() ) :
				while ( $areas->have_posts() ) : $areas->the_post();
					$lat = get_field( 'latitude' );
					$lng = get_field( 'longitude' );
					if ( $lat && $lng ) {
						$area_markers[] = array(
							'lat'      => (float) $lat,
							'lng'      => (float) $lng,
							'title'    => esc_html( get_field( 'area_name' ) ),
							'link'     => esc_url( get_permalink() ),
							'category' => esc_html( get_field( 'area_type' ) ),
						);
					}
				endwhile;
				wp_reset_postdata();
			endif;
			?>

			<?php if ( ! empty( $area_markers ) ) : ?>
				<div class="va-map" data-markers="<?php echo esc_attr( wp_json_encode( $area_markers ) ); ?>"></div>
			<?php endif; ?>

			<?php
			$featured_areas = new WP_Query( array(
				'post_type'      => 'area',
				'posts_per_page' => 3,
				'post_status'    => 'publish',
				'orderby'        => 'rand',
			) );
			?>

			<?php if ( $featured_areas->have_posts() ) : ?>
				<div class="va-grid va-grid--3">
					<?php while ( $featured_areas->have_posts() ) : $featured_areas->the_post(); ?>
						<?php get_template_part( 'template-parts/cards/card-area', null, array( 'post_id' => get_the_ID() ) ); ?>
					<?php endwhile; ?>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
	</section>

	<!-- 5. Walks & Countryside -->
	<section class="va-section va-section--light">
		<div class="va-container">
			<div class="va-section-header">
				<h2 class="va-section-header__title"><?php esc_html_e( 'Walks and Countryside', 'visitaylesbury' ); ?></h2>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'the-vale/walks' ) ) ); ?>" class="va-section-header__link">
					<?php esc_html_e( 'All walks', 'visitaylesbury' ); ?>
				</a>
			</div>

			<?php
			$walks = new WP_Query( array(
				'post_type'      => 'walk',
				'posts_per_page' => 3,
				'post_status'    => 'publish',
				'orderby'        => 'rand',
			) );
			?>

			<?php if ( $walks->have_posts() ) : ?>
				<div class="va-grid va-grid--3">
					<?php while ( $walks->have_posts() ) : $walks->the_post(); ?>
						<?php get_template_part( 'template-parts/cards/card-walk', null, array( 'post_id' => get_the_ID() ) ); ?>
					<?php endwhile; ?>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
	</section>

	<!-- 6. Useful Guides -->
	<section class="va-section">
		<div class="va-container">
			<div class="va-section-header">
				<h2 class="va-section-header__title"><?php esc_html_e( 'Useful Guides', 'visitaylesbury' ); ?></h2>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'guide' ) ); ?>" class="va-section-header__link">
					<?php esc_html_e( 'All guides', 'visitaylesbury' ); ?>
				</a>
			</div>

			<?php
			$guides = new WP_Query( array(
				'post_type'      => 'guide',
				'posts_per_page' => 3,
				'post_status'    => 'publish',
			) );
			?>

			<?php if ( $guides->have_posts() ) : ?>
				<div class="va-grid va-grid--3">
					<?php while ( $guides->have_posts() ) : $guides->the_post(); ?>
						<?php get_template_part( 'template-parts/cards/card-guide', null, array( 'post_id' => get_the_ID() ) ); ?>
					<?php endwhile; ?>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
	</section>

	<!-- 7. Featured Businesses -->
	<section class="va-section va-section--light">
		<div class="va-container">
			<div class="va-section-header">
				<h2 class="va-section-header__title"><?php esc_html_e( 'Featured Businesses', 'visitaylesbury' ); ?></h2>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'listing' ) ); ?>" class="va-section-header__link">
					<?php esc_html_e( 'Browse directory', 'visitaylesbury' ); ?>
				</a>
			</div>

			<?php
			$featured = new WP_Query( array(
				'post_type'      => 'listing',
				'posts_per_page' => 3,
				'post_status'    => 'publish',
				'meta_query'     => array(
					array(
						'key'     => 'listing_tier',
						'value'   => array( 'featured', 'premium', 'sponsor' ),
						'compare' => 'IN',
					),
				),
			) );

			// Fallback: if no paid listings yet, show random listings.
			if ( ! $featured->have_posts() ) {
				$featured = new WP_Query( array(
					'post_type'      => 'listing',
					'posts_per_page' => 3,
					'post_status'    => 'publish',
					'orderby'        => 'rand',
				) );
			}
			?>

			<?php if ( $featured->have_posts() ) : ?>
				<div class="va-grid va-grid--3">
					<?php while ( $featured->have_posts() ) : $featured->the_post(); ?>
						<?php get_template_part( 'template-parts/cards/card-listing', null, array( 'post_id' => get_the_ID() ) ); ?>
					<?php endwhile; ?>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
	</section>

	<!-- 8. Newsletter Signup -->
	<section class="va-section va-section--dark">
		<div class="va-container">
			<div class="va-newsletter">
				<h2><?php esc_html_e( 'Stay in the loop', 'visitaylesbury' ); ?></h2>
				<p><?php esc_html_e( 'The best of Aylesbury, delivered weekly. Events, local picks, and exclusive offers.', 'visitaylesbury' ); ?></p>
				<form class="va-newsletter__form">
					<input type="email" class="va-newsletter__input" placeholder="<?php esc_attr_e( 'Your email address', 'visitaylesbury' ); ?>" required />
					<button type="submit" class="va-newsletter__btn"><?php esc_html_e( 'Subscribe', 'visitaylesbury' ); ?></button>
				</form>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
