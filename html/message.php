<?php 
	include( dirname(__FILE__) . "/../../../../wp-config.php" );
	global $earth_hour_settings;
	$count = number_format( $earth_hour_settings['last_count'] );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title><?php bloginfo('name'); ?> - <?php _e( "Proudly Supporting Earth Hour", "earth-hour" ); ?></title>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('wpurl'); ?>/wp-content/plugins/earth-hour/html/style.css"></link>
	</head>
	<body>
		<?php echo $count; ?>
	</body>
</html>
