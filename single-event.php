<?php
/**
 * Single: Event
 *
 * @package VisitAylesbury
 */

get_header();

while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/single/content-event' );
endwhile;

get_footer();
