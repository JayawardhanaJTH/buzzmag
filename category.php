<?php get_header(); ?>

<div class="fl-container clearfix">
	<div class="fl-box">
		<div class="head">
		    <h1 class="title"><?php single_cat_title('',true); ?></h1>
		</div>
		<?php
		    $term = get_queried_object();
			$subCats = get_terms( $term->taxonomy, array(
				'parent' => $term->term_id,
			) );
			
			if ($subCats) {
				echo '<div class="fl-category">';
					foreach ($subCats as $cat) {
                        echo '<a class="cat-link" href="'. get_category_link($cat->term_id) .'">'. $cat->name .'</a>';
                    }
                echo '</div>';
			}

			if ( category_description() ) {
				echo '<div class="info">';
					echo category_description();
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