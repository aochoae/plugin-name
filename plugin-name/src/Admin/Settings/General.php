<?php
/**
 * @package PluginName\Admin\Settings
 */

namespace PluginName\Admin\Settings;

/**
 * General class.
 *
 * @since 1.0.0
 */
class General extends AbstractPage
{
    /**
     * Singleton instance
     *
     * @since 1.0.0
     * @var General
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
     * @return General
     */
    public static function newInstance(): General
    {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new General();
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
        $option = [
            'type'              => 'string',
            'sanitize_callback' => [ $this, 'sanitize' ],
            'show_in_rest'      => false,
            'default'           => []
        ];
        register_setting( 'plugin_name_general', 'plugin_name_option', $option );

        $another_option = [
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'show_in_rest'      => false,
            'default'           => ''
        ];
        register_setting( 'plugin_name_general', 'plugin_name_another_option', $another_option );
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
     * {@inheritdoc}
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

            <form action="<?php echo esc_url( admin_url( 'options.php' ) ); ?>" method="post">

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
            'title'    => __( 'Help!', 'plugin-name' ),
            'priority' => 10,
            'content'  => '<p><strong>Help!</strong> was nominated in the category of Album of the Year at the 1966 Grammys Awards (<a href="https://en.wikipedia.org/wiki/Help!">Wikipedia</a>).</p>'
        ];
        $screen->add_help_tab( $tab );

        $sidebar = '<p><strong>' . __( 'For more information:', 'plugin-name' ) . '</strong></p>' .
            '<p><a href="https://developer.wordpress.org/reference/classes/wp_screen/" target="_blank">WP_Screen</a></p>';
        $screen->set_help_sidebar( $sidebar );
    }
}
