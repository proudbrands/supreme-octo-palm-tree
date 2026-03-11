<?php
/**
 * Single: Listing
 *
 * @package VisitAylesbury
 */

get_header();

while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/single/content-listing' );
endwhile;

get_footer();
