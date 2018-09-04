<?php
/**
 * Template for displaying the header
 *
 * @version 1.3.2
 *
 * @package Schlicht
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
	// Check if we are in a single view and the pings are open.
	if ( is_singular() && pings_open() ) {
		?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php
	}

	// Fire wp_head action, which includes styles, scripts, et cetera, from core, themes, and plugins.
	wp_head();
	?>
</head>
<body <?php body_class(); ?>>
<a class="screen-reader-text skip-link" href="#content"><?php _e( '[Skip to Content]', 'schlicht' ); ?></a>
<header class="site-header" role="banner">
	<?php
	// Check if we have a custom logo.
	if ( '' !== schlicht_get_custom_logo() ) {

		// Check if we are on the home page which display the latest posts (this means: the page does
		// not have another headline like pages or posts, so we wrap the logo inside a h1).
		if ( ( is_front_page() && is_home() ) ) {
			?>
			<h1 class="logo">
			<?php
		}

		// Display the logo.
		echo schlicht_get_custom_logo();

		// Check again for home page which display the latests posts.
		if ( ( is_front_page() && is_home() ) ) {
			?>
			</h1>
			<?php
		}
	} else {
		// Check if we are on the latest posts home page.
		if ( ( is_front_page() && is_home() ) ) {
			?>
			<h1 class="site-title">
			<?php
				// Check if we are not on the first page of the posts page. If so, we link the title to the home page.
			if ( is_paged() ) {
				?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php
			}

					// Display the site title.
					bloginfo( 'name' );

					// Check again for paged view.
			if ( is_paged() ) {
				?>
				</a>
			<?php } ?></h1>
		<?php } else { ?>
			<p class="site-title">
				<?php
				// Check if we are not on the front page. In that case, we link the title.
				if ( ! is_front_page() ) {
					?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php
				}

					// Display the blog title.
					bloginfo( 'name' );

					// Check again for front page.
				if ( ! is_front_page() ) {
					?>
				</a>
			<?php } ?>
			</p>
			<?php
} // End if().
	} // End if().

	// Get the site description.
	$description = get_bloginfo( 'description', 'display' );

	// Check if we have a description.
	if ( $description ) {
		?>
		<p class="site-description"><?php echo $description; ?></p>
		<?php
	}

	// Check if we have menu items in the primary menu location.
	if ( has_nav_menu( 'primary' ) ) {
		?>
		<nav>
			<h2 class="screen-reader-text">
				<?php
				/* translators: hidden screen reader headline for the main navigation */
				_e( 'Main navigation', 'schlicht' );
				?>
			</h2>
			<?php
			// Display the menu.
			wp_nav_menu(
				[
					'theme_location' => 'primary',
					'menu_class'     => 'primary-nav',
					'container'      => '',
					'depth'          => 1,
				]
			);
			?>
		</nav>
	<?php } ?>
</header>
<div class="content-wrapper clearfix">
