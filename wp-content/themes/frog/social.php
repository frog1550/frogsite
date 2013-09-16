<div class="entry-social cf">
	<div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="90"></div>
	<div class="tw-tweet">
		<?php $username = substr(strrchr(get_theme_mod('twitter'), '/'), 1); ?>
		<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-text="<?php the_title(); ?>" data-via="<?php echo $username; ?>" data-related="<?php echo $username; ?>">Tweet</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</div>
</div>