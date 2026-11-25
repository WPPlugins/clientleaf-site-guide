<?php
/**
 * Shared presentation and sanitisation helpers.
 *
 * @package ClientleafSiteGuide
 */

namespace VexMedia\ClientleafSiteGuide;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Read a scalar without array-to-string warnings from malformed input.
 *
 * @param mixed $value Submitted value.
 * @return string
 */
function scalar_text( mixed $value ): string {
	return is_scalar( $value ) ? (string) $value : '';
}

/** Accept only explicit checkbox values, including for uninstall consent. */
function enabled( mixed $value ): bool {
	return in_array( $value, array( true, 1, '1' ), true );
}

/** Formatting only: no embeds, images, forms, styles, or executable markup. */
function safe_notes( string $value ): string {
	return wp_kses( $value, array(
		'a' => array( 'href' => true, 'title' => true ),
		'p' => array(), 'br' => array(), 'strong' => array(), 'em' => array(),
		'b' => array(), 'i' => array(), 'ul' => array(), 'ol' => array(),
		'li' => array(), 'blockquote' => array(), 'code' => array(),
	), array( 'http', 'https', 'mailto', 'tel' ) );
}

/** Render the core visual editor with controls matching the notes allowlist. */
function render_notes_editor( string $content, string $editor_id, string $field_name ): void {
	wp_editor( safe_notes( $content ), $editor_id, array(
		'textarea_name' => $field_name,
		'media_buttons' => false,
		'drag_drop_upload' => false,
		'quicktags' => false,
		'teeny' => true,
		'editor_height' => 200,
		'tinymce' => array(
			'toolbar1' => 'bold,italic,bullist,numlist,link,unlink',
			'toolbar2' => '',
			'toolbar3' => '',
			'toolbar4' => '',
			'content_style' => 'body { font-family: system-ui, -apple-system, BlinkMacSystemFont, Arial, sans-serif; font-size: 14px; line-height: 1.6; }',
		),
	) );
}

/** Validate HTTP(S) or local paths; never let sanitisation change the host. */
function sanitize_link_url( mixed $value ): string {
	$url = trim( scalar_text( $value ) );

	if ( '' === $url || str_starts_with( $url, '//' ) || preg_match( '/[\x00-\x20\x7F<>"\\\\]/', $url ) ) {
		return '';
	}

	if ( preg_match( '/^[a-z][a-z0-9+.-]*:/i', $url ) ) {
		$parts = wp_parse_url( $url );
		if ( ! is_array( $parts ) || ! in_array( strtolower( $parts['scheme'] ?? '' ), array( 'http', 'https' ), true ) || empty( $parts['host'] ) || isset( $parts['user'] ) || isset( $parts['pass'] ) ) {
			return '';
		}
		return esc_url_raw( $url, array( 'http', 'https' ) );
	}

	// Bare relative paths resolve against the website root, not the admin page.
	// A temporary leading slash prevents esc_url() from inventing an HTTP host.
	if ( preg_match( '/[:]/', strtok( $url, '/?#' ) ?: '' ) ) {
		return '';
	}
	return '/' === $url[0] ? esc_url_raw( $url, array( 'http', 'https' ) ) : substr( esc_url_raw( '/' . $url, array( 'http', 'https' ) ), 1 );
}

/** Resolve stored relative links consistently on subdirectory installations. */
function link_url( string $value ): string {
	$url = sanitize_link_url( $value );
	if ( '' === $url || preg_match( '#^https?://#i', $url ) || str_starts_with( $url, '/' ) ) {
		return $url;
	}
	return home_url( '/' ) . ( str_starts_with( $url, './' ) ? substr( $url, 2 ) : $url );
}

/**
 * Sanitise a Dashicon slug without the optional "dashicons-" prefix.
 *
 * @param mixed $value Submitted value.
 * @return string
 */
function sanitize_dashicon( mixed $value ): string {
	$icon = strtolower( sanitize_text_field( scalar_text( $value ) ) );
	$icon = preg_replace( '/^dashicons-/', '', $icon );

	if ( ! is_string( $icon ) || ! preg_match( '/^[a-z0-9-]+$/', $icon ) ) {
		return '';
	}

	return $icon;
}

/**
 * Create a conservative tel: link value from a display phone number.
 *
 * @param string $phone Display phone number.
 * @return string
 */
function phone_link_value( string $phone ): string {
	$value = preg_replace( '/[^0-9+*#,;]/', '', $phone );

	return is_string( $value ) ? $value : '';
}

/**
 * Determine whether an array has at least one useful scalar value.
 *
 * @param array<string, mixed> $values Values to inspect.
 * @return bool
 */
function has_populated_value( array $values ): bool {
	foreach ( $values as $value ) {
		if ( is_scalar( $value ) && '' !== trim( wp_strip_all_tags( (string) $value ) ) ) {
			return true;
		}
	}

	return false;
}
