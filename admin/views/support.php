<?php
/** @var array<string, string> $vexmedia_clientleaf_site_guide_support */

defined( 'ABSPATH' ) || exit;
$vexmedia_clientleaf_site_guide_option = \VexMedia\ClientleafSiteGuide\Settings::OPTION_SUPPORT;
?>
<div class="wrap clientleaf-site-guide-wrap clientleaf-site-guide-settings-page">
	<h1><?php esc_html_e( 'Support', 'clientleaf-site-guide' ); ?></h1>
	<p class="clientleaf-site-guide-page-intro"><?php esc_html_e( 'Tell clients where to get help. Clientleaf Site Guide displays these details but does not send email.', 'clientleaf-site-guide' ); ?></p>
	<?php settings_errors(); ?>
	<form action="options.php" method="post">
		<?php settings_fields( \VexMedia\ClientleafSiteGuide\Settings::GROUP_SUPPORT ); ?>
		<table class="form-table" role="presentation">
			<tr>
				<th scope="row"><label for="clientleaf-site-guide-support-name"><?php esc_html_e( 'Support company or name', 'clientleaf-site-guide' ); ?></label></th>
				<td><input class="regular-text" id="clientleaf-site-guide-support-name" name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_option ); ?>[name]" type="text" value="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_support['name'] ); ?>"></td>
			</tr>
			<tr>
				<th scope="row"><label for="clientleaf-site-guide-support-email"><?php esc_html_e( 'Support email', 'clientleaf-site-guide' ); ?></label></th>
				<td><input class="regular-text" id="clientleaf-site-guide-support-email" name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_option ); ?>[email]" type="email" value="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_support['email'] ); ?>"></td>
			</tr>
			<tr>
				<th scope="row"><label for="clientleaf-site-guide-support-phone"><?php esc_html_e( 'Support phone', 'clientleaf-site-guide' ); ?></label></th>
				<td><input class="regular-text" id="clientleaf-site-guide-support-phone" name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_option ); ?>[phone]" type="tel" value="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_support['phone'] ); ?>"></td>
			</tr>
			<tr>
				<th scope="row"><label for="clientleaf-site-guide-support-url"><?php esc_html_e( 'Support URL', 'clientleaf-site-guide' ); ?></label></th>
				<td><input class="regular-text" id="clientleaf-site-guide-support-url" name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_option ); ?>[url]" type="url" value="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_support['url'] ); ?>" placeholder="https://example.com/support"></td>
			</tr>
			<tr>
				<th scope="row"><label for="clientleaf_site_guide_support_message"><?php esc_html_e( 'Support message', 'clientleaf-site-guide' ); ?></label></th>
				<td>
					<?php \VexMedia\ClientleafSiteGuide\render_notes_editor( $vexmedia_clientleaf_site_guide_support['message'], 'clientleaf_site_guide_support_message', $vexmedia_clientleaf_site_guide_option . '[message]' ); ?>
					<p class="description"><?php esc_html_e( 'Explain how to get help. Use the toolbar for emphasis, lists, and links.', 'clientleaf-site-guide' ); ?></p>
				</td>
			</tr>
		</table>
		<?php submit_button( __( 'Save Support Details', 'clientleaf-site-guide' ) ); ?>
	</form>
</div>
