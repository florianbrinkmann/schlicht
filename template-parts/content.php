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
				printf( __( 'by %s', 'schlicht' ), get_the_author() ) ?></p>
			<p class="date"><?php echo get_the_date(); ?></p>
		</div>
	</header>
	<div class="entry-content">
		<?php schlicht_the_content();
		wp_link_pages(); ?>
	</div>
	<footer class="entry-footer">
		<?php schlicht_the_post_meta(); ?>
	</footer>
</article>