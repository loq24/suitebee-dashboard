<div class="list-group-item" data-page="<?php echo $page; ?>">
  <span contenteditable="true"><?php echo $title; ?></span>
  <div class="handle">
    <svg viewBox="0 0 32 32"><rect x="4" y="4" width="4" height="4"></rect><rect x="4" y="12" width="4" height="4"></rect><rect x="4" y="20" width="4" height="4"></rect><rect x="4" y="28" width="4" height="4"></rect><rect x="12" y="4" width="4" height="4"></rect><rect x="12" y="12" width="4" height="4"></rect><rect x="12" y="20" width="4" height="4"></rect><rect x="12" y="28" width="4" height="4"></rect><rect x="20" y="4" width="4" height="4"></rect><rect x="20" y="12" width="4" height="4"></rect><rect x="20" y="20" width="4" height="4"></rect><rect x="20" y="28" width="4" height="4"></rect><rect x="28" y="4" width="4" height="4"></rect><rect x="28" y="12" width="4" height="4"></rect><rect x="28" y="20" width="4" height="4"></rect><rect x="28" y="28" width="4" height="4"></rect></svg>
  </div>
  <button class="upload_image_button" data-icon-url="<?php echo $icon_url; ?>" style="<?php echo $icon_url ? 'background-image:url('.$icon_url.')' : '';  ?>"></button>
</div>