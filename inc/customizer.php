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
}

add_action( 'customize_register', 'schlicht_customize_register', 11 );

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