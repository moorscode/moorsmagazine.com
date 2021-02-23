<?php

if ( ! defined( 'ABSPATH' ) ) {
	header( 'Location: /', 301, true );
	exit;
}

get_header();

?>
	<div id="body">

		<aside>
			<p>
				Met onderstaande zoekmachine kun je zoeken binnen moors magazine. Als je een zoekwoord intikt en je
				klikt op "zoeken" word je automatisch doorgesluisd naar de speciale zoekpagina.
				Daar vind je de recente pagina's bovenaan en de oudste onderin.
			</p>

			<?php get_search_form() ?>

			<p>colofon</p>

			<p>moors magazine is de dagelijkse elektronische krant van holly moors, gestart op 13 november 2002, en
				vanaf die dag (bijna) elke dag verschenen.</p>

			<p>

				<a href="http://twitter.com/moorsmagazine" target="_blank" rel="noopener"><img
							alt="Volg Moors Magazine op Twitter" src="http://www.moorsmagazine.com/twitter-icon.gif"
							style="border-width: 0px;" height="32" width="32"></a>
				<a href="<?php bloginfo( 'rss2_url' ); ?>" target="_blank" rel="noopener"><img
							src="http://www.moorsmagazine.com/icon-rss-social.gif"
							style="border-width: 0px; margin-left: 7px;" height="32" width="32" alt="moorsmagazine RSS Feed"></a>
			</p>
		</aside>

		<div id="list">

			<?php

			$items = new WP_Query(
				array(
					'post_type'      => 'frontpage',
					'date_query'     => array(
						array(
							'column' => 'post_date_gmt',
							'after'  => '2 months ago',
						)
					),
					'posts_per_page' => - 1
				)
			);

			if ( $items->have_posts() ) {
				while ( $items->have_posts() ) {
					$items->the_post();

					$date = strtotime( get_field( 'date' ) );
					$date = strftime( '%A <h3>%e</h3> %B', $date );

					?>

					<section>
						<div class="date"><?php echo $date ?></div>
						<div class="item"><?php the_content() ?></div>
					</section>

					<?php
				}
			}

			?>

		</div>

	</div>

<?php

get_footer();
