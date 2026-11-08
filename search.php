<?php get_header(); ?>

<div class="fl-container clearfix">
	<div class="fl-box">
		<div class="head">
			<?php 
			// Search Count
			global $wp_query;
			$count = isset( $wp_query->found_posts ) ? $wp_query->found_posts : 0;
			?>
		    <span class="fl-meta"><?php echo esc_html($count).' '.esc_html__( 'Search Results for', 'buzzmag' ); ?></span>
		</div>
		<div class="head">
			<h1 class="title"><?php echo esc_html($s); ?></h1>
		</div>
	</div>

</div>
	
<div class="fl-container clearfix">
	<div id="fl-post-container" class="<?php echo esc_attr( buzzmag_layout_settings()['width_class'] ); ?>">
		<?php
		echo '<div class="'. esc_attr( buzzmag_layout_settings()['loop_class'] ) .'">';

			// latest Posts
			echo '<div id="fl-latest-posts" class="fl-loop-section">';
			    echo buzzmag_default_loop(false, 1, buzzmag_layout_settings()['thumb_size']);
			echo '</div>';

		echo '</div>';
		?>
	</div>
	<?php if ( buzzmag_layout_settings()['sidebar'] == true ) { get_sidebar(); } ?>
</div>

<?php get_footer(); ?>