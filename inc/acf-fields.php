<?php
/**
 * ACF field group registrations.
 *
 * @package VisitAylesbury
 */

defined( 'ABSPATH' ) || exit;

add_action( 'acf/init', 'va_register_acf_fields' );

function va_register_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	va_register_listing_fields();
	va_register_event_fields();
	va_register_walk_fields();
	va_register_area_fields();
	va_register_guide_fields();
}

/**
 * Listing fields.
 */
function va_register_listing_fields() {
	acf_add_local_field_group( array(
		'key'      => 'group_listing',
		'title'    => 'Listing Details',
		'fields'   => array(
			array(
				'key'      => 'field_listing_business_name',
				'label'    => 'Business Name',
				'name'     => 'business_name',
				'type'     => 'text',
				'required' => 1,
			),
			array(
				'key'       => 'field_listing_tagline',
				'label'     => 'Tagline',
				'name'      => 'tagline',
				'type'      => 'text',
				'maxlength' => 120,
			),
			array(
				'key'   => 'field_listing_description',
				'label' => 'Description',
				'name'  => 'description',
				'type'  => 'wysiwyg',
			),
			array(
				'key'           => 'field_listing_logo',
				'label'         => 'Logo',
				'name'          => 'logo',
				'type'          => 'image',
				'return_format' => 'array',
				'preview_size'  => 'thumbnail',
			),
			array(
				'key'           => 'field_listing_hero_image',
				'label'         => 'Hero Image',
				'name'          => 'hero_image',
				'type'          => 'image',
				'return_format' => 'array',
				'preview_size'  => 'medium',
			),
			array(
				'key'           => 'field_listing_gallery',
				'label'         => 'Gallery',
				'name'          => 'gallery',
				'type'          => 'gallery',
				'return_format' => 'array',
				'preview_size'  => 'thumbnail',
			),
			array(
				'key'   => 'field_listing_address',
				'label' => 'Address',
				'name'  => 'address',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_listing_postcode',
				'label' => 'Postcode',
				'name'  => 'postcode',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_listing_latitude',
				'label' => 'Latitude',
				'name'  => 'latitude',
				'type'  => 'number',
				'step'  => 'any',
			),
			array(
				'key'   => 'field_listing_longitude',
				'label' => 'Longitude',
				'name'  => 'longitude',
				'type'  => 'number',
				'step'  => 'any',
			),
			array(
				'key'   => 'field_listing_phone',
				'label' => 'Phone',
				'name'  => 'phone',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_listing_email',
				'label' => 'Email',
				'name'  => 'email',
				'type'  => 'email',
			),
			array(
				'key'   => 'field_listing_website',
				'label' => 'Website',
				'name'  => 'website',
				'type'  => 'url',
			),
			array(
				'key'        => 'field_listing_social_links',
				'label'      => 'Social Links',
				'name'       => 'social_links',
				'type'       => 'repeater',
				'layout'     => 'table',
				'sub_fields' => array(
					array(
						'key'     => 'field_listing_social_platform',
						'label'   => 'Platform',
						'name'    => 'platform',
						'type'    => 'select',
						'choices' => array(
							'facebook'  => 'Facebook',
							'instagram' => 'Instagram',
							'twitter'   => 'X / Twitter',
							'tiktok'    => 'TikTok',
							'youtube'   => 'YouTube',
							'linkedin'  => 'LinkedIn',
							'tripadvisor' => 'TripAdvisor',
						),
					),
					array(
						'key'   => 'field_listing_social_url',
						'label' => 'URL',
						'name'  => 'url',
						'type'  => 'url',
					),
				),
			),
			array(
				'key'        => 'field_listing_opening_hours',
				'label'      => 'Opening Hours',
				'name'       => 'opening_hours',
				'type'       => 'repeater',
				'layout'     => 'table',
				'sub_fields' => array(
					array(
						'key'     => 'field_listing_oh_day',
						'label'   => 'Day',
						'name'    => 'day',
						'type'    => 'select',
						'choices' => array(
							'monday'    => 'Monday',
							'tuesday'   => 'Tuesday',
							'wednesday' => 'Wednesday',
							'thursday'  => 'Thursday',
							'friday'    => 'Friday',
							'saturday'  => 'Saturday',
							'sunday'    => 'Sunday',
						),
					),
					array(
						'key'   => 'field_listing_oh_open',
						'label' => 'Open',
						'name'  => 'open',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_listing_oh_close',
						'label' => 'Close',
						'name'  => 'close',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_listing_oh_closed',
						'label' => 'Closed',
						'name'  => 'closed',
						'type'  => 'true_false',
						'ui'    => 1,
					),
				),
			),
			array(
				'key'     => 'field_listing_price_range',
				'label'   => 'Price Range',
				'name'    => 'price_range',
				'type'    => 'select',
				'choices' => array(
					'£'    => '£',
					'££'   => '££',
					'£££'  => '£££',
					'££££' => '££££',
				),
			),
			array(
				'key'     => 'field_listing_features',
				'label'   => 'Features',
				'name'    => 'features',
				'type'    => 'checkbox',
				'choices' => array(
					'dog_friendly'           => 'Dog Friendly',
					'wheelchair_accessible'  => 'Wheelchair Accessible',
					'wifi'                   => 'Wi-Fi',
					'parking'                => 'Parking',
					'outdoor_seating'        => 'Outdoor Seating',
					'child_friendly'         => 'Child Friendly',
					'vegan_options'          => 'Vegan Options',
					'gluten_free'            => 'Gluten Free',
					'live_music'             => 'Live Music',
					'private_hire'           => 'Private Hire',
				),
				'layout'  => 'horizontal',
			),
			array(
				'key'           => 'field_listing_food_drink_subcategory',
				'label'         => 'Food & Drink Subcategory',
				'name'          => 'food_drink_subcategory',
				'type'          => 'taxonomy',
				'taxonomy'      => 'food_subcategory',
				'field_type'    => 'multi_select',
				'return_format' => 'object',
				'add_term'      => 1,
			),
			array(
				'key'     => 'field_listing_tier',
				'label'   => 'Listing Tier',
				'name'    => 'listing_tier',
				'type'    => 'select',
				'choices' => array(
					'free'     => 'Free',
					'featured' => 'Featured',
					'premium'  => 'Premium',
					'sponsor'  => 'Sponsor',
				),
				'default_value' => 'free',
			),
			array(
				'key'            => 'field_listing_featured_until',
				'label'          => 'Featured Until',
				'name'           => 'featured_until',
				'type'           => 'date_picker',
				'display_format' => 'd/m/Y',
				'return_format'  => 'Ymd',
			),
			array(
				'key'        => 'field_listing_offers',
				'label'      => 'Offers',
				'name'       => 'offers',
				'type'       => 'repeater',
				'layout'     => 'block',
				'sub_fields' => array(
					array(
						'key'   => 'field_listing_offer_title',
						'label' => 'Offer Title',
						'name'  => 'offer_title',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_listing_offer_description',
						'label' => 'Offer Description',
						'name'  => 'offer_description',
						'type'  => 'textarea',
						'rows'  => 3,
					),
					array(
						'key'            => 'field_listing_offer_expiry',
						'label'          => 'Offer Expiry',
						'name'           => 'offer_expiry',
						'type'           => 'date_picker',
						'display_format' => 'd/m/Y',
						'return_format'  => 'Ymd',
					),
				),
			),
			array(
				'key'     => 'field_listing_claim_status',
				'label'   => 'Claim Status',
				'name'    => 'claim_status',
				'type'    => 'select',
				'choices' => array(
					'unclaimed' => 'Unclaimed',
					'pending'   => 'Pending',
					'claimed'   => 'Claimed',
					'verified'  => 'Verified',
				),
				'default_value' => 'unclaimed',
			),
			array(
				'key'           => 'field_listing_owner_user',
				'label'         => 'Owner User',
				'name'          => 'owner_user',
				'type'          => 'user',
				'return_format' => 'array',
				'allow_null'    => 1,
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'listing',
				),
			),
		),
		'menu_order' => 0,
		'position'   => 'normal',
		'style'      => 'default',
	) );
}

/**
 * Event fields.
 */
function va_register_event_fields() {
	acf_add_local_field_group( array(
		'key'      => 'group_event',
		'title'    => 'Event Details',
		'fields'   => array(
			array(
				'key'      => 'field_event_name',
				'label'    => 'Event Name',
				'name'     => 'event_name',
				'type'     => 'text',
				'required' => 1,
			),
			array(
				'key'   => 'field_event_description',
				'label' => 'Description',
				'name'  => 'description',
				'type'  => 'wysiwyg',
			),
			array(
				'key'            => 'field_event_start_date',
				'label'          => 'Start Date',
				'name'           => 'start_date',
				'type'           => 'date_picker',
				'display_format' => 'd/m/Y',
				'return_format'  => 'Ymd',
			),
			array(
				'key'            => 'field_event_end_date',
				'label'          => 'End Date',
				'name'           => 'end_date',
				'type'           => 'date_picker',
				'display_format' => 'd/m/Y',
				'return_format'  => 'Ymd',
			),
			array(
				'key'            => 'field_event_start_time',
				'label'          => 'Start Time',
				'name'           => 'start_time',
				'type'           => 'time_picker',
				'display_format' => 'g:i a',
				'return_format'  => 'H:i',
			),
			array(
				'key'            => 'field_event_end_time',
				'label'          => 'End Time',
				'name'           => 'end_time',
				'type'           => 'time_picker',
				'display_format' => 'g:i a',
				'return_format'  => 'H:i',
			),
			array(
				'key'     => 'field_event_recurrence',
				'label'   => 'Recurrence',
				'name'    => 'recurrence',
				'type'    => 'select',
				'choices' => array(
					'one-off'   => 'One-off',
					'weekly'    => 'Weekly',
					'monthly'   => 'Monthly',
					'annually'  => 'Annually',
				),
				'default_value' => 'one-off',
			),
			array(
				'key'   => 'field_event_venue_name',
				'label' => 'Venue Name',
				'name'  => 'venue_name',
				'type'  => 'text',
			),
			array(
				'key'           => 'field_event_venue_listing',
				'label'         => 'Venue Listing',
				'name'          => 'venue_listing',
				'type'          => 'post_object',
				'post_type'     => array( 'listing' ),
				'return_format' => 'object',
				'allow_null'    => 1,
			),
			array(
				'key'   => 'field_event_address',
				'label' => 'Address',
				'name'  => 'address',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_event_postcode',
				'label' => 'Postcode',
				'name'  => 'postcode',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_event_latitude',
				'label' => 'Latitude',
				'name'  => 'latitude',
				'type'  => 'number',
				'step'  => 'any',
			),
			array(
				'key'   => 'field_event_longitude',
				'label' => 'Longitude',
				'name'  => 'longitude',
				'type'  => 'number',
				'step'  => 'any',
			),
			array(
				'key'   => 'field_event_ticket_url',
				'label' => 'Ticket URL',
				'name'  => 'ticket_url',
				'type'  => 'url',
			),
			array(
				'key'   => 'field_event_price',
				'label' => 'Price',
				'name'  => 'price',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_event_is_free',
				'label' => 'Is Free',
				'name'  => 'is_free',
				'type'  => 'true_false',
				'ui'    => 1,
			),
			array(
				'key'   => 'field_event_is_family_friendly',
				'label' => 'Family Friendly',
				'name'  => 'is_family_friendly',
				'type'  => 'true_false',
				'ui'    => 1,
			),
			array(
				'key'           => 'field_event_hero_image',
				'label'         => 'Hero Image',
				'name'          => 'hero_image',
				'type'          => 'image',
				'return_format' => 'array',
				'preview_size'  => 'medium',
			),
			array(
				'key'   => 'field_event_organiser_name',
				'label' => 'Organiser Name',
				'name'  => 'organiser_name',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_event_organiser_email',
				'label' => 'Organiser Email',
				'name'  => 'organiser_email',
				'type'  => 'email',
			),
			array(
				'key'   => 'field_event_featured',
				'label' => 'Featured',
				'name'  => 'featured',
				'type'  => 'true_false',
				'ui'    => 1,
			),
			array(
				'key'     => 'field_event_submission_status',
				'label'   => 'Submission Status',
				'name'    => 'submission_status',
				'type'    => 'select',
				'choices' => array(
					'draft'    => 'Draft',
					'pending'  => 'Pending',
					'approved' => 'Approved',
					'expired'  => 'Expired',
				),
				'default_value' => 'draft',
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'event',
				),
			),
		),
		'menu_order' => 0,
		'position'   => 'normal',
		'style'      => 'default',
	) );
}

/**
 * Walk fields.
 */
function va_register_walk_fields() {
	acf_add_local_field_group( array(
		'key'      => 'group_walk',
		'title'    => 'Walk Details',
		'fields'   => array(
			array(
				'key'   => 'field_walk_name',
				'label' => 'Walk Name',
				'name'  => 'walk_name',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_walk_description',
				'label' => 'Description',
				'name'  => 'description',
				'type'  => 'wysiwyg',
			),
			array(
				'key'     => 'field_walk_difficulty',
				'label'   => 'Difficulty',
				'name'    => 'difficulty',
				'type'    => 'select',
				'choices' => array(
					'Easy'        => 'Easy',
					'Moderate'    => 'Moderate',
					'Challenging' => 'Challenging',
				),
			),
			array(
				'key'   => 'field_walk_distance_miles',
				'label' => 'Distance (miles)',
				'name'  => 'distance_miles',
				'type'  => 'number',
				'step'  => 'any',
			),
			array(
				'key'   => 'field_walk_estimated_time',
				'label' => 'Estimated Time',
				'name'  => 'estimated_time',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_walk_start_point',
				'label' => 'Start Point',
				'name'  => 'start_point',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_walk_start_postcode',
				'label' => 'Start Postcode',
				'name'  => 'start_postcode',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_walk_start_lat',
				'label' => 'Start Latitude',
				'name'  => 'start_lat',
				'type'  => 'number',
				'step'  => 'any',
			),
			array(
				'key'   => 'field_walk_start_lng',
				'label' => 'Start Longitude',
				'name'  => 'start_lng',
				'type'  => 'number',
				'step'  => 'any',
			),
			array(
				'key'           => 'field_walk_gpx_file',
				'label'         => 'GPX File',
				'name'          => 'gpx_file',
				'type'          => 'file',
				'return_format' => 'array',
			),
			array(
				'key'     => 'field_walk_terrain',
				'label'   => 'Terrain',
				'name'    => 'terrain',
				'type'    => 'checkbox',
				'choices' => array(
					'paved'  => 'Paved',
					'gravel' => 'Gravel',
					'grass'  => 'Grass',
					'muddy'  => 'Muddy',
					'stiles' => 'Stiles',
					'steps'  => 'Steps',
					'steep'  => 'Steep',
				),
				'layout'  => 'horizontal',
			),
			array(
				'key'   => 'field_walk_dog_friendly',
				'label' => 'Dog Friendly',
				'name'  => 'dog_friendly',
				'type'  => 'true_false',
				'ui'    => 1,
			),
			array(
				'key'   => 'field_walk_pushchair_friendly',
				'label' => 'Pushchair Friendly',
				'name'  => 'pushchair_friendly',
				'type'  => 'true_false',
				'ui'    => 1,
			),
			array(
				'key'           => 'field_walk_pub_on_route',
				'label'         => 'Pub on Route',
				'name'          => 'pub_on_route',
				'type'          => 'post_object',
				'post_type'     => array( 'listing' ),
				'return_format' => 'object',
				'allow_null'    => 1,
			),
			array(
				'key'           => 'field_walk_cafe_on_route',
				'label'         => 'Cafe on Route',
				'name'          => 'cafe_on_route',
				'type'          => 'post_object',
				'post_type'     => array( 'listing' ),
				'return_format' => 'object',
				'allow_null'    => 1,
			),
			array(
				'key'   => 'field_walk_parking',
				'label' => 'Parking',
				'name'  => 'parking',
				'type'  => 'text',
			),
			array(
				'key'        => 'field_walk_highlights',
				'label'      => 'Highlights',
				'name'       => 'highlights',
				'type'       => 'repeater',
				'layout'     => 'block',
				'sub_fields' => array(
					array(
						'key'   => 'field_walk_highlight_name',
						'label' => 'Name',
						'name'  => 'name',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_walk_highlight_description',
						'label' => 'Description',
						'name'  => 'description',
						'type'  => 'textarea',
						'rows'  => 3,
					),
					array(
						'key'           => 'field_walk_highlight_image',
						'label'         => 'Image',
						'name'          => 'image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'thumbnail',
					),
				),
			),
			array(
				'key'   => 'field_walk_seasonal_notes',
				'label' => 'Seasonal Notes',
				'name'  => 'seasonal_notes',
				'type'  => 'textarea',
				'rows'  => 4,
			),
			array(
				'key'           => 'field_walk_gallery',
				'label'         => 'Gallery',
				'name'          => 'gallery',
				'type'          => 'gallery',
				'return_format' => 'array',
				'preview_size'  => 'thumbnail',
			),
			array(
				'key'           => 'field_walk_nearby_listings',
				'label'         => 'Nearby Listings',
				'name'          => 'nearby_listings',
				'type'          => 'relationship',
				'post_type'     => array( 'listing' ),
				'return_format' => 'object',
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'walk',
				),
			),
		),
		'menu_order' => 0,
		'position'   => 'normal',
		'style'      => 'default',
	) );
}

/**
 * Area fields.
 */
function va_register_area_fields() {
	acf_add_local_field_group( array(
		'key'      => 'group_area',
		'title'    => 'Area Details',
		'fields'   => array(
			array(
				'key'   => 'field_area_name',
				'label' => 'Area Name',
				'name'  => 'area_name',
				'type'  => 'text',
			),
			array(
				'key'     => 'field_area_type',
				'label'   => 'Area Type',
				'name'    => 'area_type',
				'type'    => 'select',
				'choices' => array(
					'Village'       => 'Village',
					'Neighbourhood' => 'Neighbourhood',
					'Town'          => 'Town',
				),
			),
			array(
				'key'   => 'field_area_introduction',
				'label' => 'Introduction',
				'name'  => 'introduction',
				'type'  => 'wysiwyg',
			),
			array(
				'key'   => 'field_area_history',
				'label' => 'History',
				'name'  => 'history',
				'type'  => 'wysiwyg',
			),
			array(
				'key'   => 'field_area_getting_there',
				'label' => 'Getting There',
				'name'  => 'getting_there',
				'type'  => 'wysiwyg',
			),
			array(
				'key'           => 'field_area_hero_image',
				'label'         => 'Hero Image',
				'name'          => 'hero_image',
				'type'          => 'image',
				'return_format' => 'array',
				'preview_size'  => 'medium',
			),
			array(
				'key'           => 'field_area_gallery',
				'label'         => 'Gallery',
				'name'          => 'gallery',
				'type'          => 'gallery',
				'return_format' => 'array',
				'preview_size'  => 'thumbnail',
			),
			array(
				'key'   => 'field_area_latitude',
				'label' => 'Latitude',
				'name'  => 'latitude',
				'type'  => 'number',
				'step'  => 'any',
			),
			array(
				'key'   => 'field_area_longitude',
				'label' => 'Longitude',
				'name'  => 'longitude',
				'type'  => 'number',
				'step'  => 'any',
			),
			array(
				'key'        => 'field_area_key_attractions',
				'label'      => 'Key Attractions',
				'name'       => 'key_attractions',
				'type'       => 'repeater',
				'layout'     => 'block',
				'sub_fields' => array(
					array(
						'key'   => 'field_area_attraction_name',
						'label' => 'Name',
						'name'  => 'name',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_area_attraction_description',
						'label' => 'Description',
						'name'  => 'description',
						'type'  => 'textarea',
						'rows'  => 3,
					),
					array(
						'key'   => 'field_area_attraction_link',
						'label' => 'Link',
						'name'  => 'link',
						'type'  => 'url',
					),
				),
			),
			array(
				'key'   => 'field_area_fun_fact',
				'label' => 'Fun Fact',
				'name'  => 'fun_fact',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_area_population',
				'label' => 'Population',
				'name'  => 'population',
				'type'  => 'text',
			),
			array(
				'key'           => 'field_area_local_walks',
				'label'         => 'Local Walks',
				'name'          => 'local_walks',
				'type'          => 'relationship',
				'post_type'     => array( 'walk' ),
				'return_format' => 'object',
			),
			array(
				'key'           => 'field_area_nearest_pub',
				'label'         => 'Nearest Pub',
				'name'          => 'nearest_pub',
				'type'          => 'post_object',
				'post_type'     => array( 'listing' ),
				'return_format' => 'object',
				'allow_null'    => 1,
			),
			array(
				'key'           => 'field_area_nearest_cafe',
				'label'         => 'Nearest Cafe',
				'name'          => 'nearest_cafe',
				'type'          => 'post_object',
				'post_type'     => array( 'listing' ),
				'return_format' => 'object',
				'allow_null'    => 1,
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'area',
				),
			),
		),
		'menu_order' => 0,
		'position'   => 'normal',
		'style'      => 'default',
	) );
}

/**
 * Guide fields.
 */
function va_register_guide_fields() {
	acf_add_local_field_group( array(
		'key'      => 'group_guide',
		'title'    => 'Guide Details',
		'fields'   => array(
			array(
				'key'           => 'field_guide_hero_image',
				'label'         => 'Hero Image',
				'name'          => 'hero_image',
				'type'          => 'image',
				'return_format' => 'array',
				'preview_size'  => 'medium',
			),
			array(
				'key'           => 'field_guide_related_listings',
				'label'         => 'Related Listings',
				'name'          => 'related_listings',
				'type'          => 'relationship',
				'post_type'     => array( 'listing' ),
				'return_format' => 'object',
			),
			array(
				'key'           => 'field_guide_related_events',
				'label'         => 'Related Events',
				'name'          => 'related_events',
				'type'          => 'relationship',
				'post_type'     => array( 'event' ),
				'return_format' => 'object',
			),
			array(
				'key'           => 'field_guide_related_walks',
				'label'         => 'Related Walks',
				'name'          => 'related_walks',
				'type'          => 'relationship',
				'post_type'     => array( 'walk' ),
				'return_format' => 'object',
			),
			array(
				'key'           => 'field_guide_related_areas',
				'label'         => 'Related Areas',
				'name'          => 'related_areas',
				'type'          => 'relationship',
				'post_type'     => array( 'area' ),
				'return_format' => 'object',
			),
			array(
				'key'        => 'field_guide_call_to_action',
				'label'      => 'Call to Action',
				'name'       => 'call_to_action',
				'type'       => 'group',
				'layout'     => 'block',
				'sub_fields' => array(
					array(
						'key'   => 'field_guide_cta_text',
						'label' => 'CTA Text',
						'name'  => 'cta_text',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_guide_cta_url',
						'label' => 'CTA URL',
						'name'  => 'cta_url',
						'type'  => 'url',
					),
				),
			),
			array(
				'key'            => 'field_guide_last_verified',
				'label'          => 'Last Verified',
				'name'           => 'last_verified',
				'type'           => 'date_picker',
				'display_format' => 'd/m/Y',
				'return_format'  => 'Ymd',
			),
			array(
				'key'     => 'field_guide_seasonal_flag',
				'label'   => 'Seasonal Flag',
				'name'    => 'seasonal_flag',
				'type'    => 'select',
				'choices' => array(
					'none'      => 'None',
					'spring'    => 'Spring',
					'summer'    => 'Summer',
					'autumn'    => 'Autumn',
					'winter'    => 'Winter',
					'christmas' => 'Christmas',
					'easter'    => 'Easter',
				),
				'default_value' => 'none',
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'guide',
				),
			),
		),
		'menu_order' => 0,
		'position'   => 'normal',
		'style'      => 'default',
	) );
}
