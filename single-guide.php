<?php
/**
 * Single Guide template.
 *
 * @package VisitAylesbury
 */

get_header();

while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/single/content-guide' );
endwhile;

get_footer();
