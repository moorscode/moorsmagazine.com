<?php

if ( ! defined( 'ABSPATH' ) ) {
	header( 'Location: /', 301, true );
	exit;
}

$template = get_template_directory_uri();
$home = get_home_url();

$title = get_option( 'blogname' );
if ( ! is_front_page() ) {
	$title = sprintf( '<a href="%s">%s</a>', esc_url( $home ), esc_html( $title ) );
}

?><!DOCTYPE html>
<html lang="nl">
<head>
	<?php
	if ( ! is_user_logged_in() ):
	?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-17311600-2"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-17311600-2');
	</script>
	<?php
	endif;
	?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<meta name="template" content="<?php echo $template ?>">
	<meta name="theme-color" content="#328069">
	<link href="<?php echo $template ?>/img/favicon.ico" rel="SHORTCUT ICON">
	<link href="<?php echo $template ?>/img/favicon.ico" rel="icon" type="image/vnd.microsoft.icon">
	<?php wp_head(); ?>
</head>

<body <?php body_class() ?>>

<div id="masthead">
	<header>
		<h1><?php echo $title ?></h1>
		<?php get_template_part( 'template-parts/nav-main' ); ?>
	</header>
</div>


<div class="container">

