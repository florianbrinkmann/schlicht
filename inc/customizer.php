<?php
/**
 * Customizer functions
 *
 * @version 1.0
 */

/**
 * Customizer settings
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function schlicht_customize_register( $wp_customize ) {
	$wp_customize->remove_control( 'header_textcolor' );
	$wp_customize->remove_control( 'header_image' );

	$wp_customize->add_section( 'schlicht_options', array(
		'title'       => __( 'Schlicht Options', 'schlicht' ),
		'description' => __( 'Theme options of Schlicht theme', 'schlicht' ),
	) );

	$wp_customize->add_setting( 'schlicht_dropcap', array(
		'default'           => 0,
		'sanitize_callback' => 'schlicht_sanitize_callback'
	) );

	$wp_customize->add_control( 'schlicht_dropcap', array(
		'type'    => 'checkbox',
		'section' => 'schlicht_options',
		'label'   => __( 'Enable Dropcaps' )
	) );

	$wp_customize->add_setting( 'sidebar_visibility', array(
		'default'           => 'everywhere',
		'sanitize_callback' => 'schlicht_sanitize_select'
	) );

	$wp_customize->add_control( 'sidebar_visibility', array(
		'type'    => 'radio',
		'section' => 'schlicht_options',
		'label'   => __( 'Where to display the sidebar', 'schlicht' ),
		'choices' => array(
			'everywhere'  => __( 'On blog and single view.', 'schlicht' ),
			'blog_view'   => __( 'On blog view.', 'schlicht' ),
			'single_view' => __( 'On single view.', 'schlicht' ),
		)
	) );
}

add_action( 'customize_register', 'schlicht_customize_register', 11 );

/**
 * Checkbox sanitization callback example.
 *
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @source https://github.com/WPTRT/code-examples/blob/master/customizer/sanitization-callbacks.php
 * @param bool $checked Whether the checkbox is checked.
 *
 * @return bool Whether the checkbox is checked.
 */
function schlicht_sanitize_callback( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Select sanitization callback example.
 *
 * - Sanitization: select
 * - Control: select, radio
 *
 * Sanitization callback for 'select' and 'radio' type controls. This callback sanitizes `$input`
 * as a slug, and then validates `$input` against the choices defined for the control.
 *
 * @see sanitize_key()               https://developer.wordpress.org/reference/functions/sanitize_key/
 * @see $wp_customize->get_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/get_control/
 *
 * @source https://github.com/WPTRT/code-examples/blob/master/customizer/sanitization-callbacks.php
 * @param string $input Slug to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 *
 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
 */
function schlicht_sanitize_select( $input, $setting ) {

	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Prints CSS inside header
 *
 * @return void
 */
function schlicht_customizer_css() {
	if ( display_header_text() ) {
		return;
	} else { ?>
		<style type="text/css">
			.site-title,
			.site-description {
				clip: rect(1px, 1px, 1px, 1px);
				height: 1px;
				overflow: hidden;
				position: absolute !important;
				width: 1px;
				word-wrap: normal !important;
			}
		</style>
	<?php }
}

add_action( 'wp_head', 'schlicht_customizer_css' );