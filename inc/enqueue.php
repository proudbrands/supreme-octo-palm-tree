<?php
/**
 * Script and style enqueueing.
 *
 * @package VisitAylesbury
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', 'va_enqueue_assets' );

function va_enqueue_assets() {
	wp_enqueue_style(
		'va-global',
		VA_THEME_URI . '/assets/css/global.css',
		array(),
		filemtime( VA_THEME_DIR . '/assets/css/global.css' )
	);

	wp_enqueue_style(
		'va-components',
		VA_THEME_URI . '/assets/css/components.css',
		array( 'va-global' ),
		filemtime( VA_THEME_DIR . '/assets/css/components.css' )
	);

	wp_enqueue_script(
		'va-navigation',
		VA_THEME_URI . '/assets/js/navigation.js',
		array(),
		filemtime( VA_THEME_DIR . '/assets/js/navigation.js' ),
		true
	);

	// Maps — Leaflet + plugins on pages that need them.
	if ( va_needs_map() ) {

		// Leaflet core.
		wp_enqueue_style(
			'leaflet',
			'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
			array(),
			'1.9.4'
		);

		wp_enqueue_script(
			'leaflet',
			'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
			array(),
			'1.9.4',
			true
		);

		// Leaflet-GPX plugin.
		wp_enqueue_script(
			'leaflet-gpx',
			'https://cdnjs.cloudflare.com/ajax/libs/leaflet-gpx/2.1.2/gpx.min.js',
			array( 'leaflet' ),
			'2.1.2',
			true
		);

		// Leaflet-Elevation plugin.
		wp_enqueue_style(
			'leaflet-elevation',
			'https://unpkg.com/@raruto/leaflet-elevation@2.5.0/dist/leaflet-elevation.css',
			array( 'leaflet' ),
			'2.5.0'
		);

		wp_enqueue_script(
			'leaflet-elevation',
			'https://unpkg.com/@raruto/leaflet-elevation@2.5.0/dist/leaflet-elevation.js',
			array( 'leaflet' ),
			'2.5.0',
			true
		);

		// Theme map script — depends on all of the above.
		wp_enqueue_script(
			'va-map',
			VA_THEME_URI . '/assets/js/map.js',
			array( 'leaflet', 'leaflet-gpx', 'leaflet-elevation' ),
			filemtime( VA_THEME_DIR . '/assets/js/map.js' ),
			true
		);
	}
}

/**
 * Determine whether the current page needs Leaflet maps.
 */
function va_needs_map() {
	return is_singular( array( 'listing', 'walk', 'area' ) )
		|| is_post_type_archive( 'listing' )
		|| is_front_page()
		|| is_page_template( 'page-the-vale.php' );
}
