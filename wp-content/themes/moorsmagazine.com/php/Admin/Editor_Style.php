<?php

namespace moorsmagazine\Admin;

use moorsmagazine\WordPress\Integration;

class Editor_Style implements Integration {

	/**
	 * Registers all hooks to WordPress.
	 */
	public function initialize() {
		add_action( 'admin_init', function() {
			add_editor_style( get_template_directory_uri() . '/css/editor.css' );
		} );
	}
}
