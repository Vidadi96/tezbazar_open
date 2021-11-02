<table id="pd_table">
  <tr>
    <td class="first_td"><?=$this->langs->fullname; ?>:</td>
    <td class="second_td"><?=$pd_list->firstname?$pd_list->firstname." ".$pd_list->lastname." ".$pd_list->middlename:$pd_list->lastname; ?></td>
  </tr>
  <?php if($pd_list->company_name): ?>
    <tr>
      <td class="first_td"><?=$this->langs->corporate_name; ?>:</td>
      <td class="second_td"><?=$pd_list->company_name; ?></td>
    </tr>
  <?php endif; ?>
  <tr>
    <td class="first_td"><?=$this->langs->phone; ?>:</td>
    <td class="second_td"><?=$pd_list->phone; ?></td>
  </tr>
  <tr>
    <td class="first_td"><?=$this->langs->change_password; ?>:</td>
    <td class="second_td">
      <form action="/pages/change_password" method="post">
        <input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <input class="form-control" type="password" name="last_password" value="" placeholder="Last password...">
        <input style="margin-top: 3px" class="form-control" type="password" name="new_password" value="" placeholder="New password...">
        <input style="margin-top: 3px" class="form-control" type="password" name="confirm_password" value="" placeholder="Confirm password...">

        <button style="float: right; margin-top: 5px" type="submit" class="btn btn-success" name="button"><?=$this->langs->change; ?></button>
      </form>
    </td>
  </tr>
</table>
