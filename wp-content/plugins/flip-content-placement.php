<?php
/*
Plugin Name: moors magazine - Flip Content Placement
Plugin URI: https://www.moorsmagazine.com
Description: Content placement changer
Version: 1.0.0
Author: Jip Moors
Author URI: https://jipmoors.nl
Text Domain: moorsmagazine
*/

namespace moorsmagazine;

class Flip_Content_Placement {
	public function add_hooks() {
		add_action( 'admin_init', [ $this, 'admin_init' ] );
		add_action( 'load-post.php', [ $this, 'handle_request' ] );
	}

	public function admin_init() {
		add_meta_box( 'mm_flip_content', 'Inhoud omwisselen', [ $this, 'do_metabox' ], 'post', 'side', 'high' );
	}

	public function do_metabox() {
		$post   = get_post( $_GET['post'] );
		$layout = get_field( 'layout', $post->ID );

		echo '<a href="?' . $_SERVER['QUERY_STRING'] . '&amp;flip_content=1" class="button button-large">Omwisselen hoofdtekst en bijtekst</a>';
	}

	public function handle_request() {
		if ( filter_input( INPUT_GET, 'flip_content' ) !== '1' ) {
			return;
		}

		$post = get_post( $_GET['post'] );

		// Swap `post_content` with `get_field('supporttext')`
		$content     = $post->post_content;
		$alternative = get_field( 'supporttext', $post->ID, false );
		$layout      = get_field( 'layout', $post->ID );

		$new_layout = $layout === 'right' ? 'left' : 'right';

		wp_update_post( [
			'ID'           => $post->ID,
			'post_content' => $alternative
		] );

		update_field( 'supporttext', $content, $post->ID );
		update_field( 'layout', $new_layout, $post->ID );

		wp_safe_redirect( get_admin_url( null, 'post.php?post=' . $post->ID . '&action=edit' ) );
		exit;
	}
}

add_action( 'plugins_loaded', function() {
	$instance = new Flip_Content_Placement();
	$instance->add_hooks();
} );
