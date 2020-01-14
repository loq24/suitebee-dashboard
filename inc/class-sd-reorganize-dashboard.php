<?php 
/**
 * Reorganize default dashboard 
 */

 # Exit if accessed directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class SD_Reorganize_Dashboard{
  
  const WUAPC_ADMIN_PAGE_SLUG = 'wuapc-page';
  const DASHBOARD_PAGE = 'index.php';
  const ALLOWED_DEFAULT_TOOLBAR_ITEMS = ['my-account', 'logout'];

  static function do_all_hooks() {

    if(!is_main_site()){
      add_action('admin_enqueue_scripts', array( __CLASS__, 'main_theme_style'));
      add_action('admin_menu', array( __CLASS__, 'clean_up_admin_menus' ));
      add_action('admin_bar_menu', array( __CLASS__, 'clean_up_admin_toolbar'), 90);
      add_action('admin_bar_menu', array( __CLASS__, 'add_sd_toolbar_items'), 91); 
      add_action('admin_bar_menu', array( __CLASS__, 'replace_howdy'), 25); 
      add_action('admin_menu', array(__CLASS__, 'add_saved_submenus'), 999);
    }

  }

  /**
   * Enqueue custom dashboard styling
   */
  static function main_theme_style() {    

      wp_enqueue_style('sd-dashboard-theme', SD_ASSET_DIR_URL .'/css/sd-dashboard-theme.css' , false, SD_VERSION);
      
  }

  /**
   * Clean up default & plugin generated admin pages
   */
  static function clean_up_admin_menus(){
    global $menu;
    foreach($menu as $key => $admin_menu){
      $filtered_menu[] = (strpos($admin_menu[2], self::WUAPC_ADMIN_PAGE_SLUG) !== false || strpos($admin_menu[2], self::DASHBOARD_PAGE) !== false) ? $admin_menu : null;
    }
    $menu = $filtered_menu;
  }

  /**
   * Remove default admin toolbar links
   */
  static function clean_up_admin_toolbar($wp_adminbar) {
    foreach($wp_adminbar->get_nodes() as $key => $admin_bar){
      if(!in_array($admin_bar->id, self::ALLOWED_DEFAULT_TOOLBAR_ITEMS) && !in_array($admin_bar->parent, self::ALLOWED_DEFAULT_TOOLBAR_ITEMS)){
        $wp_adminbar->remove_node($admin_bar->id);
      }
    }
  }

  /**
   * Add Suitebee dashboard custom toolbar items
   */
  static function add_sd_toolbar_items($wp_admin_bar){
    //SUITEBEE LOGO
    $wp_admin_bar->add_node( array(
      'id'        => 'suitebee-logo',
      'title' => '<div id="suitebee-admin-logo"></div>',
      'href' => get_site_url(1)."/dashboard",
      'meta'  => array( 'class' => 'woo-toolbar-item suitebee-logo-item' )
    ));

    //SETTINGS ICON
    $wp_admin_bar->add_node( array(
      'parent'    => 'top-secondary',
      'id'        => 'suitebee-settings-icon',
      'title' => '<div id="suitebee-settings-icon"></div>',
      'href' => get_admin_url()."options-general.php",
      'meta'  => array( 'class' => 'woo-toolbar-item suitebee-settings-icon' )
    ));

    //NOTIFICATION ICON
    $wp_admin_bar->add_node( array(
      'parent'    => 'top-secondary',
      'id'        => 'suitebee-notification-icon',
      'title' => '<div id="suitebee-notification-icon"></div>',
      'href' => "#",
      'meta'  => array( 'class' => 'woo-toolbar-item suitebee-notification-icon' )
    ));

    //CLEAR CACHE BTN
    $wp_admin_bar->add_node( array(
      'parent'    => 'top-secondary',
      'id'        => 'suitebee-clear-cache-btn',
      'title' => '<div id="suitebee-clear-cache-btn"></div>',
      'href' => "#",
      'meta'  => array( 'class' => 'woo-toolbar-item suitebee-clear-cache-btn' )
    ));

    //MY SITES BTN
    $wp_admin_bar->add_node( array(
      'parent'    => 'top-secondary',
      'id'        => 'suitebee-my-sites-btn',
      'title' => '<div id="suitebee-my-sites-btn"></div>',
      'href' => get_admin_url(1)."my-sites.php",
      'meta'  => array( 'class' => 'woo-toolbar-item suitebee-my-sites-btn' )
    ));
  }

  /**
   * Add saved submenus to top level menus
   */
  static function add_saved_submenus(){
    global $submenu;
    $saved_submenu_data = SD_Submenu_Assignment::get_saved_submenu_data();
    foreach($saved_submenu_data as $key => $wpuapc_item){
      //this is needed in order to maintain the top level menu link
      $submenu[$key][] = array( '', 'manage_options', 'admin.php?page='.$key );
      foreach($wpuapc_item as $key2 => $submenu_item){
        $submenu[$key][] = array( $submenu_item['title'], 'manage_options', $submenu_item['page'] );  
      }
    }
  }

  /**
   * IMPORTANT: Temporary function. Should be deleted when moved to live.
   * 
   * Replaces WordPress Howdy text in the admin toolbar
   */
  static function replace_howdy( $wp_admin_bar ) {
    $my_account=$wp_admin_bar->get_node('my-account');
    $newtitle = str_replace( 'Howdy,', '', $my_account->title );            
    $wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => $newtitle,
    ) );
  }

}

SD_Reorganize_Dashboard::do_all_hooks();