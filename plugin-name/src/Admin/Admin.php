<?php
/**
 * @package PluginName\Admin
 */

namespace PluginName\Admin;

use PluginName\Loader;
use PluginName\Admin\Page\Settings;

/**
 * Admin class.
 *
 * @since 1.0.0
 */
class Admin
{
    /**
     * @since 1.0.0
     * @var string
     */
    private $plugin_file = null;

    /**
     * @since 1.0.0
     * @var string
     */
    private $plugin_slug = null;

    /**
     * Singleton instance
     *
     * @since 1.0.0
     * @var Admin
     */
    private static $instance;

    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    private function __construct( Loader $loader )
    {
        $this->plugin_file = $loader->getFile();
        $this->plugin_slug = $loader->getSlug();

        add_action( 'admin_menu', [ $this, 'menu' ] );
        add_action( 'admin_init', [ $this, 'action' ] );
    }

    /**
     * The singleton method.
     *
     * @since 1.0.0
     *
     * @return Admin
     */
    public static function init( Loader $loader ): Admin
    {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new Admin( $loader );
        }

        return self::$instance;
    }

    /**
     * Adds the admin menus.
     *
     * @since 1.0.0
     */
    public function menu()
    {
        global $menu, $submenu;

        $menu[35] = [
            0 => '',
            1 => 'read',
            2 => 'separator35',
            3 => '',
            4 => 'wp-menu-separator'
        ];

        /* General settings */
        $settings_slug = sprintf( '%s/settings.php', $this->plugin_slug );

        $settings_page = Settings::init();

        $settings = add_menu_page(
            esc_html__( 'Plugin Name Settings', 'plugin-name' ),
            esc_html__( 'Plugin Name', 'plugin-name' ),
            'manage_options',
            $settings_slug,
            [ $settings_page, 'render' ],
            'dashicons-smiley',
            '99.074074'
        );

        add_action( "load-$settings", [ $settings_page, 'help' ] );

        /* About page */
        $about_slug = sprintf( '%s/about.php', $this->plugin_slug );

        $about = add_submenu_page(
            $settings_slug,
            esc_html__( 'About Plugin Name', 'plugin-name' ),
            esc_html__( 'About', 'plugin-name' ),
            'manage_options',
            $about_slug,
            [ 'PluginName\Admin\Page\About', 'render' ]
        );

        /* Changes the string of the submenu */
        $submenu[ $settings_slug ][0][0] = esc_html_x( 'General', 'settings screen', 'plugin-name' );
    }

    /**
     * Adds Settings link to plugins area.
     *
     * @since 1.0.0
     */
    public function action()
    {
        add_filter( 'plugin_action_links', function( $actions, $plugin_file, $plugin_data, $context ) {

            if ( $this->plugin_file !== $plugin_file ) {
                return $actions;
            }

            $new_actions = [];

            $settings = add_query_arg( [
                'page' => sprintf( '%s/settings.php', $this->plugin_slug )
            ], network_admin_url( 'admin.php' ) );

            $new_actions['settings'] = sprintf( '<a href="%s">%s</a>', esc_url( $settings ), esc_html__( 'Settings', 'plugin-name' ) );

            $about = add_query_arg( [
                'page' => sprintf( '%s/about.php', $this->plugin_slug )
            ], network_admin_url( 'admin.php' ) );

            $new_actions['about'] = sprintf( '<a href="%s">%s</a>', esc_url( $about ), esc_html__( 'About', 'plugin-name' ) );

            return array_merge( $actions, $new_actions );
        }, 10, 4 );
    }
}
