<?php

namespace moorsmagazine\Plugin;

use moorsmagazine\WordPress\Integration;
use moorsmagazine\WordPress\Integration_Group;

class Bootstrap implements Integration {

	/**
	 * Initializes the integration.
	 */
	public function initialize() {
		$integration_group = new Integration_Group(
			[
				new SEO\Sitemap_Modified_Date(),
				new Admin\Post\Music_Player_Column(),
				new Admin\Post\Flip_Content_Placement()
			]
		);
		$integration_group->initialize();
	}
}
