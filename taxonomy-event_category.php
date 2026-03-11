<?php
/**
 * Taxonomy archive: event_category
 *
 * Shows events filtered by category (Music, Family, etc.)
 *
 * @package VisitAylesbury
 */

get_header();

$term = get_queried_object();
?>

<main class="va-container va-section">

	<h1><?php echo esc_html( $term->name . ' Events' ); ?></h1>

	<?php if ( $term->description ) : ?>
		<p><?php echo esc_html( $term->description ); ?></p>
	<?php endif; ?>

	<?php
	$events = new WP_Query( array(
		'post_type'      => 'event',
		'posts_per_page' => -1,
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
				'taxonomy' => 'event_category',
				'field'    => 'term_id',
				'terms'    => $term->term_id,
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
	<?php else : ?>
		<p><?php esc_html_e( 'No upcoming events in this category.', 'visitaylesbury' ); ?></p>
	<?php endif; ?>

</main>

<?php
get_footer();
