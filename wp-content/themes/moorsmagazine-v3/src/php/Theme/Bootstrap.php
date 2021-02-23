<?php

namespace moorsmagazine\Theme;

use moorsmagazine\WordPress\Integration;
use moorsmagazine\WordPress\Integration_Group;

class Bootstrap extends Integration_Group {

	/**
	 * Returns a list of integrations to use.
	 *
	 * @return Integration[] List of registered integrations.
	 */
	protected function get_integrations() {
		return [
			new Migration\Rewrite_Filename(),
			new Migration\Music_Player(),
			new Migration\Mailto_Fix(),

			new CPT\Frontpage(),
			new AJAX\Gallery(),
			new Media\Images(),
			new Assets\Loader(),

			new Admin\Editor_Style(),
		];
	}

	/**
	 * Initializes the integration.
	 */
	public function initialize() {
		setlocale( LC_ALL, 'nl_NL' );

		add_action( 'after_setup_theme', function() {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'title-tag' );
		} );

		parent::initialize();
	}
}
