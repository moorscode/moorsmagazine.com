<?php

namespace moorsmagazine;

class Bump_Modified_Date {
	public function add_hooks() {
		add_filter( 'get_the_modified_date', [ $this, 'overwrite_modified_date' ], 10, 3 );
	}

	public function overwrite_modified_date( $the_time, $d, $post ) {
		$timestamp = mysql2date( 'U', $post->post_modified );
		$test = mktime( 12, 0, 0, 11, 7, 2017 );
		if ( $timestamp < $test ) {
			return date( 'c', $test );
		}

		return $the_time;
	}
}
