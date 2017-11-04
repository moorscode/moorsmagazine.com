<?php

$layout = get_field( 'layout' );

?>

<div class="text">
	<aside>
		<?php

		if ( $layout === 'left' ) {
			the_content();
		} else {
			the_field( 'supporttext' );
		}

		?>
	</aside>

	<main id="main" class="site-main" role="main">

		<div class="content">
			<?php

			if ( $layout === 'right' ) {
				the_content();
			} else {
				the_field( 'supporttext' );
			}

			// gallerij toevoegen:
			if ( get_field( 'gallery' ) ) {
				get_template_part( 'template-parts/content-gallery' );
			}

			?>
		</div>

		<?php get_template_part( 'template-parts/content-navigation' ); ?>

	</main><!-- .site-main -->

</div> <!-- main -->
