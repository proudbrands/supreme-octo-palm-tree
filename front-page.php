<?php
/**
 * Front Page template.
 *
 * PHP template (not FSE) — needs dynamic queries for CPT sections.
 *
 * @package VisitAylesbury
 */

get_header();
?>

<main class="va-main">

	<!-- 1. Hero — centred text with floating images -->
	<section class="va-hero">
		<div class="va-hero__images">
			<div class="va-hero__float va-hero__float--1"></div>
			<div class="va-hero__float va-hero__float--2"></div>
			<div class="va-hero__float va-hero__float--3"></div>
			<div class="va-hero__float va-hero__float--4"></div>
			<div class="va-hero__float va-hero__float--5"></div>
			<div class="va-hero__float va-hero__float--6"></div>
		</div>
		<div class="va-hero__content">
			<h1><?php esc_html_e( 'Discover the best experiences in Aylesbury', 'visitaylesbury' ); ?></h1>
			<p><?php esc_html_e( 'Your guide to the best places, events, food, walks, and hidden gems across Aylesbury and the Vale.', 'visitaylesbury' ); ?></p>
			<div class="va-hero__buttons">
				<a href="#va-newsletter-cta" class="va-hero__btn va-hero__btn--primary"><?php esc_html_e( 'Subscribe', 'visitaylesbury' ); ?></a>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'listing' ) ); ?>" class="va-hero__btn va-hero__btn--outline"><?php esc_html_e( 'Explore experiences', 'visitaylesbury' ); ?></a>
			</div>
		</div>
	</section>

	<!-- 2. Search Bar — overlapping hero -->
	<div class="va-search-bar">
		<div class="va-search-bar__inner">
			<div class="va-search-bar__input-wrap">
				<svg class="va-search-bar__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
				<input type="search" class="va-search-bar__input" placeholder="<?php esc_attr_e( 'Search for places, events, and more...', 'visitaylesbury' ); ?>" />
			</div>
			<span class="va-search-bar__divider"></span>
			<div class="va-search-bar__select-wrap">
				<svg class="va-search-bar__select-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="3"/></svg>
				<select class="va-search-bar__select" aria-label="<?php esc_attr_e( 'Area', 'visitaylesbury' ); ?>">
					<option value=""><?php esc_html_e( 'Area', 'visitaylesbury' ); ?></option>
					<?php
					$area_terms = get_terms( array( 'taxonomy' => 'area_tax', 'hide_empty' => false ) );
					$vale_terms = get_terms( array( 'taxonomy' => 'vale_village', 'hide_empty' => false ) );
					if ( $area_terms && ! is_wp_error( $area_terms ) ) :
						foreach ( $area_terms as $term ) : ?>
							<option value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></option>
						<?php endforeach;
					endif;
					if ( $vale_terms && ! is_wp_error( $vale_terms ) ) :
						foreach ( $vale_terms as $term ) : ?>
							<option value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></option>
						<?php endforeach;
					endif;
					?>
				</select>
			</div>
			<span class="va-search-bar__divider"></span>
			<div class="va-search-bar__select-wrap">
				<svg class="va-search-bar__select-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h7"/></svg>
				<select class="va-search-bar__select" aria-label="<?php esc_attr_e( 'Category', 'visitaylesbury' ); ?>">
					<option value=""><?php esc_html_e( 'Category', 'visitaylesbury' ); ?></option>
					<?php
					$cat_terms = get_terms( array( 'taxonomy' => 'business_category', 'hide_empty' => false, 'parent' => 0 ) );
					if ( $cat_terms && ! is_wp_error( $cat_terms ) ) :
						foreach ( $cat_terms as $term ) : ?>
							<option value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></option>
						<?php endforeach;
					endif;
					?>
				</select>
			</div>
			<button class="va-search-bar__btn"><?php esc_html_e( 'Search', 'visitaylesbury' ); ?></button>
		</div>
	</div>

	<!-- 3. Explore by Category -->
	<section class="va-section">
		<div class="va-container">
			<div class="va-section-header">
				<h2 class="va-section-header__title"><?php esc_html_e( 'Explore by category', 'visitaylesbury' ); ?></h2>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'listing' ) ); ?>" class="va-section-header__btn">
					<?php esc_html_e( 'Browse all', 'visitaylesbury' ); ?>
				</a>
			</div>

			<div class="va-category-grid">
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'food-and-drink' ) ) ); ?>" class="va-category-grid__cell">
					<span class="va-category-grid__icon">&#127860;</span>
					<span class="va-category-grid__name"><?php esc_html_e( 'Food & Drink', 'visitaylesbury' ); ?></span>
				</a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'things-to-do' ) ) ); ?>" class="va-category-grid__cell">
					<span class="va-category-grid__icon">&#127917;</span>
					<span class="va-category-grid__name"><?php esc_html_e( 'Arts & Culture', 'visitaylesbury' ); ?></span>
				</a>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>" class="va-category-grid__cell">
					<span class="va-category-grid__icon">&#127925;</span>
					<span class="va-category-grid__name"><?php esc_html_e( 'Entertainment', 'visitaylesbury' ); ?></span>
				</a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'the-vale/walks' ) ) ); ?>" class="va-category-grid__cell">
					<span class="va-category-grid__icon">&#9968;</span>
					<span class="va-category-grid__name"><?php esc_html_e( 'Outdoors', 'visitaylesbury' ); ?></span>
				</a>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'listing' ) ); ?>" class="va-category-grid__cell">
					<span class="va-category-grid__icon">&#127863;</span>
					<span class="va-category-grid__name"><?php esc_html_e( 'Nightlife', 'visitaylesbury' ); ?></span>
				</a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'things-to-do' ) ) ); ?>" class="va-category-grid__cell">
					<span class="va-category-grid__icon">&#127880;</span>
					<span class="va-category-grid__name"><?php esc_html_e( 'Activities', 'visitaylesbury' ); ?></span>
				</a>
			</div>
		</div>
	</section>

	<!-- 4. Popular Experiences — horizontal cards -->
	<section class="va-section">
		<div class="va-container">
			<div class="va-section-header">
				<h2 class="va-section-header__title"><?php esc_html_e( 'Popular experiences', 'visitaylesbury' ); ?></h2>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'listing' ) ); ?>" class="va-section-header__btn">
					<?php esc_html_e( 'Browse all experiences', 'visitaylesbury' ); ?>
				</a>
			</div>

			<?php
			$popular = new WP_Query( array(
				'post_type'      => 'listing',
				'posts_per_page' => 2,
				'post_status'    => 'publish',
				'meta_query'     => array(
					array(
						'key'     => 'listing_tier',
						'value'   => array( 'featured', 'premium', 'sponsor' ),
						'compare' => 'IN',
					),
				),
			) );

			if ( ! $popular->have_posts() ) {
				$popular = new WP_Query( array(
					'post_type'      => 'listing',
					'posts_per_page' => 2,
					'post_status'    => 'publish',
					'orderby'        => 'rand',
				) );
			}
			?>

			<?php if ( $popular->have_posts() ) : ?>
				<div class="va-grid va-grid--2">
					<?php
					$card_index = 0;
					while ( $popular->have_posts() ) : $popular->the_post();
						$post_id       = get_the_ID();
						$business_name = get_field( 'business_name', $post_id );
						$tagline       = get_field( 'tagline', $post_id );
						$hero_image    = get_field( 'hero_image', $post_id );
						$address       = get_field( 'address', $post_id );
						$hours_data    = get_field( 'opening_hours', $post_id );
						$cats          = get_the_terms( $post_id, 'business_category' );
						$cat_name      = ( $cats && ! is_wp_error( $cats ) ) ? $cats[0]->name : '';
						$cta_class     = ( $card_index === 0 ) ? 'va-card__cta--accent' : 'va-card__cta--primary';

						$hours_display = '';
						if ( $hours_data && is_array( $hours_data ) ) {
							$today_name = strtolower( date( 'l' ) );
							foreach ( $hours_data as $row ) {
								if ( strtolower( $row['day'] ) === $today_name ) {
									$hours_display = ! empty( $row['closed'] ) ? 'Closed today' : esc_html( $row['open'] . ' - ' . $row['close'] );
									break;
								}
							}
						}
					?>
						<article class="va-card va-card--horizontal">
							<div class="va-card__image">
								<?php if ( $hero_image ) : ?>
									<?php echo wp_get_attachment_image( $hero_image['id'], 'va-card-thumb', false, array( 'class' => 'va-card__img', 'loading' => 'lazy' ) ); ?>
								<?php else : ?>
									<div class="va-card__image--placeholder" style="width:100%;height:100%;"></div>
								<?php endif; ?>
								<?php if ( $cat_name ) : ?>
									<span class="va-card__cat-pill">
										<span class="va-card__cat-pill-dot" style="background: var(--wp--preset--color--accent);"></span>
										<?php echo esc_html( $cat_name ); ?>
									</span>
								<?php endif; ?>
							</div>
							<div class="va-card__body">
								<h3 class="va-card__title"><?php echo esc_html( $business_name ?: get_the_title() ); ?></h3>
								<?php if ( $tagline ) : ?>
									<p class="va-card__desc"><?php echo esc_html( $tagline ); ?></p>
								<?php endif; ?>
								<hr class="va-card__divider" />
								<div class="va-card__meta-row">
									<?php if ( $address ) : ?>
										<span class="va-card__meta-item">
											<svg class="va-card__meta-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="3"/></svg>
											<?php echo esc_html( $address ); ?>
										</span>
									<?php endif; ?>
									<?php if ( $hours_display ) : ?>
										<span class="va-card__meta-item">
											<svg class="va-card__meta-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
											<?php echo esc_html( $hours_display ); ?>
										</span>
									<?php endif; ?>
								</div>
								<a href="<?php echo esc_url( get_permalink() ); ?>" class="va-card__cta <?php echo esc_attr( $cta_class ); ?>">
									<?php esc_html_e( 'View details', 'visitaylesbury' ); ?>
								</a>
							</div>
						</article>
					<?php
						$card_index++;
					endwhile;
					?>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
	</section>

	<!-- 5. What's On — experiences scroll row -->
	<section class="va-section">
		<div class="va-container">
			<div class="va-section-header">
				<h2 class="va-section-header__title"><?php esc_html_e( "What's On", 'visitaylesbury' ); ?></h2>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>" class="va-section-header__btn">
					<?php esc_html_e( 'All events', 'visitaylesbury' ); ?>
				</a>
			</div>

			<?php
			$events = new WP_Query( array(
				'post_type'      => 'event',
				'posts_per_page' => 6,
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
				<div class="va-xp-scroll">
					<button class="va-xp-scroll__nav va-xp-scroll__nav--prev" aria-label="<?php esc_attr_e( 'Previous', 'visitaylesbury' ); ?>">&larr;</button>
					<button class="va-xp-scroll__nav va-xp-scroll__nav--next" aria-label="<?php esc_attr_e( 'Next', 'visitaylesbury' ); ?>">&rarr;</button>
					<div class="va-xp-scroll__track">
						<?php while ( $events->have_posts() ) : $events->the_post();
							$event_id    = get_the_ID();
							$event_name  = get_field( 'event_name', $event_id );
							$description = wp_strip_all_tags( get_field( 'description', $event_id ) );
							$venue       = get_field( 'venue_name', $event_id );
							$address     = get_field( 'address', $event_id );
							$hero_image  = get_field( 'hero_image', $event_id );
							$location    = $venue ?: $address;
						?>
							<a href="<?php echo esc_url( get_permalink() ); ?>" class="va-xp-scroll__card">
								<div class="va-xp-scroll__img">
									<?php if ( $hero_image ) : ?>
										<?php echo wp_get_attachment_image( $hero_image['id'], 'va-card-thumb', false, array( 'loading' => 'lazy' ) ); ?>
									<?php else : ?>
										<div class="va-card__image--placeholder" style="width:100%;height:100%;"></div>
									<?php endif; ?>
								</div>
								<div class="va-xp-scroll__body">
									<h3 class="va-xp-scroll__title"><?php echo esc_html( $event_name ?: get_the_title() ); ?></h3>
									<?php if ( $description ) : ?>
										<p class="va-xp-scroll__desc"><?php echo esc_html( wp_trim_words( $description, 15, '...' ) ); ?></p>
									<?php endif; ?>
									<hr class="va-xp-scroll__divider" />
									<?php if ( $location ) : ?>
										<div class="va-xp-scroll__address">
											<svg class="va-xp-scroll__address-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="3"/></svg>
											<?php echo esc_html( $location ); ?>
										</div>
									<?php endif; ?>
									<span class="va-xp-scroll__cta"><?php esc_html_e( 'View details', 'visitaylesbury' ); ?></span>
								</div>
							</a>
						<?php endwhile; ?>
					</div>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
	</section>

	<!-- 6. Newsletter mid-page CTA -->
	<section class="va-section" id="va-newsletter-cta">
		<div class="va-container">
			<div class="va-newsletter-cta">
				<div class="va-newsletter-cta__illustration"></div>
				<div class="va-newsletter-cta__content">
					<h2><?php esc_html_e( 'Get the best of Aylesbury in your inbox', 'visitaylesbury' ); ?></h2>
					<p><?php esc_html_e( 'Weekly picks, new openings, upcoming events, and exclusive local offers delivered every Friday.', 'visitaylesbury' ); ?></p>
					<form class="va-newsletter-cta__form">
						<input type="email" class="va-newsletter-cta__input" placeholder="<?php esc_attr_e( 'Your email address', 'visitaylesbury' ); ?>" required />
						<button type="submit" class="va-newsletter-cta__btn"><?php esc_html_e( 'Subscribe', 'visitaylesbury' ); ?></button>
					</form>
				</div>
			</div>
		</div>
	</section>

	<!-- 7. Browse Articles & News -->
	<section class="va-section">
		<div class="va-container">
			<div class="va-section-header">
				<h2 class="va-section-header__title"><?php esc_html_e( 'Browse articles and news', 'visitaylesbury' ); ?></h2>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'guide' ) ); ?>" class="va-section-header__btn">
					<?php esc_html_e( 'Browse all articles', 'visitaylesbury' ); ?>
				</a>
			</div>

			<?php
			$articles = new WP_Query( array(
				'post_type'      => array( 'guide', 'post' ),
				'posts_per_page' => 3,
				'post_status'    => 'publish',
			) );
			?>

			<?php if ( $articles->have_posts() ) : ?>
				<div class="va-grid va-grid--3">
					<?php while ( $articles->have_posts() ) : $articles->the_post();
						$art_id     = get_the_ID();
						$hero_image = get_field( 'hero_image', $art_id );
						$post_type  = get_post_type();
						$excerpt    = get_the_excerpt();

						if ( $post_type === 'guide' ) {
							$guide_types = get_the_terms( $art_id, 'guide_type' );
							$cat_label   = ( $guide_types && ! is_wp_error( $guide_types ) ) ? $guide_types[0]->name : 'Guide';
							$dot_color   = 'var(--wp--preset--color--teal)';
						} else {
							$post_cats = get_the_category( $art_id );
							$cat_label = ! empty( $post_cats ) ? $post_cats[0]->name : 'News';
							$dot_color = 'var(--wp--preset--color--accent)';
						}
					?>
						<article class="va-card va-card--article">
							<a href="<?php echo esc_url( get_permalink() ); ?>" class="va-card__link">
								<div class="va-card__image">
									<?php if ( $hero_image ) : ?>
										<?php echo wp_get_attachment_image( $hero_image['id'], 'va-card-thumb', false, array( 'class' => 'va-card__img', 'loading' => 'lazy' ) ); ?>
									<?php elseif ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'va-card-thumb', array( 'class' => 'va-card__img', 'loading' => 'lazy' ) ); ?>
									<?php else : ?>
										<div class="va-card__image--placeholder"></div>
									<?php endif; ?>
								</div>
								<div class="va-card__body">
									<div class="va-card__top-row">
										<span class="va-card__cat-tag">
											<span style="width:6px;height:6px;border-radius:50%;background:<?php echo esc_attr( $dot_color ); ?>;display:inline-block;"></span>
											<?php echo esc_html( $cat_label ); ?>
										</span>
										<span class="va-card__date"><?php echo esc_html( get_the_date( 'M j, Y' ) ); ?></span>
									</div>
									<h3 class="va-card__title"><?php the_title(); ?></h3>
									<?php if ( $excerpt ) : ?>
										<p class="va-card__excerpt"><?php echo esc_html( wp_trim_words( $excerpt, 18, '...' ) ); ?></p>
									<?php endif; ?>
									<span class="va-card__read-more"><?php esc_html_e( 'Read more', 'visitaylesbury' ); ?> &rarr;</span>
								</div>
							</a>
						</article>
					<?php endwhile; ?>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
	</section>

	<!-- 8. Explore the Vale -->
	<section class="va-section">
		<div class="va-container">
			<div class="va-section-header">
				<h2 class="va-section-header__title"><?php esc_html_e( 'Explore the Vale', 'visitaylesbury' ); ?></h2>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'the-vale' ) ) ); ?>" class="va-section-header__btn">
					<?php esc_html_e( 'All villages', 'visitaylesbury' ); ?>
				</a>
			</div>

			<?php
			$featured_areas = new WP_Query( array(
				'post_type'      => 'area',
				'posts_per_page' => 3,
				'post_status'    => 'publish',
				'orderby'        => 'rand',
			) );
			?>

			<?php if ( $featured_areas->have_posts() ) : ?>
				<div class="va-grid va-grid--3">
					<?php while ( $featured_areas->have_posts() ) : $featured_areas->the_post(); ?>
						<?php get_template_part( 'template-parts/cards/card-area', null, array( 'post_id' => get_the_ID() ) ); ?>
					<?php endwhile; ?>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
	</section>

</main>

<?php
get_footer();
