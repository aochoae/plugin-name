<?php
/**
 * @package PluginName\Admin\Page
 */

namespace PluginName\Admin\Page;

/**
 * About class.
 *
 * @since 1.0.0
 */
class About
{
    /**
     * Singleton instance
     *
     * @since 1.0.0
     * @var About
     */
    private static $instance;

    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    private function __construct()
    {
    }

    /**
     * The singleton method.
     *
     * @since 1.0.0
     *
     * @return About
     */
    public static function init(): About
    {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new About;
        }

        return self::$instance;
    }

    /**
     * "About" page.
     *
     * @since 1.0.0
     */
    public function render()
    {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $plugin = get_plugin_data( PLUGIN_NAME_FILE ); ?>

        <div id="about-page">

            <div id="masthead">
                <div class="container">
                    <h1 class="dashicons-before dashicons-smiley"><?php echo esc_html( $plugin['Name'] ); ?></h1>
                </div>
            </div>

            <div id="content">
                <div class="container">
                    <h2><?php esc_html_e( 'I hope this boilerplate helps you to write the best plugin possible.', 'plugin-name' ); ?></h2>
                </div>
            </div>

        </div>

        <?php
    }

    /**
     * Enqueue the admin stylesheets and scripts.
     *
     * @since 1.0.0
     */
    public function enqueue()
    {
        $stylesheet = sprintf( 'static/css/about.%s', ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? 'css' : 'min.css' );

        wp_enqueue_style( 'plugin-name-about', plugins_url( $stylesheet, PLUGIN_NAME_FILE ), [], null, 'all' );
    }
}
