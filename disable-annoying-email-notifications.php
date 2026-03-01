<?php

/**
 * @package Disable-Annoying-Email-Notifications
 * @version 2.0.1
 * 
 * Plugin Name: Disable Annoying Email Notifications
 * Plugin URI: https://boofolaworks.com/wordpress/plugins/mu-multisite-plugins/
 * Description: A simple little plugin to help getting rid of all of those annoying notification emails about plugin, site, and core updates. Especially if you have a plugin that updates them for you!
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

//Disable plugin auto-update email notification
add_filter('auto_plugin_update_send_email', '__return_false');
 
//Disable theme auto-update email notification
add_filter('auto_theme_update_send_email', '__return_false');

//Disable automatic "Your Site Has Been Updated..." emails
add_filter( 'auto_core_update_send_email', 'smartwp_disable_core_update_emails', 10, 4 );
function smartwp_disable_core_update_emails( $send, $type, $core_update, $result ) {
  if ( !empty($type) && $type == 'success' ) {
    return false;
  }
  
  return true;
}

/* Stop Adding Functions Below this Line */
?>