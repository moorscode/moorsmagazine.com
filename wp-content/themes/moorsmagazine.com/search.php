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

<section id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">Zoekresultaten voor: <?php echo get_search_query() ?></h1>
			</header><!-- .page-header -->

			<div class="listing">
				<?php
				// Start the loop.
				while ( have_posts() ) : the_post();
					echo '<a href="' . esc_url( get_permalink() ) . '">';
					get_template_part( 'template-parts/archive-item' );
					echo '</a>';
				endwhile;
				?>
			</div>
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
</section><!-- .content-area -->

<?php get_footer(); ?>
