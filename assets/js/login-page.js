jQuery(document).ready(function($) {
  const label_text = $('label[for=user]').text();
  const label_pass = $('label[for=pass]').text();

  $('input#user').attr('placeholder', label_text);
  $('input#pass').attr('placeholder', label_pass);
});
