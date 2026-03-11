<?php
/**
 * Custom Post Type registrations.
 *
 * @package VisitAylesbury
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'va_register_cpts' );

function va_register_cpts() {
	// Listing.
	register_post_type( 'listing', array(
		'labels'       => va_cpt_labels( 'Listing', 'Listings' ),
		'public'       => true,
		'has_archive'  => true,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-store',
		'supports'     => array( 'title', 'thumbnail' ),
		'rewrite'      => array( 'slug' => 'directory' ),
	) );

	// Event.
	register_post_type( 'event', array(
		'labels'       => va_cpt_labels( 'Event', 'Events' ),
		'public'       => true,
		'has_archive'  => true,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-calendar-alt',
		'supports'     => array( 'title', 'thumbnail' ),
		'rewrite'      => array( 'slug' => 'events' ),
	) );

	// Walk.
	register_post_type( 'walk', array(
		'labels'       => va_cpt_labels( 'Walk', 'Walks' ),
		'public'       => true,
		'has_archive'  => true,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-location-alt',
		'supports'     => array( 'title', 'editor', 'thumbnail' ),
		'rewrite'      => array( 'slug' => 'walk' ),
	) );

	// Area.
	register_post_type( 'area', array(
		'labels'       => va_cpt_labels( 'Area', 'Areas' ),
		'public'       => true,
		'has_archive'  => true,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-admin-site-alt3',
		'supports'     => array( 'title', 'thumbnail' ),
		'rewrite'      => array( 'slug' => 'areas' ),
	) );

	// Guide.
	register_post_type( 'guide', array(
		'labels'       => va_cpt_labels( 'Guide', 'Guides' ),
		'public'       => true,
		'has_archive'  => false,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-book',
		'supports'     => array( 'title', 'editor', 'thumbnail' ),
		'rewrite'      => array( 'slug' => 'guides' ),
	) );
}

/**
 * Generate standard CPT labels.
 *
 * @param string $singular Singular name.
 * @param string $plural   Plural name.
 * @return array
 */
function va_cpt_labels( $singular, $plural ) {
	return array(
		'name'               => $plural,
		'singular_name'      => $singular,
		'add_new'            => 'Add New',
		'add_new_item'       => "Add New {$singular}",
		'edit_item'          => "Edit {$singular}",
		'new_item'           => "New {$singular}",
		'view_item'          => "View {$singular}",
		'view_items'         => "View {$plural}",
		'search_items'       => "Search {$plural}",
		'not_found'          => "No {$plural} found",
		'not_found_in_trash' => "No {$plural} found in Trash",
		'all_items'          => "All {$plural}",
		'archives'           => "{$singular} Archives",
	);
}
