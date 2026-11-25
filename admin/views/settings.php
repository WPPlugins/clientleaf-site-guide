<?php
/** @var array<string, mixed> $vexmedia_clientleaf_site_guide_settings */
/** @var array<string, string> $vexmedia_clientleaf_site_guide_capability_choices */

defined( 'ABSPATH' ) || exit;
$vexmedia_clientleaf_site_guide_option = \VexMedia\ClientleafSiteGuide\Settings::OPTION_SETTINGS;
?>
<div class="wrap clientleaf-site-guide-wrap clientleaf-site-guide-settings-page">
	<h1><?php esc_html_e( 'Clientleaf Site Guide Settings', 'clientleaf-site-guide' ); ?></h1>
	<p class="clientleaf-site-guide-page-intro"><?php esc_html_e( 'Control what clients see on the Your Website dashboard.', 'clientleaf-site-guide' ); ?></p>
	<?php settings_errors(); ?>
	<form action="options.php" method="post">
		<?php settings_fields( \VexMedia\ClientleafSiteGuide\Settings::GROUP_SETTINGS ); ?>
		<h2><?php esc_html_e( 'Dashboard content', 'clientleaf-site-guide' ); ?></h2>
		<table class="form-table" role="presentation">
			<tr>
				<th scope="row"><label for="clientleaf-site-guide-dashboard-heading"><?php esc_html_e( 'Dashboard heading', 'clientleaf-site-guide' ); ?></label></th>
				<td><input class="regular-text" id="clientleaf-site-guide-dashboard-heading" name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_option ); ?>[dashboard_heading]" type="text" value="<?php echo esc_attr( (string) $vexmedia_clientleaf_site_guide_settings['dashboard_heading'] ); ?>"></td>
			</tr>
			<tr>
				<th scope="row"><label for="clientleaf-site-guide-intro-message"><?php esc_html_e( 'Introductory message', 'clientleaf-site-guide' ); ?></label></th>
				<td><textarea class="large-text" id="clientleaf-site-guide-intro-message" name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_option ); ?>[intro_message]" rows="3"><?php echo esc_textarea( (string) $vexmedia_clientleaf_site_guide_settings['intro_message'] ); ?></textarea></td>
			</tr>
			<tr>
				<th scope="row"><label for="clientleaf_site_guide_helpful_notes"><?php esc_html_e( 'Helpful Notes content', 'clientleaf-site-guide' ); ?></label></th>
				<td>
					<?php \VexMedia\ClientleafSiteGuide\render_notes_editor( (string) $vexmedia_clientleaf_site_guide_settings['helpful_notes'], 'clientleaf_site_guide_helpful_notes', $vexmedia_clientleaf_site_guide_option . '[helpful_notes]' ); ?>
					<p class="description"><?php esc_html_e( 'Write the guidance your client needs. Use the toolbar for emphasis, lists, and links.', 'clientleaf-site-guide' ); ?></p>
				</td>
			</tr>
		</table>

		<h2><?php esc_html_e( 'Visible sections', 'clientleaf-site-guide' ); ?></h2>
		<fieldset class="clientleaf-site-guide-checkbox-list">
			<legend class="screen-reader-text"><?php esc_html_e( 'Visible sections', 'clientleaf-site-guide' ); ?></legend>
			<label><input name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_option ); ?>[show_quick_actions]" type="checkbox" value="1" <?php checked( ! empty( $vexmedia_clientleaf_site_guide_settings['show_quick_actions'] ) ); ?>> <?php esc_html_e( 'Show Quick Actions', 'clientleaf-site-guide' ); ?></label>
			<label><input name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_option ); ?>[show_website_info]" type="checkbox" value="1" <?php checked( ! empty( $vexmedia_clientleaf_site_guide_settings['show_website_info'] ) ); ?>> <?php esc_html_e( 'Show Website Information', 'clientleaf-site-guide' ); ?></label>
			<label><input name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_option ); ?>[show_support]" type="checkbox" value="1" <?php checked( ! empty( $vexmedia_clientleaf_site_guide_settings['show_support'] ) ); ?>> <?php esc_html_e( 'Show Support', 'clientleaf-site-guide' ); ?></label>
			<label><input name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_option ); ?>[show_helpful_notes]" type="checkbox" value="1" <?php checked( ! empty( $vexmedia_clientleaf_site_guide_settings['show_helpful_notes'] ) ); ?>> <?php esc_html_e( 'Show Helpful Notes', 'clientleaf-site-guide' ); ?></label>
		</fieldset>

		<h2><?php esc_html_e( 'Access and behaviour', 'clientleaf-site-guide' ); ?></h2>
		<fieldset class="clientleaf-site-guide-checkbox-list">
			<legend class="screen-reader-text"><?php esc_html_e( 'WordPress shortcuts', 'clientleaf-site-guide' ); ?></legend>
			<label><input name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_option ); ?>[show_dashboard_widget]" type="checkbox" value="1" <?php checked( $vexmedia_clientleaf_site_guide_settings['show_dashboard_widget'] ); ?>> <?php esc_html_e( 'Show Clientleaf Site Guide on the WordPress Dashboard', 'clientleaf-site-guide' ); ?></label>
			<label><input name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_option ); ?>[show_toolbar_shortcut]" type="checkbox" value="1" <?php checked( $vexmedia_clientleaf_site_guide_settings['show_toolbar_shortcut'] ); ?>> <?php esc_html_e( 'Show Clientleaf Site Guide in the admin toolbar', 'clientleaf-site-guide' ); ?></label>
		</fieldset>
		<table class="form-table" role="presentation">
			<tr>
				<th scope="row"><label for="clientleaf-site-guide-view-capability"><?php esc_html_e( 'Minimum dashboard capability', 'clientleaf-site-guide' ); ?></label></th>
				<td>
					<select id="clientleaf-site-guide-view-capability" name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_option ); ?>[view_capability]">
						<?php foreach ( $vexmedia_clientleaf_site_guide_capability_choices as $vexmedia_clientleaf_site_guide_capability => $vexmedia_clientleaf_site_guide_label ) : ?>
							<option value="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_capability ); ?>" <?php selected( $vexmedia_clientleaf_site_guide_settings['view_capability'], $vexmedia_clientleaf_site_guide_capability ); ?>><?php echo esc_html( $vexmedia_clientleaf_site_guide_label ); ?></option>
						<?php endforeach; ?>
					</select>
					<p class="description"><?php esc_html_e( 'Capabilities are checked on every request. This setting does not change any user role.', 'clientleaf-site-guide' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="clientleaf-site-guide-menu-position"><?php esc_html_e( 'Admin menu position', 'clientleaf-site-guide' ); ?></label></th>
				<td>
					<select id="clientleaf-site-guide-menu-position" name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_option ); ?>[menu_position]">
						<option value="near_dashboard" <?php selected( $vexmedia_clientleaf_site_guide_settings['menu_position'], 'near_dashboard' ); ?>><?php esc_html_e( 'Near the top, after Dashboard', 'clientleaf-site-guide' ); ?></option>
						<option value="near_bottom" <?php selected( $vexmedia_clientleaf_site_guide_settings['menu_position'], 'near_bottom' ); ?>><?php esc_html_e( 'Near the bottom', 'clientleaf-site-guide' ); ?></option>
					</select>
				</td>
			</tr>
		</table>

		<h2><?php esc_html_e( 'Uninstall', 'clientleaf-site-guide' ); ?></h2>
		<label class="clientleaf-site-guide-danger-setting">
			<input name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_option ); ?>[remove_on_uninstall]" type="checkbox" value="1" <?php checked( ! empty( $vexmedia_clientleaf_site_guide_settings['remove_on_uninstall'] ) ); ?>>
			<span><strong><?php esc_html_e( 'Remove Clientleaf Site Guide data on uninstall', 'clientleaf-site-guide' ); ?></strong><br><?php esc_html_e( 'When enabled, deleting the plugin removes only Clientleaf Site Guide-owned options. Deactivation never removes data.', 'clientleaf-site-guide' ); ?></span>
		</label>

		<?php submit_button( __( 'Save Settings', 'clientleaf-site-guide' ) ); ?>
	</form>
</div>
