<?php
/**
 * The template for displaying the theme header
 *
 * Displays all of the <head> section, top bar, navigation, and drawer.
 *
 * @package BuzzMag
 * @subpackage Templates
 * @author FlatLayers
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<!-- ================================================================================ -->
<!--   BuzzMag - Modern 3D News & Magazine Portal                                     -->
<!--   Rebranded by: Tiran Jayawardhana (jayawardhana.tiran@gmail.com)                -->
<!--   Version: 3.1.0                                                                 -->
<!-- ================================================================================ -->
<html <?php language_attributes(); ?>>
<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">

	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<div id="fl-top" title="<?php esc_attr_e( 'Scroll To Top', 'buzzmag' ); ?>">
		<i class="fa fa-long-arrow-up"></i>
	</div>

	<header id="fl-header">
		<div class="fl-container">
			<div id="fl-drawer-icon">
				<button class="icon">
					<span><?php esc_html_e( 'Menu', 'buzzmag' ); ?></span>
				</button>
				<?php /* <span class="text"><?php esc_html_e( 'Menu', 'buzzmag' ); ?></span> */ ?>
			</div>
			<div id="fl-logo">			    
			    <?php if ( get_theme_mod( 'logo' ) ) { ?>
			        <a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'>

			        	<img class="light-logo" src='<?php echo esc_url( get_theme_mod( 'logo' ) ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'>

			        	<?php if ( !get_theme_mod('dark_mode') && get_theme_mod( 'logo_dark' ) ) { ?>
			        		<img class="dark-logo" src='<?php echo esc_url( get_theme_mod( 'logo_dark' ) ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'>
			        	<?php } ?>

			        </a>
				<?php } else {
			        if ( is_home() ) {
						echo '<h1><a href="'. esc_url(home_url('/')).'" title="'. esc_attr( get_bloginfo('name') ) .'" rel="Home">'. esc_html( get_bloginfo('name') ) .'</a></h1>';
					} else {
						echo '<p><a href="'. esc_url(home_url('/')).'" title="'. esc_attr( get_bloginfo('name') ) .'" rel="Home">'. esc_html( get_bloginfo('name') ) .'</a></p>';
					}
				} ?>
			</div>
			
			<?php if ( has_nav_menu( 'main-menu' ) ) { ?>
				<div id="fl-topmenu">
					<?php  wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
				</div>
			<?php } ?>

			<div class="header-icons">

				<?php if ( !get_theme_mod('header_social') ) { 
					get_template_part( 'includes/social-icons' );
				}

				if ( class_exists( 'WooCommerce' ) ) {

					if ( !get_theme_mod( 'header_account' ) ) { ?>
				        <a class="my-account" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php esc_attr_e('My Account','buzzmag'); ?>">
				        	<i class="fa fa-user-circle-o"></i>
				        </a>
				    <?php }

					if ( !get_theme_mod( 'header_cart' ) ) { ?>
			            <a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'buzzmag' ); ?>">
				            <i class="fa fa-shopping-bag"></i>
				            <?php if ( WC()->cart->get_cart_contents_count() != 0 ) { ?>
					            <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
				            <?php } ?>
				        </a>
				    <?php }
				}

			    if ( !get_theme_mod( 'dark_mode' ) ) { ?>
				    <label class="fl-theme-switch" for="fl-darkmode">
				        <input type="checkbox" id="fl-darkmode">
				        <i class="fa fa-moon-o"></i>
				        <i class="fa fa-sun-o"></i>
					</label>
				<?php }

				if ( !get_theme_mod('header_search') ) { ?>
					<div id="fl-topsearch">
						<i class="fa fa-search"></i>
						<i class="fa fa-times"></i>
					</div>
				<?php } ?>
			</div>
		</div>
	</header>

	<div id="fl-drawer">
		<?php
			if ( is_active_sidebar( 'buzzmag_drawer' ) ) {
				dynamic_sidebar('buzzmag_drawer');
			}
		?>
	</div>

	<div class="push-overlay"></div>

	<?php if ( !get_theme_mod('header_search') ) { ?>
		<div id="fl-search-overlay">
			<div class="overlay-table">
				<div class="overlay-cell">
					<div class="fl-container clearfix">
						<div class="overlay-search">
							<?php get_template_part( 'searchform' ); ?>
							<div class="cats">
								<?php
								$cats = get_categories( array(
									'orderby' => 'count',
									'number' => 7
								));
								foreach ($cats as $cat) {
			                        echo '<a class="cat-link" href="'. get_category_link($cat->term_id) .'">'. $cat->name .'</a>';
			                    }
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>	

	<!-- Main Content div -->
	<div id="fl-main-warp">