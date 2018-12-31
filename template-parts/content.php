<?php
/**
 * Template part for posts
 *
 * @version 1.4.0
 *
 * @package Schlicht
 */

?>
<article <?php post_class( 'clearfix' ); ?>>
	<header class="entry-header">
		<?php
		// Check if it is a sticky post.
		if ( is_sticky() ) {
			/* translators: String displayed above headline of sticky post(s) */
			?>
			<span class="featured"><?php esc_html_e( 'Featured', 'schlicht' ); ?></span>
			<?php
		}

		// Display the title in a h2, which links to the single view.
		schlicht_the_title( 'h2' )
		?>
		<div class="author-date">
			<p class="author">
			<?php
				/* translators: s=author name */
				printf( esc_html__( 'by %s', 'schlicht' ), '<span class="author-name">' . get_the_author() . '</span>' )
			?>
				</p>
			<p class="date"><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a></p>
		</div>
	</header>
	<div class="entry-content">
		<?php
		// Check if we have a post thumbnail.
		if ( has_post_thumbnail() ) {
			?>
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'large' ); ?>
			</a>
			<?php
		}

		// Display the content with a more accessible read more link as the default from the_content().
		schlicht_the_content();

		// Display post pagination.
		schlicht_wp_link_pages();
		?>
	</div>
	<footer class="entry-footer">
		<div class="entry-footer-content">
			<?php
			// Display the post meta.
			schlicht_the_post_meta();
			?>
		</div>
	</footer>
</article>
