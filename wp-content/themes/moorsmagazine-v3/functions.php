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

$bootstrap = new Theme\Bootstrap();
$bootstrap->initialize();
