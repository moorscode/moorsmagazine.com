<?php
/*
Plugin Name: moors magazine - Duplicate Article Finder
Plugin URI: https://www.moorsmagazine.com
Description: Duplicate Article Finder
Version: 1.0.0
Author: Jip Moors
Author URI: https://jipmoors.nl
Text Domain: moorsmagazine
*/

namespace moorsmagazine;

class Find_Duplicate_Articles {
	public function register_hooks() {
		add_action( 'admin_menu', [ $this, 'register_options_page' ] );
	}

	public function register_options_page() {
		add_menu_page(
			'Duplicate Articles',
			'Duplicate Articles',
			'manage_options',
			'mm-duplicate-articles',
			[ $this, 'show_duplicate_articles' ]
		);
	}

	public function show_duplicate_articles() {
		global $wpdb;

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		echo '<div class="wrap">';

		$query = '
		SELECT post_name, ID, post_title FROM wp_posts
		WHERE post_name LIKE "%-2"
		AND post_status = "publish"
		AND post_type = "post"
		';

		$possible_duplicates = $wpdb->get_results( $query );

		foreach ( $possible_duplicates as $possible_duplicate ) {
			$query = 'SELECT post_name, ID, post_title FROM wp_posts
		WHERE post_name = %s
		AND post_title = %s
		AND post_status = "publish"
		AND post_type = "post"
		';
			$origin = $wpdb->get_results( $wpdb->prepare( $query, [ substr( $possible_duplicate->post_name, 0, -2 ), $possible_duplicate->post_title ] ) );
			if ( empty($origin ) ) {
				continue;
			}

			printf( '<a href="%s" target="_blank">source</a> <a href="%s" target="_blank">duplicate</a>: %s<br/>',
				get_admin_url( null, 'post.php?post=' . $origin[0]->ID . '&action=edit'),
				get_admin_url(null, 'post.php?post=' . $possible_duplicate->ID . '&action=edit' ),
				$origin[0]->post_title
			);
		}

		echo '</div>';
	}
}

add_action( 'plugins_loaded', function() {
	$instance = new Find_Duplicate_Articles();
	$instance->register_hooks();
} );
