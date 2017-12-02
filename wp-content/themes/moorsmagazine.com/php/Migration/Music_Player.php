<?php

namespace moorsmagazine\Migration;

use moorsmagazine\WordPress\Integration;

class Music_Player implements Integration {
	public function initialize() {
		add_filter( 'the_content', [ $this, 'replace_music_player' ], 1, 1 );
	}

	/**
	 * Replaces flash mp3 player with shortcode.
	 *
	 * @param string $content The content to replace the music player in.
	 *
	 * @return string Replaced content.
	 */
	public function replace_music_player( $content ) {

		if ( strpos( $content, 'AC_FL_RunContent' ) === false ) {
			return $content;
		}

		$original = get_post_meta( get_the_ID(), 'original_url', true );
		if ( ! $original ) {
			return $content;
		}

		$replacement = '';

		$base = str_replace( 'http://www.moorsmagazine.com', '', dirname( $original ) );

		$file        = ABSPATH . $base . '/mp3s.xml';
		$xml_content = file_get_contents( $file );

		if ( $xml_content ) {
			$xml_content = str_replace( array( '&', '&amp;amp;' ), '&amp;', $xml_content );

			$xml = simplexml_load_string( $xml_content );

			$tracks = array();
			foreach ( $xml->Track as $track ) {
				$tracks[] = sprintf(
					'[mp3j track="%1$s" flip="y" title="%2$s"]',
					'http://www.moorsmagazine.com' . $base . '/' . (string) $track->Mp3,
					(string) $track->Titel
				);
			}

			$replacement = '</p>' . implode( '<br>', $tracks ) . '<p>';
		}

		return preg_replace( '~<script language="javascript">(.*)</noscript>~si', $replacement, $content );
	}
}
