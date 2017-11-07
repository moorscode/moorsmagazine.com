<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package    WordPress
 * @subpackage Twenty_Fifteen
 * @since      Twenty Fifteen 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	header( 'Location: /', 301, true );
	exit;
}

get_header();

the_post();

$categories = wp_get_post_categories( get_the_ID() );

$_categories = array();
foreach ( $categories as $categoryID ) {
	$_categories[] = $categoryID;
	$category      = get_category( $categoryID );
	if ( $category->category_parent ) {
		$_categories[] = $category->category_parent;
	}
}

$filmpje = ( in_array( 142, $_categories ) );

?>

	<main>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php

			if ( ! $filmpje ) {
				get_template_part( 'template-parts/content-header' );
			}

			?>
			<div class="content">
				<?php
				get_template_part( 'template-parts/content', get_field( 'layout' ) );
				?>
			</div>

		</article>
	</main>

<?php

get_footer();
