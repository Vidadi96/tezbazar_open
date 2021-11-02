<div class="scroll_div">
  <?php if (isset($edit_products)): ?>
    <table>
      <thead>
        <tr>
          <th width="5%" style="text-align: center">#</th>
          <th width="55%"><?=$this->langs->product_name; ?></th>
          <th width="10%"><?=$this->langs->price; ?></th>
          <th width="10%"><?=$this->langs->count; ?></th>
          <th width="10%" style="text-align: center"><?=$this->langs->edit; ?></th>
          <th width="10%" style="text-align: center"><?=$this->langs->delete2; ?></th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 0; foreach($edit_products as $row): $i++; ?>
          <tr>
            <td style="text-align: center"><?=$i; ?></td>
            <td><?=$row->p_name; ?></td>
            <td><?=$row->ex_price; ?> ₼</td>
            <td>
              <span class="edit_close" name="count_span"><?=$row->count." ".$row->measure; ?></span>
              <input type="text" class="form-control edit_open" name="count" value="<?=$row->count; ?>">
            </td>
            <td>
              <div class="flex-justify-center">
                 <button class="edit btn btn-primary btn-sm m-btn m-btn--icon m-btn--icon-only" name="<?=$row->id; ?>">
                   <i class="fa fa-pencil"></i>
                 </button>
              </div>
            </td>
            <td>
              <div class="flex-justify-center">
                <button class="delete btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only" name="<?=$row->id; ?>">
  								<i class="fa fa-trash"></i>
  							</button>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
<input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
