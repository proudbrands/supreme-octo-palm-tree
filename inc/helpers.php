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
	// Skip if header.php already loaded the mega menu (flag set before wp_body_open).
	global $va_mega_menu_loaded;
	if ( ! empty( $va_mega_menu_loaded ) ) {
		return;
	}

	// FSE pages don't use header.php, so inject the mega menu here.
	$va_mega_menu_loaded = true;
	get_template_part( 'template-parts/components/mega-menu' );
}

/**
 * Inject footer on FSE (block template) pages.
 *
 * PHP templates load the footer via footer.php → get_template_part().
 * FSE pages need it injected via wp_footer.
 */
add_action( 'wp_footer', 'va_maybe_inject_footer', 1 );

function va_maybe_inject_footer() {
	global $va_footer_loaded;
	if ( ! empty( $va_footer_loaded ) ) {
		return;
	}

	$va_footer_loaded = true;
	echo '<footer class="va-footer" role="contentinfo">';
	get_template_part( 'template-parts/components/footer' );
	echo '</footer>';
}
