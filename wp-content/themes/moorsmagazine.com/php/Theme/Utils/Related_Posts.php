<?php

namespace moorsmagazine\Theme\Utils;

class Related_Posts {
	/**
	 * @param array $post_ids
	 * @param array $related_posts
	 *
	 * @return array
	 */
	protected function bump_related_count( $post_ids, $related_posts ) {
		foreach ( $post_ids as $post_id ) {
			if ( ! array_key_exists( $post_id, $related_posts ) ) {
				$related_posts[ $post_id ] = array(
					'count' => 1,
					'post'  => $post_id,
				);
			} else {
				$related_posts[ $post_id ]['count'] += 1;
			}
		}

		return $related_posts;
	}

	/**
	 * Retrieves the related posts for the given post.
	 *
	 * @param int $post_id ID of the post.
	 * @param int $limit   Optional. Limit the amount of related items to retrieve.
	 *
	 * @return array List of post IDs that are related.
	 */
	public function get( $post_id, $limit = 10 ) {
		$prominent_word_ids = wp_get_post_terms(
			$post_id,
			\WPSEO_Premium_Prominent_Words_Registration::TERM_NAME,
			[ 'fields' => 'ids' ]
		);

		$related_posts = [];

		foreach ( $prominent_word_ids as $prominent_word_id ) {
			$query_args  = array(
				'post__not_in' => [ $post_id ],
				'fields'       => 'ids',
				'tax_query'    => array(
					array(
						'taxonomy' => \WPSEO_Premium_Prominent_Words_Registration::TERM_NAME,
						'field'    => 'term_id',
						'terms'    => $prominent_word_id,
					),
				),
			);
			$posts_query = new \WP_Query( $query_args );

			$related_posts = $this->bump_related_count( $posts_query->posts, $related_posts );
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
