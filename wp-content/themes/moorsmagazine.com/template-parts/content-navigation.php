<?php

$related_posts = new \moorsmagazine\Related_Posts();
$posts = $related_posts->get( get_queried_object_id() );

?>

<hr size="1">

<nav>
	<p class="frontpage">
		<?php

		if ( $posts ) {
			echo 'Gerelateerde artikelen:';
			echo '<ul>';
			foreach ( $posts as $post_id ) {
				printf( '<li><a href="%s">%s</a></li>', esc_url( get_permalink( $post_id ) ), get_the_title( $post_id ) );
			}
			echo '</ul>';
		}
		?>
	</p>

	<p class="frontpage">&laquo; <a href="<?php echo home_url() ?>">terug naar de startpagina van moors magazine</a></p>
</nav>
