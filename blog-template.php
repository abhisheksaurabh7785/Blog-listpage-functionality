<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://abc.com
 * @since             1.0.0
 * @package           Blog_Template
 *
 * @wordpress-plugin
 * Plugin Name:       Blog template 
 * Plugin URI:        https://abc.com
 * Description:       For making blog listing page with filter and no load on pagination, use shortcode [blog_listing_page_shortcode] on blog page.
 * Version:           1.0.0
 * Author:            Abhishek Tripathi
 * Author URI:        https://abc.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       blog-template
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BLOG_TEMPLATE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-blog-template-activator.php
 */
function activate_blog_template() {
	define('ABHI_DIRPATH', plugin_dir_path( __FILE__ ));
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-blog-template-activator.php';
	Blog_Template_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-blog-template-deactivator.php
 */
function deactivate_blog_template() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-blog-template-deactivator.php';
	Blog_Template_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_blog_template' );
register_deactivation_hook( __FILE__, 'deactivate_blog_template' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-blog-template.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_blog_template() {

	$plugin = new Blog_Template();
	$plugin->run();

}
run_blog_template();


// Define shortcode function
function abhi_custom_shortcode_function() {
	require plugin_dir_path( __FILE__ ) . 'public/partials/blog-listing.php';
}

// Register shortcode
add_shortcode('blog_listing_page_shortcode', 'abhi_custom_shortcode_function');