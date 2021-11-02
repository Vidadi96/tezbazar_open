<?php if(!$rec_pass): ?>

  <form action="/pages/rec_pass" method="post">
    <input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

    <div class="col-lg-4 col-md-6 col-sm-6">
      <label class="rec_title" for="rec_mail"><?=$this->langs->email; ?>:</label>
      <input type="text" class="form-control m-input" name="rec_mail" id="rec_mail" placeholder="<?=$this->langs->enter_email; ?>">
      <div class="row" style="margin-top: 10px;">
    		<div class="col-lg-12" style="float: right">
    			<button style="float: right" type="submit" class="btn btn-success"><?=$this->langs->send; ?></button>
    		</div>
    	</div>
    </div>
  </form>

<?php else: ?>

  <form action="/pages/cng_pass" method="post">
    <input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

    <div class="col-lg-4 col-md-6 col-sm-6">
      <label class="rec_title" for="new_pass"><?=$this->langs->new_password2; ?>:</label>
      <input type="hidden" class="form-control m-input" name="lp" value="<?=$rec_pass; ?>">
      <input type="hidden" class="form-control m-input" name="mail" value="<?=$mail; ?>">
      <input type="password" class="form-control m-input" name="new_password" id="new_pass" placeholder="<?=$this->langs->new_password2; ?> ...">
      <input type="password" style="margin-top: 5px" class="form-control m-input" name="confirm_new_password" placeholder="<?=$this->langs->repeat_password; ?> ...">
      <div class="row" style="margin-top: 10px;">
    		<div class="col-lg-12" style="float: right">
    			<button style="float: right" type="submit" class="btn btn-success"><?=$this->langs->change; ?></button>
    		</div>
    	</div>
    </div>
  </form>

<?php endif;?>
