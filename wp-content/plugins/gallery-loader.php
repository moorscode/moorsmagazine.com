<?php
/*
Plugin Name: moors magazine - Gallery Loader
Plugin URI: https://www.moorsmagazine.com
Description: Legacy Gallery loader
Version: 1.0.0
Author: Jip Moors
Author URI: https://jipmoors.nl
Text Domain: moorsmagazine
*/

namespace moorsmagazine;

add_action( 'plugins_loaded', function() {
	$loader = new Gallery_Loader();
	$loader->register_hooks();
} );

class Gallery_Loader {
	public function register_hooks() {
		if ( ! is_admin() ) {
			add_filter( 'the_content', [ $this, 'load_gallery' ] );
			add_filter( 'acf/load_value/name=supporttext', [ $this, 'load_gallery' ] );
		}
	}

	public function load_gallery( $body ) {
		if ( strpos( $body, '<div id="gallery"' ) === false ) {
			echo '<!-- div id=gallery not found -->';

			return $body;
		}

		$post_id = get_the_ID();

		$original_path = get_post_meta( $post_id, 'original_url', true );
		$original_path = str_replace( array(
			'http://moorsmagazine.com/',
			'http://www.moorsmagazine.com/',
			'https://moorsmagazine.com/',
			'https://www.moorsmagazine.com/'
		), '', $original_path );

		$full_path = dirname( ABSPATH . $original_path );

		if ( ! is_file( $full_path . DIRECTORY_SEPARATOR . 'gallery.php' ) ) {
			echo '<!-- gallery.php not found in ' . $full_path . ' -->';

			return $body;
		}

		$gallery = new Gallery( dirname( $original_path ) );

		echo '<!-- replacing gallery for ' . $full_path . ' -->';

		return preg_replace( '/<div id="gallery"([^<]+)<\/div>/', sprintf( '<div id="gallery">%s</div>', $gallery->generate() ),
			$body );
	}
}

class Gallery {
	private $path;

	public function __construct( $path ) {
		$this->path = $path;
	}

	public function generate() {
		$html = '';

		$path = $this->path;

		$files = glob( ABSPATH . $path . '/*.jpg' );
		asort( $files );

		if ( ! empty( $files ) ) {
			foreach ( $files as $file ) {
				$filename = basename( $file );
				$thumb    = is_file( $path . '/thumbs/' . $filename ) ? $path . '/thumbs/' . $filename : $path . $filename;

				// build list
				$html .= sprintf( '<a href="/%s"><img src="/%s" width="192" /></a><br />', $filename, $thumb );
			}
		}

		return $html;
	}
}
