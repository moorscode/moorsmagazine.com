<?php

namespace moorsmagazine\Theme\Migration;

use moorsmagazine\WordPress\Integration;

class Mailto_Fix implements Integration {

	/**
	 * Initializes the integration.
	 */
	public function initialize() {
		add_filter( 'the_content', [ $this, 'fix_mailto' ] );
	}

	/**
	 * Replaces corrupt links to mailto: addresses.
	 *
	 * @param string $content Fixed content.
	 *
	 * @return string
	 */
	public function fix_mailto( $content ) {
		if ( strpos( $content, 'mailto:' ) !== false ) {
			$content = preg_replace( '~href="[^"]+mailto:([^"]+)"~i', 'href="mailto:$1"', $content );
		}

		return $content;
	}
}
