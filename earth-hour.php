<?php
/*
Plugin Name: Earth Hour
Plugin URI: http://www.bravenewcode.com/earth-hour/
Description: Changing the world, one website at a time.
Author: Dale Mugford and Duane Storey
Version: 1.0.0
Author URI: http://www.bravenewcode.com
*/

add_action( 'init', 'earth_hour_init' );
add_action( 'wp_head', 'earth_hour_head' );
add_action( 'wp_footer', 'earth_hour_footer' );

register_activation_hook( __FILE__, 'earth_hour_activate' );
register_deactivation_hook( __FILE__, 'earth_hour_deactivate' );

global $earth_hour_settings;
$earth_hour_default_settings = array(
	'currently_in_earth_hour' => false
);


function earth_hour_activate() {
}

function earth_hour_deactivate() {
}

function earth_hour_is_active() {
	global $earth_hour_settings;
	return ( $earth_hour_settings['currently_in_earth_hour'] );
}

function earth_hour_head() {
	echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"" . get_bloginfo('wpurl') . "/wp-content/plugins/earth-hour/css/earth-hour.css\"></link>";
}

function earth_hour_footer() {
	if ( !earth_hour_is_active() ) {
		echo "<script type=\"text/javascript\">\n";
		echo "\tvar d = document.createElement('div');\n";
		echo "\td.id = 'bnc_earth_hour';\n";
		echo "\tdocument.body.insertBefore(d, document.body.firstChild);\n";
		echo "</script>\n";
	}	
}

function earth_hour_settings() {
	global $earth_hour_settings;
	
	return $earth_hour_settings;
}

function earth_hour_update_settings() {
	global $earth_hour_settings;
	update_option( 'bnc_earth_hour', $earth_hour_settings );
}

function earth_hour_init() {
	global $earth_hour_settings;
	global $earth_hour_default_settings;
	
	$settings = get_option( 'bnc_earth_hour' );
	if ( $settings) {
		$earth_hour_settings = settings;
	} else {
		$earth_hour_settings = $earth_hour_default_settings;
	}
	
	$start_time = mktime( 20, 30, 0, 3, 28, 2009 );
	$end_time = $start_time + 60;
	$now_time = time();

	if ( $now_time >= $start_time && $now_time <= $end_time) {
		// we are in earth hour
		if ( $earth_hour_settings['currently_in_earth_hour'] ) {
			$earth_hour_settings['currently_in_earth_hour'] = true;	
			earth_hour_update_settings();
		}		
	} else {
		// we are not in earth hour
		if ( $earth_hour_settings['currently_in_earth_hour'] ) {
			$earth_hour_settings['currently_in_earth_hour'] = false;	
			earth_hour_update_settings();
		}

		wp_enqueue_script( 'jquery' );		
	}

}
