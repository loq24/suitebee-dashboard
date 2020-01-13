<?php 
/**
 * Custom Login Page
 * 
 * Replaces the default login page
 */

 # Exit if accessed directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class SD_Login_Page{
  
  const TEMPLATE_FILE_NAME = 'suitebee-login-template.php';
  const LOGIN_PAGE_BASE_URL = '/login';

  static function do_all_hooks(){
    
    add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_styles') );
    add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts') );
    add_filter( 'theme_page_templates', array(__CLASS__, 'sd_add_login_page_template') );
    add_filter( 'page_template', array(__CLASS__, 'sd_login_page_template') );
    add_action( 'init', array(__CLASS__, 'avoid_default_login_page') );
    add_action( 'wp_login_failed', array(__CLASS__, 'login_failed_redirect') );
    add_filter( 'authenticate', array(__CLASS__, 'blank_username_password_redirect'), 1, 3);
    add_action( 'wp_logout', array(__CLASS__, 'logout_page_redirect'));

  }

  /**
   * Enqueue login page style
   */
  static function enqueue_styles(){

    global $post;

    if(self::sd_login_page_id() === $post->ID){
      wp_enqueue_style('lato-font', 'https://fonts.googleapis.com/css?family=Lato&display=swap', false, SD_VERSION);
      wp_enqueue_style('roboto-font', 'https://fonts.googleapis.com/css?family=Roboto&display=swap', false, SD_VERSION);
      wp_enqueue_style('login-page', SD_ASSET_DIR_URL .'/css/sd-login-page.css', false, SD_VERSION);
    }

  }

  /**
   * Enqueue login page scripts
   */
  static function enqueue_scripts(){

    global $post;

    if(self::sd_login_page_id() === $post->ID){
      wp_enqueue_script('sd-login-page', SD_ASSET_DIR_URL .'/js/login-page.js', ['jquery'], SD_VERSION, true);
    }

  }

  /**
   * Add custom login page template
   * 
   * @return array Templates data
   */
  static function sd_add_login_page_template ($templates) {

    $templates[self::TEMPLATE_FILE_NAME] = 'Suitebee Login Template';
    return $templates;
    
  }

  /**
   * Point login page template to suitebee's template
   * 
   * @return string Suitebee's login template path
   */
  static function sd_login_page_template ($template) {

    $post = get_post();
    $page_template = get_post_meta( $post->ID, '_wp_page_template', true );

    if (self::TEMPLATE_FILE_NAME == basename ($page_template)){
      return SD_VIEW_DIR_PATH . '/login-template/' .self::TEMPLATE_FILE_NAME;
    }

  }

  /**
   * Get login page ID
   * 
   * @return int Page ID of /login page
   */
  static function sd_login_page_id(){

    return url_to_postid(self::login_page_url());

  }

  /**
   * Does /login page exists
   * 
   * @return boolean login page existing status
   */
  static function does_login_page_exists(){

    return self::sd_login_page_id() !== 0;

  }

  /**
   * Get login page url
   * 
   * @return string Login page URL
   */
  static function login_page_url(){

    return get_site_url() . self::LOGIN_PAGE_BASE_URL;

  }
  

  /**
   * Redirect to login page
   */
  static function avoid_default_login_page() {

    $page = basename($_SERVER['REQUEST_URI']);
    
    if( $page === "wp-login.php" && $_SERVER['REQUEST_METHOD'] === "GET" && $_GET['action'] !== 'lostpassword' && self::does_login_page_exists()) {
      self::login_page_redirect();
    }

  }

  /**
   * Redirect to login page when login fails
   */
  static function login_failed_redirect() {
    
    if(self::does_login_page_exists()){
      self::login_page_redirect( '?login=failed' );
    }

  }

  /**
   * Redirect to login page when the form is submitted with blank username OR password field
   */
  static function blank_username_password_redirect( $user, $username, $password ) {
    
    if( $username == "" || $password == "" && $_GET['action'] !== 'lostpassword' && self::does_login_page_exists()) {
      self::login_page_redirect( '?login=blank' );
    }

  }

  /**
   * Redirect to logion page after logging out
   */
  static function logout_page_redirect() {
    
    if(self::does_login_page_exists()){
      self::login_page_redirect( '?login=false' );
    }
    
  }

  /**
   * Redirect to login page
   */
  static function login_page_redirect($params = ''){

    wp_redirect( self::login_page_url() . $params );
    exit;

  }
  
  /**
   * Show custom Lost Password Form
   */
  static function lost_password_form(){

    require_once ( SD_VIEW_DIR_PATH . '/login-template/suitebee-lost-password-form.php' );

  }

  /**
   * Login error and warning messages
   * 
   * @return string Login & warning messages
   */
  static function show_login_notices(){

    $login = $_GET['login'];

    switch($login){
      case 'failed':
        echo '<p class="notice notice-error">Username or Password is incorrect.</p>';
        break;
      case 'blank':
        echo '<p class="notice notice-error">Make sure to provide Username & Password.</p>';
        break;
      case 'false':
        echo '<p class="notice notice-normal">You are now logged out.</p>';
        break;
    }

  }

}

SD_Login_Page::do_all_hooks();