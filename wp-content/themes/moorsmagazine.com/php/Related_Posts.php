<?php

namespace moorsmagazine;

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
