<?php

namespace moorsmagazine\AJAX;

use moorsmagazine\WordPress\Integration;

class Gallery implements Integration {
	protected static $connection;

	public function initialize() {
		add_action( 'wp_ajax_gallery', [ $this, 'ajax_gallery' ] );
		add_action( 'wp_ajax_nopriv_gallery', [ $this, 'ajax_gallery' ] );
	}

	/**
	 * Handles the AJAX request.
	 */
	public function ajax_gallery() {
		$source = $_REQUEST['source'];

		$this->generateAlbum( $source );

		exit();
	}

	/**
	 * Generates an album.
	 *
	 * @param string $source
	 */
	protected function generateAlbum( $source ) {
		$html = '';

		$path = str_replace( [
			'http://www.moorsmagazine.com',
			'https://www.moorsmagazine.com'
		], ABSPATH, dirname( $source ) );

		$files = glob( $path . '/*.jpg' );
		asort( $files );

		if ( ! empty( $files ) ) {
			foreach ( $files as $file ) {

				if ( strpos( $file, 'kop.jpg' ) !== false ) {
					continue;
				}

				$thumb = str_replace( $path . '/', $path . '/thumbs/', $file );
				if ( ! file_exists( $thumb ) ) {
					$this->generateThumb( $file, $thumb );
				}

				$filename = basename( $file );
				if ( ! is_file( $path . '/thumbs/' . $filename ) ) {
					continue;
				}

				// build list
				$base = dirname( $source );
				$html .= '<a href="' . $base . '/' . $filename . '"><img src="' . $base . '/thumbs/' . $filename . '" width="192" /></a><br />';
			}
		}

		if ( isset( self::$connection ) && is_resource( self::$connection ) ) {
			ftp_close( self::$connection );
		}

		echo $html;
	}

	/**
	 * Establishes an FTP connection.
	 *
	 * @return resource
	 */
	protected function get_ftp_connection() {
		if ( ! is_resource( self::$connection ) ) {
			// set up basic connection
			$connection = ftp_connect( '127.0.0.1' );

			// login with username and password
			ftp_login( $connection, 'moorsmag', 'in6692az' );

			$path   = realpath( './' ) . '/thumbs';
			$ftpdir = '/httpdocs' . str_replace( $_SERVER['DOCUMENT_ROOT'], '', $path ) . '/';

			if ( false === ftp_chdir( $connection, $ftpdir ) ) {
				ftp_mkdir( $connection, $ftpdir );
				ftp_chdir( $connection, $ftpdir );
			}

			self::$connection = $connection;
		}

		return self::$connection;
	}

	/**
	 * Generates a thumbnail for a specific image.
	 *
	 * @param string $source
	 * @param string $destination
	 */
	protected function generateThumb( $source, $destination ) {

		$connection = null;
		if ( $_SERVER['HTTP_HOST'] !== 'localhost' ) {
			$connection = $this->get_ftp_connection();
		}

		$tmp = tmpfile();

		// resize, contraint to 50 x ?
		list( $width, $height ) = getimagesize( $source );
		if ( $width > 192 ) {

			$source_image = imagecreatefromjpeg( $source );
			$new_height   = floor( ( $height / $width ) * 192 );

			$thumb = imagecreatetruecolor( 192, $new_height );
			imagecopyresampled( $thumb, $source_image, 0, 0, 0, 0, 192, $new_height, $width, $height );
			imagedestroy( $source_image );

			ob_start();
			imagejpeg( $thumb, null, 100 );
			$data = ob_get_clean();

			fwrite( $tmp, $data );
			fseek( $tmp, 0 );

			imagedestroy( $thumb );

		} else {
			$tmp = fopen( $source, 'rb' );
		}

		if ( null !== $connection && is_resource( $connection ) ) {
			ftp_fput( $connection, basename( $source ), $tmp, FTP_BINARY );
		} else {
			copy( $tmp, $destination );
		}
	}
}
