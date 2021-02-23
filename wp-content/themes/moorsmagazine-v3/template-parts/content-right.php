<section class="site-main" role="main">
	<?php

	the_content();

	// gallerij toevoegen:
	if ( get_field( 'gallery' ) ) {
		get_template_part( 'template-parts/content-gallery' );
	}

	get_template_part( 'template-parts/content-navigation' );

	?>
</section>

<section class="site-extra">
	<?php the_field( 'supporttext' ); ?>
</section>
