<?php
/**
 * Clientleaf Site Guide settings storage and validation.
 *
 * @package ClientleafSiteGuide
 */

namespace VexMedia\ClientleafSiteGuide;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Settings {
	public const OPTION_SETTINGS     = 'vexmedia_clientleaf_site_guide_settings';
	public const OPTION_QUICK_LINKS  = 'vexmedia_clientleaf_site_guide_quick_links';
	public const OPTION_WEBSITE_INFO = 'vexmedia_clientleaf_site_guide_website_info';
	public const OPTION_SUPPORT      = 'vexmedia_clientleaf_site_guide_support';
	public const OPTION_DB_VERSION   = 'vexmedia_clientleaf_site_guide_db_version';

	public const GROUP_SETTINGS     = 'vexmedia_clientleaf_site_guide_settings_group';
	public const GROUP_QUICK_LINKS  = 'vexmedia_clientleaf_site_guide_quick_links_group';
	public const GROUP_WEBSITE_INFO = 'vexmedia_clientleaf_site_guide_website_info_group';
	public const GROUP_SUPPORT      = 'vexmedia_clientleaf_site_guide_support_group';

	/**
	 * Register all Settings API options and capability filters.
	 */
	public function register(): void {
		register_setting(
			self::GROUP_SETTINGS,
			self::OPTION_SETTINGS,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'sanitize_settings' ),
				'default'           => self::default_settings(),
			)
		);

		register_setting(
			self::GROUP_QUICK_LINKS,
			self::OPTION_QUICK_LINKS,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'sanitize_quick_links' ),
				'default'           => array(),
			)
		);

		register_setting(
			self::GROUP_WEBSITE_INFO,
			self::OPTION_WEBSITE_INFO,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'sanitize_website_info' ),
				'default'           => self::default_website_info(),
			)
		);

		register_setting(
			self::GROUP_SUPPORT,
			self::OPTION_SUPPORT,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'sanitize_support' ),
				'default'           => self::default_support(),
			)
		);

		foreach ( array( self::GROUP_SETTINGS, self::GROUP_QUICK_LINKS, self::GROUP_WEBSITE_INFO, self::GROUP_SUPPORT ) as $group ) {
			add_filter( 'option_page_capability_' . $group, array( $this, 'settings_page_capability' ) );
		}
	}

	/**
	 * Capability enforced by options.php for every Clientleaf Site Guide settings group.
	 */
	public function settings_page_capability(): string {
		return self::management_capability();
	}

	/**
	 * Default dashboard settings.
	 *
	 * @return array<string, mixed>
	 */
	public static function default_settings(): array {
		return array(
			'dashboard_heading'    => __( 'Your Website', 'clientleaf-site-guide' ),
			'intro_message'        => __( 'Use the links and information below to manage your website.', 'clientleaf-site-guide' ),
			'helpful_notes'        => '',
			'show_quick_actions'   => true,
			'show_website_info'    => true,
			'show_support'         => true,
			'show_helpful_notes'   => true,
			'show_dashboard_widget'=> true,
			'show_toolbar_shortcut'=> true,
			'view_capability'      => 'edit_pages',
			'menu_position'        => 'near_dashboard',
			'remove_on_uninstall'  => false,
		);
	}

	/**
	 * Default website information, captured once when the option is created.
	 *
	 * @return array<string, string>
	 */
	public static function default_website_info(): array {
		return array(
			'website_name'   => get_bloginfo( 'name' ),
			'website_url'    => home_url( '/' ),
			'hosting'        => '',
			'domain'         => '',
			'developer'      => '',
			'launch_date'    => '',
			'general_notes'  => '',
		);
	}

	/**
	 * Default support information.
	 *
	 * @return array<string, string>
	 */
	public static function default_support(): array {
		return array(
			'name'    => '',
			'email'   => '',
			'phone'   => '',
			'url'     => '',
			'message' => '',
		);
	}

	/**
	 * Retrieve validated dashboard settings with defaults.
	 *
	 * @return array<string, mixed>
	 */
	public static function get_settings(): array {
		$settings = get_option( self::OPTION_SETTINGS, array() );
		$settings = is_array( $settings ) ? $settings : array();
		$settings = wp_parse_args( $settings, self::default_settings() );

		return ( new self() )->sanitize_settings( $settings );
	}

	/**
	 * Retrieve quick links.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	public static function get_quick_links(): array {
		$links = get_option( self::OPTION_QUICK_LINKS, array() );

		return ( new self() )->sanitize_quick_links( $links, false );
	}

	/**
	 * Retrieve website information with defaults.
	 *
	 * @return array<string, string>
	 */
	public static function get_website_info(): array {
		$value = get_option( self::OPTION_WEBSITE_INFO, array() );

		return ( new self() )->sanitize_website_info( wp_parse_args( is_array( $value ) ? $value : array(), array_fill_keys( array_keys( self::default_website_info() ), '' ) ), false );
	}

	/**
	 * Retrieve support information with defaults.
	 *
	 * @return array<string, string>
	 */
	public static function get_support(): array {
		$value = get_option( self::OPTION_SUPPORT, array() );

		return ( new self() )->sanitize_support( $value, false );
	}

	/**
	 * Capability required to configure Clientleaf Site Guide.
	 */
	public static function management_capability(): string {
		/**
		 * Filter the capability required to configure Clientleaf Site Guide.
		 *
		 * @param string $capability Default capability.
		 */
		$capability = apply_filters( 'vexmedia_clientleaf_dashboard/manage_capability', 'manage_options' );
		$capability = apply_filters( 'vexmedia_clientleaf_site_guide/manage_capability', $capability );

		return is_string( $capability ) && '' !== sanitize_key( $capability ) ? sanitize_key( $capability ) : 'manage_options';
	}

	/**
	 * Capability required to view the client dashboard.
	 */
	public static function view_capability(): string {
		$settings = self::get_settings();

		/**
		 * Filter the capability required to view the Clientleaf Site Guide dashboard.
		 *
		 * @param string $capability Configured capability.
		 */
		$capability = apply_filters( 'vexmedia_clientleaf_dashboard/view_capability', $settings['view_capability'] );
		$capability = apply_filters( 'vexmedia_clientleaf_site_guide/view_capability', $capability );

		return is_string( $capability ) && '' !== sanitize_key( $capability ) ? sanitize_key( $capability ) : 'edit_pages';
	}

	/**
	 * Available dashboard capability choices.
	 *
	 * @return array<string, string>
	 */
	public static function view_capability_choices(): array {
		$choices = array(
			'read'          => __( 'Any logged-in user (read)', 'clientleaf-site-guide' ),
			'edit_posts'    => __( 'Content editors (edit_posts)', 'clientleaf-site-guide' ),
			'edit_pages'    => __( 'Page editors (edit_pages)', 'clientleaf-site-guide' ),
			'publish_posts' => __( 'Publishers (publish_posts)', 'clientleaf-site-guide' ),
			'manage_options'=> __( 'Administrators (manage_options)', 'clientleaf-site-guide' ),
		);

		/**
		 * Filter the allowlist of dashboard capability choices.
		 *
		 * @param array<string, string> $choices Capability labels keyed by capability.
		 */
		$filtered = apply_filters( 'vexmedia_clientleaf_dashboard/view_capability_choices', $choices );
		$filtered = apply_filters( 'vexmedia_clientleaf_site_guide/view_capability_choices', $filtered );

		if ( ! is_array( $filtered ) ) {
			return $choices;
		}
		return array_filter( $filtered, static fn ( $label, $key ): bool => is_string( $key ) && '' !== $key && sanitize_key( $key ) === $key && is_string( $label ), ARRAY_FILTER_USE_BOTH ) + array( 'edit_pages' => $choices['edit_pages'] );
	}

	/**
	 * Sanitize general dashboard settings.
	 *
	 * @param mixed $input Submitted option.
	 * @return array<string, mixed>
	 */
	public function sanitize_settings( mixed $input ): array {
		$input    = is_array( $input ) ? $input : array();
		$defaults = self::default_settings();
		$heading  = sanitize_text_field( scalar_text( $input['dashboard_heading'] ?? '' ) );

		return array(
			'dashboard_heading'   => '' !== $heading ? $heading : $defaults['dashboard_heading'],
			'intro_message'       => sanitize_textarea_field( scalar_text( $input['intro_message'] ?? '' ) ),
			'helpful_notes'       => safe_notes( scalar_text( $input['helpful_notes'] ?? '' ) ),
			'show_quick_actions'  => enabled( $input['show_quick_actions'] ?? false ),
			'show_website_info'   => enabled( $input['show_website_info'] ?? false ),
			'show_support'        => enabled( $input['show_support'] ?? false ),
			'show_helpful_notes'  => enabled( $input['show_helpful_notes'] ?? false ),
			'show_dashboard_widget' => enabled( $input['show_dashboard_widget'] ?? false ),
			'show_toolbar_shortcut' => enabled( $input['show_toolbar_shortcut'] ?? false ),
			'view_capability'     => self::normalise_view_capability( $input['view_capability'] ?? '' ),
			'menu_position'       => in_array( $input['menu_position'] ?? '', array( 'near_dashboard', 'near_bottom' ), true ) ? $input['menu_position'] : 'near_dashboard',
			'remove_on_uninstall' => enabled( $input['remove_on_uninstall'] ?? false ),
		);
	}

	/**
	 * Sanitize repeatable quick-link rows.
	 *
	 * @param mixed $input Submitted option.
	 * @return array<int, array<string, mixed>>
	 */
	public function sanitize_quick_links( mixed $input, bool $report = true ): array {
		if ( ! is_array( $input ) ) {
			return array();
		}

		$links   = array();
		$omitted = 0;

		foreach ( $input as $index => $row ) {
			if ( ! is_array( $row ) ) {
				++$omitted;
				continue;
			}

			$label = sanitize_text_field( scalar_text( $row['label'] ?? '' ) );
			$url   = sanitize_link_url( $row['url'] ?? '' );

			if ( '' === $label && '' === trim( scalar_text( $row['url'] ?? '' ) ) ) {
				continue;
			}

			if ( '' === $label || '' === $url ) {
				++$omitted;
				continue;
			}

			$links[] = array(
				'label'       => $label,
				'url'         => $url,
				'description' => sanitize_textarea_field( scalar_text( $row['description'] ?? '' ) ),
				'icon'        => sanitize_dashicon( $row['icon'] ?? '' ),
				'order'       => absint( scalar_text( $row['order'] ?? $index ) ),
				'_index'      => count( $links ),
			);
		}

		usort(
			$links,
			static fn ( array $a, array $b ): int => ( $a['order'] <=> $b['order'] ) ?: ( $a['_index'] <=> $b['_index'] )
		);

		$links = array_values(
			array_map(
				static function ( array $link, int $index ): array {
					unset( $link['_index'] );
					$link['order'] = $index;
					return $link;
				},
				$links,
				array_keys( $links )
			)
		);

		if ( $report && $omitted > 0 ) {
			add_settings_error(
				self::OPTION_QUICK_LINKS,
				'vexmedia_clientleaf_site_guide_invalid_links',
				sprintf(
					/* translators: %d: Number of omitted quick links. */
					_n( '%d incomplete or invalid Quick Link was not saved.', '%d incomplete or invalid Quick Links were not saved.', $omitted, 'clientleaf-site-guide' ),
					$omitted
				),
				'warning'
			);
		}

		return $links;
	}

	/**
	 * Sanitize website information.
	 *
	 * @param mixed $input Submitted option.
	 * @return array<string, string>
	 */
	public function sanitize_website_info( mixed $input, bool $report = true ): array {
		$input = is_array( $input ) ? $input : array();
		$date  = sanitize_text_field( scalar_text( $input['launch_date'] ?? '' ) );

		if ( '' !== $date ) {
			$parsed = \DateTimeImmutable::createFromFormat( '!Y-m-d', $date );
			if ( false === $parsed || $parsed->format( 'Y-m-d' ) !== $date || (int) $parsed->format( 'Y' ) < 1 ) {
				$date = '';
				if ( $report ) {
					add_settings_error( self::OPTION_WEBSITE_INFO, 'vexmedia_clientleaf_site_guide_invalid_date', __( 'The launch date was invalid and was not saved.', 'clientleaf-site-guide' ), 'warning' );
				}
			}
		}

		return array(
			'website_name'  => sanitize_text_field( scalar_text( $input['website_name'] ?? '' ) ),
			'website_url'   => sanitize_link_url( $input['website_url'] ?? '' ),
			'hosting'       => sanitize_text_field( scalar_text( $input['hosting'] ?? '' ) ),
			'domain'        => sanitize_text_field( scalar_text( $input['domain'] ?? '' ) ),
			'developer'     => sanitize_text_field( scalar_text( $input['developer'] ?? '' ) ),
			'launch_date'   => $date,
			'general_notes' => sanitize_textarea_field( scalar_text( $input['general_notes'] ?? '' ) ),
		);
	}

	/**
	 * Sanitize support information.
	 *
	 * @param mixed $input Submitted option.
	 * @return array<string, string>
	 */
	public function sanitize_support( mixed $input, bool $report = true ): array {
		$input = is_array( $input ) ? $input : array();
		$email = sanitize_email( scalar_text( $input['email'] ?? '' ) );

		$email = is_email( $email ) ? $email : '';
		if ( $report && '' !== trim( scalar_text( $input['email'] ?? '' ) ) && '' === $email ) {
			add_settings_error( self::OPTION_SUPPORT, 'vexmedia_clientleaf_site_guide_invalid_email', __( 'The support email address was invalid and was not saved.', 'clientleaf-site-guide' ), 'warning' );
		}

		return array(
			'name'    => sanitize_text_field( scalar_text( $input['name'] ?? '' ) ),
			'email'   => $email,
			'phone'   => sanitize_text_field( scalar_text( $input['phone'] ?? '' ) ),
			'url'     => sanitize_link_url( $input['url'] ?? '' ),
			'message' => safe_notes( scalar_text( $input['message'] ?? '' ) ),
		);
	}

	/**
	 * Enforce the configured capability allowlist.
	 *
	 * @param mixed $capability Candidate capability.
	 */
	private static function normalise_view_capability( mixed $capability ): string {
		$capability = sanitize_key( scalar_text( $capability ) );
		$choices    = self::view_capability_choices();

		return array_key_exists( $capability, $choices ) ? $capability : 'edit_pages';
	}
}
