<?php
/**
 * JSON-LD Schema output functions.
 *
 * All Schema output as JSON-LD in wp_head.
 * RankMath handles basic page/post Schema. These are for CPT-specific Schema.
 *
 * @package VisitAylesbury
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_head', 'va_listing_schema' );
add_action( 'wp_head', 'va_event_schema' );
add_action( 'wp_head', 'va_walk_schema' );

/**
 * LocalBusiness Schema for listings.
 *
 * Uses most specific subtype where possible:
 * Restaurant, BarOrPub, CafeOrCoffeeShop, LodgingBusiness, Store, etc.
 */
function va_listing_schema() {
	if ( ! is_singular( 'listing' ) ) {
		return;
	}

	$id          = get_the_ID();
	$name        = get_field( 'business_name', $id );
	$description = wp_strip_all_tags( get_field( 'description', $id ) );
	$address     = get_field( 'address', $id );
	$postcode    = get_field( 'postcode', $id );
	$phone       = get_field( 'phone', $id );
	$website     = get_field( 'website', $id );
	$price       = get_field( 'price_range', $id );
	$lat         = get_field( 'latitude', $id );
	$lng         = get_field( 'longitude', $id );
	$hero        = get_field( 'hero_image', $id );
	$hours       = get_field( 'opening_hours', $id );

	// Determine @type from primary business category.
	$cats = get_the_terms( $id, 'business_category' );
	$type = 'LocalBusiness';

	if ( $cats && ! is_wp_error( $cats ) ) {
		$cat_slug = $cats[0]->slug;
		$type_map = array(
			'restaurants'   => 'Restaurant',
			'pubs'          => 'BarOrPub',
			'cafes'         => 'CafeOrCoffeeShop',
			'hotels'        => 'LodgingBusiness',
			'health-beauty' => 'HealthAndBeautyBusiness',
			'shops'         => 'Store',
			'solicitors'    => 'LegalService',
			'accountants'   => 'AccountingService',
		);

		if ( isset( $type_map[ $cat_slug ] ) ) {
			$type = $type_map[ $cat_slug ];
		}
	}

	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => $type,
		'name'        => $name,
		'description' => $description,
		'url'         => get_permalink( $id ),
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $address,
			'postalCode'      => $postcode,
			'addressLocality' => 'Aylesbury',
			'addressRegion'   => 'Buckinghamshire',
			'addressCountry'  => 'GB',
		),
	);

	if ( $phone ) {
		$schema['telephone'] = $phone;
	}
	if ( $website ) {
		$schema['sameAs'] = $website;
	}
	if ( $price ) {
		$schema['priceRange'] = $price;
	}
	if ( $hero ) {
		$schema['image'] = $hero['url'];
	}

	if ( $lat && $lng ) {
		$schema['geo'] = array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => $lat,
			'longitude' => $lng,
		);
	}

	if ( $hours && is_array( $hours ) ) {
		$opening = array();
		foreach ( $hours as $row ) {
			if ( ! empty( $row['closed'] ) ) {
				continue;
			}
			$opening[] = array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => $row['day'],
				'opens'     => $row['open'],
				'closes'    => $row['close'],
			);
		}
		if ( ! empty( $opening ) ) {
			$schema['openingHoursSpecification'] = $opening;
		}
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
}

/**
 * Event Schema for events.
 */
function va_event_schema() {
	if ( ! is_singular( 'event' ) ) {
		return;
	}

	$id    = get_the_ID();
	$name  = get_field( 'event_name', $id );
	$desc  = wp_strip_all_tags( get_field( 'description', $id ) );
	$start = get_field( 'start_date', $id );
	$end   = get_field( 'end_date', $id );
	$stime = get_field( 'start_time', $id );
	$etime = get_field( 'end_time', $id );
	$venue = get_field( 'venue_name', $id );
	$addr  = get_field( 'address', $id );
	$price = get_field( 'price', $id );
	$free  = get_field( 'is_free', $id );
	$url   = get_field( 'ticket_url', $id );
	$hero  = get_field( 'hero_image', $id );
	$org   = get_field( 'organiser_name', $id );

	$start_dt = date( 'Y-m-d', strtotime( $start ) );
	if ( $stime ) {
		$start_dt .= 'T' . $stime;
	}

	$end_dt = $end ? date( 'Y-m-d', strtotime( $end ) ) : $start_dt;
	if ( $etime ) {
		$end_dt .= 'T' . $etime;
	}

	$schema = array(
		'@context'  => 'https://schema.org',
		'@type'     => 'Event',
		'name'      => $name,
		'startDate' => $start_dt,
		'endDate'   => $end_dt,
		'url'       => get_permalink( $id ),
	);

	if ( $desc ) {
		$schema['description'] = $desc;
	}
	if ( $hero ) {
		$schema['image'] = $hero['url'];
	}

	if ( $venue || $addr ) {
		$schema['location'] = array(
			'@type'   => 'Place',
			'name'    => $venue ? $venue : 'Aylesbury',
			'address' => array(
				'@type'           => 'PostalAddress',
				'streetAddress'   => $addr,
				'addressLocality' => 'Aylesbury',
				'addressCountry'  => 'GB',
			),
		);
	}

	if ( $free ) {
		$schema['isAccessibleForFree'] = true;
	}

	if ( $url ) {
		$schema['offers'] = array(
			'@type'         => 'Offer',
			'url'           => $url,
			'price'         => $free ? '0' : $price,
			'priceCurrency' => 'GBP',
			'availability'  => 'https://schema.org/InStock',
		);
	}

	if ( $org ) {
		$schema['organizer'] = array(
			'@type' => 'Organization',
			'name'  => $org,
		);
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
}

/**
 * TouristAttraction Schema for walks.
 */
function va_walk_schema() {
	if ( ! is_singular( 'walk' ) ) {
		return;
	}

	$id       = get_the_ID();
	$name     = get_field( 'walk_name', $id );
	$desc     = wp_strip_all_tags( get_field( 'description', $id ) );
	$distance = get_field( 'distance_miles', $id );
	$time     = get_field( 'estimated_time', $id );
	$lat      = get_field( 'start_lat', $id );
	$lng      = get_field( 'start_lng', $id );
	$hero     = get_field( 'hero_image', $id );

	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'TouristAttraction',
		'name'        => $name,
		'description' => $desc,
		'url'         => get_permalink( $id ),
		'touristType' => 'Walking',
	);

	if ( $hero ) {
		$schema['image'] = $hero['url'];
	}

	if ( $lat && $lng ) {
		$schema['geo'] = array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => $lat,
			'longitude' => $lng,
		);
	}

	$schema['isAccessibleForFree'] = true;

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
}
