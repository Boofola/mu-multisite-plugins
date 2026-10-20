<?php
declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wp_initialize_site', function ( WP_Site $new_site ): void {
    if ( ! MUMultisiteOptions::get( 'enable_force_options' ) ) {
        return;
    }

    if ( MUMultisiteOptions::get( 'disable_yearmonth' ) ) {
        update_blog_option( $new_site->id, 'uploads_use_yearmonth_folders', false );
    }

    $structure = (string) MUMultisiteOptions::get( 'permalink_structure' );
    if ( ! empty( $structure ) ) {
        switch_to_blog( $new_site->id );
        update_option( 'permalink_structure', $structure );
        delete_option( 'rewrite_rules' );
        restore_current_blog();
    }
} );