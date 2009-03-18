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

if ( defined('ABSPATH') ) {
	require_once( ABSPATH . '/wp-includes/class-snoopy.php');
} else {
	require_once( '../../../wp-includes/class-snoopy.php');
}


global $earth_hour_settings;
$earth_hour_default_settings = array(
	'currently_in_earth_hour' => false,
	'last_count' => 0,
	'last_count_time' => 0
);

function earth_hour_activate() {
   $snoopy = new Snoopy;	
   $snoopy->fetch('http://earthhour.bravenewclients.com/?activate=1&site=' . md5( get_bloginfo('home') ) . '&tz=' . urlencode( get_option('gmt_offset') ) ); 
}

function earth_hour_deactivate() {
   $snoopy = new Snoopy;	
   $snoopy->fetch('http://earthhour.bravenewclients.com/?deactivate=1&site=' . md5( get_bloginfo('home') )  ); 	
}

function earth_hour_is_active() {
	global $earth_hour_settings;
	return ( $earth_hour_settings['currently_in_earth_hour'] );
}

function earth_hour_head() {
	echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"" . get_bloginfo('wpurl') . "/wp-content/plugins/earth-hour/css/earth-hour.css\"></link>";
	echo "<script type=\"text/javascript\" src=\"" . get_bloginfo('wpurl') . "/wp-content/plugins/earth-hour/js/earth-hour.js\"></script>";
}

function earth_hour_footer() {
	global $earth_hour_settings;
	global $time_until_earth_hour;
		
	if ( !earth_hour_is_active() ) {
		echo "<div id=\"bnc_earth_hour\"><div id=\"inner\">";
		$msg = sprintf( __( "One of %s websites proudly supporting <a href=\"http://www.earthhour.org/\" rel=\"nofollow\">Earth Hour</a>. ", "earth-hour" ), number_format( $earth_hour_settings['last_count'] ) );
		$msg = $msg . __( "On WordPress? Get the <a href=\"http://wordpress.org/extend/plugins/earth-hour/\" rel=\"nofollow\">plugin</a>.", "earth-hour" );	
		echo $msg;	
		
		$msg2 = sprintf( __( "<a href=\"http://earthhour.org\" rel=\"nofollow\">Earth Hour</a> begins in %d days, %d hours, and %d minutes", "earth-hour" ), 
			$time_until_earth_hour / (24*3600), 
			($time_until_earth_hour % (24*3600))/3600,
			(($time_until_earth_hour % (24*3600)) % 3600)/60
		);
		echo "</div></div>";
		echo '<script type="text/javascript">var eh_msg_1 = \'' . $msg . '\';var eh_msg_2 = \'' .$msg2 . '\';</script>';

	}	
}

function earth_hour_settings() {
	global $earth_hour_settings;
	
	return $earth_hour_settings;
}

function earth_hour_update_settings() {
	global $earth_hour_settings;
	update_option( 'bnc_earth_hour', serialize( $earth_hour_settings ) );
}

function earth_hour_init() {
	global $earth_hour_settings;
	global $earth_hour_default_settings;
	
	$settings = get_option( unserialize( 'bnc_earth_hour' ) );
	if ( $settings) {
		$earth_hour_settings = $settings;
	} else {
		$earth_hour_settings = $earth_hour_default_settings;
	}
	
	$now_time = time();	
	$time_since_last_update = $now_time - $earth_hour_settings['last_count_time'];
	
	if ( $time_since_last_update > 300 ) {
   	$snoopy = new Snoopy;	
   	if ( $snoopy->fetch('http://earthhour.bravenewclients.com/?count=1') ) {	
   		$earth_hour_settings['last_count'] = $snoopy->results;
   		$earth_hour_settings['last_count_time'] = time();
   	}
	}
	
	$start_time = mktime( 20, 30, 0, 3, 28, 2009 );
	$end_time = $start_time + 60*60;
	
	// adjust for local time
	$adjusted_time = time() + get_option('gmt_offset')*60*60;	
	$in_earth_hour = ($adjusted_time >= $start_time && $adjusted_time <= $end_time);
	
	global $time_until_earth_hour;
	$time_until_earth_hour = $start_time - $adjusted_time;

	if ( $in_earth_hour ) {
		// we are in earth hour
		if ( !$earth_hour_settings['currently_in_earth_hour'] ) {
			$earth_hour_settings['currently_in_earth_hour'] = true;	
			earth_hour_update_settings();
		}		
		
		// let people hit the admin panel
		if ( strpos( $_SERVER["REQUEST_URI"], "/wp-admin/" ) === false && strpos( $_SERVER["REQUEST_URI"], "wp-login.php" ) === false ) {
			include( 'html/message.php' );
			die;
		}
	} else {
		// we are not in earth hour
		if ( $earth_hour_settings['currently_in_earth_hour'] ) {
			$earth_hour_settings['currently_in_earth_hour'] = false;	
			earth_hour_update_settings();
		}
	}
	
	wp_enqueue_script( 'jquery' );

}

function earth_hour_options_subpanel() {
	include( 'html/options.php' );
}


function earth_hour_add_plugin_option() {
	if (function_exists('add_options_page')) {
		add_options_page( "Earth Hour", "Earth Hour", 0, basename(__FILE__), 'earth_hour_options_subpanel');
   }
}

add_action( 'admin_menu', 'earth_hour_add_plugin_option');

