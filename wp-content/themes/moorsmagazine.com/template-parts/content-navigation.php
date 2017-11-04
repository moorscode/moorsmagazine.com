<?php

$previous = get_previous_post_link();
$next     = get_next_post_link();

?>

<p class="frontpage">
	<a href="<?php echo home_url() ?>">terug naar de startpagina van moors magazine</a>
	<br>
	<br>
	<?php echo $previous . ( $previous && $next ? ' | ' : '' ) . $next ?>
</p>
