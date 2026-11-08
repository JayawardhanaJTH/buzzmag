<?php if ( !get_theme_mod( 'hide_author_box' ) ) {  ?>
    <div class="fl-box">
        <div class="avatar">
            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr( get_the_author() ); ?>">
                <?php echo get_avatar( get_the_author_meta( 'user_email' ), 80 ); ?>
            </a>
        </div>
        <div class="info">
            <span class="fl-meta"><?php esc_html_e( 'Written By', 'buzzmag' ); ?></span>
            <h4 class="title"><?php the_author_posts_link(); ?></h4>
            <p><?php the_author_meta( 'description' ); ?></p>
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
    </div>
<?php } ?>