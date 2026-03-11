<?php
/**
 * Template Name: Vale Walks
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
	$walks = new WP_Query( array(
		'post_type'      => 'walk',
		'posts_per_page' => -1,
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
	<?php else : ?>
		<p><?php esc_html_e( 'No walks found.', 'visitaylesbury' ); ?></p>
	<?php endif; ?>

</main>

<?php
get_footer();
