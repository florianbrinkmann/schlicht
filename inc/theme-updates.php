<?php
/**
 * Handling automatic theme updates
 *
 * @version 1.4.0
 *
 * @package Schlicht
 */

/**
 * Customizer settings for theme update.
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function schlicht_update_customize_register( $wp_customize ) {
	// Only add setting and control if we are not on a multisite.
	if ( ! is_multisite() ) {
		// Add setting for URL.
		$wp_customize->add_setting(
			'schlicht_upgrade_url',
			[
				'type'              => 'option',
				'default'           => '',
				'sanitize_callback' => 'schlicht_esc_update_url',
			]
		);

		// Add control for update URL.
		$wp_customize->add_control(
			'schlicht_upgrade_url',
			[
				'priority' => 1,
				'type'     => 'url',
				'section'  => 'schlicht_options',
				'label'    => __( 'Paste your download link for »Schlicht« to enable automatic theme updates.', 'schlicht' ),
			]
		);
	}
}

/**
 * Escape URL and check if it matches a valid download format.
 *
 * @param string $url Update URL from customizer control.
 *
 * @return string Escaped update URL or empty string.
 */
function schlicht_esc_update_url( $url ) {
	// Escape the URL.
	$url = esc_url_raw( $url );

	// Possible update URL patterns.
	$pattern = '/^https:\/\/florianbrinkmann\.com\/(en\/)?\?download_file=|^https:\/\/(en\.)?florianbrinkmann\.de\/\?download_file=/';

	// Check if we have a match.
	preg_match( $pattern, $url, $matches );

	// If match, return the URL. Otherwise an empty string.
	if ( ! empty( $matches ) ) {
		return $url;
	} else {
		return '';
	}
}

/**
 * Checking for updates and updating the transient for theme updates.
 *
 * @param object $transient Transient object for theme updates.
 *
 * @return object Theme update transient.
 */
function schlicht_theme_update( $transient ) {
	if ( empty( $transient->checked ) ) {
		return $transient;
	}

	// Get data of upgrade json on florianbrinkmann.com.
	$request = schlicht_fetch_data_of_latest_version();

	// Check if request is not valid and return the $transient.
	// Otherwise get the data body.
	if ( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) !== 200 ) {
		return $transient;
	} else {
		$response = wp_remote_retrieve_body( $request );
	}

	// Decode json.
	$data = json_decode( $response );

	// Get the theme ID and unset it from the data object.
	$theme_id = $data->theme_id;
	unset( $data->theme_id );

	// Check if new version is available.
	if ( version_compare( $transient->checked['schlicht'], $data->new_version, '<' ) ) {
		// Add response array for Schlicht in $transient object.
		$transient->response['schlicht'] = (array) $data;

		// Set the changelog URL.
		$transient->response['schlicht']['url'] = __( 'https://florianbrinkmann.com/en/wordpress-themes/schlicht/changelog/', 'schlicht' );

		// Get the update URL theme option.
		$theme_package = get_option( 'schlicht_upgrade_url' );

		// Check if we have a URL.
		if ( ! empty( $theme_package ) ) {
			// Upgrade URL pattern (this time with theme ID, not without like in the customizer).
			$pattern = '/^https:\/\/florianbrinkmann\.com\/(en\/)?\?download_file=' . $theme_id . '|^https:\/\/(en\.)?florianbrinkmann\.de\/\?download_file=' . $theme_id . '/';

			// Check for match.
			preg_match( $pattern, $theme_package, $matches );

			// If match, add the package.
			if ( ! empty( $matches ) ) {
				$transient->response['schlicht']['package'] = $theme_package;
			}
		}
	}

	return $transient;
}

/**
 * Fetch data of latest theme version.
 *
 * @return array|WP_Error Array with data of the latest theme version or WP_Error.
 */
function schlicht_fetch_data_of_latest_version() {
	$request = wp_safe_remote_get( 'https://florianbrinkmann.com/wordpress-themes/schlicht/upgrade-json/' );

	return $request;
}

/**
 * Remove upgrade URL option after switching the theme,
 * if the new theme is not Schlicht or a child theme of Schlicht.
 */
function schlicht_remove_upgrade_url() {
	// Get theme object.
	$theme_object = wp_get_theme();

	// Get template.
	$template = $theme_object->template;

	// Check if template is not »schlicht«.
	if ( 'schlicht' !== $template ) {
		delete_option( 'schlicht_upgrade_url' );
	}
}
