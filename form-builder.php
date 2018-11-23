<?php
/**
 * Plugin Name: Form Builder
 * Plugin URI: https://github.com/teunrutten/wordpress-formbuilder
 * Description: Build custom forms using shortcodes
 * Author: Bureau Bright
 * Author URI: https://github.com/teunrutten/
 * Version: 2.0.0
 *
 * @package Wordpress
 * @subpackage FormBuilder
 */

namespace FormBuilder\Lib;
use \Cuisine\Wrappers\Field;

// Prevent direct file acces
if ( ! defined( 'ABSPATH' ) ) {
  header( 'Status: 403 Forbidden' );
  header( 'HTTP/1.1 403 Forbidden' );
  exit;
}


/**
 * Load form builder plugin files
 */
function loadPluginCallback() {
  // Set some constants
  define( 'FB_VERSION', '1.0.0' );
  define( 'FB_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
  define( 'FB_PLUGIN_FILE', __FILE__ );
  define( 'FB_PLUGIN_DIR', dirname( __FILE__  ) );

  require_once( FB_PLUGIN_DIR . '/vendor/autoload.php' );

  add_action( 'init', function () {
    new FormPostType();
    new Shortcodes();
    if ( is_admin() ) {
      new Admin();
    }
  } );

}

// Hook to plugins loaded
add_action( 'plugins_loaded', 'FormBuilder\Lib\\loadPluginCallback' );
