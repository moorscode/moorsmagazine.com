<?php

$images = get_field( 'images' );
if ( $images ) {
	echo '<div id="galerie">';

	foreach ( $images as $image ) {
		?>
		<section>
			<a href="<?php esc_attr_e( $image['sizes']['large'] ); ?>">
				<img src="<?php esc_attr_e( $image['sizes']['gallery-thumb'] ); ?>"
					 width="<?php esc_attr_e( $image['sizes']['gallery-thumb-width'] ); ?>"
					 height="<?php esc_attr_e( $image['sizes']['gallery-thumb-height'] ); ?>"
					 alt="<?php esc_attr_e( $image['alt'] ); ?>"/>
			</a><?php echo ( empty( $image['caption'] ) ? '' : '<br>' . $image['caption'] . '&nbsp;' ); ?>
        </section>
		<?php
	}

	echo '</div>';
}
