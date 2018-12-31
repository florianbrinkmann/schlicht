<?php
/**
 * Template for displaying single post content
 *
 * @version 1.4.0
 *
 * @package Schlicht
 */

?>
<article <?php post_class( 'clearfix' ); ?>>
	<header class="entry-header">
		<?php
		// Display the title as h1 without linking it.
		schlicht_the_title( 'h1', false )
		?>
		<div class="author-date">
			<p class="author">
			<?php
				/* translators: s=author name */
				printf( esc_html__( 'by %s', 'schlicht' ), '<span class="author-name">' . get_the_author() . '</span>' )
			?>
				</p>
			<p class="date"><?php echo get_the_date(); ?></p>
		</div>
	</header>
	<div class="entry-content">
		<?php
		// Display large post thumbnail.
		the_post_thumbnail( 'large' );

		// Display the content.
		schlicht_the_content();

		// Display pagination.
		schlicht_wp_link_pages();
		?>
	</div>
	<footer class="entry-footer">
		<div class="entry-footer-content">
			<?php
			// Display post meta.
			schlicht_the_post_meta();
			?>
		</div>
	</footer>
</article>
