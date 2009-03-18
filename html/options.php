<?php global $earth_hour_settings; ?>
<div class="wrap" id="earth_hour">
	<h2>Earth Hour</h2>
	
	<?php echo sprintf( __( "There are currently %d WordPress sites using this plugin and supporting Earth Hour.", "earth-hour" ), number_format( $earth_hour_settings['last_count'] ) ); ?>
</div>