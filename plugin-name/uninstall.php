<?php
/**
 * @link https://developer.wordpress.org/plugins/the-basics/uninstall-methods/
 *
 * @package PluginName
 */

/* if uninstall.php is not called by WordPress, exit */
defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

/* Removes all cache items. */
wp_cache_flush();
