<?php
/**
 * @package PluginName
 */

namespace PluginName;

use PluginName\Admin\Admin;

/**
 * Hook the WordPress plugin into the appropriate WordPress actions and filters.
 *
 * @since 1.0.0
 */
class Loader
{
	const VERSION = '1.0.0';

	private $plugin_file = '';

	private $plugin_slug = '';

	private static $instance;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	private function __construct( $plugin_file )
	{
		$this->plugin_file = $plugin_file;

		add_action( 'init', array( $this, 'loadTextdomain' ) );

		/* WordPress 5.1 */
		add_action( 'plugin_loaded', array( $this, 'plugin' ) );

		add_action( 'plugins_loaded', array( $this, 'plugins' ) );

		if ( is_admin() ) {
			add_action( 'init', array( $this, 'admin' ) );
		}
	}

	/**
	 * The singleton method.
	 *
	 * @since 1.0.0
	 *
	 * @return Loader
	 */
	public static function init( $plugin_file ): Loader
	{
		if ( ! isset( self::$instance ) ) {
			self::$instance = new Loader( $plugin_file );
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
		load_plugin_textdomain( 'plugin-name', false, dirname( plugin_basename( $this->plugin_file ) ) . '/languages' );
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
		Admin::init( $this );
	}

	/**
	 * Fires once activated plugin have loaded.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function plugin()
	{
	}

	/**
	 * Fires once activated plugins have loaded.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function plugins()
	{
	}

	/**
	 * Retrieve the basename of the plugin.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function getFile(): string
	{
		return $this->plugin_file;
	}

	/**
	 * Retrieve the slug of the plugin.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function getSlug(): string
	{
		return basename( $this->plugin_file, '.php' );
	}
}
