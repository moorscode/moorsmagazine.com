<?php

if ( ! defined( 'ABSPATH' ) ) {
	header( 'Location: /', 301, true );
	exit;

}
$template = get_template_directory_uri();

wp_footer();

?>

<script type="text/javascript" src="<?php echo $template ?>/js/jquery.lightbox-0.5.min.js?v=1"></script>

</body>
</html>
