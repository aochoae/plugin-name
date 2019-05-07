<?php
/**
 * @package PluginName\Admin\Page
 */

namespace PluginName\Admin\Page;

/**
 * Settings class.
 *
 * @since 1.0.0
 */
class Settings
{
    /**
     * Singleton instance
     *
     * @since 1.0.0
     * @var Settings
     */
    private static $instance;

    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    private function __construct()
    {
        add_action( 'admin_init', [ $this, 'settings' ] );
    }

    /**
     * The singleton method.
     *
     * @since 1.0.0
     *
     * @return Settings
     */
    public static function init(): Settings
    {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new Settings;
        }

        return self::$instance;
    }

    /**
     * Registers a setting.
     *
     * @since 1.0.0
     */
    public function settings()
    {
        /* Settings */
        $args = [
            'type'              => 'string',
            'sanitize_callback' => [ $this, 'sanitize' ],
            'show_in_rest'      => false,
            'default'           => []
        ];
        register_setting( 'plugin_name_general', 'plugin_name_general', $args );
    }

    /**
     * Sanitizes the settings' values.
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function sanitize( $input )
    {
        return $input;
    }

    /**
     * The main settings page.
     *
     * @since 1.0.0
     */
    public function render()
    {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        ?>

        <div class="wrap">

            <?php settings_errors(); ?>

            <h1 class="wp-heading-inline"><?php esc_html_e( 'General Settings', 'plugin-name' ); ?></h1>

            <form action="<?php echo admin_url( 'options.php' ); ?>" method="post">

                <?php settings_fields( 'plugin_name_general' ); ?>

                <?php submit_button(); ?>

            </form>

        </div>

        <?php
    }

    /**
     * Adds a tab to the contextual help menu in the current screen.
     *
     * @since 1.0.0
     */
    public function help()
    {
        $screen = get_current_screen();

        $tab = [
            'id'       => 'id-help',
            'title'    => esc_html__( 'Help!', 'plugin-name' ),
            'priority' => 10,
            'content'  => '<p><strong>Help!</strong> was nominated in the category of Album of the Year at the 1966 Grammys Awards (<a href="https://en.wikipedia.org/wiki/Help!">Wikipedia</a>).</p>'
        ];
        $screen->add_help_tab( $tab );

        $sidebar = '<p><strong>' . esc_html__( 'For more information:', 'plugin-name' ) . '</strong></p>' .
            '<p><a href="https://developer.wordpress.org/reference/classes/wp_screen/" target="_blank">WP_Screen</a></p>';
        $screen->set_help_sidebar( $sidebar );
    }
}
