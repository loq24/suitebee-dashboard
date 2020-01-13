<form name="lostpasswordform" id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
  
  <p class="notice notice-normal">Please enter your username or email address. You will receive a link to create a new password via email.</p>
  
  <p class="lost-password">
      <input type="text" placeholder="Username or E-mail" name="user_login" id="user_login" class="input" value="" size="20" tabindex="10"></label>
  </p>
    
  <p class="submit">
    <input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Get New Password" tabindex="100">
  </p>

  <a class="bottom-link" href="<?php echo SD_Login_Page::login_page_url(); ?>">Log In</a>

  <input type="hidden" name="redirect_to" value="<?php echo SD_Login_Page::login_page_url(); ?>">

</form>