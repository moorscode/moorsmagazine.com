<header>
	<aside>
		<?php get_template_part( 'template-parts/content-header-image' ); ?>
	</aside>

	<div class="content">
		<?php

		// check if the repeater field has rows of data
		if ( have_rows( 'titles' ) ) {

			// loop through the rows of data
			while ( have_rows( 'titles' ) ) {
				the_row();

				// display a sub field value
				$type = get_sub_field( 'type' );
				$text = get_sub_field( 'text' );

				printf( '<%s>%s</%s>', $type, esc_html( $text ), $type );
			}
		} else {
			the_title( '<h1>', '</h1>' );
		}

		?>
	</div>
</header>
