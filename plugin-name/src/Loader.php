<?php
/**
 * @package PluginName
 */

namespace PluginName;

/**
 * Hook the WordPress plugin into the appropriate WordPress actions and filters.
 *
 * @since 1.0.0
 */
class Loader
{
    /**
     * Plugin version
     *
     * @since 1.0.0
     * @var string
     */
    const VERSION = '1.0.0';

    /**
     * The path to a plugin main file
     *
     * @since 1.0.0
     * @var string
     */
    private $plugin_file = '';

    /**
     * Singleton instance
     *
     * @since 1.0.0
     * @var Loader
     */
    private static $instance;

    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    private function __construct( $plugin_file )
    {
        $this->plugin_file = $plugin_file;

        add_action( 'init', [ $this, 'loadTextdomain' ] );

        add_action( 'init', [ $this, 'admin' ] );

        /* WordPress 5.1 */
        add_action( 'plugin_loaded', [ $this, 'plugin' ] );

        add_action( 'plugins_loaded', [ $this, 'plugins' ] );
    }

    /**
     * Cloning is forbidden.
     *
     * @since 1.0.0
     */
    public function __clone()
    {
        if ( WP_DEBUG ) {
            trigger_error( __( 'Cloning is forbidden.', 'plugin-name' ), E_USER_ERROR );
        }
    }

    /**
     * Unserializing instances of this class is forbidden.
     *
     * @since 1.0.0
     */
    public function __wakeup()
    {
        if ( WP_DEBUG ) {
            trigger_error( __( 'Unserializing instances of this class is forbidden.', 'plugin-name' ), E_USER_ERROR );
        }
    }

    /**
     * The singleton method.
     *
     * @since 1.0.0
     *
     * @return Loader
     */
    public static function newInstance( $plugin_file ): Loader
    {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new Loader( $plugin_file );
        }

        return self::$instance;
    }

    /**
     * Load translated strings for the current locale.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function loadTextdomain()
    {
        load_plugin_textdomain( 'plugin-name', false, dirname( $this->plugin_file ) . '/languages' );
    }

    /**
     * Hook into actions and filters for administrative interface page.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function admin()
    {
        /**
         * Do not show the admin toolbar if the current user is not allowed to
         * access WordPress administration
         */
        if ( ! current_user_can( 'edit_posts' ) ) {
            add_filter( 'show_admin_bar', '__return_false' );
        }

        /* Administration functionalities */
        if ( is_admin() ) {
            \PluginName\Admin\Admin::newInstance( $this );
        }
    }

    /**
     * Fires once activated plugin have loaded.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function plugin()
    {
    }

    /**
     * Fires once activated plugins have loaded.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function plugins()
    {
    }

    /**
     * Retrieve the basename of the plugin.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function getFile(): string
    {
        return $this->plugin_file;
    }

    /**
     * Retrieve the slug of the plugin.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function getSlug(): string
    {
        return basename( $this->plugin_file, '.php' );
    }
}
