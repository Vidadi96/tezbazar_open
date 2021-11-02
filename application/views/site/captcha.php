<div>
  <?php
  //6Lf9kc8UAAAAAI8XNnlKiZmkzGbGKURai6SGVBvA //KEY
  //6Lf9kc8UAAAAANNMlJUrfPOk2JOFDN_Am7ykp_4s //SECRET
  ?>
  <?php
    require_once ($this->config->item("server_root")."/recaptchalib.php");

    $lang = "az";
    // The response from reCAPTCHA
    $resp = null;
    $siteKey = "6Lf9kc8UAAAAAI8XNnlKiZmkzGbGKURai6SGVBvA";
    $secret = "6Lf9kc8UAAAAANNMlJUrfPOk2JOFDN_Am7ykp_4s";
    // The error code from reCAPTCHA, if any
    $error = null;
    $reCaptcha = new ReCaptcha($secret);

  ?>
  <div class="g-recaptcha" data-sitekey="<?php echo $siteKey;?>"></div>
  <script type="text/javascript"
      src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang;?>">
  </script>

</div>
