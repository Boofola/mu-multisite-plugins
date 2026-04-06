<?php

/**
 * @package Must-Use_Multisite-Plugins
 * @version 2.0.1
 * 
 * Plugin Name: Must-Use Multisite Plugins
 * Plugin URI: https://boofolaworks.com/wordpress/plugins/mu-multisite-plugins/
 * Description: A small collection of Must-Use plugins for WordPress Multisite that helps with setting up new sites quickly without having to duplicate making the same settings changes.
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

// We need the ABSPATH constant to be defined to ensure that this file is being accessed through WordPress and not directly. If it's not defined, we exit the script.
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Check if the add_action function exists, which is a core WordPress function. If it doesn't exist, it means that this file is being accessed outside of the WordPress environment, so we display a message and exit.
if(!function_exists('add_action')){
	echo 'You are not allowed to access this page directly.';
	exit;
}

// Include the individual plugin files. Each of these files contains the code for a specific plugin that provides a certain functionality. By including them here, we ensure that they are loaded and available for use in the WordPress Multisite environment.
require_once plugin_dir_path(__FILE__) . 'mu-plugins/custom-dashboard-message.php';
require_once plugin_dir_path(__FILE__) . 'mu-plugins/disable-annoying-email-notifications.php';
require_once plugin_dir_path(__FILE__) . 'mu-plugins/force-new-site-options.php';
require_once plugin_dir_path(__FILE__) . 'mu-plugins/it-gets-better.php';
require_once plugin_dir_path(__FILE__) . 'mu-plugins/newblog_setter.php';
require_once plugin_dir_path(__FILE__) . 'mu-plugins/permalink_setter.php'; 

// Add the action to load the plugins when WordPress initializes. This ensures that the plugins are loaded at the appropriate time during the WordPress loading process.
add_action('plugins_loaded', 'mu_multisite_load_plugins_load_plugin');

// The function that will be called when the plugin is loaded. This function can be used to perform any necessary setup or initialization for the plugins. Currently, it's empty, but you can add any code here that you want to run when the plugins are loaded.
function mu_multisite_load_plugins_load_plugin(){

}

/* Stop Adding Functions Below this Line */
?>