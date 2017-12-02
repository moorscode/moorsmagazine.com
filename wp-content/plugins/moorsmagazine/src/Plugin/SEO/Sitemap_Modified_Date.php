<?php

namespace moorsmagazine\Plugin\SEO;

use moorsmagazine\WordPress\Integration;

class Sitemap_Modified_Date implements Integration {
	protected static $timestamp = 1510056000; // mktime( 12, 0, 0, 11, 7, 2017 );

	public function initialize() {
		add_filter( 'get_the_modified_date', [ $this, 'overwrite_modified_date' ], 10, 3 );
		add_filter( 'wpseo_sitemap_entry', [ $this, 'overwrite_sitemap_date' ], 10, 2 );
	}

	/**
	 * Overwrites the modified date for the sitemap.
	 *
	 * @param array  $url
	 * @param string $post_type
	 *
	 * @return array
	 */
	public function overwrite_sitemap_date( $url, $post_type ) {
		if ( $post_type !== 'post' ) {
			return $url;
		}

		$timestamp = mysql2date( 'U', $url['mod'] );
		if ( $timestamp < self::$timestamp ) {
			$url['mod'] = gmdate( 'Y-m-d H:i:s', self::$timestamp );
		}

		return $url;
	}

	/**
	 * Overwrites the last modified date.
	 *
	 * @param int      $the_time
	 * @param string   $d
	 * @param \WP_Post $post
	 *
	 * @return false|string
	 */
	public function overwrite_modified_date( $the_time, $d, $post ) {
		$timestamp = mysql2date( 'U', $post->post_modified );

		if ( $timestamp < self::$timestamp ) {
			return date( 'c', self::$timestamp );
		}

		return $the_time;
	}
}
