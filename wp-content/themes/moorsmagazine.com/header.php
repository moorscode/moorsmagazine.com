<?php

if ( ! defined( 'ABSPATH' ) ) {
	header( 'Location: /', 301, true );
	exit;
}

$template = get_template_directory_uri();
$home = get_home_url();

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="nl">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content="nl" http-equiv="Content-Language">
	<meta content="no" http-equiv="imagetoolbar">
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<meta name="template" content="<?php echo $template ?>">
	<link href="<?php echo $template ?>/img/favicon.ico" rel="SHORTCUT ICON">
	<link href="<?php echo $template ?>/img/favicon.ico" rel="icon" type="image/vnd.microsoft.icon">
	<link href='http://fonts.googleapis.com/css?family=Lusitana:400' rel='stylesheet' type='text/css'>
	<link href="<?php echo $template ?>/css/index.css?v=2" type="text/css" rel="stylesheet">
	<link href="<?php echo $template ?>/css/jquery.lightbox-0.5.css" type="text/css" rel="stylesheet">
	<?php wp_head(); ?>
</head>

<body <?php body_class() ?>>

<div id="masthead">

	<header>
		<h1><a href="<?php echo home_url() ?>"><?php echo get_option( 'blogname' ) ?></a></h1>

		<div class="container">
			<div id="categories" style="color: blue">
				<a href="<?php echo home_url() ?>">startpagina</a> &nbsp;&ndash;&nbsp;
				<a href="<?php echo $home ?>/muziek/">muziek</a>&nbsp; &bull;&nbsp;
				<a href="<?php echo $home ?>/boeken/">boeken</a>&nbsp; &bull;&nbsp;
				<a href="<?php echo $home ?>/cartoons/">cartoons en strips</a>&nbsp; &bull;&nbsp;
				<a href="<?php echo $home ?>/beeld-geluid/">films en tv</a>&nbsp; &bull;&nbsp;
				<a href="<?php echo $home ?>/kunst/">kunst</a>&nbsp; &bull;&nbsp;
				<a href="<?php echo $home ?>/fotografie/">fotografie</a>&nbsp; &bull;&nbsp;
				<a href="<?php echo $home ?>/muziek/agenda/">concerttips</a>
				&nbsp;&ndash;&nbsp;
				<script>(
						function( a, b, c ) {
							document.write( "<a href=\"" + a + ":" + b + "@" + c + ".com\">contact</a>" );
						}
					)( "mailto", "holly", "moorsmagazine" );</script>

				<br>

				<a href="<?php echo $home ?>/onzinbak/">onzin</a>&nbsp; &bull;&nbsp;
				<a href="<?php echo $home ?>/kaartenbak/">kaartenbak</a>&nbsp; &bull;&nbsp;
				<a href="<?php echo $home ?>/haren/">ons dorp</a>&nbsp; &bull;&nbsp;
				<a href="<?php echo $home ?>/actualia/">meningen en opinies</a>&nbsp; &bull;&nbsp;
				<a href="<?php echo $home ?>/buitenwereld/">buitenwereld</a>
				<br>
				<a href="<?php echo $home ?>/hollys-hoekje/">holly's hoekje</a>&nbsp; &bull;&nbsp;
				<a href="<?php echo $home ?>/fotos/">foto's holly moors</a>&nbsp; &bull;&nbsp;
				<a href="<?php echo $home ?>/gasten/">gastschrijvers</a>

			</div>
		</div>
	</header>
</div>


<div class="container">

