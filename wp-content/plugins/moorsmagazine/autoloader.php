<?php
/**
 * @package moorsmagazine
 *
 * Load the classes.
 */

spl_autoload_register( function ( $class ) {

	$parts = explode( '\\', $class, 2 );
	if ( 'moorsmagazine' !== $parts[0] ) {
		return;
	}

	$lookup = array(
		'Post_Enhancer' => 'class-post-enhancer',
		'Bump_Modified_Date' => 'class-bump-modified-date'
	);

	if ( isset( $lookup[ $parts[1] ] ) ) {
		$filename = __DIR__ . '/classes/moorsmagazine/' . $lookup[ $parts[1] ] . '.php';
		require_once $filename;
	}

} );
