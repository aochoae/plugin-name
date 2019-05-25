<?php
/**
 * @package PluginName\Admin\Settings
 */

namespace PluginName\Admin\Settings;

defined( 'ABSPATH' ) || exit;

abstract class AbstractPage
{
    /**
     * Renders the HTML content.
     *
     * @since 1.0.0
     */
    abstract public function render();
}
