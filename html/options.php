<?php global $earth_hour_settings; ?>

<div class="wrap" id="bnc-global">
<div class="metabox-holder" id="earth-hour-head">
	<div class="postbox">
		<div id="earth-hour-head-colour">
			<div id="earth-hour-head-title">
				<?php Earth_Hour(); ?>
				<p><?php echo sprintf( __( "There are currently <span>%d</span> WordPress sites using this plugin &amp; supporting Earth Hour.", "earth-hour" ), number_format( $earth_hour_settings['last_count'] ) ); ?>
</p>
			</div>
				<div id="earth-hour-head-links">
					<ul>
						<li><?php echo sprintf(__( "%sBNC Earth Hour Page%s", "earth-hour" ), '<a href="http://www.bravenewcode.com/earth-hour" target="_blank">','</a>'); ?> | </li>
						<!-- <li><?php echo sprintf(__( "%sNewsletter%s", "wordtwit" ), '<a href="http://www.bravenewcode.com/newsletter" target="_blank">','</a>'); ?> | </li> -->
						<li><?php echo sprintf(__( "%sDonate%s", "earth-hour" ), '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&amp;business=paypal%40bravenewcode%2ecom&amp;item_name=earth-hour%20Beer%20Fund&amp;no_shipping=1&amp;tax=0&amp;currency_code=CAD&amp;lc=CA&amp;bn=PP%2dDonationsBF&amp;charset=UTF%2d8" target="_blank">','</a>'); ?></li>
					</ul>
				</div>
	<div class="bnc-clearer"></div>
			</div>	
	
		<div id="earth-hour-news-twitter">

			<div id="earth-hour-news-wrap">
			<h3><span class="rss-head">&nbsp;</span><?php _e( "EarthHour.org Official Blog", "earth-hour" ); ?></h3>
				<div id="earth-hour-blog-content">
					<?php require_once (ABSPATH . WPINC . '/rss.php');
					$rss = @fetch_rss('http://earthhourblog.posterous.com/rss.xml');						
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
			
		</div><!-- earth-hour-news-support -->

	<div class="bnc-clearer"></div>
	</div><!-- postbox -->
</div><!-- earth-hour-head -->

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
				<p><?php _e( "During Earth Hour all links to your site will show this image and the text you choose in the option below.", "earth-hour" ); ?></p>
				<p><?php _e( "Choose between the two provided images, or link to one of your own.", "earth-hour" ); ?></p>
				<p><?php _e( "Our images are 350px x 350px, and we'd recommend you keep yours at a similar size to work correctly.", "earth-hour" ); ?></p>
				
				<br /><br />

				<h4><?php _e( "Earth Hour Text", "earth-hour" ); ?></h4>
				<p><?php _e( "Along with the image above, during Earth Hour your site will display a message to all your visitors. You can edit that message here.", "earth-hour" ); ?></p>

				<br /><br />

				<h4><?php _e( "Preview Site", "earth-hour" ); ?></h4>
				<p><?php _e( "Clicking the Preview button will show you what your site will look like during Earth Hour.", "earth-hour" ); ?></p>
				<p><?php _e( "Only you will see the preview, not your visitors.", "earth-hour" ); ?></p>
			</div>

			<div class="right-content">

				<ul>
					<li><input class="radio" type="radio" name="website-banner" id="website-top" value="website-top" checked="true" /> <label for="website-top">Website Top</label></li>
					<li><input class="radio" type="radio" name="website-banner" id="website-bottom" value="website-bottom" /> <label for="website-bottom">Website Bottom</label></li>
				</ul>

				<ul>
					<li><input class="radio" type="radio" name="image" id="official-image" value="official-image" checked="true" /> <label for="official-image">Official Earth Hour</label></li>
					<li><input class="radio" type="radio" name="image" id="lightbulbs" value="lightbulbs" /> <label for="lightbulbs">Lightbulbs</label></li>
					<li><input class="radio" type="radio" name="image" id="custom-image" value="custom-image" /> <label for="custom-image">Custom</label></li>
				</ul>
			</div>
			
	<div class="bnc-clearer"></div>
	</div><!-- postbox -->
</div><!-- metabox -->

	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<input type="submit" name="submit" value="<?php _e('Save Options', 'earth-hour' ); ?>" id="bnc-button" class="button-primary" />
	</form>
	
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<input type="submit" onclick="return confirm('<?php _e('Restore default Earth Hour settings?', 'earth-hour' ); ?>');" name="reset" value="<?php _e('Restore Defaults', 'earth-hour' ); ?>" id="bnc-button-reset" class="button-highlighted" />
	</form>
		
		<?php echo('' . Earth_Hour('<div class="bnc-plugin-version"> This is ','</div>') . ''); ?>

	<div class="bnc-clearer"></div>

</div><!-- global earth-hour -->