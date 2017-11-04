<?php
/**
 * @package moorsmagazine
 */

namespace moorsmagazine;

/**
 * Class Post_Enhancer
 */
class Post_Enhancer {
	/**
	 * Post_Enhancer constructor.
	 */
	public function __construct() {
		add_filter('manage_posts_columns' , array( $this, 'add_old_musicplayer_column' ) );
		add_action( 'manage_posts_custom_column' , array( $this, 'fill_old_musicplayer_column' ), 10, 2 );
	}

	function add_old_musicplayer_column($columns) {
		return array_merge( $columns,
			array('musicplayer' => __('Musicplayer')) );
	}

	public function fill_old_musicplayer_column( $column, $post_id ) {
		if ( 'musicplayer' === $column ) {
			$post = get_post($post_id);
			if ( false !== strpos( $post->post_content, 'AC_RunActiveContent' ) ) {
				echo '<b>OUD</b>';

				// <embed src="http://www.moorsmagazine.com/muziek/805twice/musicplayer.swf"
				if ( 0 !== preg_match( '~<embed src="http://www\.moorsmagazine\.com/(.*?)/musicplayer.swf"~', $post->post_content, $matches ) ) {
					echo '<br>Folder: /' . $matches[1] . '/';
				}
			}
		}
	}


}
