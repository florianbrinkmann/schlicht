<?php
/**
 * Functions file
 *
 * @package Schlicht
 */

/**
 * Include file with add_action() calls.
 */
require_once locate_template( 'inc/actions.php' );

/**
 * Include file with add_filter() calls.
 */
require_once locate_template( 'inc/filters.php' );

/**
 * Include file with template tags.
 */
require_once locate_template( 'inc/template-tags.php' );

/**
 * Include file with template functions.
 */
require_once locate_template( 'inc/template-functions.php' );

/**
 * Include file with filter functions.
 */
require_once locate_template( 'inc/filter-functions.php' );

/**
 * Include customizer functions.
 */
require_once locate_template( 'inc/customizer.php' );

/**
 * Include functions for theme update handling.
 */
require_once locate_template( 'inc/theme-updates.php' );
