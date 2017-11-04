<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header();

?>

<aside>

	<?php

	global $wp_query;

	// echo get_category_parents($wp_query->query_vars['cat'], true, ' &ndash; ');

	$list = wp_list_categories(
		array(
			'hide_empty' => 1,
			'child_of' => $wp_query->queried_object_id,
			'show_count' => 0,
			'exclude' => array(1),
			'title_li' => '',
			'show_option_none' => '',
			'echo' => false
		)
	);

	if ($list) {
		echo '<h2>Onderverdeling:</h2>';
		echo '<ul id="categories">'.$list.'</ul>';
	}
	?>

</aside>


	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php

		query_posts(
			array(
				'category__in' => array($wp_query->query_vars['cat']),
			    'paged' => $paged,
				'posts_per_page=50',
			    'orderby' => array( 'date' => 'DESC', 'title' => 'ASC' )
			)
		);



			?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );

					$category = get_category($wp_query->query_vars['cat']);
					if ($category->parent) {
						$parent = get_category($category->parent);

						printf('<div class="parent">Dit is een onderverdeling uit de categorie <a href="%s">%s</a>.</div>', get_category_link($category->parent), mb_strtolower($parent->name));
					}
				?>
			</header><!-- .page-header -->

			<ul>
			<?php
			// Start the Loop.

			if ( have_posts() ) :

			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */

				the_title( sprintf( '<li><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></li>' );

			// End the loop.
			endwhile;

			?>
			</ul>
			<?php

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => '&laquo; vorige pagina',
				'next_text'          => 'volgende pagina &raquo;',
				'before_page_number' => '<span class="meta-nav screen-reader-text">pagina </span>',
			) );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'content', 'none' );

		endif;
		?>

		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php


wp_reset_query();

get_footer();

?>
