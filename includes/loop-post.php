<?php
// Loop Post Content
// Used in all Loops
?>
<article <?php post_class('fl-post clearfix'); ?>>
    <?php if ( has_post_thumbnail() ) { ?>
        <div class="fl-picture">
            <a href="<?php the_permalink(); ?>">
                <?php
                the_post_thumbnail( $args['thumb_size'] );

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
    <?php } ?>
    <div class="content">
        <div class="post-meta">
            <?php if ( is_sticky() ) {
                echo '<span class="sticky"><i class="fa fa-thumb-tack"></i></span>';
            } ?>

            <span class="fl-category"><?php echo the_category(' '); ?></span>

            <?php if ( !get_theme_mod( 'hide_meta_author' ) ) { ?>
                <span class="fl-meta"><i class="fa fa-user-o"></i><?php the_author_posts_link(); ?></span>
            <?php }

            
            if ( !get_theme_mod( 'hide_meta_date' ) ) { ?>
                <span class="fl-meta"><i class="fa fa-clock-o"></i><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . esc_html__( ' ago', 'buzzmag' ); ?></span>
            <?php }

            if ( !get_theme_mod( 'hide_meta_views' ) ) { ?>
                <span class="fl-meta"><i class="fa fa-eye"></i><?php echo buzzmag_getpostviews(get_the_ID()); ?></span>
            <?php }

            if ( !get_theme_mod( 'hide_meta_comments' ) ) {
                if ( comments_open() || have_comments() ) { ?>
                    <span class="fl-meta">
                        <i class="fa fa-comment-o"></i><?php comments_number( esc_html__('0', 'buzzmag'), esc_html__('1', 'buzzmag'), esc_html__( '%', 'buzzmag') ); ?>
                    </span>
                <?php }
            }

            ?>
        </div>

        <h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>    

        <?php if ( has_excerpt() ) { ?>
            <div class="fl-excerpt">
                <?php the_excerpt(); ?>
            </div>
        <?php } ?>
    </div>
</article>