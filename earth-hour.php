<?php
/*
Plugin Name: Earth Hour
Plugin URI: http://www.bravenewcode.com/earth-hour/
Description: Changing the world, one website at a time.
Author: Dale Mugford and Duane Storey
Version: 1.3
Author URI: http://www.bravenewcode.com
Text Domain: earth-hour
*/

require( 'compat.php' );

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

global $bnc_earth_hour_version;
$bnc_earth_hour_version = '1.3';

	function Earth_Hour($before = '', $after = '') {
		global $bnc_earth_hour_version;
		echo $before . 'WPtouch ' . $bnc_earth_hour_version . $after;
	}

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
	$on_iphone = false;
	if ( function_exists( 'bnc_is_iphone' ) ) {
		$on_iphone = bnc_is_iphone();
	}

	if ( !$on_iphone ) {
		echo "<link rel='stylesheet' type='text/css' media='screen' href='" . WP_PLUGIN_URL . "/earth-hour/css/earth-hour.css'></link>";
		echo "<script type='text/javascript' src='" . WP_PLUGIN_URL . "/earth-hour/js/earth-hour.js'></script>";
	}
	
}

function earth_hour_footer() {
	global $earth_hour_settings;
	global $time_until_earth_hour;

	$on_iphone = false;
	if ( function_exists( 'bnc_is_iphone' ) ) {
		$on_iphone = bnc_is_iphone();
	}
		
	if ( $time_until_earth_hour > 0 ) {
		if ( !earth_hour_is_active() && !$on_iphone ) {
			echo "<div id=\"bnc_earth_hour\">";
			echo "<a id=\"banner\" href=\"http://www.earthhour.org\" rel=\"nofollow\">";
			echo __( "Visit the Earth Hour Website", "earth-hour" );
			echo "</a><div id=\"inner\">";
			$msg = sprintf( 
				__ngettext( 
					"One of %s website proudly supporting <a href=\"http://www.bravenewcode.com/products/earth-hour/\" rel=\"nofollow\">Earth Hour</a>. ", 
					"One of %s websites proudly supporting <a href=\"http://www.bravenewcode.com/products/earth-hour/\" rel=\"nofollow\">Earth Hour</a>. ",
					$earth_hour_settings['last_count'],
					"earth-hour"
				),
				number_format( $earth_hour_settings['last_count'] ) 
			);
			$msg = $msg . __( "On WordPress? Get the <a href=\"http://wordpress.org/extend/plugins/earth-hour/\" rel=\"nofollow\">plugin</a>.", "earth-hour" );	
			echo $msg;	
			
			$days = sprintf( __ngettext( "%d day", "%d days", $time_until_earth_hour / (24*3600), "earth-hour" ),  $time_until_earth_hour / (24*3600) );
			$hours = sprintf( __ngettext( "%d hour", "%d hours", ($time_until_earth_hour % (24*3600))/3600, "earth-hour" ),  ($time_until_earth_hour % (24*3600))/3600 );
			$mins = sprintf( __ngettext( "%d minute", "%d minutes", (($time_until_earth_hour % (24*3600)) % 3600)/60, "earth-hour" ), (($time_until_earth_hour % (24*3600)) % 3600)/60 );
			$msg2 = sprintf( __( "<a href=\"http://www.bravenewcode.com/earth-hour/\" rel=\"nofollow\">Earth Hour</a> begins in %1\$s, %2\$s, and %3\$s", "earth-hour" ), 
				$days, $hours, $mins
			);
			echo "</div></div>";
			echo '<script type="text/javascript">var eh_msg_1 = \'' . $msg . '\';var eh_msg_2 = \'' .$msg2 . '\';</script>';
		}	
	}
}

function earth_hour_update_settings() {
	global $earth_hour_settings;
	update_option( 'bnc_earth_hour', serialize( $earth_hour_settings ) );
}

function earth_hour_init() {
	global $earth_hour_settings;
	global $earth_hour_default_settings;
	
	$current_locale = get_locale();
	if( !empty( $current_locale ) ) {
		$moFile = dirname(__FILE__) . "/lang/earth-hour-" . $current_locale . ".mo";
		if(@file_exists($moFile) && is_readable($moFile)) load_textdomain( 'earth-hour' , $moFile );
	}
	
	$settings = get_option( unserialize( 'bnc_earth_hour' ) );
	if ( $settings) {
		$earth_hour_settings = $settings;
	} else {
		$earth_hour_settings = $earth_hour_default_settings;
	}
	
	$now_time = time();	
	$time_since_last_update = $now_time - $earth_hour_settings['last_count_time'];
	
	if ( $time_since_last_update > (60*60) ) {
   	$snoopy = new Snoopy;	
   	if ( $snoopy->fetch('http://earthhour.bravenewclients.com/?count=1') ) {	
   		$earth_hour_settings['last_count'] = $snoopy->results;
   		$earth_hour_settings['last_count_time'] = time();
   		
   		earth_hour_update_settings();
   	}
	}
	
	$start_time = gmmktime( 20, 30, 0, 3, 27, 2010 );
	$end_time = $start_time + 60*60;
	
	// adjust for local time
	$adjusted_time = time() + get_option('gmt_offset')*60*60;	
	$in_earth_hour = ( $adjusted_time >= $start_time && $adjusted_time <= $end_time );
	
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
			global $earth_hour_minutes;
			$earth_hour_minutes = ($end_time - $adjusted_time)/60;
			
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
       
	$on_iphone = false;
	if ( function_exists( 'bnc_is_iphone' ) ) {
		$on_iphone = bnc_is_iphone();
	}

	if ( !$on_iphone ) {	
		wp_enqueue_script( 'jquery' );
	}
}

function earth_hour_options_subpanel() {
	include( 'html/options.php' );
}

function earth_hour_add_plugin_option() {
	if ( function_exists('add_options_page') ) {
		add_options_page( "Earth Hour", "Earth Hour", 0, basename(__FILE__), 'earth_hour_options_subpanel');
   }
}

//Add a link to settings on the plugin listings page
function earth_hour_settings_link( $links, $file ) {
 	if( $file == 'earth-hour/earth-hour.php' && function_exists( "admin_url" ) ) {
		$settings_link = '<a href="' . admin_url( 'options-general.php?page=earth-hour.php' ) . '">' . __('Settings') . '</a>';
		array_unshift( $links, $settings_link ); // before other links
	}
	return $links;
}

add_action( 'admin_menu', 'earth_hour_add_plugin_option');
add_filter( 'plugin_action_links', 'earth_hour_settings_link', 9, 2 );