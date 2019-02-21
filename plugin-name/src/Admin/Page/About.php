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
	 * "About" page.
	 *
	 * @since 1.0.0
	 */
	public static function render()
	{
	?>
		<div class="wrap">
			<h1 class="wp-heading-inline"><?php esc_html_e( 'About', 'plugin-name' ); ?></h1>
		</div>
	<?php
	}
}
