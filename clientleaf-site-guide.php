<?php
/**
 * Plugin Name: Clientleaf Site Guide
 * Description: A simple client dashboard and website handover guide for WordPress.
 * Version: 0.1.6
 * Author: Vex Media Ltd
 * Text Domain: clientleaf-site-guide
 * Requires PHP: 8.1
 * Requires at least: 7.1
 * License: GPL-2.0-or-later
 */

namespace VexMedia\ClientleafSiteGuide;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'VEXMEDIA_CLIENTLEAF_SITE_GUIDE_VERSION', '0.1.6' );
define( 'VEXMEDIA_CLIENTLEAF_SITE_GUIDE_DB_VERSION', '2' );
define( 'VEXMEDIA_CLIENTLEAF_SITE_GUIDE_FILE', __FILE__ );
define( 'VEXMEDIA_CLIENTLEAF_SITE_GUIDE_DIR', plugin_dir_path( __FILE__ ) );
define( 'VEXMEDIA_CLIENTLEAF_SITE_GUIDE_URL', plugin_dir_url( __FILE__ ) );

require_once VEXMEDIA_CLIENTLEAF_SITE_GUIDE_DIR . 'includes/helpers.php';
require_once VEXMEDIA_CLIENTLEAF_SITE_GUIDE_DIR . 'includes/class-settings.php';
require_once VEXMEDIA_CLIENTLEAF_SITE_GUIDE_DIR . 'includes/class-admin.php';
require_once VEXMEDIA_CLIENTLEAF_SITE_GUIDE_DIR . 'includes/class-plugin.php';

register_activation_hook( __FILE__, array( Plugin::class, 'activate' ) );
register_deactivation_hook( __FILE__, array( Plugin::class, 'deactivate' ) );

Plugin::instance()->run();
