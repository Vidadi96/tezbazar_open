
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
                <?=$this->langs->new_provider; ?>
              </h3>
            </div>
          </div>
        </div>
        <form action="/provider/add_provider" method="post" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
          <div class="m-portlet__body">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="form-group m-form__group row">
              <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                <label for="corporate_name" class="control-label"><?=$this->langs->corporate_name; ?></label>
                <input type="text" class="form-control m-input" id="corporate_name" name="corporate_name" required>
              </div>
              <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                <label for="full_name" class="control-label"><?=$this->langs->fullname; ?></label>
                <input type="text" class="form-control m-input" id="full_name" name="full_name" required>
              </div>
              <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                <label for="phone" class="control-label"><?=$this->langs->number2; ?></label>
                <input type="text" class="form-control m-input number_format" id="phone" name="phone" required>
              </div>
            </div>
          </div>
          <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
              <div class="row">
                <div class="col-lg-12 m--align-right">
                  <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> <?=$this->langs->add; ?></button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
      <div class="text-center">
         <ul class="pagination pagination-lg text-center" style="display: inline-flex;">
            <?=@$pagination;?>
         </ul>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

$('.number_format')

  .keydown(function (e) {
    var key = e.which || e.charCode || e.keyCode || 0;
    $phone = $(this);

    // Don't let them remove the starting '('
    if ($phone.val().length === 1 && (key === 8 || key === 46)) {
      $phone.val('(');
      return false;
    }
    // Reset if they highlight and type over first char.
    else if ($phone.val().charAt(0) !== '(') {
      $phone.val('('+String.fromCharCode(e.keyCode)+'');
    }

    // Auto-format- do not expose the mask as the user begins to type
    if (key !== 8 && key !== 9) {
      if ($phone.val().length === 4) {
        $phone.val($phone.val() + ')');
      }
      if ($phone.val().length === 5) {
        $phone.val($phone.val() + ' ');
      }
      if ($phone.val().length === 9) {
        $phone.val($phone.val() + '-');
      }
      if ($phone.val().length === 12) {
        $phone.val($phone.val() + '-');
      }
      if ($phone.val().length > 14) {
        $phone.val($phone.val().substr(0, $phone.val().length-1));
      }
    }

    // Allow numeric (and tab, backspace, delete) keys only
    return (key == 8 ||
        key == 9 ||
        key == 46 ||
        (key >= 48 && key <= 57) ||
        (key >= 96 && key <= 105));
  })

  .bind('focus click', function () {
    $phone = $(this);

    if ($phone.val().length === 0) {
      $phone.val('(');
    }
    else {
      var val = $phone.val();
      $phone.val('').val(val); // Ensure cursor remains at the end
    }
  })

  .blur(function () {
    $phone = $(this);

    if ($phone.val() === '(') {
      $phone.val('');
  }
});

</script>
