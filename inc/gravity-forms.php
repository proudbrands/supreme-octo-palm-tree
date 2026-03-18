<?php
/**
 * Gravity Forms — event submission forms and processing.
 *
 * Creates two forms programmatically:
 *   1. Single Event Submission
 *   2. Bulk Event Submission (CSV upload)
 *
 * Handles gform_after_submission to create event CPTs from form entries.
 *
 * @package VisitAylesbury
 */

defined( 'ABSPATH' ) || exit;

/* ==========================================================================
   Form creation — runs once via admin action
   ========================================================================== */

add_action( 'admin_init', 'va_maybe_create_event_forms' );

/**
 * Create submission forms if they don't already exist.
 */
function va_maybe_create_event_forms() {
	if ( ! class_exists( 'GFAPI' ) ) {
		return;
	}

	if ( get_option( 'va_event_forms_created' ) ) {
		return;
	}

	$single_form_id = va_create_single_event_form();
	$bulk_form_id   = va_create_bulk_event_form();

	if ( $single_form_id && $bulk_form_id ) {
		update_option( 'va_event_forms_created', true );
		update_option( 'va_single_event_form_id', $single_form_id );
		update_option( 'va_bulk_event_form_id', $bulk_form_id );
	}
}

/**
 * Create the single event submission form.
 *
 * @return int|false Form ID on success, false on failure.
 */
function va_create_single_event_form() {
	if ( ! class_exists( 'GFAPI' ) ) {
		return false;
	}

	$event_cats = get_terms( array(
		'taxonomy'   => 'event_category',
		'hide_empty' => false,
	) );

	$category_choices = array();
	if ( ! is_wp_error( $event_cats ) && ! empty( $event_cats ) ) {
		foreach ( $event_cats as $cat ) {
			$category_choices[] = array(
				'text'  => $cat->name,
				'value' => $cat->term_id,
			);
		}
	}

	$form = array(
		'title'                => 'Submit an Event',
		'description'          => 'Add your event to the Visit Aylesbury what\'s on guide. All submissions are reviewed before publishing.',
		'labelPlacement'       => 'top_label',
		'descriptionPlacement' => 'below',
		'button'               => array(
			'type' => 'text',
			'text' => 'Submit Event',
		),
		'confirmations'        => array(
			array(
				'id'      => 1,
				'name'    => 'Default Confirmation',
				'type'    => 'message',
				'message' => '<div class="va-submission-success"><h3>Thank you!</h3><p>Your event has been submitted for review. We\'ll publish it within 48 hours if it meets our guidelines.</p><p><a href="/events/">Back to What\'s On</a></p></div>',
				'isDefault' => true,
			),
		),
		'fields'               => array(
			// Section: Event details.
			array(
				'type'  => 'section',
				'id'    => 100,
				'label' => 'Event Details',
			),
			array(
				'type'      => 'text',
				'id'        => 1,
				'label'     => 'Event Name',
				'isRequired' => true,
				'size'      => 'large',
				'placeholder' => 'e.g. Aylesbury Farmers Market',
			),
			array(
				'type'      => 'textarea',
				'id'        => 2,
				'label'     => 'Event Description',
				'isRequired' => true,
				'size'      => 'large',
				'maxLength' => 2000,
				'placeholder' => 'Tell visitors what this event is about, what to expect, and any key details.',
			),
			array(
				'type'    => 'select',
				'id'      => 3,
				'label'   => 'Event Category',
				'isRequired' => true,
				'choices' => $category_choices,
				'placeholder' => 'Select a category',
			),
			// Section: Date & time.
			array(
				'type'  => 'section',
				'id'    => 101,
				'label' => 'Date & Time',
			),
			array(
				'type'         => 'date',
				'id'           => 4,
				'label'        => 'Start Date',
				'isRequired'   => true,
				'dateType'     => 'datepicker',
				'dateFormat'   => 'dmy',
				'calendarIconType' => 'calendar',
			),
			array(
				'type'       => 'date',
				'id'         => 5,
				'label'      => 'End Date',
				'isRequired' => false,
				'dateType'   => 'datepicker',
				'dateFormat' => 'dmy',
				'description' => 'Leave blank for single-day events.',
				'calendarIconType' => 'calendar',
			),
			array(
				'type'        => 'time',
				'id'          => 6,
				'label'       => 'Start Time',
				'isRequired'  => true,
				'timeFormat'  => '12',
			),
			array(
				'type'       => 'time',
				'id'         => 7,
				'label'      => 'End Time',
				'isRequired' => false,
				'timeFormat' => '12',
			),
			array(
				'type'    => 'select',
				'id'      => 8,
				'label'   => 'Recurrence',
				'choices' => array(
					array( 'text' => 'One-off event', 'value' => 'one-off', 'isSelected' => true ),
					array( 'text' => 'Weekly',        'value' => 'weekly' ),
					array( 'text' => 'Monthly',       'value' => 'monthly' ),
					array( 'text' => 'Annually',      'value' => 'annually' ),
				),
			),
			// Section: Location.
			array(
				'type'  => 'section',
				'id'    => 102,
				'label' => 'Location',
			),
			array(
				'type'      => 'text',
				'id'        => 9,
				'label'     => 'Venue Name',
				'isRequired' => true,
				'placeholder' => 'e.g. Waterside Theatre',
			),
			array(
				'type'        => 'text',
				'id'          => 10,
				'label'       => 'Address',
				'isRequired'  => true,
				'size'        => 'large',
				'placeholder' => 'Full street address',
			),
			array(
				'type'        => 'text',
				'id'          => 11,
				'label'       => 'Postcode',
				'isRequired'  => true,
				'size'        => 'small',
				'placeholder' => 'HP20 1UG',
			),
			// Section: Tickets & pricing.
			array(
				'type'  => 'section',
				'id'    => 103,
				'label' => 'Tickets & Pricing',
			),
			array(
				'type'    => 'checkbox',
				'id'      => 12,
				'label'   => 'Pricing',
				'choices' => array(
					array( 'text' => 'This is a free event', 'value' => 'free' ),
					array( 'text' => 'Family friendly', 'value' => 'family_friendly' ),
				),
			),
			array(
				'type'        => 'text',
				'id'          => 13,
				'label'       => 'Price',
				'description' => 'e.g. "£5 adults / £3 children" or "From £12.50"',
				'placeholder' => 'Leave blank if free',
			),
			array(
				'type'        => 'website',
				'id'          => 14,
				'label'       => 'Ticket / Booking URL',
				'placeholder' => 'https://',
			),
			// Section: Image.
			array(
				'type'  => 'section',
				'id'    => 104,
				'label' => 'Event Image',
			),
			array(
				'type'            => 'fileupload',
				'id'              => 15,
				'label'           => 'Event Image',
				'description'     => 'Upload a landscape image for your event. Max 2 MB. JPG or PNG only.',
				'allowedExtensions' => 'jpg,jpeg,png',
				'maxFileSize'     => 2,
				'isRequired'      => false,
			),
			// Section: Organiser details.
			array(
				'type'  => 'section',
				'id'    => 105,
				'label' => 'Your Details',
			),
			array(
				'type'      => 'text',
				'id'        => 16,
				'label'     => 'Organiser Name',
				'isRequired' => true,
				'placeholder' => 'Your name or organisation',
			),
			array(
				'type'      => 'email',
				'id'        => 17,
				'label'     => 'Organiser Email',
				'isRequired' => true,
				'description' => 'We\'ll only use this to contact you about your listing. Not displayed publicly.',
			),
			// GDPR consent.
			array(
				'type'          => 'consent',
				'id'            => 18,
				'label'         => 'Consent',
				'checkboxLabel' => 'I confirm that I have the right to submit this event and agree to the Visit Aylesbury terms of use.',
				'isRequired'    => true,
				'description'   => 'Your email will not be shared or used for marketing.',
				'inputs'        => array(
					array( 'id' => '18.1', 'label' => 'Consent', 'name' => '' ),
					array( 'id' => '18.2', 'label' => 'Text', 'name' => '', 'isHidden' => true ),
					array( 'id' => '18.3', 'label' => 'Description', 'name' => '', 'isHidden' => true ),
				),
			),
		),
	);

	$result = GFAPI::add_form( $form );

	return is_wp_error( $result ) ? false : $result;
}

/**
 * Create the bulk event submission form (CSV upload).
 *
 * @return int|false Form ID on success, false on failure.
 */
function va_create_bulk_event_form() {
	if ( ! class_exists( 'GFAPI' ) ) {
		return false;
	}

	$form = array(
		'title'                => 'Bulk Event Submission',
		'description'          => 'Upload multiple events at once using our CSV template.',
		'labelPlacement'       => 'top_label',
		'descriptionPlacement' => 'below',
		'button'               => array(
			'type' => 'text',
			'text' => 'Upload Events',
		),
		'confirmations'        => array(
			array(
				'id'      => 1,
				'name'    => 'Default Confirmation',
				'type'    => 'message',
				'message' => '<div class="va-submission-success"><h3>Upload received!</h3><p>We\'ll review your events and publish them within 48 hours. We\'ll email you if we need any corrections.</p><p><a href="/events/">Back to What\'s On</a></p></div>',
				'isDefault' => true,
			),
		),
		'fields'               => array(
			array(
				'type'  => 'section',
				'id'    => 100,
				'label' => 'Bulk Upload',
			),
			array(
				'type'    => 'html',
				'id'      => 101,
				'label'   => 'Instructions',
				'content' => '<div class="va-bulk-instructions">
					<h4>How to submit multiple events</h4>
					<ol>
						<li>Download the <a href="#" id="va-csv-template-download">CSV template</a></li>
						<li>Fill in one row per event — all columns are explained in the template</li>
						<li>Save the file as CSV (not Excel)</li>
						<li>Upload it below along with your contact details</li>
					</ol>
					<p><strong>Required columns:</strong> event_name, description, start_date (DD/MM/YYYY), start_time (HH:MM), venue_name, address, postcode, category, organiser_name, organiser_email</p>
					<p><strong>Optional columns:</strong> end_date, end_time, recurrence, price, ticket_url, is_free (yes/no), is_family_friendly (yes/no)</p>
				</div>',
			),
			array(
				'type'              => 'fileupload',
				'id'                => 1,
				'label'             => 'CSV File',
				'isRequired'        => true,
				'allowedExtensions' => 'csv',
				'maxFileSize'       => 1,
				'description'       => 'Upload your completed CSV template. Max 1 MB.',
			),
			array(
				'type'  => 'section',
				'id'    => 102,
				'label' => 'Your Details',
			),
			array(
				'type'      => 'text',
				'id'        => 2,
				'label'     => 'Organisation Name',
				'isRequired' => true,
			),
			array(
				'type'      => 'email',
				'id'        => 3,
				'label'     => 'Contact Email',
				'isRequired' => true,
			),
			array(
				'type'          => 'consent',
				'id'            => 4,
				'label'         => 'Consent',
				'checkboxLabel' => 'I confirm that I have the right to submit these events and agree to the Visit Aylesbury terms of use.',
				'isRequired'    => true,
				'description'   => 'Your email will not be shared or used for marketing.',
				'inputs'        => array(
					array( 'id' => '4.1', 'label' => 'Consent', 'name' => '' ),
					array( 'id' => '4.2', 'label' => 'Text', 'name' => '', 'isHidden' => true ),
					array( 'id' => '4.3', 'label' => 'Description', 'name' => '', 'isHidden' => true ),
				),
			),
		),
	);

	$result = GFAPI::add_form( $form );

	return is_wp_error( $result ) ? false : $result;
}

/* ==========================================================================
   Single event form — create event CPT on submission
   ========================================================================== */

add_action( 'gform_after_submission', 'va_process_single_event_submission', 10, 2 );

/**
 * Process single event form submission — create a pending event CPT.
 *
 * @param array $entry The form entry.
 * @param array $form  The form object.
 */
function va_process_single_event_submission( $entry, $form ) {
	$single_form_id = (int) get_option( 'va_single_event_form_id', 0 );

	if ( (int) $form['id'] !== $single_form_id || ! $single_form_id ) {
		return;
	}

	$event_name  = sanitize_text_field( rgar( $entry, '1' ) );
	$description = sanitize_textarea_field( rgar( $entry, '2' ) );
	$category_id = absint( rgar( $entry, '3' ) );
	$start_date  = rgar( $entry, '4' );
	$end_date    = rgar( $entry, '5' );
	$start_time  = rgar( $entry, '6' );
	$end_time    = rgar( $entry, '7' );
	$recurrence  = sanitize_text_field( rgar( $entry, '8' ) );
	$venue       = sanitize_text_field( rgar( $entry, '9' ) );
	$address     = sanitize_text_field( rgar( $entry, '10' ) );
	$postcode    = sanitize_text_field( rgar( $entry, '11' ) );
	$pricing     = rgar( $entry, '12' );
	$price       = sanitize_text_field( rgar( $entry, '13' ) );
	$ticket_url  = esc_url_raw( rgar( $entry, '14' ) );
	$image_url   = rgar( $entry, '15' );
	$organiser   = sanitize_text_field( rgar( $entry, '16' ) );
	$org_email   = sanitize_email( rgar( $entry, '17' ) );

	// Parse free / family-friendly from checkbox values.
	$is_free            = ( strpos( $pricing, 'free' ) !== false ) ? 1 : 0;
	$is_family_friendly = ( strpos( $pricing, 'family_friendly' ) !== false ) ? 1 : 0;

	// Convert date from GF format (DD/MM/YYYY) to ACF format (Ymd).
	$start_date_acf = va_gf_date_to_acf( $start_date );
	$end_date_acf   = $end_date ? va_gf_date_to_acf( $end_date ) : $start_date_acf;

	// Convert time from GF 12-hour format to H:i.
	$start_time_acf = va_gf_time_to_acf( $start_time );
	$end_time_acf   = $end_time ? va_gf_time_to_acf( $end_time ) : '';

	// Create the event post as pending.
	$post_id = wp_insert_post( array(
		'post_type'   => 'event',
		'post_title'  => $event_name,
		'post_status' => 'pending',
	) );

	if ( is_wp_error( $post_id ) || ! $post_id ) {
		return;
	}

	// Set ACF fields.
	update_field( 'event_name', $event_name, $post_id );
	update_field( 'description', wpautop( $description ), $post_id );
	update_field( 'start_date', $start_date_acf, $post_id );
	update_field( 'end_date', $end_date_acf, $post_id );
	update_field( 'start_time', $start_time_acf, $post_id );
	update_field( 'end_time', $end_time_acf, $post_id );
	update_field( 'recurrence', $recurrence ?: 'one-off', $post_id );
	update_field( 'venue_name', $venue, $post_id );
	update_field( 'address', $address, $post_id );
	update_field( 'postcode', $postcode, $post_id );
	update_field( 'price', $price, $post_id );
	update_field( 'is_free', $is_free, $post_id );
	update_field( 'is_family_friendly', $is_family_friendly, $post_id );
	update_field( 'ticket_url', $ticket_url, $post_id );
	update_field( 'organiser_name', $organiser, $post_id );
	update_field( 'organiser_email', $org_email, $post_id );
	update_field( 'submission_status', 'pending', $post_id );
	update_field( 'featured', 0, $post_id );

	// Set event category taxonomy.
	if ( $category_id ) {
		wp_set_object_terms( $post_id, array( $category_id ), 'event_category' );
	}

	// Handle image upload — sideload from GF upload URL.
	if ( $image_url ) {
		$image_id = va_sideload_gf_image( $image_url, $post_id );
		if ( $image_id ) {
			update_field( 'hero_image', $image_id, $post_id );
			set_post_thumbnail( $post_id, $image_id );
		}
	}

	// Notify admin.
	va_notify_admin_event_submission( $event_name, $post_id );
}

/* ==========================================================================
   Bulk event form — notify admin for manual processing
   ========================================================================== */

add_action( 'gform_after_submission', 'va_process_bulk_event_submission', 10, 2 );

/**
 * Process bulk event CSV submission — parse CSV and create pending events.
 *
 * @param array $entry The form entry.
 * @param array $form  The form object.
 */
function va_process_bulk_event_submission( $entry, $form ) {
	$bulk_form_id = (int) get_option( 'va_bulk_event_form_id', 0 );

	if ( (int) $form['id'] !== $bulk_form_id || ! $bulk_form_id ) {
		return;
	}

	$csv_url   = rgar( $entry, '1' );
	$org_name  = sanitize_text_field( rgar( $entry, '2' ) );
	$org_email = sanitize_email( rgar( $entry, '3' ) );

	if ( ! $csv_url ) {
		return;
	}

	// Download CSV to a temp file.
	$tmp_file = download_url( $csv_url );
	if ( is_wp_error( $tmp_file ) ) {
		va_notify_admin_bulk_error( $org_name, $org_email, 'Could not download CSV file.' );
		return;
	}

	$handle = fopen( $tmp_file, 'r' );
	if ( ! $handle ) {
		wp_delete_file( $tmp_file );
		return;
	}

	// Read header row.
	$headers = fgetcsv( $handle );
	if ( ! $headers ) {
		fclose( $handle );
		wp_delete_file( $tmp_file );
		return;
	}

	$headers    = array_map( 'trim', array_map( 'strtolower', $headers ) );
	$created    = 0;
	$max_events = 100; // Safety limit.

	while ( ( $row = fgetcsv( $handle ) ) !== false && $created < $max_events ) {
		if ( count( $row ) < count( $headers ) ) {
			continue;
		}

		$data = array_combine( $headers, $row );

		$event_name = sanitize_text_field( $data['event_name'] ?? '' );
		if ( ! $event_name ) {
			continue;
		}

		// Create pending event post.
		$post_id = wp_insert_post( array(
			'post_type'   => 'event',
			'post_title'  => $event_name,
			'post_status' => 'pending',
		) );

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}

		// Map CSV columns to ACF fields.
		update_field( 'event_name', $event_name, $post_id );
		update_field( 'description', wpautop( sanitize_textarea_field( $data['description'] ?? '' ) ), $post_id );
		update_field( 'start_date', va_gf_date_to_acf( $data['start_date'] ?? '' ), $post_id );
		update_field( 'end_date', va_gf_date_to_acf( $data['end_date'] ?? '' ), $post_id );
		update_field( 'start_time', sanitize_text_field( $data['start_time'] ?? '' ), $post_id );
		update_field( 'end_time', sanitize_text_field( $data['end_time'] ?? '' ), $post_id );
		update_field( 'recurrence', sanitize_text_field( $data['recurrence'] ?? 'one-off' ), $post_id );
		update_field( 'venue_name', sanitize_text_field( $data['venue_name'] ?? '' ), $post_id );
		update_field( 'address', sanitize_text_field( $data['address'] ?? '' ), $post_id );
		update_field( 'postcode', sanitize_text_field( $data['postcode'] ?? '' ), $post_id );
		update_field( 'price', sanitize_text_field( $data['price'] ?? '' ), $post_id );
		update_field( 'ticket_url', esc_url_raw( $data['ticket_url'] ?? '' ), $post_id );
		update_field( 'organiser_name', $org_name, $post_id );
		update_field( 'organiser_email', $org_email, $post_id );
		update_field( 'submission_status', 'pending', $post_id );
		update_field( 'featured', 0, $post_id );

		$is_free = strtolower( trim( $data['is_free'] ?? '' ) );
		update_field( 'is_free', in_array( $is_free, array( 'yes', '1', 'true' ), true ) ? 1 : 0, $post_id );

		$is_family = strtolower( trim( $data['is_family_friendly'] ?? '' ) );
		update_field( 'is_family_friendly', in_array( $is_family, array( 'yes', '1', 'true' ), true ) ? 1 : 0, $post_id );

		// Set category taxonomy by name.
		$cat_name = sanitize_text_field( $data['category'] ?? '' );
		if ( $cat_name ) {
			$term = get_term_by( 'name', $cat_name, 'event_category' );
			if ( $term ) {
				wp_set_object_terms( $post_id, array( $term->term_id ), 'event_category' );
			}
		}

		$created++;
	}

	fclose( $handle );
	wp_delete_file( $tmp_file );

	// Notify admin.
	$admin_email = get_option( 'admin_email' );
	wp_mail(
		$admin_email,
		sprintf( '[Visit Aylesbury] Bulk event upload: %d events from %s', $created, $org_name ),
		sprintf(
			"A bulk event CSV has been processed.\n\nOrganisation: %s\nEmail: %s\nEvents created: %d\n\nAll events are set to Pending. Review them in the WordPress admin:\n%s",
			$org_name,
			$org_email,
			$created,
			admin_url( 'edit.php?post_type=event&post_status=pending' )
		)
	);
}

/* ==========================================================================
   Helper functions
   ========================================================================== */

/**
 * Convert a GF date (DD/MM/YYYY) to ACF format (Ymd).
 *
 * @param string $date Date string in DD/MM/YYYY format.
 * @return string Date in Ymd format.
 */
function va_gf_date_to_acf( $date ) {
	if ( ! $date ) {
		return '';
	}

	$parsed = date_create_from_format( 'd/m/Y', $date );
	if ( ! $parsed ) {
		// Try Y-m-d (GF sometimes uses this).
		$parsed = date_create_from_format( 'Y-m-d', $date );
	}

	return $parsed ? $parsed->format( 'Ymd' ) : '';
}

/**
 * Convert a GF time value to H:i format.
 *
 * GF stores time as "HH:MM AM/PM" or just "HH:MM".
 *
 * @param string $time Time string.
 * @return string Time in H:i 24-hour format.
 */
function va_gf_time_to_acf( $time ) {
	if ( ! $time ) {
		return '';
	}

	$parsed = strtotime( $time );
	return $parsed ? date( 'H:i', $parsed ) : '';
}

/**
 * Sideload a Gravity Forms uploaded image into the media library.
 *
 * @param string $url     The upload URL.
 * @param int    $post_id The post to attach the image to.
 * @return int|false Attachment ID on success, false on failure.
 */
function va_sideload_gf_image( $url, $post_id ) {
	if ( ! function_exists( 'media_sideload_image' ) ) {
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
	}

	$attachment_id = media_sideload_image( $url, $post_id, null, 'id' );

	return is_wp_error( $attachment_id ) ? false : $attachment_id;
}

/**
 * Notify site admin about a new single event submission.
 *
 * @param string $event_name The event name.
 * @param int    $post_id    The event post ID.
 */
function va_notify_admin_event_submission( $event_name, $post_id ) {
	$admin_email = get_option( 'admin_email' );
	$edit_link   = admin_url( 'post.php?post=' . $post_id . '&action=edit' );

	wp_mail(
		$admin_email,
		sprintf( '[Visit Aylesbury] New event submission: %s', $event_name ),
		sprintf(
			"A new event has been submitted for review.\n\nEvent: %s\nStatus: Pending\n\nReview and publish:\n%s",
			$event_name,
			$edit_link
		)
	);
}

/**
 * Notify admin about a bulk upload error.
 *
 * @param string $org_name  Organisation name.
 * @param string $org_email Organisation email.
 * @param string $error     Error message.
 */
function va_notify_admin_bulk_error( $org_name, $org_email, $error ) {
	wp_mail(
		get_option( 'admin_email' ),
		'[Visit Aylesbury] Bulk event upload failed',
		sprintf(
			"A bulk event upload could not be processed.\n\nOrganisation: %s\nEmail: %s\nError: %s",
			$org_name,
			$org_email,
			$error
		)
	);
}

/* ==========================================================================
   File upload validation — enforce size limits
   ========================================================================== */

add_filter( 'gform_validation', 'va_validate_event_file_uploads' );

/**
 * Additional server-side validation for file uploads.
 *
 * @param array $validation_result The validation result.
 * @return array Modified validation result.
 */
function va_validate_event_file_uploads( $validation_result ) {
	$form           = $validation_result['form'];
	$single_form_id = (int) get_option( 'va_single_event_form_id', 0 );

	if ( (int) $form['id'] !== $single_form_id ) {
		return $validation_result;
	}

	foreach ( $form['fields'] as &$field ) {
		if ( $field->type !== 'fileupload' ) {
			continue;
		}

		$input_name = 'input_' . $field->id;

		if ( ! empty( $_FILES[ $input_name ]['size'] ) ) {
			$max_bytes = 2 * 1024 * 1024; // 2 MB.
			if ( $_FILES[ $input_name ]['size'] > $max_bytes ) {
				$validation_result['is_valid'] = false;
				$field->failed_validation      = true;
				$field->validation_message     = 'File size must be under 2 MB.';
			}
		}
	}

	$validation_result['form'] = $form;
	return $validation_result;
}

/* ==========================================================================
   CSV template download endpoint
   ========================================================================== */

add_action( 'wp_ajax_nopriv_va_download_csv_template', 'va_download_csv_template' );
add_action( 'wp_ajax_va_download_csv_template', 'va_download_csv_template' );

/**
 * Serve the bulk upload CSV template.
 */
function va_download_csv_template() {
	header( 'Content-Type: text/csv' );
	header( 'Content-Disposition: attachment; filename="visit-aylesbury-events-template.csv"' );

	$output = fopen( 'php://output', 'w' );

	// Header row.
	fputcsv( $output, array(
		'event_name',
		'description',
		'start_date',
		'end_date',
		'start_time',
		'end_time',
		'recurrence',
		'venue_name',
		'address',
		'postcode',
		'category',
		'price',
		'ticket_url',
		'is_free',
		'is_family_friendly',
		'organiser_name',
		'organiser_email',
	) );

	// Example row.
	fputcsv( $output, array(
		'Aylesbury Farmers Market',
		'Fresh local produce from Buckinghamshire farms and artisan producers.',
		'15/04/2026',
		'15/04/2026',
		'09:00',
		'14:00',
		'monthly',
		'Market Square',
		'Market Square, Aylesbury',
		'HP20 1TW',
		'Food & Drink',
		'Free entry',
		'',
		'yes',
		'yes',
		'Aylesbury Town Council',
		'events@example.com',
	) );

	fclose( $output );
	exit;
}
