<?php
/**
 * Single Post Template (3D News Format)
 *
 * @package BuzzMag
 */

$sidebar = true;
$layoutClass = '';

if ( get_theme_mod( 'hide_sidebar_post' ) ) {
    $sidebar = false;
    $layoutClass = 'no-sidebar';
}

get_header();
?>

<div id="fl-content" class="fl-single fl-3d-single-page">
    <div class="fl-container clearfix">
        <?php
        while ( have_posts() ) :
            the_post();
            $postFormat = get_post_format();
            $gallery    = get_post_meta( $post->ID, '_format_gallery_images', true );
            $audio      = get_post_meta( $post->ID, '_format_audio_embed', true );
            $video      = get_post_meta( $post->ID, '_format_video_embed', true );

            $class = 'fl-3d-card fl-single-article-card';
        ?>

        <div class="clearfix fl-single-columns-wrap">
            <div id="fl-post-container" class="<?php echo esc_attr( $layoutClass ); ?>">
                <div id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
                    <!-- 1. Post Media aligned with sidebar start -->
                    <div class="fl-media-wrap">
                    <?php
                    switch ( $postFormat ) {
                        case 'gallery':
                            if ( ! empty( $gallery ) ) {
                                echo '<div class="fl-gallery owl-carousel">';
                                foreach ( $gallery as $image ) {
                                    echo wp_get_attachment_image( $image, 'buzzmag_large' );
                                }
                                echo '</div>';
                            }
                            break;

                        case 'audio':
                            if ( ! empty( $audio ) ) {
                                echo '<div class="fl-audio">';
                                echo wp_oembed_get( esc_url( $audio ) );
                                echo '</div>';
                            }
                            break;

                        case 'video':
                            if ( ! empty( $video ) ) {
                                echo '<div class="fl-video">';
                                echo wp_oembed_get( esc_url( $video ) );
                                echo '</div>';
                            }
                            break;

                        default:
                            if ( has_post_thumbnail() ) {
                                echo '<div class="fl-picture single">';
                                the_post_thumbnail( 'buzzmag_large' );
                                echo '</div>';
                            }
                            break;
                    }
                    ?>
                    </div>

                    <!-- 2. Post Article Body -->
                    <div class="fl-single-body-wrap">
                        <article class="fl-article" post-id="<?php the_ID(); ?>">
                            <div class="fl-category"><?php echo the_category( ' ' ); ?></div>

                            <div class="fl-post-header">
                                <h1 class="title"><?php the_title(); ?></h1>

                                <?php if ( has_excerpt() ) { ?>
                                    <div class="fl-excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                <?php }

                                if ( ! get_theme_mod( 'hide_meta_author' ) ) { ?>
                                    <span class="fl-meta">
                                        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr( get_the_author() ); ?>">
                                            <i class="authoravatar">
                                                <?php echo get_avatar( get_the_author_meta( 'user_email' ), 40 ); ?>
                                            </i>
                                            <?php the_author(); ?>
                                        </a>
                                    </span>
                                <?php }

                                if ( ! get_theme_mod( 'hide_meta_date' ) ) { ?>
                                    <span class="fl-meta"><i class="fa fa-clock-o"></i><?php echo human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . esc_html__( ' ago', 'buzzmag' ); ?></span>
                                <?php }

                                if ( ! get_theme_mod( 'hide_meta_comments' ) ) {
                                    if ( comments_open() || have_comments() ) { ?>
                                        <span class="fl-meta">
                                            <a href="<?php comments_link(); ?>" class="comments"><i class="fa fa-comment-o"></i><?php comments_number( esc_html__( '0', 'buzzmag' ), esc_html__( '1', 'buzzmag' ), esc_html__( '%', 'buzzmag' ) ); ?></a>
                                        </span>
                                    <?php }
                                } ?>
                            </div>

                            <div class="fl-post-content clearfix">
                                <?php
                                the_content();
                                $link_pages_args = array(
                                    'before'           => '<div class="fl-page-links">',
                                    'after'            => '</div>',
                                    'separator'        => '<span class="page-link-sep"><span>' . esc_html__( 'Page', 'buzzmag' ) . '</span>' . $page . esc_html__( ' / ', 'buzzmag' ) . count( $pages ) . '</span>',
                                    'next_or_number'   => 'next',
                                    'nextpagelink'     => '<span class="page-link">' . esc_html__( 'Next', 'buzzmag' ) . '</span><i class="fa fa-long-arrow-right"></i>',
                                    'previouspagelink' => '<i class="fa fa-long-arrow-left"></i><span class="page-link">' . esc_html__( 'Previous', 'buzzmag' ) . '</span>',
                                );
                                wp_link_pages( $link_pages_args );
                                ?>
                            </div>

                            <?php if ( has_tag() && ! get_theme_mod( 'hide_meta_tags' ) ) { ?>
                                <div class="fl-tags clearfix">
                                    <span class="tag"><?php esc_html_e( 'Tags', 'buzzmag' ); ?></span>
                                    <?php echo the_tags( '', ' ' ); ?>
                                </div>
                            <?php }

                            // Post Ad
                            $post_ad = get_theme_mod( 'post_ad', '' );
                            if ( $post_ad ) { ?>
                                <div class="fl-ad alignwide clearfix">
                                    <span class="adtitle"><?php esc_html_e( '&ndash; Advertisement &ndash;', 'buzzmag' ); ?></span>
                                    <?php echo wp_kses_post( $post_ad ); ?>
                                </div>
                            <?php } ?>
                        </article>

                        <?php
                        // Author Section
                        get_template_part( 'includes/author-box' );
                        ?>
                    </div>
                </div>

                <?php
                // Under Post Modules: Latest (6) and Most Read (last 36hr, 6)
                buzzmag_render_single_under_post( get_the_ID() );
                ?>
            </div>

            <!-- Post Sidebar with 6 Categories (Local, Off road, Business, Sports, Foreign, Featured) -->
            <?php if ( $sidebar == true ) : ?>
                <aside id="fl-sidebar" class="fl-sticky-sidebar fl-single-sidebar">
                    <?php
                    // Render the 6 Main Categories (3 posts each)
                    buzzmag_render_single_sidebar_categories( get_the_ID() );

                    // Default sidebar widgets (if any exist)
                    if ( is_active_sidebar( 'buzzmag_sidebar' ) ) {
                        dynamic_sidebar( 'buzzmag_sidebar' );
                    }
                    ?>
                </aside>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>
