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
									<?=$this->langs->add_new_user; ?>
								</h3>
							</div>
						</div>
					</div>
					<div class="m-portlet__body">
						<div class="m-section">
							<div class="m-section__content">

                <form id="add_admin_user" action="/adm/add_admin_user" method="post">
                  <input type="hidden" name="<?=$this->security->get_csrf_token_name(); ?>" value="<?=$this->security->get_csrf_hash(); ?>">

                  <div class="form-group m-form__group row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label for="name"><?=$this->langs->user_name; ?></label>
                        <input id="name" name="name" class="form-control m-input">
                      </div>
                    </div>

                    <div class="col-lg-3">
                      <div class="form-group">
                        <label for="full_name"><?=$this->langs->fullname; ?></label>
                        <input id="full_name" name="full_name" class="form-control m-input">
                      </div>
                    </div>

                    <div class="col-lg-3">
                      <div class="form-group">
                        <label for="email"><?=$this->langs->email; ?></label>
      									<input id="email" name="email" class="form-control m-input">
                      </div>
                    </div>

                    <div class="col-lg-3">
                      <div class="form-group">
                        <label for="role_id"><?=$this->langs->role; ?></label>
                        <select class="form-control" id="role_id" name="role_id">
                          <option value=""></option>
                          <?php foreach($role_list as $row): ?>
                            <option value="<?=$row->id; ?>"><?=$row->name; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-lg-3">
    									<label><?=$this->langs->cinsi; ?></label>
    									<div class="m-radio-inline">
    										<label class="m-radio m-radio--solid">
    											<input type="radio" name="gender" checked="" value="1">
    											<?=$this->langs->man; ?>
    											<span></span>
    										</label>
    										<label class="m-radio m-radio--solid">
    											<input type="radio" name="gender" value="0">
    											<?=$this->langs->woman; ?>
    											<span></span>
    										</label>
    									</div>
    								</div>

                    <div class="col-lg-3">
                      <div class="form-group">
                        <label for="password"><?=$this->langs->pass; ?></label>
      									<input type="password" id="password" name="password" class="form-control m-input">
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
                  <?=$this->langs->user_list; ?>
                </h3>
              </div>
            </div>
          </div>
          <div class="m-portlet__body">
            <table delete_url="/adm/delete_admin_user/" class="table table-bordered m-table" active_passive_url="/adm/active_passive_admin_user/">
              <thead>
                <tr>
                  <th>#</th>
                  <th><?=$this->langs->user_name; ?></th>
                  <th><?=$this->langs->fullname; ?></th>
                  <th><?=$this->langs->email; ?></th>
                  <th><?=$this->langs->role; ?></th>
                  <th><?=$this->langs->gender; ?></th>
                  <th><?=$this->langs->active_passive; ?></th>
                  <th><?=$this->langs->delete; ?></th>
                </tr>
              </thead>
              <tbody>
                <?php $i=0; foreach ($users_list as $row): $i++; ?>
                  <?php
                    $word=$this->langs->do_passive."!"; $class="btn-success";
                    $active_passive = 0;
                    if(!$row->active)
                    {
                      $word=$this->langs->do_active."!";
                      $class="btn-danger";
                      $active_passive = 1;
                    }
                    $btn_active_passive ='<button id="'.$row->id.'" active_passive="'.$active_passive.'" type="button" data-container="body" data-skin="dark" data-toggle="m-popover" data-placement="right" data-content="'.$word.'" class="'.$class.' set_active_passive btn m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air show_unshow"></button>';
                  ?>
                  <tr>
                    <td><?=$i; ?></td>
                    <td><?=$row->name; ?></td>
                    <td><?=$row->full_name; ?></td>
                    <td><?=$row->email; ?></td>
                    <td><?=$row->role; ?></td>
                    <td><?=$row->gender==1?$this->langs->man:$this->langs->woman; ?></td>
                    <td><?=$btn_active_passive; ?></td>
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
  <input type="hidden" id="language_js" value="<?=$this->session->userdata('lang_id'); ?>">

<script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.validate.unobtrusive.min.js"></script>

<style media="screen">
  textarea{
    height: 80px;
  }
  .error{
    color: red !important;
    border-color: red;
  }
</style>


<script type="text/javascript">

  var validate_array = [];

  var required = [];
  required[2] = 'Bu xananın doldurulması vacibdir';
  required[1] = 'This field is required';
  required[3] = 'Заполните это поле';
  required[4] = 'Bu alanın doldurulması önemli';
  validate_array['required'] = required;

  var mail = [];
  mail[2] = 'Düzgün e-poçt daxil edin';
  mail[1] = 'Enter a valid mail';
  mail[3] = 'Введите правильный е-мейл';
  mail[4] = 'Geçerli bir mail girin';
  validate_array['mail'] = mail;

  var minlength_6 = [];
  minlength_6[2] = 'Bu xanaya 6 simvoldan az simvol daxil edilə bilməz';
  minlength_6[1] = 'This field must have more than 6 symbols';
  minlength_6[3] = 'Это поле должно содержать больше 6 символов';
  minlength_6[4] = 'Bu alan 6-dan çok sembol içermeli';
  validate_array['minlength_6'] = minlength_6;

  var maxlength_50 = [];
  maxlength_50[2] = 'Bu xanaya 50 simvoldan artıq simvol daxil edilə bilməz';
  maxlength_50[1] = 'This field must have less than 50 symbols';
  maxlength_50[3] = 'Это поле должно содержать меньше 50 символов';
  maxlength_50[4] = 'Bu alan 50-den az sembol içere bilir';
  validate_array['maxlength_50'] = maxlength_50;

  var lang = $('#language_js').val();

  $('#add_admin_user').validate({
    rules: {
      name: {
        required: true,
        maxlength: 50
      },
      full_name: {
        required: true,
        maxlength: 50
      },
      email: {
      	required: true,
      	email: true
      },
      role_id: {
      	required: true
      },
      gender: {
      	required: true
      },
      password: {
        required: true,
        minlength: 6
      }
    },
    messages: {
      name: {
        required: validate_array['required'][lang],
        maxlength: validate_array['maxlength_50'][lang]
      },
      full_name: {
        required: validate_array['required'][lang],
        maxlength: validate_array['maxlength_50'][lang]
      },
      email: {
      	required: validate_array['required'][lang],
      	email: validate_array['mail'][lang]
      },
      role_id: {
      	required: validate_array['required'][lang]
      },
      gender: {
      	required: validate_array['required'][lang]
      },
      password: {
        required: validate_array['required'][lang],
        minlength: validate_array['minlength_6'][lang]
      }
    }
  });

</script>
