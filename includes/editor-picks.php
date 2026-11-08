<?php if ( !get_theme_mod('hide_editorpicks_box') ) {

    // Cats Slugs
	$editor_cats = get_theme_mod('editor_cats');
	$cats = str_replace(' ', '', $editor_cats);
	$array_cats = explode(',',$cats);

	$loop = new WP_Query(
	    array (
	        'post_type'           => 'post',  
	        'post_status'         => 'publish',
	        'tax_query'           => array(
	            array(
	                'taxonomy' => 'category',
	                'field'    => 'slug',
	                'terms'    => $array_cats //Cats
	            )
	        ),
	        'post__not_in'        => array($post->ID),
	        'posts_per_page'      => 6,
	        'ignore_sticky_posts' => 1,
	    )
	);

    if ( $loop->have_posts() ) { ?>
		<div class="fl-related picks alignwide">
			<h3><?php esc_html_e( 'Editor Picks', 'buzzmag' ); ?></h3>
			<div class="fl-list">
				<div class="fl-loop-section">
					<?php
					while( $loop->have_posts() ) {
						$loop->the_post(); ?>
							<article class="fl-post">
								<div class="fl-picture">
						            <a href="<?php the_permalink(); ?>">
						                <?php if ( has_post_thumbnail() ) {
							                the_post_thumbnail('buzzmag_small');
							            } else {
							            	echo '<img src="'. fl_theme_path . '/img/buzzmag_small.png">';
							            }

							            if ( has_post_format( 'audio' ) ) {
							                echo '<div class="format-overlay"><i class="fa fa-music"></i></div>';
							            } elseif ( has_post_format( 'video' ) ) {
							                echo '<div class="format-overlay"><i class="fa fa-play"></i></div>';
							            } elseif ( has_post_format( 'gallery' ) ) {
							                echo '<div class="format-overlay"><i class="fa fa-camera"></i></div>';
							            }

						                echo esc_html( get_the_title() );
						                ?>
						            </a>
						        </div>
						        <div class="content">
									<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

									<span class="fl-meta category"><?php echo the_category(' / '); ?></span>

					                <?php if ( !get_theme_mod( 'hide_meta_date' ) ) { ?>
						                <span class="fl-meta"><i class="fa fa-clock-o"></i><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . esc_html__( ' ago', 'buzzmag' ); ?></span>
						            <?php } ?>
						        </div>
							</article>
					<?php }
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
	wp_reset_postdata();
} ?>