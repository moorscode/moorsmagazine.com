<?php

namespace moorsmagazine;

if ( ! defined( 'ABSPATH' ) ) {
	header( 'Location: /', 301, true );
	exit;
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

require_once __DIR__ . '/php/bootstrap.php';
$bootstrap = new bootstrap();
$bootstrap->boot();
