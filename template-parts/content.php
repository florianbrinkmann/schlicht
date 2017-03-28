<?php
/**
 * Template part for posts
 *
 * @version 1.0
 */
?>
<article <?php post_class( 'clearfix' ); ?>>
	<header class="entry-header">
		<?php if ( is_sticky() ) {
			/* translators: String displayed above headline of sticky post(s) */ ?>
			<span class="featured"><?php _e( 'Featured', 'schlicht' ); ?></span>
		<?php }
		schlicht_the_title( 'h2' ) ?>
		<div class="author-date">
			<p class="author"><?php
				/* translators: s=author name */
				printf( __( 'by %s', 'schlicht' ), '<span class="author-name">' . get_the_author() . '</span>' ) ?></p>
			<p class="date"><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a></p>
		</div>
	</header>
	<div class="entry-content">
		<?php $post_thumbnail = get_the_post_thumbnail( $post->ID, 'large' );
		if ( $post_thumbnail != '' ) { ?>
			<a href="<?php the_permalink(); ?>">
				<?php echo $post_thumbnail; ?>
			</a>
		<?php }
		schlicht_the_content();
		schlicht_wp_link_pages(); ?>
	</div>
	<footer class="entry-footer">
		<div class="entry-footer-content">
			<?php schlicht_the_post_meta(); ?>
		</div>
	</footer>
</article>
