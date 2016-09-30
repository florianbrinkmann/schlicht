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
				printf( __( 'by %s', 'schlicht' ), get_the_author() ) ?></p>
			<p class="date"><?php echo get_the_date(); ?></p>
		</div>
	</header>
	<div class="entry-content">
		<?php the_post_thumbnail( 'large' );
		schlicht_the_content();
		wp_link_pages(); ?>
	</div>
	<footer class="entry-footer">
		<?php schlicht_the_post_meta(); ?>
	</footer>
</article>