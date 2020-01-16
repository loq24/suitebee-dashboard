<?php 
/**
 * @package Suitebee Dashboard
 * @version 0.1.1
 */
/*
/*
Plugin Name: Suitebee Dashboard
Plugin URI: https://thewoo.com/
Description: Modifies the Wordpress admin toolbar and sidebar menus
Version: 0.1.1
Author: Lougie Quisel
Author URI: https://lougiequisel.com/
Text Domain: suitebee-dashboard
*/


# Exit if accessed directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'SD_VERSION', '0.1.1' );
define( 'SD_SLUG', 'suitebee-dashboard' );
define( 'SD_VIEW_DIR_PATH', plugin_dir_path( __FILE__ ) . 'views' );
define( 'SD_ASSET_DIR_URL', plugin_dir_url( __FILE__ ) . 'assets' );

/**
 * Require plugin core classes
 */
require( dirname(__FILE__) . '/inc/class-sd-theme.php' );
require( dirname(__FILE__) . '/inc/class-sd-main-menu.php' );
require( dirname(__FILE__) . '/inc/class-sd-submenu-assignment.php' );
require( dirname(__FILE__) . '/inc/class-sd-login-page.php' );

/**
 * Important configuration class
 */
final class Suitebee_Dashboard{

  static function init(){
    
    // display notice there is no added WPUAPC admin page yet
    if(is_main_site() && !SD_Submenu_Assignment::get_all_wpuapc_admin_pages() ){
      add_action( 'admin_notices', array(__CLASS__, 'admin_notice_minimum_elementor_version') );
    }

  }

  /**
  * Admin notice
  *
  * Warning when there is no added WPUAPC admin page yet
  *
  * @since 1.0.0
  *
  * @access public
  */
  static function admin_notice_minimum_elementor_version() {

    $message = sprintf(
      esc_html__( 'Make sure to add a top level admin page %1$s', SD_SLUG ),
      '<a href="'.esc_html__( get_admin_url(1).'network/admin.php?page=wp-ultimo-admin-pages', SD_SLUG ).'">here</a>'
    );

    printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

  }
}

Suitebee_Dashboard::init();