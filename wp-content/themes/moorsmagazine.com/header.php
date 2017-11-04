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
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<meta name="template" content="<?php echo $template ?>">
	<link href="<?php echo $template ?>/img/favicon.ico" rel="SHORTCUT ICON">
	<link href="<?php echo $template ?>/img/favicon.ico" rel="icon" type="image/vnd.microsoft.icon">
	<link href="<?php echo $template ?>/css/index.css?v=4" type="text/css" rel="stylesheet">
	<link href="<?php echo $template ?>/css/jquery.lightbox-0.5.css" type="text/css" rel="stylesheet">
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

