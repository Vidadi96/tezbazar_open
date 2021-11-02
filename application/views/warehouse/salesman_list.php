<div class="m-subheader ">
	<div class="d-flex align-items-center">
		<div class="mr-auto">
			<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
				<li class="m-nav__item m-nav__item--home">
					<a href="/slides/get_view_main/" class="m-nav__link m-nav__link--icon">
						<i class="m-nav__link-icon la la-home"></i>
					</a>
				</li>
			</ul>
			<h3 class="m-subheader__title m-subheader__title--separator">
				<?=$page_title; ?>
			</h3>
		</div>
	</div>
</div>
<!-- END: Subheader -->
	<div class="m-content">
		<div class="row">
			<div class="col-lg-12">
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
				<!--begin::Portlet-->
				<div class="m-portlet m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_2">
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
					<div class="m-portlet__body">
						<div class="m-section">
							<div class="m-section__content">

                <form action="/warehouse/salesman_list" method="post">
                  <input type="hidden" name="<?=$this->security->get_csrf_token_name(); ?>" value="<?=$this->security->get_csrf_hash(); ?>">

                  <div class="form-group m-form__group row">
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="corporate_name"><?=$this->langs->corporate_name; ?></label>
                        <input id="corporate_name" name="corporate_name" class="form-control m-input" placeholder="">
                      </div>
                    </div>

                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="fullname"><?=$this->langs->fullname; ?></label>
      									<input id="fullname" name="fullname" class="form-control m-input" placeholder="">
                      </div>
                    </div>

                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="phone"><?=$this->langs->contact_number; ?></label>
      									<input id="phone" name="phone" class="form-control m-input phone_format" placeholder="">
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-12 m--align-left">
                    <button type="submit_ru" class="btn btn-success"><i class="fa fa-plus"></i> <?=$this->langs->add; ?></button>
                  </div>

                </form>

							</div>
						</div>

					</div>
				</div>

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
            <table delete_url="/warehouse/delete_salesman/" class="table table-bordered m-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th><?=$this->langs->fullname; ?></th>
                  <th><?=$this->langs->corporate_name; ?></th>
                  <th><?=$this->langs->contact_number; ?></th>
                  <th><?=$this->langs->delete; ?></th>
                </tr>
              </thead>
              <tbody>
                <?php $i=0; foreach($salesman_list as $row): $i++; ?>
                  <tr>
                    <td><?=$i; ?></td>
                    <td><?=$row->fullname; ?></td>
                    <td><?=$row->corporate_name; ?></td>
                    <td><?=$row->phone; ?></td>
                    <td>
                      <button
                        class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only delete"
                        rel="<?=$row->id; ?>"
                      >
  											<i class="fa fa-trash"></i>
  										</button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
			</div>
		</div>
	</div>

<style media="screen">
  textarea{
    height: 80px;
  }
</style>


<script type="text/javascript">

    /*----- PHONE INPUT -----*/

  	$('.phone_format')

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
  			}

  			// Allow numeric (and tab, backspace, delete) keys only
  			if ($phone.val().length > 14)
  				return (key == 8 ||
  						key == 9 ||
  						key == 46 ||
  						(key >= 96 && key <= 105));
  			else
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
