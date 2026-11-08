<?php get_header(); ?>

<div class="fl-container clearfix">
	<div class="fl-box">
		<div class="head">			
		    <span class="fl-meta"><?php esc_html_e( 'Browsing Tag', 'buzzmag' ); ?></span>
		    <h1 class="title"><?php single_tag_title('',true); ?></h1>
		</div>
		<?php
			if ( tag_description() ) {
				echo '<div class="info">';
					echo tag_description();
			    echo '</div>';
		    }
	    ?>
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