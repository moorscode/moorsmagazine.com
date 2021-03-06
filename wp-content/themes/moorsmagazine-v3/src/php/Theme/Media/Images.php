<?php

namespace moorsmagazine\Theme\Media;

use moorsmagazine\WordPress\Integration;

class Images implements Integration {

	/**
	 * Registers all hooks to WordPress.
	 */
	public function initialize() {
		add_image_size( 'gallery-thumb', 192 );
		add_image_size( 'voorpagina', 450 );
		add_image_size( 'featured', 300 );

		add_filter( 'image_size_names_choose', function( $sizes ) {
			return array_merge( $sizes, array(
				'voorpagina' => 'Voorpagina',
			) );
		} );

		// Remove default images sizes.
		add_filter( 'intermediate_image_sizes_advanced', function( $sizes ) {
 			unset( $sizes['small']);
 			unset( $sizes['medium']);
 			unset( $sizes['medium_large']);
 			return $sizes;
		} );
	}
}
