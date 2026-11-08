<?php

// Add Category Fields
function buzzmag_add_category_fields($taxonomy){

	$layout_options = array(
    	'default'          => esc_html__('Default Category Layout', 'buzzmag'),
    	'grid'             => esc_html__('Grid 2 Columns', 'buzzmag'),
    	'grid_sidebar'     => esc_html__('Grid 2 Columns & Sidebar', 'buzzmag'),
    	'grid_col_3'       => esc_html__('Grid 3 Columns', 'buzzmag'),
    	'list'             => esc_html__('List Full Width', 'buzzmag'), 
    	'list_sidebar'     => esc_html__('List & Sidebar', 'buzzmag'),  
    	'masonry'          => esc_html__('Masonry 2 Columns', 'buzzmag'),  	
    	'masonry_sidebar'  => esc_html__('Masonry 2 Columns & Sidebar', 'buzzmag'),
    	'masonry_col_3'    => esc_html__('Masonry 3 Columns', 'buzzmag'),
    	'standard'         => esc_html__('Standard', 'buzzmag'),
    	'standard_sidebar' => esc_html__('Standard & Sidebar', 'buzzmag')
    );
    ?>
    <div class="form-field term-group">
        <label for="buzzmag_cat_layout"><?php esc_html_e('Category Layout', 'buzzmag'); ?></label>
        <select name="buzzmag_cat_layout" id="buzzmag_cat_layout">
        	<?php
        	foreach ($layout_options as $key => $value) {
        		echo '<option value="'. esc_attr($key) .'">'. esc_html($value) .'</option>';
        	}
        	?>
        </select>
        <p><?php esc_html_e( 'Select Category Layout', 'buzzmag' ); ?></p>
    </div>
    <?php
}
add_filter('category_add_form_fields', 'buzzmag_add_category_fields');

// Edit Category Fields
function buzzmag_edit_category_fields($term) {
    $layout = get_term_meta($term->term_id, 'buzzmag_cat_layout', true);

    $layout_options = array(
    	'default'          => esc_html__('Default Category Layout', 'buzzmag'),
    	'grid'             => esc_html__('Grid 2 Columns', 'buzzmag'),
    	'grid_sidebar'     => esc_html__('Grid 2 Columns & Sidebar', 'buzzmag'),
    	'grid_col_3'       => esc_html__('Grid 3 Columns', 'buzzmag'),
    	'list'             => esc_html__('List Full Width', 'buzzmag'), 
    	'list_sidebar'     => esc_html__('List & Sidebar', 'buzzmag'),  
    	'masonry'          => esc_html__('Masonry 2 Columns', 'buzzmag'),  	
    	'masonry_sidebar'  => esc_html__('Masonry 2 Columns & Sidebar', 'buzzmag'),
    	'masonry_col_3'    => esc_html__('Masonry 3 Columns', 'buzzmag'),
    	'standard'         => esc_html__('Standard', 'buzzmag'),
    	'standard_sidebar' => esc_html__('Standard & Sidebar', 'buzzmag')
    );
    ?>
    <table class="form-table">
        <tr class="form-field">
            <th scope="row" valign="top">
            	<label for="buzzmag_cat_layout"><?php esc_html_e('Category Layout', 'buzzmag'); ?></label>
            </th>
            <td>
                <select name="buzzmag_cat_layout" id="buzzmag_cat_layout">
                	<?php
                	foreach ($layout_options as $key => $option) {
                		echo '<option value="'. esc_attr($key) .'"'. selected( $key, $layout ) .'>'. esc_html($option) .'</option>';
                	}
                	?>
                </select>
                <p class="description"><?php esc_html_e( 'Select Category Layout', 'buzzmag' ); ?></p>
            </td>
        </tr>
    </table>
<?php
}
add_filter('category_edit_form_fields', 'buzzmag_edit_category_fields');

// Save Category Fields
function buzzmag_save_category_fields($term_id) {
    if (isset($_POST['buzzmag_cat_layout']) && '' !== $_POST['buzzmag_cat_layout']){
        add_term_meta($term_id, 'buzzmag_cat_layout', $_POST['buzzmag_cat_layout'], true);
    }
}
add_action ( 'create_category', 'buzzmag_save_category_fields');

// Update Category Fields
function buzzmag_update_category_fields( $term_id ) {
    if (isset($_POST['buzzmag_cat_layout']) && '' !== $_POST['buzzmag_cat_layout']){
        update_term_meta($term_id, 'buzzmag_cat_layout', $_POST['buzzmag_cat_layout']);
    }
}
add_action ( 'edited_category', 'buzzmag_update_category_fields');
