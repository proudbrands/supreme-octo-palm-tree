<?php
/**
 * Template Name: The Vale
 *
 * Hub page for Aylesbury Vale villages and countryside.
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

	<!-- Interactive Vale Map -->
	<?php
	$areas = new WP_Query( array(
		'post_type'      => 'area',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'orderby'        => 'title',
		'order'          => 'ASC',
	) );

	$markers = array();
	if ( $areas->have_posts() ) :
		while ( $areas->have_posts() ) : $areas->the_post();
			$lat = get_field( 'latitude' );
			$lng = get_field( 'longitude' );
			if ( $lat && $lng ) {
				$markers[] = array(
					'lat'      => (float) $lat,
					'lng'      => (float) $lng,
					'title'    => esc_html( get_field( 'area_name' ) ),
					'link'     => esc_url( get_permalink() ),
					'category' => esc_html( get_field( 'area_type' ) ),
				);
			}
		endwhile;
		wp_reset_postdata();
	endif;
	?>

	<?php if ( ! empty( $markers ) ) : ?>
		<div class="va-map va-map--tall" data-markers="<?php echo esc_attr( wp_json_encode( $markers ) ); ?>"></div>
	<?php endif; ?>

	<!-- Villages & Areas -->
	<section class="va-section">
		<div class="va-section-header">
			<h2 class="va-section-header__title"><?php esc_html_e( 'Villages and Areas', 'visitaylesbury' ); ?></h2>
		</div>

		<?php if ( $areas->have_posts() ) : ?>
			<?php $areas->rewind_posts(); ?>
			<div class="va-grid va-grid--3">
				<?php while ( $areas->have_posts() ) : $areas->the_post(); ?>
					<?php get_template_part( 'template-parts/cards/card-area', null, array( 'post_id' => get_the_ID() ) ); ?>
				<?php endwhile; ?>
			</div>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	</section>

	<!-- Featured Walks -->
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

</main>

<?php
get_footer();
