<?php
/**
 * Template Name: Guides
 *
 * Index page for all guide content. Grouped by guide_type taxonomy.
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

	<?php
	$guide_types = get_terms( array(
		'taxonomy'   => 'guide_type',
		'hide_empty' => true,
		'orderby'    => 'name',
		'order'      => 'ASC',
	) );
	?>

	<?php if ( ! empty( $guide_types ) && ! is_wp_error( $guide_types ) ) : ?>
		<?php foreach ( $guide_types as $type ) : ?>
			<section class="va-section">
				<div class="va-section-header">
					<h2 class="va-section-header__title"><?php echo esc_html( $type->name ); ?></h2>
				</div>

				<?php
				$type_guides = new WP_Query( array(
					'post_type'      => 'guide',
					'posts_per_page' => -1,
					'post_status'    => 'publish',
					'tax_query'      => array(
						array(
							'taxonomy' => 'guide_type',
							'field'    => 'term_id',
							'terms'    => $type->term_id,
						),
					),
				) );
				?>

				<?php if ( $type_guides->have_posts() ) : ?>
					<div class="va-grid va-grid--3">
						<?php while ( $type_guides->have_posts() ) : $type_guides->the_post(); ?>
							<?php get_template_part( 'template-parts/cards/card-guide', null, array( 'post_id' => get_the_ID() ) ); ?>
						<?php endwhile; ?>
					</div>
					<?php wp_reset_postdata(); ?>
				<?php endif; ?>
			</section>
		<?php endforeach; ?>

	<?php else : ?>
		<!-- Fallback: show all guides ungrouped -->
		<?php
		$all_guides = new WP_Query( array(
			'post_type'      => 'guide',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'orderby'        => 'title',
			'order'          => 'ASC',
		) );
		?>

		<?php if ( $all_guides->have_posts() ) : ?>
			<div class="va-grid va-grid--3">
				<?php while ( $all_guides->have_posts() ) : $all_guides->the_post(); ?>
					<?php get_template_part( 'template-parts/cards/card-guide', null, array( 'post_id' => get_the_ID() ) ); ?>
				<?php endwhile; ?>
			</div>
			<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'No guides found.', 'visitaylesbury' ); ?></p>
		<?php endif; ?>
	<?php endif; ?>

</main>

<?php
get_footer();
