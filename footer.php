<?php
/**
 * Template for website footer
 *
 * @version 1.0.1
 */
?>
</div><!--.content-wrapper-->
<footer class="site-footer clearfix">
    <?php if ( has_nav_menu( 'footer' ) ) { ?>
        <nav class="footer-nav-container">
            <h2 class="screen-reader-text">
                <?php /* translators: hidden screen reader headline for the footer navigation */
                _e( 'Footer navigation', 'schlicht' ); ?>
            </h2>
            <?php wp_nav_menu(
                array(
                    'theme_location' => 'footer',
                    'menu_class'     => 'footer-nav',
                    'container'      => '',
                    'depth'          => 1
                )
            ); ?>
        </nav>
    <?php }
    if ( is_active_sidebar( 'sidebar-footer' ) ) { ?>
        <aside class="site-footer-widget-area clearfix">
            <h2 class="screen-reader-text">
                <?php /* translators: screen reader text for the footer widget area */
                _e( 'Footer widget area', 'schlicht' ) ?></h2>
            <?php dynamic_sidebar( 'sidebar-footer' ); ?>
        </aside>
    <?php } ?>
    <p class="theme-author"><?php printf(
            __( 'Theme: Schlicht by %s', 'schlicht' ),
            sprintf( '<a rel="nofollow" href="%s">Florian Brinkmann</a>', __( 'https://florianbrinkmann.com/en/', 'schlicht' ) ) ); ?></p>
</footer>
<?php wp_footer(); ?>
</body>
</html>
