<div class="page-body" style="height: 600px;">






<form action="/contactus/submit_letter" method="post" class="modals">
  <input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
  <div class="fieldset">
                <div class="form-fields">
                    <div class="inputs">
                        <label for="fullname"><?=$this->langs->full_name;?> <span class="valid">*</span></label>
                        <input class="fullname" data-val="true" data-val-required="<?=$this->langs->required;?>" id="fullname" name="fullname" placeholder="" type="text" value="" />

                        <span class="field-validation-valid" data-valmsg-for="fullname" data-valmsg-replace="true"></span>
                    </div>
                    <div class="inputs">
                        <label for="email"><?=$this->langs->email;?> <span class="valid">*</span></label>
                        <input class="email" data-val="true" data-val-email="<?=$this->langs->wrong_email;?>" data-val-required="<?=$this->langs->required;?>" id="email" name="email" placeholder="" type="text" value="" />

                        <span class="field-validation-valid" data-valmsg-for="email" data-valmsg-replace="true"></span>
                    </div>
                    <div class="inputs" style="width: 100%;">
                        <label for="subject"><?=$this->langs->subject;?> <span class="valid">*</span></label>
                        <input class="subject" data-val="true" data-val-required="<?=$this->langs->required;?>" id="subject" name="subject" placeholder="" type="text" value="" />

                        <span class="field-validation-valid" data-valmsg-for="subject" data-valmsg-replace="true"></span>
                    </div>
                    <div class="inputs" style="width: 100%;">
                        <label for="msg"><?=$this->langs->msg;?><span class="valid">*</span></label>
                        <textarea class="enquiry" cols="20" data-val="true" data-val-required="<?=$this->langs->required;?>" id="msg" name="msg" placeholder="" rows="2">
                        </textarea>
                        <span class="field-validation-valid" data-valmsg-for="msg" data-valmsg-replace="true"></span>
                    </div>
                    <div class=captcha-box>
                      <?=$this->load->view("site/captcha", "", true);?>
                    </div>
                </div>
            </div>
            <div class="buttons">
                <input type="button" name="send-email" class="button-1 contact-us-button" value="<?=$this->langs->send;?>" />
            </div>
            <br />
            <div style="clear: both;"></div>
</form>
</div>
