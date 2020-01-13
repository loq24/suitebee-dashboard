<div class="wrap">
  <h1>Suitebee Admin Submenu Assignment</h1>
  <?php echo $top_level_menu_data ? '<p>Drag and drop submenus from the right side to the top level menus in the left side.</p>' : ''; ?>
  
  <div id="sd-admin-submenu-assignment-page-main-wrapper">
    <div id="wpuapc-admin-pages" class="list-group col">
      <?php echo $top_level_menu_data; ?>
  
      <?php if($top_level_menu_data): ?>
        <div class="button-area">
          <div class="notification-msg-placeholder"></div>
          <button class="button button-primary" id="save-menu-list">Save</button>
          <button class="button" id="reset-menu-list">Reset</button>
        </div>
      <?php endif; ?>
    </div>
    <div id="wp-admin-pages" class="list-group col nested-sortable">
      <?php echo $available_submenus; ?>
    </div>    
  </div>
</div>