<?php
/**
 * @package moorsmagazine
 */

namespace moorsmagazine\Plugin\Admin\Post;

use moorsmagazine\WordPress\Integration;

/**
 * Class Post_Enhancer
 */
class Music_Player_Column implements Integration {
	/**
	 * Post_Enhancer constructor.
	 */
	public function initialize() {
		add_filter( 'manage_posts_columns', [ $this, 'add_old_musicplayer_column' ] );
		add_action( 'manage_posts_custom_column', [ $this, 'fill_old_musicplayer_column' ], 10, 2 );
	}

	/**
	 * Adds the Musicplayer column to the post list.
	 *
	 * @param array $columns List of columns.
	 *
	 * @return array Enhanched list of columns.
	 */
	public function add_old_musicplayer_column( $columns ) {
		return array_merge(
			$columns,
			[ 'musicplayer' => 'Musicplayer' ]
		);
	}

	/**
	 * Adds content to the column when applicable.
	 *
	 * @param string $column  The name of the column.
	 * @param int    $post_id The post ID of the current post.
	 */
	public function fill_old_musicplayer_column( $column, $post_id ) {
		if ( 'musicplayer' !== $column ) {
			return;
		}

		$post = get_post( $post_id );
		if ( false === strpos( $post->post_content, 'AC_RunActiveContent' ) ) {
			return;
		}

		echo '<b>OUD</b>';
		if ( 0 !== preg_match( '~<embed src="http://www\.moorsmagazine\.com/(.*?)/musicplayer.swf"~',
				$post->post_content, $matches ) ) {
			echo '<br>Folder: /' . $matches[1] . '/';
		}
	}
}
