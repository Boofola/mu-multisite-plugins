<?php
declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'admin_init', function (): void {
    if ( MUMultisiteOptions::get( 'enable_custom_dashboard' ) ) {
        remove_action( 'welcome_panel', 'wp_welcome_panel' );
    }
} );

add_action( 'welcome_panel', function (): void {
    if ( ! MUMultisiteOptions::get( 'enable_custom_dashboard' ) ) {
        return;
    }
    ?>
    <div class="custom-welcome-panel-content">
        <h3><?php echo esc_html( MUMultisiteOptions::get( 'dashboard_heading' ) ); ?></h3>
        <p class="about-description">
            <?php esc_html_e( 'Here you can create and manage your content, customize your site, and explore various features.', 'mu-multisite-plugins' ); ?>
        </p>
    </div>
    <?php
} );