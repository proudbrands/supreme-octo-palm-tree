<?php
/**
 * Mega Menu Navigation
 *
 * Hardcoded navigation with mega menu dropdowns for Things to Do,
 * The Vale, and Guides. Desktop uses hover panels, mobile uses
 * slide-in drawer with accordions.
 *
 * @package VisitAylesbury
 */

defined( 'ABSPATH' ) || exit;
?>

<header class="va-header" id="va-header">
	<div class="va-header__inner">

		<!-- Logo -->
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="va-header__logo">aylesbury.town</a>

		<!-- Desktop nav -->
		<nav class="va-header__nav" aria-label="<?php esc_attr_e( 'Main navigation', 'visitaylesbury' ); ?>">
			<ul class="va-nav">

				<li class="va-nav__item">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="va-nav__link">Home</a>
				</li>

				<!-- Things to Do — has mega dropdown -->
				<li class="va-nav__item va-nav__item--has-mega" data-mega="things-to-do">
					<button class="va-nav__link va-nav__link--toggle" aria-expanded="false" aria-haspopup="true">
						Things to Do
						<svg class="va-nav__chevron" width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</button>
				</li>

				<li class="va-nav__item">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>" class="va-nav__link">Events</a>
				</li>

				<li class="va-nav__item">
					<?php
					$food_page = get_page_by_path( 'food-and-drink' );
					$food_url  = $food_page ? get_permalink( $food_page ) : home_url( '/food-and-drink/' );
					?>
					<a href="<?php echo esc_url( $food_url ); ?>" class="va-nav__link">Food &amp; Drink</a>
				</li>

				<!-- The Vale — has mega dropdown -->
				<li class="va-nav__item va-nav__item--has-mega" data-mega="the-vale">
					<button class="va-nav__link va-nav__link--toggle" aria-expanded="false" aria-haspopup="true">
						The Vale
						<svg class="va-nav__chevron" width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</button>
				</li>

				<li class="va-nav__item">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'listing' ) ); ?>" class="va-nav__link">Directory</a>
				</li>

				<!-- Guides — has mega dropdown -->
				<li class="va-nav__item va-nav__item--has-mega" data-mega="guides">
					<button class="va-nav__link va-nav__link--toggle" aria-expanded="false" aria-haspopup="true">
						Guides
						<svg class="va-nav__chevron" width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</button>
				</li>

			</ul>

			<!-- CTA button -->
			<a href="<?php echo esc_url( home_url( '/add-your-business/' ) ); ?>" class="va-header__cta">Add Your Business</a>
		</nav>

		<!-- Mobile hamburger -->
		<button class="va-header__burger" id="va-burger" aria-label="<?php esc_attr_e( 'Open menu', 'visitaylesbury' ); ?>" aria-expanded="false" aria-controls="va-mobile-menu">
			<span class="va-header__burger-line"></span>
			<span class="va-header__burger-line"></span>
			<span class="va-header__burger-line"></span>
		</button>

	</div>

	<!-- Mega menu panels (desktop) -->
	<div class="va-mega" id="va-mega-things-to-do" aria-hidden="true">
		<div class="va-mega__inner va-mega__inner--3col">

			<!-- Column 1: Explore -->
			<div class="va-mega__col">
				<h3 class="va-mega__heading">Explore</h3>
				<ul class="va-mega__list">
					<?php
					$things_page = get_page_by_path( 'things-to-do' );
					$things_url  = $things_page ? get_permalink( $things_page ) : home_url( '/things-to-do/' );
					?>
					<li><a href="<?php echo esc_url( $things_url ); ?>" class="va-mega__link">Things to Do Today</a></li>
					<li><a href="<?php echo esc_url( $things_url ); ?>?when=weekend" class="va-mega__link">Things to Do This Weekend</a></li>
					<li><a href="<?php echo esc_url( $things_url ); ?>?price=free" class="va-mega__link">Free Things to Do</a></li>
					<li><a href="<?php echo esc_url( $things_url ); ?>?audience=families" class="va-mega__link">Family Activities</a></li>
					<li><a href="<?php echo esc_url( $things_url ); ?>?type=indoor" class="va-mega__link">Indoor Activities</a></li>
					<?php
					$vale_page  = get_page_by_path( 'the-vale' );
					$walks_page = get_page_by_path( 'the-vale/walks' );
					$walks_url  = $walks_page ? get_permalink( $walks_page ) : home_url( '/the-vale/walks/' );
					?>
					<li><a href="<?php echo esc_url( $walks_url ); ?>" class="va-mega__link">Outdoors &amp; Walks</a></li>
					<?php
					$arts_term = get_term_by( 'slug', 'arts-culture', 'business_category' );
					$arts_url  = $arts_term ? get_term_link( $arts_term ) : home_url( '/directory/' );
					?>
					<li><a href="<?php echo esc_url( $arts_url ); ?>" class="va-mega__link">Arts &amp; Culture</a></li>
					<?php
					$shopping_term = get_term_by( 'slug', 'shopping', 'business_category' );
					$shopping_url  = $shopping_term ? get_term_link( $shopping_term ) : home_url( '/directory/' );
					?>
					<li><a href="<?php echo esc_url( $shopping_url ); ?>" class="va-mega__link">Shopping</a></li>
					<li><a href="<?php echo esc_url( $things_url ); ?>?type=attractions" class="va-mega__link">Attractions</a></li>
				</ul>
			</div>

			<!-- Column 2: Popular -->
			<div class="va-mega__col">
				<h3 class="va-mega__heading">Popular</h3>
				<ul class="va-mega__list">
					<?php
					$popular_items = array(
						'aylesbury-waterside-theatre' => 'Aylesbury Waterside Theatre',
						'discover-bucks-museum'       => 'Discover Bucks Museum',
						'waddesdon-manor'             => 'Waddesdon Manor',
						'wendover-woods'              => 'Wendover Woods',
						'david-bowie-statue'          => 'David Bowie Statue',
					);
					foreach ( $popular_items as $slug => $label ) :
						$popular_post = get_page_by_path( $slug, OBJECT, array( 'listing', 'guide', 'area' ) );
						$popular_url  = $popular_post ? get_permalink( $popular_post ) : home_url( '/directory/' );
					?>
						<li><a href="<?php echo esc_url( $popular_url ); ?>" class="va-mega__link"><?php echo esc_html( $label ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<!-- Column 3: Featured card -->
			<div class="va-mega__col va-mega__col--featured">
				<?php
				$featured_guide = get_page_by_path( 'visit-aylesbury', OBJECT, 'guide' );
				if ( $featured_guide ) :
					$fg_id    = $featured_guide->ID;
					$fg_image = get_field( 'hero_image', $fg_id );
					$fg_img_id = $fg_image ? $fg_image['id'] : get_post_thumbnail_id( $fg_id );
				?>
					<a href="<?php echo esc_url( get_permalink( $fg_id ) ); ?>" class="va-mega-card">
						<?php if ( $fg_img_id ) : ?>
							<div class="va-mega-card__image">
								<?php echo wp_get_attachment_image( $fg_img_id, 'va-card-thumb', false, array( 'class' => 'va-mega-card__img' ) ); ?>
							</div>
						<?php endif; ?>
						<div class="va-mega-card__body">
							<span class="va-mega-card__label">Featured Guide</span>
							<h4 class="va-mega-card__title"><?php echo esc_html( get_the_title( $fg_id ) ); ?></h4>
							<span class="va-mega-card__action">Read guide &rarr;</span>
						</div>
					</a>
				<?php else : ?>
					<div class="va-mega-card va-mega-card--placeholder">
						<div class="va-mega-card__body">
							<span class="va-mega-card__label">Featured Guide</span>
							<h4 class="va-mega-card__title">Visit Aylesbury</h4>
							<span class="va-mega-card__action">Coming soon</span>
						</div>
					</div>
				<?php endif; ?>
			</div>

		</div>
	</div>

	<div class="va-mega" id="va-mega-the-vale" aria-hidden="true">
		<div class="va-mega__inner va-mega__inner--3col">

			<!-- Column 1: Villages -->
			<div class="va-mega__col">
				<h3 class="va-mega__heading">Villages</h3>
				<ul class="va-mega__list">
					<?php
					$villages = array(
						'waddesdon'         => 'Waddesdon',
						'wendover'          => 'Wendover',
						'haddenham'         => 'Haddenham',
						'brill'             => 'Brill',
						'long-crendon'      => 'Long Crendon',
						'quainton'          => 'Quainton',
						'weston-turville'   => 'Weston Turville',
						'stoke-mandeville'  => 'Stoke Mandeville',
					);
					foreach ( $villages as $slug => $label ) :
						$area_post = get_page_by_path( $slug, OBJECT, 'area' );
						$area_url  = $area_post ? get_permalink( $area_post ) : home_url( '/the-vale/' );
					?>
						<li><a href="<?php echo esc_url( $area_url ); ?>" class="va-mega__link"><?php echo esc_html( $label ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<!-- Column 2: Explore the Vale -->
			<div class="va-mega__col">
				<h3 class="va-mega__heading">Explore the Vale</h3>
				<ul class="va-mega__list">
					<li><a href="<?php echo esc_url( $walks_url ); ?>" class="va-mega__link">Walks &amp; Countryside</a></li>
					<?php
					$day_trips_from = get_page_by_path( 'day-trips-from-aylesbury', OBJECT, 'guide' );
					$day_trips_to   = get_page_by_path( 'day-trips-to-aylesbury', OBJECT, 'guide' );
					$vale_map_url   = $vale_page ? get_permalink( $vale_page ) . '#vale-map' : home_url( '/the-vale/#vale-map' );
					?>
					<li><a href="<?php echo esc_url( $day_trips_from ? get_permalink( $day_trips_from ) : $things_url ); ?>" class="va-mega__link">Day Trips from Aylesbury</a></li>
					<li><a href="<?php echo esc_url( $day_trips_to ? get_permalink( $day_trips_to ) : $things_url ); ?>" class="va-mega__link">Day Trips to Aylesbury</a></li>
					<li><a href="<?php echo esc_url( $vale_map_url ); ?>" class="va-mega__link">Vale Map</a></li>
				</ul>
			</div>

			<!-- Column 3: Featured area -->
			<div class="va-mega__col va-mega__col--featured">
				<?php
				$featured_area = get_page_by_path( 'waddesdon', OBJECT, 'area' );
				if ( ! $featured_area ) {
					$featured_area = get_posts( array( 'post_type' => 'area', 'posts_per_page' => 1, 'post_status' => 'publish' ) );
					$featured_area = $featured_area ? $featured_area[0] : null;
				}
				if ( $featured_area ) :
					$fa_id     = $featured_area->ID;
					$fa_image  = get_field( 'hero_image', $fa_id );
					$fa_img_id = $fa_image ? $fa_image['id'] : get_post_thumbnail_id( $fa_id );
					$fa_name   = get_field( 'area_name', $fa_id ) ?: get_the_title( $fa_id );
				?>
					<a href="<?php echo esc_url( get_permalink( $fa_id ) ); ?>" class="va-mega-card">
						<?php if ( $fa_img_id ) : ?>
							<div class="va-mega-card__image">
								<?php echo wp_get_attachment_image( $fa_img_id, 'va-card-thumb', false, array( 'class' => 'va-mega-card__img' ) ); ?>
							</div>
						<?php endif; ?>
						<div class="va-mega-card__body">
							<span class="va-mega-card__label">Featured Village</span>
							<h4 class="va-mega-card__title"><?php echo esc_html( $fa_name ); ?></h4>
							<span class="va-mega-card__action">Explore &rarr;</span>
						</div>
					</a>
				<?php endif; ?>
			</div>

		</div>
	</div>

	<div class="va-mega" id="va-mega-guides" aria-hidden="true">
		<div class="va-mega__inner va-mega__inner--2col">

			<!-- Column 1: Visitor Guides -->
			<div class="va-mega__col">
				<h3 class="va-mega__heading">Visitor Guides</h3>
				<ul class="va-mega__list">
					<?php
					$visitor_guides = array(
						'visit-aylesbury'             => 'Visit Aylesbury',
						'getting-here-and-around'     => 'Getting Here &amp; Around',
						'aylesbury-for-families'      => 'Aylesbury for Families',
						'aylesbury-for-foodies'       => 'Aylesbury for Foodies',
						'aylesbury-for-dog-owners'    => 'Aylesbury for Dog Owners',
					);
					foreach ( $visitor_guides as $slug => $label ) :
						$guide_post = get_page_by_path( $slug, OBJECT, 'guide' );
						$guide_url  = $guide_post ? get_permalink( $guide_post ) : home_url( '/guides/' );
					?>
						<li><a href="<?php echo esc_url( $guide_url ); ?>" class="va-mega__link"><?php echo $label; ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<!-- Column 2: Living & Business -->
			<div class="va-mega__col">
				<h3 class="va-mega__heading">Living &amp; Business</h3>
				<ul class="va-mega__list">
					<?php
					$living_guides = array(
						'living-in-aylesbury'                  => 'Living in Aylesbury',
						'aylesbury-for-commuters'              => 'Aylesbury for Commuters',
						'business-in-aylesbury'                => 'Business in Aylesbury',
						'best-market-towns-buckinghamshire'    => 'Best Market Towns Buckinghamshire',
					);
					foreach ( $living_guides as $slug => $label ) :
						$guide_post = get_page_by_path( $slug, OBJECT, 'guide' );
						$guide_url  = $guide_post ? get_permalink( $guide_post ) : home_url( '/guides/' );
					?>
						<li><a href="<?php echo esc_url( $guide_url ); ?>" class="va-mega__link"><?php echo esc_html( $label ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

		</div>
	</div>

</header>

<!-- Mobile menu overlay + drawer -->
<div class="va-mobile-overlay" id="va-mobile-overlay" aria-hidden="true"></div>

<nav class="va-mobile-drawer" id="va-mobile-menu" aria-label="<?php esc_attr_e( 'Mobile navigation', 'visitaylesbury' ); ?>" aria-hidden="true">
	<ul class="va-mobile-nav">

		<li class="va-mobile-nav__item">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="va-mobile-nav__link">Home</a>
		</li>

		<li class="va-mobile-nav__item va-mobile-nav__item--has-children">
			<button class="va-mobile-nav__link va-mobile-nav__link--parent" aria-expanded="false">
				Things to Do
				<span class="va-mobile-nav__icon">+</span>
			</button>
			<ul class="va-mobile-nav__sub">
				<li><a href="<?php echo esc_url( $things_url ); ?>">Things to Do Today</a></li>
				<li><a href="<?php echo esc_url( $things_url ); ?>?when=weekend">This Weekend</a></li>
				<li><a href="<?php echo esc_url( $things_url ); ?>?price=free">Free Things to Do</a></li>
				<li><a href="<?php echo esc_url( $things_url ); ?>?audience=families">Family Activities</a></li>
				<li><a href="<?php echo esc_url( $things_url ); ?>?type=indoor">Indoor Activities</a></li>
				<li><a href="<?php echo esc_url( $walks_url ); ?>">Outdoors &amp; Walks</a></li>
				<li><a href="<?php echo esc_url( $arts_url ); ?>">Arts &amp; Culture</a></li>
				<li><a href="<?php echo esc_url( $shopping_url ); ?>">Shopping</a></li>
			</ul>
		</li>

		<li class="va-mobile-nav__item">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>" class="va-mobile-nav__link">Events</a>
		</li>

		<li class="va-mobile-nav__item">
			<a href="<?php echo esc_url( $food_url ); ?>" class="va-mobile-nav__link">Food &amp; Drink</a>
		</li>

		<li class="va-mobile-nav__item va-mobile-nav__item--has-children">
			<button class="va-mobile-nav__link va-mobile-nav__link--parent" aria-expanded="false">
				The Vale
				<span class="va-mobile-nav__icon">+</span>
			</button>
			<ul class="va-mobile-nav__sub">
				<?php foreach ( $villages as $slug => $label ) :
					$area_post = get_page_by_path( $slug, OBJECT, 'area' );
					$area_url  = $area_post ? get_permalink( $area_post ) : home_url( '/the-vale/' );
				?>
					<li><a href="<?php echo esc_url( $area_url ); ?>"><?php echo esc_html( $label ); ?></a></li>
				<?php endforeach; ?>
				<li><a href="<?php echo esc_url( $walks_url ); ?>">Walks &amp; Countryside</a></li>
			</ul>
		</li>

		<li class="va-mobile-nav__item">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'listing' ) ); ?>" class="va-mobile-nav__link">Directory</a>
		</li>

		<li class="va-mobile-nav__item va-mobile-nav__item--has-children">
			<button class="va-mobile-nav__link va-mobile-nav__link--parent" aria-expanded="false">
				Guides
				<span class="va-mobile-nav__icon">+</span>
			</button>
			<ul class="va-mobile-nav__sub">
				<?php foreach ( $visitor_guides as $slug => $label ) :
					$guide_post = get_page_by_path( $slug, OBJECT, 'guide' );
					$guide_url  = $guide_post ? get_permalink( $guide_post ) : home_url( '/guides/' );
				?>
					<li><a href="<?php echo esc_url( $guide_url ); ?>"><?php echo $label; ?></a></li>
				<?php endforeach; ?>
				<?php foreach ( $living_guides as $slug => $label ) :
					$guide_post = get_page_by_path( $slug, OBJECT, 'guide' );
					$guide_url  = $guide_post ? get_permalink( $guide_post ) : home_url( '/guides/' );
				?>
					<li><a href="<?php echo esc_url( $guide_url ); ?>"><?php echo esc_html( $label ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</li>

	</ul>

	<div class="va-mobile-nav__cta">
		<a href="<?php echo esc_url( home_url( '/add-your-business/' ) ); ?>" class="va-btn">Add Your Business</a>
	</div>
</nav>
