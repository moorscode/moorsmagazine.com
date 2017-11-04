<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header();

$layout = get_field('layout');

the_post();

$previous = get_previous_post_link();
$next = get_next_post_link();

$categories = wp_get_post_categories(get_the_ID());

$_categories = array();
foreach ($categories as $categoryID) {
	$_categories[] = $categoryID;
	$category = get_category($categoryID);
	if ($category->category_parent) {
		$_categories[] = $category->category_parent;
	}
}

$filmpje = (in_array(142, $_categories));


?>

<div id="primary" class="content-area">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php

		if ( ! $filmpje ) {

			?>
			<header>
				<aside>
					<?php


					if (has_post_thumbnail()) {
						the_post_thumbnail( 'featured', array( 'class' => 'featured' ) );
					} else {
						$original = get_post_meta( get_the_ID(), 'original_featured', true );
						if ( $original ) {
							echo '<img src="' . $original . '">';
						}
					}

					?>
				</aside>

				<div class="content">
					<?php

					// check if the repeater field has rows of data
					if ( have_rows( 'titles' ) ) {

						// loop through the rows of data
						while ( have_rows( 'titles' ) ) {
							the_row();

							// display a sub field value
							$type = get_sub_field( 'type' );
							$text = get_sub_field( 'text' );

							printf( '<%s>%s</%s>', $type, $text, $type );
						}
					} else {
						the_title( '<h1>', '</h1>' );
					}


					?>
				</div>
			</header>
		<?php

		}

		?>

		<div class="text">
		<aside>
			<?php

			if ($layout == 'left') {
				the_content();
			} else {
				the_field('supporttext');
			}
			?>
		</aside>

		<main id="main" class="site-main" role="main">

		<div class="content">
			<?php
			if ( $layout == 'right' ) {
				the_content();
			} else {
				the_field( 'supporttext' );
			}


			// gallerij toevoegen:
			$gallery = get_field('gallery');
			if ($gallery) {

				$images = get_field( 'images' );
				if ( $images ) {
					echo '<div id="galerie">';

					foreach ( $images as $image ) {
						?>
						<section>
							<a href="<?php echo $image['sizes']['large']; ?>">
								<img src="<?php echo $image['sizes']['gallery-thumb']; ?>"
								     width="<?php echo $image['sizes']['gallery-thumb-width']; ?>"
								     height="<?php echo $image['sizes']['gallery-thumb-height']; ?>"
								     alt="<?php echo $image['alt']; ?>"/>
							</a><br>
							<?php echo $image['caption']; ?>&nbsp;</section>
					<?php
					}

					echo '</div>';
				}

			}
			?>
		</div>

			<p class="frontpage">
				<a href="<?php echo home_url() ?>">terug naar de startpagina van moors magazine</a>
				<br>
				<br>
				<?php echo $previous . ($previous && $next ? ' | ' : '') . $next ?>
			</p>


		</main><!-- .site-main -->

	</div> <!-- main -->
	</article><!-- #post-## -->
</div><!-- .content-area -->

<?php get_footer(); ?>
