<?php

if ( has_post_thumbnail() ) {
	the_post_thumbnail( 'featured', array( 'class' => 'featured' ) );
} else {
	$original = get_post_meta( get_the_ID(), 'original_featured', true );
	if ( $original ) {
		echo '<img src="' . $original . '">';
	}
}
