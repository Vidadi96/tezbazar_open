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
				<?=$page_title;?>
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
									<?=$this->langs->new_income_type; ?>
								</h3>
							</div>
						</div>
					</div>
					<div class="m-portlet__body">
						<div class="m-section">
							<div class="m-section__content">

                <form action="/warehouse/entry_name_lists" method="post">
                  <input type="hidden" name="<?=$this->security->get_csrf_token_name(); ?>" value="<?=$this->security->get_csrf_hash(); ?>">

                  <div class="form-group m-form__group row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label>AZE <img style="max-width: 20px" src="/img/langs/lang_1529385598.png"></label>
      									<input name="entry_name_2" class="form-control m-input" placeholder="">
                      </div>
                    </div>

                    <div class="col-lg-3">
                      <div class="form-group">
                        <label>ENG <img style="max-width: 20px" src="/img/langs/lang_1529385572.png"></label>
      									<input name="entry_name_1" class="form-control m-input" placeholder="">
                      </div>
                    </div>

                    <div class="col-lg-3">
                      <div class="form-group">
                        <label>RUS <img style="max-width: 20px" src="/img/langs/ru.png"></label>
                        <input name="entry_name_3" class="form-control m-input" placeholder="">
                      </div>
                    </div>

                    <div class="col-lg-3">
                      <div class="form-group">
                        <label>TUR <img style="max-width: 20px" src="/img/langs/lang_1529321015.png"></label>
                        <input name="entry_name_4" class="form-control m-input" placeholder="">
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-12 m--align-left">
                    <button type="submit_ru" class="btn btn-success"><i class="fa fa-plus"></i> <?=$this->langs->submit; ?></button>
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
                  <?=$this->langs->list_of_income_types; ?>
                </h3>
              </div>
            </div>
          </div>
          <div class="m-portlet__body">
            <table delete_url="/warehouse/delete_entry_name/" class="table table-bordered m-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th><?=$this->langs->income_type_name; ?></th>
                  <th><?=$this->langs->delete; ?></th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; foreach($entry_type_list as $row): ?>
                  <tr>
                    <td><?=$i; ?></td>
                    <td><?=$row->entry_name; ?></td>
                    <td>
                      <button
                        class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only delete"
                        rel="<?=$row->entry_name_id; ?>"
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
			</div>
		</div>
	</div>

<style media="screen">
  textarea{
    height: 80px;
  }
</style>
