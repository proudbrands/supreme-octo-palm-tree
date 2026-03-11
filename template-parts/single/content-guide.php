<?php
/**
 * Single content: Guide
 *
 * Rich editorial layout with ACF metadata and related content.
 *
 * @package VisitAylesbury
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

// ACF fields.
$hero_image      = get_field( 'hero_image', $post_id );
$last_verified   = get_field( 'last_verified', $post_id );
$seasonal_flag   = get_field( 'seasonal_flag', $post_id );
$cta             = get_field( 'call_to_action', $post_id );
$related_listings = get_field( 'related_listings', $post_id );
$related_events  = get_field( 'related_events', $post_id );
$related_walks   = get_field( 'related_walks', $post_id );
$related_areas   = get_field( 'related_areas', $post_id );

$hero_image_id = $hero_image ? $hero_image['id'] : get_post_thumbnail_id( $post_id );

// Guide type.
$guide_type_name = '';
$types           = get_the_terms( $post_id, 'guide_type' );
if ( $types && ! is_wp_error( $types ) ) {
	$guide_type_name = $types[0]->name;
}

// Updated date.
$updated_display = '';
if ( $last_verified ) {
	$updated_display = date( 'F Y', strtotime( $last_verified ) );
}
?>

<?php if ( $hero_image_id ) : ?>
	<div class="va-single-guide__hero">
		<?php echo wp_get_attachment_image( $hero_image_id, 'va-hero', false, array( 'class' => 'va-single-guide__hero-img' ) ); ?>
	</div>
<?php endif; ?>

<div class="va-container va-section">

	<div class="va-single-guide__header">
		<h1 class="va-single-guide__title"><?php the_title(); ?></h1>
		<div class="va-single-guide__meta">
			<?php if ( $guide_type_name ) : ?>
				<span class="va-badge va-badge--category"><?php echo esc_html( $guide_type_name ); ?></span>
			<?php endif; ?>
			<?php if ( $seasonal_flag && 'none' !== $seasonal_flag ) : ?>
				<span class="va-badge va-badge--featured"><?php echo esc_html( ucfirst( $seasonal_flag ) ); ?></span>
			<?php endif; ?>
			<?php if ( $updated_display ) : ?>
				<span class="va-text-small"><?php echo esc_html( 'Updated ' . $updated_display ); ?></span>
			<?php endif; ?>
		</div>
	</div>

	<div class="va-single-guide__content">
		<?php the_content(); ?>
	</div>

	<?php if ( $cta && ! empty( $cta['cta_text'] ) && ! empty( $cta['cta_url'] ) ) : ?>
		<div class="va-single-guide__cta">
			<a href="<?php echo esc_url( $cta['cta_url'] ); ?>" class="va-single-guide__cta-btn">
				<?php echo esc_html( $cta['cta_text'] ); ?>
			</a>
		</div>
	<?php endif; ?>

	<?php if ( $related_listings ) : ?>
		<div class="va-single-guide__related">
			<h2><?php esc_html_e( 'Related Listings', 'visitaylesbury' ); ?></h2>
			<div class="va-grid va-grid--3">
				<?php foreach ( $related_listings as $listing ) : ?>
					<?php get_template_part( 'template-parts/cards/card-listing', null, array( 'post_id' => $listing->ID ) ); ?>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( $related_events ) : ?>
		<div class="va-single-guide__related">
			<h2><?php esc_html_e( 'Related Events', 'visitaylesbury' ); ?></h2>
			<div class="va-grid va-grid--3">
				<?php foreach ( $related_events as $event ) : ?>
					<?php get_template_part( 'template-parts/cards/card-event', null, array( 'post_id' => $event->ID ) ); ?>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( $related_walks ) : ?>
		<div class="va-single-guide__related">
			<h2><?php esc_html_e( 'Related Walks', 'visitaylesbury' ); ?></h2>
			<div class="va-grid va-grid--3">
				<?php foreach ( $related_walks as $walk ) : ?>
					<?php get_template_part( 'template-parts/cards/card-walk', null, array( 'post_id' => $walk->ID ) ); ?>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( $related_areas ) : ?>
		<div class="va-single-guide__related">
			<h2><?php esc_html_e( 'Explore the Vale', 'visitaylesbury' ); ?></h2>
			<div class="va-grid va-grid--3">
				<?php foreach ( $related_areas as $area ) : ?>
					<?php get_template_part( 'template-parts/cards/card-area', null, array( 'post_id' => $area->ID ) ); ?>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

</div>
