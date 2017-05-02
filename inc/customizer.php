<?php
/**
 * Customizer functions
 *
 * @version 1.1.1
 *
 * @package Schlicht
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
		'title' => __( 'Theme options', 'schlicht' ),
	) );

	$wp_customize->add_setting( 'schlicht_dropcap', array(
		'default'           => 0,
		'sanitize_callback' => 'schlicht_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'schlicht_dropcap', array(
		'type'    => 'checkbox',
		'section' => 'schlicht_options',
		'label'   => __( 'Enable Dropcaps', 'schlicht' ),
	) );

	$wp_customize->add_setting( 'schlicht_auto_dropcaps_for_posts', array(
		'default'           => 0,
		'sanitize_callback' => 'schlicht_sanitize_checkbox',
	) );

	/* translators: s=HTML markup for wrapping a dropcap */
	$wp_customize->add_control( 'schlicht_auto_dropcaps_for_posts', array(
		'type'            => 'checkbox',
		'section'         => 'schlicht_options',
		'label'           => __( 'Auto integration of dropcaps only for posts, not pages.', 'schlicht' ),
		'active_callback' => 'schlicht_use_dropcaps',
	) );

	$wp_customize->add_setting( 'schlicht_no_auto_dropcap', array(
		'default'           => 0,
		'sanitize_callback' => 'schlicht_sanitize_checkbox',
	) );

	/* translators: s=HTML markup for wrapping a dropcap */
	$wp_customize->add_control( 'schlicht_no_auto_dropcap', array(
		'type'            => 'checkbox',
		'section'         => 'schlicht_options',
		'label'           => sprintf(
			__( 'Don’t insert dropcaps automatically. You can insert dropcaps manually with wrapping a first letter of a paragraph inside %s in the text view of the editor.', 'schlicht' ),
			'<span class="dropcap"></span>' ),
		'active_callback' => 'schlicht_use_dropcaps',
	) );

	$wp_customize->add_setting( 'schlicht_alternate_post_layout', array(
		'default'           => 0,
		'sanitize_callback' => 'schlicht_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'schlicht_alternate_post_layout', array(
		'type'    => 'checkbox',
		'section' => 'schlicht_options',
		'label'   => __( 'Enable alternate post/page layout where title is displayed in a column left of the content (only works if no widgets are in the sidebar).', 'schlicht' ),
	) );

	$wp_customize->add_setting( 'schlicht_vollkorn_font', array(
		'default'           => 0,
		'sanitize_callback' => 'schlicht_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'schlicht_vollkorn_font', array(
		'type'    => 'checkbox',
		'section' => 'schlicht_options',
		'label'   => __( 'Use the Vollkorn font instead of Sorts Mill Goudy.', 'schlicht' )
	) );

	/**
	 * Change transport to refresh
	 */
	$wp_customize->get_setting( 'custom_logo' )->transport = 'refresh';
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
function schlicht_sanitize_checkbox( $checked ) {
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
 * Checks if checkbox for dropcaps is checked and returns true, otherwise false
 *
 * @param $control
 *
 * @return bool
 */
function schlicht_use_dropcaps( $control ) {
	if ( $control->manager->get_setting( 'schlicht_dropcap' )->value() == 1 ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Checks if sidebar is active
 *
 * @return bool
 */
function schlicht_no_sidebar() {
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		return false;
	} else {
		return true;
	}
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
