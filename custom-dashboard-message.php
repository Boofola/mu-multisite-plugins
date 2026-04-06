<?php

/**
 * @package Custom-Dashboard-Message
 * @version 2.0.1
 * 
 * Plugin Name: Custom Dashboard Message
 * Plugin URI: https://boofolaworks.com/wordpress/plugins/mu-multisite-plugins/
 * Description: A little plugin to modify the default dashboard welcome message.
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

/**
 * Remove the default welcome dashboard message
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/

add_action( 'init', 'remove_panel' );

function remove_panel() {
remove_action( 'welcome_panel', 'wp_welcome_panel' );
}

/**
 * Custom welcome panel function
 *
 * @access      public
 * @since       1.0 
 * @return      void
 */
function boofola_wp_welcome_panel() { 

?>

<div class="custom-welcome-panel-content">
    <h3><?php _e( 'Welcome to your MyBoofola Dashboard!' ); ?></h3>
    <p class="about-description">
        <?php _e( 'Here you can create and manage your content, customize your site, and explore various features.' ); ?>
    </p>
    <div class="welcome-panel-column-container">
        <div class="welcome-panel-column">
            <h4><?php _e( "Let's Get Started" ); ?></h4>
            <a class="button button-primary button-hero load-customize hide-if-no-customize"
                href="https://myboofola.com"><?php _e( 'Call me maybe !' ); ?></a>
            <p class="hide-if-no-customize">
                <?php printf( __( 'or, <a href="%s">edit your site settings</a>' ), admin_url( 'options-general.php' ) ); ?>
            </p>
        </div><!-- .welcome-panel-column -->
        <div class="welcome-panel-column">
            <h4><?php _e( 'Next Steps' ); ?></h4>
            <ul>
                <?php if ( 'page' == get_option( 'show_on_front' ) && ! get_option( 'page_for_posts' ) ) : ?>
                <li><?php printf( '<a href="%s" class="welcome-icon welcome-edit-page">' . __( 'Edit your front page' ) . '</a>', get_edit_post_link( get_option( 'page_on_front' ) ) ); ?>
                </li>
                <li><?php printf( '<a href="%s" class="welcome-icon welcome-add-page">' . __( 'Add additional pages' ) . '</a>', admin_url( 'post-new.php?post_type=page' ) ); ?>
                </li>
                <?php elseif ( 'page' == get_option( 'show_on_front' ) ) : ?>
                <li><?php printf( '<a href="%s" class="welcome-icon welcome-edit-page">' . __( 'Edit your front page' ) . '</a>', get_edit_post_link( get_option( 'page_on_front' ) ) ); ?>
                </li>
                <li><?php printf( '<a href="%s" class="welcome-icon welcome-add-page">' . __( 'Add additional pages' ) . '</a>', admin_url( 'post-new.php?post_type=page' ) ); ?>
                </li>
                <li><?php printf( '<a href="%s" class="welcome-icon welcome-write-blog">' . __( 'Add a blog post' ) . '</a>', admin_url( 'post-new.php' ) ); ?>
                </li>
                <?php else : ?>
                <li><?php printf( '<a href="%s" class="welcome-icon welcome-write-blog">' . __( 'Write your first blog post' ) . '</a>', admin_url( 'post-new.php' ) ); ?>
                </li>
                <li><?php printf( '<a href="%s" class="welcome-icon welcome-add-page">' . __( 'Add an About page' ) . '</a>', admin_url( 'post-new.php?post_type=page' ) ); ?>
                </li>
                <?php endif; ?>
                <li><?php printf( '<a href="%s" class="welcome-icon welcome-view-site">' . __( 'View your site' ) . '</a>', home_url( '/' ) ); ?>
                </li>
            </ul>
        </div><!-- .welcome-panel-column -->
        <div class="welcome-panel-column welcome-panel-last">
            <h4><?php _e( 'More Actions' ); ?></h4>
            <ul>
                <li><?php printf( '<div class="welcome-icon welcome-widgets-menus">' . __( 'Manage <a href="%1$s">widgets</a> or <a href="%2$s">menus</a>' ) . '</div>', admin_url( 'widgets.php' ), admin_url( 'nav-menus.php' ) ); ?>
                </li>
                <li><?php printf( '<a href="%s" class="welcome-icon welcome-comments">' . __( 'Turn comments on or off' ) . '</a>', admin_url( 'options-discussion.php' ) ); ?>
                </li>
                <li><?php printf( '<a href="%s" class="welcome-icon welcome-learn-more">' . __( 'Learn more about getting started' ) . '</a>', __( 'http://codex.wordpress.org/First_Steps_With_WordPress' ) ); ?>
                </li>
            </ul>
        </div><!-- .welcome-panel-column welcome-panel-last -->
    </div><!-- .welcome-panel-column-container -->
</div><!-- .custom-welcome-panel-content -->

<?php }

add_action( 'welcome_panel', 'boofola_wp_welcome_panel' );


/* Stop Adding Functions Below this Line */

?>