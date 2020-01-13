<?php 
/**
 * Top Level Admin Page or WPUAPC generated pages contents
 *
 */

# Exit if accessed directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class SD_Main_Menu{
  
  static function do_all_hooks(){

    if(!is_main_site()){  
      add_action('admin_enqueue_scripts', array( __CLASS__, 'enqueue_styles'));
      add_action('admin_enqueue_scripts', array( __CLASS__, 'enqueue_scripts'));
      add_shortcode( 'sd-main-page-template', array(__CLASS__, 'template_shortcode' ));
    }

  }

  /**
   * Enqueue Main Page style
   */
  static function enqueue_styles(){
    
    wp_enqueue_style('main-page', SD_ASSET_DIR_URL .'/css/sd-main-menu.css', false, SD_VERSION);

  }

  /**
	 * Enqueue scripts
	 */
	static function enqueue_scripts(){

    wp_enqueue_script('sd-main-menu-page', SD_ASSET_DIR_URL .'/js/main-menu-page.js', false, SD_VERSION, true);
    
	}	

  /**
   * Template Shortcode
   */
  static function template_shortcode(){

    ob_start();
      $submenu_blocks = self::submenu_blocks();
      $submenu_assignment_page = get_admin_url(1).'admin.php?page='.SD_Submenu_Assignment::SD_SUBMENU_ASSIGNMENT_PAGE_SLUG;
      require( SD_VIEW_DIR_PATH . '/main-menu/main-menu.php');
    return ob_get_clean();

  }

  /**
   * Render all submenu blocks
   */
  static function submenu_blocks(){

    ob_start();
      $page_submenus = self::get_page_submenus();
      foreach($page_submenus as $key => $submenu){
        $title = $submenu['title'];
        $page = $submenu['page'];
        $icon_url = $submenu['icon_url'];
        require( SD_VIEW_DIR_PATH . '/main-menu/block.php');
      }
    return ob_get_clean();

  }

  /**
   * Get all saved submenus under the current Top Level menu
   */
  static function get_page_submenus(){

    $page_slug = $_GET['page']; 
    $saved_submenu_data = SD_Submenu_Assignment::get_saved_submenu_data();
    return $saved_submenu_data[$page_slug];
    
  }

}

SD_Main_Menu::do_all_hooks();