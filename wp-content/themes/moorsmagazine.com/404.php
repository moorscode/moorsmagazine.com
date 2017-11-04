<?php


$original_url = 'http://www.moorsmagazine.com' . str_replace( '/moorsmagazine', '', $_SERVER['REQUEST_URI'] );

if ( isset( $_REQUEST['url'] ) ) {
	$original_url = $_REQUEST['url'];
}

$redirect = new WP_Query( "post_type=post&meta_key=original_url&meta_value=$original_url" );
if ( $redirect->have_posts() ) {
	$redirect->the_post();

	wp_redirect( get_permalink(), 301 );
	exit();

}

get_header();

?>

	<div id="primary" class="content-area">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header>
				<aside>
<!--					<img src="http://ww.moorsmagazine.com/images/404.gif">-->
				</aside>

				<div class="content">
					<h1>pagina niet gevonden...</h1>

					<h2>- heeft u al geprobeerd te zoeken?</h2>
				</div>
			</header>

			<div class="text">
				<aside>
				</aside>

				<main id="main" class="site-main" role="main">

					<div class="content">
						<?php get_search_form() ?>
					</div>
				</main>
			</div>
		</article>
	</div>

<?php

get_footer();

