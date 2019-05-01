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
            self::$instance = new About();
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

        <div class="wrap">

            <h1 class="wp-heading-inline"><?php echo esc_html( $plugin['Name'] ); ?></h1>

        </div>

        <?php
    }
}
