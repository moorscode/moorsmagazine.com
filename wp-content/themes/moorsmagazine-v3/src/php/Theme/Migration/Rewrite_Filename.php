<?php

namespace moorsmagazine\Theme\Migration;

use moorsmagazine\WordPress\Integration;

class Rewrite_Filename implements Integration {

	/**
	 * Registers all hooks to WordPress.
	 */
	public function initialize() {
		add_action( 'init', function() {
			add_rewrite_rule( '^index.html$', 'index.php', 'top' );
		} );
	}
}
