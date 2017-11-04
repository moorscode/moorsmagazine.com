<?php

if ( has_post_thumbnail() ) {
	$thumbnail = get_the_post_thumbnail_url( null, 'gallery-thumb' );
} else {
	$thumbnail = get_post_meta( get_the_ID(), 'original_featured', true );
}

?>
<header>
	<aside style="background-image: url('<?php echo esc_url( $thumbnail ) ?>');"></aside>

	<div class="content">
		<div class="spacer">
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
	</div>
</header>
