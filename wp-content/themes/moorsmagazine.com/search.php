<?php
/**
 * The template for displaying search results pages.
 *
 * @package    WordPress
 * @subpackage Twenty_Fifteen
 * @since      Twenty Fifteen 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	header( 'Location: /', 301, true );
	exit;
}

get_header(); ?>

<div id="primary" class="content-area">
	<article>
		<div class="text">
			<aside>
			</aside>

			<main id="main" class="site-main" role="main">

				<?php if ( have_posts() ) : ?>

					<header class="page-header">
						<h1 class="page-title">Zoekresultaten voor: <?php echo get_search_query() ?></h1>
					</header><!-- .page-header -->

					<ul>
						<?php
						// Start the loop.
						while ( have_posts() ) : the_post(); ?>

							<?php
							/*
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
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

			</main>
			<!-- .site-main -->
		</div>
	</article>
</div><!-- .content-area -->

<?php get_footer(); ?>
