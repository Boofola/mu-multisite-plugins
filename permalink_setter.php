<?php
/* Plugin name: Permalink Setter
Description: Sets permalink structure for each blog activation
*/

/* Start Adding Functions Below this Line */

add_action('activate_blog', 'wpse_271662_set_permalinks');
function wpse_271662_set_permalinks() {
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
    $wp_rewrite->flush_rules();
}

/* Stop Adding Functions Below this Line */
?>
