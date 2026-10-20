<?php
declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'login_enqueue_scripts', function (): void {
    if ( ! MUMultisiteOptions::get( 'enable_custom_login' ) ) {
        return;
    }

    $bg_url   = esc_url( MUMultisiteOptions::get( 'login_bg_url' ) );
    $logo_url = esc_url( MUMultisiteOptions::get( 'login_logo_url' ) );

    ?>
    <style type="text/css">
        body.login {
            background-image: url('<?php echo $bg_url; ?>') !important;
            background-size: cover !important;
            background-position: center !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-height: 100vh !important;
            margin: 0 !important;
            flex-direction: column !important;
        }
        #login { width: 400px !important; padding: 20px 0 !important; margin: 0 !important; }
        #login h1 a {
            background-image: url('<?php echo $logo_url; ?>') !important;
            background-size: contain !important;
            background-position: center !important;
            width: 100% !important;
            height: 120px !important;
            margin-bottom: 20px !important;
        }
        .login form { background: rgba(16, 19, 25, 0.9) !important; border: 1px solid #363940 !important; border-radius: 8px !important; }
        .login label { color: #FDB405 !important; }
        .login input[type="text"], .login input[type="password"] { background: #29375C !important; color: #fff !important; }
        .login input[type="submit"] { background: #FDB405 !important; color: #000 !important; font-weight: bold !important; border: none !important; }
        .custom-login-footer { margin-top: 50px !important; text-align: center !important; color: #ffffff !important; }
        .custom-login-footer-links a { color: #ffffff !important; margin: 0 15px !important; }
    </style>
    <?php
} );

add_action( 'login_footer', function (): void {
    if ( ! MUMultisiteOptions::get( 'enable_custom_login' ) ) {
        return;
    }
    ?>
    <div class="custom-login-footer">
        <div class="custom-login-footer-links">
            <a href="<?php echo esc_url( wp_privacy_policy_url() ); ?>"><?php esc_html_e( 'Privacy Policy', 'mu-multisite-plugins' ); ?></a>
            <a href="https://boofolallc.com/tcou" target="_blank" rel="noopener"><?php esc_html_e( 'Terms of Service', 'mu-multisite-plugins' ); ?></a>
            <a href="https://boofolaworks.com/help" target="_blank" rel="noopener"><?php esc_html_e( 'Help Center', 'mu-multisite-plugins' ); ?></a>
        </div>
        <div class="custom-login-copyright">
            &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> BOOFOLA LLC. <?php esc_html_e( 'All rights reserved.', 'mu-multisite-plugins' ); ?>
        </div>
    </div>
    <?php
} );

add_filter( 'login_headerurl', fn (): string => home_url() );
add_filter( 'login_headertext', fn (): string => get_bloginfo( 'name' ) );