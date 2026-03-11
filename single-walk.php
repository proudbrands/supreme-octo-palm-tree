<?php
/**
 * Single: Walk
 *
 * @package VisitAylesbury
 */

get_header();

while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/single/content-walk' );
endwhile;

get_footer();
