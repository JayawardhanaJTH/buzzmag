<?php get_header(); ?>

<div class="fl-container clearfix">
	<div class="fl-box">
		<div class="head">			
		    <h1 class="title">
		        <?php esc_html_e( 'Error 404. Oops!', 'buzzmag' ); ?>
		    </h1>
		</div>
		<div class="info">
		    <p><?php esc_html_e( 'It seems we can not find what you are looking for. Perhaps searching can help.', 'buzzmag' ); ?></p>
		    <?php get_template_part( 'searchform' ); ?>
	    </div>
	</div>

</div>
	
<div class="fl-container clearfix">
	<?php
	// Editor Picks
	get_template_part('includes/editor-picks');
	?>
</div>

<?php get_footer(); ?>