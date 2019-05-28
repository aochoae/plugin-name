<?php
/**
 * @package PluginName
 */

namespace PluginName;

defined( 'ABSPATH' ) || exit;

use PluginName\Admin\Admin;

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

        /* WordPress 5.1 */
        add_action( 'plugin_loaded', [ $this, 'plugin' ] );

        add_action( 'plugins_loaded', [ $this, 'plugins' ] );

        if ( is_admin() ) {
            add_action( 'init', [ $this, 'admin' ] );
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
        Admin::newInstance( $this );
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
