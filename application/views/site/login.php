<div class="master-wrapper-content">
<div class="master-column-wrapper">
<div class="center-1">




<div class="page login-page">
    <div class="page-title">
        <h1><?=$this->langs->login_msg;?></h1>
    </div>


    <?php if (isset($status)){?>
    <div class="alert alert-<?=$status["status"];?>">
      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
      <h4 class="alert-heading"><?=$status["title"];?></h4>
      <?=$status["msg"];?>
    </div>
  <?php }
    if(!$this->session->userdata("user_id")){ ?>
    <div class="page-body">
        <div class="customer-blocks">
            <div class="new-wrapper register-block tab_container">
                <div class="title register_tab">
                    <strong><?=$this->langs->new_customer;?></strong>
                </div>
                <div class="inner-wrapper registration-page login_container" style="padding: 0;">
                    <?=$register_form;?>
                </div>
            </div>
            <div class="returning-wrapper fieldset tab_container">
              <form action="/profile/login/" method="post">
                <input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <div class="title active login_tab">
                        <strong><?=$this->langs->returning_customer;?></strong>
                    </div>
                    <div class="inner-wrapper show register_container">
                        <div class="form-fields">
                                <div class="inputs">
                                    <label for="email"><?=$this->langs->email;?>:</label>
                                    <input autofocus="autofocus" class="email" data-val="true" data-val-email="Wrong email" data-val-required="<?=$this->langs->v_email;?>" id="email" name="email" type="text" value="<?=$this->input->post("email");?>" />
                                    <span class="field-validation-valid" data-valmsg-for="email" data-valmsg-replace="true"></span>
                                </div>
                            <div class="inputs">
                                <label for="password"><?=$this->langs->pass;?>:</label>
                                <input class="password" data-val-required="<?=$this->langs->v_pass;?>" data-val="true" id="password" name="password" type="password" value="<?=$this->input->post("password");?>" />
                                <span class="field-validation-valid" data-valmsg-for="password" data-valmsg-replace="true"></span>
                            </div>
                            <div class="captcha-box">
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
                            <div class="inputs reversed">
                                <input data-val="true" data-val-required="Вредноста на &#39;Remember Me&#39; не треба да биде празна." id="RememberMe" name="rememberme" <?=$this->input->post("rememberme")?'checked':'';?> type="checkbox" value="true" /><input name="RememberMe" type="hidden" value="false" />
                                <label for="RememberMe"><?=$this->langs->remember_me;?></label>
                                <span class="forgot-password">
                                    <a href="/passwordrecovery"><?=$this->langs->forget_pass;?>?</a>
                                </span>
                            </div>
                        </div>
                        <div class="buttons">
                            <input class="button-1 login-button" type="submit" value="<?=$this->langs->login;?>"/>
                        </div>
                    </div>
</form>            </div>
        </div>




    </div>
    <?php } ?>
</div>


</div>

        </div>

    </div>
