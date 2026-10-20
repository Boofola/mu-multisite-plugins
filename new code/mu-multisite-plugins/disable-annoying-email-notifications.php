<?php
declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( MUMultisiteOptions::get( 'disable_update_emails' ) ) {
    add_filter( 'auto_plugin_update_send_email', '__return_false' );
    add_filter( 'auto_theme_update_send_email', '__return_false' );
    add_filter( 'auto_core_update_send_email', function ( bool $send, string $type ): bool {
        return 'success' === $type ? false : $send;
    }, 10, 2 );
}