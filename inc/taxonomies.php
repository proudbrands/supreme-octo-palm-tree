<?php
/**
 * Taxonomy registrations.
 *
 * @package VisitAylesbury
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'va_register_taxonomies' );

function va_register_taxonomies() {
	// Business Category — hierarchical (Eat & Drink > Restaurants).
	register_taxonomy( 'business_category', array( 'listing' ), array(
		'labels'       => va_tax_labels( 'Category', 'Categories' ),
		'hierarchical' => true,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'directory/category', 'hierarchical' => true ),
	) );

	// Area — flat (Town Centre, Old Town, Bedgrove, etc.).
	register_taxonomy( 'area_tax', array( 'listing', 'event', 'walk' ), array(
		'labels'       => va_tax_labels( 'Area', 'Areas' ),
		'hierarchical' => false,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'area' ),
	) );

	// Vale Village — flat (Waddesdon, Wendover, Haddenham, etc.).
	register_taxonomy( 'vale_village', array( 'listing', 'event', 'walk' ), array(
		'labels'       => va_tax_labels( 'Village', 'Villages' ),
		'hierarchical' => false,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'village' ),
	) );

	// Event Category — flat (Music, Theatre, Family, etc.).
	register_taxonomy( 'event_category', array( 'event' ), array(
		'labels'       => va_tax_labels( 'Event Category', 'Event Categories' ),
		'hierarchical' => false,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'events/category' ),
	) );

	// Food Subcategory — flat (used for Eat & Drink filtering).
	register_taxonomy( 'food_subcategory', array( 'listing' ), array(
		'labels'       => va_tax_labels( 'Food & Drink Type', 'Food & Drink Types' ),
		'hierarchical' => false,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'directory/food-drink' ),
	) );

	// Guide Type — flat (Visitor, Seasonal, Living, Business, Audience).
	register_taxonomy( 'guide_type', array( 'guide' ), array(
		'labels'       => va_tax_labels( 'Guide Type', 'Guide Types' ),
		'hierarchical' => false,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'guides/type' ),
	) );
}

/**
 * Generate standard taxonomy labels.
 *
 * @param string $singular Singular name.
 * @param string $plural   Plural name.
 * @return array
 */
function va_tax_labels( $singular, $plural ) {
	return array(
		'name'              => $plural,
		'singular_name'     => $singular,
		'search_items'      => "Search {$plural}",
		'all_items'         => "All {$plural}",
		'parent_item'       => "Parent {$singular}",
		'parent_item_colon' => "Parent {$singular}:",
		'edit_item'         => "Edit {$singular}",
		'update_item'       => "Update {$singular}",
		'add_new_item'      => "Add New {$singular}",
		'new_item_name'     => "New {$singular} Name",
		'not_found'         => "No {$plural} found",
	);
}
