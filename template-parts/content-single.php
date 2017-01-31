<?php
/**
 * Template for displaying single post content
 *
 * @version 1.0
 */
?>
<article <?php post_class( 'clearfix' ); ?>>
    <header class="entry-header">
        <?php schlicht_the_title( 'h1', false ) ?>
        <div class="author-date">
            <p class="author"><?php
                /* translators: s=author name */
                printf( __( 'by %s', 'schlicht' ), '<span class="author-name">' . get_the_author() . '</span>' ) ?></p>
            <p class="date"><?php echo get_the_date(); ?></p>
        </div>
    </header>
    <div class="entry-content">
        <?php the_post_thumbnail( 'large' );
        schlicht_the_content();
        schlicht_wp_link_pages(); ?>
    </div>
    <footer class="entry-footer">
        <div class="entry-footer-content">
            <?php schlicht_the_post_meta(); ?>
        </div>
    </footer>
</article>