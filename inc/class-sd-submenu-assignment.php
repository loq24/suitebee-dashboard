<?php 
/**
 * Menu assignment admin page
 *
 * Assign admin menus to WPUAPC generated top level admin menu pages.
 *
 */

 # Exit if accessed directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class SD_Submenu_Assignment{
	
	const ADMIN_PAGE_NAME = 'Admin Subpages';
	const EXCLUDED_ADMIN_MENUS = ['Dashboard', self::ADMIN_PAGE_NAME, ''];
	const SD_SUBMENU_ASSIGNMENT_PAGE_SLUG = 'suitebee-admin-submenu-assignment';
	const SD_SUBMENU_ASSIGNMENT_OPTION_KEY = 'sd_submenu_assignment';
	const WPUAPC_POST_TYPE = 'wpultimo_admin_page';

  static function do_all_hooks(){
		if(is_main_site()){
			add_action('admin_enqueue_scripts', array( __CLASS__, 'enqueue_styles'));
			add_action('admin_enqueue_scripts', array( __CLASS__, 'enqueue_scripts'));
			add_action('admin_menu', array(__CLASS__, 'sd_submenu_assignment_hook'));
			add_action('wp_ajax_admin_submenu_save_action', array(__CLASS__, 'sd_submenu_save_action' ));
			add_action('wp_ajax_admin_submenu_reset_action', array(__CLASS__, 'sd_submenu_reset_action' ));
		}
	}

	/**
	 * Enqueue styles
	 */
	static function enqueue_styles(){
		wp_enqueue_style('submenu-assignment', SD_ASSET_DIR_URL .'/css/sd-submenu-assignment-page.css', false, SD_VERSION);
	}
	
	/**
	 * Enqueue scripts
	 */
	static function enqueue_scripts(){
		wp_enqueue_script('sortable-js', 'https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js', false, '1.10.2', true);
		wp_enqueue_script('submenu-assigment-page', SD_ASSET_DIR_URL .'/js/submenu-assignment-page.js', false, SD_VERSION, true);
		wp_enqueue_script('submenu-assignment-media-uploader', SD_ASSET_DIR_URL .'/js/wp-media-uploader.js', false, SD_VERSION, true);
		wp_enqueue_media();
	}	

	/**
	* Menu assignment hook
	*/
	static function sd_submenu_assignment_hook(){
		add_menu_page('Suitebee Admin Submenu Assignment', self::ADMIN_PAGE_NAME, 'read', self::SD_SUBMENU_ASSIGNMENT_PAGE_SLUG, array(__CLASS__, 'admin_submenu_assignment_view'), null, 3);
	}
		
	/**
	 * Menu assignment main view
	 */
	static function admin_submenu_assignment_view(){
		if ( current_user_can( 'manage_options' ) )  {
			$top_level_menu_data = self::show_top_level_menu_data();
			$available_submenus = self::show_all_available_submenus();
			require_once( SD_VIEW_DIR_PATH . '/submenu-assignment/submenu-assignment.php');
		}
	}

	/**
	 * Menu assignment item view
	 */
	static function admin_submenu_assignment_item_view($page, $title, $icon_url){
		require( SD_VIEW_DIR_PATH . '/submenu-assignment/submenu-item.php');
	}

	/**
	 * List all available submenus
	 */
	static function show_all_available_submenus(){
		ob_start();
			global $menu;
			foreach($menu as $key => $menu_item){ 
				if(in_array($menu_item[0], self::EXCLUDED_ADMIN_MENUS)) continue;
				if(!self::is_submenu_already_in_used($menu_item[2])) self::admin_submenu_assignment_item_view($menu_item[2], $menu_item[0], '');
			}
		return ob_get_clean();
	}

	/**
	 * Top level menu data
	 */
	static function show_top_level_menu_data(){
		ob_start();
			$wpuapc_admin_pages = self::get_all_wpuapc_admin_pages();
			$saved_menu_data = self::get_saved_submenu_data();

			foreach($wpuapc_admin_pages as $key => $top_level_admin_page): ?>
				<div class="list-group-item nested-1">
					<?php echo $top_level_admin_page->post_title; ?>
					<div
						class="list-group nested-sortable top-level-id-<?php echo $top_level_admin_page->ID; ?>"
						data-wpuapc-id="<?php echo $top_level_admin_page->ID; ?>"
					>
						<?php 
							$top_level_key = 'wuapc-page-'.$top_level_admin_page->ID;
							foreach($saved_menu_data as $key => $top_level_item){
								if($key === $top_level_key){
									foreach($top_level_item as $key2 => $item){
										self::admin_submenu_assignment_item_view($item['page'], $item['title'], $item['icon_url']); 
									}
								}
							} 
						?>
					</div>
				</div>
			<?php endforeach;
		return ob_get_clean();
	}


	/**
	 * Get all WPUAPC generated admin pages
	 */
	static function get_all_wpuapc_admin_pages(){
		global $post;
		return get_posts( ['numberposts' => -1,'post_type' => self::WPUAPC_POST_TYPE ] );
	}

	/**
	 * Get saved submenu data
	 */
	static function get_saved_submenu_data(){
		return get_network_option(null, self::SD_SUBMENU_ASSIGNMENT_OPTION_KEY);
	}

	/**
	 * Is submenu already in used
	 */
	static function is_submenu_already_in_used($page){
		$saved_data = self::get_saved_submenu_data();
		foreach($saved_data as $key => $top_level_item){
			foreach($top_level_item as $key2 => $item){
				if($item['page'] === $page) return true;
			}
		}
		return false;
	}

	/**
	 * AJAX action hook.
	 * 
	 * Saves submenu assignment data.
	 */
	static function sd_submenu_save_action(){
		$data = $_POST['data'];
		update_network_option(null, self::SD_SUBMENU_ASSIGNMENT_OPTION_KEY, $data);
		echo 1;
		wp_die(); 
	}

	/**
	 * AJAX action hook.
	 * 
	 * Resets submenu assignment data.
	 */
	static function sd_submenu_reset_action(){
		update_network_option(null, self::SD_SUBMENU_ASSIGNMENT_OPTION_KEY, '');
		echo 1;
		wp_die();
	}

}

SD_Submenu_Assignment::do_all_hooks();