<?php

namespace moorsmagazine;

if ( ! defined( 'ABSPATH' ) ) {
	header( 'Location: /', 301, true );
	exit;
}

define( 'MOORSMAGAZINE_THEME_ROOT', __DIR__ );

if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

function get_root() {
	static $root;

	if ( null === $root ) {
		if ( $_SERVER['HTTP_HOST'] === 'localhost' ) {
			$root = '/Volumes/Macintosh HDD/moorsmagazine.com/httpdocs';
		} else {
			$root = $_SERVER['DOCUMENT_ROOT'];
		}
	}

	return $root;
}

$bootstrap = new Bootstrap();
$bootstrap->initialize();
