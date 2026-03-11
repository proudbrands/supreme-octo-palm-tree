<?php
/**
 * Archive: Event (What's On)
 *
 * @package VisitAylesbury
 */

get_header();
?>

<main class="va-container va-section">

	<h1><?php esc_html_e( "What's On in Aylesbury", 'visitaylesbury' ); ?></h1>

	<?php
	$events = new WP_Query( array(
		'post_type'      => 'event',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
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
	<?php else : ?>
		<p><?php esc_html_e( 'No upcoming events found.', 'visitaylesbury' ); ?></p>
	<?php endif; ?>

</main>

<?php
get_footer();
