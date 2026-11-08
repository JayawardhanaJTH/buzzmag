<?php

// Cats Slugs
$featured_cats = get_theme_mod('featured_cats');
$cats = str_replace(' ', '', $featured_cats);
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
        'posts_per_page'      => 1,
        'ignore_sticky_posts' => 1,
    )
);

if ( $loop->have_posts() ) {
    while ( $loop->have_posts() ) {
        $loop->the_post();
        
        $thumbnail = '';
        if ( has_post_thumbnail() ) {
            $thumbnail =  wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'buzzmag_large');
            $thumbnail = $thumbnail[0];
        } ?>
        <div class="post-1 fl-container">     
            <article class="fl-post" style="background-image: url(<?php echo esc_url($thumbnail); ?>);">
                <div class="fl-picture">
                    <a href="<?php the_permalink(); ?>">
                        <?php                        
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
                    <div class="fl-category"><?php echo the_category(' '); ?></div>
                    <div class="inner">
                        <h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

                        <?php if ( !get_theme_mod( 'hide_meta_date' ) ) { ?>
                        <span class="fl-meta"><i class="fa fa-clock-o"></i><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . esc_html__( ' ago', 'buzzmag' ); ?></span>
                        <?php }

                        if ( !get_theme_mod( 'hide_meta_author' ) ) { ?>
                        <span class="fl-meta">
                            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr( get_the_author() ); ?>">
                                <i class="authoravatar">
                                    <?php echo get_avatar( get_the_author_meta( 'user_email' ), 24 ); ?>
                                </i>
                                <?php the_author(); ?>                       
                            </a>
                        </span>
                        <?php } 
                        if ( !get_theme_mod( 'hide_meta_comments' ) ) {
                            if ( comments_open() || have_comments() ) { ?>
                                <span class="fl-meta">
                                    <i class="fa fa-comment-o"></i><?php comments_number( esc_html__('0', 'buzzmag'), esc_html__('1', 'buzzmag'), esc_html__( '%', 'buzzmag') ); ?>
                                </span>
                            <?php }
                        }
                        if ( !get_theme_mod( 'hide_meta_views' ) ) { ?>
                        <span class="fl-meta"><i class="fa fa-eye"></i><?php echo buzzmag_getpostviews(get_the_ID()); ?></span>
                        <?php } ?>
                    </div>
                </div>
            </article>
        </div>
    <?php }
    wp_reset_postdata();
}
?>