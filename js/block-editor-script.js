// Remove block style from pull quote.
wp.domReady( () => {
	wp.blocks.unregisterBlockStyle( 'core/pullquote', 'default' );
	wp.blocks.unregisterBlockStyle( 'core/pullquote', 'solid-color' );
} );
