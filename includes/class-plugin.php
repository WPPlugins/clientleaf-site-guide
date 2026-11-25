<?php
/**
 * Main plugin lifecycle coordinator.
 *
 * @package ClientleafSiteGuide
 */

namespace VexMedia\ClientleafSiteGuide;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Plugin {
	private static ?Plugin $instance = null;

	private function __construct() {}

	public static function instance(): Plugin {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Register plugin behaviour.
	 */
	public function run(): void {
		$settings = new Settings();
		$admin    = new Admin();

		add_action( 'admin_init', array( $settings, 'register' ) );
		add_action( 'admin_init', array( $this, 'maybe_upgrade' ), 5 );
		add_action( 'admin_menu', array( $admin, 'register_menu' ) );
		add_action( 'wp_dashboard_setup', array( $admin, 'register_dashboard_widget' ) );
		add_action( 'admin_bar_menu', array( $admin, 'register_toolbar_shortcut' ), 80 );
		add_action( 'admin_enqueue_scripts', array( $admin, 'enqueue_assets' ) );
		add_filter( 'plugin_action_links_' . plugin_basename( VEXMEDIA_CLIENTLEAF_SITE_GUIDE_FILE ), array( $admin, 'plugin_action_links' ) );
	}

	/**
	 * Initialize only options that do not yet exist.
	 */
	public static function activate(): void {
		if ( false === get_option( Settings::OPTION_DB_VERSION, false ) && ! self::copy_legacy_options() ) {
			return;
		}
		self::add_option_if_missing( Settings::OPTION_SETTINGS, Settings::default_settings() );
		self::add_option_if_missing( Settings::OPTION_QUICK_LINKS, array() );
		self::add_option_if_missing( Settings::OPTION_WEBSITE_INFO, Settings::default_website_info() );
		self::add_option_if_missing( Settings::OPTION_SUPPORT, Settings::default_support() );
		self::add_option_if_missing( Settings::OPTION_DB_VERSION, VEXMEDIA_CLIENTLEAF_SITE_GUIDE_DB_VERSION );
	}

	/**
	 * Copy site-local data from an earlier package before installing defaults.
	 * If several copies exist, the active copy identifies the intended source.
	 */
	private static function copy_legacy_options(): bool {
		$active = array_merge( get_option( 'active_plugins', array() ), array_keys( (array) get_site_option( 'active_sitewide_plugins', array() ) ) );
		$sources = array();
		$running = array();
		foreach ( array( 'siteguide', 'handover-panel', 'clientleaf', 'clientleaf-handover', 'clientleaf-dashboard' ) as $slug ) {
			$prefix = 'vexmedia_' . str_replace( '-', '_', $slug ) . '_';
			if ( false === get_option( $prefix . 'db_version', false ) ) {
				continue;
			}
			$sources[] = $prefix;
			if ( in_array( $slug . '/' . $slug . '.php', $active, true ) ) {
				$running[] = $prefix;
			}
		}
		$sources = $running ? $running : $sources;
		if ( count( $sources ) > 1 ) {
			add_action( 'admin_notices', static function () {
				if ( current_user_can( 'activate_plugins' ) ) {
					wp_admin_notice( __( 'Clientleaf Site Guide found several earlier installations. Activate only the earlier plugin whose settings you want to keep, then refresh this screen to finish the upgrade.', 'clientleaf-site-guide' ), array( 'type' => 'warning' ) );
				}
			} );
			return false;
		}
		if ( $sources ) {
			$options = array(
				'settings'     => Settings::OPTION_SETTINGS,
				'quick_links'  => Settings::OPTION_QUICK_LINKS,
				'website_info' => Settings::OPTION_WEBSITE_INFO,
				'support'      => Settings::OPTION_SUPPORT,
			);
			foreach ( $options as $suffix => $destination ) {
				$value = get_option( $sources[0] . $suffix, false );
				if ( false !== $value ) {
					self::add_option_if_missing( $destination, $value );
				}
			}
		}
		return true;
	}

	/**
	 * Deactivation deliberately preserves all Clientleaf Site Guide data.
	 */
	public static function deactivate(): void {}

	/**
	 * Run targeted, idempotent admin-side migrations when needed.
	 */
	public function maybe_upgrade(): void {
		if ( ! current_user_can( Settings::management_capability() ) ) {
			return;
		}
		$stored_version = scalar_text( get_option( Settings::OPTION_DB_VERSION, '0' ) );

		if ( version_compare( $stored_version, VEXMEDIA_CLIENTLEAF_SITE_GUIDE_DB_VERSION, '>=' ) ) {
			return;
		}

		// Fill missing options, then add new preferences without replacing saved values.
		self::activate();
		if ( false === get_option( Settings::OPTION_DB_VERSION, false ) ) {
			return;
		}
		if ( version_compare( $stored_version, '2', '<' ) ) {
			$settings = get_option( Settings::OPTION_SETTINGS, array() );
			$settings = is_array( $settings ) ? $settings : array();
			$settings += array( 'show_dashboard_widget' => true, 'show_toolbar_shortcut' => true );
			update_option( Settings::OPTION_SETTINGS, $settings, false );
		}
		update_option( Settings::OPTION_DB_VERSION, VEXMEDIA_CLIENTLEAF_SITE_GUIDE_DB_VERSION, false );
	}

	/**
	 * Add a non-autoloaded option without overwriting an existing value.
	 *
	 * @param string $name  Option name.
	 * @param mixed  $value Initial value.
	 */
	private static function add_option_if_missing( string $name, mixed $value ): void {
		if ( false === get_option( $name, false ) ) {
			add_option( $name, $value, '', false );
		}
	}
}
