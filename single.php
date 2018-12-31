<?php
/**
 * Template for displaying single view of posts
 *
 * @version 1.4.0
 *
 * @package Schlicht
 */

// Include header.php.
get_header(); ?>
	<main>
		<div class="main-content">
			<?php
			// Check if we have posts.
			if ( have_posts() ) {
				// Loop through the posts.
				while ( have_posts() ) {
					// Setup post.
					the_post();

					// Include template file. Default template-parts/content-single.php.
					get_template_part( 'template-parts/content-single', get_post_format() );
				}

				// Check if comments are open or we already have comments.
				if ( comments_open() || get_comments_number() ) {
					// Include comments.php.
					comments_template();
				}
			} else {
				// Include template-parts/content-none.php.
				get_template_part( 'template-parts/content', 'none' );
			}
			?>
		</div>
	</main>
<?php
// Include the sidebar.php.
get_sidebar();

// Include the footer.php.
get_footer();
