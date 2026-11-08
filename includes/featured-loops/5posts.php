<?php
if ( empty($args['offset']) ) {
    $args['offset'] = 0;
}

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
        'posts_per_page'      => 5,
        'ignore_sticky_posts' => 1,
        'offset'              => $args['offset'],
    )
);

if ( $loop->post_count >= 5 ) { ?>
    <div class="posts-5 fl-container clearfix">
        <?php while ( $loop->have_posts() ) {
            $loop->the_post();
            ?>
            <article class="fl-post">
                <div class="fl-picture">
                    <a href="<?php the_permalink(); ?>">
                        <?php
                        if ( has_post_thumbnail() ) {
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
                    <div class="category">
                        <?php echo the_category(' / '); ?>
                    </div>                    
                    <?php if ( !get_theme_mod( 'hide_meta_date' ) ) : ?>
                    <div class="meta"><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . esc_html__( ' ago', 'buzzmag' ); ?>
                    </div>                    
                    <?php endif; ?>
                    <h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                </div>
            </article>
            <?php
        }
        wp_reset_postdata();
        ?>
    </div>
<?php } ?>