<?php

if ( get_theme_mod('disable_sticky_sidebar') ) {
	$class = '';
} else {
	$class = 'fl-sticky-sidebar';
}

echo '<aside id="fl-sidebar" class="'. esc_attr($class) .'">';
	if ( class_exists( 'WooCommerce' ) ) {
		if ( is_woocommerce() ) {
			if ( is_active_sidebar( 'buzzmag_woocommerce_sidebar' ) ) {
				dynamic_sidebar('buzzmag_woocommerce_sidebar');
			}
		} else {
			if ( is_active_sidebar( 'buzzmag_sidebar' ) ) {
				dynamic_sidebar('buzzmag_sidebar');
			}
		}
	} else {
		if ( is_active_sidebar( 'buzzmag_sidebar' ) ) {
			dynamic_sidebar('buzzmag_sidebar');
		}
	}
echo '</aside>';

?>