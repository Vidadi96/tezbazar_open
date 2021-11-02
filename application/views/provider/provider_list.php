
<div class="m-content">
  <div class="row">
    <div class="col-lg-12">
      <!--begin::Portlet-->
      <?php if(isset($status)): ?>
      <div class="m-alert m-alert--icon m-alert--outline alert alert-<?=$status['status'];?> alert-dismissible fade show" role="alert">
        <div class="m-alert__icon">
          <i class="fa fa-<?=$status['icon'];?>"></i>
        </div>
        <div class="m-alert__text">
          <strong><?=$status['title'];?> </strong> <?=$status['msg'];?>
        </div>
        <div class="m-alert__close">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
      <?php endif;?>
      <div class="m-portlet m-portlet--accent m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_2">
        <div class="m-portlet__head">
          <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
              <span class="m-portlet__head-icon m--hide">
                <i class="la la-gear"></i>
              </span>
              <h3 class="m-portlet__head-text">
                <?=$this->langs->providers_list; ?>
              </h3>
            </div>
          </div>
        </div>
        <div class="m-portlet__body">
          <table delete_url="/provider/delete_provider/" class="table table-bordered m-table" active_passive_url="/provider/active_passive/">
            <thead>
              <tr>
                <th>#</th>
                <th><?=$this->langs->fullname;?></th>
                <th><?=$this->langs->company_name;?></th>
                <th><?=$this->langs->number2;?></th>
                <th><?=$this->langs->active_passive;?></th>
                <th><?=$this->langs->delete;?></th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; ?>
              <?php foreach ($providers_list as $row):
                $word=$this->langs->do_passive."!"; $class="btn-success"; $active_passive=0;
                if($row->active_passive==0)
                {
                  $word=$this->langs->do_active."!";
                  $class="btn-danger";
                  $active_passive = 1;
                }
                $btn_active_passive ='<button active_passive="'.$active_passive.'" id="'.$row->id.'" type="button" data-container="body" data-skin="dark" data-toggle="m-popover" data-placement="right" data-content="'.$word.'" class="'.$class.' set_active_passive btn m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"></button>';
                 ?>
                <tr>
                  <td><?=$i; ?></td>
                  <td><?=$row->full_name; ?></td>
                  <td><?=$row->corporate_name; ?></td>
                  <td><?=$row->phone; ?></td>
                  <td>
                    <?=$btn_active_passive;?>
                  </td>
                  <td>
                    <button
                      class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only delete"
                      rel="<?=$row->id; ?>"
                    >
											<i class="fa fa-trash"></i>
										</button>
                  </td>
                </tr>
                <?php $i++; ?>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="text-center">
         <ul class="pagination pagination-lg text-center" style="display: inline-flex;">
            <?=@$pagination;?>
         </ul>
      </div>
    </div>
  </div>
</div>
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
