<?php
/**
 * Template Name: Submit an Event
 *
 * Front-end event submission page with tabs for single and bulk upload.
 *
 * @package VisitAylesbury
 */

get_header();

$single_form_id = (int) get_option( 'va_single_event_form_id', 0 );
$bulk_form_id   = (int) get_option( 'va_bulk_event_form_id', 0 );
$active_tab     = isset( $_GET['tab'] ) && $_GET['tab'] === 'bulk' ? 'bulk' : 'single';
?>

<main class="va-main">

	<div class="va-container">

		<div class="va-submit-event">

			<div class="va-submit-event__header">
				<h1><?php esc_html_e( 'Submit Your Event', 'visitaylesbury' ); ?></h1>
				<p class="va-submit-event__intro">
					<?php esc_html_e( 'Got an event happening in Aylesbury or the Vale? Add it to our what\'s on guide — it\'s free. All submissions are reviewed before publishing.', 'visitaylesbury' ); ?>
				</p>
			</div>

			<div class="va-submit-event__tabs" role="tablist">
				<button
					class="va-submit-event__tab <?php echo $active_tab === 'single' ? 'is-active' : ''; ?>"
					role="tab"
					aria-selected="<?php echo $active_tab === 'single' ? 'true' : 'false'; ?>"
					aria-controls="va-tab-single"
					data-tab="single"
				>
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
						<line x1="16" y1="2" x2="16" y2="6"></line>
						<line x1="8" y1="2" x2="8" y2="6"></line>
						<line x1="3" y1="10" x2="21" y2="10"></line>
					</svg>
					<?php esc_html_e( 'Single Event', 'visitaylesbury' ); ?>
				</button>
				<button
					class="va-submit-event__tab <?php echo $active_tab === 'bulk' ? 'is-active' : ''; ?>"
					role="tab"
					aria-selected="<?php echo $active_tab === 'bulk' ? 'true' : 'false'; ?>"
					aria-controls="va-tab-bulk"
					data-tab="bulk"
				>
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
						<polyline points="14 2 14 8 20 8"></polyline>
						<line x1="12" y1="18" x2="12" y2="12"></line>
						<line x1="9" y1="15" x2="15" y2="15"></line>
					</svg>
					<?php esc_html_e( 'Bulk Upload', 'visitaylesbury' ); ?>
				</button>
			</div>

			<div
				id="va-tab-single"
				class="va-submit-event__panel <?php echo $active_tab === 'single' ? 'is-active' : ''; ?>"
				role="tabpanel"
			>
				<?php if ( $single_form_id && class_exists( 'GFAPI' ) ) : ?>
					<?php gravity_form( $single_form_id, false, false, false, null, true ); ?>
				<?php else : ?>
					<div class="va-submit-event__notice">
						<p><?php esc_html_e( 'The event submission form is currently unavailable. Please try again later or contact us directly.', 'visitaylesbury' ); ?></p>
					</div>
				<?php endif; ?>
			</div>

			<div
				id="va-tab-bulk"
				class="va-submit-event__panel <?php echo $active_tab === 'bulk' ? 'is-active' : ''; ?>"
				role="tabpanel"
			>
				<?php if ( $bulk_form_id && class_exists( 'GFAPI' ) ) : ?>
					<?php gravity_form( $bulk_form_id, false, false, false, null, true ); ?>
				<?php else : ?>
					<div class="va-submit-event__notice">
						<p><?php esc_html_e( 'The bulk upload form is currently unavailable. Please try again later or contact us directly.', 'visitaylesbury' ); ?></p>
					</div>
				<?php endif; ?>
			</div>

		</div>

	</div>

</main>

<script>
(function () {
	var tabs = document.querySelectorAll('.va-submit-event__tab');
	var panels = document.querySelectorAll('.va-submit-event__panel');

	tabs.forEach(function (tab) {
		tab.addEventListener('click', function () {
			var target = this.getAttribute('data-tab');

			tabs.forEach(function (t) {
				t.classList.remove('is-active');
				t.setAttribute('aria-selected', 'false');
			});
			panels.forEach(function (p) {
				p.classList.remove('is-active');
			});

			this.classList.add('is-active');
			this.setAttribute('aria-selected', 'true');
			document.getElementById('va-tab-' + target).classList.add('is-active');
		});
	});

	// CSV template download.
	var downloadBtn = document.getElementById('va-csv-template-download');
	if (downloadBtn) {
		downloadBtn.addEventListener('click', function (e) {
			e.preventDefault();
			window.location.href = '<?php echo esc_js( admin_url( 'admin-ajax.php?action=va_download_csv_template' ) ); ?>';
		});
	}
})();
</script>

<?php
get_footer();
