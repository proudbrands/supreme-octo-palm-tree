<?php
/**
 * Taxonomy archive: business_category
 *
 * Shows all listings in a given business category.
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

	<?php if ( have_posts() ) : ?>
		<div class="va-grid va-grid--3">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/cards/card-listing', null, array( 'post_id' => get_the_ID() ) ); ?>
			<?php endwhile; ?>
		</div>
	<?php else : ?>
		<p><?php esc_html_e( 'No listings found in this category.', 'visitaylesbury' ); ?></p>
	<?php endif; ?>

</main>

<?php
get_footer();
