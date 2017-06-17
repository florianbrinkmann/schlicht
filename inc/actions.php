<?php
/**
 * All add_action() calls.
 *
 * @version 1.3.0
 *
 * @package Schlicht
 */

add_action( 'after_setup_theme', 'schlicht_load_translation' );

add_action( 'after_setup_theme', 'schlicht_add_theme_support' );

add_action( 'after_setup_theme', 'schlicht_add_editor_style' );

add_action( 'init', 'schlicht_register_menus' );

add_action( 'widgets_init', 'schlicht_register_sidebars' );

add_action( 'wp_enqueue_scripts', 'schlicht_scripts_styles' );

add_action( 'admin_enqueue_scripts', 'schlicht_admin_script' );

add_action( 'wp_footer', 'schlicht_dropcap_inline_script' );
