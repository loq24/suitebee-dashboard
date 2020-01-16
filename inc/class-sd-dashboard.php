<?php 
/**
 * Replaces the default Dashboard content 
 * 
 */

 # Exit if accessed directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class SD_Dashboard{

  static function do_all_hooks(){

    add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_styles' ) );
    add_shortcode( 'suitebee-dashboard', array( __CLASS__, 'dashboard_template' ) );
    add_shortcode( 'suitebee-dashboard-widgets', array( __CLASS__, 'dashboard_widgets' ) );

  }

  /**
   * Enqueue styles
   */
  static function enqueue_styles(){
    wp_enqueue_style('sd-dashboard', SD_ASSET_DIR_URL .'/css/sd-dashboard.css', false, SD_VERSION);
  }

  /**
   * Main dashboard template
   */
  static function dashboard_template(){
    ob_start();
      $quick_create = self::quick_create();
      $analytics = self::analytics();
      require_once( SD_VIEW_DIR_PATH . '/dashboard/dashboard.php' );
    return ob_get_clean();
  }

  /**
   * Quick Create section
   * 
   * @return String Quick Create content 
   */
  static function quick_create(){
    ob_start();
      require_once( SD_VIEW_DIR_PATH . '/dashboard/quick-create.php' );
    return ob_get_clean();
  }

  /**
   * Analytics section
   * 
   * @return String Analytics content 
   */
  static function analytics(){
    ob_start();
      $left_widgets = do_shortcode('[suitebee-dashboard-widgets type="normal"]');
      $right_widgets = do_shortcode('[suitebee-dashboard-widgets type="side"]');
      require_once( SD_VIEW_DIR_PATH . '/dashboard/analytics.php' );
    return ob_get_clean();
  }

  /**
   * Add shortcode that will show dashboard widgets
   *
   * type parameter can be 'normal', 'side', 'column3' or 'column4'
   * 
   * @return String Widget content 
   * 
   */
  static function dashboard_widgets( $atts ){
    $atts = shortcode_atts( array( 'type' => 'normal', 'screen' => 'dashboard'), $atts);

    ob_start();
        switch_to_blog( $GLOBALS['this_site_id'] );
            do_meta_boxes( $atts['screen'], $atts['type'], '' );
            $content = ob_get_contents();
        restore_current_blog();
    ob_end_clean();

    return $content;
  }

}

SD_Dashboard::do_all_hooks();