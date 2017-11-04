<nav class="main">
	<div class="container" id="categories">
		<form id="category-select" class="category-select" action="<?php echo esc_url( home_url( '/' ) ); ?>"
			  method="get">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">startpagina</a> &nbsp;&ndash;&nbsp;

			<?php wp_dropdown_categories(
				[
					'orderby'      => 'name',
					'hierarchical' => 1,
					'show_count'   => 0
				]
			); ?>
			<input type="submit" name="submit" value="bekijk overzicht"/>
			&nbsp;&ndash;&nbsp;
			<a href="mailto:holly@moorsmagazine.com">contact</a>
		</form>

	</div>
</nav>
