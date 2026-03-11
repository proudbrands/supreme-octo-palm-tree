<?php
/**
 * Front Page template.
 *
 * PHP template (not FSE) — needs dynamic queries for CPT sections.
 *
 * @package VisitAylesbury
 */

get_header();
?>

<main>

	<!-- Hero -->
	<section class="va-hero">
		<h1><?php esc_html_e( 'Discover Aylesbury and the Vale', 'visitaylesbury' ); ?></h1>
		<p><?php esc_html_e( 'The digital front door to everything local.', 'visitaylesbury' ); ?></p>
		<div class="va-hero__search">
			<!-- Search form placeholder -->
		</div>
	</section>

	<!-- What's On This Week -->
	<section class="va-section">
		<div class="va-container">
			<div class="va-section-header">
				<h2 class="va-section-header__title"><?php esc_html_e( "What's On This Week", 'visitaylesbury' ); ?></h2>
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

	<!-- Featured Food & Drink -->
	<section class="va-section">
		<div class="va-container">
			<div class="va-section-header">
				<h2 class="va-section-header__title"><?php esc_html_e( 'Featured Food and Drink', 'visitaylesbury' ); ?></h2>
				<a href="<?php echo esc_url( get_term_link( 'eat-drink', 'business_category' ) ); ?>" class="va-section-header__link">
					<?php esc_html_e( 'All food & drink', 'visitaylesbury' ); ?> &rarr;
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

	<!-- Walks & Countryside -->
	<section class="va-section">
		<div class="va-container">
			<div class="va-section-header">
				<h2 class="va-section-header__title"><?php esc_html_e( 'Walks and Countryside', 'visitaylesbury' ); ?></h2>
				<a href="<?php echo esc_url( get_permalink( 348 ) ); ?>" class="va-section-header__link">
					<?php esc_html_e( 'All walks', 'visitaylesbury' ); ?> &rarr;
				</a>
			</div>

			<?php
			$walks = new WP_Query( array(
				'post_type'      => 'walk',
				'posts_per_page' => 3,
				'post_status'    => 'publish',
				'orderby'        => 'title',
				'order'          => 'ASC',
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

	<!-- Newsletter Signup -->
	<section class="va-section va-section--dark">
		<div class="va-container">
			<h2><?php esc_html_e( 'Get the best of Aylesbury in your inbox', 'visitaylesbury' ); ?></h2>
			<p><?php esc_html_e( 'Weekly events and local picks.', 'visitaylesbury' ); ?></p>
			<div class="va-newsletter__form">
				<!-- Gravity Form placeholder -->
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
