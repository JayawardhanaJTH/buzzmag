<?php
/*
Template Name: Latest Posts Page
Template Post Type: page
*/

get_header();

?>

<div class="fl-container clearfix">
	<div class="fl-box">
		<div class="head">
		    <h1 class="title"><?php the_title(); ?></h1>
		</div>
		<?php
			if ( has_excerpt() ) {
				echo '<div class="info">';
					the_excerpt();
			    echo '</div>';
		    }
	    ?>
	</div>

</div>
	
<div class="fl-container clearfix">
	<div id="fl-post-container" class="<?php echo esc_attr( buzzmag_layout_settings()['width_class'] ); ?>">

		<article class="fl-article">
			<div class="fl-post-content template clearfix">
				<?php the_content(); ?>
			</div>
		</article>

		<?php
		echo '<div class="'. esc_attr( buzzmag_layout_settings()['loop_class'] ) .'">';

			// latest Posts
			echo '<div id="fl-latest-posts" class="fl-loop-section">';
			    echo buzzmag_latest_loop(1, buzzmag_layout_settings()['thumb_size']);
			echo '</div>';

		echo '</div>';
		?>
	</div>
	<?php if ( buzzmag_layout_settings()['sidebar'] == true ) { get_sidebar(); } ?>
</div>

<?php get_footer(); ?>