<?php
/**
 * Conditional Clientleaf Site Guide data cleanup.
 *
 * @package ClientleafSiteGuide
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$vexmedia_clientleaf_site_guide_options = array(
	'vexmedia_clientleaf_site_guide_settings',
	'vexmedia_clientleaf_site_guide_quick_links',
	'vexmedia_clientleaf_site_guide_website_info',
	'vexmedia_clientleaf_site_guide_support',
	'vexmedia_clientleaf_site_guide_db_version',
);

if ( is_multisite() ) {
	$vexmedia_clientleaf_site_guide_site_ids = get_sites( array( 'fields' => 'ids', 'number' => 0 ) );
	foreach ( $vexmedia_clientleaf_site_guide_site_ids as $vexmedia_clientleaf_site_guide_site_id ) {
		switch_to_blog( (int) $vexmedia_clientleaf_site_guide_site_id );
		$vexmedia_clientleaf_site_guide_settings = get_option( 'vexmedia_clientleaf_site_guide_settings', array() );
		if ( ! is_array( $vexmedia_clientleaf_site_guide_settings ) || ! in_array( $vexmedia_clientleaf_site_guide_settings['remove_on_uninstall'] ?? false, array( true, 1, '1' ), true ) ) {
			restore_current_blog();
			continue;
		}
		foreach ( $vexmedia_clientleaf_site_guide_options as $vexmedia_clientleaf_site_guide_option ) {
			delete_option( $vexmedia_clientleaf_site_guide_option );
		}
		restore_current_blog();
	}
} else {
	$vexmedia_clientleaf_site_guide_settings = get_option( 'vexmedia_clientleaf_site_guide_settings', array() );
	if ( is_array( $vexmedia_clientleaf_site_guide_settings ) && in_array( $vexmedia_clientleaf_site_guide_settings['remove_on_uninstall'] ?? false, array( true, 1, '1' ), true ) ) {
		foreach ( $vexmedia_clientleaf_site_guide_options as $vexmedia_clientleaf_site_guide_option ) {
			delete_option( $vexmedia_clientleaf_site_guide_option );
		}
	}
}
