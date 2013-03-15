<?php
/*
Plugin Name: Earth Hour
Plugin URI: http://www.bravenewcode.com/free-stuff/
Description: Proudly show your support for Earth Hour with a banner countdown to the event and "turning off" your site during the hour.
Author: BraveNewCode Inc.
Version: 1.7
Author URI: http://www.bravenewcode.com
Text Domain: earth-hour
*/

define( 'EARTH_HOUR_VERSION', '1.7' );

require( 'compat.php' );

add_action( 'init', 'earth_hour_init' );
add_action( 'wp_head', 'earth_hour_head' );
add_action( 'wp_footer', 'earth_hour_footer' );
add_action( 'admin_init', 'earth_hour_admin_init' );

register_activation_hook( __FILE__, 'earth_hour_activate' );
register_deactivation_hook( __FILE__, 'earth_hour_deactivate' );

if ( defined('ABSPATH') ) {
	require_once( ABSPATH . '/wp-includes/class-snoopy.php');
} else {
	require_once( dirname( __FILE__ ) . '/../../../wp-includes/class-snoopy.php');
}

global $earth_hour_settings;
$earth_hour_settings = false;

$earth_hour_default_settings = array(
	'currently_in_earth_hour' => false,
	'last_count' => 0,
	'last_count_time' => 0,
	'banner_location' => 'top',
	'main_image' => 'official',
	'custom_image' => '',
	'earth_hour_text' => '' . get_bloginfo('title') . ' is proudly participating in Earth Hour 2013.',
	'earth_hour_version' => 0.0,
	'earth_hour_excluded_paths' => ''
);

function earth_hour_get_settings() {
	global $earth_hour_settings;
	global $earth_hour_default_settings;
	
	// Return the settings if they already exist
	if ( $earth_hour_settings ) {
		return $earth_hour_settings;
	}
	
	$saved_settings = get_option( 'bnc_earth_hour', false );
	if ( !is_array( $saved_settings ) ) {
		$saved_settings = unserialize( $saved_settings );	
	}
	
	if ( $saved_settings ) {
		// Settings exist, let's add recently added default settings
		foreach( $earth_hour_default_settings as $key => $value ) {
			if ( !isset( $saved_settings[$key] ) ) {
				$saved_settings[$key] = $value;	
			}	
		}
		
		// Save our local cached copy
		$earth_hour_settings = $saved_settings;
		
		return $saved_settings;
	} else {
		// No settings exist, so just return the defaults
		return $earth_hour_default_settings;
	}
}

function earth_hour_save_settings( $new_settings ) {
	global $earth_hour_settings;	
	
	update_option( 'bnc_earth_hour', $new_settings );	
	$earth_hour_settings = $new_settings;
}

global $bnc_earth_hour_version;
$bnc_earth_hour_version = EARTH_HOUR_VERSION;

function earth_hour_version($before = '', $after = '') {
	global $bnc_earth_hour_version;
	echo $before . 'Earth Hour ' . $bnc_earth_hour_version . $after;
}
	
// WP Admin stylesheets & javascript
function earth_hour_admin_files() {		
	if ( isset( $_GET['page'] ) && $_GET['page'] == 'earth-hour.php' ) {
		echo "<link rel='stylesheet' type='text/css' href='" . compat_get_plugin_url( 'earth-hour' ) . "/css/earth-hour-admin.css' />\n";
	}
}

function earth_hour_activate() {
   $snoopy = new Snoopy;
   $snoopy->read_timeout = 5;	
   $snoopy->fetch( 'http://earthhour.bravenewclients.com/?activate=1&site=' . md5( get_bloginfo('home') ) . '&tz=' . urlencode( get_option('gmt_offset') ) ); 
}

function earth_hour_deactivate() {
   $snoopy = new Snoopy;	
   $snoopy->read_timeout = 5;
   $snoopy->fetch( 'http://earthhour.bravenewclients.com/?deactivate=1&site=' . md5( get_bloginfo('home') )  ); 
}

function earth_hour_is_active() {
	global $earth_hour_settings;
	return ( $earth_hour_settings['currently_in_earth_hour'] );
}

function earth_hour_head() {	
	global $earth_hour_settings;
	global $time_until_earth_hour;

	$on_iphone = false;
	if ( function_exists( 'bnc_is_iphone' ) ) {
		$on_iphone = bnc_is_iphone();
	}

	if ( $time_until_earth_hour > 0 ) {
		if ( !earth_hour_is_active() && !$on_iphone ) {
			echo "<link rel='stylesheet' type='text/css' media='screen' href='" . WP_PLUGIN_URL . "/earth-hour/css/earth-hour-banner.css'></link>\n";
			echo "<link rel='stylesheet' type='text/css' media='screen' href='" . get_bloginfo("home") . "/?earth_hour_dynamic_css=1'></link>\n";
			echo "<script type='text/javascript' src='" . WP_PLUGIN_URL . "/earth-hour/js/earth-hour.js'></script>";
		}
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
					"One of %s website proudly supporting <a href=\"http://www.earthhour.org/\" rel=\"nofollow\">Earth Hour</a>. ", 
					"One of %s websites proudly supporting <a href=\"http://www.earthhour.org/\" rel=\"nofollow\">Earth Hour</a>. ",
					$earth_hour_settings['last_count'],
					"earth-hour"
				),
				number_format( $earth_hour_settings['last_count'] ) 
			);
			$msg = $msg . '&nbsp; &nbsp;' . __( "Use WordPress? Get the <a href=\"http://wordpress.org/extend/plugins/earth-hour/\" rel=\"nofollow\">plugin</a>.", "earth-hour" );	
			echo $msg;	
			
			$days = sprintf( __ngettext( "%d day", "%d days", $time_until_earth_hour / (24*3600), "earth-hour" ),  $time_until_earth_hour / (24*3600) );
			$hours = sprintf( __ngettext( "%d hour", "%d hours", ($time_until_earth_hour % (24*3600))/3600, "earth-hour" ),  ($time_until_earth_hour % (24*3600))/3600 );
			$mins = sprintf( __ngettext( "%d minute", "%d minutes", (($time_until_earth_hour % (24*3600)) % 3600)/60, "earth-hour" ), (($time_until_earth_hour % (24*3600)) % 3600)/60 );
			$msg2 = sprintf( __( "<a href=\"http://www.earthhour.org/\" rel=\"nofollow\">Earth Hour</a> begins in %1\$s, %2\$s, and %3\$s", "earth-hour" ), 
				$days, $hours, $mins
			);
			echo "</div></div>";
			echo '<script type="text/javascript">var eh_msg_1 = \'' . $msg . '\';var eh_msg_2 = \'' .$msg2 . '\';</script>';
		}	
	}
}

function bnc_earth_hour_is_valid_path() {
	$valid_path = true;
	
	$settings = earth_hour_get_settings();
	$paths = $settings[ 'earth_hour_excluded_paths' ];	
	if ( $paths ) {
		$proper_paths = apply_filters( 'bnc_earth_hour_excluded_paths', explode( "\n", rtrim( $paths ) ) );
		if ( $proper_paths && is_array( $proper_paths ) && count( $proper_paths ) ) {
			// Make sure the path is valid
			foreach( $proper_paths as $one_path ) {
				if ( stripos( $_SERVER['REQUEST_URI'], trim( $one_path ) ) !== false ) {
					$valid_path = false;
				}
				
				if ( !$valid_path ) {
					break;
				}	
			}
		}
	}
	
	return $valid_path;
}

function earth_hour_init() {	
	$settings = earth_hour_get_settings();	
	
	if ( !isset( $settings['earth_hour_version'] ) || $settings['earth_hour_version'] != EARTH_HOUR_VERSION ) {
		$settings['earth_hour_version'] = EARTH_HOUR_VERSION;
		
		earth_hour_save_settings( $settings );
		earth_hour_activate();
	}
	
	// Output Dynamic CSS
	if ( isset( $_GET['earth_hour_dynamic_css'] ) ) {
		header( "Content-type: text/css" );
		
		switch( $settings['banner_location'] ) {
			case 'top':
				echo "body{top: 20px} \n #bnc_earth_hour { position: fixed; top: 0px; right: 0px; -webkit-box-shadow: 0px 4px 8px #333; border-bottom: 1px solid #57565f; } \n";
				break;
			case 'bottom':
				echo "body{margin-bottom: 20px} \n #bnc_earth_hour { position: fixed; bottom: 0px; right: 0px; border-top: 1px solid #57565f; }\n";
				break;
			case 'off':
				echo "#bnc_earth_hour { display:none }\n";
				break;
			default:
				break;	
		}
		
		switch( $settings['main_image'] ) {
			case 'official':
				echo "#earth_hour { background-image: url(" . WP_PLUGIN_URL . "/earth-hour/images/wwf-earth-hour.gif); }\n";
				break;
			case 'lightbulbs':
				echo "#earth_hour { background-image: url(" . WP_PLUGIN_URL . "/earth-hour/images/bnc-earth-hour.gif); }\n";
				break;
			case 'custom':
				echo "#earth_hour { background-image: url(" . $settings['custom_image'] . "); }\n";
				break;	
		}
		
		die;
	}
	
	$current_locale = get_locale();
	if( !empty( $current_locale ) ) {
		$moFile = dirname(__FILE__) . "/lang/earth-hour-" . $current_locale . ".mo";
		if (@file_exists($moFile) && is_readable($moFile)) load_textdomain( 'earth-hour' , $moFile );
	}

	$now_time = time();	
	$time_since_last_update = $now_time - $earth_hour_settings['last_count_time'];
	// check the site count everyday
	if ( $time_since_last_update > (24*60*60) ) {
	   	$snoopy = new Snoopy;	
	   	$snoopy->read_timeout = 5;
	   	if ( $snoopy->fetch( 'http://earthhour.bravenewclients.com/?count=1') ) {	
	   		$settings['last_count'] = $snoopy->results;
	   		$settings['last_count_time'] = time();
	   		
	   		earth_hour_save_settings( $settings );
	   	}
	}
	
	$start_time = gmmktime( 20, 30, 0, 3, 23, 2013 );
	$end_time = $start_time + 60*60;
	
	// adjust for local time
	$adjusted_time = time() + get_option('gmt_offset')*60*60;	
	$in_earth_hour = ( $adjusted_time >= $start_time && $adjusted_time <= $end_time );
	
	// Force earth hour if the user clicked the preview button
	if ( isset( $_GET['earth_hour_preview'] ) ) {
		$in_earth_hour = true;	
	}
	
	// Make sure this is a valid path
	$in_earth_hour = $in_earth_hour && bnc_earth_hour_is_valid_path();
	
	// Filter added in version 1.6.1 in case other people want to force Earth Hour off via a hook
	$in_earth_hour = apply_filters( 'bnc_earth_hour_activate', $in_earth_hour );
		
	global $time_until_earth_hour;
	$time_until_earth_hour = $start_time - $adjusted_time;

	if ( $in_earth_hour ) {
		// we are in earth hour
		if ( !$settings['currently_in_earth_hour'] ) {
			$settings['currently_in_earth_hour'] = true;	
			earth_hour_save_settings( $settings );
		}		
		
		// let people hit the admin panel
		if ( strpos( $_SERVER["REQUEST_URI"], "/wp-admin/" ) === false && strpos( $_SERVER["REQUEST_URI"], "wp-login.php" ) === false ) {
			global $earth_hour_minutes;
			$earth_hour_minutes = ($end_time - $adjusted_time)/60;

			header( 'HTTP/1.1 503 Service Temporarily Unavailable' );
			header( 'Status: 503 Service Temporarily Unavailable' );
			header( 'Retry-After: 3600');	

			include( 'html/message.php' );
			die;
		}
	} else {
		// we are not in earth hour
		if ( $settings['currently_in_earth_hour'] ) {
			$settings['currently_in_earth_hour'] = false;	
			earth_hour_save_settings( $settings );
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

function earth_hour_settings_link( $links, $file ) {
 	if( $file == 'earth-hour/earth-hour.php' && function_exists( "admin_url" ) ) {
		$settings_link = '<a href="' . admin_url( 'options-general.php?page=earth-hour.php' ) . '">' . __('Settings') . '</a>';
		array_push( $links, $settings_link ); // after other links
	}
	return $links;
}

function earth_hour_admin_init() {
	if ( isset( $_POST['preview'] ) ) {
		header( 'Location: ' . get_bloginfo('home') . '?earth_hour_preview=1' );
		die;
	}
	
	if ( isset( $_POST['submit'] ) ) {
		$settings = earth_hour_get_settings();
		
		foreach( $settings as $key => $value ) {
			if ( isset( $_POST[$key] ) ) {
				$settings[$key] = $_POST[$key];	
			}
		}
		
		earth_hour_save_settings( $settings );
		
	} elseif ( isset( $_POST['reset'] ) ) {
		global $earth_hour_default_settings;
		earth_hour_save_settings( $earth_hour_default_settings );
	}	
}

add_action( 'admin_menu', 'earth_hour_add_plugin_option' );
add_action( 'admin_head', 'earth_hour_admin_files' );
add_filter( 'plugin_action_links', 'earth_hour_settings_link', 9, 2 );
