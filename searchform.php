<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'schlicht' ); ?></span>
		<input type="search" class="search-field"
		       placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'schlicht' ); ?>"
		       value="<?php echo get_search_query(); ?>" name="s"/>
	</label>
	<label>
		<input type="submit" class="screen-reader-text"
		       value="<?php echo esc_attr_x( 'Search', 'submit button', 'schlicht' ); ?>"/>
		<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" class="search-submit">
			<path
				d="M14 13l-3.866-3.866C10.673 8.393 11 7.487 11 6.5 11 4.015 8.985 2 6.5 2S2 4.015 2 6.5 4.015 11 6.5 11c.987 0 1.893-.327 2.634-.866L13 14l1-1zM3 6.5C3 4.567 4.567 3 6.5 3 8.434 3 10 4.567 10 6.5S8.434 10 6.5 10C4.567 10 3 8.433 3 6.5z"
				fill="currentColor"/>
		</svg>
	</label>

</form>