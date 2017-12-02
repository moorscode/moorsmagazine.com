<?php

namespace moorsmagazine\Plugin\Admin\Post;

use moorsmagazine\WordPress\Integration;

class Flip_Content_Placement implements Integration {
	public function initialize() {
		add_action( 'admin_init', [ $this, 'on_admin_init' ] );
		add_action( 'load-post.php', [ $this, 'handle_request' ] );
	}

	/**
	 * Registers a metabox to the post post-type.
	 */
	public function on_admin_init() {
		add_meta_box( 'mm_flip_content', 'Inhoud omwisselen', [ $this, 'do_metabox' ], 'post', 'side', 'high' );
	}

	/**
	 * Renders the metabox.
	 */
	public function do_metabox() {
		echo '<a href="?' . $_SERVER['QUERY_STRING'] . '&amp;flip_content=1" class="button button-large">Omwisselen hoofdtekst en bijtekst</a>';
	}

	/**
	 * Handles the flip request.
	 */
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
