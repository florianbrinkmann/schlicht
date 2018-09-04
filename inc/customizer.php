<?php
/**
 * Customizer functions
 *
 * @version 1.3.2
 *
 * @package Schlicht
 */

/**
 * Customizer settings
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function schlicht_customize_register( $wp_customize ) {
	// Remove header text color control.
	$wp_customize->remove_control( 'header_textcolor' );

	// Remove header image control.
	$wp_customize->remove_control( 'header_image' );

	// Add Section for theme options.
	$wp_customize->add_section(
		'schlicht_options', [
			'title' => __( 'Theme options', 'schlicht' ),
		]
	);

	// Add setting for alternative post layout.
	$wp_customize->add_setting(
		'schlicht_alternate_post_layout', [
			'default'           => 0,
			'sanitize_callback' => 'schlicht_sanitize_checkbox',
		]
	);

	// Add control for alternative post layout.
	$wp_customize->add_control(
		'schlicht_alternate_post_layout', [
			'type'    => 'checkbox',
			'section' => 'schlicht_options',
			'label'   => __( 'Enable alternate post/page layout where title is displayed in a column left of the content (only works if no widgets are in the sidebar).', 'schlicht' ),
		]
	);

	// Add setting for Vollkorn font option.
	$wp_customize->add_setting(
		'schlicht_vollkorn_font', [
			'default'           => 0,
			'sanitize_callback' => 'schlicht_sanitize_checkbox',
		]
	);

	// Add control for Vollkorn font option.
	$wp_customize->add_control(
		'schlicht_vollkorn_font', [
			'type'    => 'checkbox',
			'section' => 'schlicht_options',
			'label'   => __( 'Use the Vollkorn font instead of Sorts Mill Goudy.', 'schlicht' ),
		]
	);

	// Change transport to refresh for custom logo setting.
	$wp_customize->get_setting( 'custom_logo' )->transport = 'refresh';
}

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
function schlicht_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true === $checked ) ? true : false );
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
 * @param string               $input   Slug to sanitize.
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
 * Checks if checkbox for dropcaps is checked.
 *
 * @param WP_Customize_Control $control Control object.
 *
 * @return bool true if drop caps checkbox is checked, otherwise false.
 */
function schlicht_use_dropcaps( $control ) {
	// Check if checkbox is checked.
	if ( $control->manager->get_setting( 'schlicht_dropcap' )->value() === true ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Checks if sidebar is active.
 *
 * @return bool true if sidebar is active, false if not.
 */
function schlicht_no_sidebar() {
	// Check if sidebar-1 is active.
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		return false;
	} else {
		return true;
	}
}

/**
 * Prints CSS inside header.
 */
function schlicht_customizer_css() {
	// Check if the header text should be displayed.
	if ( display_header_text() ) {
		return;
	} else {
		// Output CSS to hide header text.
		?>
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
		<?php
	}
}
