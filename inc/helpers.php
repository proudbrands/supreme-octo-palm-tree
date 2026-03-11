<?php
/**
 * Template helper functions.
 *
 * @package VisitAylesbury
 */

defined( 'ABSPATH' ) || exit;

// Helper functions will be added as templates are built.

/**
 * Inject mega menu on FSE (block template) pages.
 *
 * PHP templates already include the mega menu via header.php → get_template_part().
 * FSE pages (index.html) load via block_template_part('header') which can't run PHP,
 * so we inject the mega menu via wp_body_open for those pages.
 */
add_action( 'wp_body_open', 'va_maybe_inject_mega_menu' );

function va_maybe_inject_mega_menu() {
	// If this is a PHP template page, header.php already loaded the mega menu.
	// Detect by checking if we're in a block template render.
	if ( ! wp_is_block_theme() ) {
		return;
	}

	// Only inject if the PHP header.php didn't already run (i.e., FSE page).
	global $va_mega_menu_loaded;
	if ( empty( $va_mega_menu_loaded ) ) {
		get_template_part( 'template-parts/components/mega-menu' );
	}
}
