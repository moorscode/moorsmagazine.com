<?php

if ( ! defined( 'ABSPATH' ) ) {
	header( 'Location: /', 301, true );
	exit;
}

get_header();

?>
	<div id="body">

		<div id="list">

			<?php

			$paged = (int) get_query_var( 'paged' );
			$paged = max( 1, $paged );

			$items = new WP_Query(
				array(
					'post_type'      => 'frontpage',
					'paged'          => $paged,
					'posts_per_page' => 14
				)
			);

			if ( $items->have_posts() ) {
				while ( $items->have_posts() ) {
					$items->the_post();

					$date = strtotime( get_field( 'date' ) );
					$date = strftime( '%A %e %B', $date );

					?>

					<section>
						<h2><?php echo $date ?></h2>
						<div class="item"><?php the_content() ?></div>
					</section>

					<?php
				}
			}

			?>

			<?php previous_posts_link(); ?>
			<div class="align-right">
				<?php next_posts_link(); ?>
			</div>

		</div>

		<aside>
			<?php get_search_form() ?>

			<p><strong>colofon</strong></p>

			<p>moors magazine is de dagelijkse elektronische krant van holly moors, gestart op 13 november 2002, en
				vanaf die dag (bijna) elke dag verschenen.</p>

			<p>

				<a href="http://twitter.com/moorsmagazine" target="_blank" rel="noopener"><img
							alt="Volg Moors Magazine op Twitter" src="http://www.moorsmagazine.com/twitter-icon.gif"
							style="border-width: 0px;" height="32" width="32"></a>
				<a href="<?php bloginfo( 'rss2_url' ); ?>" target="_blank" rel="noopener"><img
							src="http://www.moorsmagazine.com/icon-rss-social.gif"
							style="border-width: 0px; margin-left: 7px;" height="32" width="32"
							alt="moorsmagazine RSS Feed"></a>
			</p>
		</aside>

	</div>

<?php

get_footer();
