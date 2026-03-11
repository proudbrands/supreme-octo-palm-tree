<?php
/**
 * Template Name: Food and Drink
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

	<!-- Restaurants -->
	<section class="va-section">
		<div class="va-section-header">
			<h2 class="va-section-header__title"><?php esc_html_e( 'Restaurants', 'visitaylesbury' ); ?></h2>
		</div>

		<?php
		$restaurants = new WP_Query( array(
			'post_type'      => 'listing',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'tax_query'      => array(
				array(
					'taxonomy' => 'business_category',
					'field'    => 'slug',
					'terms'    => 'restaurants',
				),
			),
		) );
		?>

		<?php if ( $restaurants->have_posts() ) : ?>
			<div class="va-grid va-grid--3">
				<?php while ( $restaurants->have_posts() ) : $restaurants->the_post(); ?>
					<?php get_template_part( 'template-parts/cards/card-listing', null, array( 'post_id' => get_the_ID() ) ); ?>
				<?php endwhile; ?>
			</div>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	</section>

	<!-- Pubs -->
	<section class="va-section">
		<div class="va-section-header">
			<h2 class="va-section-header__title"><?php esc_html_e( 'Pubs', 'visitaylesbury' ); ?></h2>
		</div>

		<?php
		$pubs = new WP_Query( array(
			'post_type'      => 'listing',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'tax_query'      => array(
				array(
					'taxonomy' => 'business_category',
					'field'    => 'slug',
					'terms'    => 'pubs',
				),
			),
		) );
		?>

		<?php if ( $pubs->have_posts() ) : ?>
			<div class="va-grid va-grid--3">
				<?php while ( $pubs->have_posts() ) : $pubs->the_post(); ?>
					<?php get_template_part( 'template-parts/cards/card-listing', null, array( 'post_id' => get_the_ID() ) ); ?>
				<?php endwhile; ?>
			</div>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	</section>

	<!-- Cafes -->
	<section class="va-section">
		<div class="va-section-header">
			<h2 class="va-section-header__title"><?php esc_html_e( 'Cafes', 'visitaylesbury' ); ?></h2>
		</div>

		<?php
		$cafes = new WP_Query( array(
			'post_type'      => 'listing',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'tax_query'      => array(
				array(
					'taxonomy' => 'business_category',
					'field'    => 'slug',
					'terms'    => 'cafes',
				),
			),
		) );
		?>

		<?php if ( $cafes->have_posts() ) : ?>
			<div class="va-grid va-grid--3">
				<?php while ( $cafes->have_posts() ) : $cafes->the_post(); ?>
					<?php get_template_part( 'template-parts/cards/card-listing', null, array( 'post_id' => get_the_ID() ) ); ?>
				<?php endwhile; ?>
			</div>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	</section>

</main>

<?php
get_footer();
