<?php

namespace moorsmagazine;

class bootstrap {

	public function boot() {
		$this->load_always();

		$this->add_hooks();
		if ( is_admin() ) {
			$this->add_admin_hooks();
		}
	}

	protected function load_always() {
		setlocale( LC_ALL, 'nl_NL' );

		add_image_size( 'gallery-thumb', 192 );
		add_image_size( 'voorpagina', 450 );
		add_image_size( 'featured', 300 );

		spl_autoload_register( [ $this, 'autoload' ] );
	}

	protected function autoload( $class_name ) {
		if ( strpos( $class_name, 'moorsmagazine\\' ) !== 0 ) {
			return;
		}

		$class_name = substr( $class_name, strlen( 'moorsmagazine\\' ) );

		include_once __DIR__ . '/' . $class_name . '.php';
	}

	protected function add_hooks() {
		$music_player = new MusicPlayer();
		$music_player->add_hooks();

		$gallery = new AJAX_Gallery();
		$gallery->add_hooks();

		$cpt_frontpage = new CPT_Frontpage();
		$cpt_frontpage->add_hooks();

		add_action( 'init', function() {
			add_rewrite_rule( '^index.html$', 'index.php', 'top' );
		} );

		add_action( 'init', function() {
			wp_enqueue_script( 'jquery' );
		} );

		add_action( 'wp_head', function() {
			echo '<script type="text/javascript">var ajaxurl = \'' . admin_url( 'admin-ajax.php' ) . '\';</script>';
		} );

		add_action( 'wp_footer', function() {
			if ( is_single() ) {
				echo '<script type="text/javascript">var originalurl = \'' . get_post_meta( get_the_ID(), 'original_url', true ) . '\';</script>';
			}
		} );

		add_action( 'after_setup_theme', function() {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'title-tag' );
		} );

		add_filter( 'image_size_names_choose', function( $sizes ) {
			return array_merge( $sizes, array(
				'voorpagina' => 'Voorpagina',
			) );
		} );
	}

	protected function add_admin_hooks() {
		add_action( 'admin_init', function() {
			add_editor_style( get_template_directory_uri() . '/css/editor.css' );
		} );
	}
}
