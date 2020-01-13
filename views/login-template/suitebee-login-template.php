<?php get_header(); ?>
<div class="suitebee-login-page-wrapper">

  <div class="suitebee-login-page__left">

    <div class="logo-area">
      <a href="<?php bloginfo('url'); ?>">
        <div id="suitebee-logo-big"></div>
      </a>
    </div>
    <div class="tagline-area">
      <h1>A dxp platform<br>powered by the Woo.</h1>
      <p>Musicale is one of the most popular and recognizable music<br>streaming apps ever.</p>
    </div>

  </div>

  <div class="suitebee-login-page__right">
    
    <?php 
      $action = $_GET['action'];

      if($action === 'lostpassword'){

        SD_Login_Page::lost_password_form();

      }
      else{

        echo '<h2>Login To Your Account</h2>';

        SD_Login_Page::show_login_notices();
    
        wp_login_form([
        'redirect' => get_admin_url(), 'id_username' => 'user', 'id_password' => 'pass', 'label_username' => 'Email or Username', 'label_password' => 'Password', 'label_log_in' => 'Login', 'remember' => true
        ]); 

        echo '<a href="'.SD_Login_Page::login_page_url().'?action=lostpassword" class="bottom-link">Lost your password?</a>';

      }
    ?>

  </div>

</div>
<?php get_footer(); ?>