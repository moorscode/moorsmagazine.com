<?php

namespace moorsmagazine\Theme;

use moorsmagazine\WordPress\Integration;

class Bootstrap implements Integration {

	/**
	 * Initializes the integration.
	 */
	public function initialize() {
		setlocale( LC_ALL, 'nl_NL' );

		add_action( 'after_setup_theme', function() {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'title-tag' );
		} );

		$integration_group = new Integration_Group(
			[
				new Migration\Rewrite_Filename(),
				new Migration\Music_Player(),
				new Migration\Mailto_Fix(),

				new CPT\Frontpage(),
				new AJAX\Gallery(),
				new Media\Images(),
				new Assets\Loader(),

				new Admin\Editor_Style(),
			]
		);
		$integration_group->initialize();
	}
}
