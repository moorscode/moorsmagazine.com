<?php

namespace moorsmagazine\WordPress;

/**
 * An interface for registering integrations with WordPress
 */
interface Integration {
	/**
	 * Initializes the integration.
	 */
	public function initialize();
}
