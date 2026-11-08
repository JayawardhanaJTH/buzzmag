<?php get_header(); ?>

<div class="fl-container clearfix">
	<div class="fl-box">
		<div class="avatar">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), 108 ); ?>
		</div>
		<div class="head">
		    <span class="fl-meta"><?php esc_html_e( 'Articles Written By', 'buzzmag' ); ?></span>
		    <h1 class="title"><?php the_author(); ?></h1>
		    <div class="social">
                <?php if ( get_the_author_meta( 'url' ) ) { ?>
                    <a href="<?php the_author_meta( 'url' ); ?>" target="_blank" rel="nofollow">
                        <i class="fa fa-globe"></i>
                    </a>
                <?php }

                if ( get_the_author_meta( 'twitter' ) ) { ?>
                    <a href="<?php the_author_meta( 'twitter' ); ?>" target="_blank" rel="nofollow">
                        <i class="fa fa-twitter"></i>
                    </a>
                <?php }

                if ( get_the_author_meta( 'facebook' ) ) { ?>
                    <a href="<?php the_author_meta( 'facebook' ); ?>" target="_blank" rel="nofollow">
                        <i class="fa fa-facebook"></i>
                    </a>
                <?php }

                if ( get_the_author_meta( 'instagram' ) ) { ?>
                    <a href="<?php the_author_meta( 'instagram' ); ?>" target="_blank" rel="nofollow">
                        <i class="fa fa-instagram"></i>
                    </a>
                <?php }

                if ( get_the_author_meta( 'youtube' ) ) { ?>
                    <a href="<?php the_author_meta( 'youtube' ); ?>" target="_blank" rel="nofollow">
                        <i class="fa fa-youtube-play"></i>
                    </a>
                <?php }

                if ( get_the_author_meta( 'linkedin' ) ) { ?>
                    <a href="<?php the_author_meta( 'linkedin' ); ?>" target="_blank" rel="nofollow">
                        <i class="fa fa-linkedin"></i>
                    </a>
                <?php }

                if ( get_the_author_meta( 'pinterest' ) ) { ?>
                    <a href="<?php the_author_meta( 'pinterest' ); ?>" target="_blank" rel="nofollow">
                        <i class="fa fa-pinterest-p"></i>
                    </a>
                <?php }

                if ( get_the_author_meta( 'vk' ) ) { ?>
                    <a href="<?php the_author_meta( 'vk' ); ?>" target="_blank" rel="nofollow">
                        <i class="fa fa-vk"></i>
                    </a>
                <?php } ?>
            </div>
		</div>
		<?php if ( get_the_author_meta( 'description' ) ) {
			echo '<div class="info">';
			    echo '<p>'. get_the_author_meta( 'description' ) .'</p>';
		    echo '</div>';
		} ?>
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