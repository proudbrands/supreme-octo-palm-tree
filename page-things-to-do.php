<?php
/**
 * Template Name: Things to Do
 *
 * Activity discovery hub. Mixes events, listings, and guides.
 *
 * @package VisitAylesbury
 */

get_header();
?>

<main class="va-container va-section">

	<h1><?php the_title(); ?></h1>

	<?php
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
	?>

	<div class="va-pill-row">
		<a href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>" class="va-pill"><?php esc_html_e( 'Events', 'visitaylesbury' ); ?></a>
		<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'food-and-drink' ) ) ); ?>" class="va-pill"><?php esc_html_e( 'Food & Drink', 'visitaylesbury' ); ?></a>
		<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'the-vale/walks' ) ) ); ?>" class="va-pill"><?php esc_html_e( 'Walks', 'visitaylesbury' ); ?></a>
		<a href="<?php echo esc_url( get_term_link( 'attractions', 'business_category' ) ); ?>" class="va-pill"><?php esc_html_e( 'Attractions', 'visitaylesbury' ); ?></a>
		<a href="<?php echo esc_url( get_term_link( 'leisure', 'business_category' ) ); ?>" class="va-pill"><?php esc_html_e( 'Leisure', 'visitaylesbury' ); ?></a>
		<a href="<?php echo esc_url( get_term_link( 'shops', 'business_category' ) ); ?>" class="va-pill"><?php esc_html_e( 'Shopping', 'visitaylesbury' ); ?></a>
	</div>

	<!-- Upcoming Events -->
	<section class="va-section">
		<div class="va-section-header">
			<h2 class="va-section-header__title"><?php esc_html_e( 'Coming Up', 'visitaylesbury' ); ?></h2>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>" class="va-section-header__link">
				<?php esc_html_e( 'All events', 'visitaylesbury' ); ?> &rarr;
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
			<div class="va-grid va-grid--3">
				<?php while ( $events->have_posts() ) : $events->the_post(); ?>
					<?php get_template_part( 'template-parts/cards/card-event', null, array( 'post_id' => get_the_ID() ) ); ?>
				<?php endwhile; ?>
			</div>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	</section>

	<!-- Attractions -->
	<section class="va-section">
		<div class="va-section-header">
			<h2 class="va-section-header__title"><?php esc_html_e( 'Attractions', 'visitaylesbury' ); ?></h2>
			<a href="<?php echo esc_url( get_term_link( 'attractions', 'business_category' ) ); ?>" class="va-section-header__link">
				<?php esc_html_e( 'All attractions', 'visitaylesbury' ); ?> &rarr;
			</a>
		</div>

		<?php
		$attractions = new WP_Query( array(
			'post_type'      => 'listing',
			'posts_per_page' => 3,
			'tax_query'      => array(
				array(
					'taxonomy' => 'business_category',
					'field'    => 'slug',
					'terms'    => 'attractions',
				),
			),
		) );
		?>

		<?php if ( $attractions->have_posts() ) : ?>
			<div class="va-grid va-grid--3">
				<?php while ( $attractions->have_posts() ) : $attractions->the_post(); ?>
					<?php get_template_part( 'template-parts/cards/card-listing', null, array( 'post_id' => get_the_ID() ) ); ?>
				<?php endwhile; ?>
			</div>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	</section>

	<!-- Walks -->
	<section class="va-section">
		<div class="va-section-header">
			<h2 class="va-section-header__title"><?php esc_html_e( 'Walks and Countryside', 'visitaylesbury' ); ?></h2>
			<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'the-vale/walks' ) ) ); ?>" class="va-section-header__link">
				<?php esc_html_e( 'All walks', 'visitaylesbury' ); ?> &rarr;
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
	</section>

	<!-- Guides -->
	<section class="va-section">
		<div class="va-section-header">
			<h2 class="va-section-header__title"><?php esc_html_e( 'Useful Guides', 'visitaylesbury' ); ?></h2>
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
	</section>

</main>

<?php
get_footer();
