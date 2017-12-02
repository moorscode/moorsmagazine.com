<?php

namespace moorsmagazine\Plugin;

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
			new SEO\Sitemap_Modified_Date(),
			new Admin\Post\Music_Player_Column(),
			new Admin\Post\Flip_Content_Placement()
		];
	}
}
