<?php
/**
 * Template for website footer
 *
 * @version 1.3.2
 *
 * @package Schlicht
 */

?>
</div><!--.content-wrapper-->
<footer class="site-footer clearfix">
	<?php
	// Check if the menu location footer has a menu.
	if ( has_nav_menu( 'footer' ) ) {
		?>
		<nav class="footer-nav-container">
			<h2 class="screen-reader-text">
				<?php
				// translators: hidden screen reader headline for the footer navigation.
				esc_html_e( 'Footer navigation', 'schlicht' );
				?>
			</h2>
			<?php
			// Display the menu.
			wp_nav_menu(
				[
					'theme_location' => 'footer',
					'menu_class'     => 'footer-nav',
					'container'      => '',
					'depth'          => 1,
				]
			);
			?>
		</nav>
		<?php
	}

	// Check if the footer sidebar has widgets.
	if ( is_active_sidebar( 'sidebar-footer' ) ) {
		?>
		<aside class="site-footer-widget-area clearfix">
			<h2 class="screen-reader-text">
				<?php
				// translators: screen reader text for the footer widget area.
				esc_html_e( 'Footer widget area', 'schlicht' )
				?>
				</h2>
			<?php
			// Display the widgets.
			dynamic_sidebar( 'sidebar-footer' );
			?>
		</aside>
	<?php } ?>
	<p class="theme-author">
		<?php
		printf( // translators: s=name of theme author.
			esc_html__( 'Theme: Schlicht by %s', 'schlicht' ),
			sprintf( '<a rel="nofollow" href="%s">Florian Brinkmann</a>', esc_attr__( 'https://florianbrinkmann.com/en/', 'schlicht' ) )
		);
		?>
	</p>
</footer>
<?php
// Includes scripts, et cetera, which are hooked to the wp_footer action.
wp_footer();
?>
</body>
</html>
