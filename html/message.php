<?php 
	global $earth_hour_settings;
	global $earth_hour_minutes;
	$count = number_format( $earth_hour_settings['last_count'] );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title><?php bloginfo('name'); ?> - <?php _e( "Proudly Supporting Earth Hour", "earth-hour" ); ?></title>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo compat_get_plugin_url( 'earth-hour' ); ?>/css/earth-hour-event.css"></link>
	</head>
	<body>
		<div id="page">
			<div id="content">
				<h2><?php echo sprintf( __( "%s is currently participating in", "earth-hour" ), get_bloginfo('name') ); ?></h2>
				<p id="duane"><?php echo sprintf( __ngettext( "There is currently %d other WordPress site supporting this cause.",  "There are currently %d other WordPress sites supporting this cause.", $count, "earth-hour"), $count); ?></p>
				<p id="chloe"><?php echo __( "If you'd like to join us, download the <br /><a href=\"http://www.bravenewcode.com/earth-hour/\">WordPress Earth Hour plugin</a>", "earth-hour" ) ?></p>
				<p id="dale"><?php echo sprintf( __ngettext( "This website will be back online in %d minute.", "This website will be back online in %d minutes.", $earth_hour_minutes, "earth-hour" ), $earth_hour_minutes ); ?></p>
			</div>
		</div>
	</body>
</html>
