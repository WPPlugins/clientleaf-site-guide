<?php
/** @var array<string, string> $vexmedia_clientleaf_site_guide_website_info */

defined( 'ABSPATH' ) || exit;
$vexmedia_clientleaf_site_guide_option = \VexMedia\ClientleafSiteGuide\Settings::OPTION_WEBSITE_INFO;
?>
<div class="wrap clientleaf-site-guide-wrap clientleaf-site-guide-settings-page">
	<h1><?php esc_html_e( 'Website Info', 'clientleaf-site-guide' ); ?></h1>
	<p class="clientleaf-site-guide-page-intro"><?php esc_html_e( 'Record practical website details for the client. Never store passwords, credentials, licence keys, or other secrets here.', 'clientleaf-site-guide' ); ?></p>
	<?php settings_errors(); ?>
	<form action="options.php" method="post">
		<?php settings_fields( \VexMedia\ClientleafSiteGuide\Settings::GROUP_WEBSITE_INFO ); ?>
		<table class="form-table" role="presentation">
			<tr>
				<th scope="row"><label for="clientleaf-site-guide-website-name"><?php esc_html_e( 'Website name', 'clientleaf-site-guide' ); ?></label></th>
				<td><input class="regular-text" id="clientleaf-site-guide-website-name" name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_option ); ?>[website_name]" type="text" value="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_website_info['website_name'] ); ?>"></td>
			</tr>
			<tr>
				<th scope="row"><label for="clientleaf-site-guide-website-url"><?php esc_html_e( 'Website URL', 'clientleaf-site-guide' ); ?></label></th>
				<td><input class="regular-text" id="clientleaf-site-guide-website-url" name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_option ); ?>[website_url]" type="url" value="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_website_info['website_url'] ); ?>" placeholder="https://example.com"></td>
			</tr>
			<tr>
				<th scope="row"><label for="clientleaf-site-guide-hosting"><?php esc_html_e( 'Hosting provider', 'clientleaf-site-guide' ); ?></label></th>
				<td><input class="regular-text" id="clientleaf-site-guide-hosting" name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_option ); ?>[hosting]" type="text" value="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_website_info['hosting'] ); ?>"></td>
			</tr>
			<tr>
				<th scope="row"><label for="clientleaf-site-guide-domain"><?php esc_html_e( 'Domain provider', 'clientleaf-site-guide' ); ?></label></th>
				<td><input class="regular-text" id="clientleaf-site-guide-domain" name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_option ); ?>[domain]" type="text" value="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_website_info['domain'] ); ?>"></td>
			</tr>
			<tr>
				<th scope="row"><label for="clientleaf-site-guide-developer"><?php esc_html_e( 'Developer or agency', 'clientleaf-site-guide' ); ?></label></th>
				<td><input class="regular-text" id="clientleaf-site-guide-developer" name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_option ); ?>[developer]" type="text" value="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_website_info['developer'] ); ?>"></td>
			</tr>
			<tr>
				<th scope="row"><label for="clientleaf-site-guide-launch-date"><?php esc_html_e( 'Launch date', 'clientleaf-site-guide' ); ?></label></th>
				<td><input id="clientleaf-site-guide-launch-date" name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_option ); ?>[launch_date]" type="date" value="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_website_info['launch_date'] ); ?>"></td>
			</tr>
			<tr>
				<th scope="row"><label for="clientleaf-site-guide-general-notes"><?php esc_html_e( 'General notes', 'clientleaf-site-guide' ); ?></label></th>
				<td><textarea class="large-text" id="clientleaf-site-guide-general-notes" name="<?php echo esc_attr( $vexmedia_clientleaf_site_guide_option ); ?>[general_notes]" rows="6"><?php echo esc_textarea( $vexmedia_clientleaf_site_guide_website_info['general_notes'] ); ?></textarea></td>
			</tr>
		</table>
		<?php submit_button( __( 'Save Website Info', 'clientleaf-site-guide' ) ); ?>
	</form>
</div>
