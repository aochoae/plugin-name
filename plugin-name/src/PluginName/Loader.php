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
	const VERSION = '1.0.0';

	private $plugin = '';

	private static $instance;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	private function __construct( $plugin )
	{
		$this->plugin = $plugin;

		add_action( 'init', array( $this, 'loadTextdomain' ) );

		add_action( 'plugins_loaded', array( $this, 'loaded' ) );

		if ( is_admin() ) {
			add_action( 'init', array( $this, 'admin' ) );
		}
	}

	/**
	 * The singleton method.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function init( $plugin )
	{
		if ( ! isset( self::$instance ) ) {
			self::$instance = new Loader( $plugin );
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
		load_plugin_textdomain( 'plugin-name', false, dirname( plugin_basename( $this->plugin ) ) . '/languages' );
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
	}

	/**
	 * Fires once activated plugins have loaded.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function loaded()
	{
	}
}
