<?php

function generateAlbum( $source ) {
	$html = '';

	$path  = str_replace( 'http://www.moorsmagazine.com', get_root(), dirname( $source ) );
	$path  = str_replace( 'https://www.moorsmagazine.com', get_root(), $path );

	$files = glob( $path . '/*.jpg' );
	asort( $files );

	if ( ! empty( $files ) ) {
		foreach ( $files as $file ) {

			if ( strpos( $file, 'kop.jpg' ) !== false ) {
				continue;
			}

			$thumb = str_replace( $path . '/', $path . '/thumbs/', $file );
			if ( ! file_exists( $thumb ) ) {
				generateThumb( $file, $thumb );
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

	if ( isset( $GLOBALS['ftp_connection'] ) && is_resource( $GLOBALS['ftp_connection'] ) ) {
		ftp_close( $GLOBALS['ftp_connection'] );
	}

	echo $html;
}

function generateThumb( $source, $destination ) {

	if ( $_SERVER['HTTP_HOST'] != 'localhost' ) {
		if ( ! is_resource( $GLOBALS['ftp_connection'] ) ) {
			// set up basic connection
			$c_ftp = ftp_connect( '127.0.0.1' );

			// login with username and password
			$login_result = ftp_login( $c_ftp, 'moorsmag', 'in6692az' );

			$path   = realpath( './' ) . '/thumbs';
			$ftpdir = '/httpdocs' . str_replace( $_SERVER['DOCUMENT_ROOT'], '', $path ) . '/';

			if ( false === ftp_chdir( $c_ftp, $ftpdir ) ) {
				ftp_mkdir( $c_ftp, $ftpdir );
				ftp_chdir( $c_ftp, $ftpdir );
			}

			$GLOBALS['ftp_connection'] =& $c_ftp;
		} else {
			$c_ftp =& $GLOBALS['ftp_connection'];
		}
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
		$tmp = fopen( $source, 'r' );
	}

	if ( isset( $c_ftp ) ) {
		$saved = ftp_fput( $c_ftp, basename( $source ), $tmp, FTP_BINARY );
	} else {
		copy( $tmp, $destination );
	}
}
