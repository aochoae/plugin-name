<?php
/**
 * @package PluginName\Admin\Settings
 */

namespace PluginName\Admin\Settings;

/**
 * About class.
 *
 * @since 1.0.0
 */
class About extends AbstractPage
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
    public static function newInstance(): About
    {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new About();
        }

        return self::$instance;
    }

    /**
     * {@inheritdoc}
     *
     * @since 1.0.0
     */
    public function render()
    {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $plugin = get_plugin_data( PLUGIN_NAME_FILE, false ); ?>

        <div id="about-page">

            <div id="masthead">
                <div class="container">
                    <h1 class="dashicons-before dashicons-smiley"><?php echo esc_html( $plugin['Name'] ); ?></h1>
                </div>
            </div>

            <div id="content">
                <div class="container">
                    <h2><?php echo wp_kses_post( $plugin['Description'] ); ?></h2>
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
        $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        wp_enqueue_style( 'plugin-name-about',
            plugins_url( "static/css/about$suffix.css", PLUGIN_NAME_FILE ),
            [],
            null
        );
    }
}
