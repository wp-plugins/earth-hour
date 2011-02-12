<?php $settings = earth_hour_get_settings();  ?>

<div class="wrap" id="bnc-global">
<?php if (isset($_POST['submit'])) {
		echo('<div id="message" class="updated fade"><p><strong>');
		echo __( "Settings saved", "earth-hour");
		echo('</strong></p></div>');
		} 
	elseif (isset($_POST['reset'])) {
		echo('<div id="message" class="updated fade"><p><strong>');
		echo __( "Defaults restored", "earth-hour");
		echo('</strong></p></div>');
		} 
?>
<div class="metabox-holder" id="earth-hour-head">
	<div class="postbox">
		<div id="earth-hour-head-colour">
			<div id="earth-hour-head-title">
				<?php earth_hour_version(); ?>
				<p><?php 	global $earth_hour_settings; $count = number_format( $earth_hour_settings['last_count'] ); echo sprintf( __ngettext( "There is currently %d other WordPress site supporting this cause.",  "There are currently %d other WordPress sites supporting this cause.", $count, "earth-hour"), $count); ?></p>
			</div>
				<div id="earth-hour-head-links">
					<ul>
						<li><?php echo sprintf(__( "%sEarthHour.org%s", "earth-hour" ), '<a href="http://www.earthhour.org" target="_blank">','</a>'); ?> | </li>
						<li><?php echo sprintf(__( "%sBNC Earth Hour Page%s", "earth-hour" ), '<a href="http://www.bravenewcode.com/free-stuff/" target="_blank">','</a>'); ?> | </li>
						<li><?php echo sprintf(__( "%sSupport Forums%s", "earth-hour" ), '<a href="http://www.bravenewcode.com/support/" target="_blank">','</a>'); ?></li>
					</ul>
				</div>
			<div class="bnc-clearer"></div>
		</div>	
	
		<div id="earth-hour-news-twitter">

			<div id="earth-hour-news-wrap">
			<h3><span class="rss-head">&nbsp;</span><?php _e( "BraveNewCode Environmental Entries", "earth-hour" ); ?></h3>
				<div id="earth-hour-blog-content">
					<?php require_once (ABSPATH . WPINC . '/rss.php');
					$rss = @fetch_rss('http://www.bravenewcode.com/tag/environment/rss/');
					//$rss = @fetch_rss('http://earthhourblog.posterous.com/rss.xml');						
					if ( isset($rss->items) && 0 != count($rss->items) ) { ?>
					<ul>
						<?php $rss->items = array_slice($rss->items, 0, 5); foreach ($rss->items as $item ) { ?>
						<li><a target="_blank" class="orange-link" href='<?php echo wp_filter_kses($item['link']); ?>'><?php echo wp_specialchars($item['title']); ?></a></li>
						<?php } ?>
					</ul>
					<?php } ?>
				</div>
			</div>

			<div id="earth-hour-twitter-wrap">			
			<h3><span class="rss-head">&nbsp;</span><?php _e( "EarthHour.org Official Twitter Feed", "earth-hour" ); ?></h3>
				<div id="earth-hour-twitter-content">
					<?php require_once (ABSPATH . WPINC . '/rss.php');
					$rss = @fetch_rss('http://twitter.com/statuses/user_timeline/12626962.rss');						
					if ( isset($rss->items) && 0 != count($rss->items) ) { ?>
					<ul>
						<?php $rss->items = array_slice($rss->items, 0, 3); foreach ($rss->items as $item ) { ?>
						<li><a target="_blank" class="orange-link" href='<?php echo wp_filter_kses($item['link']); ?>'><?php echo wp_specialchars($item['title']); ?></a></li>
						<?php } ?>
					</ul>
					<?php } ?>
				</div>
			</div>
			
		</div><!-- earth-hour-news-twitter -->
	
	<div class="bnc-clearer"></div>
	</div><!-- postbox -->

</div><!-- earth-hour-head -->

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

<!-- Earth Hour Settings Pane -->
<div class="metabox-holder">
	<div class="postbox">
		<h3><span class="global-settings">&nbsp;</span><?php _e( "General Settings", "earth-hour" ); ?></h3>

			<div class="left-content">
				<h4><?php _e( "Banner Placement", "earth-hour" ); ?></h4>
				<p><?php _e( "Before Earth Hour begins, your site shows a banner in a fixed position showing your support for the event.", "earth-hour" ); ?></p>
				<p><?php _e( "Choose whether the banner is shown at the top or bottom of your website.", "earth-hour" ); ?></p>

				<br /><br />

				<h4><?php _e( "Earth Hour Image", "earth-hour" ); ?></h4>
				<p><?php _e( "During Earth Hour all website URLs will show a page with the image you choose and the text you include in the option below.", "earth-hour" ); ?></p>
				<p><?php _e( "Choose between the two provided images, or link to one of your own.", "earth-hour" ); ?></p>
				<p><?php _e( "Our images are 300px by 300px, and we suggest you keep yours at around the same size to work correctly.", "earth-hour" ); ?></p>
				
				<br /><br />

				<h4><?php _e( "Earth Hour Text", "earth-hour" ); ?></h4>
				<p><?php _e( "Along with the image your site displays a message to all your visitors. Edit that message here.", "earth-hour" ); ?></p>

				<br /><br />

				<h4><?php _e( "Preview Site", "earth-hour" ); ?></h4>
				<p><?php _e( "Clicking the Preview button will show you what your site will look like during Earth Hour.", "earth-hour" ); ?></p>
			</div>
			
			<div class="right-content">
				<div id="earth-hour-images">
					<ul>
						<li><h4><?php _e( "Official Earth Hour Image", "earth-hour" ); ?></h4><img src="<?php echo '' . WP_PLUGIN_URL . ''; ?>/earth-hour/images/wwf-earth-hour.gif" alt="official image" /></li>
						<li><h4><?php _e( 'Lightbulbs BNC Image', "earth-hour" ); ?></h4><img src="<?php echo '' . WP_PLUGIN_URL . ''; ?>/earth-hour/images/bnc-earth-hour.gif" alt="BNC image" /></li>
						<!-- <li><h4>Your Custom Image</h4><img src="" alt="custom image" /></li> -->
					</ul>
				</div>
				<p><strong><?php _e( "Banner Placement", "earth-hour" ); ?></strong></p>
				<ul>
					<li><input class="radio" type="radio" name="banner_location" id="website-top" value="top" <?php if ( $settings['banner_location'] == 'top' ) echo 'checked="true" '; ?>/> <label for="website-top"><?php _e( 'Website Top', "earth-hour" ); ?></label></li>
					<li><input class="radio" type="radio" name="banner_location" id="website-bottom" value="bottom" <?php if ( $settings['banner_location'] == 'bottom' ) echo 'checked="true" '; ?>/> <label for="website-bottom"><?php _e( 'Website Bottom', "earth-hour" ); ?></label></li>
				</ul>

				<br /><br /><br /><br />
				
				<p><strong><?php _e( "Earth Hour Image", "earth-hour" ); ?></strong></p>
				<ul>
					<li><input class="radio" type="radio" name="main_image" id="official-image" value="official" <?php if ( $settings['main_image'] == 'official' ) echo 'checked="true" '; ?>/> <label for="official-image"><?php _e( 'Official Earth Hour', "earth-hour" ); ?></label></li>
					<li><input class="radio" type="radio" name="main_image" id="lightbulbs" value="lightbulbs" <?php if ( $settings['main_image'] == 'lightbulbs' ) echo 'checked="true" '; ?>/> <label for="lightbulbs"><?php _e( 'Lightbulbs', "earth-hour" ); ?></label></li>
					<li>
						<input class="radio" type="radio" name="main_image" id="custom-image" value="custom" <?php if ( $settings['main_image'] == 'custom' ) echo 'checked="true" '; ?>/> <label for="custom-image"><?php _e( 'Custom Image URL', "earth-hour" ); ?>:</label><br />
						<input  class="input" type="text" name="custom_image" id="custom-path" value="<?php echo $settings['custom_image']; ?>" />
					</li>
				</ul>

				<br /><br />
				
				<p><strong><?php _e( "Earth Hour Text", "earth-hour" ); ?></strong></p>
				<ul>
					<li><textarea class="textarea" id="earth-hour-text" name="earth_hour_text"><?php echo $settings['earth_hour_text']; ?></textarea></li>
				</ul>
				
				<p><strong><?php _e( "Preview Site", "earth-hour" ); ?></strong> <small>(<?php _e( "Make sure you save before previewing", "earth-hour" ); ?>)</small></p>
				<ul>
					<li><input class="button" type="submit" name="preview" value="<?php _e('Preview Website During Earth Hour', 'earth-hour' ); ?>" /></li>
				</ul>						

			</div>
			
	<div class="bnc-clearer"></div>
	</div><!-- postbox -->
</div><!-- metabox -->

		<input type="submit" name="submit" value="<?php _e('Save Options', 'earth-hour' ); ?>" id="bnc-button" class="button-primary" />
	</form>
	
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<input type="submit" onclick="return confirm('<?php _e('Restore default Earth Hour settings?', 'earth-hour' ); ?>');" name="reset" value="<?php _e('Restore Defaults', 'earth-hour' ); ?>" id="bnc-button-reset" class="button-highlighted" />
	</form>
		
	<?php earth_hour_version('<div class="bnc-plugin-version"> This is ','</div>'); ?>

	<div class="bnc-clearer"></div>

</div><!-- global earth-hour -->
