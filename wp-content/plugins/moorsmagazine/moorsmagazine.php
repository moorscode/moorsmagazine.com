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

define( 'MOMA_PLUGIN_DIR', __DIR__ );

require_once 'autoloader.php';

if ( is_admin() ) {
	new Post_Enhancer();
}

$bump = new Bump_Modified_Date();
$bump->add_hooks();
