<?php

/**
 * Plugin Name: Force Settings for New Sites
 * Description: This plugin makes changes to the settings when a new site is created on a MU installation.
 * Plugin URI: https://boofolaworks.com/wp-plugins/force-mu-new-site-settings
 * Author: BoofolaWorks.com
 * Version: 1.0.2
 * Author URI: https://boofolaworks.com
 *
 * Text Domain: boofolaworks
 *
 * @package BoofolaWorks
 * @category Settings
 *
 * This plugin is created as free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This plugin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

/* Start Adding Functions Below this Line */

// Force Uploads Use Yearmonth to off (0) for all existing sites in Multisites:

add_filter( 'option_uploads_use_yearmonth_folders', '__return_false', 100 );


/* Sets permalink structure for each blog activation */
add_action('activate_blog', 'wpse_271662_set_permalinks');
function wpse_271662_set_permalinks() {
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
    $wp_rewrite->flush_rules();
}


/* Stop Adding Functions Below this Line */
?>
