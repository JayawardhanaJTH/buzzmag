<?php get_header(); ?>

<div id="fl-content" class="fl-single">
	<div class="fl-container clearfix">
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="fl-media-wrap">
				<div class="fl-picture single">
					<?php echo wp_get_attachment_image( get_the_ID(), 'full' ); ?>
				</div>
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
							<?php the_content(); ?>
						</div>
					</article>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>