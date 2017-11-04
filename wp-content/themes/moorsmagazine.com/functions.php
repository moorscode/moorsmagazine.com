<?php

if ( ! defined( 'ABSPATH' ) ) {
	header( 'Location: /', 301, true );
	exit;
}

setlocale( LC_ALL, 'nl_NL' );

// add_filter( 'show_admin_bar', '__return_false' );

add_image_size( 'gallery-thumb', 192 );
add_image_size( 'voorpagina', 450 );
add_image_size( 'featured', 300 );

add_filter( 'image_size_names_choose', 'my_custom_sizes' );

add_action( 'init', 'custom_rewrite_rules' );
function custom_rewrite_rules() {
	add_rewrite_rule( '^index.html$', 'index.php', 'top' );
}

function my_custom_sizes( $sizes ) {
	return array_merge( $sizes, array(
		'voorpagina' => 'Voorpagina',
	) );
}

if ( ! defined( 'WPMDB_LICENCE' ) ) {
	define( 'WPMDB_LICENCE', '18625a21-91eb-4d2c-836e-0badec399140' );
}

add_action( 'init', 'create_custom_posts' );
function create_custom_posts() {
	wp_enqueue_script( 'jquery' );

	register_post_type(
		'frontpage',
		array(
			'menu_position'      => 2,
			'public'             => false,
			'publicly_queryable' => false,
			'label'              => 'Voorpagina',
			'show_ui'            => true,
			'show_in_menu'       => true,
			'hierarchical'       => false
		)
	);

	if ( function_exists( 'p2p_register_connection_type' ) ) {
		p2p_register_connection_type( array(
			'name'       => 'posts_to_posts',
			'from'       => 'post',
			'to'         => 'post',
			'reciprocal' => true
		) );
	}
}


add_action( 'admin_init', 'admin_init' );
function admin_init() {
	add_editor_style( get_template_directory_uri() . '/css/editor.css' );
}

add_action( 'after_setup_theme', 'after_theme_setup' );
function after_theme_setup() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
}

add_action( 'wp_head', 'add_ajaxurl' );
function add_ajaxurl() {
	echo '<script type="text/javascript">var ajaxurl = \'' . admin_url( 'admin-ajax.php' ) . '\';</script>';
}

add_action( 'wp_footer', 'add_original_url' );
function add_original_url() {
	if ( is_single() ) {
		echo '<script type="text/javascript">var originalurl = \'' . get_post_meta( get_the_ID(), 'original_url', true ) . '\';</script>';
	}
}

add_action( 'wp_ajax_gallery', 'ajax_gallery' );
add_action( 'wp_ajax_nopriv_gallery', 'ajax_gallery' );
function ajax_gallery() {
	$source = $_REQUEST['source'];

	require_once 'mm-gallery.php';
	generateAlbum( $source );

	exit();
}

add_filter( 'the_content', 'musicplayer_fix', 1, 1 );
function musicplayer_fix( $content ) {

	if ( strpos( $content, 'AC_FL_RunContent' ) !== false ) {

		$original = get_post_meta( get_the_ID(), 'original_url', true );
		if ( $original ) {

			$base = str_replace( 'http://www.moorsmagazine.com', '', dirname( $original ) );

			$file = get_root() . $base . '/mp3s.xml';
			$file = file_get_contents( $file );

			$file = str_replace( '&', '&amp;', $file );
			$file = str_replace( '&amp;amp;', '&amp;', $file );

			$xml = simplexml_load_string( $file );
			// $xml = simplexml_load_file( $file );

			$tracks = array();
			foreach ( $xml->Track as $track ) {
				$tracks[] = sprintf( '[mp3j track="%s" flip="y" title="%s"]', 'http://www.moorsmagazine.com' . $base . '/' . (string) $track->Mp3, (string) $track->Titel );
			}

			$content = preg_replace( '~<script language="javascript">(.*)</noscript>~si', '</p>' . implode( '<br>', $tracks ) . '<p>', $content );

		}
	}

	return $content;
}

function get_root() {
	static $root;

	if ( is_null( $root ) ) {
		if ( $_SERVER['HTTP_HOST'] == 'localhost' ) {
			$root = '/Volumes/Macintosh HDD/moorsmagazine.com/httpdocs';
		} else {
			$root = $_SERVER['DOCUMENT_ROOT'];
		}
	}

	return $root;
}

$related_posts = new Related_Posts();

class Related_Posts {
	/**
	 * @param \WP_Query $posts_query
	 * @param array     $posts
	 *
	 * @return array
	 */
	protected function bump_related_count( $posts_query, $posts ) {
		foreach ( $posts_query->posts as $post_id ) {
			if ( array_key_exists( $post_id, $posts ) ) {
				$posts[ $post_id ]['count'] += 1;
			} else {
				$posts[ $post_id ] = array(
					'count' => 1,
					'post'  => $post_id,
				);
			}
		}

		return $posts;
	}

	/**
	 * @param int $post_id
	 * @param int $limit
	 *
	 * @return array
	 */
	public function get( $post_id, $limit = 10 ) {
		$prominent_words = wp_get_post_terms(
			$post_id,
			\WPSEO_Premium_Prominent_Words_Registration::TERM_NAME,
			[ 'fields' => 'ids' ]
		);

		$related_posts = [];

		foreach ( $prominent_words as $prominent_word ) {
			$query_args  = array(
				'post__not_in' => [ $post_id ],
				'fields'       => 'ids',
				'tax_query'    => array(
					array(
						'taxonomy' => \WPSEO_Premium_Prominent_Words_Registration::TERM_NAME,
						'field'    => 'term_id',
						'terms'    => $prominent_word,
					),
				),
			);
			$posts_query = new \WP_Query( $query_args );

			$related_posts = $this->bump_related_count( $posts_query, $related_posts );
		}

		// Only fetch items with a count of 2 or higher.
		$related_posts = array_filter( $related_posts, function( $item ) {
			return ( $item['count'] > 1 );
		} );

		// Sort by count (descending).
		usort( $related_posts, function( $post_a, $post_b ) {
			return ( $post_b['count'] - $post_a['count'] );
		} );

		// Cut off excess.
		if ( $limit ) {
			$related_posts = array_slice( $related_posts, 0, $limit );
		}

		// Only return the post_ids.
		return wp_list_pluck( $related_posts, 'post' );
	}
}
