<?php
/**
 * Visit Aylesbury theme functions.
 *
 * @package VisitAylesbury
 */

defined( 'ABSPATH' ) || exit;

define( 'VA_THEME_DIR', get_template_directory() );
define( 'VA_THEME_URI', get_template_directory_uri() );
define( 'VA_TEXT_DOMAIN', 'visitaylesbury' );

require_once VA_THEME_DIR . '/inc/setup.php';
require_once VA_THEME_DIR . '/inc/enqueue.php';
require_once VA_THEME_DIR . '/inc/cpt.php';
require_once VA_THEME_DIR . '/inc/taxonomies.php';
require_once VA_THEME_DIR . '/inc/acf-fields.php';
require_once VA_THEME_DIR . '/inc/blocks.php';
require_once VA_THEME_DIR . '/inc/schema.php';
require_once VA_THEME_DIR . '/inc/helpers.php';
