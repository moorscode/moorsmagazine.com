<header>
	<figure>
		<?php get_template_part( 'template-parts/content-header-image' ); ?>
	</figure>

	<div class="titles">
	<?php

	// check if the repeater field has rows of data
	if ( have_rows( 'titles' ) ) {

		// loop through the rows of data
		while ( have_rows( 'titles' ) ) {
			the_row();

			// display a sub field value
			$type = get_sub_field( 'type' );
			$text = get_sub_field( 'text' );

			if ( $type === 'h1' ) {
				printf( '<%s>%s</%s>', $type, esc_html( $text ), $type );
			} else {
				printf( '<div class="%s">%s</div>', $type, esc_html( $text ), $type );
			}
		}
	} else {
		the_title( '<h1>', '</h1>' );
	}

	?>
	</div>
</header>
