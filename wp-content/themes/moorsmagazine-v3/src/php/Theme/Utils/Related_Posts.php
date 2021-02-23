<?php

namespace moorsmagazine\Theme\Utils;

class Related_Posts {
	protected $post_id;
	protected $post_type;

	public function __construct( $post_id ) {
		$this->post_id   = $post_id;
		$this->post_type = get_post_type( $post_id );
	}

	/**
	 * Retrieves the related posts for the given post.
	 *
	 * @param int $limit Optional. Limit the amount of related items to retrieve.
	 *
	 * @return string HTML of the list of related articles.
	 */
	public function get_html( $limit = 6 ) {
		$output      = [];
		$suggestions = $this->get_link_suggestions( $limit );

		foreach ( $suggestions as $suggestion ) {
			$output[] = sprintf(
				'<a href="%1$s">%2$s</a>',
				$suggestion['link'],
				$suggestion['title']
			);
		}

		if ( empty( $output ) ) {
			return '';
		}

		return '<h4>Gerelateerde artikelen</h4><ul><li>' . implode( '</li><li>', $output ) . '</li></ul>';
	}

	/**
	 * @return array
	 */
	function get_link_suggestions( $limit ) {
		$suggestions = [];

		if ( ! function_exists( 'YoastSEOPremium' ) ) {
			return $suggestions;
		}

		$classes = $this->get_yoast_seo_classes();

		$indexable = $classes['indexable_repository']->find_by_id_and_type( $this->post_id, $this->post_type );
		if ( $indexable ) {
			$prominent_words = $classes['prominent_words_repository']->find_by_indexable_id( $indexable->id );

			$input = [];
			foreach ( $prominent_words as $prominent_word ) {
				$input[ $prominent_word->stem ] = $prominent_word->weight;
			}

			$suggestions = $classes['action']->get_suggestions( $input, $limit, $this->post_id, $this->post_type );
		}

		return $suggestions;
	}

	/**
	 * @return array
	 */
	function get_yoast_seo_classes() {
		static $classes;

		if ( empty( $classes ) ) {
			$get_container     = function () {
				return $this->get_container();
			};
			$Yoast_SEO_Premium = \YoastSEOPremium();
			$get_container     = \Closure::bind( $get_container, $Yoast_SEO_Premium, $Yoast_SEO_Premium );
			$container         = $get_container();

			$retrieve_objects = [
				'action'                     => 'Yoast\\WP\\SEO\Actions\\Link_Suggestions_Action',
				'indexable_repository'       => 'Yoast\\WP\\SEO\\Repositories\\Indexable_Repository',
				'prominent_words_repository' => 'Yoast\\WP\\SEO\\Repositories\\Prominent_Words_Repository',
			];

			foreach ( $retrieve_objects as $key => $retrieve ) {
				$classes[ $key ] = $container->get( strtolower( $retrieve ) );
			}
		}

		return $classes;
	}
}
