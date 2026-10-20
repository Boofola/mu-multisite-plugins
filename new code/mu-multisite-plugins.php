<?php
/**
 * Plugin Name: Must-Use Multisite Plugins Loader
 * Plugin URI:  https://boofolaworks.com/wordpress/plugins/mu-multisite-plugins/
 * Description: Central management and loader for Must-Use plugins with configurable settings.
 * Version:     3.0.0
 * Author:      BOOFOLA LLC
 * License:     GPLv2 or later
 * Text Domain: mu-multisite-plugins
 * 
 * PHP Version: 8.3+
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Option Management Class
 */
final class MUMultisiteOptions {

    public const OPTION_KEY = 'mu_multisite_plugin_options';

    public static function get_defaults(): array {
        return [
            // Custom Login Settings
            'enable_custom_login' => true,
            'login_bg_url'        => 'https://boofolaworks.com/boofola_brands996/login/boofola_multi-layers-gray-blue-background.jpg',
            'login_logo_url'      => 'https://boofolaworks.com/boofola_brands996/login/boofola_dashboard_logo.svg',
            
            // Dashboard Message Settings
            'enable_custom_dashboard' => true,
            'dashboard_heading'       => 'Welcome to your MyBoofola Dashboard!',
            
            // Email Notifications
            'disable_update_emails' => true,
            
            // Site Structure & Permalinks
            'enable_force_options'   => true,
            'disable_yearmonth'      => true,
            'permalink_structure'    => '/%postname%/',
            'clean_default_content'  => true,
            'default_date_format'    => 'd,m,Y',
            'default_time_format'    => 'H/i/s',
            
            // Quote Widget
            'enable_quotes' => true,
        ];
    }

    public static function get( string $key, mixed $default = null ): mixed {
        $options = is_multisite() 
            ? get_site_option( self::OPTION_KEY, self::get_defaults() ) 
            : get_option( self::OPTION_KEY, self::get_defaults() );

        $options = wp_parse_args( is_array( $options ) ? $options : [], self::get_defaults() );

        return $options[ $key ] ?? $default;
    }

    public static function update_all( array $new_options ): bool {
        $clean_options = [];
        foreach ( self::get_defaults() as $key => $default_val ) {
            if ( is_bool( $default_val ) ) {
                $clean_options[ $key ] = ! empty( $new_options[ $key ] );
            } else {
                $clean_options[ $key ] = sanitize_text_field( $new_options[ $key ] ?? $default_val );
            }
        }

        return is_multisite() 
            ? update_site_option( self::OPTION_KEY, $clean_options )
            : update_option( self::OPTION_KEY, $clean_options );
    }
}

/**
 * Admin Settings Interface
 */
final class MUMultisiteAdmin {

    public function __construct() {
        if ( is_multisite() ) {
            add_action( 'network_admin_menu', [ $this, 'add_menu' ] );
            add_action( 'network_admin_edit_mu_multisite_save', [ $this, 'save_network_options' ] );
        } else {
            add_action( 'admin_menu', [ $this, 'add_menu' ] );
            add_action( 'admin_init', [ $this, 'register_settings' ] );
        }
    }

    public function add_menu(): void {
        $title    = __( 'MU Plugins Settings', 'mu-multisite-plugins' );
        $capability = 'manage_options';

        if ( is_multisite() ) {
            add_submenu_page(
                'settings.php',
                $title,
                $title,
                'manage_network_options',
                'mu-plugin-settings',
                [ $this, 'render_admin_page' ]
            );
        } else {
            add_options_page( $title, $title, $capability, 'mu-plugin-settings', [ $this, 'render_admin_page' ] );
        }
    }

    public function register_settings(): void {
        register_setting( 'mu_multisite_options_group', MUMultisiteOptions::OPTION_KEY );
    }

    public function save_network_options(): void {
        check_admin_referer( 'mu_multisite_options_verify' );

        if ( ! current_user_can( 'manage_network_options' ) ) {
            wp_die( esc_html__( 'Unauthorized user.', 'mu-multisite-plugins' ) );
        }

        if ( isset( $_POST['mu_options'] ) && is_array( $_POST['mu_options'] ) ) {
            MUMultisiteOptions::update_all( $_POST['mu_options'] );
        }

        wp_redirect( add_query_arg( [ 'page' => 'mu-plugin-settings', 'updated' => 'true' ], network_admin_url( 'settings.php' ) ) );
        exit;
    }

    public function render_admin_page(): void {
        if ( isset( $_POST['mu_options'] ) && ! is_multisite() && check_admin_referer( 'mu_multisite_options_verify' ) ) {
            MUMultisiteOptions::update_all( $_POST['mu_options'] );
            echo '<div class="updated"><p>' . esc_html__( 'Settings saved.', 'mu-multisite-plugins' ) . '</p></div>';
        }

        $action_url = is_multisite() ? network_admin_url( 'edit.php?action=mu_multisite_save' ) : '';
        ?>
<div class="wrap">
    <h1><?php esc_html_e( 'MU Plugins Configuration', 'mu-multisite-plugins' ); ?></h1>
    <form method="post" action="<?php echo esc_url( $action_url ); ?>">
        <?php wp_nonce_field( 'mu_multisite_options_verify' ); ?>

        <h2><?php esc_html_e( 'Custom Login Page Options', 'mu-multisite-plugins' ); ?></h2>
        <table class="form-table">
            <tr>
                <th><label
                        for="enable_custom_login"><?php esc_html_e( 'Enable Custom Login', 'mu-multisite-plugins' ); ?></label>
                </th>
                <td><input type="checkbox" id="enable_custom_login" name="mu_options[enable_custom_login]" value="1"
                        <?php checked( MUMultisiteOptions::get( 'enable_custom_login' ) ); ?> /></td>
            </tr>
            <tr>
                <th><label
                        for="login_bg_url"><?php esc_html_e( 'Background Image URL', 'mu-multisite-plugins' ); ?></label>
                </th>
                <td><input type="text" class="regular-text" id="login_bg_url" name="mu_options[login_bg_url]"
                        value="<?php echo esc_url( MUMultisiteOptions::get( 'login_bg_url' ) ); ?>" /></td>
            </tr>
            <tr>
                <th><label for="login_logo_url"><?php esc_html_e( 'Logo Image URL', 'mu-multisite-plugins' ); ?></label>
                </th>
                <td><input type="text" class="regular-text" id="login_logo_url" name="mu_options[login_logo_url]"
                        value="<?php echo esc_url( MUMultisiteOptions::get( 'login_logo_url' ) ); ?>" /></td>
            </tr>
        </table>

        <h2><?php esc_html_e( 'New Site Defaults & Permalinks', 'mu-multisite-plugins' ); ?></h2>
        <table class="form-table">
            <tr>
                <th><label
                        for="permalink_structure"><?php esc_html_e( 'Permalink Structure', 'mu-multisite-plugins' ); ?></label>
                </th>
                <td><input type="text" class="regular-text" id="permalink_structure"
                        name="mu_options[permalink_structure]"
                        value="<?php echo esc_attr( MUMultisiteOptions::get( 'permalink_structure' ) ); ?>" /></td>
            </tr>
            <tr>
                <th><label
                        for="disable_yearmonth"><?php esc_html_e( 'Disable Year/Month Upload Folders', 'mu-multisite-plugins' ); ?></label>
                </th>
                <td><input type="checkbox" id="disable_yearmonth" name="mu_options[disable_yearmonth]" value="1"
                        <?php checked( MUMultisiteOptions::get( 'disable_yearmonth' ) ); ?> /></td>
            </tr>
            <tr>
                <th><label
                        for="clean_default_content"><?php esc_html_e( 'Remove Default Content on Site Setup', 'mu-multisite-plugins' ); ?></label>
                </th>
                <td><input type="checkbox" id="clean_default_content" name="mu_options[clean_default_content]" value="1"
                        <?php checked( MUMultisiteOptions::get( 'clean_default_content' ) ); ?> /></td>
            </tr>
        </table>

        <h2><?php esc_html_e( 'General Toggles', 'mu-multisite-plugins' ); ?></h2>
        <table class="form-table">
            <tr>
                <th><label
                        for="enable_custom_dashboard"><?php esc_html_e( 'Enable Dashboard Welcome Panel', 'mu-multisite-plugins' ); ?></label>
                </th>
                <td><input type="checkbox" id="enable_custom_dashboard" name="mu_options[enable_custom_dashboard]"
                        value="1" <?php checked( MUMultisiteOptions::get( 'enable_custom_dashboard' ) ); ?> /></td>
            </tr>
            <tr>
                <th><label
                        for="disable_update_emails"><?php esc_html_e( 'Disable Update Emails', 'mu-multisite-plugins' ); ?></label>
                </th>
                <td><input type="checkbox" id="disable_update_emails" name="mu_options[disable_update_emails]" value="1"
                        <?php checked( MUMultisiteOptions::get( 'disable_update_emails' ) ); ?> /></td>
            </tr>
            <tr>
                <th><label
                        for="enable_quotes"><?php esc_html_e( 'Enable Admin Quotes', 'mu-multisite-plugins' ); ?></label>
                </th>
                <td><input type="checkbox" id="enable_quotes" name="mu_options[enable_quotes]" value="1"
                        <?php checked( MUMultisiteOptions::get( 'enable_quotes' ) ); ?> /></td>
            </tr>
        </table>

        <?php submit_button(); ?>
    </form>
</div>
<?php
    }
}

new MUMultisiteAdmin();

// Load Module Files dynamically from the `mu-plugins/mu-multisite-plugins` subdirectory or relative folder
$modules_dir = plugin_dir_path( __FILE__ ) . 'mu-multisite-plugins/';

$modules = [
    'boofola-custom-login.php',
    'custom-dashboard-message.php',
    'disable-annoying-email-notifications.php',
    'force-new-site-options.php',
    'it-gets-better.php',
    'default-site-structure.php',
];

foreach ( $modules as $module_file ) {
    $path = $modules_dir . $module_file;
    if ( file_exists( $path ) ) {
        require_once $path;
    }
}