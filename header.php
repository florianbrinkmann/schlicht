<?php
/**
 * Template for displaying the header
 *
 * @version 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php if ( is_singular() && pings_open() ) { ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php }
	wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="site-header" role="banner">
	<?php if ( schlicht_get_custom_logo() != '' ) {
		if ( ( is_front_page() && is_home() ) ) { ?>
			<h1 class="logo">
		<?php }
		echo schlicht_get_custom_logo();
		if ( ( is_front_page() && is_home() ) ) { ?>
			</h1>
		<?php }
	} else {
		if ( ( is_front_page() && is_home() ) ) { ?>
			<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
		<?php } else {
			if ( ! is_front_page() ) { ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php } ?>
			<p class="site-title"><?php bloginfo( 'name' ); ?></p>
			<?php if ( ! is_front_page() ) { ?>
				</a >
			<?php }
		}
	}
	$description = get_bloginfo( 'description', 'display' );
	if ( $description ) { ?>
		<p class="site-description"><?php echo $description; ?></p>
	<?php }
	if ( has_nav_menu( 'primary' ) ) { ?>
		<nav>
			<h2 class="screen-reader-text">
				<?php /* translators: hidden screen reader headline for the main navigation */
				_e( 'Main navigation', 'schlicht' ); ?>
			</h2>
			<?php wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_class'     => 'primary-nav',
					'container'      => ''
				)
			); ?>
		</nav>
	<?php } ?>
</header>
<div class="content-wrapper clearfix">