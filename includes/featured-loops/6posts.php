<?php

// 1 Post
get_template_part( 'includes/featured-loops/1post');
// 5 Posts, 1 offset
get_template_part( 'includes/featured-loops/5posts', null, array( 'offset' => 1 ) );

?>