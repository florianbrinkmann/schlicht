<?php
/**
 * All add_action() calls.
 *
 * @version 1.3.0
 *
 * @package Schlicht
 */

/**
 * Load translation.
 */
add_action( 'after_setup_theme', 'schlicht_load_translation' );

/**
 * Add theme support for various core features.
 */
add_action( 'after_setup_theme', 'schlicht_add_theme_support' );

/**
 * Add editor style sheet.
 */
add_action( 'after_setup_theme', 'schlicht_add_editor_style' );

/**
 * Register menus.
 */
add_action( 'init', 'schlicht_register_menus' );

/**
 * Register widget areas.
 */
add_action( 'widgets_init', 'schlicht_register_sidebars' );

/**
 * Enqueue scripts and styles.
 */
add_action( 'wp_enqueue_scripts', 'schlicht_scripts_styles' );

/**
 * Enqueue script in admin view.
 */
add_action( 'admin_enqueue_scripts', 'schlicht_admin_script' );

/**
 * Register customize controls.
 */
add_action( 'customize_register', 'schlicht_customize_register', 11 );

/**
 * Include customize related CSS.
 */
add_action( 'wp_head', 'schlicht_customizer_css' );

/**
 * Register controls for theme updates.
 */
add_action( 'customize_register', 'schlicht_update_customize_register', 12 );

/**
 * Remove upgrade URL option value after
 * switching away from Schlicht or a child theme.
 */
add_action( 'switch_theme', 'schlicht_remove_upgrade_url', 10, 2 );
