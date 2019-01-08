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
	 * Hooks and filters.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function init()
	{
		add_action( 'init', array( $this, 'loadTextdomain' ) );

		if ( is_admin() ) {
			add_action( 'init', array( $this, 'admin' ) );
		}
	}

	/**
	 * Load translated strings for the current locale.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function loadTextdomain() {
		load_plugin_textdomain( 'plugin-name' );
	}

	/**
	 * Hook into actions and filters for administrative interface page.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function admin() {
	}
}
