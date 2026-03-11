<?php
/**
 * Theme setup: supports, menus, image sizes.
 *
 * @package VisitAylesbury
 */

defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', 'va_theme_setup' );

function va_theme_setup() {
	load_theme_textdomain( 'visitaylesbury', VA_THEME_DIR . '/languages' );

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'rank-math-breadcrumbs' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'visitaylesbury' ),
		'footer'  => __( 'Footer Menu', 'visitaylesbury' ),
	) );

	add_image_size( 'va-card-thumb', 480, 300, true );
	add_image_size( 'va-hero', 1200, 600, true );
	add_image_size( 'va-gallery', 800, 600, true );
}

/**
 * Register PHP page templates so they appear in the page editor
 * and take priority over FSE block templates.
 */
add_filter( 'theme_page_templates', 'va_register_page_templates' );

function va_register_page_templates( $templates ) {
	$templates['page-vale-walks.php'] = __( 'Vale Walks', 'visitaylesbury' );
	$templates['page-food-drink.php'] = __( 'Food and Drink', 'visitaylesbury' );

	return $templates;
}

/**
 * Force WordPress to use PHP page templates over FSE block templates.
 *
 * In block themes the locate_block_template() function hooks into
 * template_include and replaces PHP templates with block .html files.
 * We intercept earlier via the same filter at a higher priority so
 * our PHP template is returned before the block system can override it.
 *
 * Also handles CPT single/archive templates (single-*.php, archive-*.php,
 * taxonomy-*.php) that exist in the theme root.
 */
add_filter( 'template_include', 'va_force_php_templates', 1 );

function va_force_php_templates( $template ) {
	// 0. Front page: front-page.php
	if ( is_front_page() ) {
		$file = get_theme_file_path( 'front-page.php' );

		if ( file_exists( $file ) ) {
			return $file;
		}
	}

	// 1. Pages with a custom PHP page template assigned.
	if ( is_page() ) {
		$page_template = get_post_meta( get_queried_object_id(), '_wp_page_template', true );

		if ( $page_template && 'default' !== $page_template ) {
			$file = get_theme_file_path( $page_template );

			if ( file_exists( $file ) ) {
				return $file;
			}
		}
	}

	// 2. CPT singles: single-{post_type}.php
	if ( is_singular() ) {
		$post_type = get_post_type();
		$file      = get_theme_file_path( "single-{$post_type}.php" );

		if ( file_exists( $file ) ) {
			return $file;
		}
	}

	// 3. CPT archives: archive-{post_type}.php
	if ( is_post_type_archive() ) {
		$post_type = get_query_var( 'post_type' );
		if ( is_array( $post_type ) ) {
			$post_type = reset( $post_type );
		}
		$file = get_theme_file_path( "archive-{$post_type}.php" );

		if ( file_exists( $file ) ) {
			return $file;
		}
	}

	// 4. Taxonomy archives: taxonomy-{taxonomy}.php
	if ( is_tax() ) {
		$term = get_queried_object();
		$file = get_theme_file_path( "taxonomy-{$term->taxonomy}.php" );

		if ( file_exists( $file ) ) {
			return $file;
		}
	}

	return $template;
}
