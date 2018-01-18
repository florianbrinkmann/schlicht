<?php
/**
 * Template for displaying pages
 *
 * @version 1.3.2
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
				// Loop the posts.
				while ( have_posts() ) {
					// Setup post.
					the_post();

					// Include template file template-parts/content-page.php for displaying the page content.
					get_template_part( 'template-parts/content', 'page' );
				}

				// Check if comments are open or we have comments.
				if ( comments_open() || get_comments_number() ) {
					// Include the comments.php.
					comments_template();
				}
			} else {
				// Include template-parts/content-none.php.
				get_template_part( 'template-parts/content', 'none' );
			} ?>
		</div>
	</main>
<?php
// Include the sidebar.php.
get_sidebar();

// Include the footer.php.
get_footer();
