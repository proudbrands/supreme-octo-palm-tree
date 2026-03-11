<?php
/**
 * Traditional footer for PHP templates (CPT singles and archives).
 *
 * @package VisitAylesbury
 */

global $va_footer_loaded;
$va_footer_loaded = true;
?>

<footer class="va-footer" role="contentinfo">
	<?php get_template_part( 'template-parts/components/footer' ); ?>
</footer>

<?php wp_footer(); ?>
</body>
</html>
