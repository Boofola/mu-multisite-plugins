<?php

/**
 * @package Default_Site_Structure
 * @version 2.0.1
 * 
 * Plugin Name: Default Site Structure
 * Plugin URI: https://boofolaworks.com/wordpress/plugins/mu-multisite-plugins/
 * Description: Crates default pages and set them as front/blog index pages.
 * Network:     true
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
namespace WPSE177819;

add_action( 'wp_loaded', __NAMESPACE__ . '\init' );

/**
 * @wp-hook wp_loaded
 */
function init() {

    add_action(
        'wp_initialize_site',
        function( \WP_Site $new_site, array $args ) {

            $blog_id = $new_site->id;
            $user_id = isset( $args['user_id'] ) ? (int) $args['user_id'] : 0;

            switch_to_blog( $blog_id );

            $front_page_id = wp_insert_post( front_page_data( $user_id ) );

            if ( ! is_wp_error( $front_page_id ) && 0 !== $front_page_id ) {
                update_option( 'show_on_front', 'page' );
                update_option( 'page_on_front', $front_page_id );
            }

            update_option( 'date_format', date_format() );
            update_option( 'time_format', time_format() );

            restore_current_blog();
        },
        10,
        2
    );
}

/**
 * Returns the data of the front page
 *
 * @param int $post_author
 *
 * @return array
 */
function front_page_data( $post_author ) {

    return [
        'post_title'   => 'Home',
        'post_content' => '',
        'post_type'    => 'page',
        'post_author'  => $post_author,
        'post_status'  => 'publish'
    ];
}

add_action( 'wp_initialize_site', __NAMESPACE__ . '\wpse296303_delete_wordpress_defaults', 100 );

function wpse296303_delete_wordpress_defaults( \WP_Site $new_site ) {
    $blog_id = $new_site->id;
    // Switch to the newly created blog
    switch_to_blog( $blog_id );
    // Delete 'Sample comment'
    wp_delete_comment( 1, true );
    // Delete 'Hello World!' post
    wp_delete_post( 1, true );
    // Delete 'Sample Page'
    wp_delete_post( 2, true );
    restore_current_blog();
}

/**
 * Returns the custom date format
 *
 * @return string
 */
function date_format() {

    return 'd,m,Y';
}

/**
 * Returns the custom time format
 *
 * @return string
 */
function time_format() {

    return 'H/i/s';
}

/* Stop Adding Functions Below this Line */
?>