<?php global $earth_hour_settings; ?>

<div class="wrap" id="earth_hour">
<div class="metabox-holder" id="earth-hour-head">
	<div class="postbox">
		<div id="earth-hour-head-colour">
			<div id="earth-hour-head-title">
				<?php Earth_Hour(); ?>
				<img class="ajax-load" src="<?php echo compat_get_plugin_url('earth-hour'); ?>/images/admin-ajax-loader.gif" alt="ajax"/>
			</div>
				<div id="earth-hour-head-links">
					<ul>
						<li><?php echo sprintf(__( "%sEarth Hour Homepage%s", "earth-hour" ), '<a href="http://www.bravenewcode.com/earth-hour" target="_blank">','</a>'); ?> | </li>
						<li><?php echo sprintf(__( "%sNewsletter%s", "wordtwit" ), '<a href="http://www.bravenewcode.com/newsletter" target="_blank">','</a>'); ?> | </li>
						<li><?php echo sprintf(__( "%sDonate%s", "earth-hour" ), '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&amp;business=paypal%40bravenewcode%2ecom&amp;item_name=earth-hour%20Beer%20Fund&amp;no_shipping=1&amp;tax=0&amp;currency_code=CAD&amp;lc=CA&amp;bn=PP%2dDonationsBF&amp;charset=UTF%2d8" target="_blank">','</a>'); ?></li>
					</ul>
				</div>
	<div class="bnc-clearer"></div>
			</div>	
	
		<div id="earth-hour-news-support">

			<div id="earth-hour-news-wrap">
			<h3><span class="rss-head">&nbsp;</span><?php _e( "EarthHour.org Wire", "earth-hour" ); ?></h3>
				<div id="earth-hour-news-content" style="display:none">

				</div>
			</div>

			<div id="earth-hour-support-wrap">			
			<h3><span class="rss-head">&nbsp;</span><?php _e( "Twitter Topics", "earth-hour" ); ?></h3>
				<div id="earth-hour-support-content" style="display:none">

				</div>
			</div>
			
		</div><!-- earth-hour-news-support -->

	<div class="bnc-clearer"></div>
	</div><!-- postbox -->
</div><!-- earth-hour-head -->
	<?php echo sprintf( __( "There are currently %d WordPress sites using this plugin and supporting Earth Hour.", "earth-hour" ), number_format( $earth_hour_settings['last_count'] ) ); ?>

</div><!-- wrap earth-hour -->