<?php if ( !get_theme_mod( 'hide_related_box' ) ) {

	if ( get_theme_mod( 'related_type' ) == 'category' ) {
		$relates = get_the_category($post->ID);
	} else {
		$relates = wp_get_post_tags($post->ID);
	}

	if ( !empty($relates) ) {

		$IDs = array();

		foreach ( $relates as $relate ) {
			$IDs[] = $relate->term_id;
		}

		$args = array(
			'post__not_in'        => array($post->ID),
			'posts_per_page'      => 6,
			'ignore_sticky_posts' => 1,
		);

		if ( get_theme_mod( 'related_type' ) == 'category' ) {
			$args = array_merge( $args, array('category__in' => $IDs) );
		} else {
			$args = array_merge($args, array('tag__in' => $IDs) );
		}
	
		$loop = new wp_query( $args );

		if ( $loop->have_posts() ) { ?>
			<div class="fl-related alignwide">
				<h3><?php esc_html_e( 'You might also like', 'buzzmag' ); ?></h3>
				<div class="fl-grid col-3">
					<div class="fl-loop-section">
						<?php
						while( $loop->have_posts() ) {
							$loop->the_post(); ?>
							<article class="fl-post">
								<div class="fl-picture">
						            <a href="<?php the_permalink(); ?>">
						                <?php if ( has_post_thumbnail() ) {
							                the_post_thumbnail('buzzmag_medium');
							            } else {
							            	echo '<img src="'. fl_theme_path . '/img/buzzmag_medium.png">';
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
	}
} ?>