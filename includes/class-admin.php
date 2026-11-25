<?php
/**
 * Clientleaf Site Guide admin menus, pages, and scoped assets.
 *
 * @package ClientleafSiteGuide
 */

namespace VexMedia\ClientleafSiteGuide;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Admin {
	/** @var array<int, string> */
	private array $page_hooks = array();

	/**
	 * Offer client shortcuts on the native WordPress Dashboard, without extra assets.
	 */
	public function register_dashboard_widget(): void {
		if ( ! $this->can_view() || ! Settings::get_settings()['show_dashboard_widget'] ) {
			return;
		}
		wp_add_dashboard_widget( 'vexmedia_clientleaf_site_guide_overview', __( 'Clientleaf Site Guide — Your Website', 'clientleaf-site-guide' ), array( $this, 'render_dashboard_widget' ) );
	}

	public function render_dashboard_widget(): void {
		if ( ! $this->can_view() ) {
			return;
		}
		$settings = Settings::get_settings();
		if ( ! $settings['show_dashboard_widget'] ) {
			return;
		}
		echo '<p>' . esc_html( $settings['intro_message'] ) . '</p>';
		if ( $settings['show_quick_actions'] ) {
			$links = array_slice( Settings::get_quick_links(), 0, 3 );
			if ( $links ) {
				echo '<ul>';
				foreach ( $links as $link ) {
					echo '<li><a href="' . esc_url( link_url( $link['url'] ) ) . '">' . esc_html( $link['label'] ) . '</a></li>';
				}
				echo '</ul>';
			}
		}
		echo '<p><a class="button" href="' . esc_url( admin_url( 'admin.php?page=clientleaf-site-guide' ) ) . '">' . esc_html__( 'Open your website guide', 'clientleaf-site-guide' ) . '</a></p>';
	}

	/**
	 * Keep the shortcut in wp-admin only; leave the public-facing toolbar unchanged.
	 */
	public function register_toolbar_shortcut( \WP_Admin_Bar $admin_bar ): void {
		if ( ! is_admin() || is_network_admin() || is_user_admin() || ! $this->can_view() || ! Settings::get_settings()['show_toolbar_shortcut'] ) {
			return;
		}
		$admin_bar->add_node( array(
			'id'    => 'vexmedia-clientleaf-site-guide',
			'title' => __( 'Clientleaf Site Guide', 'clientleaf-site-guide' ),
			'href'  => admin_url( 'admin.php?page=clientleaf-site-guide' ),
		) );
	}

	private function can_view(): bool {
		return current_user_can( Settings::management_capability() ) || current_user_can( Settings::view_capability() );
	}

	/**
	 * Register the Clientleaf Site Guide menu and pages.
	 */
	public function register_menu(): void {
		$view_capability = current_user_can( Settings::management_capability() ) ? Settings::management_capability() : Settings::view_capability();
		$manage_capability = Settings::management_capability();
		$settings = Settings::get_settings();
		$position = 'near_bottom' === $settings['menu_position'] ? 80 : 3;

		/**
		 * Filter the numeric Clientleaf Site Guide top-level admin menu position.
		 *
		 * @param int $position Configured menu position.
		 */
		$position = apply_filters( 'vexmedia_clientleaf_dashboard/menu_position', $position );
		$position = absint( apply_filters( 'vexmedia_clientleaf_site_guide/menu_position', $position ) );

		$this->add_page_hook(
			add_menu_page(
				__( 'Clientleaf Site Guide', 'clientleaf-site-guide' ),
				__( 'Clientleaf Site Guide', 'clientleaf-site-guide' ),
				$view_capability,
				'clientleaf-site-guide',
				array( $this, 'render_dashboard' ),
				'dashicons-welcome-learn-more',
				$position
			)
		);

		$this->add_page_hook( add_submenu_page( 'clientleaf-site-guide', __( 'Your Website', 'clientleaf-site-guide' ), __( 'Dashboard', 'clientleaf-site-guide' ), $view_capability, 'clientleaf-site-guide', array( $this, 'render_dashboard' ) ) );
		$this->add_page_hook( add_submenu_page( 'clientleaf-site-guide', __( 'Quick Links', 'clientleaf-site-guide' ), __( 'Quick Links', 'clientleaf-site-guide' ), $manage_capability, 'clientleaf-site-guide-quick-links', array( $this, 'render_quick_links' ) ) );
		$this->add_page_hook( add_submenu_page( 'clientleaf-site-guide', __( 'Website Info', 'clientleaf-site-guide' ), __( 'Website Info', 'clientleaf-site-guide' ), $manage_capability, 'clientleaf-site-guide-website-info', array( $this, 'render_website_info' ) ) );
		$this->add_page_hook( add_submenu_page( 'clientleaf-site-guide', __( 'Support', 'clientleaf-site-guide' ), __( 'Support', 'clientleaf-site-guide' ), $manage_capability, 'clientleaf-site-guide-support', array( $this, 'render_support' ) ) );
		$this->add_page_hook( add_submenu_page( 'clientleaf-site-guide', __( 'Settings', 'clientleaf-site-guide' ), __( 'Settings', 'clientleaf-site-guide' ), $manage_capability, 'clientleaf-site-guide-settings', array( $this, 'render_settings' ) ) );
	}

	/**
	 * Enqueue assets only on registered Clientleaf Site Guide screens.
	 */
	public function enqueue_assets( string $hook_suffix ): void {
		if ( ! in_array( $hook_suffix, $this->page_hooks, true ) ) {
			return;
		}

		wp_enqueue_style( 'vexmedia-clientleaf-site-guide-admin', VEXMEDIA_CLIENTLEAF_SITE_GUIDE_URL . 'admin/css/clientleaf-site-guide-admin.css', array(), VEXMEDIA_CLIENTLEAF_SITE_GUIDE_VERSION );
		if ( str_ends_with( $hook_suffix, '_clientleaf-site-guide-quick-links' ) ) {
			wp_enqueue_script( 'vexmedia-clientleaf-site-guide-admin', VEXMEDIA_CLIENTLEAF_SITE_GUIDE_URL . 'admin/js/clientleaf-site-guide-admin.js', array(), VEXMEDIA_CLIENTLEAF_SITE_GUIDE_VERSION, true );
		}
	}

	/**
	 * Add a settings shortcut on the Plugins screen.
	 *
	 * @param array<int, string> $links Existing links.
	 * @return array<int, string>
	 */
	public function plugin_action_links( array $links ): array {
		if ( current_user_can( Settings::management_capability() ) ) {
			array_unshift( $links, '<a href="' . esc_url( admin_url( 'admin.php?page=clientleaf-site-guide-settings' ) ) . '">' . esc_html__( 'Settings', 'clientleaf-site-guide' ) . '</a>' );
		}

		return $links;
	}

	public function render_dashboard(): void {
		$this->assert_capability( current_user_can( Settings::management_capability() ) ? Settings::management_capability() : Settings::view_capability() );
		$settings     = Settings::get_settings();
		$quick_links  = Settings::get_quick_links();
		$website_info = Settings::get_website_info();
		$support      = Settings::get_support();

		$this->render_view( 'dashboard', compact( 'settings', 'quick_links', 'website_info', 'support' ) );
	}

	public function render_quick_links(): void {
		$this->assert_capability( Settings::management_capability() );
		$quick_links = Settings::get_quick_links();
		$this->render_view( 'quick-links', compact( 'quick_links' ) );
	}

	public function render_website_info(): void {
		$this->assert_capability( Settings::management_capability() );
		$website_info = Settings::get_website_info();
		$this->render_view( 'website-info', compact( 'website_info' ) );
	}

	public function render_support(): void {
		$this->assert_capability( Settings::management_capability() );
		$support = Settings::get_support();
		$this->render_view( 'support', compact( 'support' ) );
	}

	public function render_settings(): void {
		$this->assert_capability( Settings::management_capability() );
		$settings = Settings::get_settings();
		$capability_choices = Settings::view_capability_choices();
		$this->render_view( 'settings', compact( 'settings', 'capability_choices' ) );
	}

	private function assert_capability( string $capability ): void {
		if ( ! current_user_can( $capability ) ) {
			wp_die( esc_html__( 'You do not have permission to access this Clientleaf Site Guide page.', 'clientleaf-site-guide' ), '', array( 'response' => 403 ) );
		}
	}

	/**
	 * Include a trusted internal view with a small variable scope.
	 *
	 * @param string               $view View basename.
	 * @param array<string, mixed> $variables View variables.
	 */
	private function render_view( string $view, array $variables ): void {
		$vexmedia_clientleaf_site_guide_settings           = $variables['settings'] ?? array();
		$vexmedia_clientleaf_site_guide_quick_links        = $variables['quick_links'] ?? array();
		$vexmedia_clientleaf_site_guide_website_info       = $variables['website_info'] ?? array();
		$vexmedia_clientleaf_site_guide_support            = $variables['support'] ?? array();
		$vexmedia_clientleaf_site_guide_capability_choices = $variables['capability_choices'] ?? array();
		include VEXMEDIA_CLIENTLEAF_SITE_GUIDE_DIR . 'admin/views/' . $view . '.php';
	}

	private function add_page_hook( string|false $hook ): void {
		if ( is_string( $hook ) && '' !== $hook ) {
			$this->page_hooks[] = $hook;
		}
	}
}
