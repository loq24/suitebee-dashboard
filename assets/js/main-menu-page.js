jQuery(document).ready(function($) {
  /**
   * Make top level menu active when the submenu page is clicked
   */
  $('#adminmenu > li:has(li.current)')
    .removeClass('wp-not-current-submenu')
    .addClass('wp-has-current-submenu wp-menu-open');
});
