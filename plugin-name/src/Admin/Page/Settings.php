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
     * The main settings page.
     *
     * @since 1.0.0
     */
    public static function render()
    {
    ?>
        <div class="wrap">
            <h1 class="wp-heading-inline"><?php esc_html_e( 'Plugin Name', 'plugin-name' ); ?></h1>
        </div>
    <?php
    }

    /**
     * Adds a tab to the contextual help menu in the current screen.
     *
     * @since 1.0.0
     */
    public static function help()
    {
        $screen = get_current_screen();
        
        $screen->add_help_tab( [
            'id'      => 'id-help',
            'title'   => "Help!",
            'content' => '<p><strong>Help!</strong> was nominated in the category of Album of the Year at the 1966 Grammys Awards (<a href="https://en.wikipedia.org/wiki/Help!">Wikipedia</a>).</p>'
        ] );
    }
}
