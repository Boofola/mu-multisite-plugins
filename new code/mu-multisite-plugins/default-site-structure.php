<?php
declare(strict_types=1);

namespace WPSE177819;

use MUMultisiteOptions;
use WP_Site;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wp_initialize_site', function ( WP_Site $new_site, array $args ): void {
    $blog_id = $new_site->id;
    $user_id = isset( $args['user_id'] ) ? (int) $args['user_id'] : 0;

    switch_to_blog( $blog_id );

    $front_page_id = wp_insert_post( [
        'post_title'   => 'Home',
        'post_content' => '',
        'post_type'    => 'page',
        'post_author'  => $user_id,
        'post_status'  => 'publish',
    ] );

    if ( ! is_wp_error( $front_page_id ) && 0 !== $front_page_id ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $front_page_id );
    }

    update_option( 'date_format', (string) MUMultisiteOptions::get( 'default_date_format', 'd,m,Y' ) );
    update_option( 'time_format', (string) MUMultisiteOptions::get( 'default_time_format', 'H/i/s' ) );

    if ( MUMultisiteOptions::get( 'clean_default_content' ) ) {
        wp_delete_comment( 1, true );
        wp_delete_post( 1, true );
        wp_delete_post( 2, true );
    }

    restore_current_blog();
}, 10, 2 );