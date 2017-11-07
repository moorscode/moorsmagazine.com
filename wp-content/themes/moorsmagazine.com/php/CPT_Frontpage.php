<?php

namespace moorsmagazine;

class CPT_Frontpage {
	public function add_hooks() {
		add_action( 'init', [ $this, 'register' ] );
	}

	public function register() {
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
}
