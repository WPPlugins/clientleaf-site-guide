<?php
/** @var array<int, array<string, mixed>> $vexmedia_clientleaf_site_guide_quick_links */

defined( 'ABSPATH' ) || exit;

$vexmedia_clientleaf_site_guide_rows = ! empty( $vexmedia_clientleaf_site_guide_quick_links ) ? $vexmedia_clientleaf_site_guide_quick_links : array( array( 'label' => '', 'url' => '', 'description' => '', 'icon' => '', 'order' => 0 ) );

$vexmedia_clientleaf_site_guide_render_row = static function ( array $vexmedia_clientleaf_site_guide_link, string $vexmedia_clientleaf_site_guide_index ): void {
	$vexmedia_clientleaf_site_guide_prefix = \VexMedia\ClientleafSiteGuide\Settings::OPTION_QUICK_LINKS . '[' . $vexmedia_clientleaf_site_guide_index . ']';
	?>
	<div class="clientleaf-site-guide-link-row" data-clientleaf-site-guide-link-row>
		<div class="clientleaf-site-guide-link-row__header">
			<strong class="clientleaf-site-guide-link-row__title" data-title="<?php esc_attr_e( 'Quick Link', 'clientleaf-site-guide' ); ?>"><?php esc_html_e( 'Quick Link', 'clientleaf-site-guide' ); ?></strong>
			<div class="clientleaf-site-guide-link-row__controls">
				<button type="button" class="button button-small" data-clientleaf-site-guide-move="up"><span class="dashicons dashicons-arrow-up-alt2" aria-hidden="true"></span><span class="screen-reader-text"><?php esc_html_e( 'Move Quick Link up', 'clientleaf-site-guide' ); ?></span></button>
				<button type="button" class="button button-small" data-clientleaf-site-guide-move="down"><span class="dashicons dashicons-arrow-down-alt2" aria-hidden="true"></span><span class="screen-reader-text"><?php esc_html_e( 'Move Quick Link down', 'clientleaf-site-guide' ); ?></span></button>
				<button type="button" class="button button-small clientleaf-site-guide-remove-link" data-clientleaf-site-guide-remove><?php esc_html_e( 'Remove', 'clientleaf-site-guide' ); ?></button>
			</div>
		</div>
		<div class="clientleaf-site-guide-field-grid">
			<p>
				<label for="clientleaf-site-guide-link-<?php echo esc_attr( $vexmedia_clientleaf_site_guide_index ); ?>-label"><?php esc_html_e( 'Label', 'clientleaf-site-guide' ); ?> <span aria-hidden="true">*</span></label>
				<input class="regular-text" id="clientleaf-site-guide-link-<?php echo esc_attr( $vexmedia_clientleaf_site_guide_index ); ?>-label" name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_prefix ); ?>[label]" type="text" value="<?php echo esc_attr( (string) ( $vexmedia_clientleaf_site_guide_link['label'] ?? '' ) ); ?>" data-field="label">
			</p>
			<p>
				<label for="clientleaf-site-guide-link-<?php echo esc_attr( $vexmedia_clientleaf_site_guide_index ); ?>-url"><?php esc_html_e( 'URL', 'clientleaf-site-guide' ); ?> <span aria-hidden="true">*</span></label>
				<input class="regular-text" id="clientleaf-site-guide-link-<?php echo esc_attr( $vexmedia_clientleaf_site_guide_index ); ?>-url" name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_prefix ); ?>[url]" type="text" value="<?php echo esc_attr( (string) ( $vexmedia_clientleaf_site_guide_link['url'] ?? '' ) ); ?>" placeholder="/wp-admin/edit.php" data-field="url">
			</p>
			<p class="clientleaf-site-guide-field-grid__wide">
				<label for="clientleaf-site-guide-link-<?php echo esc_attr( $vexmedia_clientleaf_site_guide_index ); ?>-description"><?php esc_html_e( 'Short description', 'clientleaf-site-guide' ); ?></label>
				<textarea class="large-text" id="clientleaf-site-guide-link-<?php echo esc_attr( $vexmedia_clientleaf_site_guide_index ); ?>-description" name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_prefix ); ?>[description]" rows="2" data-field="description"><?php echo esc_textarea( (string) ( $vexmedia_clientleaf_site_guide_link['description'] ?? '' ) ); ?></textarea>
			</p>
			<p>
				<label for="clientleaf-site-guide-link-<?php echo esc_attr( $vexmedia_clientleaf_site_guide_index ); ?>-icon"><?php esc_html_e( 'Dashicon name', 'clientleaf-site-guide' ); ?></label>
				<input class="regular-text" id="clientleaf-site-guide-link-<?php echo esc_attr( $vexmedia_clientleaf_site_guide_index ); ?>-icon" name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_prefix ); ?>[icon]" type="text" value="<?php echo esc_attr( (string) ( $vexmedia_clientleaf_site_guide_link['icon'] ?? '' ) ); ?>" placeholder="edit" data-field="icon">
				<span class="description"><?php esc_html_e( 'Optional, for example: edit, admin-page, or plus-alt2.', 'clientleaf-site-guide' ); ?></span>
			</p>
		</div>
		<input type="hidden" name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_prefix ); ?>[order]" value="<?php echo esc_attr( (string) ( $vexmedia_clientleaf_site_guide_link['order'] ?? 0 ) ); ?>" data-clientleaf-site-guide-order>
	</div>
	<?php
};
?>
<div class="wrap clientleaf-site-guide-wrap clientleaf-site-guide-settings-page">
	<h1><?php esc_html_e( 'Quick Links', 'clientleaf-site-guide' ); ?></h1>
	<p class="clientleaf-site-guide-page-intro"><?php esc_html_e( 'Add the most useful places your client needs to visit. Rows with a missing label or invalid URL are not saved.', 'clientleaf-site-guide' ); ?></p>
	<?php settings_errors(); ?>
	<form action="options.php" method="post">
		<?php settings_fields( \VexMedia\ClientleafSiteGuide\Settings::GROUP_QUICK_LINKS ); ?>
		<div class="clientleaf-site-guide-link-rows" data-clientleaf-site-guide-link-rows>
			<?php foreach ( $vexmedia_clientleaf_site_guide_rows as $vexmedia_clientleaf_site_guide_index => $vexmedia_clientleaf_site_guide_link ) : ?>
				<?php $vexmedia_clientleaf_site_guide_render_row( $vexmedia_clientleaf_site_guide_link, (string) $vexmedia_clientleaf_site_guide_index ); ?>
			<?php endforeach; ?>
		</div>
		<p><button type="button" class="button" data-clientleaf-site-guide-add-link><?php esc_html_e( 'Add Quick Link', 'clientleaf-site-guide' ); ?></button></p>
		<p class="description"><?php esc_html_e( 'Use HTTP(S) addresses, root-relative paths such as /wp-admin/edit.php, or paths relative to the website home. Links do not grant access to their destination.', 'clientleaf-site-guide' ); ?></p>
		<noscript><p><?php esc_html_e( 'Enable JavaScript to add, remove, or reorder Quick Links.', 'clientleaf-site-guide' ); ?></p></noscript>
		<?php submit_button( __( 'Save Quick Links', 'clientleaf-site-guide' ) ); ?>
	</form>
	<template id="clientleaf-site-guide-link-row-template">
		<?php $vexmedia_clientleaf_site_guide_render_row( array( 'label' => '', 'url' => '', 'description' => '', 'icon' => '', 'order' => 0 ), '__INDEX__' ); ?>
	</template>
</div>
