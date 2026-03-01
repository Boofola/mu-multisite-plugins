<?php

/**
 * @package Disable-Annoying-Email-Notifications
 * @version 1.0.1
 * Plugin Name: Disable Annoying Email Notifications
 * Plugin URI: https://boofolaworks.com/plugins/disable-annoying-emails
 * Description: A simple little plugin to help getting rid of all of those annoying notification emails about plugin, site, and core updates. Especially if you have a plugin that updates them for you!
 * Author: BoofolaWorks.com
 * Version: 1.0.1
 * Author URI: https://boofolaworks.com/plugins/
 * Contributors: BOOFOLA LLC, Todd Stratton
**/


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
