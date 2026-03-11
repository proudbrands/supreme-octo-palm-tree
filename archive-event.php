<?php
/**
 * Archive: Event (What's On)
 *
 * @package VisitAylesbury
 */

get_header();
?>

<main class="va-main">

	<div class="va-container">
		<div class="va-archive-header">
			<h1><?php esc_html_e( "What's On in Aylesbury", 'visitaylesbury' ); ?></h1>
		</div>
	</div>

	<div class="va-filter-bar">
		<div class="va-filter-bar__inner">
			<div class="va-pill-row">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>" class="va-pill is-active"><?php esc_html_e( 'All', 'visitaylesbury' ); ?></a>
				<?php
				$event_cats = get_terms( array(
					'taxonomy'   => 'event_category',
					'hide_empty' => true,
				) );
				if ( ! is_wp_error( $event_cats ) && ! empty( $event_cats ) ) :
					foreach ( $event_cats as $ecat ) :
				?>
					<a href="<?php echo esc_url( get_term_link( $ecat ) ); ?>" class="va-pill"><?php echo esc_html( $ecat->name ); ?></a>
				<?php
					endforeach;
				endif;
				?>
			</div>
		</div>
	</div>

	<div class="va-section">
		<div class="va-container">

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

		</div>
	</div>

</main>

<?php
get_footer();
