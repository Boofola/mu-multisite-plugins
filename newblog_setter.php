<?php
/**
 * Plugin Name: Default Site Structure
 * Description: Crates default pages and set them as front/blog index pages.
 * Network:     true
 * Plugin URL:  http://wordpress.stackexchange.com/a/219504/31323
 * License:     MIT
 * Version:     1.0.0-alpha
 */
 
/* Start Adding Functions Below this Line */
namespace WPSE177819;

add_action( 'wp_loaded', __NAMESPACE__ . '\init' );

/**
 * @wp-hook wp_loaded
 */
function init() {

    add_action(
        'wpmu_new_blog',
        function( $blog_id, $user_id ) {

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

add_action ('wpmu_new_blog', 'wpse296303_delete_wordpress_defaults', 100, 1);

function wpse296303_delete_wordpress_defaults ($blog_id, $user_id, $domain, $path, $site_id, $meta) {
  // Switch to the newly created blog
  switch_to_blog ($blog_id);
  // Delete 'Sample comment' page
  wp_delete_comment (1, true);
  // Delete 'Hello World!' post
  wp_delete_post (1, true);
  // Delete 'Sample page' page
  wp_delete_post (2, true);
}

  restore_current_blog();

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
