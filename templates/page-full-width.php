<?php

/*
Template Name: Full Width Page
Template Post Type: page
*/

get_header();
?>

<div id="fl-content" class="fl-single">
	<div class="fl-container clearfix">
		<?php

		while (have_posts()) :
			the_post();

	        $class = '';

        	if ( has_post_thumbnail() ) {
        		$class = 'negative-margin';
        	}
		?>

		<div id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
			<div class="fl-media-wrap">
			<?php
	            if ( has_post_thumbnail() ) {
	                echo '<div class="fl-picture single">';
	                    the_post_thumbnail('buzzmag_large');
	                echo '</div>';
	            }
	        ?>
	        </div>
			<div class="clearfix">
				<div id="fl-post-container" class="no-sidebar">
					<article class="fl-article">						

						<div class="fl-post-header">
							<h1 class="title"><?php the_title(); ?></h1>

		                    <?php if ( has_excerpt() ) { ?>
			                    <div class="fl-excerpt">
			                        <?php the_excerpt(); ?>
			                    </div>
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
					</article>
					<?php

					// Comments
					comments_template();
					?>
				</div>
			</div>
		</div>
		<?php endwhile; ?>
	</div>
</div>

<?php get_footer(); ?>