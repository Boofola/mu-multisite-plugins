<?php
declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( MUMultisiteOptions::get( 'disable_yearmonth' ) ) {
    add_filter( 'option_uploads_use_yearmonth_folders', '__return_false', 100 );
}

add_action( 'wp_initialize_site', function ( WP_Site $new_site ): void {
    $structure = (string) MUMultisiteOptions::get( 'permalink_structure' );
    if ( empty( $structure ) ) {
        return;
    }

    switch_to_blog( $new_site->id );
    global $wp_rewrite;
    if ( is_object( $wp_rewrite ) ) {
        $wp_rewrite->set_permalink_structure( $structure );
        $wp_rewrite->flush_rules();
    }
    restore_current_blog();
} );