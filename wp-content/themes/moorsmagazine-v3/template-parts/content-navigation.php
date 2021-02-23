<?php

use moorsmagazine\Theme\Utils\Related_Posts;

$related_posts = new Related_Posts( get_queried_object_id() );

?>

<hr size="1">

<nav>
	<p class="frontpage">
		<?php
		echo $related_posts->get_html( 8 );
		?>
	</p>

	<p class="frontpage">&laquo; <a href="<?php echo home_url() ?>">terug naar de startpagina van moors magazine</a></p>
</nav>
