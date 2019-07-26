<?php
/**
 * @package PluginName\Admin
 */

namespace PluginName\Admin;

use PluginName\Loader;
use PluginName\Admin\Settings\General;
use PluginName\Admin\Settings\About;

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
        /* Properties */
        $this->plugin_file = $loader->getFile();
        $this->plugin_slug = $loader->getSlug();

        /* Prevents access to administration */
        add_action( 'admin_menu', [ $this, 'init' ] );

        /* Setting for super admins and administrators */
        if ( current_user_can( 'manage_options' ) ) {
            add_action( 'admin_menu', [ $this, 'menu' ] );
        }

        /* Plugins administration functionalities */
        if ( current_user_can( 'activate_plugins' ) ) {
            add_action( 'admin_init', [ $this, 'plugins' ] );
        }

        /* Setting for users with other roles and capabilities */
        //add_action( 'admin_menu', [ $this, 'foo' ] );
    }

    /**
     * The singleton method.
     *
     * @since 1.0.0
     *
     * @return Admin
     */
    public static function newInstance( Loader $loader ): Admin
    {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new Admin( $loader );
        }

        return self::$instance;
    }

    /**
     * Prevents access to administration.
     *
     * @since 1.0.0
     */
    public function init()
    {
        if ( ! current_user_can( 'edit_posts' ) || wp_doing_ajax() ) {
            wp_safe_redirect( esc_url( get_home_url() ) );
            exit;
        }
    }

    /**
     * Adds the admin menus.
     *
     * @since 1.0.0
     */
    public function menu()
    {
        /* Menu */
        global $menu, $submenu;

        $menu[35] = [
            0 => '',
            1 => 'read',
            2 => 'separator35',
            3 => '',
            4 => 'wp-menu-separator'
        ];

        /* General settings */
        $general_slug = sanitize_key( sprintf( '%s-settings', $this->plugin_slug ) );

        $general_page = General::newInstance();

        $general = add_menu_page(
            esc_html__( 'General Settings', 'plugin-name' ),
            esc_html__( 'Plugin Name', 'plugin-name' ),
            'manage_options',
            $general_slug,
            [ $general_page, 'render' ],
            'dashicons-smiley',
            '99.074074'
        );

        add_action( "load-$general", [ $general_page, 'help' ] );

        /* About page */
        $about_slug = sanitize_key( sprintf( '%s-about', $this->plugin_slug ) );

        $about_page = About::newInstance();

        $about = add_submenu_page(
            $general_slug,
            esc_html__( 'About Plugin Name', 'plugin-name' ),
            esc_html__( 'About', 'plugin-name' ),
            'manage_options',
            $about_slug,
            [ $about_page, 'render' ]
        );

        add_action( "load-$about", [ $about_page, 'enqueue' ] );

        /* Changes the string of the submenu */
        $submenu[ $general_slug ][0][0] = esc_html_x( 'General', 'settings screen', 'plugin-name' );
    }

    /**
     * Adds Settings link to plugins area.
     *
     * @since 1.0.0
     */
    public function plugins()
    {
        add_filter( 'plugin_action_links', function( $actions, $plugin_file, $plugin_data, $context ) {

            if ( $this->plugin_file !== $plugin_file ) {
                return $actions;
            }

            $new_actions = [];

            $settings = add_query_arg( [
                'page' => sanitize_key( sprintf( '%s-settings', $this->plugin_slug ) )
            ], network_admin_url( 'admin.php' ) );

            $new_actions['settings'] = sprintf( '<a href="%s">%s</a>', esc_url( $settings ), esc_html__( 'Settings', 'plugin-name' ) );

            $about = add_query_arg( [
                'page' => sanitize_key( sprintf( '%s-about', $this->plugin_slug ) )
            ], network_admin_url( 'admin.php' ) );

            $new_actions['about'] = sprintf( '<a href="%s">%s</a>', esc_url( $about ), esc_html__( 'About', 'plugin-name' ) );

            return array_merge( $actions, $new_actions );
        }, 10, 4 );

        add_filter( 'plugin_row_meta', function( $plugin_meta, $plugin_file, $plugin_data, $status ) {

            if ( $this->plugin_file !== $plugin_file ) {
                return $plugin_meta;
            }

            $new_meta = [
                sprintf( '<a href="%s">%s</a>', esc_url( 'https://example.com/' ), esc_html__( 'Documentation', 'plugin-name' ) ),
                sprintf( '<a href="%s">%s</a>', esc_url( 'https://example.com/wiki/' ), esc_html__( 'Wiki', 'plugin-name' ) )
            ];

            return array_merge( $plugin_meta, $new_meta );
        }, 10, 4 );
    }
}
