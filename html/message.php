<?php 
	global $earth_hour_settings;
	global $earth_hour_minutes;
	$count = number_format( $earth_hour_settings['last_count'] );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title><?php bloginfo('name'); ?> - <?php _e( "Proudly Supporting Earth Hour", "earth-hour" ); ?></title>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo WP_PLUGIN_URL; ?>/earth-hour/css/earth-hour-event.css"></link>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('home'); ?>/?earth_hour_dynamic_css=1"></link>
		<script type='text/javascript' src='<?php bloginfo('wpurl'); ?>/wp-includes/js/jquery/jquery.js'></script>
	</head>
	<body>
		<div id="page">
		<?php if ( isset( $_GET['earth_hour_preview'] )	) { ?><div class="preview">preview mode <a href="<?php bloginfo('wpurl'); ?>/wp-admin/options-general.php?page=earth-hour.php" id="admin-return">&larr; Earth Hour Admin Settings</a></div><?php } ?>
			<div id="earth_hour">
				<p class="admin-text"><?php echo $settings['earth_hour_text']; ?></p>
				<p class="below-image"><?php echo sprintf( __ngettext( "There is currently %d other WordPress site participating in the event.",  "There are currently %d other WordPress sites participating in the event.", $count, "earth-hour"), $count); ?></p>
				<p><?php echo __( "If you'd like to join us, download the <br /><a href=\"http://www.bravenewcode.com/earth-hour/\">WordPress Earth Hour plugin</a>", "earth-hour" ) ?></p>
				<p><?php echo sprintf( __ngettext( "This website will be back online in %d minute.", "This website will be back online in %d minutes.", $earth_hour_minutes, "earth-hour" ), $earth_hour_minutes ); ?></p>
			</div>
		</div>
	</body>
</html>
