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