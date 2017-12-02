<?php

namespace moorsmagazine\Assets;

use moorsmagazine\WordPress\Integration;

class Load implements Integration {

	/**
	 * Registers all hooks to WordPress.
	 */
	public function initialize() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'dequeue' ], 11 );

		add_action( 'init', [ $this, 'on_init' ] );
		add_action( 'wp_head', [ $this, 'on_wp_head' ], 2 );
		add_action( 'wp_footer', [ $this, 'on_wp_footer' ] );
	}

	/**
	 * Runs on init.
	 */
	public function on_init() {
		wp_enqueue_script( 'jquery' );
	}

	/**
	 * Runs on wp_head.
	 */
	public function on_wp_head() {
		if ( is_single() ) {
			echo '<script type="text/javascript">var ajaxurl = \'' . admin_url( 'admin-ajax.php' ) . '\';</script>';

			return;
		}

		wp_dequeue_style( 'mp3-jplayer' );
		wp_deregister_script( 'jquery' );
	}

	/**
	 * Runs on wp_footer.
	 */
	public function on_wp_footer() {
		if ( is_single() ) {
			echo '<script type="text/javascript">var originalurl = \'' . get_post_meta( get_the_ID(), 'original_url', true ) . '\';</script>';
		}
	}

	/**
	 * Remove enqueued scripts and styles.
	 */
	public function dequeue() {
		wp_dequeue_style( 'wpt-twitter-feed' );
	}

	/**
	 * Enqueue scripts and styles.
	 */
	public function enqueue() {
		$template_directory_uri = get_template_directory_uri();

		wp_enqueue_style(
			'moorsmagazine',
			$template_directory_uri . '/css/index.css',
			false,
			$this->get_file_version( '/css/index.css' )
		);

		if ( is_single() ) {
			wp_enqueue_script(
				'jquery-lightbox',
				$template_directory_uri . '/js/jquery.lightbox-0.5.min.js',
				[ 'jquery' ],
				$this->get_file_version( '/js/jquery.lightbox-0.5.min.js' ),
				true
			);

			wp_enqueue_style(
				'jquery-lightbox',
				$template_directory_uri . '/css/jquery.lightbox-0.5.css',
				false,
				$this->get_file_version( '/css/jquery.lightbox-0.5.css' ),
				'screen'
			);
		}
	}

	/**
	 * Returns the last modified date for a file.
	 *
	 * @return string Last modified date.
	 */
	protected function get_file_version( $path ) {
		return date( 'ymd-Gis', filemtime( MOORSMAGAZINE_THEME_ROOT . $path ) );
	}

}
