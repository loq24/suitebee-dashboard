jQuery(document).ready(function($) {
  const menu_data = {};

  $('#save-menu-list').click(function() {
    const _btn = $(this);
    _btn.attr('disabled', true);
    _btn.text('Saving...');

    $('#wpuapc-admin-pages .nested-sortable').each(function() {
      let dragged_data = [];
      const _this = $(this);
      const top_level_page_id = _this.data('wpuapc-id');

      $(_this)
        .find('div.list-group-item')
        .each(function(i) {
          const _this = $(this);
          const title = _this.find('span').text();
          const page = _this.data('page');
          const icon_url = _this
            .find('button.upload_image_button')
            .data('icon-url');
          dragged_data.push({
            title,
            page,
            icon_url
          });
        });
      menu_data[`wuapc-page-${top_level_page_id}`] = dragged_data;
    });

    $.post(
      ajaxurl,
      { action: 'admin_submenu_save_action', data: menu_data },
      function(response) {
        if (response === '1') {
          callback_message(_btn, 'Submenu data have been successfully saved!');
        }
      }
    );
  });

  $('#reset-menu-list').click(function() {
    const _btn = $(this);
    _btn.attr('disabled', true);
    _btn.text('Resetting...');

    $.post(ajaxurl, { action: 'admin_submenu_reset_action' }, function(
      response
    ) {
      if (response === '1') {
        callback_message(_btn, 'Submenu data have been successfully reset!');
        location.reload();
      }
    });
  });

  function callback_message(_btn, msg) {
    const notification_placeholder = $('.notification-msg-placeholder');
    notification_placeholder.text(msg);
    notification_placeholder.addClass('success');
    _btn.removeAttr('disabled');
    _btn.text('Save');
    setTimeout(function() {
      notification_placeholder.text('');
      notification_placeholder.removeClass('success');
    }, 3000);
  }
});

var nestedSortables = [].slice.call(
  document.querySelectorAll('.nested-sortable')
);

for (var i = 0; i < nestedSortables.length; i++) {
  new Sortable(nestedSortables[i], {
    group: 'nested',
    handle: '.handle',
    animation: 150,
    fallbackOnBody: true,
    swapThreshold: 0.5,
    emptyInsertThreshold: 8,
    ghostClass: 'placeholder-el',
    chosenClass: 'sortable-chosen',
    dragClass: 'sortable-drag',
    onAdd: function(evt) {
      console.log('itemEl', evt.item);
      jQuery(evt.item)
        .find('span')
        .find('span')
        .remove();
      // console.log('To', evt.to.getAttribute('data-wpuapc-id'));
    },
    onMove: function(evt, originalEvent) {
      // console.log('onMove evt', evt.to);
      // console.log('itemEl', evt.item.getAttribute('data-url'));
      // console.log('To', evt.to.getAttribute('data-wpuapc-id'));
    },
    onUpdate: function(evt) {
      // same properties as onEnd
    }
  });
}
