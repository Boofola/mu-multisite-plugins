<?php

/**
 * @package Force-Site-Settings
 * @version 2.0.1
 * 
 * Plugin Name: Force Site Settings
 * Description: This plugin makes changes to the settings when a new site is created on a MU installation.
 * Plugin URI: https://boofolaworks.com/wordpress/plugins/mu-multisite-plugins/
 * Version: 2.0.1
 * Author: BOOFOLA LLC
 * Author URI: https://boofolallc.com/
 * License: GPLv2 or later
 * Text Domain: mu-multisite-plugins
 *
 * @package BoofolaWorks Must-Use Multisite Plugins
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