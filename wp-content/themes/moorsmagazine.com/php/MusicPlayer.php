<?php

namespace moorsmagazine;

class MusicPlayer {
	public function add_hooks() {
		add_filter( 'the_content', [ $this, 'musicplayer_fix' ], 1, 1 );
	}

	public function musicplayer_fix( $content ) {

		if ( strpos( $content, 'AC_FL_RunContent' ) !== false ) {

			$original = get_post_meta( get_the_ID(), 'original_url', true );
			if ( $original ) {

				$base = str_replace( 'http://www.moorsmagazine.com', '', dirname( $original ) );

				$file = get_root() . $base . '/mp3s.xml';
				if ( is_file( $file ) ) {
					$file = file_get_contents( $file );
				} else {
					$file = false;
				}

				$file = str_replace( '&', '&amp;', $file );
				$file = str_replace( '&amp;amp;', '&amp;', $file );

				if ( $file ) {
					$xml = simplexml_load_string( $file );
					// $xml = simplexml_load_file( $file );

					$tracks = array();
					foreach ( $xml->Track as $track ) {
						$tracks[] = sprintf( '[mp3j track="%s" flip="y" title="%s"]', 'http://www.moorsmagazine.com' . $base . '/' . (string) $track->Mp3, (string) $track->Titel );
					}
					$content = preg_replace( '~<script language="javascript">(.*)</noscript>~si', '</p>' . implode( '<br>', $tracks ) . '<p>', $content );
				} else {
					$content = preg_replace( '~<script language="javascript">(.*)</noscript>~si', '', $content );
				}
			}
		}

		return $content;
	}
}
