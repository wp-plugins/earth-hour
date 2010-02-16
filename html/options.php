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

</div><!-- global earth-hour -->