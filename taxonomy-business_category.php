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

<main class="va-main">

	<div class="va-container">
		<div class="va-archive-header">
			<h1><?php echo esc_html( $term->name ); ?></h1>
			<?php if ( $term->description ) : ?>
				<p><?php echo esc_html( $term->description ); ?></p>
			<?php endif; ?>
		</div>
	</div>

	<div class="va-filter-bar">
		<div class="va-filter-bar__inner">
			<div class="va-pill-row">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'listing' ) ); ?>" class="va-pill"><?php esc_html_e( 'All', 'visitaylesbury' ); ?></a>
				<?php
				$top_cats = get_terms( array(
					'taxonomy'   => 'business_category',
					'parent'     => 0,
					'hide_empty' => true,
					'number'     => 8,
				) );
				if ( ! is_wp_error( $top_cats ) && ! empty( $top_cats ) ) :
					foreach ( $top_cats as $cat ) :
						$is_current = ( $cat->term_id === $term->term_id );
				?>
					<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="va-pill<?php echo $is_current ? ' is-active' : ''; ?>"><?php echo esc_html( $cat->name ); ?></a>
				<?php
					endforeach;
				endif;
				?>
			</div>
		</div>
	</div>

	<div class="va-section">
		<div class="va-container">
			<?php if ( have_posts() ) : ?>
				<div class="va-grid va-grid--3">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'template-parts/cards/card-listing', null, array( 'post_id' => get_the_ID() ) ); ?>
					<?php endwhile; ?>
				</div>
			<?php else : ?>
				<p><?php esc_html_e( 'No listings found in this category.', 'visitaylesbury' ); ?></p>
			<?php endif; ?>
		</div>
	</div>

</main>

<?php
get_footer();
