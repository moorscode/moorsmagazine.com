<?php
/*
Plugin Name: moors magazine
Plugin URI: https://www.moorsmagazine.com
Description: Addded functionality to moorsmagazine.com
Author: Jip Moors
Version: 1.0.0
Requires at least: 4.0
Author URI: http://jipmoors.nl
License: GPL v3
*/

namespace moorsmagazine;

define( 'MOORSMAGAZINE_PLUGIN_ROOT', __DIR__ );

if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

$bootstrap = new Plugin\Bootstrap();
$bootstrap->initialize();
