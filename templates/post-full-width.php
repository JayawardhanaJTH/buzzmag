<?php
/*
Template Name: Full Width Post
Template Post Type: post
*/

$sidebar = false;
$layoutClass = 'no-sidebar';

get_header();

?>

<div id="fl-content" class="fl-single">
	<div class="fl-container clearfix">
		<?php

		while (have_posts()) :
			the_post();
			$postFormat = get_post_format();
			$gallery = get_post_meta( $post->ID, '_format_gallery_images', true );
	        $audio = get_post_meta( $post->ID, '_format_audio_embed', true );
	        $video = get_post_meta( $post->ID, '_format_video_embed', true );

	        $class = '';

	        if ( $postFormat == 'gallery' || $postFormat == 'image' || $postFormat == false ) {
	        	if ( !empty($gallery) || has_post_thumbnail() ) {
	        		$class = 'negative-margin';
	        	}
	        }
		?>

		<div id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
			<div class="fl-media-wrap">
			<?php	            
	        switch ($postFormat) {

	            case 'gallery':
	                if ( !empty($gallery) ) {
	                    echo '<div class="fl-gallery owl-carousel">';
	                        foreach( $gallery as $image ) {
	                            echo wp_get_attachment_image( $image, 'buzzmag_large' );
	                        }
	                    echo '</div>';
	                }
	                break;

	            case 'audio':
	                if ( !empty($audio) ) {
	                    echo '<div class="fl-audio">';
	                        echo wp_oembed_get( esc_url($audio) ); 
	                    echo '</div>';
	                }
	                break;

	            case 'video':
	                if ( !empty($video) ) {
	                    echo '<div class="fl-video">';
	                        echo wp_oembed_get( esc_url($video) ); 
	                    echo '</div>';
	                }
	                break;
	            
	            default:
	                if ( has_post_thumbnail() ) {
	                    echo '<div class="fl-picture single">';
	                        the_post_thumbnail('buzzmag_large');
	                    echo '</div>';
	                }
	                break;
	        }

	        ?>
	        </div>
			<div class="clearfix">
				<div id="fl-post-container" class="<?php echo esc_attr($layoutClass); ?>">
					<article class="fl-article" post-id="<?php the_ID(); ?>">

						<div class="fl-category"><?php echo the_category(' '); ?></div>

						<div class="fl-post-header">
							<h1 class="title"><?php the_title(); ?></h1>

		                    <?php if ( has_excerpt() ) { ?>
			                    <div class="fl-excerpt">
			                        <?php the_excerpt(); ?>
			                    </div>
		                    <?php }

		                    if ( !get_theme_mod( 'hide_meta_author' ) ) { ?>
		                        <span class="fl-meta">
		                            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr( get_the_author() ); ?>">
		                                <i class="authoravatar">
		                                    <?php echo get_avatar( get_the_author_meta( 'user_email' ), 40 ); ?>
		                                </i>
		                                <?php the_author(); ?>
		                            </a>
		                        </span>
	                        <?php }

			                if ( !get_theme_mod( 'hide_meta_date' ) ) { ?>
		                        <span class="fl-meta"><i class="fa fa-clock-o"></i><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . esc_html__( ' ago', 'buzzmag' ); ?></span>
	                        <?php }

			                if ( !get_theme_mod( 'hide_meta_comments' ) ) {
	                            if ( comments_open() || have_comments() ) { ?>
	                                <span class="fl-meta">
	                                    <a href="<?php comments_link(); ?>" class="comments"><i class="fa fa-comment-o"></i><?php comments_number( esc_html__('0', 'buzzmag'), esc_html__('1', 'buzzmag'), esc_html__( '%', 'buzzmag') ); ?></a>
	                                </span>
	                            <?php }
	                        }

			                if ( !get_theme_mod( 'hide_meta_views' ) ) { ?>
		                        <span class="fl-meta"><i class="fa fa-eye"></i><?php echo buzzmag_getpostviews(get_the_ID()); ?></span>
	                        <?php } ?>
						</div>

						<div class="fl-post-content clearfix">
							<?php
								the_content();
								$link_pages_args = array (
								    'before'            => '<div class="fl-page-links">',
								    'after'             => '</div>',
								    'separator'         => '<span class="page-link-sep"><span>'. esc_html__( 'Page', 'buzzmag' ) .'</span>'. $page . esc_html__( ' / ', 'buzzmag' ) . count($pages) .'</span>',
								    'next_or_number'    => 'next',
								    'nextpagelink'      => '<span class="page-link">'. esc_html__( 'Next', 'buzzmag' ) . '</span><i class="fa fa-long-arrow-right"></i>',
							        'previouspagelink'  => '<i class="fa fa-long-arrow-left"></i><span class="page-link">' . esc_html__( 'Previous', 'buzzmag' ) . '</span>',
								);
								wp_link_pages( $link_pages_args );
						    ?>
						</div>
						<?php if( has_tag() && !get_theme_mod( 'hide_meta_tags' ) ) { ?>
		                	<div class="fl-tags clearfix">
		                		<span class="tag"><?php esc_html_e( 'Tags', 'buzzmag' ); ?></span>
								<?php echo the_tags( '', ' ' ); ?>
							</div>
						<?php }

						// Footer Ad
					    $post_ad = get_theme_mod( 'post_ad', '<a href="https://themeforest.net/item/buzzmag-viral-news-wordpress-magazineblog-theme/19207752?ref=FlatLayers" target="_blank"><img src="'.fl_theme_path.'/img/ad.jpg" alt="BuzzMag Ad"></a>' );
					    if ( $post_ad ) { ?>
					        <div class="fl-ad alignwide clearfix">
					            <span class="adtitle"><?php esc_html_e( '&ndash; Advertisement &ndash;', 'buzzmag' ); ?></span>
					            <?php echo wp_kses_post($post_ad); ?>
					        </div>
					    <?php } ?>
					</article>
					<?php
					// Author Section
					get_template_part('includes/author-box');

					// Related Posts
					get_template_part('includes/related-posts');

					// Editor Picks
					get_template_part('includes/editor-picks');

					// Comments
					comments_template();
					?>
				</div>
				<?php if ( $sidebar == true) { get_sidebar(); } ?>
			</div>
		</div>
		<?php endwhile; ?>
	</div>
</div>

<?php get_footer(); ?>