<?php

get_header();

// Featured Posts
if ( get_theme_mod('featured_style') != 'none' ) {
	echo '<div id="fl-featured">';
		get_template_part( 'includes/featured-loops/'. get_theme_mod('featured_style', '6posts') );
	echo '</div>';
}

// Home Ad
$home_ad = get_theme_mod( 'home_ad', '<a href="https://themeforest.net/item/buzzmag-viral-news-wordpress-magazineblog-theme/19207752?ref=FlatLayers" target="_blank"><img src="'.fl_theme_path.'/img/ad.jpg" alt="BuzzMag Ad"></a>' );
if ( $home_ad ) { ?>
    <div class="fl-ad fl-container clearfix">
        <span class="adtitle"><?php esc_html_e( '&ndash; Advertisement &ndash;', 'buzzmag' ); ?></span>
        <?php echo wp_kses_post($home_ad); ?>
    </div>
<?php } ?>

<div id="fl-content">
	<div class="fl-container clearfix">
		<div id="fl-post-container" class="<?php echo esc_attr( buzzmag_layout_settings()['width_class'] ); ?>">
			<?php
			// Loop Tabs
			get_template_part( 'includes/loop-tabs' );
			
			echo '<div class="'. esc_attr( buzzmag_layout_settings()['loop_class'] ) .'">';

				// latest Posts
				echo '<div id="fl-latest-posts" class="fl-loop-section ajax-loaded">';
				    echo buzzmag_default_loop(false, 1, buzzmag_layout_settings()['thumb_size']);
				echo '</div>';

				// Trending Posts
				if ( !get_theme_mod('hide_trending') ) {
					echo '<div id="fl-trending-posts" class="fl-loop-section">';
					// Ajax Call
					echo '</div>';
				}

				// Audio Posts
				if ( !get_theme_mod('hide_audio') ) {
					echo '<div id="fl-audio-posts" class="fl-loop-section">';
					// Ajax Call
					echo '</div>';
				}

				// Video Posts
				if ( !get_theme_mod('hide_video') ) {
					echo '<div id="fl-video-posts" class="fl-loop-section"></div>';
				}

				// Gallery Posts
				if ( !get_theme_mod('hide_gallery') ) {
					echo '<div id="fl-gallery-posts" class="fl-loop-section"></div>';
				}

			echo '</div>';
			?>
		</div>
		<?php if ( buzzmag_layout_settings()['sidebar'] == true ) { get_sidebar(); } ?>
	</div>
</div>

<?php get_footer(); ?>