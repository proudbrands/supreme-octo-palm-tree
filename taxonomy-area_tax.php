<?php
/**
 * Taxonomy archive: area_tax
 *
 * Shows listings, events, and walks tagged with a specific area.
 *
 * @package VisitAylesbury
 */

get_header();

$term = get_queried_object();
?>

<main class="va-container va-section">

	<h1><?php echo esc_html( $term->name ); ?></h1>

	<?php if ( $term->description ) : ?>
		<p><?php echo esc_html( $term->description ); ?></p>
	<?php endif; ?>

	<!-- Listings in this area -->
	<?php
	$listings = new WP_Query( array(
		'post_type'      => 'listing',
		'posts_per_page' => -1,
		'tax_query'      => array(
			array(
				'taxonomy' => 'area_tax',
				'field'    => 'term_id',
				'terms'    => $term->term_id,
			),
		),
	) );
	?>

	<?php if ( $listings->have_posts() ) : ?>
		<section class="va-section">
			<div class="va-section-header">
				<h2 class="va-section-header__title"><?php esc_html_e( 'Listings', 'visitaylesbury' ); ?></h2>
			</div>
			<div class="va-grid va-grid--3">
				<?php while ( $listings->have_posts() ) : $listings->the_post(); ?>
					<?php get_template_part( 'template-parts/cards/card-listing', null, array( 'post_id' => get_the_ID() ) ); ?>
				<?php endwhile; ?>
			</div>
			<?php wp_reset_postdata(); ?>
		</section>
	<?php endif; ?>

	<!-- Events in this area -->
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
		'tax_query'      => array(
			array(
				'taxonomy' => 'area_tax',
				'field'    => 'term_id',
				'terms'    => $term->term_id,
			),
		),
	) );
	?>

	<?php if ( $events->have_posts() ) : ?>
		<section class="va-section">
			<div class="va-section-header">
				<h2 class="va-section-header__title"><?php esc_html_e( 'Upcoming Events', 'visitaylesbury' ); ?></h2>
			</div>
			<div class="va-grid va-grid--3">
				<?php while ( $events->have_posts() ) : $events->the_post(); ?>
					<?php get_template_part( 'template-parts/cards/card-event', null, array( 'post_id' => get_the_ID() ) ); ?>
				<?php endwhile; ?>
			</div>
			<?php wp_reset_postdata(); ?>
		</section>
	<?php endif; ?>

	<!-- Walks in this area -->
	<?php
	$walks = new WP_Query( array(
		'post_type'      => 'walk',
		'posts_per_page' => -1,
		'tax_query'      => array(
			array(
				'taxonomy' => 'area_tax',
				'field'    => 'term_id',
				'terms'    => $term->term_id,
			),
		),
	) );
	?>

	<?php if ( $walks->have_posts() ) : ?>
		<section class="va-section">
			<div class="va-section-header">
				<h2 class="va-section-header__title"><?php esc_html_e( 'Walks', 'visitaylesbury' ); ?></h2>
			</div>
			<div class="va-grid va-grid--3">
				<?php while ( $walks->have_posts() ) : $walks->the_post(); ?>
					<?php get_template_part( 'template-parts/cards/card-walk', null, array( 'post_id' => get_the_ID() ) ); ?>
				<?php endwhile; ?>
			</div>
			<?php wp_reset_postdata(); ?>
		</section>
	<?php endif; ?>

</main>

<?php
get_footer();
