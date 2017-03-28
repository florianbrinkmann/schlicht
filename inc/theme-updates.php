<?php
/**
 * Handling automatic theme updates
 *
 * @version 1.2
 */

/**
 * Customizer settings for theme update
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function schlicht_update_customize_register( $wp_customize ) {
	$wp_customize->add_setting( 'schlicht_upgrade_url', array(
		'type'              => 'option',
		'default'           => '',
		'sanitize_callback' => 'schlicht_esc_update_url'
	) );

	if ( ! is_multisite() ) {
		$wp_customize->add_control( 'schlicht_upgrade_url', array(
			'priority' => 1,
			'type'     => 'url',
			'section'  => 'schlicht_options',
			'label'    => __( 'Paste your download link for »Schlicht« to enable automatic theme updates.', 'schlicht' ),
		) );
	}
}

add_action( 'customize_register', 'schlicht_update_customize_register', 12 );

/**
 * Escape URL and check if it matches a valid download format
 *
 * @param $url
 *
 * @return string
 */
function schlicht_esc_update_url( $url ) {
	$url     = esc_url_raw( $url );
	$pattern = '/^https:\/\/florianbrinkmann\.com\/(en\/)?\?download_file=|^https:\/\/(en\.)?florianbrinkmann\.de\/\?download_file=/';
	preg_match( $pattern, $url, $matches );

	if ( ! empty ( $matches ) ) {
		return $url;
	} else {
		return '';
	}
}

/**
 * Checking for updates and updating the transient for theme updates
 *
 * @param $transient
 *
 * @return mixed
 */
function schlicht_theme_update( $transient ) {
	if ( empty( $transient->checked ) ) {
		return $transient;
	}

	$request = schlicht_fetch_data_of_latest_version();
	if ( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) != 200 ) {
		return $transient;
	} else {
		$response = wp_remote_retrieve_body( $request );
	}

	$data     = json_decode( $response );
	$theme_id = $data->theme_id;
	unset( $data->theme_id );
	if ( version_compare( $transient->checked['schlicht'], $data->new_version, '<' ) ) {
		$transient->response['schlicht']        = (array) $data;
		$transient->response['schlicht']['url'] = __( 'https://florianbrinkmann.com/en/wordpress-themes/schlicht/changelog/', 'schlicht' );

		$theme_package = get_option( 'schlicht_upgrade_url' );
		if ( ! empty ( $theme_package ) ) {
			$pattern = '/^https:\/\/florianbrinkmann\.com\/(en\/)?\?download_file=' . $theme_id . '|^https:\/\/(en\.)?florianbrinkmann\.de\/\?download_file=' . $theme_id . '/';
			preg_match( $pattern, $theme_package, $matches );
			if ( ! empty ( $matches ) ) {
				$transient->response['schlicht']['package'] = $theme_package;
			} else {
			}
		}
	}

	return $transient;
}

add_filter( 'pre_set_site_transient_update_themes', 'schlicht_theme_update' );

/**
 * Fetch data of latest theme version
 *
 * @return array|WP_Error
 */
function schlicht_fetch_data_of_latest_version() {
	$request = wp_safe_remote_get( 'https://florianbrinkmann.com/wordpress-themes/schlicht/upgrade-json/' );

	return $request;
}

/**
 * Remove upgrade URL option after switching the theme,
 * if the new theme is not schlicht or a child theme of schlicht
 */
function schlicht_remove_upgrade_url() {
	$theme_object = wp_get_theme();
	$template     = $theme_object->template;
	if ( $template == 'schlicht' ) {

	} else {
		delete_option( 'schlicht_upgrade_url' );
	}
}

add_action( 'switch_theme', 'schlicht_remove_upgrade_url', 10, 2 );
